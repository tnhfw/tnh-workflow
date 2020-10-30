<?php 
	$wf_status = get_wf_state_list();
	$wf_task_types = get_wf_task_type_list();
	$wf_node_types = get_wf_node_type_list();
 ?>
  <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo sprintf(__tr('wf_page_header_workflow_node_detail'), $node->wf_node_name); ?>
    </div>
    <div class="card-body">
		<p class = "text-right">
			<?php echo Html::anchor('workflow', '<i class = "fa fa-th-list"></i> ' . __tr('wf_page_header_workflow_list'), array('class' => 'btn btn-sm btn-secondary'));?>
			<?php echo Html::anchor('workflow/detail/' . $node->wf_id, '<i class = "fa fa-th-list"></i> ' . __tr('wf_txt_workflow_detail'), array('class' => 'btn btn-sm btn-info'));?>
		</p>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-hover table-sm table-bordered detail">
					<tr>
						<th><?php echo __tr('wf_field_node_id'); ?></th>
						<td><?php echo $node->wf_node_id;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_name'); ?></th>
						<td><?php echo $node->wf_node_name;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_task_type'); ?></th>
						<td><?php echo $wf_task_types[$node->wf_node_task_type];?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_type'); ?></th>
						<td><?php echo $wf_node_types[$node->wf_node_type];?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_validation_role'); ?></th>
						<td><?php echo $node->wf_role_name;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_script'); ?></th>
						<td><?php echo nl2br($node->wf_node_script);?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_service'); ?></th>
						<td><?php echo $node->wf_node_service;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_node_state'); ?></th>
						<td><?php echo $wf_status[$node->wf_node_status];?></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo Html::anchor('workflow/node_update/'.$node->wf_node_id .'?from_detail=1', '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br />
		<?php if(isset($outcomes)): ?>
			<h4><b><?php echo __tr('wf_page_header_workflow_node_detail_outcomes'); ?></b></h4>
			<p class = "text-right">
				<?php echo Html::anchor('workflow/outcome_add/' . $node->wf_node_id, '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_workflow_node_add_outcome'), array('class' => 'btn btn-sm btn-success'));?>
			</p>
			<?php if(!empty($outcomes)):?>
				<?php echo Form::open('workflow/outcome_delete', array('class' => 'form'));?>
				<table class="table table-hover table-sm table-bordered">
				  <thead>
				  <tr>
						<th><?php echo __tr('wf_field_node_oc_id'); ?></th>
						<th><?php echo __tr('wf_field_node_oc_code'); ?></th>
						<th><?php echo __tr('wf_field_node_oc_name'); ?></th>
						<th><?php echo __tr('wf_txt_delete'); ?></th>
						<th><?php echo __tr('wf_txt_action'); ?></th>
					</tr>
				</thead>
					<?php foreach($outcomes as $l): ?>
					<tr>
						<td><?php echo $l->wf_oc_id;?></td>
						<td><?php echo $l->wf_oc_code;?></td>
						<td><?php echo $l->wf_oc_name;?></td>
						<td>
							<?php echo Form::checkbox('ids[]', $l->wf_oc_id);?>
						</td>
						<td>
							<?php echo Html::anchor('workflow/outcome_update/'.$l->wf_oc_id, '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
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
		<?php endif; ?>
	</div>
</div>
