<?php 
  $lroles = array('' => ' ---- ');
  foreach ($roles as $l) {
    $lroles[$l->wf_role_id] = $l->wf_role_name;
  }
 ?>
 <div class="row justify-content-center align-items-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo sprintf(__tr('wf_workflow_instance_fle_start'), $entity->leav_desc);?>
      </div>
      <div class="card-body">
            <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
               <div class="row">
                    <div class="col-md-7">
                        <div class="form-group row">
                          <?php echo Form::label(__tr('wf_field_inst_desc').': ', 'desc', array('class' => 'col-md-3 col-form-label'));?>
                          <div class="col-md-9">
                           <?php echo Form::textarea('desc', Form::value('desc'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_instance_desc')));?>
                            <span class="ferror"><?php echo Form::error('desc');?></span>
                          </div>
                        </div>

                        <div class="form-group row">
                          <?php echo Form::label(__tr('wf_field_inst_entity_detail').': ', 'entity_detail', array('class' => 'col-md-3 col-form-label'));?>
                          <div class="col-md-9">
                           <?php echo Form::textarea('entity_detail', Form::value('entity_detail'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_instance_entity_detail')));?>
                            <span class="ferror"><?php echo Form::error('entity_detail');?></span>
                          </div>
                        </div>

                        <div class="form-group row">
                          <?php echo Form::label(__tr('wf_field_inst_start_comment').': ', 'start_comment', array('class' => 'col-md-3 col-form-label'));?>
                          <div class="col-md-9">
                           <?php echo Form::textarea('start_comment', Form::value('start_comment'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_instance_start_comment')));?>
                            <span class="ferror"><?php echo Form::error('start_comment');?></span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4><?php echo __tr('wf_page_header_workflow_instance_validation_actors'); ?></h4>
                        <?php if(!empty($roles)):?>
                            <table id = "table_actor" class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo __tr('wf_field_role'); ?></th>
                                        <th><?php echo __tr('wf_field_user'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id ="wf_actor_tbody">
                                    <tr id = "wf_actor_first_row">
                                        <td><?php echo Form::select('roles[]', $lroles, null, array('class' => 'form-control form-control-sm'));?></td>
                                        <td><?php echo Form::select('users[]', array('' => ' ---- ') + $users, null, array('class' => 'form-control form-control-sm'));?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-right">
                                <button class="btn btn-sm btn-success" id = "wf_add_actor_row"><i class="fa fa-plus-circle"></i> <?php echo __tr('wf_txt_workflow_task_add_actor'); ?></button>
                            </p>
                        <?php else:?>
                          <p class = "alert alert-info"><?php echo __tr('wf_txt_database_no_data'); ?></p>
                        <?php endif;?>
                    </div>
                    <div class="col-md-12">
                        <br />
                        <div class="row">
                            <div class="offset-1 col pr-2">
                               <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm', 'onclick' => 'return confirm("'.__tr('wf_txt_workflow_validation_start_warning').'")'));?>
                               <?php echo Html::anchor('leave/detail/'. $entity->leav_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                            </div>
                        </div> 
                    </div>
                </div>
               <?php echo Form::close();?>
            </div>
        </div>
    </div>
</div>
