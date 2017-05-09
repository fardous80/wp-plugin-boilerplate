<style>

	li.ig-img{

		display: inline-block;

		width: 100px;

		height: 100px;

		overflow: hidden;
		
	}

	li.ig-img > img{
		height: 100%;
	}

	.ig-highlight{

		border: 2px solid magenta;
	}

</style>

<!--	

HTML

/-->


<ul id="image_gallery">
	
	<?php if( count($data['images']) > 0 ): foreach($data['images'] as $image): ?>

		<li class="ig-img" data-id="<?=$image['id']?>">
		 	<img src="<?=$image['url']?>">
		</li>

	<?php endforeach; endif; ?>

</ul>

<input type="hidden" name="_sf_image_gallery_ids" value="<?=$data['ids']?>">

<?=wp_nonce_field( '_sf_image_gallery_', 'image-gallery-selector')?>

<button id="btnAddImageToGallery" class="button">Add Image</button>

<button id="btnRemoveImagFromGallery" class="button">Remove Selected</button>

<!--	

JavaScript

/-->

<script>

(function($){

	var wp_image_dialog = null;

	var images = [];

	var ids = [<?=$data['ids']?>];

	var btn_remove_disabled = true;

	btnRemoveState();

	$('body').on('click', '#btnAddImageToGallery', openWpImageDialog);

	$('body').on('click', '.ig-img', highlightImage);

	$('body').on('click', '#btnRemoveImagFromGallery', removeImageFromGallery);

	function openWpImageDialog(e){

		e.preventDefault();

		if(wp_image_dialog) return wp_image_dialog.open();

		wp_image_dialog = wp.media.frames.downloadable_file = wp.media({
            
            // Set the title of the modal.
            title: "<?php _e( 'Add Images to Gallery', '_sf_image_gallery' ); ?>",
            button: {
                text: "<?php _e( 'Add to gallery', '_sf_image_gallery' ); ?>",
            },
            multiple: true
        }).open();

        wp_image_dialog.on( 'select', onSelectImages );

	}

	function onSelectImages(){

		images = wp_image_dialog.state().get('selection').toJSON();


		appendImage();

	}

	function appendImage(){

		images.forEach( image => {

			var li = $('<li class="ig-img" data-id="'+ image.id +'"></li>').appendTo('#image_gallery');

			li.append('<img src="' + image.url + '">');

			ids.push(image.id);

		});

		setGalleryIDs();

	}

	function setGalleryIDs(){
		$('input[name=_sf_image_gallery_ids]').val(ids.join(','));

		console.log(ids);
	}

	function highlightImage(e){

		e.preventDefault();

		$(this).toggleClass('ig-highlight');

		btnRemoveState();
	}

	function btnRemoveState(){

		var selected = 0;

		if($('.ig-img').length){

			$.map($('.ig-img'), function(o){

				if($(o).hasClass('ig-highlight')){

					selected++;
				}

			});
		}

		$('#btnRemoveImagFromGallery').prop('disabled', selected<=0);

	}

	function removeImageFromGallery(e){

		e.preventDefault();

		if($('.ig-img').length){

			ids = [];

			$.map($('.ig-img'), function(o){

				if($(o).hasClass('ig-highlight')){

					$(o).remove();

				}else{

					ids.push($(o).attr('data-id'));
				}

			});

			setGalleryIDs();
		}

	}


}(jQuery))




</script>