<?php 
    $wf_status = get_wf_state_list();
 ?>
<div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo __tr('wf_workflow_fle_create');?>
      </div>
      <div class="card-body">
            <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_workflow_name').': <span class="required">*</span>', 'name', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                  <?php echo Form::text('name', Form::value('name'), array('required' => true, 'placeholder' => __tr('wf_fp_workflow_name'), 'class' => 'form-control form-control-sm '));?>
                  <span class="ferror"><?php echo Form::error('name');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_workflow_desc').': ', 'desc', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                  <?php echo Form::textarea('desc', Form::value('desc'), array('class' => 'form-control form-control-sm', 'placeholder' =>  __tr('wf_fp_workflow_desc')));?>
                  <span class="ferror"><?php echo Form::error('desc');?></span>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label(__tr('wf_field_workflow_state').': <span class="required">*</span>', 'status', array('class' => 'col-md-3 col-form-label'));?>
                <div class="col-md-9">
                  <?php echo Form::select('status', $wf_status, Form::value('status'), array('required' => true, 'class' => 'form-control form-control-sm'));?>
                  <span class="ferror"><?php echo Form::error('status');?></span>
                </div>
            </div>
            
             <br />
            <div class="row">
                <div class="offset-1 col pr-2">
                   <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                   <?php echo Html::anchor('workflow',  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                </div>
            </div>
            <?php echo Form::close();?>
        </div>
      </div>
    </div>
</div>
