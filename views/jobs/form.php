<h2>Hello from form</h2>

<?=wp_nonce_field( 'wpb_nonce', 'job-form')?>

<p>
	<label>Job ID:</label>
	<input type="text" name="job_id" value="<?=_sf_meta_value($data, 'job_id')?>">
</p>