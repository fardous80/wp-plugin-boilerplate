
<th scrop="row" colspan="2"><h2>Social Networks</h2></th>

<?=wp_nonce_field( 'wpb_nonce', 'location-meta-form')?>

<?php foreach($networks as $key=>$network): ?>
<tr class="form-field">
	<th scrop="row">
		<label><?=$network?>:</label>
	</th>
	<td>
		<input type="text" name="<?=$key?>" value="<?=_sf_meta_value($data, 'location_' . $key, 'http://www.'.$key. 'com/' )?>">
	<td>
</tr>

<?php endforeach; ?>