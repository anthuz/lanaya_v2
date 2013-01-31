#Lanaya
Lanaya is a PHP framework created by Andreas Thuresson. Lanaya is based on another framework called Lydia, created by Mikael Roos. Lydia can be found at: https://github.com/mosbth/lydia

##Downloading
To clone lanaya use the following command: `git clone git://github.com/anthuz/lanaya_v2.git`

##Installing
First you have to make the data folder writeable. The data folder contains all the database information in Lanaya. To make the folder writeable write:  
`cd lanaya; chmod 777 site/data`
	

###.htaccess
The Rewrite option must be changed if you want to run Lanaya from another directory than root on a web server. Simply remove the comment tag and link to the Lanaya directory.
`RewriteBase /change/this/to/Lanaya/folder`
	

###Initialize modules
The modules in Lanaya is used for the user, content and guestbook. You need to initialize them by entering the following link:
`/modules/install`
	
##Configuration
The configuration file can be found in the folder `site/config.php`. It contains information for controllers, themes, menus, routing, title, logo, footer, etc...

###Change title of the page
Just change the value of ***title*** inside the data array: `'title' => 'YOUR TITLE',`

###Change logo
Just change the value of ***favicon*** inside the data array: `'favicon' => 'logo.jpg',`

###Change footer
Just change the value of ***footer*** inside the data array: `'footer' => '<p>YOUR FOOTER</p>',`

### Add a controller
To add a controller you have to change the controllers array in config.php. This is an example of adding a contoller:
`'example' => array('enabled' => true, 'class' => 'CCExample'),`

This will make it possible to reach the controller from `lanaya_v2/example`. The PHP file must use the name CCExample and you can choose to enable or disable the controller.

###Add a menu
Create a new array inside the "menus" array in the configuration file. The name of your menu will be used inside the "theme" array to add the menu.

	'examle-navbar' => array(
	  'about'     => array('url'=>'my', 'label'=>'About Me'),
	  'blog'   	=> array('url'=>'my/blog', 'label'=>'My Blog'),
	  'guestbook'	=> array('url'=>'my/guestbook', 'label'=>'My Guestbook'),
	),

This will create a menu with the tabs about, blog and guestbook. To add this menu to the site you have to change the value of **menu_to_region** in the theme array. Change it to:
`'menu_to_region'  => array('example_navbar'=>'nav'),`

**nav** is the name of the div element for the element so do not change that. Only change the first value in the array.

###Routing
You can create your own links to a controller by changing the values inside the rouing array. Example:
`'home' => array('enabled' => true, 'url' => 'index/index'),`

The link `lanaya_v2/home` will now point to the controller index and the method index.

##Add pages and blog post
You can add pages or blog post from `/content/create`. Just fill in information in the form and press the create button. Title is the header of the page, key is a field to make the 
page/post unique, type can be page or post, filter can be plain(just text) or bbcode(some characters in the text will translate to html code).

You can view all the pages you have add at `http://localhost/lanaya_refinstall/content`. Here you can see their ID, name and who the creator is. You can also delete and edit pages/posts. If you want to use one of those pages in the menu you have to link to their id!
For example: 

	'examle-navbar' => array(
	  'about'     => array('url'=>'4', 'label'=>'Home'),
	),
	
This will add a menu with one link to the home page wich has id 4. You can also use Routing to create a better url to the page

All blog post can be viewed on the page `/blog`.

##An example controller
Look at the example `https://github.com/anthuz/lanaya_v2/tree/master/site/controllers/CCMycontroller/CCMycontroller.php`.