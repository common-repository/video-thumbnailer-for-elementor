<?php

// Frontend scripts and styles

add_action('wp_enqueue_scripts','vtfe_script');
add_action( 'elementor/editor/after_enqueue_scripts', 'vtfe_script', 11 );
add_action( 'admin_enqueue_scripts', 'vtfe_admin_script' );

function vtfe_script() {
    wp_enqueue_script( 'vtfe_script', VTFE_PLUGINURL.'assets/js/script.js', array(), date('YmdHi', filemtime(plugin_dir_path( __FILE__ ).'../assets/js/script.js')), true);
	wp_enqueue_style('vtfe_style', VTFE_PLUGINURL.'assets/css/style.css', array(), date('YmdHi', filemtime(plugin_dir_path( __FILE__ ).'../assets/css/style.css')));
}

function vtfe_admin_script() {
	global $pagenow;
	$settings_page = "";
	if ($_GET['page']) { $settings_page = $_GET['page']; }
	if($pagenow == 'options-general.php' && $settings_page == 'vtfe_settings') {
		wp_enqueue_style('vtfe_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', array(), '5.2.3');
		wp_enqueue_style('vtfe_style', VTFE_PLUGINURL.'assets/css/style.css', array(), date('YmdHi', filemtime(plugin_dir_path( __FILE__ ).'../assets/css/style.css')));
	}
}

// Backend - Elementor fix - Check if there are any videos with image overlay thumbnails set to "" when Elementor post meta is updated and replace them with a blank field instead

function vtfe_overlaythumb($meta_id, $post_id, $meta_key='', $meta_value=''){

    // Stop if it is not the Elementor post meta

    if ( $meta_key != '_elementor_data') {

        return false;

    }

    // Retrieve exisiting Elementor JSON for this post

	$elementor_data = get_post_meta($post_id,'_elementor_data',true);

	// Remove blank field and replace with nothing, enabling the default image

	$elementor_data = str_replace(',"image_overlay":{"url":"","id":""}','',$elementor_data);

	// Update post_meta with the edited JSON

	update_post_meta($post_id,'_elementor_data',wp_slash($elementor_data));
}

add_action('updated_post_meta', 'vtfe_overlaythumb', 10, 4);

// Frontend - Adding a class for the plugin to find videos on the frontend and do its thing

add_action( 'elementor/widget/render_content', function( $content, $widget ){

	// Look for Elementor video widgets on the page

    if ($widget->get_name() === 'video') {
        $settings = $widget->get_settings();

		// Check if Auto Thumbnail is switched on and add a class
		
		$auto_thumbnailcrop = "";
		
		if ($settings['auto_thumbnail_crop'] == 'yes') {
			$auto_thumbnailcrop =  ' elementor-auto-video-thumbnail-crop';
		}
		
		if ($settings['auto_thumbnail'] == 'yes') {
			$content = str_replace(array('elementor-custom-embed-image-overlay','elementor-fit-aspect-ratio'),array('elementor-custom-embed-image-overlay elementor-auto-video-thumbnail elementor-auto-video-thumbnailess'.$auto_thumbnailcrop,'elementor-fit-aspect-ratio elementor-fit-aspect-ratio-auto-video-thumbnail'), $content);
		}
    }
    return $content;
}, 10, 2 );

// Backend - Add a switch for auto thumbnail in the image overlay section of videos in the Elementor editor

add_action('elementor/element/before_section_end', function( $section, $section_id, $args ) {

	$vtfe_default_on = 'no';
	$vtfe_default_crop_on = 'no';
	if (isset(get_option( 'vtfe_settings' )['elementor_default_switch' ])) $vtfe_default_on = (get_option( 'vtfe_settings' )['elementor_default_switch' ]) ? 'yes' : 'no';
	if (isset(get_option( 'vtfe_settings' )['elementor_default_crop_switch' ])) $vtfe_default_crop_on = ( get_option( 'vtfe_settings' )[ 'elementor_default_crop_switch' ] ) ? 'yes' : 'no';

	if( $section->get_name() == 'video' && $section_id == 'section_image_overlay' ){
		$section->add_control(
			'auto_thumbnail' ,
			[
				'label' => esc_html__( 'Automatic thumbnail', 'elementor' ),
				'default' => $vtfe_default_on,
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'elementor' ),
				'label_on' => esc_html__( 'On', 'elementor' ),
				'condition' => [
					'show_image_overlay' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$section->add_control(
			'auto_thumbnail_crop' ,
			[
				'label' => esc_html__( 'Automatic thumbnail - crop', 'elementor' ),
				'default' => $vtfe_default_crop_on,
				'description' => 'This is recommended for videos (often older) with thumbnails other than 16:9 (eg. HD / full HD / 4K) resolution, such as 4:3.',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'elementor' ),
				'label_on' => esc_html__( 'On', 'elementor' ),
				'condition' => [
					'auto_thumbnail' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$section->update_control(
			'image_overlay' ,
			[
				'description' => 'When Automatic thumbnail is switched on below, this setting will be ignored.',
			]
		);
		$section->update_control(
			'image_overlay_size' ,
			[
				'description' => 'When Automatic thumbnail is switched on below, this setting will be ignored.',
			]
		);
	}
}, 100, 3 );