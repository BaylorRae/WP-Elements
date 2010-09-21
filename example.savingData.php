<?php
/*
Plugin Name: Add a super hero to your post
Plugin URI: http://baylorrae.com
Description: Adds a super hero to your post and lets you rate their awesomeness
Author: Baylor Rae'
Version: Beta
Author URI: http://baylorrae.com/
*/

// ===============
// = Add The Box =
// ===============
include 'WP-Elements.class.php';

$box = new WPElement('post');

$box->createMetaBox('superHero', 'Add A Super Hero', 'advanced');

$nickname = null;
$awesomeness = null;
if( isset($_GET['post']) ) {
  $value = get_post_meta($_GET['post'], 'superHeroData', true);
  
  if( !empty($value) ) {
    $value = unserialize($value);
    
    $nickname = (empty($value['nickname'])) ? null : $value['nickname'];
    $awesomeness = (empty($value['awesomeness'])) ? null : $value['awesomeness'];
  }
}

$box->addInput(array(
    'id' => 'nickname',
    'label' => 'Nickname',
    'value' => $nickname
  ));
  
$box->addDropdown(array(
    'id' => 'awesomeness',
    'label' => 'Awesomeness',
    'value' => $awesomeness,
    'options' => array(
        'Ultra Awesome' => 'ultra',
        'Super Awesome' => 'super',
        'Not So Awesome' => 'notSo',
        'Kinda Dull Awesome' => 'kindaDull',
        'Super Duper Mega Awesome!' => 'superDuperMega'
      )
  ));

// =======================
// = Save the Super Hero =
// =======================

add_action('save_post', 'saveSuperHero');

function saveSuperHero($post_id) {
  
  // Make sure our form was submitted
  if( !wp_verify_nonce($_POST['superHero_noncename'], plugin_basename(__FILE__)) )
    return $post_id;
    
  // Make sure this is not an autosave
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;
    
  // Check permissions
  $type = $_POST['post_type'];
  if( !current_user_can('edit_' . $type, $post_id) )
    return $post_id;
    
  $value = array();
    
  // Check for nickname
  $nickname = $_POST['superHero_nickname'];
  if( !empty($nickname) )
    $value['nickname'] = $nickname;
    
  // Get awesomeness
  $awesomeness = $_POST['superHero_awesomeness'];
  if( !empty($awesomeness) )
    $value['awesomeness'] = $awesomeness;
  
  // Save the data as post meta
  $value = serialize($value);
  update_post_meta($post_id, 'superHeroData', $value);
  
}

?>