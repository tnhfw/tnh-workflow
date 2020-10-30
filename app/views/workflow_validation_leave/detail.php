<?php 
    $wf_task_states = get_wf_task_state_list();
    $wf_task_cancel_trigger_states = get_wf_task_cancel_trigger_list();
    $wf_inst_status = get_wf_instance_state_list();
    $entity_states = array(
        '0' => __tr('leav_txt_state_invalide'),
        '1' => __tr('leav_txt_state_valid')
    );
 ?>
  <div class="card mb-4">
    <div class="card-header bg-white font-weight-bold page-header">
        <?php echo __tr('wf_page_header_workflow_instance_detail'); ?>
    </div>
    <div class="card-body">
        <p class = "text-right">
            <?php echo Html::anchor('workflow_validation_leave', '<i class = "fa fa-th-list"></i> ' . __tr('wf_page_header_workflow_instances'), array('class' => 'btn btn-sm btn-secondary'));?>
       </p>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover table-sm table-bordered detail">
                    <tr>
                        <th><?php echo __tr('wf_field_inst_id'); ?></th>
                        <td><?php echo $instance->wf_inst_id;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_desc'); ?></th>
                        <td><?php echo $instance->wf_inst_desc;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_start_date'); ?></th>
                        <td><?php echo $instance->wf_inst_start_date;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_end_date'); ?></th>
                        <td><?php echo $instance->wf_inst_end_date;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_state'); ?></th>
                        <td><?php echo $wf_inst_status[$instance->wf_inst_state];?></td>
                    </tr>
                     <tr>
                        <th><?php echo __tr('wf_field_inst_entity_id'); ?></th>
                        <td><?php echo $instance->wf_inst_entity_id;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_entity_name'); ?></th>
                        <td><?php echo $instance->wf_inst_entity_name;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_entity_detail'); ?></th>
                        <td><?php echo $instance->wf_inst_entity_detail;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_start_comment'); ?></th>
                        <td><?php echo $instance->wf_inst_start_comment;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_inst_start_by'); ?></th>
                        <td><?php echo $instance->start_user_name;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('wf_field_workflow'); ?></th>
                        <td><?php echo $instance->wf_name;?></td>
                    </tr>
                    <?php if($instance->wf_inst_state == 'I'): ?>
                        <tr>
                            <td colspan="2">
                                <?php echo Html::anchor('workflow_validation_leave/cancel/'.$instance->wf_inst_id,  __tr('wf_txt_cancel'), array('class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("'.__tr('wf_txt_workflow_instance_cancel_warning').'")'));?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

                 <?php if($current_user_task && ! empty($current_user_task->outcomes)): ?>
                    <div class="offset-4 col-md-8">
                        <?php 
                            $loutcome = array();
                            foreach ($current_user_task->outcomes as $l) {
                                $loutcome[$l->wf_oc_id] = $l->wf_oc_name;
                            }
                         ?>
                        <?php echo Form::open('workflow_validation_leave/validation', array('class' => 'form well', 'role' => 'form'));?>
                            <?php echo Form::fieldset(__tr('wf_workflow_task_validation_fle'));?>
                            <?php echo Form::hidden('task_id', $current_user_task->wf_task_id); ?>
                            <?php echo Form::hidden('entity_id', $instance->wf_inst_entity_id); ?>
                             <div class = 'form-group'>
                                <?php echo Form::label(__tr('wf_txt_workflow_task_validation_outcome_result') . ' :', 'outcome');?>
                                <?php echo Form::select('outcome', $loutcome, Form::value('outcome'), array('class' => 'form-control form-control-sm'));?>
                                <?php echo Form::error('outcome');?>
                            </div>

                            <div class = 'form-group'>
                                <?php echo Form::label(__tr('wf_field_task_comment') . ' :', 'comment');?>
                                <?php echo Form::textarea('comment', Form::value('comment'), array('class' => 'form-control form-control-sm', 'placeholder' => __tr('wf_fp_workflow_task_validation_comment')));?>
                                <?php echo Form::error('comment');?>
                            </div>

                            <div class = 'form-group'>
                               <?php echo Form::submit('submit', __tr('wf_txt_valide'), array('class' => 'btn btn-success btn-sm btn-sm', 'onclick' => 'return confirm("'.__tr('wf_txt_workflow_task_validation_warning').'")'));?>
                            </div>
                        <?php echo Form::close();?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h4><?php echo __tr('wf_page_header_workflow_instance_entity_detail'); ?></h4>
                <table class="table table-hover table-sm table-bordered detail">
                    <tr>
                        <th><?php echo __tr('leav_field_id'); ?></th>
                        <td><?php echo $entity->leav_id;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('leav_field_desc'); ?></th>
                        <td><?php echo $entity->leav_desc;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('leav_field_start_date'); ?></th>
                        <td><?php echo $entity->leav_bdate;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('leav_field_end_date'); ?></th>
                        <td><?php echo $entity->leav_edate;?></td>
                    </tr>
                    <tr>
                        <th><?php echo __tr('leav_field_state'); ?></th>
                        <td><?php echo $entity_states[$entity->leav_state];?></td>
                    </tr>
                </table>

                <h4><?php echo __tr('wf_page_header_workflow_instance_validation_actors'); ?></h4>
                <?php if(!empty($users_roles)):?>
                    <table class="table table-hover table-sm table-bordered">
                      <thead>
                      <tr>
                            <th><?php echo __tr('wf_field_user_role_id'); ?></th>
                            <th><?php echo __tr('wf_field_role'); ?></th>
                            <th><?php echo __tr('wf_field_user'); ?></th>
                            <th><?php echo __tr('wf_txt_action'); ?></th>
                        </tr>
                    </thead>
                        <?php foreach($users_roles as $l): ?>
                        <tr>
                            <td><?php echo $l->wf_ur_id;?></td>
                            <td><?php echo $l->wf_role_name;?></td>
                            <td><?php echo $l->user_name;?></td>
                            <td>
                                <?php if($instance->wf_inst_state == 'I'): ?>
                                    <?php echo Html::anchor('workflow_validation_leave/delete_user_role/'.$l->wf_ur_id, '<i class = "fa fa-trash"></i> ' . __tr('wf_txt_delete'), array('class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("'.__tr('wf_txt_workflow_task_delete_actor_warning').'")'));?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else:?>
                    <p class = "alert alert-info"><?php echo __tr('wf_txt_database_no_data'); ?></p>
                <?php endif;?>
                <p class="text-right">
                    <?php if($instance->wf_inst_state == 'I'): ?>
                        <?php echo Html::anchor('workflow_validation_leave/add_user_role/'.$instance->wf_inst_id, '<i class = "fa fa-plus-circle"></i> ' . __tr('wf_txt_workflow_task_add_actor'), array('class' => 'btn btn-sm btn-success'));?>
                     <?php endif; ?>
                </p>
            </div>
        </div>

        <h4><b><?php echo __tr('wf_page_header_workflow_instance_tasks'); ?></b></h4>

        <?php if(!empty($tasks)):?>
            <?php echo Form::open('workflow/node_delete', array('class' => 'form'));?>
            <table class="table table-hover table-sm table-bordered">
              <thead>
              <tr>
                    <th><?php echo __tr('wf_field_task_id'); ?></th>
                    <th><?php echo __tr('wf_field_task_node'); ?></th>
                    <th><?php echo __tr('wf_field_task_actor'); ?></th>
                    <th><?php echo __tr('wf_field_task_state'); ?></th>
                    <th><?php echo __tr('wf_field_task_outcome_result'); ?></th>
                    <th><?php echo __tr('wf_field_task_comment'); ?></th>
                    <th><?php echo __tr('wf_field_task_cancel_trigger'); ?></th>
                    <th><?php echo __tr('wf_field_task_start_time'); ?></th>
                    <th><?php echo __tr('wf_field_task_end_time'); ?></th>
                </tr>
            </thead>
                <?php foreach($tasks as $l): ?>
                <tr>
                    <td><?php echo $l->wf_task_id;?></td>
                    <td><?php echo $l->wf_node_name;?></td>
                    <td><?php echo $l->user_name;?></td>
                    <td><?php echo $wf_task_states[$l->wf_task_status];?></td>
                    <td><?php echo $l->wf_oc_name;?></td>
                    <td><?php echo $l->wf_task_comment;?></td>
                    <td><?php echo isset($wf_task_cancel_trigger_states[$l->wf_task_cancel_trigger]) ? $wf_task_cancel_trigger_states[$l->wf_task_cancel_trigger] : '';?></td>
                    <td><?php echo $l->wf_task_start_time;?></td>
                    <td><?php echo $l->wf_task_end_time;?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else:?>
            <p class = "alert alert-info"><?php echo __tr('wf_txt_database_no_data'); ?></p>
        <?php endif;?>
        <br />
    </div>
</div>
