<?php
/*
Plugin Name: Fake Plugin (Navigation Menus)
Plugin URI: http://baylorrae.com
Description: What a cool thing
Author: Baylor Rae'
Version: Beta
Author URI: http://baylorrae.com/
*/

$topPage = new topMenuLink(array(
    'page_title' => 'What Up',
    'menu_title' => 'Check me out',
    'capability' => 'manage_options',
    'menu_slug' => 'what-up',
    'function' => 'whatUp',
    'has_separator' => null // (before, after, both)
  ));

function whatUp() {
  echo 'Hey';
}

// Add a sublink to top page
$topPage->addSubLink(array(
    'parent_slug' => 'what-up',
    'page_title' => 'This is useful',
    'menu_title' => 'need to know!',
    'capability' => 'manage_options',
    'menu_slug' => 'what-up-page2',
    'function' => 'whatUp2'
  ));
  
function whatUp2() {
  echo 'Check this out!';
}

// Only adding a subpage
$subPage = new subMenuLink(array(
    'parent_slug' => 'index.php',
    'page_title' => 'Analytics',
    'menu_title' => 'Analytics',
    'capability' => 'manage_options',
    'menu_slug' => 'what-up-page2',
    'function' => 'analytics'
  ));
  
function analytics() {
  echo '<div class="wrap"><h2>Your Analytics</h2></div>';
}

?>