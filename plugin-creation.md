# WORDPRESS PLUGIN CREATION

#### Generate and Use PHP Composer, treat plugin as component

- **Resources**
	- [doc] (https://codex.wordpress.org/Writing_a_Plugin)
	- [handbook] (https://developer.wordpress.org/plugins/)
	- [youtube] (https://www.youtube.com/watch?v=tSblOUw97Mc&list=PLIjMj0-5C8TI7Jwell1rTvv5XXyrbKDcy)

[x] Create a Plugin that will appear inside the top header at the homepage

	- create a folder with a unique name inside plugin directory

	- create a php file inside the directory.

	- it's good practice to name the main file as the plugin name, but it isn't necessary

	- Now put these three lines inside the main file right after the php tag
```

	/**
	 * Plugin Name: WP Plugin Boilerplate
	 * Plugin URI: http://www.site.com
	 * Description: A Boilerplace for Wordpress Plugin
	 * Author: Author Name
	 * Version: 0.00.01
	 * License: MIT
	 */

```
	- Now the plugin should appear in the dashboard
	- Activate the plugin

[x] Init Composer

	- run 'Composer init' to generate composer.json file
	- now add the following lines to the file

```
	"autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }

```
	
	- in the main plugin php file

```php

	require __DIR__.'/../vendor/autoload.php';

	new App\App();


```

	- composer dump-autoload

	- run "php main.php" to check if it's working

## Action

#### Wordpress fires events at various stages of it's lifecycles, you can hook an action to be executed before or after an event

[x] Add Action

- Wordpress fires events at various stages of it's lifecycles, you can hook an action to be executed before or after an event
- use add_action function to attach an action to a hook
- to remove "wordpress news" from dashboard use

```php

add_action('wp_dashboard_setup', function(){

	remove_meta_box('dashboard_primary', 'dashboard', 'side');
});

```
## Filter

#### Filter is used to modify data

[*] Add Filter

- this filter is used to change country name from UK to BD

```php
	
	add_filter('country', function($country){
		return 'BD';
	}, 2);

	add_filter('country', function($country){
		return 'PK';
	}, 1);


	// call filter

	$country = apply_filters('country', 'UK');

	echo 'changed UK to ' . $country;

```

- although last filter is PK, BD is applied since it has higher priority number: 2


[ ] Template Tags

[ ] Store Options

[ ] Database Connectivity

[ ] Widgetize

[ ] Admin Panel