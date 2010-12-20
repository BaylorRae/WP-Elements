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

$box = new metaBox(array(
    'isFormBox' => true,
    'type' => 'post',
    'id' => 'superHero',
    'title' => 'Add a Super Hero'
  ));

$box->addInput(array(
    'id' => 'nickname',
    'label' => 'Nickname',
    'value' => get_post_meta($_GET['post'], 'nickname', true),
    'size' => 'large'
  ));
  
$box->addDropdown(array(
    'id' => 'awesomeness',
    'label' => 'Awesomeness',
    'value' => get_post_meta($_GET['post'], 'awesomeness', true),
    'options' => array(
        'Ultra Awesome' => 'ultra',
        'Super Awesome' => 'super',
        'Not So Awesome' => 'notSo',
        'Kinda Dull Awesome' => 'kindaDull',
        'Super Duper Mega Awesome!' => 'superDuperMega'
      )
  ));
  
$box->addRadiobuttons(array(
    'id' => 'gender',
    'label' => 'Gender',
    'value' => get_post_meta($_GET['post'], 'gender', true),
    'options' => array(
        'Male' => 'male',
        'Female' => 'female'
      ),
    // 'desc' => null
  ));

?>