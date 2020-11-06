<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

namespace plugins\goo1\wc\videos\elementor\widgets;

class Videolist extends \Elementor\Widget_Base {

	protected static $cachepostlevels = null;

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
		return 'goo1-wc-videos-videolist';
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
		return __( 'Video List', 'plugin-name' );
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
		return 'fa fa-th';
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
		return ["andreaskasper", "tanzschule"];
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

      	/*$args = array(
               'type' => 'msp-videos',
               'orderby' => 'name',
               'order'   => 'ASC'
           );


		$a = array("" => "");
   		$cats = get_categories($args);
		foreach($cats as $cat) $a[$cat->term_id] = $cat->name;

		$this->add_control(
			'category',
		[
			'label' => __( 'Category Name', 'plugin-domain' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => $a,
		]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category Name', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);*/

		/*$this->add_control(
			'show_locked',
			[
				'label' => __( 'show locked videos', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'show', 'your-plugin' ),
				'label_off' => __( 'hide', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);*/

		/*$this->add_control(
			'url_link',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '/', 'plugin-domain' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
               		
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label' => __( 'Duration 00:00', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( '', 'plugin-name' ),
			]
		);*/

		

		$this->end_controls_section();

	}
	
	protected function levelnameofpost(int $id) : string {
		global $wpdb;
		if (is_null(self::$cachepostlevels)) {
			self::$cachepostlevels = array();
			$rows = $wpdb->get_results('SELECT * FROM kylsara_swpm_membership_tbl WHERE id > 1 ORDER BY id DESC');
			foreach ($rows as $row) {
				self::$cachepostlevels[$row->id] = unserialize($row->custom_post_list);
			}
		}
		$a = array();
		if (in_array($id, self::$cachepostlevels[2])) $a[] = "Basic";
		if (in_array($id, self::$cachepostlevels[3])) $a[] = "Elite";
		if (in_array($id, self::$cachepostlevels[4])) $a[] = "Founder";
		return $this->natural_language_join($a," & ");
	}

	protected function natural_language_join(array $list, $conjunction = 'and') {
		$last = array_pop($list);
		if ($list) {
		  return implode(', ', $list) . ' ' . $conjunction . ' ' . $last;
		}
		return $last;
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

if (!isset($_ENV["already_loaded_style_".__FILE__])) {
?>
<style>
a.akvideoitem { display: block; flex: 2 0 15rem; width:15rem; border: 1px solid rgba(255,255,255,0.5); padding: 0.5rem; background: rgba(0,0,0,0.5); transition: all 300ms ease; margin: 0px 0.5rem 0.5rem 0px; }
a.akvideoitem div.poster { position: relative; display: block; width: 100%; height: 0; padding-bottom: 56.25%; }
a.akvideoitem div.poster > div.img { position: absolute; display: block; width: 100%; height: 100%; top: 0; left: 0; background: transparent no-repeat center center; background-size: cover; opacity: 0.75; }
a.akvideoitem:hover { border-color: #fff; background: #000; }
a.akvideoitem:hover div.poster > div.img { opacity: 1;}

div.akvideoitem { display: block; flex: 2 0 15rem; width:15rem; border: 1px solid rgba(255,255,255,0.5); padding: 0.5rem; background: rgba(0,0,0,0.5); transition: all 300ms ease; margin: 0px 0.5rem 0.5rem 0px; }
div.akvideoitem div.poster { position: relative; display: block; width: 100%; height: 0; padding-bottom: 56.25%; }
div.akvideoitem div.poster > div.img { position: absolute; display: block; width: 100%; height: 100%; top: 0; left: 0; background: transparent no-repeat center center; background-size: cover; opacity: 0.75; }
div.akvideoitem.disabled div.poster > div.img { filter: grayscale(100%); opacity: 0.25; }

div.akvideoitem:hover { border-color: #fff; background: #000; }
</style>
<?php
	$_ENV["already_loaded_style_".__FILE__] = true;
}

?>
<table style="width:100%;">
<tr><td>Search:</td><td><INPUT type="text" name="query" style="width:100%;"/></td></tr>
<tr><td>Level:</td><td><button type="button">Level 1</button><button type="button">Level 2</button><button type="button">Level 3</button><button type="button">Level 4</button><button type="button">all</button></td></tr>
<tr><td>Show:</td><td><button type="button">open</button><button type="button">locked</button><button type="button">all</button></td></tr>
<tr><td>Sort:</td><td><button type="button">Name</button><button type="button">Release</button><button type="button">Random</button></td></tr>

</table>

<?php

$url_swpm_login = SwpmSettings::get_instance()->get_value('login-page-url');

echo('<!--'.$url_swpm_login.'-->');

$access_ctrl = SwpmAccessControl::get_instance();
$protection_ctrl = SwpmProtection::get_instance();


$member_isloggedin = (SwpmMemberUtils::is_member_logged_in());
if ($member_isloggedin) {
	$member_id = SwpmMemberUtils::get_logged_in_members_id();
	$swpm_user = SwpmMemberUtils::get_user_by_id($member_id);

	$user_since = $swpm_user->member_since;
	$user_days = (time()-strtotime($swpm_user->member_since))/86400;
	$user_level = $swpm_user->membership_level;
}

echo('<!--Lvl:'.($user_level ?? ""));
echo('  Days:'.($user_days ?? ""));
echo('-->');


		$args = array(  
			'post_type' => 'msp-videos',
			'post_status' => 'publish',
			/*'posts_per_page' => 8, */
			'orderby' => 'title', 
			'order' => 'ASC', 
		);

		//if (!empty($settings["category"])) $args["category_name"] = $settings["category"];
		if (!empty($settings["category"])) $args["cat"] = $settings["category"];

		echo('<div style="display: flex; width:100%; flex-wrap: wrap;">');
	
		$loop = new \WP_Query( $args ); 
		while ($loop->have_posts()) {
			$loop->the_post();
			$post = get_post();

			$url_img = get_the_post_thumbnail_url($post, 'post-thumbnail');
			if (empty($url_img)) $url_img = "//placehold.it/1920x1080.jpg";

			//print_r($post);
			
			$item_enabled = ((!$protection_ctrl->is_protected($post->ID)) OR ($member_isloggedin AND $access_ctrl->can_i_read_post($post)));

			if (!$item_enabled  AND (($settings["show_locked"] ?? "yes") != "yes")) continue;

			if ($item_enabled) echo('<a href="'.get_permalink().'" class="akvideoitem">');
			else echo('<div class="akvideoitem disabled">');
		echo('<div class="poster"><div class="img" style="background-image: url('.($url_img).');"></div>');
		if (!empty($settings["duration"])) echo('<div style="display: block; position: absolute; right: 0; bottom: 0; padding: 3px; color: #fff; background: rgba(0,0,0,0.25); font-size: 12px;">'.$settings["duration"].'</div>');
		
		if (!$item_enabled AND !$member_isloggedin) {
			echo('<div style="display: block; position: absolute; width:100%; height:100%; left: 0; top: 0; align-items: center; justify-content: center;"><a href="'.$url_swpm_login.'"><button type="button"><i class="far fa-user-lock"></i>please login</button></a></div>');
			echo('<div style="display: block; position: absolute; left: 0; bottom: 0; background: #0094FF20; color: #0094FF; padding: 0.1rem 0.3rem; font-size: 0.8rem; border-top-right-radius: 0.5rem;">'.$this->levelnameofpost($post->ID).'</div>');
			//$level=$this->levelofpost($post->ID);
		}
		elseif (!$item_enabled AND !$access_ctrl->can_i_read_post($post)) echo('<div style="display: flex; position: absolute; width:100%; height:100%;  left: 0; top: 0; align-items: center; justify-content: center;"><span><i class="fas fa-lock-alt" style="font-size: 4rem; opacity: 0.75;"></i></span></div>');

		if ($item_enabled) echo('<div style="display: flex; position: absolute; width:100%; height:100%; left: 0; top: 0; align-items: center; justify-content: center;"><i class="fal fa-play-circle" style="font-size: 4rem; color: #ffffffb0;"></i></div>');

		echo('</div>');
		echo('<div style="font-size: 1.25rem; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" TITLE="'.(get_the_title() ?? "Lorem Ipsum").'">'.(get_the_title() ?? "Lorem Ipsum").'</div>');
		if ($item_enabled) echo('</a>'); else echo('</div>');
		}

		echo('</div>');
			
		/*while ( $loop->have_posts() ) : $post = $loop->the_post(); 
			print_r($post);
			/*print the_title(); 
			the_excerpt(); * /
		endwhile;*/
	
		wp_reset_postdata(); 

		//$rows = get_posts();
		//print_r($rows);

		//print_r($settings);
	}
}