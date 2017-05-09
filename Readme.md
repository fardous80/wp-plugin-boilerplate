# ~~~~~~~~~~~~ FOR TESTING ONLY ~~~~~~~~~~~~~

# WORDPRESS PLUGIN BOILERPLATE

#### A Boilerplate for quick Wordpress plugin creation

## Installation

```
	git clone https://github.com/fardous80/wp-plugin-boilerplate.git plugin_name

```

## Usage

- app/Back.php deals with Backend

- app/Front.php deals with Frontend


## Create a Custom Post Type

------------------------------------------------------------------
> Create a Custom Post Type **Book**
------------------------------------------------------------------

In 'app/Back.php' add the following lines

```php

	w::Post('book', 'Book')
		->register();

```

'book': post_type
'Book': Label

*Both required

You can pass more parameters by simply chaining them

```php

	w::Post('book', 'Book')
		->plural('Books')
		->labels(['all_items' => 'All Books'])
		->args([
			'supports' => ['title', 'thumbnail'],
			'rewrite' => true,
		])
		->register();

```

------------------------------------------------------------------
> Creating **MetaBox** for Book Post Type
------------------------------------------------------------------

```php
	
	w::MetaBox('book_attributes', 'Book Attributes')
		->belongsTo('book')
		->attach( function($post){

			$isbn = 'ZZZZZZZZZZ';

			echo _sf_view('test.form', compact('isbn'));

		})
		->save(function($post_id){

			_sf_verify_nonce('nonce_id', 'nonce_value');

			if( $isbn = _sf_post('isbn') ) {

				update_post_meta($post_id, 'isbn', $isbn);

			}

		});

```

Create 'form.php' in 'views/test/' folder and put the following lines

```html

	<?=wp_nonce_field( 'nonce_id', 'nonce_value')?>
	
	<p>
		<label>ISBN</label>

		<input type="text" name="isbn" value="<?=$isbn?>">
	</p>

```


## A Component for attaching Images to Post

```php

	c::ImageGallery('book_image_gallery', 'Image Gallery', 'book');

```

## set taxonomy for custom post type

```php

w::Taxonomy('book-category', 'Category')
	->plural('Categories')
	->belongsTo('book')
	->register();

```

##


```php

w::TermMeta('book-category')

	->create(function(){

		echo _sf_view('template', $data);

	})

	->save(function($term_id) {

		// create term

	})

	->edit(function($term){

		// edit form

	})

	->update(function($term_id){

		// update term
	});

```
