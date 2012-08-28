### About WP Elements
WP Elements is a series of classes to make building WordPress plugins easy. Whether your creating a meta box or adding navigation menus, it's a breeze.

The demo pages will show you the structure WP Elements classes use and all of the methods inside each class. The commented lines are the optional parameters with their default value.

### Making a form

```php
// Goes on the post page and will be a form box
$form = new metaBox(array(
	  'isFormBox' => true,
	  'type' => 'post',
	  'id' => 'whatDoYaThink',
	  'title' => 'What Do Ya Think?'
	));

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

// TinyMCE form (still very buggy)
$form->addEditor(array(
    'id' => 'evenmore',
    'label' => "Don't Hold Back On Me",
    // 'desc' => null,
    // 'value' => null
  ));
```

### Just a box

```php
$box = new metaBox(array(
	  'type' = 'post',
	  'id' => 'aBox',
	  'title' => 'A Box',
	  'context' => 'side'
	));

$box->html('<h3>This is my box</h3>');

$box->paragraph('Please use it, and click my <a href="#">link</a>');
```
	
### Making a top level navigation menu
Helps to read the WordPress Codex on [Adding Administration Menus](http://codex.wordpress.org/Adding_Administration_Menus)

```php
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

// This will create a subpage under 'What Up'
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
```
	
### Adding sub level navigation items

```php
// This will go under the Dashboard tab
$subPage = new subMenuLink(array(
    'parent_slug' => 'index.php', // slug of dashboard tab
    'page_title' => 'Analytics',
    'menu_title' => 'Analytics',
    'capability' => 'manage_options',
    'menu_slug' => 'what-up-page2',
    'function' => 'analytics'
  ));

function analytics() {
  echo '<div class="wrap"><h2>Your Analytics</h2></div>';
}
```