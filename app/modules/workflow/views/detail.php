<?php 
	$wf_status = get_wf_state_list();
	$wf_task_types = get_wf_task_type_list();
	$wf_node_types = get_wf_node_type_list();
	$wf_node_path_conditions_type = get_wf_node_path_condition_type_list();
 ?>
 <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo sprintf(__tr('wf_page_header_workflow_detail'), $wf->wf_name); ?>
    </div>
    <div class="card-body">
		<p class = "text-right">
			<?php echo Html::anchor('workflow', '<i class = "fa fa-th-list"></i> ' . __tr('wf_page_header_workflow_list'), array('class' => 'btn btn-sm btn-secondary'));?>
			<?php echo Html::anchor('workflow/add', '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_create'), array('class' => 'btn btn-sm btn-success'));?>
		</p>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-hover table-sm table-bordered detail">
					<tr>
						<th><?php echo __tr('wf_field_workflow_id'); ?></th>
						<td><?php echo $wf->wf_id;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_workflow_name'); ?></th>
						<td><?php echo $wf->wf_name;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_workflow_desc'); ?></th>
						<td><?php echo $wf->wf_desc;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('wf_field_workflow_state'); ?></th>
						<td><?php echo $wf_status[$wf->wf_status];?></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo Html::anchor('workflow/update/'.$wf->wf_id . '?from_detail=1', '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-12">
				<br />
				<?php echo build_flowchart($nodes_path); ?>
			</div>
		</div>
		<br />
		<br />
		<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="roles-tab" data-toggle="tab" href="#roles-content" role="tab" aria-controls="roles" aria-selected="false"><?php  echo __tr('wf_page_header_workflow_detail_roles');?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="nodes-tab" data-toggle="tab" href="#nodes-content" role="tab" aria-controls="nodes" aria-selected="true"><?php  echo __tr('wf_page_header_workflow_detail_nodes');?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="nodes-path-tab" data-toggle="tab" href="#nodes-path-content" role="tab" aria-controls="nodes-path" aria-selected="false"><?php  echo __tr('wf_page_header_workflow_detail_nodes_path');?></a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        	<div class="tab-pane show fade active" id="roles-content" role="tabpanel" aria-labelledby="roles-tab">
        		<p class = "text-right">
					<?php echo Html::anchor('workflow/role_add/' . $wf->wf_id, '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_workflow_add_role'), array('class' => 'btn btn-sm btn-success'));?>
				</p>
				<?php if(!empty($roles)):?>
					<?php echo Form::open('workflow/role_delete', array('class' => 'form'));?>
					<table class="table table-hover table-sm table-bordered">
					  	<thead>
						  	<tr>
								<th><?php echo __tr('wf_field_role_id'); ?></th>
								<th><?php echo __tr('wf_field_role_name'); ?></th>
								<th><?php echo __tr('wf_txt_delete'); ?></th>
								<th><?php echo __tr('wf_txt_action'); ?></th>
							</tr>
						</thead>
						<?php foreach($roles as $l): ?>
						<tr>
							<td><?php echo $l->wf_role_id;?></td>
							<td><?php echo $l->wf_role_name;?></td>
							<td>
								<?php echo Form::checkbox('ids[]', $l->wf_role_id);?>
							</td>
							<td>
								<?php echo Html::anchor('workflow/role_update/'.$l->wf_role_id, '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
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
        	</div>
        	<div class="tab-pane fade" id="nodes-content" role="tabpanel" aria-labelledby="nodes-tab">
        		<p class = "text-right">
					<?php echo Html::anchor('workflow/node_add/' . $wf->wf_id, '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_workflow_add_node'), array('class' => 'btn btn-sm btn-success'));?>
				</p>
				<?php if(!empty($nodes)):?>
					<?php echo Form::open('workflow/node_delete', array('class' => 'form'));?>
					<table class="table table-hover table-sm table-bordered">
					  <thead>
						  <tr>
								<th><?php echo __tr('wf_field_node_id'); ?></th>
								<th><?php echo __tr('wf_field_node_name'); ?></th>
								<th><?php echo __tr('wf_field_node_task_type'); ?></th>
								<th><?php echo __tr('wf_field_node_type'); ?></th>
								<th><?php echo __tr('wf_field_node_state'); ?></th>
								<th><?php echo __tr('wf_field_node_validation_role'); ?></th>
								<th><?php echo __tr('wf_txt_delete'); ?></th>
								<th><?php echo __tr('wf_txt_action'); ?></th>
							</tr>
						</thead>
						<?php foreach($nodes as $l): ?>
						<tr>
							<td><?php echo $l->wf_node_id;?></td>
							<td><?php echo $l->wf_node_name;?></td>
							<td><?php echo $wf_task_types[$l->wf_node_task_type];?></td>
							<td><?php echo $wf_node_types[$l->wf_node_type];?></td>
							<td><?php echo $wf_status[$l->wf_node_status];?></td>
							<td><?php echo $l->wf_role_name;?></td>
							<td>
								<?php echo Form::checkbox('ids[]', $l->wf_node_id);?>
							</td>
							<td>
								<?php echo Html::anchor('workflow/node_update/'.$l->wf_node_id, '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
								<?php echo Html::anchor('workflow/node_detail/'.$l->wf_node_id, '<i class = "fa fa-eye"></i> ' . __tr('wf_txt_detail'), array('class' => 'btn btn-sm btn-secondary'));?>
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
        	</div>
        	<div class="tab-pane fade" id="nodes-path-content" role="tabpanel" aria-labelledby="nodes-path-tab">
        		<p class = "text-right">
					<?php echo Html::anchor('workflow/node_path_add/' . $wf->wf_id, '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_workflow_add_node_path'), array('class' => 'btn btn-sm btn-success'));?>
				</p>
				<?php if(!empty($nodes_path)):?>
					<?php echo Form::open('workflow/node_path_delete', array('class' => 'form'));?>
					<table class="table table-hover table-sm table-bordered">
					  <thead>
						  <tr>
								<th><?php echo __tr('wf_field_node_path_id'); ?></th>
								<th><?php echo __tr('wf_field_node_path_name'); ?></th>
								<th><?php echo __tr('wf_field_node_path_node_from'); ?></th>
								<th><?php echo __tr('wf_field_node_path_node_to'); ?></th>
								<th><?php echo __tr('wf_field_node_path_cond_type'); ?></th>
								<th><?php echo __tr('wf_field_node_path_cond_name'); ?></th>
								<th><?php echo __tr('wf_field_node_path_cond_operator'); ?></th>
								<th><?php echo __tr('wf_field_node_path_cond_value'); ?></th>
								<th><?php echo __tr('wf_field_node_path_is_default'); ?></th>
								<th><?php echo __tr('wf_field_node_path_order'); ?></th>
								<th><?php echo __tr('wf_txt_delete'); ?></th>
								<th><?php echo __tr('wf_txt_action'); ?></th>
							</tr>
						</thead>
						<?php foreach($nodes_path as $l): ?>
						<tr>
							<td><?php echo $l->wf_np_id;?></td>
							<td><?php echo $l->wf_np_name;?></td>
							<td><?php echo $l->from_name;?></td>
							<td><?php echo $l->to_name;?></td>
							<td><?php echo isset($wf_node_path_conditions_type[$l->wf_np_cond_type]) ? $wf_node_path_conditions_type[$l->wf_np_cond_type] : '';?></td>
							<td><?php echo $l->wf_np_cond_name;?></td>
							<td><?php echo $l->wf_np_cond_operator;?></td>
							<td><?php echo $l->wf_np_cond_value;?></td>
							<td><?php echo $l->wf_np_is_default ? __tr('wf_txt_yes') : __tr('wf_txt_no');?></td>
							<td><?php echo $l->wf_np_order;?></td>
							<td>
								<?php echo Form::checkbox('ids[]', $l->wf_np_id);?>
							</td>
							<td>
								<?php echo Html::anchor('workflow/node_path_update/'.$l->wf_np_id, '<i class = "fa fa-edit"></i> ' . __tr('wf_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
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
        	</div>
        </div>
	</div>
</div>
