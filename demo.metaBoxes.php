<?php
/*
Plugin Name: Fake Plugin (Meta Boxes)
Plugin URI: http://baylorrae.com
Description: What a cool thing
Author: Baylor Rae'
Version: Beta
Author URI: http://baylorrae.com/
*/

include 'WP-Elements.class.php';

// ============
// = Form Box =
// ============
$poem = new metaBox(array(
    'isFormBox' => true,
    'id' => 'whatDoYaThink',
    'title' => 'What Do Ya Think',
    // 'context' => 'advanced', (normal, advanced, side)
    // 'priority' => 'default' (high, low)
  ));

$poem->addInput(array(
    'id' => 'tellme',
    'label' => 'Tell Me',
    // 'desc' => null,
    // 'value' => null,
    // 'size' => 'regular'
  ));
    
$poem->addTextarea(array(
    'id' => 'more',
    'label' => 'Give Me More',
    // 'desc' => null,
    // 'value' => null,
    // 'rows' => 5,
    // 'width' => 500
  ));
    
$poem->addEditor(array(
    'id' => 'evenmore',
    'label' => "Don't Hold Back On Me",
    // 'desc' => null,
    // 'value' => null
  ));

// A single checkbox
$poem->addCheckbox(array(
    'id' => 'isSpecial',
    'label' => 'Is Special?',
    'title' => 'Status',
    // 'desc' => null,
    // 'checked' => false
  ));

// Multiple checkboxes
  // checked always defaults to false
$poem->addCheckbox(array(
    'id' => 'repairs',
    'label' => 'Repairs Include',
    // 'desc' => null,
    
    'options' => array(
        'Engine' => array(
            'id' => 'engine',
            'checked' => true
          ),
        'Tires' => array(
            'id' => 'tires',
            // 'checked' => false
          ),
        'Brake Lights' => array(
            'id' => 'brakelights',
            'checked' => true
          )
      )
  ));

$poem->addRadiobuttons(array(
    'id' => 'gender',
    'label' => 'Gender',
    'value' => 'male',
    'options' => array(
        'Male' => 'male',
        'Female' => 'female'
      ),
    // 'desc' => null
  ));
  
$poem->addDropdown(array(
    'id' => 'type',
    'label' => 'Type',
    // 'value' => null,
    'options' => array(
        'Car' => 'car',
        'Truck' => 'truck',
        'Motorcycle' => 'motorcycle'
      ),
    // 'desc' => null
  ));
  

// ===============
// = Regular Box =
// ===============
$box2 = new metaBox(array(
    'id' => 'box2',
    'title' => 'This is my second box',
    'context' => 'side'
  ));

$box2->html('<p>Please click on my <a href="#">link</a></p>');

$box2->paragraph('Please tell me something');

?>