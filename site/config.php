<?php
/**
* Site configuration, this file is changed by user per site.
*
*/

/*
* Set level of error reporting
*/
error_reporting(-1);
ini_set('display_errors', 1);

/*
* Define session name
*/
$lanaya->config['session_name'] = preg_replace('/[:\.\/-_]/', '', $_SERVER["SERVER_NAME"]);

/*
* Define server timezone
*/
$lanaya->config['timezone'] = 'Europe/Stockholm';

/*
* Define internal character encoding
*/
$lanaya->config['character_encoding'] = 'UTF-8';

/*
* Define language
*/
$lanaya->config['language'] = 'en';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example:
* the url 'developer/dump' would instantiate the controller with the key "developer", that is
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $lanaya->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$lanaya->config['controllers'] = array(
	'index'     => array('enabled' => true, 'class' => 'CCIndex'),
  	'guestbook' => array('enabled' => true, 'class' => 'CCGuestbook'),
	'user' => array('enabled' => true, 'class' => 'CCUser'),
	'acp' => array('enabled' => true, 'class' => 'CCAdminControlPanel'),
	'content' => array('enabled' => true, 'class' => 'CCContent'),
	'blog' => array('enabled' => true, 'class' => 'CCBlog'),
	'page' => array('enabled' => true, 'class' => 'CCPage'),
	'theme' => array('enabled' => true, 'class' => 'CCTheme'),
	'modules' => array('enabled' => true, 'class' => 'CCModules'),
	'my' => array('enabled' => true, 'class' => 'CCMycontroller'),
);

/**
* Settings for the theme.
* 
* There is alot of different theme exaples to choose from.
* You can also create a own by creating a folder in "site/themes" with your theme name
* In your theme folder create a file called style.css with your stylesheet
* Then change the 'path' in this array to your theme folder.
* Example: 'path' => 'site/themes/Example'
*
* Examples:
* Amelia: 	 "Sweet and cheery."
* Cerulean:  "A calm, blue sky."
* Cosmo: 	 "An ode to Metro."
* Cyborg: 	 "Jet black and electric blue."
* Journal:	 "Crisp like a new sheet of paper."
* Readable:  "Optimized for legibility."
* Simplex:   "Mini and minimalist."
* Slate:	 "Shades of gunmetal gray."
* Spacelab:  "Silvery and sleek."
* Superhero: "Batman meets... Aquaman?"
* United:    "Ubuntu orange and unique font."
* 
* Standard is: 'path'=>'views/grid'
*/
$lanaya->config['theme'] = array(
  	'path'          => 'site/themes/United',
  	'parent'        => 'views/grid',
	'name'        	=> 'grid',        // The name of the theme in the views directory
  	'stylesheet'  	=> 'style.css',   // Main stylesheet to include in template files
  	'template_file'	=> 'index.tpl.php',   // Default template file, else use default.tpl.php
	'regions' => array(
		'header','content','sidebar','footer',
	),
	'menu_to_region'  => array('my-navbar'=>'nav'),
	'data' => array(
		'header' => 'Lanaya',
		'slogan' => 'Lanaya',
		'favicon' => 'logo.jpg',
		'logo' => '',
		'logo_width'  => 31,
		'logo_height' => 31,
		'footer' => '<p>Lanaya &copy; by Andreas Thuresson</p>',
		'title' => 'Lanaya Test site',
	),
);

/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $ly->config['theme'].
 */
$lanaya->config['menus'] = array(
		'nav' => array(
				'home'      => array('url'=>'', 'label'=>'Home'),
				'modules'   => array('url'=>'modules', 'label'=>'Modules'),
				'content'   => array('url'=>'content', 'label'=>'Content'),
				'guestbook' => array('url'=>'guestbook', 'label'=>'Guestbook'),
				'blog'      => array('url'=>'blog', 'label'=>'Blog'),
		),
		'my-navbar' => array(
				'about'     => array('url'=>'my', 'label'=>'About Me'),
				'blog'   	=> array('url'=>'my/blog', 'label'=>'My Blog'),
				'guestbook'	=> array('url'=>'my/guestbook', 'label'=>'My Guestbook'),
		),
);

/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 */
$lanaya->config['routing'] = array(
		'home' => array('enabled' => true, 'url' => 'index/index'),
);

/**
* Set a base_url to use another than the default calculated
*/
$lanaya->config['base_url'] = null;

/**
* What type of urls should be used?
*
* default      = 0      => index.php/controller/method/arg1/arg2/arg3
* clean        = 1      => controller/method/arg1/arg2/arg3
* querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
*/
$lanaya->config['url_type'] = 2;

/**
 * Set database(s).
 */
$lanaya->config['database'][0]['dsn'] = 'sqlite:' . LANAYA_SITE_PATH . '/data/.ht.sqlite';

/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$lanaya->config['debug']['lanaya'] = false;
$lanaya->config['debug']['db-num-queries'] = true;
$lanaya->config['debug']['db-queries'] = false;

/**
 * Session key
 */
$lanaya->config['session_key']  = 'lanaya';

/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$lanaya->config['hashing_algorithm'] = 'sha1salt';

/**
 * Allow or disallow creation of new user accounts.
 */
$lanaya->config['create_new_users'] = true;