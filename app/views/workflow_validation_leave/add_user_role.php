<?php 
  $lroles = array('' => ' ---- ');
  foreach ($roles as $l) {
    $lroles[$l->wf_role_id] = $l->wf_role_name;
  }
 ?>
 <div class="row justify-content-center align-items-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-white font-weight-bold">
        <?php echo sprintf(__tr('wf_workflow_instance_fle_actor_create'), $instance->wf_inst_desc . ' - ' . $instance->wf_inst_entity_detail);?>
      </div>
      <div class="card-body">
                <?php echo Form::open(null, array('class' => 'form well', 'role' => 'form'));?>
               <div class="row">
                    <div class="col-md-12">
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
                        <?php endif;?>
                    </div>
                    <div class="col-md-12">
                        <br />
                        <div class="row">
                            <div class="offset-1 col pr-2">
                               <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm'));?>
                               <?php echo Html::anchor('workflow_validation_leave/detail/'. $instance->wf_inst_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-secondary'));?>
                            </div>
                        </div> 
                    </div>
                </div>
                <?php echo Form::fieldsetClose();?>
               <?php echo Form::close();?>
            </div>
        </div>
    </div>
</div>
