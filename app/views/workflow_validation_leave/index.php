<?php 
	$wf_status = get_wf_instance_state_list();
 ?>
 <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('wf_page_header_workflow_instances'); ?>
    </div>
    <div class="card-body">
	<?php if(!empty($list)):?>
			<table class="table table-hover table-sm table-bordered">
			  <thead>
			  <tr>
					<th><?php echo __tr('wf_field_inst_id'); ?></th>
					<th><?php echo __tr('wf_field_inst_desc'); ?></th>
					<th><?php echo __tr('wf_field_inst_start_date'); ?></th>
					<th><?php echo __tr('wf_field_inst_end_date'); ?></th>
					<th><?php echo __tr('wf_field_inst_state'); ?></th>
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
					<td><?php echo $l->wf_inst_desc;?></td>
					<td><?php echo $l->wf_inst_start_date;?></td>
					<td><?php echo $l->wf_inst_end_date;?></td>
					<td><?php echo isset($wf_status[$l->wf_inst_state]) ? $wf_status[$l->wf_inst_state] : '';?></td>
					<td><?php echo $l->wf_inst_entity_id;?></td>
					<td><?php echo $l->wf_inst_entity_name;?></td>
					<td><?php echo $l->wf_inst_start_comment;?></td>
					<td><?php echo $l->start_user_name;?></td>
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
