<?php 
	$states = array(
		'0' => __tr('leav_txt_state_invalide'),
		'1' => __tr('leav_txt_state_valid')
	);
 ?>
  <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('leav_page_header_detail'); ?>
    </div>
    <div class="card-body">
		<p class = "text-right">
			<?php echo Html::anchor('leave', '<i class = "fa fa-th-list"></i> ' . __tr('leav_page_header_list'), array('class' => 'btn btn-sm btn-secondary'));?>
			<?php echo Html::anchor('leave/add', '<i class = "fa fa-plus-circle"></i> ' . __tr('leav_txt_create'), array('class' => 'btn btn-sm btn-success'));?>
			<?php if(! $instance):?>
				<?php echo Html::anchor('workflow_validation_leave/start/' . $leave->leav_id, '<i class = "fa fa-star"></i> ' . __tr('wf_txt_start_workflow_validation'), array('class' => 'btn btn-sm btn-primary'));?>
			<?php else: ?>
				<?php echo Html::anchor('workflow_validation_leave/detail/' . $instance->wf_inst_id, '<i class = "fa fa-eye"></i> ' . __tr('wf_txt_workflow_validation_instance_detail'), array('class' => 'btn btn-sm btn-info'));?>
			<?php endif; ?>
		</p>
		<div class="row">
			<div class="col-md-6">
				<table class="table table-hover table-sm table-bordered detail">
					<tr>
						<th><?php echo __tr('leav_field_id'); ?></th>
						<td><?php echo $leave->leav_id;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('leav_field_desc'); ?></th>
						<td><?php echo $leave->leav_desc;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('leav_field_start_date'); ?></th>
						<td><?php echo $leave->leav_bdate;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('leav_field_end_date'); ?></th>
						<td><?php echo $leave->leav_edate;?></td>
					</tr>
					<tr>
						<th><?php echo __tr('leav_field_state'); ?></th>
						<td><?php echo $states[$leave->leav_state];?></td>
					</tr>
					<tr>
						<th><?php echo __tr('leav_field_workflow'); ?></th>
						<td><?php echo !empty($leave->workflow) ? $leave->workflow->wf_name : '';?></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo Html::anchor('leave/update/'.$leave->leav_id, '<i class = "fa fa-edit"></i> ' . __tr('leav_txt_edit'), array('class' => 'btn btn-sm btn-primary'));?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
