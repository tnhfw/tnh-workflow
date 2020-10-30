<?php
	defined('ROOT_PATH') || exit('Access denied');

	/**
	 * 
	 */
	class Users extends Controller {
		/**
		 * the class constructor
		 */
		public function __construct() {
			parent::__construct();
			$this->loader->model('users_model');
		}		


		public function login(){
			$this->loader->library('FormValidation');
			$v = $this->formvalidation;
			$v->setRule('username', 'username', 'required');
			if($v->validate() === true){
				$username = strtolower($this->request->post('username'));
				$user = $this->users_model->getSingleRecordCond('user_name', $username);
				if(!$user){
					sferror('Auth credential error');
					$this->response->render('users/login');
				}
				else{
					//save user information into session
					$data = array();
					$data['id'] = $user->user_id;
					$data['login'] = $user->user_name;
					$this->session->set('auth_session', $data);
					unset($data);
					//go to home page
					$this->response->redirect();
				}
			}
			else{
				$this->response->render('users/login');
			}
		}

		

		public function logout(){
			$this->session->clear('auth_session');
			//go to login page
			$this->response->redirect('users/login');
		}

	}
