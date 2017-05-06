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

[ ] Template Tags

[ ] Store Options

[ ] Database Connectivity

[ ] Widgetize

[ ] Admin Panel