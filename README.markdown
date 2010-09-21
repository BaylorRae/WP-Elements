This class makes it super easy to add meta boxes to WordPress pages.

`demo_page.php` implements all the methods in the class, and comments out the optional parameters. The optional parameters have their default value.

### The Basics
The WPElements class takes two parameters. The first is the page ('post', 'page', 'link', 'custom\_post\_type'). The second is for the box type.

When setting the box type, `true` will add html for a form. `false` will not. This way you can add boxes with a paragraph or html. Similar to the "Post Thumbnail" box.

`WPElements::createMetaBox($id, $title[, $context][, $priority]);`

* `$id (string)(required) HTML 'id' attribute of the box`

* `$title (string)(required) The title of the box`

* `$context (string)(optional) Where to put the box ('normal', 'advanced', 'side') Default: 'advanced'`

* `$priority (string)(optional) The importance of the box. Determines where the box goes. ('high', 'low') Default: 'default'`

### Making a form
	
	// Goes on the post page and will be a form
	$form = new WPElements('post');
	
	$form->createMetaBox('whatDoYaThink', 'What Do Ya Think?');
	
	$form->addInput(array(
	    'id' => 'tellme',
	    'label' => 'Tell Me',
	    // 'desc' => null,
	    // 'value' => null,
	    // 'size' => 'regular'
	  ));
	
	// Regular textarea
	$form->addTextarea(array(
	    'id' => 'more',
	    'label' => 'Give Me More',
	    // 'desc' => null,
	    // 'value' => null,
	    // 'cols' => 30,
	    // 'rows' => 5,
	    // 'width' => 500
	  ));
	
	// TinyMCE form
	$form->addEditor(array(
	    'id' => 'evenmore',
	    'label' => "Don't Hold Back On Me",
	    // 'desc' => null,
	    // 'value' => null
	  ));
	
### Just a box
	
	$box = new WPElements('post', $isForm = false);
	
	$box->createMetaBox('aBox', 'A Box', 'side');
	
	$box->html('<h3>This is my box</h3>');
	
	$box->paragraph('Please use it, and click my <a href="#">link</a>');