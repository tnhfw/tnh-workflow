<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Leave_model extends Model {

      protected $table = 'leaves';
      protected $primaryKey = 'leav_id';

      protected $manyToOne = array(
                                    'workflow' => array('primary_key' => 'wf_id', 'model' => 'workflow_model')
                                  );
        
        public function __construct(){
            parent::__construct();
        }

 
    }
