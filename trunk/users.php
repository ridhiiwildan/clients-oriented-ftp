<?php
	$tablesorter = 1;
	$allowed_levels = array(9);
	require_once('includes/includes.php');
	$page_title = __('Users administration','cftp_admin');;
	include('header.php');
?>

<script type="text/javascript">
$(document).ready(function()
	{
		$("#users_tbl").tablesorter( {
			sortList: [[0,0]], widgets: ['zebra'], headers: {
				6: { sorter: false }, 
			}
		})
		.tablesorterPager({container: $("#pager")})
	}
);
</script>

<div id="main">
	<h2><?php echo $page_title; ?></h2>
	
	<script type="text/javascript">
		function confirm_delete() {
			if (confirm("<?php _e("This will delete the user permanently. Continue?",'cftp_admin'); ?>")) return true ;
			else return false ;
		}
	</script>

<?php
	$database->MySQLDB();
	$sql = $database->query("SELECT * FROM tbl_users");
	$count=mysql_num_rows($sql);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="users_tbl" class="tablesorter">
<thead>
	<tr>
		<th><?php _e('ID','cftp_admin'); ?></th>
		<th><?php _e('Full name','cftp_admin'); ?></th>
		<th><?php _e('Log in username','cftp_admin'); ?></th>
		<th><?php _e('E-mail','cftp_admin'); ?></th>
		<th><?php _e('Role','cftp_admin'); ?></th>
		<th><?php _e('Added on','cftp_admin'); ?></th>
		<th><?php _e('Actions','cftp_admin'); ?></th>
	</tr>
</thead>
<tbody>

<?php
	while($row = mysql_fetch_array($sql)) {
	?>
	<tr>
		<td><?php echo $row["id"]?></td>
		<td><?php echo $row["name"]?></td>
		<td><?php echo $row["user"]?></td>
		<td><?php echo $row["email"]?></td>
		<td><?php
			switch($row["level"]) {
				case '9': echo USER_ROLE_LVL_9; break;
				case '8': echo USER_ROLE_LVL_8; break;
				case '7': echo USER_ROLE_LVL_7; break;
			}
		?>
		</td>
		<td>
			<?php
			$time_stamp=$row['timestamp']; //get timestamp
			$date_format=date($timeformat,$time_stamp); // formats timestamp in mm:dd:yy
			echo $date_format; // results here ... 02 : 11 : 07
			?>
		</td>
		<td>
			<a href="userform.php?do=edit&amp;user=<?php echo $row["id"]; ?>" target="_self">
				<img src="img/icons/edit.png" alt="<?php _e('Edit user','cftp_admin'); ?>">
			</a>
			<?php if ($row["user"] != 'admin') { ?>
				<a onclick="return confirm_delete();" href="process.php?do=del_user&amp;user=<?php echo $row["user"]; ?>" target="_self">
					<img src="img/icons/delete.png" alt="<?php _e('Delete user','cftp_admin'); ?>">
				</a>
			<?php } ?>
		</td>
	</tr>
			
	<?php
	}

	$database->Close();
?>

</tbody>
</table>

<?php if ($count > 10) { ?>
<div id="pager" class="pager">
	<form>
		<input type="button" class="first pag_btn" value="<?php _e('First','cftp_admin'); ?>" />
		<input type="button" class="prev pag_btn" value="<?php _e('Prev.','cftp_admin'); ?>" />
		<span><strong><?php _e('Page','cftp_admin'); ?></strong>:</span>
		<input type="text" class="pagedisplay" disabled="disabled" />
		<input type="button" class="next pag_btn" value="<?php _e('Next','cftp_admin'); ?>" />
		<input type="button" class="last pag_btn" value="<?php _e('Last','cftp_admin'); ?>" />
		<span><strong><?php _e('Show','cftp_admin'); ?></strong>:</span>
		<select class="pagesize">
			<option selected="selected" value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
		</select>
	</form>
</div>
<?php } else { ?>
	<div id="pager">
		<form>
			<input type="hidden" value="<?php echo $count; ?>" class="pagesize" />
		</form>
	</div>
<?php } ?>

</div>

<?php include('footer.php'); ?>