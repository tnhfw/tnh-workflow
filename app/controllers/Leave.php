<?php
defined('ROOT_PATH') or exit('Access denied');

class Leave extends Controller{


	public function __construct(){
		parent::__construct();
		auth();
		$this->loader->model('leave_model');
		$this->loader->model('workflow/workflow_model');
	}

	function index(){
		$data['list'] = $this->leave_model->with('workflow')->getListRecord();
		$this->response->render('header');
		$this->response->render('leave/index', $data);
		$this->response->render('footer');
	}

	public function add(){
		$data['workflows'] = $this->workflow_model->dropdown('wf_name');
		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('desc', __tr('leav_field_desc'), 'required|min_length[2]|is_unique[leaves.leav_desc]');
		$v->setRule('bdate', __tr('leav_field_start_date'), 'required');
		$v->setRule('edate', __tr('leav_field_end_date'), 'required');
		$v->setRule('wf', __tr('leav_field_workflow'), 'required');

		if ($v->validate() === true) {
			$desc = $this->request->post('desc');
			$bdate = $this->request->post('bdate');
			$edate = $this->request->post('edate');
			$wf = $this->request->post('wf');
			
			$params = array(
				'leav_desc' => $desc,
				'leav_bdate' => $bdate,
				'leav_edate' => $edate,
				'leav_state' => 0,
				'wf_id' => $wf
			);
			$id = $this->leave_model->insert($params);
			if($id){
				sfsuccess(__tr('leav_txt_database_insert_ok'));
				$this->response->redirect('leave');
			}
			else{
				sferror(__tr('leav_txt_database_insert_error'));
				$this->response->render('header');
				$this->response->render('leave/add', $data);
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('leave/add', $data);
			$this->response->render('footer');
		}
	}



	public function update($id){
		$leave = $this->leave_model->getSingleRecord($id);
		if(!$leave){
			sfwarning(__tr('leav_txt_database_data_not_exists'));
			$this->response->redirect('leave');
		}
		$data['leave'] = $leave;
		$data['workflows'] = $this->workflow_model->dropdown('wf_name');

		$this->loader->library('FormValidation');
		$v = $this->formvalidation;
		$v->setRule('desc', __tr('leav_field_desc'), 'required|min_length[2]');
		$v->setRule('bdate', __tr('leav_field_start_date'), 'required');
		$v->setRule('edate', __tr('leav_field_end_date'), 'required');
		$v->setRule('wf', __tr('leav_field_workflow'), 'required');

		if ($v->validate() === true) {
			$desc = $this->request->post('desc');
			$bdate = $this->request->post('bdate');
			$edate = $this->request->post('edate');
			$wf = $this->request->post('wf');

			$params = array(
				'leav_desc' => $desc,
				'leav_bdate' => $bdate,
				'leav_edate' => $edate,
				'wf_id' => $wf
			);

			$update = $this->leave_model->update($id, $params);
			if($update){
				sfsuccess(__tr('leav_txt_database_update_ok'));
				$this->response->redirect('leave');
			}
			else{
				sferror(__tr('leav_txt_database_update_error'));
				$this->response->render('header');
				$this->response->render('leave/update', $data);
				$this->response->render('footer');
			}
		}
		else {
			$this->response->render('header');
			$this->response->render('leave/update', $data);
			$this->response->render('footer');
		}
	}

	public function detail($id){
		$leave = $this->leave_model->with('workflow')->getSingleRecord($id);
		if(!$leave){
			sfwarning(__tr('leav_txt_database_data_not_exists'));
			$this->response->redirect('leave');
		}
		$data['leave'] = $leave;
		$this->loader->model('workflow/wf_instance_model');
		$entity_name = get_leave_entity_name();
		$data['instance'] = $this->wf_instance_model->getForEntity($id, $entity_name);

		$this->response->render('header');
		$this->response->render('leave/detail', $data);
		$this->response->render('footer');
	}

	public function delete(){
		$ids = $this->request->post('ids');
		if(empty($ids)){
			$this->response->redirect('leave');
		}
		$this->leave_model->delete_many($ids);
		sfsuccess(__tr('leav_txt_database_delete_ok'));
		$this->response->redirect('leave');
	}

}
