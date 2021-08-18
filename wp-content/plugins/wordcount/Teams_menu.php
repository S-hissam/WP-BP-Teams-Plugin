<?php

// // Required PHP version.
// define( 'BP_REQUIRED_PHP_VERSION', '5.6.0' );

/*
* @package TeamsClimactivity
*/

/*
Plugin Name: Teams fo Clim
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



//load scripts
// require_once(plugin_dir_url(__FILE__).'./includes/climactive.php');

// // if the Class for Plugin exist then show 
// if ( class_exists('Teams')){ return
// $teams;
// }




//class for plugin


    add_action('admin_menu', 'tm_add_admin_menu');  

   function tm_add_admin_menu()
   {
      add_menu_page('Teams', 'Teams Climactivity', 'manage_options', 'Teams-admin-menu', 'teams_menu_main', 'dashicons-buddicons-buddypress-logo', 2);
   }

   function teams_menu_main(){
      echo '<div class"wrap"> <h3 class="wrap"> Working on it</h3> </div>';
   }



