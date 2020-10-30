<?php 
  $wf_status = get_wf_state_list();
  $wf_task_types = get_wf_task_type_list();
  $wf_node_types = get_wf_node_type_list();

  $lroles = array('0' => '-----------------');
  foreach ($roles as $l) {
    $lroles[$l->wf_role_id] = $l->wf_role_name;
  }

  $lservice = array('' => '-----------------');
  foreach ($service_list as $name => $def) {
    $lservice[$name] = $def['name'];
  }

  $def = explode(':', $node->wf_node_service);
  $service = isset($def[0]) ? trim($def[0]) : null;
  $service_arg = isset($def[1]) ? trim($def[1]) : null;
 
 ?>
<div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo __tr('wf_workflow_node_fle_edit');?>
      </div>
      <div class="card-body">
          <?php echo Form::open(get_instance()->url->current(), array('class' => 'form well', 'role' => 'form'));?>
            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_name').': <span class="required">*</span>', 'name', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                  <?php echo Form::text('name', Form::value('name')?Form::value('name'):$node->wf_node_name, array('class' => 'form-control form-control-sm', 'required' => true, 'placeholder' => __tr('wf_fp_workflow_node_name')));?>
                  <span class="ferror"><?php echo Form::error('name');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_task_type').': <span class="required">*</span>', 'task_type', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                  <?php echo Form::select('task_type', $wf_task_types, Form::value('task_type')?Form::value('task_type'):$node->wf_node_task_type, array('required' => true, 'class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('task_type');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_type').': <span class="required">*</span>', 'node_type', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                   <?php echo Form::select('node_type', $wf_node_types, Form::value('node_type')?Form::value('node_type'):$node->wf_node_type, array('required' => true, 'class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('node_type');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_script').': ', 'script', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                   <?php echo Form::textarea('script', Form::value('script')?Form::value('script'):$node->wf_node_script, array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_script'), 'rows' => 10));?>
                  <span class="ferror"><?php echo Form::error('script');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_service').': ', 'service', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                    <?php echo Form::select('service', $lservice, Form::value('service')?Form::value('service'):$service, array('class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('service');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_service_args').': ', 'service_arg', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                    <?php echo Form::text('service_arg', Form::value('service_arg')?Form::value('service_arg'):$service_arg, array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_service_arg')));?>
                  <span class="ferror"><?php echo Form::error('service_arg');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_state').': <span class="required">*</span>', 'status', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                   <?php echo Form::select('status', $wf_status, Form::value('status')?Form::value('status'):$node->wf_node_status, array('required' => true, 'class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('status');?></span>
                </div>
            </div>

             <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_node_validation_role').': ', 'role', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                    <?php echo Form::select('role', $lroles, Form::value('role')?Form::value('role'):$node->wf_role_id, array('class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('role');?></span>
                </div>
            </div>

             <br />
            <div class="row">
                <div class="offset-1 col pr-2">
                   <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                   <?php echo Html::anchor('workflow/detail/' . $node->wf_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                </div>
            </div>    
          <?php echo Form::close();?>
           </div>
      </div>
  </div>
</div>

