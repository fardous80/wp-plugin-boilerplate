<h2>Social Networks</h2>

<?=wp_nonce_field( 'wpb_nonce', 'location-meta-form')?>

<?php foreach($networks as $key=>$network): ?>

<p>
	<label><?=$network?>:</label>
	<input type="text" name="<?=$key?>" value="http://www.<?=$key?>.com/">
</p>

<?php endforeach; ?>