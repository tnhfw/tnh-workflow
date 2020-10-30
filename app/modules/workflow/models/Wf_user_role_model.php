<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_user_role_model extends Model {

      protected $table = 'wf_user_role';
      protected $primaryKey = 'wf_ur_id';
        
        public function __construct(){
            parent::__construct();
        }

        public function getList($inst_id = -1, $role_id = -1, $user_id = -1){
           $this->getQueryBuilder()->select('wf_user_role.*, u.*, wr.*')
                                    ->from($this->table)
                                    ->join('users u', 'u.user_id = wf_user_role.user_id')
                                    ->join('wf_role wr', 'wr.wf_role_id = wf_user_role.wf_role_id')
                                    ->join('wf_instance wi', 'wi.wf_inst_id = wf_user_role.wf_inst_id');
            if($inst_id != -1){
              $this->getQueryBuilder()->where('wf_user_role.wf_inst_id', $inst_id);
            }
            if($role_id != -1){
              $this->getQueryBuilder()->where('wf_user_role.wf_role_id', $role_id);
            }
            if($user_id != -1){
              $this->getQueryBuilder()->where('wf_user_role.user_id', $user_id);
            }
            return $this->db->getAll();
        }

 
    }
