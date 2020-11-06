<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_WooCommerce_Youtube_Widget extends \Elementor\Widget_Base {

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
		return 'woocommerce-youtube';
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
		return __( 'WooCommerce Youtube', 'plugin-name' );
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
        
        $this->add_control(
			'pid1',
			[
				'label' => __( 'WooCommerce Product1 ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'plugin-name' ),
			]
        );
        
        $this->add_control(
			'pid2',
			[
				'label' => __( 'WooCommerce Product2 ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'plugin-name' ),
			]
        );
        
        $this->add_control(
			'pid3',
			[
				'label' => __( 'WooCommerce Product3 ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'placeholder' => __( '', 'plugin-name' ),
			]
        );
        
        $this->add_control(
			'pid4',
			[
				'label' => __( 'WooCommerce Product4 ID', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
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
    
    protected function order_status() {

        if (!is_user_logged_in()) return -1;

        $w = $this->get_settings_for_display();

        $current_user = wp_get_current_user();

        if ( current_user_can('administrator') || 
        (!empty($w["pid1"]) AND wc_customer_bought_product($current_user->email, $current_user->ID, $w['pid1'])) ||  
        (!empty($w["pid2"]) AND wc_customer_bought_product($current_user->email, $current_user->ID, $w['pid2'])) || 
        (!empty($w["pid3"]) AND wc_customer_bought_product($current_user->email, $current_user->ID, $w['pid3'])) ||  
        (!empty($w["pid4"]) AND wc_customer_bought_product($current_user->email, $current_user->ID, $w['pid4']))
         ) return 1;

        return -2;
    }

    protected function username() {
        $current_user = wp_get_current_user();
        return $current_user->user_login;
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

        $status = $this->order_status();

        switch ($status) {
            case -1: 
                echo('<div style="position: relative;"><img src="/wp-content/uploads/2020/04/livestream_bg.jpg" style="width:100%;"/><table style="position: absolute; top:0; left:0; width:100%; height:100%;"><tr><td style="vertical-align:middle;"><div style="text-align:center;font-size:200%">Not logged in</div><div style="text-align:center;">please login to watch the livestream.</div><div style="text-align:center;"><a href="/my-account/" TARGET="_blank"><button type="button">login</button></a></div></td></td></table></div>');
                break;
            case -2: 
                echo('<div style="position: relative;"><img src="/wp-content/uploads/2020/04/livestream_bg.jpg" style="width:100%;"/><table style="position: absolute; top:0; left:0; width:100%; height:100%;"><tr><td style="vertical-align:middle; padding-left: 20%; padding-right:20%;"><div style="text-align:center;font-size:200%">'.(!empty($settings["product-name"])?$settings["product-name"]:"livestream").'<br/>Order not found</div><div style="text-align:center;">Hi '.$this->username().',<br/>we can\'t find any order for this livestream.<br/>If you haven\'t bought a ticket yet, please click on the button below. If you already bought it or have trouble accessing it, please <a href="https://m.me/AndiKDance" TARGET="_blank">contact us</a>.</div><div style="text-align:center;"><a href="/shop/" TARGET="_blank"><button type="button">buy a livestream ticket</button></a></div></td></td></table></div>');
                break;
            case 1: 
				if (empty($settings["youtube-id"])) echo('Error: Video ID is missing');
				else echo('<div style="position: relative; width:100%; height: 0; padding-bottom: 56.25%"><div style="position: absolute; left: 0; top:0; width:100%; height:100%">
			   <iframe class="elementor-video-iframe" allowfullscreen="" title="youtube Video Player" src="https://www.youtube.com/embed/'.$settings["youtube-id"].'?feature=oembed&amp;start&amp;end&amp;wmode=opaque&amp;loop=0&amp;controls=1&amp;mute=0&amp;rel=0&amp;modestbranding=0" style="width:100%; height:100%;"></iframe>
				</div></div>
                '); 
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