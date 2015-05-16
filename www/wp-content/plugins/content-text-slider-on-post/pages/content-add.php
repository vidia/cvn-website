<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$ctsop_errors = array();
$ctsop_success = '';
$ctsop_error_found = FALSE;

// Preset the form fields
$form = array(
	'ctsop_text' => '',
	'ctsop_title' => '',
	'ctsop_link' => '',
	'ctsop_order' => '',
	'ctsop_status' => '',
	'ctsop_group' => '',
	'ctsop_id' => ''
);

// Form submitted, check the data
if (isset($_POST['ctsop_form_submit']) && $_POST['ctsop_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('ctsop_form_add');
	
	$form['ctsop_text'] = isset($_POST['ctsop_text']) ? $_POST['ctsop_text'] : '';
	if ($form['ctsop_text'] == '')
	{
		$ctsop_errors[] = __('Please enter the message.', 'content-text-slider');
		$ctsop_error_found = TRUE;
	}
	
	$form['ctsop_title'] = isset($_POST['ctsop_title']) ? $_POST['ctsop_title'] : '';
	$form['ctsop_link'] = isset($_POST['ctsop_link']) ? $_POST['ctsop_link'] : '';
	$form['ctsop_status'] = isset($_POST['ctsop_status']) ? $_POST['ctsop_status'] : '';
	$form['ctsop_group'] = isset($_POST['ctsop_group']) ? $_POST['ctsop_group'] : '';
	if ($form['ctsop_group'] == '')
	{
		$ctsop_errors[] = __('Please select your group.', 'content-text-slider');
		$ctsop_error_found = TRUE;
	}
	
	$form['ctsop_order'] = isset($_POST['ctsop_order']) ? $_POST['ctsop_order'] : '';

	//	No errors found, we can add this Group to the table
	if ($ctsop_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_ctsop_TABLE."`
			(`ctsop_text`, `ctsop_title`, `ctsop_link`, `ctsop_order`, `ctsop_status`, `ctsop_group`)
			VALUES(%s, %s, %s, %s, %s, %s)",
			array($form['ctsop_text'], $form['ctsop_title'], $form['ctsop_link'], $form['ctsop_order'], $form['ctsop_status'], $form['ctsop_group'])
		);
		$wpdb->query($sql);
		
		$ctsop_success = __('New details was successfully added.', 'content-text-slider');
		
		// Reset the form fields
		$form = array(
			'ctsop_text' => '',
			'ctsop_title' => '',
			'ctsop_link' => '',
			'ctsop_order' => '',
			'ctsop_status' => '',
			'ctsop_group' => '',
			'ctsop_id' => ''
		);
	}
}

if ($ctsop_error_found == TRUE && isset($ctsop_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $ctsop_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($ctsop_error_found == FALSE && strlen($ctsop_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $ctsop_success; ?> 
		<a href="<?php echo WP_ctsop_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'content-text-slider'); ?></a></strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo WP_ctsop_PLUGIN_URL; ?>/pages/setting.js"></script>
<script language="JavaScript" src="<?php echo WP_ctsop_PLUGIN_URL; ?>/pages/noenter.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Content text slider on post', 'content-text-slider'); ?></h2>
	<form name="ctsop_form" method="post" action="#" onsubmit="return ctsop_submit()"  >
      <h3><?php _e('Add details', 'content-text-slider'); ?></h3>
      
		<label for="tag-title"><?php _e('Title', 'content-text-slider'); ?></label>
		<input name="ctsop_title" type="text" id="ctsop_title" value="" size="103" />
		<p><?php _e('Enter your title.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Message/Content', 'content-text-slider'); ?></label>
		<textarea name="ctsop_text" id="ctsop_text" cols="100" rows="5"></textarea>
		<p><?php _e('Enter your message/content.', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Link', 'content-text-slider'); ?></label>
		<input name="ctsop_link" type="text" id="ctsop_link" value="" size="103" />
		<p><?php _e('Enter your link.', 'content-text-slider'); ?></p>
	  
	  	<label for="tag-title"><?php _e('Display status', 'content-text-slider'); ?></label>
		<select name="ctsop_status" id="ctsop_status">
			<option value="">Select</option>
            <option value='YES'>Yes</option>
            <option value='NO'>No</option>
          </select>
		<p><?php _e('Do you want to show this message in the slider?', 'content-text-slider'); ?></p>
		
		<label for="tag-title"><?php _e('Group name', 'content-text-slider'); ?></label>
		<select name="ctsop_group" id="ctsop_group">
		<option value="">Select</option>
		<?php
		$sSql = "SELECT distinct(ctsop_group) as ctsop_group FROM `".WP_ctsop_TABLE."` order by ctsop_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["ctsop_group"] = strtoupper($DistinctData['ctsop_group']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["ctsop_group"] = "GROUP" . $j;
		}
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo $arrDistinct["ctsop_group"]; ?>'><?php echo $arrDistinct["ctsop_group"]; ?></option><?php
		}
		?>
		</select>
		<p></p>
		
		<label for="tag-title"><?php _e('Order', 'content-text-slider'); ?></label>
		<input name="ctsop_order" type="text" id="ctsop_order" value="0" maxlength="3" />
		<p><?php _e('Enter your display order, only number.', 'content-text-slider'); ?></p>
	  
      <input name="ctsop_id" id="ctsop_id" type="hidden" value="">
      <input type="hidden" name="ctsop_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'content-text-slider'); ?>" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="ctsop_redirect()" value="<?php _e('Cancel', 'content-text-slider'); ?>" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="ctsop_help()" value="<?php _e('Help', 'content-text-slider'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('ctsop_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'content-text-slider'); ?>
	<a target="_blank" href="<?php echo WP_ctsop_FAV; ?>"><?php _e('click here', 'content-text-slider'); ?></a>
</p>
</div>