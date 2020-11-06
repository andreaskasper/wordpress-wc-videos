<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

namespace plugins\goo1\wc\videos\elementor\widgets;

class Player extends \Elementor\Widget_Base {

	public function get_video_dir() {
		return dirname(dirname(__DIR__))."/uploads/videodata/conv/";
	}

	public function get_video_urlpath() {
		return "/wp-content/uploads/videodata/conv/";
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'goo1-wc-videos-player';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dance Video Player', 'plugin-name' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-youtube-play';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ["andreaskasper", "tanzschule" ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);


		$arr = array();
		$dirs = array("/");
		$rootdir = dirname(dirname(__DIR__))."/uploads/videodata/conv";
		$i = -1;
		while (isset($dirs[$i+1])) {
			$i++;
			$files = scandir($rootdir.$dirs[$i]);
			foreach ($files as $file) {
				if (substr($file,0,1) == ".") continue;
				if (is_dir($rootdir.$dirs[$i].$file)) {
					$dirs[] = $dirs[$i].$file."/";
					continue;
				}
				if (substr($file, -10,10) == ".1080p.mp4") {
					$a = substr($dirs[$i].substr($file,0, strlen($file)-9),1,9999999);
					$arr[$a] = rtrim(str_replace("/", " » ", $a),".");
				}
			}
		}

		$this->add_control(
			'pathpre_video',
			[
				'label' => __( 'Source', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => null,
				'options' => $arr,
			]
		);
		
		/*$this->add_control(
			'url_mp4',
			[
				'label' => __( 'Video URL mp4', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL
			]
        );
        
        $this->add_control(
			'url_webm',
			[
				'label' => __( 'Video URL webm', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL
			]
        );
        
        $this->add_control(
			'url_poster',
			[
				'label' => __( 'Poster URL', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL
			]
        );

        $this->add_control(
			'url_chapters_vtt',
			[
				'label' => __( 'Kapitel vtt', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL
			]
        );*/
        
        $this->add_control(
			'poster_local',
			[
				'label' => __( 'Ersatzvorschaubild', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA
			]
		);

        

		$this->end_controls_section();

		

    }
    
	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        //print_r($settings);

        $id = "player".md5(microtime(true));

		
		echo('<div style="position: relative; display: block; width:100%; height: 0px; padding-bottom: 56.25%; overflow: hidden; background: black;">');
		echo('<div style="position: absolute; display: block; width:100%; height: 100%; left: 0px; top: 0px; background: black;">');
		echo('<video id="'.$id.'" class="video-js vjs-default-skin" controls playsinline controlsList="nodownload" preload="auto" style="width:100%; height:100%;">');
		echo('<!-- '.$this->get_video_dir().$settings["pathpre_video"]."1080p.mp4".' -->');
		echo('<!-- '.$this->get_video_urlpath().$settings["pathpre_video"]."1080p.mp4".' -->');
        if (!empty($settings["pathpre_video"]) AND file_exists($this->get_video_dir().$settings["pathpre_video"]."1080p.mp4")) echo('<source src="'.$this->get_video_urlpath().$settings["pathpre_video"].'1080p.mp4" type="video/mp4"/>'.PHP_EOL);
        
        if (!empty($settings["url_chapters_vtt"]["url"])) echo('<track src="'.$settings["url_chapters_vtt"]["url"].'" kind="chapters" label="Kapitel" srclang="de">'.PHP_EOL);

	/*if (file_exists($folder_videos.$settings["file_prefix"].".en.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.en.vtt" kind="captions" srclang="en" label="English">'.PHP_EOL);
	if (file_exists($folder_videos.$settings["file_prefix"].".de.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.de.vtt" kind="captions" srclang="de" label="Deutsch">'.PHP_EOL);

	if (file_exists($folder_videos.$settings["file_prefix"].".chapters.en.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.chapters.en.vtt" kind="chapters" label="Chapters" srclang="en">'.PHP_EOL);
	if (file_exists($folder_videos.$settings["file_prefix"].".chapters.de.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.chapters.de.vtt" kind="chapters" label="Kapitel" srclang="en">'.PHP_EOL);*/
	
	echo('<p class="vjs-no-js">please enable Javascript to watch the video</p>
</video>');

		echo('</div>');
		echo('</div>');

    	echo('<link href="https://vjs.zencdn.net/7.8.2/video-js.css" rel="stylesheet" />');
		echo('<script src="https://vjs.zencdn.net/7.8.2/video.js"></script>');

		?>
<style>
/*.vjs-picture-in-picture-control { display: none !important; }*/
.vjs-control button.vjs-cams-button { width: 20px; background: url(/wp-content/plugins/andreaskasper/assets/images/videojs_cam.png) no-repeat center center; padding-left: 0px; padding-right: 0px; }
.vjs-control button.vjs-min10sec-button { width: 20px; background: url(/wp-content/plugins/goo1-mediamarc/assets/videojs_min10sec.png) no-repeat center center; padding-left: 0px; padding-right: 0px; }
.video-js .vjs-big-play-button { margin: -24px 0px 0px -45px; top: 50% !important; left: 50% !important; }
.vjs-quality-button .vjs-quality-value { pointer-events: none; font-size: 1.5em; line-height: 2; text-align: center; }
</style>
<script>
var akvjs = {
	init: function(id, options) {
		console.log("Optionen", options);
		akvjs.options = options;
		akvjs.id = id;
		akvjs.ele = jQuery(id);
		akvjs.quality = 1080;
		akvjs.vjs = videojs(id, {"playbackRates": [0.25, 0.5, 1.0, 2.0], "poster": "<?=$settings["url_poster"]["url"]; ?>"}, function(){
			console.log(akvjs.ele.length);
			jQuery(akvjs.id+" .vjs-progress-control").before('<div class="vjs-min10sec-button vjs-menu-button vjs-control vjs-button"><button class="vjs-min10sec-button vjs-button" type="button" aria-disabled="false" title="10sec zurück" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">-10sec</span></button></div>');

			jQuery(akvjs.id+" div.vjs-audio-button").after('<div class="vjs-quality-button vjs-menu-button vjs-menu-button-popup vjs-control vjs-button"><div class="vjs-quality-value">HD</div><button class="vjs-quality-rate vjs-menu-button vjs-menu-button-popup vjs-button" type="button" aria-disabled="false" title="Playback Rate" aria-haspopup="true" aria-expanded="false"><span aria-hidden="true" class="vjs-icon-placeholder"></span><span class="vjs-control-text" aria-live="polite">Playback Rate</span></button><div class="vjs-menu"><ul class="vjs-menu-content" role="menu"><li class="vjs-menu-title">Qualität</li></ul></div></div>');
			jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(1080);"><span class="vjs-menu-item-text">1080p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
			jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(480);"><span class="vjs-menu-item-text">480p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
			jQuery(akvjs.id+" div.vjs-quality-button ul").append('<li class="vjs-menu-item" role="menuitemradio" aria-disabled="false" tabindex="-1" aria-checked="false" onclick="akvjs.setquality(240);"><span class="vjs-menu-item-text">240p</span><span class="vjs-control-text" aria-live="polite"></span></li>');
			jQuery("div.vjs-quality-button").hover(function() {
				console.log("hover quality");
				jQuery(this).addClass("vjs-hover");
			}, function() {
				jQuery(this).removeClass("vjs-hover");
			});
			
			jQuery("button.vjs-min10sec-button").click(function() {
				akvjs.secback(10);
			});

			console.log("player loaded", akvjs.vjs.language(), akvjs.vjs);
		});
	},
	enable_hotkeys: function() {
		jQuery(document).on("keypress", function(event) {
			switch (event.charCode) {
				case 32: /*Spacebar*/
					var isPlaying = !akvjs.vjs.paused();
					if (isPlaying) akvjs.vjs.pause(); else akvjs.vjs.play();
					return false;
				case 106: /*j - minus 10sec*/
					akvjs.secback(10);
					return false;
				case 108: /*l - plus 10 sec*/
					akvjs.secforward(10);
					return false;
				case 117:
					akvjs.vjs.playbackRate(0.25);
					return false;
				case 105:
					akvjs.vjs.playbackRate(0.5);
					return false;
				case 111:
					akvjs.vjs.playbackRate(1);
					return false;
				case 109: /*m - mute*/
					var a = akvjs.vjs.muted();
					akvjs.vjs.muted(!a);
					return false;
				case 103: /*g - -1frame*/
					akvjs.vjs.pause();
					akvjs.secback(1/60);
					return false;
				case 104: /*h - +1frame */
					akvjs.vjs.pause();
					akvjs.secforward(1/60);
					return false;
			}
		//alert('Handler for .keypress() called. - ' + event.charCode);
		});
	},
	setquality: function(value) {
		console.log("switch to quality", value);
		akvjs.quality = value;
		switch (value) {
			case 1080:
				jQuery(akvjs.id+" div.vjs-quality-value").text('HD');
				break;
			case 480:
				jQuery(akvjs.id+" div.vjs-quality-value").text('SD');
				break;
			case 240:
				jQuery(akvjs.id+" div.vjs-quality-value").html('<i class="far fa-mobile-android-alt"></i>');
				break;
			case 120:
				jQuery(akvjs.id+" div.vjs-quality-value").html('<i class="fas fa-pager"></i>');
				break;
		}
		var pos = akvjs.vjs.currentTime();
		akvjs.loadsource();
		akvjs.vjs.play();
		akvjs.vjs.currentTime(pos);
	},
	secback: function (sec) {
		var pos = akvjs.vjs.currentTime();
		pos = Math.max(0, pos - sec);
		akvjs.vjs.currentTime(pos);
	},
	secforward: function (sec) {
		var pos = akvjs.vjs.currentTime();
		pos = Math.min(akvjs.vjs.duration(), pos +sec);
		akvjs.vjs.currentTime(pos);
	}
}

jQuery(document).ready(function($) {
    akvjs.init("#<?=$id ?>", <?=json_encode(array()); ?>);
    akvjs.enable_hotkeys();
});
</script>
<?php
	}


	

	private static function get5678index($mustreload = false) {
		$local = __DIR__."/5678-index.json";
		if ($mustreload OR filemtime($local) < time()-rand(86400,2*86400)) {
			$str = file_get_contents("https://cdnkylesarah.5678.video/mediaconvertserver/index.json");
			$json = json_decode($str,true);
			if (!empty($json["pres"]) AND !empty($json["meta"])) {
				file_put_contents($local, json_encode($json));
				return $json;
			}
		}
		$str = file_get_contents($local);
		return json_decode($str,true);
	}
}