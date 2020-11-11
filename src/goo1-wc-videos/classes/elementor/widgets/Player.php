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
		return __( 'Dance Video Player', "goo1-wc-videos" );
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
			'source',
			[
				'label' => __( 'Source', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => null,
				'options' => array(
					"5678.video" => "5678.video",
					"wordpress" => "selfhosted",
					"youtube" => "YouTube",
					"vimeo" => "Vimeo",
					"medialibrary" => "Media Library",
					"url" => "custom URL"
				),
			]
		);

		/*$this->add_control(
			'multiangle',
			[
				'label' => __( 'Multiangle', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => '1',
				'default' => '',
				'condition' => [
					'source' => ['wordpress', "url"]
				]
			]
		);

		$this->add_control(
			'multiquality',
			[
				'label' => __( 'Multiple Qualities', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => '1',
				'default' => '',
				'condition' => [
					'source' => ['url']
				]
			]
		);*/

		$this->add_control(
			'youtube_id',
			[
				'label' => __( 'YouTube ID', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'source' => ['youtube']
				]
			]
		);

		$this->add_control(
			'vimeo_id',
			[
				'label' => __( 'Vimeo ID', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'source' => ['vimeo']
				]
			]
		);

		$this->add_control(
			'url_index_json',
			[
				'label' => __( 'Index json (optional)', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::URL,
				'condition' => [
					'source' => ['url'],
				]
			]
        );

		$repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'url',
			[
				'label' => __( 'URL Video', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '', "goo1-wc-videos" ),
			]
		);

		$repeater->add_control(
			'quality',
			[
				'label' => __( 'Video Quality', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "1080p",
				'options' => array("2160p" => "2160p 4K", '1080p' => "1080p FullHD", "480p" => "480p SD", "240p" => "240p Mobile"),
			]
		);

		$repeater->add_control(
			'format',
			[
				'label' => __( 'Video Format', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "mp4",
				'options' => array("mp4" => "mp4", 'webm' => "webm"),
			]
		);

		$repeater->add_control(
			'angle',
			[
				'label' => __( 'Camera Angle', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "front",
				'options' => array("front" => "Front", 'top' => "Top", "side" => "Side", "feet" => "Feet"),
			]
		);

		
		/*$a = $this->get_settings_for_display("wcpids");
		print_r($a);

		$product = wc_get_product( id );
		$pt = $product->get_title();*/
		
		$this->add_control(
			'video_urls',
			[
				'label' => __( 'Video URLs', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => 'Video: {{{ quality }}} {{{ angle }}} {{{ format }}}',
				'condition' => [
					'source' => ['url']
				]
			]
		);

		$repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'media',
			[
				'label' => __( 'URL Video', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'placeholder' => __( '', "goo1-wc-videos" ),
				/*'default' => [
					'url' => \Elementor\Utils::get_placeholder_video_src(),
				]*/
			]
		);

		$repeater->add_control(
			'quality',
			[
				'label' => __( 'Video Quality', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "1080p",
				'options' => array("2160p" => "2160p 4K", '1080p' => "1080p FullHD", "480p" => "480p SD", "240p" => "240p Mobile"),
			]
		);

		$repeater->add_control(
			'format',
			[
				'label' => __( 'Video Format', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "mp4",
				'options' => array("mp4" => "mp4", 'webm' => "webm"),
			]
		);

		$repeater->add_control(
			'angle',
			[
				'label' => __( 'Camera Angle', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => "front",
				'options' => array("front" => "Front", 'top' => "Top", "side" => "Side", "feet" => "Feet"),
			]
		);

		
		/*$a = $this->get_settings_for_display("wcpids");
		print_r($a);

		$product = wc_get_product( id );
		$pt = $product->get_title();*/
		
		$this->add_control(
			'medias',
			[
				'label' => __( 'Media Videos', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => 'Video: {{{ quality }}} {{{ angle }}} {{{ format }}}',
				'condition' => [
					'source' => ["medialibrary"]
				]
			]
		);

		$this->add_control(
			'url_chapters_vtt',
			[
				'label' => __( 'URL chapters.vtt', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::URL,
				'condition' => [
					'source' => ['url'],
				]
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
				'label' => __( 'Ersatzvorschaubild', "goo1-wc-videos" ),
				'type' => \Elementor\Controls_Manager::MEDIA
			]
		);

        

		$this->end_controls_section();

		$this->start_controls_section(
			'restictaccess_section',
			[
				'label' => __( 'Restrict Access', "goo1-wc-videos" ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'is_admin_allowed',
			[
				'label' => __( 'Admin don\'t need to buy', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => '1',
				'default' => '1'
			]
		);

		$repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'product_id',
			[
				'label' => __( 'WooCommerce Product ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);

		/*$a = $this->get_settings_for_display("wcpids");
		print_r($a);

		$product = wc_get_product( id );
		$pt = $product->get_title();*/
		
		$this->add_control(
			'woocommerce_product_ids',
			[
				'label' => __( 'Woocommerce Products', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => 'PID: {{{ product_id }}}',
			]
		);

		$this->add_control(
			'swpm',
			[
				'label' => __( 'SWPM Free Members', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Allowed', 'your-plugin' ),
				'label_off' => __( 'Disallowed', 'your-plugin' ),
				'return_value' => '1',
				'default' => '1'
			]
		);

		$this->add_control(
			'url_buy',
			[
				'label' => __( 'URL to buy', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL
			]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'player-options',
			[
				'label' => __( 'Options', "goo1-wc-videos" ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'source' => ['url'],
				]
			]
		);

		$this->add_control(
			'is_hotkeys',
			[
				'label' => __( 'Hotkeys', 'goo1-wc-videos' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'enabled', "goo1-wc-videos" ),
				'label_off' => __( 'disabled', "goo1-wc-videos" ),
				'return_value' => '1',
				'default' => '1'
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
		
		echo('<div style="position: relative; display: block; width:100%; height: 0px; padding-bottom: 56.25%; overflow: hidden; background: black;">');
		echo('<div style="position: absolute; display: block; width:100%; height: 100%; left: 0px; top: 0px; background: black;">');
        switch ($settings["source"] ?? "") {
			case "":
				echo(__("Please choose a video source ", "goo1-wc-videos"));
				break;
			case "youtube":
				$this->render_youtube($settings);
				break;
			case "vimeo":
				$this->render_vimeo($settings);
				break;
			case "medialibrary":
				$this->render_medialibrary($settings);
				break;
			case "url":
				$this->render_customurls($settings);
				break;
			default:
				print_r($settings);
		}
		echo('</div></div>');
	}

	private function render_medialibrary($settings) {
		$w = array();
		foreach ($settings["medias"] as $row) {
			$b = array();
			$b["quality"] = $row["quality"];
			$b["format"] = $row["format"];
			$b["angle"] = $row["angle"];
			$b["url"] = $row["media"]["url"];
			$w[] = $b;
		}
		//print_r($settings["video_urls"]);
		$this->render_filesarray($w, $settings);
	}

	private function render_customurls($settings) {
		$w = array();
		foreach ($settings["video_urls"] as $row) {
			$b = array();
			$b["quality"] = $row["quality"];
			$b["format"] = $row["format"];
			$b["angle"] = $row["angle"];
			$b["url"] = $row["url"]["url"];
			$w[] = $b;
		}
		//print_r($settings["video_urls"]);
		$this->render_filesarray($w, $settings);
	}

	private function render_filesarray($urls, $settings) {
		//print_r($settings);

		$id = "player".md5(microtime(true));

		echo('<script>');
		echo('var player_data = '.json_encode($urls).';');
		echo('console.log(player_data);');
		echo('</script>');


		echo('<video id="'.$id.'" class="video-js vjs-default-skin" controls playsinline controlsList="nodownload" poster="'.($settings["poster_local"]["url"] ?? "").'" preload="auto" style="width:100%; height:100%;">');
		
		$rows = $this->best_of_front($urls);
		foreach ($rows as $k => $row) {
			if ($k == "mp4") echo('<source src="'.$row["url"].'" type="video/mp4"/>'.PHP_EOL);
			if ($k == "webm") echo('<source src="'.$row["url"].'" type="video/webm"/>'.PHP_EOL);
		}

		if (!empty($settings["url_chapters_vtt"]["url"])) echo('<track src="'.$settings["url_chapters_vtt"]["url"].'" kind="chapters" label="Kapitel" srclang="de">'.PHP_EOL);

		/*if (file_exists($folder_videos.$settings["file_prefix"].".en.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.en.vtt" kind="captions" srclang="en" label="English">'.PHP_EOL);
		if (file_exists($folder_videos.$settings["file_prefix"].".de.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.de.vtt" kind="captions" srclang="de" label="Deutsch">'.PHP_EOL);

		if (file_exists($folder_videos.$settings["file_prefix"].".chapters.en.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.chapters.en.vtt" kind="chapters" label="Chapters" srclang="en">'.PHP_EOL);
		if (file_exists($folder_videos.$settings["file_prefix"].".chapters.de.vtt")) echo('<track src="'.$urlpath_videos.$settings["file_prefix"].'.chapters.de.vtt" kind="chapters" label="Kapitel" srclang="en">'.PHP_EOL);*/

		echo('<p class="vjs-no-js">please enable Javascript to watch the video</p>
		</video>');

/* Check for new version at
 *
 *       https://videojs.com/getting-started
 * 
 */
		echo('<link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />');
		echo('<script src="https://vjs.zencdn.net/7.8.4/video.js"></script>');

		?>
<style>
/*.vjs-picture-in-picture-control { display: none !important; }*/
.vjs-control button.vjs-cams-button { width: 20px; background: url(<?=site_url("/wp-content/plugins/goo1-wc-videos/assets/videojs_cam.png"); ?>) no-repeat center center; padding-left: 0px; padding-right: 0px; }
.vjs-control button.vjs-min10sec-button { width: 20px; background: url(<?=site_url("/wp-content/plugins/goo1-wc-videos/assets/videojs_min10sec.png"); ?>) no-repeat center center; padding-left: 0px; padding-right: 0px; }
.video-js .vjs-big-play-button { margin: -24px 0px 0px -45px; top: 50% !important; left: 50% !important; }
.vjs-quality-button .vjs-quality-value { pointer-events: none; font-size: 1.5em; line-height: 2; text-align: center; }
</style>
<script>
<?php
readfile(__DIR__."/player.js");
?>

jQuery(document).ready(function($) {
akvjs.init("#<?=$id ?>", <?=json_encode(array()); ?>);
akvjs.enable_hotkeys();
});
</script>
<?php
	}
	
	private function render_youtube($settings) {
		if (empty($settings["youtube_id"])) { echo('YouTube-ID is missing'); return; }
		if (!preg_match ("@^[A-Za-z0-9]+$@", $settings["youtube_id"])) { echo('Strange YouTube-ID'); return; }
		echo('<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$settings["youtube_id"].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
	}

	private function render_vimeo($settings) {
		if (empty($settings["vimeo_id"])) { echo('Vimeo-ID is missing'); return; }
		if (!preg_match ("@^[0-9]+$@", $settings["vimeo_id"])) { echo('Strange Vimeo-ID'); return; }
		echo('<iframe src="https://player.vimeo.com/video/243115097" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>');
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

	private function best_of_front(Array $urls) {
		$out = array();
		$ql = array("------", "2160p", "1080p", "480p", "240p");
		foreach ($urls as $row) {
			if ($row["angle"] != "front") continue;
			$a = $row["format"];
			if (!isset($out[$a]) OR array_search($row["quality"],$ql) < array_search($out[$a]["quality"],$ql)) $out[$a] = $row;
		}
		return $out;
	}
}