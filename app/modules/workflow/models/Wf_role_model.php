<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_role_model extends Model {

      protected $table = 'wf_role';
      protected $primaryKey = 'wf_role_id';
        
        public function __construct(){
            parent::__construct();
        }

         public function getRolesForWorkflow($wf_id){
            $this->getQueryBuilder()->select('wf_role.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_role.wf_id')
                                    ->where('wf_role.wf_id', $wf_id);
            return $this->db->getAll();
        }

 
    }
