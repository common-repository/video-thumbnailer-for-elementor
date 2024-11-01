//console.log(ElementorConfig['initial_document']['elements']);

jQuery(function ($) {

	$(document).ready(function () {

		

		// Function to extract Vimeo ID from a Vimeo URL

		function vtfe_get_vimeo_id(url) {

			var vtfe_removeEnd = url.split('?')[0].split("/");

			var vtfe_vidId = vtfe_removeEnd[vtfe_removeEnd.length - 1];

			return vtfe_vidId;

		}

		

		// Function to extract YouTube ID from a YouTube URL

		function vtfe_get_youtube_id(url) {

			var vtfe_regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;

			var vtfe_match = url.match(vtfe_regExp);

			return (vtfe_match && vtfe_match[7].length == 11) ? vtfe_match[7] : false;

		}

		

		// Find each Elementor embedded video with an image overlay set

		

		if ( $('body').hasClass('elementor-editor-active') ) {

		

			const vtfe_updateThumbnails = setInterval(function() {



				$('.elementor-auto-video-thumbnailess').each(function() {



					var vtfe_thisVideo = $(this);



					// Remove image tags and only use the background image which we will blank at this stage

					vtfe_thisVideo.find('img').remove();

					vtfe_thisVideo.attr('style', 'background-image: url("")');

					vtfe_thisVideo.addClass('elementor-auto-video-thumbnail-edit');



				});



			}, 1300);

		

		} else {

		

			const vtfe_updateThumbnails = setInterval(function() {



				$('.elementor-auto-video-thumbnailess').each(function() {



					var vtfe_thisVideo = $(this);



					// Remove image tags and only use the background image which we will blank at this stage

					vtfe_thisVideo.find('img').remove();

					vtfe_thisVideo.attr('style', 'background-image: url("")');



					var vtfe_videoURL = vtfe_thisVideo.closest('.elementor-widget-video').data('settings')['youtube_url'];



					if (!vtfe_videoURL) { vtfe_videoURL = vtfe_thisVideo.closest('.elementor-widget-video').data('settings')['url']; }

					if (!vtfe_videoURL && vtfe_thisVideo.parent().hasClass('elementor-open-lightbox')) { vtfe_videoURL = vtfe_thisVideo.data('elementor-lightbox')['youtube_url']; }

					if (!vtfe_videoURL && vtfe_thisVideo.parent().hasClass('elementor-open-lightbox')) { vtfe_videoURL = vtfe_thisVideo.data('elementor-lightbox')['url']; }

					if (!vtfe_videoURL) { vtfe_videoURL = vtfe_thisVideo.parent().find('iframe').data('lazy-load'); }



					// Pull in the thumbnail for Vimeo videos

					if (vtfe_videoURL.includes("vimeo")) {

						var vtfe_vimeoId = vtfe_get_vimeo_id(vtfe_videoURL);

						$.getJSON('https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/' + vtfe_vimeoId, {

								format: "json",

								width: "640"

							},

							function (data) {



								//thisImage.attr("src", data.thumbnail_url);

								//thisImage.attr("srcset", data.thumbnail_url);

								vtfe_thisVideo.attr('style', 'background-image: url("' + data.thumbnail_url +'")');



								// Set default alt and title of thumbnail

								//thisImage.attr("alt", "Vimeo video thumbnail");

								//thisImage.attr("title", "Vimeo video");



								// Set title and alt from Vimeo data

								if (data.title) {

									var vtfe_vimeoTitle = data.title;

									if (vtfe_vimeoTitle != "") {

										//thisImage.attr("alt", "Vimeo video thumbnail for " + vtfe_vimeoTitle);

										//thisImage.attr("title", "Video - " + vtfe_vimeoTitle);

									}

								}



							}

						);

					}



					// Pull in the thumbnail for YouTube videos

					if (vtfe_videoURL.includes("youtube") || vtfe_videoURL.includes("youtu.be")) {

						vtfe_thisVideo.addClass('elementor-custom-embed-image-overlay-youtube');

						var vtfe_youtubeId = vtfe_get_youtube_id(vtfe_videoURL);

						var vtfe_img = new Image();

						// Change thumbnail URL and alt

						vtfe_img.onload = function () {



							var vtfe_yt_thumbnail_url;



							if (this.width < 1280) {

								vtfe_yt_thumbnail_url = "https://i.ytimg.com/vi/" + vtfe_youtubeId + "/hqdefault.jpg";

							} else {

								vtfe_yt_thumbnail_url = "https://i.ytimg.com/vi/" + vtfe_youtubeId + "/maxresdefault.jpg";

							}



							//thisImage.attr("src", vtfe_yt_thumbnail_url);

							//thisImage.attr("srcset", vtfe_yt_thumbnail_url);

							vtfe_thisVideo.attr('style', 'background-image: url("' + vtfe_yt_thumbnail_url +'")');



							// Add default text for alt and title text of thumbnail

							//thisImage.attr("alt", "YouTube video thumbnail");

							//thisImage.attr("title", "YouTube video");





							// Get YouTube video title for alt and title text of thumbnail - not currently in use

							/*

							function getYouTubeInfo() {

									$.ajax({

											url: "//gdata.youtube.com/feeds/api/videos/" + vtfe_youtubeId + "?v=2&alt=json",

											dataType: "jsonp",

											success: function (data) { getYTTitle(data); }

									});

							}

							function getYTTitle(data) {

									var vtfe_title = data.entry.title.$t;

									if (vtfe_title != "") {

										thisImage.attr("alt", "YouTube video thumbnail for " + vtfe_title);

										thisImage.attr("title", "Video - " + vtfe_title);

									}

							}

							getYouTubeInfo();

							*/

						}

						if (!vtfe_img.src) { vtfe_img.src = "https://i.ytimg.com/vi/" + vtfe_youtubeId + "/maxresdefault.jpg"; }

						if (!vtfe_img.srcset) { vtfe_img.srcset = "https://i.ytimg.com/vi/" + vtfe_youtubeId + "/maxresdefault.jpg"; }



					}



					$(this).removeClass('elementor-auto-video-thumbnailess');



					if ($('.elementor-auto-video-thumbnailess').length < 1) {

						clearInterval(vtfe_updateThumbnails);

					}



				});



			}, 200);

		}

	})

})