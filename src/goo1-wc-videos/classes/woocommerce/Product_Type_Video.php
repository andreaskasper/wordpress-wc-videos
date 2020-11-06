<?php

namespace plugins\goo1\wc\videos\woocommerce;

class Product_Type_Video extends WC_Product_Simple {


    public function __construct($product) {
        $this->product_type = 'video';
        add_filter('woocommerce_product_data_tabs', array($this, 'remove_tabs'), 10, 1);
        parent::__construct($product);
    }

    /**
     * Returns the product's active price.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string price
     */
     public function get_price( $context = 'view' ) {

        if ( current_user_can('manage_options') ) {
            $price = $this->get_meta( '_member_price', true );
            if ( is_numeric( $price ) ) {
                return $price;
            }
        
        }
		return $this->get_prop( 'price', $context );
      }

      public function remove_tabs($tabs) {

        /**
         * The available tab array keys are:
         * 
         * general
         * inventory
         * shipping
         * linked_product
         * attribute
         * variations
         * advanced
         */
        print_r($tabs);
        //unset($tabs['shipping']);
        //unset($tabs['inventory']);
        return $tabs;
    }
}