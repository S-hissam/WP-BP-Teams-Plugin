<?php

// // Required PHP version.
// define( 'BP_REQUIRED_PHP_VERSION', '5.6.0' );

/*
* @package TeamsClimactivity
*/

/*
Plugin Name: Climactivity Teams
Plugin URI: https://app.climactivity.de 
Description: Teams Plugin for Climactivity Social network.
Version: 0.0.1
Author: Climactivity
Author URI: https://github.com/climactivity
License: MIT
Text Domain: cy
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
// defined('ABSPATH') or die('Hey you cant access here');
// if(! function_exists('add_action')){
//   echo 'hey, no access here';
//   exit;
// }


//load scripts
// require_once(plugin_dir_url(__FILE__).'./includes/climactive.php');

// // if the Class for Plugin exist then show 
// if ( class_exists('Teams')){ return
// $teams;
// }



//class for plugin

class Teams {
   function __construct()
   {
    add_action('admin_menu', array($this, "adminPage")); 
    add_action('admin_init',array($this, 'settings')); 
    add_filter('the_content',array($this, 'ifwrap'));
   }

   function ifwrap($content){
      if ((is_main_query() AND is_single()) AND
       (
         get_option('wcp_checkbox','1') OR
         get_option('wcp_character','1') OR
         get_option('wcp_read','1')
      )) {
         return $this-> createhtml($content);
      }
      return $content;
   }

   function createhtml($content){
      $title = '<h3>' .  get_option('wcp_headline','Teams Title') .'</h3> <p>';
      $stadt = '<h3>' .  get_option('wcp_stadt','Teams Stadt / Stadtteil') .'</h3> <p>';
      $plz = '<h3>' .  get_option('wcp_plz','Teams Postleitzahl') .'</h3> <p>';
      $des = '<h4>' .  get_option('wcp_des','Teams Description') .'</h4> <p>';

      if(get_option('wcp_location','0') == '0'){
         return $title . $stadt . $plz. $des . $content;
      }
      return $content . $title. $stadt . $plz . $des;
   }

   function adminPage(){
      add_menu_page('Teams Plugin', 'Teams Plugin','manage_options', 'teams-plugin-setting-page',array($this, 'ourhtml'),'dashicons-buddicons-buddypress-logo',2);
   }
   
   function settings(){
      
      add_settings_section('teams_mode_sec', null, null, 'teams-plugin-setting-page');
      
      
      // headline
      add_settings_field('wcp_headline', 'Teams Title', array($this,'headlinehtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_headline', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'Teams Title'));
      
      // Teams stadtteil
      add_settings_field('wcp_stadt', 'Stadt/Stadtteil', array($this,'stadthtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_stadt', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'Bremen'));

      // Teams plz
      add_settings_field('wcp_plz', 'Postleitzahl', array($this,'plzhtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_plz', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'28329'));

      // Teams description
      add_settings_field('wcp_des', 'Teams Description', array($this,'deshtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_des', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'We are a good team!'));
      
      // location
      add_settings_field('wcp_location', 'Teams Location', array($this,'locationhtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' =>'0'));
      
      // checkbox
      add_settings_field('wcp_checkbox', 'Teams checkbox', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_checkbox'));
      register_setting('wordteamsplugin', 'wcp_checkbox', array('sanitize_callback' => 'sanitize_text_field', 'default' =>'1'));

      // charactecount
      add_settings_field('wcp_character', 'Member Count', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_character'));
      register_setting('wordteamsplugin', 'wcp_character', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'1'));

      // readtime
      add_settings_field('wcp_read', 'Share', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_read'));
      register_setting('wordteamsplugin', 'wcp_read', array('sanitize_callback'=> 'sanitize_text_field', 'default' =>'1'));


   }
   

   function sanitizeLocation($input){
      if($input != '0' AND $input != '1'){
         add_settings_error('wcp_location','wcp_location-error','its not allowed must be 1 or 0 displlay location');
         return get_option('wcp_location');
      }
      return $input;
   }   

   function checkboxhtml($arg){?>
      <input type="checkbox" name="<?php echo $arg['name'] ?>" value="1"<?php checked(get_option($arg['name']),'1') ?> >
      <?php 
   }

   function headlinehtml(){?>
      <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')) ?>">
      <?php 
   }

   function plzhtml(){?>
      <input type="number" name="wcp_plz" value="<?php echo esc_attr(get_option('wcp_plz')) ?>">
      <?php 
   }

   function stadthtml(){?>
      <input type="text" name="wcp_stadt" value="<?php echo esc_attr(get_option('wcp_stadt')) ?>">
      <?php 
   }

   function deshtml(){?>
      <input type="text" name="wcp_des" value="<?php echo esc_attr(get_option('wcp_des')) ?>">
      <?php 
   }
   

   function locationhtml(){?> 
   <select name="wcp_location">
      <option value="0" <?php selected(get_option('wcp_location'),'0') ?>>Oben</option>
      <option value="1" <?php selected(get_option('wcp_location'),'1') ?>>Unten</option>
   </select>
   <?php 
   }
   
   function ourhtml() { ?>
      <div class="wrap">
      <h3>Climactivity Teams</h3>
      <form action="options.php" method="POST">
        <?php 
        settings_fields('wordteamsplugin');
        do_settings_sections('teams-plugin-setting-page');
        submit_button('Create Teams');
        ?>
      </form>

      <?php 
   } 
   
}

$teams1 = new Teams();