<?php

if( !class_exists('WPElement') ) {

  class WPElement {

    private $type = null;
    private $useFormStructure = true;
    private $elements = array();
    private $boxProperties = array();
    private $fileName = null;

    function __construct($type, $useFormStructure = true) {
      $this->type = $type;
      $this->useFormStructure = $useFormStructure;

      $debug = debug_backtrace();
      $this->fileName = $debug[0]['file'];
    }

    public function createMetaBox($id, $title, $context = null, $priority = null) {
      $this->boxProperties['id'] = $id;
      $this->boxProperties['title'] = $title;
      $this->boxProperties['context'] = (empty($context)) ? 'advanced' : $context;
      $this->boxProperties['priority'] = (empty($priority)) ? 'default' : $priority;

      add_action('admin_menu', array($this, 'addmetaBox'));
    }  

    public function addMetaBox() {
      $id = $this->boxProperties['id'];
      $title = $this->boxProperties['title'];
      $context = $this->boxProperties['context'];
      $priority = $this->boxProperties['priority'];
      add_meta_box($id, $title, array($this, 'doMetaBox'), $this->type, $context, $priority);
    }

    public function doMetaBox() {

      $elements = $this->elements;

      if( $this->useFormStructure )
        echo '<table class="form-table">';

      echo '<input type="hidden" name="' . $this->boxProperties['id'] . '_noncename" id="' . $this->boxProperties['id'] . '_noncename" value="' . wp_create_nonce( plugin_basename($this->fileName) ) . '" />';

      foreach( $elements as $elem ) {
        $elem = (object) $elem;

        if( empty($elem->id) )
          continue;

        $elem->id = $this->boxProperties['id'] . '_' .  $elem->id;

        if( $this->useFormStructure ) {
          echo '<tr valign="top">';

          // Display the label
          if( $elem->type == 'checkbox' && !isset($elem->options))
            echo '<th scope="row"><span>' . $elem->title . '</span></th>';

          elseif( !in_array($elem->type, array('paragraph', 'html')) )
            echo '<th scope="row"><label for="' . $elem->id . '">' . $elem->label . '</label></th>';

          if( !in_array($elem->type, array('paragraph', 'html')) )
            echo '<td>';
          else
            echo '<td colspan="2">';
        }

        if( !in_array($elem->type, array('checkbox', 'radiobuttons')) )
          $elem->value = ( empty($elem->value)) ? '' : $elem->value;

        switch ($elem->type) {

          case 'input' :

            // Optional values
            $elem->size = (empty($elem->size)) ? 'regular-text' : $elem->size . '-text';

            echo '<input type="text" id="' . $elem->id . '" name="' . $elem->id . '" value="' . $elem->value . '" class="' . $elem->size . '" />';

          break;

          case 'textarea' :

            // Optional values
            $elem->cols = (empty($elem->cols)) ? 30 : $elem->cols;
            $elem->rows = (empty($elem->rows)) ? 5 : $elem->rows;
            $elem->width = (empty($elem->width)) ? 500 : $elem->width;

            echo '<textarea id="' . $elem->id . '" name="' . $elem->id . '" cols="' . $elem->cols . '" rows="' . $elem->rows . '" style="width: ' . $elem->width . 'px">' . $elem->value . '</textarea>';

          break;

          case 'editor' :

            wp_tiny_mce(true, array('editor_selector' => $elem->id, $initArray));

            echo '<textarea class="' . $elem->id . '" id="' . $elem->id . '" name="' . $elem->id . '">' . $elem->value . '</textarea>';

          break;

          case 'checkbox' :

            // Single checkbox
            if( !isset($elem->options) ) {

              // Optional values
              $elem->checked = (empty($elem->checked)) ? false : $elem->checked;

              $extra = '';
              if( $elem->checked )
                $extra .= 'checked="checked"';

              echo '<input type="checkbox" id="' . $elem->id . '" name="' . $elem->id . '" ' . $extra . '/>';

              echo ' <label for="' . $elem->id . '">' . $elem->label . '</label> ';

            // Multiple checkboxes
            }else {

              if( is_array($elem->options) ) {
                foreach( $elem->options as $label => $info ) {
                  $info = (object) $info;

                  if( empty($info->id) )
                    continue;

                  // Optional values
                  $info->checked = (empty($info->checked)) ? false : $info->checked;

                  $extra = '';
                  if( $info->checked )
                    $extra .= 'checked="checked"';

                  echo '<input type="checkbox" id="' . $info->id . '" name="' . $info->id . '" ' . $extra . '/>';

                  echo ' <label for="' . $info->id . '">' . $label . '</label><br />';

                }
              }

            }

          break;

          case 'radiobuttons' :

            if( is_array($elem->options) ) {
              foreach( $elem->options as $label => $id ) {                          
                if( empty($id) )
                  continue;

                $extra = '';
                if( $elem->value == $id )
                  $extra .= 'checked="checked"';

                echo '<input type="radio" id="' . $id . '" name="' . $elem->id . '" value="' . $id . '" ' . $extra . '/>';

                echo ' <label for="' . $id . '">' . $label . '</label><br />';

              }
            }

          break;

          case 'dropdown' :

            if( is_array($elem->options) ) {
              echo '<select name="' . $elem->id . '" id="' . $elem->id . '">';            

              foreach( $elem->options as $label => $id ) {                          

                $extra = '';
                if( $elem->value == $id )
                  $extra .= 'selected="selected"';

                echo '<option value="' . $id . '" ' . $extra . '>' . $label . '</option>';

              }

              echo '</select>';            
            }

          break;

          case 'paragraph' :
            echo '<p>' . $elem->text . '</p>';
          break;

          case 'html' :
            echo $elem->html;
          break;

        } // end switch

        if( !in_array($elem->type, array('slider', 'date')) && !empty($elem->desc) )
          echo '<span class="description">' . $elem->desc . '</span>';

        if( $this->useFormStructure ) {
          echo '</td>';
          echo '</tr>';
        }

      } // end foreach

      if( $this->useFormStructure )
        echo '</table>';


    } 

    private function add($type, $args) {
      $type = array('type' => $type);
      $args = array_merge($type, $args);
      $this->elements[] = $args;
    }

    function __call($func, $args) {
      $args = $args[0];
      if( preg_match('/^add(.+)/', $func, $matches) ) {
        $type = strtolower($matches[1]);
        $this->add($type, $args);
      }
    }

    public function addParagraph($text) {
      $data = array('text' => $text);
      $this->add('paragraph', $data);
    }

    // Alias to $this->addParagraph()
    public function paragraph($text) {
      $this->addParagraph($text);
    }


    public function addHTML($html) {
      $data = array('html' => $html);
      $this->add('html', $data);
    }

    // Alias to $this->addHTML()
    public function html($html) {
      $this->addHTML($html);
    }

  }  
  
}


?>