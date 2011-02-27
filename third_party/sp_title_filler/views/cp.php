<?php // We'll use a hidden field to keep track of the new number ?>
<input type="hidden" name="<?=$form_name?>" value="<?=$next_number?>" id="sp_title_filler" />

<?php // Output the JS that performs the title filling ?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		// Fill the title in
		$('#title').val("<?=$channel_title?> " + $('#sp_title_filler').val());
		
		// Remove this badboy
		$('div.publish_field.publish_sp_title_filler').hide();
	});
</script>