<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_task_model extends Model {

      protected $table = 'wf_task';
      protected $primaryKey = 'wf_task_id';
        
        public function __construct(){
            parent::__construct();
        }

        public function getList($begin_date = null, $end_date = null, $offset = -1, $limit = -1, $inst_id = -1, $node_id = -1, $oc_id = -1, $user_id = -1, $state = -1, $return_system_cancel_task = false){
            $this->getQueryBuilder()->select('wf_task.*, u.*, wf.*, oc.wf_oc_name, wn.*, wi.*')
                                    ->from($this->table)
                                    ->leftJoin('wf_instance wi', 'wi.wf_inst_id = wf_task.wf_inst_id')
                                    ->leftJoin('workflow wf', 'wf.wf_id = wi.wf_id')
                                    ->leftJoin('users u', 'u.user_id = wf_task.user_id')
                                    ->leftJoin('wf_node wn', 'wn.wf_node_id = wf_task.wf_node_id')
                                    ->leftJoin('wf_node_outcome oc', 'oc.wf_oc_id = wf_task.wf_oc_id')
                                    ->orderBy('wf_task.wf_task_start_time');
            if($offset != -1 && $limit != -1){
              $this->getQueryBuilder()->limit($offset, $limit);
            }
            if(! $return_system_cancel_task){
              $this->getQueryBuilder()->groupStart()
                                      ->where('wf_task_cancel_trigger', '!=', 'S')
                                      ->whereIsNull('wf_task_cancel_trigger', 'OR')
                                      ->groupEnd();
            }
            if($begin_date != null){
              $this->getQueryBuilder()->where('wf_task_start_time', '>=', $begin_date);
            }
            if($end_date != null){
              $this->getQueryBuilder()->limit('wf_task_end_time', '<=', $end_date);
            }
            if($state != -1){
              $this->getQueryBuilder()->where('wf_task.wf_task_status', $state);
            }
            if($inst_id != -1){
              $this->getQueryBuilder()->where('wf_task.wf_inst_id', $inst_id);
            }
            if($node_id != -1){
              $this->getQueryBuilder()->where('wf_task.wf_node_id', $node_id);
            }
            if($user_id != -1){
              $this->getQueryBuilder()->where('wf_task.user_id', $user_id);
            }
             if($oc_id != -1){
              $this->getQueryBuilder()->where('wf_task.wf_oc_id', $oc_id);
            }
            return $this->db->getAll();
        }

        public function getOutcomeResultForNode($inst_id, $node_id){
          $this->getQueryBuilder()->select('woc.wf_oc_code AS code')
                                  ->from($this->table)
                                  ->join('wf_instance wi', 'wi.wf_inst_id = wf_task.wf_inst_id')
                                  ->join('wf_node wn', 'wn.wf_node_id = wf_task.wf_node_id')
                                  ->join('wf_node_outcome woc', 'woc.wf_node_id = wn.wf_node_id')
                                  ->where('wf_task.wf_oc_id', '=', 'woc.wf_oc_id', '', 'AND', $escape = false)
                                  ->where('wf_task.wf_node_id', $node_id)
                                  ->where('wf_task.wf_inst_id', $inst_id) 
                                  ->where('wf_task.wf_task_status', 'T')
                                  ->orderBy('wf_task_end_time', 'DESC'); //it's very important to add ORDER BY here
            return $this->db->get();
        }

        public function getCurrentUserRoleForNodeValidation($user_id, $role_id, $inst_id){
          $this->getQueryBuilder()->select('wf_task.*')
                                  ->from($this->table)
                                  ->join('wf_instance wi', 'wi.wf_inst_id = wf_task.wf_inst_id')
                                  ->join('wf_node wn', 'wn.wf_node_id = wf_task.wf_node_id')
                                  ->join('wf_role wr', 'wr.wf_role_id = wn.wf_role_id')
                                  ->where('wf_task.user_id', $user_id)
                                  ->where('wr.wf_role_id', $role_id)
                                  ->where('wf_task.wf_inst_id', $inst_id)
                                  ->where('wf_task.wf_task_status', 'I');
          return $this->db->getAll();
        }

        

 
    }
