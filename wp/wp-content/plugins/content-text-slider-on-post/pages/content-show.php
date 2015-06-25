<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_ctsop_display']) && $_POST['frm_ctsop_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$ctsop_success = '';
	$ctsop_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_ctsop_TABLE."
		WHERE `ctsop_id` = %d",
		array($did)
	);

	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'content-text-slider'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('ctsop_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_ctsop_TABLE."`
					WHERE `ctsop_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$ctsop_success_msg = TRUE;
			$ctsop_success = __('Selected record was successfully deleted.', 'content-text-slider');
		}
	}
	
	if ($ctsop_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $ctsop_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Content text slider on post', 'content-text-slider'); ?>
	<a class="add-new-h2" href="<?php echo WP_ctsop_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'content-text-slider'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_ctsop_TABLE."` order by ctsop_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_ctsop_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_ctsop_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="width:15px;"><input type="checkbox" name="ctsop_group_item[]" /></th>
			<th scope="col" style="width:15px;"><?php _e('Id', 'content-text-slider'); ?></th>
			<th scope="col" style="width:220px;"><?php _e('Title', 'content-text-slider'); ?></th>
            <th scope="col"><?php _e('Message', 'content-text-slider'); ?></th>
			<th scope="col"><?php _e('Group', 'content-text-slider'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="height:15px;"><input type="checkbox" name="ctsop_group_item[]" /></th>
			<th scope="col" style="width:15px;"><?php _e('Id', 'content-text-slider'); ?></th>
			<th scope="col" style="width:220px;"><?php _e('Title', 'content-text-slider'); ?></th>
            <th scope="col"><?php _e('Message', 'content-text-slider'); ?></th>
			<th scope="col"><?php _e('Group', 'content-text-slider'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['ctsop_id']; ?>" name="ctsop_group_item[]"></td>
					<td><?php echo stripslashes($data['ctsop_id']); ?></td>
					<td><?php echo stripslashes($data['ctsop_title']); ?>
					<div class="row-actions">
					<span class="edit"><a title="Edit" href="<?php echo WP_ctsop_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['ctsop_id']; ?>"><?php _e('Edit', 'content-text-slider'); ?></a> | </span>
					<span class="trash"><a onClick="javascript:ctsop_delete('<?php echo $data['ctsop_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'content-text-slider'); ?></a></span> 
					</div>
					</td>
					<td><?php echo stripslashes($data['ctsop_text']); ?></td>
					<td><?php echo stripslashes($data['ctsop_group']); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="5" align="center"><?php _e('No records available.', 'content-text-slider'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('ctsop_form_show'); ?>
		<input type="hidden" name="frm_ctsop_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_ctsop_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'content-text-slider'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_ctsop_ADMIN_URL; ?>&amp;ac=set"><?php _e('Plugin Setting', 'content-text-slider'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_ctsop_FAV; ?>"><?php _e('Help', 'content-text-slider'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'content-text-slider'); ?></h3>
	<ol>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'content-text-slider'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'content-text-slider'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'content-text-slider'); ?>
		<a target="_blank" href="<?php echo WP_ctsop_FAV; ?>"><?php _e('click here', 'content-text-slider'); ?></a>
	</p>
	</div>
</div>