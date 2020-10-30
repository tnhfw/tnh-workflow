 <div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo __tr('leav_fle_create');?>
      </div>
      <div class="card-body">
            <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
                <div class="form-group row">
                  <?php echo Form::label(__tr('leav_field_desc').': <span class="required">*</span>', 'desc', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::textarea('desc', Form::value('desc'), array('required' => true, 'class' => 'form-control form-control-sm', 'placeholder' => __tr('leav_fp_description')));?>
                    <span class="ferror"><?php echo Form::error('desc');?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <?php echo Form::label(__tr('leav_field_start_date').': <span class="required">*</span>', 'bdate', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::input('bdate', Form::value('bdate'), array('required' => true, 'class' => 'form-control form-control-sm', 'placeholder' =>  __tr('leav_fp_start_date')), 'date');?>
                    <span class="ferror"><?php echo Form::error('bdate');?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <?php echo Form::label(__tr('leav_field_end_date').': <span class="required">*</span>', 'edate', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::input('edate', Form::value('edate'), array('required' => true, 'class' => 'form-control form-control-sm', 'placeholder' =>  __tr('leav_fp_end_date')), 'date');?>
                    <span class="ferror"><?php echo Form::error('edate');?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <?php echo Form::label(__tr('leav_field_workflow').': <span class="required">*</span>', 'wf', array('class' => 'col-md-3 col-form-label'));?>
                  <div class="col-md-9">
                   <?php echo Form::select('wf', $workflows, Form::value('wf'), array('required' => true, 'class' => 'form-control form-control-sm'));?>
                    <span class="ferror"><?php echo Form::error('wf');?></span>
                  </div>
                </div>

                <br />
                <div class="row">
                    <div class="offset-1 col pr-2">
                       <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                       <?php echo Html::anchor('leave',  __tr('leav_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                    </div>
                </div> 
                <?php echo Form::close();?>
            </div>
        </div>
    </div>
</div>
