<?php
defined('ROOT_PATH') or exit('Access denied');

class Workflow_validation_leave extends Controller{


    public function __construct(){
        parent::__construct();
        auth();
        $this->loader->model('leave_model');
        $this->loader->model('workflow/workflow_model');
        $this->loader->model('workflow/wf_node_model');
        $this->loader->model('workflow/wf_role_model');
        $this->loader->model('workflow/wf_user_role_model');
        $this->loader->model('users_model');
        $this->loader->model('workflow/wf_node_outcome_model');
        $this->loader->model('workflow/wf_instance_model');
        $this->loader->model('workflow/wf_task_model');
    }

   public function index(){
        $entity_name = get_leave_entity_name();
        $data['list'] = $this->wf_instance_model->getList(null,  null, -1, -1, -1, -1, $entity_name, -1);
        $this->response->render('header');
        $this->response->render('workflow_validation_leave/index', $data);
        $this->response->render('footer');
    }

    public function my_task(){
        $data['list'] = $this->wf_task_model->getList(null, null, -1, -1, -1, -1, -1, auth_get_params('id'), 'I', false);

        $this->response->render('header');
        $this->response->render('workflow_validation_leave/my_task', $data);
        $this->response->render('footer');
    }

    public function detail($inst_id){
        $instance = $this->wf_instance_model->getInfo($inst_id);
        if(!$instance){
            sfwarning(__tr('wf_txt_database_data_not_exists'));
            $this->response->redirect('workflow_validation_leave');
        }
        $data['instance'] = $instance;
        $data['entity'] = $this->leave_model->getSingleRecord($instance->wf_inst_entity_id);
        $data['users_roles'] = $this->wf_user_role_model->getList($inst_id);
        $tasks = $this->wf_task_model->getList(null, null, -1, -1, $inst_id, -1, -1, -1, -1, false);
        $current_user_task = null;
        if(! empty($tasks)){
            foreach ($tasks as $l) {
                if($instance->wf_inst_state != 'C' && $l->wf_task_status == 'I' && $l->user_id == auth_get_params('id')){
                    $current_user_task = $l;
                    break;
                }
            }
        }
        if($current_user_task){
            $outcomes = $this->wf_node_outcome_model->getListRecordCond('wf_node_id', $current_user_task->wf_node_id);
            if(empty($outcomes)){
                sfwarning(sprintf(__tr('wf_txt_no_outcome_for_user_task_warning'), $current_user_task->wf_node_name));
            }
            $current_user_task->outcomes = $outcomes;
        }
        $data['current_user_task'] = $current_user_task;
        $data['tasks'] = $tasks;

        $this->response->render('header');
        $this->response->render('workflow_validation_leave/detail', $data);
        $this->response->render('footer');
    }

    

    public function start($entity_id){
        $entity = $this->leave_model->getSingleRecord($entity_id);
        if(! $entity){
            sfwarning(__tr('wf_txt_database_data_not_exists'));
            $this->response->redirect('leave');
        }
        $entity_name = get_leave_entity_name();
        $instance = $this->wf_instance_model->getForEntity($entity_id, $entity_name);
        //first check if already start
        if($instance){
            sferror(__tr('wf_txt_validation_already_start_error'));
            $this->response->redirect('leave/detail/' . $entity_id);
        }

        //check if workflow state is active
        $workflow = $this->workflow_model->getSingleRecord($entity->wf_id);
        if(! $workflow || ! $workflow->wf_status){
            sferror(__tr('wf_txt_validation_workflow_not_valid_error'));
            $this->response->redirect('leave/detail/' . $entity_id);
        }

        //check if workflow have start/end event
        $start = $this->wf_node_model->getStartNodeForWorkflow($entity->wf_id, 1);
        if(! $start){
            sferror(__tr('wf_txt_validation_workflow_start_node_not_valid_error'));
            $this->response->redirect('leave/detail/' . $entity_id);
        }
        $end = $this->wf_node_model->getEndNodeForWorkflow($entity->wf_id, 1);
        if(! $end){
            sferror(__tr('wf_txt_validation_workflow_end_node_not_valid_error'));
            $this->response->redirect('leave/detail/' . $entity_id);
        }

        $data['entity'] = $entity;
        $data['roles'] = $this->wf_role_model->getRolesForWorkflow($entity->wf_id);
        $data['users'] = $this->users_model->dropdown('user_name');
        
        $this->loader->library('FormValidation');
        $v = $this->formvalidation;
        $v->setRule('desc', __tr('wf_field_inst_desc'), 'min_length[2]');
        $v->setRule('entity_detail', __tr('wf_field_inst_entity_detail'), 'min_length[2]');
        $v->setRule('start_comment', __tr('wf_field_inst_start_comment'), 'min_length[2]');

        if ($v->validate() === true) {
            $entity_detail = $this->request->post('entity_detail');
            $desc = $this->request->post('desc');
            $start_comment = $this->request->post('start_comment');
            $roles = $this->request->post('roles');
            $users = $this->request->post('users');

            $start_by_id = auth_get_params('id');

            //instance
            $params_instance = array(
                'wf_inst_state' => 'I',
                'wf_inst_desc' => $desc,
                'wf_inst_start_date' => date('Y-m-d H:i:s'),
                'wf_inst_entity_id' => $entity_id,
                'wf_inst_entity_name' => $entity_name,
                'wf_inst_entity_detail' => $entity_detail,
                'wf_inst_start_comment' => $start_comment,
                'start_by_id' => $start_by_id,
                'wf_id' => $entity->wf_id,
            );
            $inst_id = $this->wf_instance_model->insert($params_instance);
            if($inst_id){
                /////////////////////////////////////// user role //////////////////////////////////////////////////////////////// //
                if(! empty($roles)){
                    $nb = count($roles);
                    for ($i = 0; $i < $nb; $i++) {
                        if(! empty($roles[$i]) && ! empty($users[$i])){
                            $row = array(
                                'wf_inst_id' => $inst_id,
                                'user_id' => $users[$i],
                                'wf_role_id' => $roles[$i] 
                            );
                            //check if already exists
                            if(! $this->wf_user_role_model->getSingleRecordCond($row)){
                               $this->wf_user_role_model->insert($row);
                            }
                        }
                    }
                }

                //Execute Workflow
                $result_str = execute_workflow($entity->wf_id, $inst_id, $entity, $entity_id, $entity_name, $start, true);
                sfsuccess($result_str);
                $this->response->redirect('workflow_validation_leave/detail/' . $inst_id);
            }
            else{
                sferror(__tr('wf_txt_database_insert_error'));
                $this->response->render('header');
                $this->response->render('workflow_validation_leave/start', $data);
                $this->response->render('footer');
            }
        }
        else{
            $this->response->render('header');
            $this->response->render('workflow_validation_leave/start', $data);
            $this->response->render('footer');
        }
    }

    public function validation(){
        $this->loader->library('FormValidation');
        $v = $this->formvalidation;
        $v->setRule('outcome', __tr('wf_field_outcome'), 'required');
        $v->setRule('comment', __tr('wf_field_task_comment'), 'min_length[2]');
        $v->setRule('task_id', __tr('wf_field_task'), 'required');
        $v->setRule('entity_id', __tr('wf_field_inst_entity_id'), 'required');
         if ($v->validate() === true) {
            $entity_name = get_leave_entity_name();

            $task_id = $this->request->post('task_id');
            $entity_id = $this->request->post('entity_id');
            $entity = $this->leave_model->getSingleRecord($entity_id);
            $outcome = $this->request->post('outcome');
            $comment = $this->request->post('comment');
            
            $taskInfo = $this->wf_task_model->getSingleRecordCond(array(
                'wf_task_id' => $task_id,
                'wf_task_status' => 'I',
                'user_id' => auth_get_params('id')
            ));
            if(! $taskInfo){
                sferror(__tr('wf_txt_validation_task_not_valid_error'));
                $this->response->redirect('workflow_validation_leave');
            }
            else if(! $entity){
                sferror(__tr('wf_txt_validation_entiy_not_found_error'));
                $this->response->redirect('workflow_validation_leave');
            }

            $instance = $this->wf_instance_model->getForEntity($entity_id, $entity_name);
            //first check if already start
            if(! $instance){
                sferror(__tr('wf_txt_validation_instance_not_found_error'));
                $this->response->redirect('workflow_validation_leave');
            }
            else if($instance->wf_inst_state != 'I'){
                sferror(__tr('wf_txt_validation_instance_state_not_valid_error'));
                $this->response->redirect('workflow_validation_leave/detail/' . $instance->wf_inst_id);
            }
            //Everything is OK
             $inst_id = $instance->wf_inst_id;
             $params_task = array(
                                'wf_task_status' => 'T',
                                'wf_task_comment' => $comment,
                                'wf_task_end_time' => date('Y-m-d H:i:s'),
                                'wf_oc_id' => $outcome
                            );
             $update = $this->wf_task_model->updateCond(
                        array(
                            'wf_task_id' => $task_id,
                            'wf_node_id' => $taskInfo->wf_node_id,
                            'user_id' => auth_get_params('id'),
                            'wf_inst_id' => $inst_id
                        ),
                        $params_task
                     );
             if($update){
                //other tasks will cancelled
                $this->wf_task_model->updateCond(
                        array(
                            'wf_task_status' => 'I',
                            'wf_node_id' => $taskInfo->wf_node_id,
                            'wf_inst_id' => $inst_id
                        ),
                        array(
                                'wf_task_status' => 'C',
                                'wf_task_comment' => 'Already validate by ' . auth_get_params('login'),
                                'wf_task_end_time' => date('Y-m-d H:i:s'),
                                'wf_task_cancel_trigger' => 'S'
                            )
                     );
                ////////////////////////////////// CONTINUE WORKFLOW ///////////////////////////////////////////////////////
                $taskNode = $this->wf_node_model->getInfo($taskInfo->wf_node_id);
                //Execute Workflow
                $result_str = execute_workflow($entity->wf_id, $inst_id, $entity, $entity_id, $entity_name, $taskNode, false);
                /////////////////////////////////////////////////////////////////////////////////////////////////////////
                sfsuccess($result_str);
                $this->response->redirect('workflow_validation_leave/detail/' . $inst_id);
             }
             else{
                sferror('Error when update workflow task !');
                $this->response->redirect('workflow_validation_leave/detail/' . $instance->wf_inst_id);
             }
         }
        else{
            $this->response->redirect('workflow_validation_leave');
        }
    }


    public function cancel($inst_id){
        $instance = $this->wf_instance_model->getInfo($inst_id);
        if(!$instance){
            sfwarning(__tr('wf_txt_database_data_not_exists'));
            $this->response->redirect('workflow_validation_leave');
        }
        else if($instance->wf_inst_state != 'I'){
            sferror(__tr('wf_txt_validation_cancel_instance_state_not_valid_error'));
            $this->response->redirect('workflow_validation_leave/detail/' . $inst_id);
        }
        $params_instance = array(
                        'wf_inst_state' => 'C',
                        'wf_inst_end_date' => date('Y-m-d H:i:s')
                    );
        $this->wf_instance_model->update($inst_id, $params_instance);
        $this->wf_task_model->updateCond(
                                        array(
                                            'wf_inst_id' => $inst_id, 
                                            'wf_task_status' => 'I'
                                        ), 
                                        array(
                                            'wf_task_status' => 'C',
                                            'wf_task_comment' => 'Workflow canceled by ' . auth_get_params('login'),
                                            'wf_task_cancel_trigger' => 'U',
                                            'wf_task_end_time' => date('Y-m-d H:i:s')
                                        )
                                    );
        sfsuccess(__tr('wf_txt_validation_cancel_instance_success'));
        $this->response->redirect('workflow_validation_leave/detail/' . $inst_id);
    }

    public function add_user_role($inst_id){
        $instance = $this->wf_instance_model->getInfo($inst_id, 'I');
        if(!$instance){
            sferror(__tr('wf_txt_validation_add_user_role_instance_state_not_valid_error'));
            $this->response->redirect('workflow_validation_leave');
        }
        $data['instance'] = $instance;
        $data['roles'] = $this->wf_role_model->getRolesForWorkflow($instance->wf_id);
        $data['users'] = $this->users_model->dropdown('user_name');
        
        $this->loader->library('FormValidation');
        $v = $this->formvalidation;
        $v->setRule('submit', 'submit', 'required');
        
        if ($v->validate() === true) {
            $roles = $this->request->post('roles');
            $users = $this->request->post('users');

            if(! empty($roles)){
                $nb = count($roles);
                for ($i = 0; $i < $nb; $i++) {
                    if(! empty($roles[$i]) && ! empty($users[$i])){
                        $row = array(
                            'wf_inst_id' => $inst_id,
                            'user_id' => $users[$i],
                            'wf_role_id' => $roles[$i] 
                        );
                        //check if already exists
                        if(! $this->wf_user_role_model->getSingleRecordCond($row)){
                           $this->wf_user_role_model->insert($row);
                        }
                    }
                }
            }
            sfsuccess(__tr('wf_txt_validation_add_user_role_instance_success'));
            $this->response->redirect('workflow_validation_leave/detail/' . $inst_id);
        }
        else{
            $this->response->render('header');
            $this->response->render('workflow_validation_leave/add_user_role', $data);
            $this->response->render('footer');
        }

    }

    public function delete_user_role($wf_ur_id){
        $user_role = $this->wf_user_role_model->getSingleRecord($wf_ur_id);
        if(!$user_role){
            sfwarning(__tr('wf_txt_database_data_not_exists'));
            $this->response->redirect('workflow_validation_leave');
        }
        $instance = $this->wf_instance_model->getInfo($user_role->wf_inst_id, 'I');
        if(!$instance){
            sferror(__tr('wf_txt_validation_delete_user_role_instance_state_not_valid_error'));
            $this->response->redirect('workflow_validation_leave');
        }
        $deleted = $this->wf_user_role_model->delete($wf_ur_id);
        if($deleted){
            //Cancel all task for this user
            $tasks = $this->wf_task_model->getCurrentUserRoleForNodeValidation($user_role->user_id, $user_role->wf_role_id, $instance->wf_inst_id);
            if(! empty($tasks)){
                foreach ($tasks as $l) {
                    $this->wf_task_model->update($l->wf_task_id,
                        array(
                                'wf_task_status' => 'C',
                                'wf_task_comment' => 'Actor deleted',
                                'wf_task_end_time' => date('Y-m-d H:i:s'),
                                'wf_task_cancel_trigger' => 'S'
                            )
                     );
                }
            }  
        }
        sfsuccess(__tr('wf_txt_validation_delete_user_role_instance_success'));
        $this->response->redirect('workflow_validation_leave/detail/' . $instance->wf_inst_id);
    }
}
