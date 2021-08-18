<?php

// // Required PHP version.
// define( 'BP_REQUIRED_PHP_VERSION', '5.6.0' );

/*
* @package TeamsClimactivity
*/

/*
Plugin Name: Plugin testing
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

class Wordcount {
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
      $html = '<h3>' .  get_option('wcp_headline','Post Statistics') .'</h3> <p>';

      if(get_option('wcp_location','0') == '0'){
         return $html . $content;
      }
      return $content . $html;
   }

   function adminPage(){
      add_options_page('Test Plugin', 'Test Plugin','manage_options', 'teams-plugin-setting-page',array($this, 'ourhtml'));
   }
   
   function settings(){
      
      add_settings_section('teams_mode_sec', null, null, 'teams-plugin-setting-page');
      
      // location
      add_settings_field('wcp_location', 'Teams Location', array($this,'locationhtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' =>'0'));
       
      // headline
      add_settings_field('wcp_headline', 'Teams Headline', array($this,'headlinehtml'), 'teams-plugin-setting-page', 'teams_mode_sec');
      register_setting('wordteamsplugin', 'wcp_headline', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'Teams Headline'));

      // checkbox
      add_settings_field('wcp_checkbox', 'Teams checkbox', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_checkbox'));
      register_setting('wordteamsplugin', 'wcp_checkbox', array('sanitize_callback' => 'sanitize_text_field', 'default' =>'1'));

      // charactecount
      add_settings_field('wcp_character', 'Character Count', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_character'));
      register_setting('wordteamsplugin', 'wcp_character', array('sanitize_callback' =>'sanitize_text_field', 'default' =>'1'));

      // readtime
      add_settings_field('wcp_read', 'Readtime', array($this,'checkboxhtml'), 'teams-plugin-setting-page', 'teams_mode_sec',array('name' => 'wcp_read'));
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

$wordcount = new Wordcount();