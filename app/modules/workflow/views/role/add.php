 <div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo sprintf(__tr('wf_workflow_role_fle_create'), $wf->wf_name );?>
      </div>
      <div class="card-body">
            <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
                <div class="form-group row">
                  <?php echo Form::label(__tr('wf_field_role_name').': <span class="required">*</span>', 'name', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::text('name', Form::value('name'), array('class' => 'form-control form-control-sm', 'required' => true, 'placeholder' => __tr('wf_fp_workflow_role_name')));?>
                    <span class="ferror"><?php echo Form::error('name');?></span>
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
