<?php 
	$wf_task_status = get_wf_task_state_list();
 ?>
 <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('wf_page_header_workflow_my_tasks'); ?>
    </div>
    <div class="card-body">
	<p class = "text-right">
        <?php echo Html::anchor('workflow_validation_leave', '<i class = "fa fa-th-list"></i> ' . __tr('wf_page_header_workflow_instances'), array('class' => 'btn btn-sm btn-secondary'));?>
   </p>
	<?php if(!empty($list)):?>
			<table class="table table-hover table-sm table-bordered">
			  <thead>
			  <tr>
					<th><?php echo __tr('wf_field_task_id'); ?></th>
					<th><?php echo __tr('wf_field_task_node'); ?></th>
					<th><?php echo __tr('wf_field_task_state'); ?></th>
					<th><?php echo __tr('wf_field_inst_desc'); ?></th>
					<th><?php echo __tr('wf_field_task_start_time'); ?></th>
					<th><?php echo __tr('wf_field_task_end_time'); ?></th>
					<th><?php echo __tr('wf_field_inst_entity_id'); ?></th>
					<th><?php echo __tr('wf_field_inst_entity_name'); ?></th>
					<th><?php echo __tr('wf_field_inst_start_comment'); ?></th>
					<th><?php echo __tr('wf_field_inst_start_by'); ?></th>
					<th><?php echo __tr('wf_field_workflow'); ?></th>
					<th><?php echo __tr('wf_txt_action'); ?></th>
				</tr>
			</thead>
				<?php foreach($list as $l): ?>
				<tr>
					<td><?php echo $l->wf_inst_id;?></td>
					<td><?php echo $l->wf_node_name;?></td>
					<td><?php echo isset($wf_task_status[$l->wf_task_status]) ? $wf_task_status[$l->wf_task_status] : '';?></td>
					<td><?php echo $l->wf_inst_desc;?></td>
					<td><?php echo $l->wf_task_start_time;?></td>
					<td><?php echo $l->wf_task_end_time;?></td>
					<td><?php echo $l->wf_inst_entity_id;?></td>
					<td><?php echo $l->wf_inst_entity_name;?></td>
					<td><?php echo $l->wf_inst_start_comment;?></td>
					<td><?php echo $l->user_name;?></td>
					<td><?php echo $l->wf_name;?></td>
					<td>
						<?php echo Html::anchor('workflow_validation_leave/detail/'.$l->wf_inst_id, '<i class = "fa fa-eye"></i> ' . __tr('wf_txt_detail'), array('class' => 'btn btn-sm btn-secondary'));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		<?php else:?>
			<p class = "alert alert-info"><?php echo __tr('wf_txt_database_no_data'); ?></p>
		<?php endif;?>
	</div>
</div>
