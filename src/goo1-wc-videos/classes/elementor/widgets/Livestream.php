<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_WooCommerce_Livestream_Widget extends \Elementor\Widget_Base {

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
		return 'woocommerce-livestream';
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
		return __( 'WooCommerce Livestream', 'plugin-name' );
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
		return 'fa fa-video-camera';
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
		return [ 'Woocommerce', 'andreaskasper' ];
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
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'youtube-id',
			[
				'label' => __( 'YouTube ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
        );

        $this->add_control(
			'product-name',
			[
				'label' => __( 'Product Name', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'pid',
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
			'wcpids',
			[
				'label' => __( 'Woocommerce Products', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => 'PID: {{{ pid }}}',
			]
		);
		
		

		$this->add_control(
			'swpm_level_2',
			[
				'label' => __( 'Membership Basic', 'plugin-domain' ),
				'descrip2tion' => "this can make your site a little bit slower, but easier to manage. Only works for local files as source.",
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'enabled', 'your-plugin' ),
				'label_off' => __( 'disabled', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'swpm_level_3',
			[
				'label' => __( 'Membership Elite', 'plugin-domain' ),
				'descri2ption' => "this can make your site a little bit slower, but easier to manage. Only works for local files as source.",
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'enabled', 'your-plugin' ),
				'label_off' => __( 'disabled', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'swpm_level_4',
			[
				'label' => __( 'Membership Founder', 'plugin-domain' ),
				'descrip2tion' => "this can make your site a little bit slower, but easier to manage. Only works for local files as source.",
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'enabled', 'your-plugin' ),
				'label_off' => __( 'disabled', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'hr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

	
		$this->add_control(
			'url-shop',
			[
				'label' => __( 'URL to buy', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'https://example.com/shop/', 'plugin-name' ),
			]
		);

        $this->add_control(
			'dt-start',
			[
				'label' => __( 'starting time (in PST)', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'placeholder' => __( '', 'plugin-name' ),
			]
		);
		
		$this->add_control(
			'timezone3',
			[
				'label' => __( 'Timezone 3 letters', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);

		$this->add_control(
			'timezonefull',
			[
				'label' => __( 'Timezone full', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);
        
        

		/*$this->add_control(
			'url',
			[
				'label' => __( 'URL to embed', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'https://your-link.com', 'plugin-name' ),
			]
		);*/

		$this->end_controls_section();

    }
    
    protected function order_status($settings) {

        if (!is_user_logged_in()) return -1;

        $w = $this->get_settings_for_display();

		$current_user = wp_get_current_user();
		
		$j = false;
		if (current_user_can('administrator')) $j = true;
		$level = self::user_membership_level();
		if (($j != true) AND !empty($settings["swpm_level_2"]) AND $settings["swpm_level_2"] == "yes" AND $level == 2) $j = true;
		if (($j != true) AND !empty($settings["swpm_level_3"]) AND $settings["swpm_level_3"] == "yes" AND $level == 3) $j = true;
		if (($j != true) AND !empty($settings["swpm_level_4"]) AND $settings["swpm_level_4"] == "yes" AND $level == 4) $j = true;
		if (isset($w["wcpids"])) {
			foreach ($w["wcpids"] as $row) {
				if (($j != true) AND !empty($row["pid"]) AND wc_customer_bought_product($current_user->email, $current_user->ID, $row['pid'])) $j = true;
			}
		}
		if ($j == true) return 1;

        return -2;
	}
	
	protected function user_membership_level() {
		$member_isloggedin = (SwpmMemberUtils::is_member_logged_in());
		if (!$member_isloggedin) return 0;

		$member_id = SwpmMemberUtils::get_logged_in_members_id();
	$swpm_user = SwpmMemberUtils::get_user_by_id($member_id);

	$user_since = $swpm_user->member_since;
	$user_days = (time()-strtotime($swpm_user->member_since))/86400;
	$user_level = $swpm_user->membership_level;
		return $user_level;


	}

    protected function username() {
        $current_user = wp_get_current_user();
        return $current_user->user_login;
    }

    protected function txt_resttime(DateTime $d) {
        $diff = $d->getTimestamp()-time();
        if ($diff < 0) return "soon";
        if ($diff < 100*60) return "in ".round($diff/60)."minutes";
        if ($diff < 2*86400) return "in ".round($diff/3600)."hours";
        return "in ".round($diff/86400)."days";
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
		
        $status = $this->order_status($settings);

        switch ($status) {
            case -1: 
                echo('<div style="position: relative;"><img src="/wp-content/uploads/2020/04/livestream_bg.jpg" style="width:100%;"/><table style="position: absolute; top:0; left:0; width:100%; height:100%;"><tr><td style="vertical-align:middle;"><div style="text-align:center;font-size:200%">Not logged in</div><div style="text-align:center;">please login to watch the livestream.</div><div style="text-align:center;"><a href="/my-account/" TARGET="_blank"><button type="button">login</button></a></div></td></td></table></div>');
                break;
            case -2: 
                echo('<div style="position: relative;"><img src="/wp-content/uploads/2020/04/livestream_bg.jpg" style="width:100%;"/><table style="position: absolute; top:0; left:0; width:100%; height:100%;"><tr><td style="vertical-align:middle; padding-left: 20%; padding-right:20%;"><div style="text-align:center;font-size:200%">'.(!empty($settings["product-name"])?$settings["product-name"]:"livestream").'<br/>Order not found</div><div style="text-align:center;">Hi '.$this->username().',<br/>we can\'t find any order for this livestream.<br/>If you haven\'t bought a ticket yet, please click on the button below. If you already bought it or have trouble accessing it, please <a href="https://m.me/AndiKDance" TARGET="_blank">contact us</a>.</div><div style="text-align:center;"><a href="'.(!empty($settings["url-shop"])?$settings["url-shop"]:"/shop/").'" TARGET="_blank"><button type="button">buy a livestream ticket</button></a></div></td></td></table></div>');
                break;
            case 1: 
                if (empty($settings["youtube-id"])) {
                    echo('<div style="position: relative;"><img src="/wp-content/uploads/2020/04/livestream_bg.jpg" style="width:100%;"/><table style="position: absolute; top:0; left:0; width:100%; height:100%;"><tr><td style="vertical-align:middle; padding-left: 20%; padding-right:20%;"><div style="text-align:center;font-size:200%">'.(!empty($settings["product-name"])?$settings["product-name"]:"livestream").'<br/>Hi '.$this->username().', livestream hasn\'t started yet...</div>');
                    if (!empty($settings["dt-start"])) {
                        date_default_timezone_set($settings["timezonefull"] ?? "America/Los_Angeles");
                        $d = new DateTime($settings["dt-start"]." ".($settings["timezonefull"] ?? "America/Los_Angeles"));
                        echo('<table align="center" style="margin-top: 2rem; width: 20rem; color: #fff; background: rgba(0,0,0,0.85); border-radius: 1rem; font-family: Roboto,\'Noto Sans\',Arial, Sans-Serif;"><tbody><tr><td style="padding: 0.5rem 0.5rem;"><i class="far fa-signal-stream fa-2x"></i></td><td style="white-space:nowrap; padding: 0.5rem 0.5rem;">Live '.$this->txt_resttime($d).'<br>starting '.$d->format("l, F jS Y h:ia").' '.$settings["timezone3"].'…</td></tr></tbody></table>');
                    }
                    echo('</td></td></table></div>');
                } else echo('<div><table style="width:100%;"><tr><td width="66%">
    
                <div style="position: relative; width:100%; height: 0; padding-bottom: 56.25%"><div style="position: absolute; left: 0; top:0; width:100%; height:100%">
               <iframe class="elementor-video-iframe" allowfullscreen="" title="youtube Video Player" src="https://www.youtube.com/embed/'.$settings["youtube-id"].'?feature=oembed&amp;start&amp;end&amp;wmode=opaque&amp;loop=0&amp;controls=1&amp;mute=0&amp;rel=0&amp;modestbranding=0" style="width:100%; height:100%;"></iframe></div></div>
                <a href="https://youtu.be/'.$settings["youtube-id"].'" TARGET="_blank"><button>Watch it on YouTube</button></a>
               
               </td><td style="vertical-align:top;"><div style="position: relative; width:100%; height:100%;">
               
               <iframe src="https://www.youtube.com/live_chat?v='.$settings["youtube-id"].'&amp;embed_domain='.$_SERVER["HTTP_HOST"].'" frameborder="0" style="width:100%; height:100%; min-height:400px;"></iframe>
               </div>
               </td></tr></table></div>'); 
                break;
        }

        /*//
        return;
        $html = wp_oembed_get( $settings['url'] );
		echo '<div class="oembed-elementor-widget">';
		echo ( $html ) ? $html : $settings['url'];
		echo '</div>';*/

	}

}