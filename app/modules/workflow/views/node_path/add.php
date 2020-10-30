<?php 
    $conditions_types = get_wf_node_path_condition_type_list();
    $conditions_operator = get_wf_node_path_condition_operator_list();
    
    $lnodes = array();
    foreach ($nodes as $l) {
      $lnodes[$l->wf_node_id] = $l->wf_node_name;
    }
    
    $loutcomes = array();
    foreach ($outcomes as $l) {
      $loutcomes[$l->wf_oc_code] = $l->wf_oc_name . ' (' .$l->wf_node_name . ')';
    }

    $defaults = array(
        '0' => __tr('wf_txt_no'),
        '1' => __tr('wf_txt_yes')
    );
 ?>
 <div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo sprintf(__tr('wf_workflow_node_path_fle_create'),  $wf->wf_name);?>
      </div>
      <div class="card-body">
             <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_node_from').': <span class="required">*</span>', 'node_from', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                        <?php echo Form::select('node_from', $lnodes, Form::value('node_from'), array('class' => 'form-control form-control-sm', 'required' => true));?>
                      <span class="ferror"><?php echo Form::error('node_from');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_node_to').': <span class="required">*</span>', 'node_to', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                        <?php echo Form::select('node_to', $lnodes, Form::value('node_to'), array('class' => 'form-control form-control-sm', 'required' => true));?>
                      <span class="ferror"><?php echo Form::error('node_to');?></span>
                    </div>
                </div>

                 <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_name').': ', 'name', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                       <?php echo Form::text('name', Form::value('name'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_path_name')));?>
                      <span class="ferror"><?php echo Form::error('name');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_cond_type').': ', 'cond_type', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                       <?php echo Form::select('cond_type', array('' => ' ---- ') + $conditions_types, Form::value('cond_type'), array('class' => 'form-control form-control-sm'));?>
                      <span class="ferror"><?php echo Form::error('cond_type');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_cond_name').': ', 'cond_name', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                        <?php echo Form::text('cond_name', Form::value('cond_name'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_path_cond_name')));?>
                      <span class="ferror"><?php echo Form::error('cond_name');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_cond_operator').': ', 'cond_operator', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                         <?php echo Form::select('cond_operator', array('' => ' ---- ') + $conditions_operator, Form::value('cond_operator'), array('class' => 'form-control form-control-sm'));?>
                      <span class="ferror"><?php echo Form::error('cond_operator');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_cond_outcome_value').': ', 'cond_oc_value', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                         <?php echo Form::select('cond_oc_value', array('' => ' ---- ') + $loutcomes, Form::value('cond_oc_value'), array('class' => 'form-control form-control-sm'));?>
                      <span class="ferror"><?php echo Form::error('cond_oc_value');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_cond_value').': ', 'cond_value', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                         <?php echo Form::text('cond_value', Form::value('cond_value'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_path_cond_value')));?>
                      <span class="ferror"><?php echo Form::error('cond_value');?></span>
                    </div>
                </div>

                <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_is_default').': <span class="required">*</span>', 'is_default', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                        <?php echo Form::select('is_default', $defaults, Form::value('is_default'), array('required' => true, 'class' => 'form-control form-control-sm'));?>
                      <span class="ferror"><?php echo Form::error('is_default');?></span>
                    </div>
                </div>

                 <div class="form-group row">
                    <?php echo Form::label(__tr('wf_field_node_path_order').': ', 'order', array('class' => 'col-md-3 col-form-label'));?>
                    <div class="col-md-9">
                        <?php echo Form::number('order', Form::value('order'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_node_path_order')));?>
                      <span class="ferror"><?php echo Form::error('order');?></span>
                    </div>
                </div>

                <br />
                <div class="row">
                    <div class="offset-1 col pr-2">
                       <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                       <?php echo Html::anchor('workflow/detail/' . $wf->wf_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                    </div>
                </div> 
               <?php echo Form::close();?>
            </div>
        </div>
    </div>
</div>
