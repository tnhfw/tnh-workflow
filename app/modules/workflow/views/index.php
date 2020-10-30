<?php 
	$wf_status = get_wf_state_list();
 ?>
 <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('wf_page_header_workflow_list'); ?>
    </div>
    <div class="card-body">
		<p class = "text-right">
			<?php echo Html::anchor('workflow/add', '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_create'), array('class' => 'btn btn-sm btn-success'));?>
		</p>
		<?php if(!empty($list)):?>
			<?php echo Form::open('workflow/delete', array('class' => 'form'));?>
			<table class="table table-hover table-sm table-bordered">
			  <thead>
			  <tr>
					<th><?php echo __tr('wf_field_workflow_id'); ?></th>
					<th><?php echo __tr('wf_field_workflow_name'); ?></th>
					<th><?php echo __tr('wf_field_workflow_desc'); ?></th>
					<th><?php echo __tr('wf_field_workflow_state'); ?></th>
					<th><?php echo __tr('wf_txt_delete'); ?></th>
					<th><?php echo __tr('wf_txt_action'); ?></th>
				</tr>
			</thead>
				<?php foreach($list as $l): ?>
				<tr>
					<td><?php echo $l->wf_id;?></td>
					<td><?php echo $l->wf_name;?></td>
					<td><?php echo $l->wf_desc;?></td>
					<td><?php echo $wf_status[$l->wf_status];?></td>
					<td>
						<?php echo Form::checkbox('ids[]', $l->wf_id);?>
					</td>
					<td>
						<?php echo Html::anchor('workflow/update/'.$l->wf_id, '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
						<?php echo Html::anchor('workflow/detail/'.$l->wf_id, '<i class = "fa fa-eye"></i> ' . __tr('wf_txt_detail'), array('class' => 'btn btn-sm btn-secondary'));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<div class = 'form-group text-right'>
	            <?php echo Form::submit('submit', __tr('wf_txt_delete'), array('class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("'.__tr('wf_txt_delete_selected_data_warning').'")'));?>
			</div>
			<?php echo Form::close();?>
		<?php else:?>
			<p class = "alert alert-info"><?php echo __tr('wf_txt_database_no_data'); ?></p>
		<?php endif;?>
		<br />
	</div>
</div>
