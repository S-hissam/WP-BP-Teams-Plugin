<?php
// Script here
function test_add_scripts(){
  // main js
  wp_enqueue_script('test-main-script', plugins_url().'./Test_plugin/js/main.js');
  //main css
  wp_enqueue_style('test-main-style', plugins_url(). './Test_plugin/css/style.css');
}

add_action('wp_enqueue_scripts', 'test_add_scripts');