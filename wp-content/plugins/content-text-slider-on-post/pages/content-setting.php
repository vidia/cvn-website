<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Content text slider on post', 'content-text-slider'); ?></h2>
    <?php
	$ctsop_height_display_length_s1 = get_option('ctsop_height_display_length_s1');
	$ctsop_height_display_length_s2 = get_option('ctsop_height_display_length_s2');
	$ctsop_height_display_length_s3 = get_option('ctsop_height_display_length_s3');
	
	$ctsop_height_display_length_s1_new = explode("_", $ctsop_height_display_length_s1);
	$ctsop_height_1 = @$ctsop_height_display_length_s1_new[0];
	$ctsop_display_1 = @$ctsop_height_display_length_s1_new[1];
	$ctsop_length_1 = @$ctsop_height_display_length_s1_new[2];
	
	$ctsop_height_display_length_s2 = explode("_", $ctsop_height_display_length_s2);
	$ctsop_height_2 = @$ctsop_height_display_length_s2[0];
	$ctsop_display_2 = @$ctsop_height_display_length_s2[1];
	$ctsop_length_2 = @$ctsop_height_display_length_s2[2];
	
	$ctsop_height_display_length_s3 = explode("_", $ctsop_height_display_length_s3);
	$ctsop_height_3 = @$ctsop_height_display_length_s3[0];
	$ctsop_display_3 = @$ctsop_height_display_length_s3[1];
	$ctsop_length_3 = @$ctsop_height_display_length_s3[2];
	
	if (isset($_POST['ctsop_form_submit']) && $_POST['ctsop_form_submit'] == 'yes')
	{
		$ctsop_height_1 = stripslashes($_POST['ctsop_height_1']);
		$ctsop_display_1 = stripslashes($_POST['ctsop_display_1']);
		$ctsop_length_1 = stripslashes($_POST['ctsop_length_1']);
		
		$ctsop_height_2 = stripslashes($_POST['ctsop_height_2']);
		$ctsop_display_2 = stripslashes($_POST['ctsop_display_2']);
		$ctsop_length_2 = stripslashes($_POST['ctsop_length_2']);
		
		$ctsop_height_3 = stripslashes($_POST['ctsop_height_3']);
		$ctsop_display_3 = stripslashes($_POST['ctsop_display_3']);
		$ctsop_length_3 = stripslashes($_POST['ctsop_length_3']);
		
		$ctsop_height_display_length_s1 = $ctsop_height_1 . "_" . $ctsop_display_1. "_" . $ctsop_length_1;
		$ctsop_height_display_length_s2 = $ctsop_height_2 . "_" . $ctsop_display_2. "_" . $ctsop_length_2;
		$ctsop_height_display_length_s3 = $ctsop_height_3 . "_" . $ctsop_display_3. "_" . $ctsop_length_3;
		
		update_option('ctsop_height_display_length_s1', $ctsop_height_display_length_s1 );
		update_option('ctsop_height_display_length_s2', $ctsop_height_display_length_s2 );
		update_option('ctsop_height_display_length_s3', $ctsop_height_display_length_s3 );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'content-text-slider'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_ctsop_PLUGIN_URL; ?>/pages/setting.js"></script>
	<form name="ctsop_form" method="post" action="">
		
		<h3><?php _e('Setting 1', 'content-text-slider'); ?></h3>
		
		<label for="tag-title"><?php _e('Record height in scroll', 'content-text-slider'); ?></label>
		<input name="ctsop_height_1" type="text" id="ctsop_height_1" value="<?php echo $ctsop_height_1; ?>" maxlength="4" />
		<p><?php _e('This is the height of the each record in the scroll.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Display records', 'content-text-slider'); ?></label>
		<input name="ctsop_display_1" type="text" id="ctsop_display_1" value="<?php echo $ctsop_display_1; ?>" maxlength="4" />
		<p><?php _e('No of records you want to show in the screen at same time.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Text Length', 'content-text-slider'); ?></label>
		<input name="ctsop_length_1" type="text" id="ctsop_length_1" value="<?php echo $ctsop_length_1; ?>" maxlength="4" />
		<p><?php _e('This is to maintain the record description length in the scroll.', 'content-text-slider'); ?></p>
		
		<h3><?php _e('Setting 2', 'content-text-slider'); ?></h3>
		
		<label for="tag-title"><?php _e('Record height in scroll', 'content-text-slider'); ?></label>
		<input name="ctsop_height_2" type="text" id="ctsop_height_2" value="<?php echo $ctsop_height_2; ?>" maxlength="4" />
		<p><?php _e('This is the height of the each record in the scroll.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Display records', 'content-text-slider'); ?></label>
		<input name="ctsop_display_2" type="text" id="ctsop_display_2" value="<?php echo $ctsop_display_2; ?>" maxlength="4" />
		<p><?php _e('No of records you want to show in the screen at same time.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Text Length', 'content-text-slider'); ?></label>
		<input name="ctsop_length_2" type="text" id="ctsop_length_2" value="<?php echo $ctsop_length_2; ?>" maxlength="4" />
		<p><?php _e('This is to maintain the record description length in the scroll.', 'content-text-slider'); ?></p>
		
		<h3><?php _e('Setting 3', 'content-text-slider'); ?></h3>
		
		<label for="tag-title"><?php _e('Record height in scroll', 'content-text-slider'); ?></label>
		<input name="ctsop_height_3" type="text" id="ctsop_height_3" value="<?php echo $ctsop_height_3; ?>" maxlength="4" />
		<p><?php _e('This is the height of the each record in the scroll.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Display records', 'content-text-slider'); ?></label>
		<input name="ctsop_display_3" type="text" id="ctsop_display_3" value="<?php echo $ctsop_display_3; ?>" maxlength="4" />
		<p><?php _e('No of records you want to show in the screen at same time.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Text Length', 'content-text-slider'); ?></label>
		<input name="ctsop_length_3" type="text" id="ctsop_length_3" value="<?php echo $ctsop_length_3; ?>" maxlength="4" />
		<p><?php _e('This is to maintain the record description length in the scroll.', 'content-text-slider'); ?></p>
		
		
		<div style="height:5px;"></div>
		<input type="hidden" name="ctsop_form_submit" value="yes"/>
		<input name="ctsop_submit" id="ctsop_submit" class="button add-new-h2" value="<?php _e('Submit', 'content-text-slider'); ?>" type="submit" />&nbsp;
		<input name="publish" lang="publish" class="button add-new-h2" onclick="ctsop_redirect()" value="<?php _e('Cancel', 'content-text-slider'); ?>" type="button" />&nbsp;
		<input name="Help" lang="publish" class="button add-new-h2" onclick="ctsop_help()" value="<?php _e('Help', 'content-text-slider'); ?>" type="button" />
		<div style="height:5px;"></div>
		<?php wp_nonce_field('ctsop_form_setting'); ?>
    </form>
	 </div>
<p class="description">
	<?php _e('Check official website for more information', 'content-text-slider'); ?>
	<a target="_blank" href="<?php echo WP_ctsop_FAV; ?>"><?php _e('click here', 'content-text-slider'); ?></a>
</p>
</div>