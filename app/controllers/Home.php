<?php
	defined('ROOT_PATH') || exit('Access denied');

	/**
	 * 
	 */
	class Home extends Controller {

		/**
		 * the class constructor
		 */
		public function __construct() {
			parent::__construct();
			auth();
		}

		/**
		 * The default method
		 * @return null
		 */
		function index() {
			$this->response->render('header');
			$this->response->render('footer');
		}

		public function set_lang($l){
			//set the lang
			if($this->lang->isValid($l) && $l != $this->lang->getCurrent()){
				$this->loader->library('Cookie');
				$this->cookie->set($this->config->get('language_cookie_name'), $l, $expire = 2 * 86400 /* 2 days*/);
			}
			$referer = $this->request->server('HTTP_REFERER');
			if($referer){
				$this->response->redirect($referer);
			}
			$this->response->redirect();
		}
	}
