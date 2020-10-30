<?php 
	$states = array(
		'0' => __tr('leav_txt_state_invalide'),
		'1' => __tr('leav_txt_state_valid')
	);
 ?>
 <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('leav_page_header_list'); ?>
    </div>
    <div class="card-body">
		<p class = "text-right">
			<?php echo Html::anchor('leave/add', '<i class = "fa fa-plus-circle"></i> ' . __tr('leav_txt_create'), array('class' => 'btn btn-sm btn-success'));?>
		</p>
		<?php if(!empty($list)):?>
			<?php echo Form::open('leave/delete', array('class' => 'form'));?>
			<table class="table table-hover table-sm table-bordered">
			  <thead>
			  <tr>
					<th><?php echo __tr('leav_field_id'); ?></th>
					<th><?php echo __tr('leav_field_desc'); ?></th>
					<th><?php echo __tr('leav_field_start_date'); ?></th>
					<th><?php echo __tr('leav_field_end_date'); ?></th>
					<th><?php echo __tr('leav_field_state'); ?></th>
					<th><?php echo __tr('leav_field_workflow'); ?></th>
					<th><?php echo __tr('leav_txt_delete'); ?></th>
					<th><?php echo __tr('leav_txt_action'); ?></th>
				</tr>
			</thead>
				<?php foreach($list as $l): ?>
				<tr>
					<td><?php echo $l->leav_id;?></td>
					<td><?php echo $l->leav_desc;?></td>
					<td><?php echo $l->leav_bdate;?></td>
					<td><?php echo $l->leav_edate;?></td>
					<td><?php echo $states[$l->leav_state];?></td>
					<td><?php echo !empty($l->workflow) ? $l->workflow->wf_name : '';?></td>
					<td>
						<?php echo Form::checkbox('ids[]', $l->leav_id);?>
					</td>
					<td  class="actions">
						<?php echo Html::anchor('leave/update/'.$l->leav_id, '<i class = "fa fa-edit"></i> ' . __tr('leav_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
						<?php echo Html::anchor('leave/detail/'.$l->leav_id, '<i class = "fa fa-eye"></i> ' . __tr('leav_txt_detail'), array('class' => 'btn btn-sm btn-secondary'));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<div class = 'form-group text-right'>
	            <?php echo Form::submit('submit', __tr('leav_txt_delete'), array('class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("'.__tr('leav_txt_delete_selected_data_warning').'")'));?>
			</div>
			<?php echo Form::close();?>
		<?php else:?>
			<p class = "alert alert-info"><?php echo __tr('leav_txt_database_no_data'); ?></p>
		<?php endif;?>
	</div>
</div>
