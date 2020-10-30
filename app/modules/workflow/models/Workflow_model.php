<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Workflow_model extends Model {

      protected $table = 'workflow';
      protected $primaryKey = 'wf_id';
        
        public function __construct(){
            parent::__construct();
        }

 
    }
