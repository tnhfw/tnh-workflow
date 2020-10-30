 <div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo __tr('wf_workflow_outcome_fle_edit');?>
      </div>
      <div class="card-body">
            <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
                <div class="form-group row">
                  <?php echo Form::label(__tr('wf_field_node_oc_code').': <span class="required">*</span>', 'code', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::text('code', Form::value('code')?Form::value('code'):$outcome->wf_oc_code, array('class' => 'form-control form-control-sm', 'required' => true, 'placeholder' => __tr('wf_fp_workflow_node_outcome_code')));?>
                    <span class="ferror"><?php echo Form::error('code');?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <?php echo Form::label(__tr('wf_field_node_oc_name').': <span class="required">*</span>', 'name', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::text('name', Form::value('name')?Form::value('name'):$outcome->wf_oc_name, array('class' => 'form-control form-control-sm', 'required' => true, 'placeholder' => __tr('wf_fp_workflow_node_outcome_name')));?>
                    <span class="ferror"><?php echo Form::error('name');?></span>
                  </div>
                </div>

                <br />
                <div class="row">
                    <div class="offset-1 col pr-2">
                       <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                       <?php echo Html::anchor('workflow/node_detail/' . $outcome->wf_node_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                    </div>
                </div> 
           <?php echo Form::close();?>
        </div>
        </div>
    </div>
</div>
