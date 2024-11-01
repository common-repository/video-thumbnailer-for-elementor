<?php

//register settings

function vtfe_options_add() {
	register_setting( 'vtfe_settings', 'vtfe_settings' );
}

//add settings page to menu

function vtfe_add_options() {
	add_options_page( __( 'Video Thumbnailer for Elementor' ), __( 'Video Thumbnailer for Elementor' ), 'manage_options', 'vtfe_settings', 'vtfe_settings_page' );
}

//add actions

add_action( 'admin_init', 'vtfe_options_add' );
add_action( 'admin_menu', 'vtfe_add_options' );

//start settings page

function vtfe_settings_page() {
	$options = get_option( 'vtfe_settings' );
	?>
<div>
    <form method="post" action="options.php" class="vtfe_form">
        <h1 class="text-center mb-3">Video Thumbnailer for Elementor - Settings</h1>
        <?php settings_fields( 'vtfe_settings' ); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-3 bg-primary text-white rounded">
                        <h2 class="text-black bg-white p-2 rounded">Default to on or off</h2>
                        <h3 class="text-white">
                            <input type="radio" id="vtfe_settings[elementor_default_switch]-on" name="vtfe_settings[elementor_default_switch]" value="true" <?php if (get_option('vtfe_settings')['elementor_default_switch'] == 'true') { ?> checked<?php } ?>>
                            <label for="vtfe_settings[elementor_default_switch]-on">
                                <?php _e( 'Default On' ); ?>
                            </label>
                        </h3>
                        <h3 class="text-white">
                            <input type="radio" id="vtfe_settings[elementor_default_switch]-off" name="vtfe_settings[elementor_default_switch]" value="false" <?php if (get_option('vtfe_settings')['elementor_default_switch'] == 'false') { ?> checked<?php } ?>>
                            <label for="vtfe_settings[elementor_default_switch]-off">
                                <?php _e( 'Default Off' ); ?>
                            </label>
                        </h3>
                        <p> Use this setting to switch the automatic thumbnails on by default for all Elementor videos. This will only work for videos where you have not set it directly for that particular video in the Elementor interface yet. Once set, you may have to clear the cache for any pages with Elementor videos to see the change. </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-3 bg-primary text-white rounded">
                        <h2 class="text-black bg-white p-2 rounded">Default to crop or not</h2>
                        <h3 class="text-white">
                            <input type="radio" id="vtfe_settings[elementor_default_crop_switch]-on" name="vtfe_settings[elementor_default_crop_switch]" value="true" <?php if (get_option('vtfe_settings')['elementor_default_crop_switch'] == 'true') { ?> checked<?php } ?>>
                            <label for="vtfe_settings[elementor_default_crop_switch]-on">
                                <?php _e( 'Default On' ); ?>
                            </label>
                        </h3>
                        <h3 class="text-white">
                            <input type="radio" id="vtfe_settings[elementor_default_crop_switch]-off" name="vtfe_settings[elementor_default_crop_switch]" value="false" <?php if (get_option('vtfe_settings')['elementor_default_crop_switch'] == 'false') { ?> checked<?php } ?>>
                            <label for="vtfe_settings[elementor_default_crop_switch]-off">
                                <?php _e( 'Default Off' ); ?>
                            </label>
                        </h3>
                        <p> Use this setting to crop video thumbnails (as opposed to resizing for the space) by default for all Elementor videos. This will only work for videos where you have not set it directly for that particular video in the Elementor interface yet. Once set, you may have to clear the cache for any pages with Elementor videos to see the change. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-4">
            <p>
                <input name="submit" id="submit" value="Save Changes" type="submit" class='btn btn-primary btn-lg'>
            </p>
            <h2>Donate</h2>
            <p>We have developed and continue to maintain this free plugin but if you have found it useful and wish to contribute towards our development costs at Engage Web, donating via PayPal is safe, fast and easy!</p>
            <div id="donate-button-container">
                <div id="donate-button"></div>
                <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script> 
                <script>

					PayPal.Donation.Button({
						env:'production',
						hosted_button_id:'6V8QKMWESU7AU',
						image: {
							src:'https://pics.paypal.com/00/s/YmFkOTVjYjEtMDhjZC00Zjk0LTk5MTEtZmE4YTFjYjkwOTRh/file.PNG',
							alt:'Donate with PayPal button',
							title:'PayPal - The safer, easier way to pay online!',
						}
					}).render('#donate-button');
					</script> 
            </div>
        </div>
    </form>
</div>
<?php
}