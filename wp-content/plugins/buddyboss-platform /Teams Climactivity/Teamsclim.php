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
    add_action('admin_menu', array($this, 'adminPage'));
    add_action('admin_init', array($this, 'settings'));
  }

  function settings(){
    add_settings_section('teams_mode_sec', null, null,'teams-climativity');
    add_settings_field('wcp_name', 'Teams Mode', array($this,'modeHtml'), 'teams-climativity', 'teams_mode_sec');
    register_setting('teamsplugin','wcp_name', array('sanitize_callback','sanitize_text_field', 'default' =>'0'));
  }

  function modeHtml(){?>
  <select name="wcp_name">
    <option value="0">Private</option>
    <option value="1">Public</option>
  </select>
  <?php }

  function adminPage(){
  add_options_page('Teams Climactivity','Climactivity Teams', 'manage_options','teams-climativity',array($this, 'ourhtml'));
  } 

  function ourhtml() { ?>
    <div class="wrap">
      <h3>Climactivity Teams</h3>
      <form action="option.php" method="POST">
        <?php 
        settings_fields('teamsplugin'); 
        do_settings_sections('teams-climativity'); 
        submit_button(); ?>
        
      </form>
    </div>
  <?php 
  } 
  
} 

$teams = new Teams();







