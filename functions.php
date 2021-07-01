<?php

function my_custom_scripts() {
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' , 'jquery-ui-autocomplete' ),'1.1',true );
    wp_localize_script( 'custom-js', 'ajaxscript', array( 'templatedir' => get_stylesheet_directory_uri().'/js/data.json' ) );

}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

function my_custom_style() {
  wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/maingauche.css',true );
}
add_action( 'wp_enqueue_scripts', 'my_custom_style' );


register_post_type(
  'blog',
  array(
    'label' => 'blog',
    'labels' => array(
      'name' => 'blog',
      //'singular_name' => 'Actualité',
      //'all_items' => 'Toutes les actus',
      //'add_new_item' => 'Ajouter une  actus',
      ),

        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => true,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        // "rewrite" => array( "slug" => "projets", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail", "excerpt" ),

  )
);


register_taxonomy(
  'categorie',
  'blog',
  array(
    'label' => 'categorie',
    'labels' => array(
    'name' => 'categorie',
    'singular_name' => 'categorie',
  ),
    'hierarchical' => true,


    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    //'rewrite' => array( 'slug' => 'projets', 'with_front' => false, 'hierarchical' => false ),
    'show_admin_column' => true,
  )
);
register_taxonomy_for_object_type( 'categorie', 'blog' );


register_taxonomy(
  'tendance',
  'blog',
  array(
    'label' => 'tendance',
    'labels' => array(
    'name' => 'tendance',
    'singular_name' => 'tendance',
  ),
    'hierarchical' => true,


    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    //'rewrite' => array( 'slug' => 'projets', 'with_front' => false, 'hierarchical' => false ),
    'show_admin_column' => true,
  )
);
register_taxonomy_for_object_type( 'tendance', 'blog' );

//Single Product - Hook

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_filter('woocommerce_product_single_add_to_cart_text','QL_customize_add_to_cart_button_woocommerce');
function QL_customize_add_to_cart_button_woocommerce(){
return __('Ajouter au Panier', 'woocommerce');
}
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( '<div class="mb-4">Votre panier est actuellement vide </div>', 'woocommerce' ) ) );
    echo $html;
}
// Change WooCommerce "Related products" text

add_filter('gettext', 'change_rp_text', 10, 3);
add_filter('ngettext', 'change_rp_text', 10, 3);

function change_rp_text($translated, $text, $domain)
{
     if ($text === 'Related products' && $domain === 'woocommerce') {
         $translated = esc_html__('Produits Similaires', $domain);
     }
     return $translated;
}
remove_action( 'woocommerce_checkout_billing', 'action_woocommerce_checkout_billing', 10, 0 ); 
// define the woocommerce_checkout_billing callback 
function action_woocommerce_checkout_billing(  ) { 
  return __('Adresse de Facturation', 'woocommerce');
}; 
// add the action 
add_action( 'woocommerce_checkout_billing', 'action_woocommerce_checkout_billing', 10, 0 ); 


//Personaliser les champs dans la page Checkout | WooCommerce
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
 {
 unset($fields['billing']['billing_address_2']);
 $fields['billing']['billing_first_name']['placeholder'] = 'Prénom'; 
 $fields['billing']['billing_first_name']['label'] = 'Votre Prénom'; 
 $fields['billing']['billing_last_name']['placeholder'] = 'Nom';
 $fields['billing']['billing_last_name']['label'] = 'Votre Nom';
 $fields['billing']['billing_email']['label'] = 'Adresse E-Mail';
 $fields['billing']['billing_phone']['label'] = 'Numéro de Téléphone';
 $fields['billing']['billing_country']['label'] = 'Pays';
 $fields['billing']['billing_postcode']['label'] = 'Code Postal';
 $fields['billing']['billing_postcode']['placeholder'] = 'Ex : 75000';
 //$fields['billing']['billing_city']['custom_attributes'] = array('readonly'=>'readonly');
 $fields['billing']['billing_city']['label'] = 'Ville';
 $fields['billing']['billing_city']['placeholder'] = 'Ex : Paris';
 $fields['billing']['billing_state']['label'] = 'Région';
 $fields['billing']['billing_address_1']['label'] = 'Adresse';
 $fields['billing']['billing_address_1']['placeholder'] = 'Ex : 17 Rue Des Cerisiers';
 $fields['order']['order_comments']['label'] = 'Notes';
 $fields['order']['order_comments']['placeholder'] = 'Commentaires conçernant votre commande, ex : consignes de livraison';



 return $fields;
 }

/*
 Remove all possible fields
 */
function wc_remove_checkout_fields( $fields ) {

  // Billing fields
  unset( $fields['billing']['billing_company'] );

  return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );

add_filter('login_errors', 'filter_login_errors', 10, 1);	
function filter_login_errors( $error ) {
	if (empty($error)) return $error;
	
	$error = 'Votre login ou votre mot de passe est incorrect. Veuillez réessayer.';

	return $error ;
}
add_action( 'plugins_loaded', 'init_wc_custom_payment_gateway' );

function init_wc_custom_payment_gateway(){
    class WC_Custom_PG extends WC_Payment_Gateway {
        function __construct(){
            $this->id = 'wc_custom_pg';
            $this->method_title = 'Carte Cadeau Cadhoc ou Kadéos';
            $this->title = 'Carte Cadeau Cadhoc ou Kadéos';
            $this->has_fields = true;
            $this->method_description = 'Your description of the payment gateway';

            //load the settings
            $this->init_form_fields();
            $this->init_settings();
            $this->enabled = $this->get_option('enabled');
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option('description');

            //process settings with parent method
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        }
        public function init_form_fields(){
            $this->form_fields = array(
                'enabled' => array(
                    'title'         => 'Enable/Disable',
                    'type'          => 'checkbox',
                    'label'         => 'Enable Custom Payment Gateway',
                    'default'       => 'yes'
                ),
                'title' => array(
                    'title'         => 'Method Title',
                    'type'          => 'text',
                    'description'   => 'This controls the payment method title',
                    'default'       => 'Custom Payment Gatway',
                    'desc_tip'      => true,
                ),
                'description' => array(
                    'title'         => 'Customer Message',
                    'type'          => 'textarea',
                    'css'           => 'width:500px;',
                    'default'       => 'Your Payment Gateway Description',
                    'description'   => 'The message which you want it to appear to the customer in the checkout page.',
                )
            );
        }

        function process_payment( $order_id ) {
            global $woocommerce;

            $order = new WC_Order( $order_id );

            /****

                Here is where you need to call your payment gateway API to process the payment
                You can use cURL or wp_remote_get()/wp_remote_post() to send data and receive response from your API.

            ****/

            //Based on the response from your payment gateway, you can set the the order status to processing or completed if successful:
            $order->update_status('processing','Additional data like transaction id or reference number');

            //once the order is updated clear the cart and reduce the stock
            $woocommerce->cart->empty_cart();
            $order->reduce_order_stock();

            //if the payment processing was successful, return an array with result as success and redirect to the order-received/thank you page.
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url( $order )
            );
        }

        //this function lets you add fields that can collect payment information in the checkout page like card details and pass it on to your payment gateway API through the process_payment function defined above.

        public function payment_fields(){
            ?>
            <fieldset>
                <p class="form-row form-row-wide">
                    <?php echo esc_attr($this->description); ?>
                </p>                        
                <div class="clear"></div>
            </fieldset>
            <?php
        }

    }
}

add_filter( 'woocommerce_payment_gateways', 'add_your_gateway_class' );

function add_your_gateway_class( $methods ) {
    $methods[] = 'WC_Custom_PG'; 
    return $methods;
}
/**
 * Add "Print receipt" link to Order Received page and View Order page
 */
function isa_woo_thankyou() {
  echo '<a class="btn btn-primary mb-5" type="button" href="javascript:window.print()" id="wc-print-button">Imprimer</a>';
}
add_action( 'woocommerce_thankyou', 'isa_woo_thankyou', 1);
add_action( 'woocommerce_view_order', 'isa_woo_thankyou', 8 );
add_action('woocommerce_thankyou_bacs', 'webroom_custom_bank_thankyou_message', 5);
function webroom_custom_bank_thankyou_message(){
	echo '<section class="woocommerce-order-details">
        <h2 class="woocommerce-order-details__title">Contact</h2>
        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        </table>
        <p>Après avoir effectué votre virement, veuillez envoyer un mail à cette addresse : <a href="mailto:jules@free.fr">lamaingauche@orange.fr</a> en indiquant votre numéro de commande.</p>

  </section>';
}


/**
 * @snippet       Rename Custom Link Label @ WooCommerce/WP Nav Menu
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'wp_nav_menu_items', 'bbloomer_dynamic_menu_item_label', 9999, 2 ); 
 
function bbloomer_dynamic_menu_item_label( $items, $args ) { 
   if ( ! is_user_logged_in() ) { 
      $items = str_replace( "Login / Register", "Login", $items ); 
   } 
   return $items; 
} 

