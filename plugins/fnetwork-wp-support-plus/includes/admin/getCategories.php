<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<div id="catDisplayTableContainer" class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th><?php _e('Category Name','wp-support-plus-responsive');?></th>
			<th><?php _e('Action','wp-support-plus-responsive');?></th>
		</tr>
		<?php foreach ($categories as $category){?>
			<tr>
				<td><?php _e($category->name,'wp-support-plus-responsive');?></td>
				<td>
					<?php if($category->id!=1){?>
					<img alt="Edit" onclick="editCategory(<?php echo $category->id;?>,'<?php echo $category->name;?>');" class="catEdit" title="Edit" src="<?php echo WCE_PLUGIN_URL.'asset/images/edit.png';?>" />
					<img alt="Edit" onclick="deleteCategory(<?php echo $category->id;?>,'<?php echo $category->name;?>');" class="catDelete" title="Delete" src="<?php echo WCE_PLUGIN_URL.'asset/images/delete.png';?>" />
					<?php }?>
				</td>
			</tr>
		<?php }?>
	</table>
</div>
<div id="createCategoryContainer">
<input id="newCatName" class="form-control" type="text" placeholder="<?php _e('Enter Category Name','wp-support-plus-responsive');?>" >
	<button class="btn btn-success" onclick="createNewCategory();"><?php _e('Create New Category','wp-support-plus-responsive');?></button>
</div>
<div id="editCategoryContainer">
	<input type="hidden" id="editCatID" value="">
	<input id="editCatName" class="form-control" type="text" >
	<button onclick="updateCategory();" class="btn btn-success"><?php _e('Update Category','wp-support-plus-responsive');?></button>
</div>