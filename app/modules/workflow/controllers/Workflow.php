<?php
defined('ROOT_PATH') or exit('Access denied');

class Workflow extends Controller{


	public function __construct(){
		parent::__construct();
		auth();
		$this->loader->model('workflow/workflow_model');
		$this->loader->model('workflow/wf_node_model');
		$this->loader->model('workflow/wf_node_path_model');
		$this->loader->model('workflow/wf_role_model');
		$this->loader->model('workflow/wf_node_outcome_model');
	}

	////////////////////////////////////////////////// WORKFLOW START ///////////////////////////////////////////////
	public function index(){
		$data['list'] = $this->workflow_model->getListRecord();
		$this->response->render('header');
		$this->response->render('index', $data);
		$this->response->render('footer');
	}

	public function add(){
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_workflow_name'), 'required|min_length[2]|is_unique[workflow.wf_name]');
		$v->setRule('desc', __tr('wf_field_workflow_desc'), 'min_length[2]');
		$v->setRule('status', __tr('wf_field_workflow_state'), 'required');

		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$desc = $this->request->post('desc');
			$status = $this->request->post('status');

			$params = array(
				'wf_name' => $name,
				'wf_desc' => $desc,
				'wf_status' => $status
			);
			$id = $this->workflow_model->insert($params);
			if($id){
				//add Start node
				$this->wf_node_model->insert(array(
					'wf_node_name' => 'Start',
					'wf_node_task_type' => 1, //1 = User task
					'wf_node_type' => 1, //1 = Start node
					'wf_node_status' => 1, //1 = Active
					'wf_id' => $id
				));

				//add End node
				$this->wf_node_model->insert(array(
					'wf_node_name' => 'End',
					'wf_node_task_type' => 1, //1 = User task
					'wf_node_type' => 3, //3 = End node
					'wf_node_status' => 1, //1 = Active
					'wf_id' => $id
				));

				sfsuccess(__tr('wf_txt_database_insert_ok'));
				$this->response->redirect('workflow');
			}
			else{
				sferror(__tr('wf_txt_database_insert_error'));
				$this->response->render('header');
				$this->response->render('add');
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('add');
			$this->response->render('footer');
		}
	}

	public function update($id){
		$wf = $this->workflow_model->getSingleRecord($id);
		if(!$wf){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['wf'] = $wf;
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_workflow_name'), 'required|min_length[2]');
		$v->setRule('desc', __tr('wf_field_workflow_desc'), 'min_length[2]');
		$v->setRule('status', __tr('wf_field_workflow_state'), 'required');

		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$desc = $this->request->post('desc');
			$status = $this->request->post('status');

			$params = array(
				'wf_name' => $name,
				'wf_desc' => $desc,
				'wf_status' => $status
			);
			$update = $this->workflow_model->update($id, $params);
			if($update){
				sfsuccess(__tr('wf_txt_database_update_ok'));
				if($this->request->get('from_detail')){
					$this->response->redirect('workflow/detail/' . $id);
				}
				$this->response->redirect('workflow');
			}
			else{
				sferror(__tr('wf_txt_database_update_error'));
				$this->response->render('header');
				$this->response->render('update', $data);
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('update', $data);
			$this->response->render('footer');
		}
	}

	public function detail($id){
		$wf = $this->workflow_model->getSingleRecord($id);
		if(!$wf){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['wf'] = $wf;
		$data['roles'] = $this->wf_role_model->getRolesForWorkflow($id);
		$data['nodes'] = $this->wf_node_model->getList($id, -1, -1, -1, -1);
		$data['nodes_path'] = $this->wf_node_path_model->getNodesPathForWorkflow($id, -1, -1);
		
		$this->response->render('header');
		$this->response->render('detail', $data);
		$this->response->render('footer');
	}

	public function delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('workflow');
		}
		foreach($ids as $id){
			$wf = $this->workflow_model->getSingleRecord($id);
			if($wf){
				//delete it
				$deleted = $this->workflow_model->delete($id);
				if($deleted){
					//delete from instance
					$this->loader->model('wf_instance_model');
					$this->wf_instance_model->delete_by('wf_id', $id);

					//delete from node
					$this->wf_node_model->delete_by('wf_id', $id);

					//delete from node_path
					$this->wf_node_path_model->delete_by('wf_id', $id);

					//delete from role
					$this->wf_role_model->delete_by('wf_id', $id);
				}
			}
		}
		$this->workflow_model->delete_many($ids);
		sfsuccess(__tr('wf_txt_database_delete_ok'));
		$this->response->redirect('workflow');
	}
	////////////////////////////////////////////////// WORKFLOW END ///////////////////////////////////////////////


	////////////////////////////////////////////////// WORKFLOW NODE START ///////////////////////////////////////////////
	public function node_add($wf_id){
		$wf = $this->workflow_model->getSingleRecord($wf_id);
		if(!$wf){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['wf'] = $wf;
		$data['roles'] = $this->wf_role_model->getRolesForWorkflow($wf_id);
		$serviceList = get_service_method_list();
		$data['service_list'] = $serviceList;

		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_node_name'), 'required|min_length[2]');
		$v->setRule('task_type', __tr('wf_field_node_task_type'), 'required');
		$v->setRule('node_type', __tr('wf_field_node_type'), 'required');
		$v->setRule('script', __tr('wf_field_node_script'), 'min_length[2]');
		$v->setRule('service', __tr('wf_field_node_service'), 'min_length[2]');
		$v->setRule('service_arg', __tr('wf_field_node_service_args'), 'min_length[1]');
		$v->setRule('status', __tr('wf_field_node_state'), 'required');
		//$v->setRule('role', __tr('wf_field_role'), ''); //only for User Task
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$task_type = $this->request->post('task_type');
			$node_type = $this->request->post('node_type');
			$script = $this->request->post('script',  false);
			$service = $this->request->post('service');
			$service_arg = $this->request->post('service_arg');
			$status = $this->request->post('status');
			$role = $this->request->post('role');

			$error = null;

			$exists = $this->wf_node_model->getSingleRecordCond(array(
											'wf_node_name' => $name,
											'wf_id' => $wf_id
										));
			if($exists){
				$error = __tr('wf_txt_node_already_exists_error');	
			}

			if(is_start_node($node_type)){
				//check if already exists
				$start = $this->wf_node_model->getSingleRecordCond(array(
					'wf_id' => $wf_id,
					'wf_node_type' => 1, //1 = Start Node
				));
				if($start){
					$error = __tr('wf_txt_start_node_already_exists_error');	
				}
			}

			if(is_end_node($node_type)){
				//check if already exists
				$end = $this->wf_node_model->getSingleRecordCond(array(
					'wf_id' => $wf_id,
					'wf_node_type' => 3, //3 = End Node
				));
				if($end){
					$error = __tr('wf_txt_end_node_already_exists_error');	
				}
			}

			if(is_user_node($task_type) && ! is_start_node($node_type) && ! is_end_node($node_type) && empty($role)){
				$error = __tr('wf_txt_role_required_for_user_node_error');	
			}

			if(is_script_node($task_type) && empty($script)){
				$error = __tr('wf_txt_script_required_for_script_node_error');	
			}

			if(is_service_node($task_type)){
				if(empty($service)){
					$error = __tr('wf_txt_service_required_for_service_node_error');	
				}
				else if(isset($serviceList[$service]) && count(explode(',', $service_arg)) < $serviceList[$service]['required_arg']){
					$error = __tr('wf_txt_service_arg_required_for_service_method_error');	
				}
			}

			if($error){
				sferror($error);
				$this->response->render('header');
				$this->response->render('node/add', $data);
				$this->response->render('footer');
			}
			else{
				$params = array(
					'wf_node_name' => $name,
					'wf_node_task_type' => $task_type,
					'wf_node_type' => $node_type,
					'wf_node_script' => is_script_node($task_type) ? $script : '',
					'wf_node_service' => is_service_node($task_type) ? ($service .': ' . $service_arg) :'',
					'wf_node_status' => $status,
					'wf_id' => $wf_id
				);
				//role add only for user node
				if(is_user_node($task_type) && $role){
					$params['wf_role_id'] = $role;
				}
				else{
					$params['wf_role_id'] = 0;
				}

				$id = $this->wf_node_model->insert($params);
				if($id){
					sfsuccess(__tr('wf_txt_database_insert_ok'));
					$this->response->redirect('workflow/detail/' . $wf_id);
				}
				else{
					sferror(__tr('wf_txt_database_insert_error'));
					$this->response->render('header');
					$this->response->render('node/add', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('node/add', $data);
			$this->response->render('footer');
		}
	}

	public function node_update($id){
		$node = $this->wf_node_model->getSingleRecord($id);
		if(!$node){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['node'] = $node;
		$data['roles'] = $this->wf_role_model->getRolesForWorkflow($node->wf_id);
		$serviceList = get_service_method_list();
		$data['service_list'] = $serviceList;

		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_node_name'), 'required|min_length[2]');
		$v->setRule('task_type', __tr('wf_field_node_task_type'), 'required');
		$v->setRule('node_type', __tr('wf_field_node_type'), 'required');
		$v->setRule('script', __tr('wf_field_node_script'), 'min_length[2]');
		$v->setRule('service', __tr('wf_field_node_service'), 'min_length[2]');
		$v->setRule('service_arg', __tr('wf_field_node_service_args'), 'min_length[1]');
		$v->setRule('status', __tr('wf_field_node_state'), 'required');
		//$v->setRule('role', __tr('wf_field_role'), ''); //only for User Task
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$task_type = $this->request->post('task_type');
			$node_type = $this->request->post('node_type');
			$script = $this->request->post('script', false);
			$service = $this->request->post('service');
			$service_arg = $this->request->post('service_arg');
			$status = $this->request->post('status');
			$role = $this->request->post('role');

			$error = null;
			if(is_start_node($node_type)){
				//check if already exists
				$start = $this->wf_node_model->getSingleRecordCond(array(
					'wf_id' => $node->wf_id,
					'wf_node_type' => 1, //1 = Start Node
				));
				if($start && $start->wf_node_id != $id){
					$error = __tr('wf_txt_start_node_already_exists_error');	
				}
			}

			if(is_end_node($node_type)){
				//check if already exists
				$end = $this->wf_node_model->getSingleRecordCond(array(
					'wf_id' => $node->wf_id,
					'wf_node_type' => 3, //3 = End Node
				));
				if($end && $end->wf_node_id != $id){
					$error = __tr('wf_txt_end_node_already_exists_error');	
				}
			}

			if(is_user_node($task_type) && ! is_start_node($node_type) && ! is_end_node($node_type) && empty($role)){
				$error = __tr('wf_txt_role_required_for_user_node_error');	
			}

			if(is_script_node($task_type) && empty($script)){
				$error = __tr('wf_txt_script_required_for_script_node_error');	
			}

			if(is_service_node($task_type)){
				if(empty($service)){
					$error = __tr('wf_txt_service_required_for_service_node_error');	
				}
				else if(isset($serviceList[$service]) && count(explode(',', $service_arg)) < $serviceList[$service]['required_arg']){
					$error = __tr('wf_txt_service_arg_required_for_service_method_error');	
				}
			}

			if($error){
				sferror($error);
				$this->response->render('header');
				$this->response->render('node/update', $data);
				$this->response->render('footer');
			}
			else{
				$params = array(
					'wf_node_name' => $name,
					'wf_node_task_type' => $task_type,
					'wf_node_type' => $node_type,
					'wf_node_script' => is_script_node($task_type) ? $script : '',
					'wf_node_service' => is_service_node($task_type) ? ($service .': ' . $service_arg) :'',
					'wf_node_status' => $status
				);
				//role add only for user node
				if(is_user_node($task_type) && $role){
					$params['wf_role_id'] = $role;
				}
				else{
					$params['wf_role_id'] = 0;
				}

				$update = $this->wf_node_model->update($id, $params);
				if($update){
					sfsuccess(__tr('wf_txt_database_update_ok'));
					if($this->request->get('from_detail')){
						$this->response->redirect('workflow/node_detail/' . $id);
					}
					$this->response->redirect('workflow/detail/' . $node->wf_id);
				}
				else{
					sferror(__tr('wf_txt_database_update_error'));
					$this->response->render('header');
					$this->response->render('node/update', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('node/update', $data);
			$this->response->render('footer');
		}
	}

	public function node_detail($id){
		$node = $this->wf_node_model->getInfo($id);
		if(!$node){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['node'] = $node;
		if(is_user_node($node->wf_node_task_type) && ! is_start_node($node->wf_node_type) && ! is_end_node($node->wf_node_type)){
			$data['outcomes'] = $this->wf_node_outcome_model->getList($id);
		}

		$this->response->render('header');
		$this->response->render('node/detail', $data);
		$this->response->render('footer');
	}

	public function node_delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('workflow');
		}
		$wf_id = null;
		foreach($ids as $id){
			$node = $this->wf_node_model->getSingleRecord($id);
			if($node){
				$wf_id = $node->wf_id;
				//delete it
				$deleted = $this->wf_node_model->delete($id);
				if($deleted){
					//delete from node_path
					$this->wf_node_path_model->delete_by('wf_node_from_id', $id);
					$this->wf_node_path_model->delete_by('wf_node_to_id', $id);

					//delete from node_outcome
					$this->wf_node_outcome_model->delete_by('wf_node_id', $id);

					//delete from task
					$this->loader->model('workflow/wf_task_model');
					$this->wf_task_model->delete_by('wf_node_id', $id);
				}
			}
		}
		sfsuccess(__tr('wf_txt_database_delete_ok'));
		if($wf_id){
			$this->response->redirect('workflow/detail/' . $wf_id);
		}
		$this->response->redirect('workflow');
	}

	////////////////////////////////////////////////// WORKFLOW NODE END ///////////////////////////////////////////////


	////////////////////////////////////////////////// WORKFLOW NODE PATH START ///////////////////////////////////////////////
	public function node_path_add($wf_id){
		$wf = $this->workflow_model->getSingleRecord($wf_id);
		if(!$wf){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['wf'] = $wf;
		$data['nodes'] = $this->wf_node_model->getList($wf_id, -1, -1, -1, -1);
		$data['outcomes'] = $this->wf_node_outcome_model->getList(-1, $wf_id);

		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('node_from', __tr('wf_field_node_path_node_from'), 'required');
		$v->setRule('node_to', __tr('wf_field_node_path_node_to'), 'required');
		$v->setRule('name', __tr('wf_field_node_path_name'), 'min_length[1]');
		$v->setRule('cond_type', __tr('wf_field_node_path_cond_type'), 'min_length[1]');
		$v->setRule('cond_name', __tr('wf_field_node_path_cond_name'), 'min_length[1]');
		$v->setRule('cond_operator', __tr('wf_field_node_path_cond_operator'), 'min_length[1]');
		$v->setRule('cond_value', __tr('wf_field_node_path_cond_value'), 'min_length[1]');
		$v->setRule('cond_oc_value', __tr('wf_field_node_path_cond_outcome_value'), 'min_length[1]');
		$v->setRule('order', __tr('wf_field_node_path_order'), 'numeric');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$cond_type = $this->request->post('cond_type');
			$cond_operator = $this->request->post('cond_operator', false);
			$cond_name = $this->request->post('cond_name');
			$cond_value = $this->request->post('cond_value');
			$cond_oc_value = $this->request->post('cond_oc_value');
			$order = $this->request->post('order');
			$node_from = $this->request->post('node_from');
			$node_to = $this->request->post('node_to');
			$is_default = $this->request->post('is_default') ? 1 : 0;

			//get nodes details
			$onode_from = $this->wf_node_model->getSingleRecord($node_from);
			$onode_to = $this->wf_node_model->getSingleRecord($node_to);
			
			$error = null;

			if(! $onode_from || ! $onode_to){
				sferror(__tr('wf_txt_node_path_node_from_or_to_not_exists_error'));
				$this->response->redirect('workflow/detail/' . $wf_id);
			}

			$exists = $this->wf_node_path_model->getSingleRecordCond(array(
											'wf_node_from_id' => $node_from,
											'wf_node_to_id' => $node_to
										));
			if($exists){
				$error = __tr('wf_txt_node_path_already_exists_error');	
			}
			else{
				if($node_from == $node_to){
					$error = __tr('wf_txt_source_destination_node_is_same_error');	
				}
				
				if(is_start_node($onode_to->wf_node_type)){
					$error = __tr('wf_txt_start_node_is_destination_node_error');
				}
				if(is_end_node($onode_from->wf_node_type)){
					$error = __tr('wf_txt_end_node_is_source_node_error');
				}
				if(is_decision_node($onode_from->wf_node_task_type) && is_decision_node($onode_to->wf_node_task_type)){
					$error = __tr('wf_txt_decision_node_for_source_destination_error');
				}
				
				$node_path_src = $this->wf_node_path_model->getSingleRecordCond('wf_node_from_id', $node_from);
				if($node_path_src && ! is_decision_node($onode_from->wf_node_task_type)){
					$error = __tr('wf_txt_multiple_destination_path_for_no_decision_node_error');
				}

				if($cond_type){
					if(empty($cond_operator)){
						$error = __tr('wf_txt_condition_operator_required_error');
					}

					if($cond_type != 'outcome' && strlen($cond_value) <= 0){
						$error = __tr('wf_txt_condition_value_required_error');
					}

					if($cond_type == 'outcome' && empty($cond_oc_value)){
						$error = __tr('wf_txt_condition_outcome_value_required_error');
					}

					if($cond_type == 'entity' && empty($cond_name)){
						$error = __tr('wf_txt_condition_entity_name_required_error');
					}
				}
			}

			if($error){
				sferror($error);
				$this->response->render('header');
				$this->response->render('node_path/add', $data);
				$this->response->render('footer');
			}
			else{
				if($cond_type == 'outcome'){
					$cond_value = $cond_oc_value;
				}

				$params = array(
					'wf_np_name' => $name,
					'wf_np_cond_type' => $cond_type,
					'wf_np_cond_name' => $cond_name,
					'wf_np_cond_operator' => $cond_operator,
					'wf_np_cond_value' => $cond_value,
					'wf_node_from_id' => $node_from,
					'wf_node_to_id' => $node_to,
					'wf_np_is_default' => $is_default,
					'wf_id' => $wf_id
				);
				if(strlen($order) > 0){
					$params['wf_np_order'] = $order;
				}
				$id = $this->wf_node_path_model->insert($params);
				if($id){
					sfsuccess(__tr('wf_txt_database_insert_ok'));
					$this->response->redirect('workflow/detail/' . $wf_id);
				}
				else{
					sferror(__tr('wf_txt_database_insert_error'));
					$this->response->render('header');
					$this->response->render('node_path/add', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('node_path/add', $data);
			$this->response->render('footer');
		}
	}

	public function node_path_update($id){
		$node_path = $this->wf_node_path_model->getSingleRecord($id);
		if(!$node_path){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['node_path'] = $node_path;
		$data['nodes'] = $this->wf_node_model->getList($node_path->wf_id, -1, -1, -1, -1);
		$data['outcomes'] = $this->wf_node_outcome_model->getList(-1, $node_path->wf_id);

		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('node_from', __tr('wf_field_node_path_node_from'), 'required');
		$v->setRule('node_to', __tr('wf_field_node_path_node_to'), 'required');
		$v->setRule('name', __tr('wf_field_node_path_name'), 'min_length[1]');
		$v->setRule('cond_type', __tr('wf_field_node_path_cond_type'), 'min_length[1]');
		$v->setRule('cond_name', __tr('wf_field_node_path_cond_name'), 'min_length[1]');
		$v->setRule('cond_operator', __tr('wf_field_node_path_cond_operator'), 'min_length[1]');
		$v->setRule('cond_value', __tr('wf_field_node_path_cond_value'), 'min_length[1]');
		$v->setRule('cond_oc_value', __tr('wf_field_node_path_cond_outcome_value'), 'min_length[1]');
		$v->setRule('order', __tr('wf_field_node_path_order'), 'numeric');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$cond_type = $this->request->post('cond_type');
			$cond_operator = $this->request->post('cond_operator', false);
			$cond_name = $this->request->post('cond_name');
			$cond_value = $this->request->post('cond_value');
			$cond_oc_value = $this->request->post('cond_oc_value');
			$order = $this->request->post('order');
			$node_from = $this->request->post('node_from');
			$node_to = $this->request->post('node_to');
			$is_default = $this->request->post('is_default') ? 1 : 0;

			//get nodes details
			$onode_from = $this->wf_node_model->getSingleRecord($node_from);
			$onode_to = $this->wf_node_model->getSingleRecord($node_to);
			
			$error = null;

			if(! $onode_from || ! $onode_to){
				sferror(__tr('wf_txt_node_path_node_from_or_to_not_exists_error'));
				$this->response->redirect('workflow/detail/' . $node_path->wf_id);
			}

			if($node_from == $node_to){
				$error = __tr('wf_txt_source_destination_node_is_same_error');	
			}

			if(is_start_node($onode_to->wf_node_type)){
				$error = __tr('wf_txt_start_node_is_destination_node_error');
			}

			if(is_end_node($onode_from->wf_node_type)){
				$error = __tr('wf_txt_end_node_is_source_node_error');
			}

			if(is_decision_node($onode_from->wf_node_task_type) && is_decision_node($onode_to->wf_node_task_type)){
				$error = __tr('wf_txt_decision_node_for_source_destination_error');
			}

			$node_path_src = $this->wf_node_path_model->getSingleRecordCond('wf_node_from_id', $node_from);
			if($node_path_src && $node_path_src->wf_node_from_id != $node_path->wf_node_from_id && ! is_decision_node($onode_from->wf_node_task_type)){
				$error = __tr('wf_txt_multiple_destination_path_for_no_decision_node_error');
			}

			if($cond_type){
				if(empty($cond_operator)){
					$error = __tr('wf_txt_condition_operator_required_error');
				}

				if($cond_type != 'outcome' && strlen($cond_value) <= 0){
					$error = __tr('wf_txt_condition_value_required_error');
				}

				if($cond_type == 'outcome' && empty($cond_oc_value)){
					$error = __tr('wf_txt_condition_outcome_value_required_error');
				}

				if($cond_type == 'entity' && empty($cond_name)){
					$error = __tr('wf_txt_condition_entity_name_required_error');
				}
			}

			if($error){
				sferror($error);
				$this->response->render('header');
				$this->response->render('node_path/update', $data);
				$this->response->render('footer');
			}
			else{
				if($cond_type == 'outcome'){
					$cond_value = $cond_oc_value;
				}
				$params = array(
					'wf_np_name' => $name,
					'wf_np_cond_type' => $cond_type,
					'wf_np_cond_name' => $cond_name,
					'wf_np_cond_operator' => $cond_operator,
					'wf_np_cond_value' => $cond_value,
					'wf_node_from_id' => $node_from,
					'wf_node_to_id' => $node_to,
					'wf_np_is_default' => $is_default,
				);
				if(strlen($order) > 0){
					$params['wf_np_order'] = $order;
				}
				$update = $this->wf_node_path_model->update($id, $params);
				if($update){
					sfsuccess(__tr('wf_txt_database_update_ok'));
					$this->response->redirect('workflow/detail/' . $node_path->wf_id);
				}
				else{
					sferror(__tr('wf_txt_database_update_error'));
					$this->response->render('header');
					$this->response->render('node_path/update', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('node_path/update', $data);
			$this->response->render('footer');
		}
	}

	public function node_path_delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('workflow');
		}
		$wf_id = null;
		foreach($ids as $id){
			$node_path = $this->wf_node_path_model->getSingleRecord($id);
			if($node_path){
				$wf_id = $node_path->wf_id;
				//delete it
				$this->wf_node_path_model->delete($id);
			}
		}
		sfsuccess(__tr('wf_txt_database_delete_ok'));
		if($wf_id){
			$this->response->redirect('workflow/detail/' . $wf_id);
		}
		$this->response->redirect('workflow');
	}

	////////////////////////////////////////////////// WORKFLOW NODE PATH END ///////////////////////////////////////////////


	////////////////////////////////////////////////// WORKFLOW ROLE START ///////////////////////////////////////////////
	public function role_add($wf_id){
		$wf = $this->workflow_model->getSingleRecord($wf_id);
		if(!$wf){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['wf'] = $wf;
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_role_name'), 'required|min_length[2]');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$exists = $this->wf_role_model->getSingleRecordCond(array(
											'wf_role_name' => $name,
											'wf_id' => $wf_id
										));
			if($exists){
				sferror(__tr('wf_txt_role_already_exists_error'));
				$this->response->render('header');
				$this->response->render('role/add', $data);
				$this->response->render('footer');
			}
			else{
				$params = array(
					'wf_role_name' => $name,
					'wf_id' => $wf_id
				);
				$id = $this->wf_role_model->insert($params);
				if($id){
					sfsuccess(__tr('wf_txt_database_insert_ok'));
					$this->response->redirect('workflow/detail/' . $wf_id);
				}
				else{
					sferror(__tr('wf_txt_database_insert_error'));
					$this->response->render('header');
					$this->response->render('role/add', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('role/add', $data);
			$this->response->render('footer');
		}
	}

	public function role_update($id){
		$role = $this->wf_role_model->getSingleRecord($id);
		if(!$role){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['role'] = $role;
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_role_name'), 'required|min_length[2]|is_unique_update[wf_role.wf_role_name,wf_role_id=' . $id . ']');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			
			$params = array(
				'wf_role_name' => $name
			);
			$update = $this->wf_role_model->update($id, $params);
			if($update){
				sfsuccess(__tr('wf_txt_database_update_ok'));
				$this->response->redirect('workflow/detail/' . $role->wf_id);
			}
			else{
				sferror(__tr('wf_txt_database_update_error'));
				$this->response->render('header');
				$this->response->render('role/update', $data);
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('role/update', $data);
			$this->response->render('footer');
		}
	}

	public function role_delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('workflow');
		}
		$wf_id = null;
		foreach($ids as $id){
			$role = $this->wf_role_model->getSingleRecord($id);
			if($role){
				$wf_id = $role->wf_id;
				//delete it
				$this->wf_role_model->delete($id);
			}
		}
		sfsuccess(__tr('wf_txt_database_delete_ok'));
		if($wf_id){
			$this->response->redirect('workflow/detail/' . $wf_id);
		}
		$this->response->redirect('workflow');
	}
	////////////////////////////////////////////////// WORKFLOW ROLE END ///////////////////////////////////////////////


	////////////////////////////////////////////////// WORKFLOW NODE OUTCOME START ///////////////////////////////////////////////
	public function outcome_add($node_id){
		$node = $this->wf_node_model->getSingleRecord($node_id);
		if(!$node){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		else if(! is_user_node($node->wf_node_task_type) || is_start_node($node->wf_node_type) || is_end_node($node->wf_node_type)){
			sferror(__tr('wf_txt_add_outcome_not_user_task_or_start_end_node_error'));
			$this->response->redirect('workflow/node_detail/' . $node_id);
		}
		$data['node'] = $node;
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_node_oc_name'), 'required|min_length[2]');
		$v->setRule('code', __tr('wf_field_node_oc_code'), 'required|alnum_dash');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$code = $this->request->post('code');
			$exists = $this->wf_node_outcome_model->getSingleRecordCond(array(
											'wf_oc_name' => $name,
											'wf_node_id' => $node_id
										));
			if($exists){
				sferror(__tr('wf_txt_outcome_already_exists_error'));
				$this->response->render('header');
				$this->response->render('outcome/add', $data);
				$this->response->render('footer');
			}
			else{
				$params = array(
					'wf_oc_code' => $code,
					'wf_oc_name' => $name,
					'wf_node_id' => $node_id
				);
				$id = $this->wf_node_outcome_model->insert($params);
				if($id){
					sfsuccess(__tr('wf_txt_database_insert_ok'));
					$this->response->redirect('workflow/node_detail/' . $node_id);
				}
				else{
					sferror(__tr('wf_txt_database_insert_error'));
					$this->response->render('header');
					$this->response->render('outcome/add', $data);
					$this->response->render('footer');
				}
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('outcome/add', $data);
			$this->response->render('footer');
		}
	}

	public function outcome_update($id){
		$outcome = $this->wf_node_outcome_model->getSingleRecord($id);
		if(!$outcome){
			sfwarning(__tr('wf_txt_database_data_not_exists'));
			$this->response->redirect('workflow');
		}
		$data['outcome'] = $outcome;
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('name', __tr('wf_field_node_oc_name'), 'required|min_length[2]');
		$v->setRule('code', __tr('wf_field_node_oc_code'), 'required|alnum_dash');
		
		if ($v->validate() === true) {
			$name = $this->request->post('name');
			$code = $this->request->post('code');
			
			$params = array(
				'wf_oc_code' => $code,
				'wf_oc_name' => $name
					);
			$update = $this->wf_node_outcome_model->update($id, $params);
			if($update){
				sfsuccess(__tr('wf_txt_database_update_ok'));
				$this->response->redirect('workflow/node_detail/' . $outcome->wf_node_id);
			}
			else{
				sferror(__tr('wf_txt_database_update_error'));
				$this->response->render('header');
				$this->response->render('outcome/update', $data);
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('outcome/update', $data);
			$this->response->render('footer');
		}
	}

	public function outcome_delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('workflow');
		}
		$node_id = null;
		foreach($ids as $id){
			$outcome = $this->wf_node_outcome_model->getSingleRecord($id);
			if($outcome){
				$node_id = $outcome->wf_node_id;
				//delete it
				$this->wf_node_outcome_model->delete($id);
			}
		}
		sfsuccess(__tr('wf_txt_database_delete_ok'));
		if($node_id){
			$this->response->redirect('workflow/node_detail/' . $node_id);
		}
		$this->response->redirect('workflow');
	}
	////////////////////////////////////////////////// WORKFLOW NODE OUTCOME END ///////////////////////////////////////////////
}
