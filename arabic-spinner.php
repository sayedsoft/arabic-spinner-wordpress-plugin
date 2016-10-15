<?php
/**
* Plugin Name: Arabic Spinner
* Plugin URI: http://arabicspinner.com/
* Description: First arabic spinner in internet
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author: Ahmed Yaman Sayed
* Author https://www.eforweb.net/
* License: MIT License 2016
*/


add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Arabic Spinner Options', 'Arabic Spinner', 'manage_options', 'arabic-spinner/spinner-options.php', '', 'dashicons-tickets', 6  );
}

add_action('media_buttons', 'add_spinner_button');

function add_spinner_button() {
    echo '<a href="#" id="insert-my-media" class="button">Spin it</a>';
    echo '<script>var spinnerurl = "'.plugins_url('/css/',__FILE__).'"; </script>';
}

add_action('wp_enqueue_media', 'include_media_button_js_file');

function include_media_button_js_file() {
    wp_enqueue_script('media_button', plugins_url( '/js/spinner-script.js', __FILE__ ), array('jquery'), '1.0', true);
}

add_action('wp_enqueue_media', 'include_media_button_css_file');

function include_media_button_css_file() {
    wp_register_style( 'spinner-admin-style', plugins_url( '/css/spinner-style.css', __FILE__ ));
    wp_enqueue_style( 'spinner-admin-style' );
}

function ArrayToJeson ($array) {
        if (is_array($array)) {
           $return = json_encode( $array, JSON_UNESCAPED_UNICODE );
        } else {
           $return = "False Array To array"; 
        }
        return $return ;
 }

add_action( 'wp_ajax_arabic_spinner_ajax', 'arabic_spinner_ajax' );

function arabic_spinner_ajax() {
     $response = new WP_Ajax_Response;
     if ($_REQUEST['conent']) {
         $content  = "";
         $apikey   = get_option('spinnerapikey', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');  // Enter Your Api Key
         $apipass  = get_option('spinnerapipass', 'xxxxxxxxx');  // Enter Your Api Password
         $yourtext = $_REQUEST['conent']; 
         $info     = array("apikey"=>$apikey,"apipass"=>$apipass,"text"=>html_entity_decode($yourtext) );
         $json   = ArrayToJeson ($info);
         $posturl  = "http://api.arabicspinner.com/api.php?mode=spinner";
         $ch       = curl_init();
         curl_setopt($ch, CURLOPT_URL,$posturl);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,"json=".$json);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         // Get Output
         $server_output = curl_exec ($ch);
         curl_close ($ch);
         $out          = json_decode($server_output,true);
         $modeout      = $out["mode"];
         $message      = $out["message"];
         if ($modeout == "true") {
            $mode    = "success";
            $content = $out["spinnedText"]; 
         } else {
            $mode    = "error";
         }
     } else {
        $mode     = "error";
        $message  = "Content Not Found!";
     }
     
     $response->add( array(
			'data'	=> $mode,
			'supplemental' => array(
				'message'     => $message,
                'spinnedText' => $content,
			),
		) );
     
     $response->send();
     exit();
     
}