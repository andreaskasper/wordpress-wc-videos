<?php

namespace plugins\goo1\wc\videos;

class woocommerce {

    public static function init() {
        add_filter("woocommerce_product_data_tabs", [__CLASS__, "add_product_tabs"]);
        add_action("woocommerce_product_data_panels", [__CLASS__, "add_product_panel"]);
        add_action("woocommerce_process_product_meta", [__CLASS__, "save_product_tag"]);
    }

    public static function add_product_tabs($tabs) {
        $tabs['video'] = array(
            'label' => __('Video', 'goo1-wc-videos'),
            'target' => 'wc_video_id',
            'class'  => array('show_if_virtual'),
        );
        return $tabs;
    }

    public static function add_product_panel() {
        global $post_id;
        echo('<div id="wc_video_id" class="panel woocommerce_options_panel">');
        echo('<style>
        #woocommerce-product-data ul.wc-tabs li.video_options a:before { content: "\f235"; }
        </style>');
        $row = get_post_meta($post_id);

        woocommerce_wp_text_input(array(
			'id'            => "goo1_wcv_youtube_id1",
			'wrapper_class' => 'show_if_simple',
			'label'         => __("YouTube ID:", "goo1-wc-videos"),
            'description'   => __('abchgui', "goo1-wc-videos"),
            'value'         => $arr["goo1_wcv_youtube_id1"][0] ?? "",
            'desc_tip'      => true
        ));
        
        woocommerce_wp_text_input(array(
			'id'            => "goo1_wcv_url_video",
			'wrapper_class' => 'show_if_simple',
			'label'         => __("Video URL:", "goo1-wc-videos"),
            'description'   => __('', "goo1-wc-videos"),
            'value'         => $arr["goo1_wcv_url_video"][0] ?? ""
        ));
        
        woocommerce_wp_text_input(array(
			'id'            => "goo1_wcv_local_video_pre",
			'wrapper_class' => 'show_if_simple',
			'label'         => __("Local Video Prefix:", "goo1-wc-videos"),
            'description'   => __('', "goo1-wc-videos"),
            'value'         => $arr["goo1_wcv_local_video_pre"][0] ?? ""
		));

        echo('</div>');
    }

    public static function save_product_tag($post_id) {
        $tagPrefix = 'wc_akyoutube_';
        /*for ($i = 1; $i <= 6; $i++) {
            if (!empty($_POST['wc_akyoutube_id'.$i])) update_post_meta($post_id, "wc_akyoutube_id".$i, $_POST['wc_akyoutube_id'.$i]);
            if (!empty($_POST['wc_akyoutube_label'.$i])) update_post_meta($post_id, "wc_akyoutube_label".$i, $_POST['wc_akyoutube_label'.$i]);
        }*/
            /*print_r($_POST['wc_akyoutube_id1']);
            /*$videoMetaTags = ['link', 'uri', 'name', 'description', 'duration', 'status', 'password'];
            $videoData = wc_vimeo_get_set_video_item_transient($_POST['wc_vimeo_id']);
            wc_vimeo_update_delete_post_meta($post_id, $tagPrefix.'id', $_POST['wc_vimeo_id']);
            foreach ($videoMetaTags as $tag) {
                wc_vimeo_update_delete_post_meta($post_id, $tagPrefix.$tag, $videoData->$tag);
            }* /
        }*/
    }

}