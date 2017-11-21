<div id="book_info_metabox">

	<table class="form-table cmb_metabox">
		<tr>
			<th>ISBN</th>
			<td><input type="text" name="isbn" value="<?=_sf_value($info, 'isbn')?>"></td>

		</tr>

	</table>

	<?=wp_nonce_field( 'book_info', 'book-info-form')?>

</div>