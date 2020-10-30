<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_node_model extends Model {

      protected $table = 'wf_node';
      protected $primaryKey = 'wf_node_id';
        
        public function __construct(){
            parent::__construct();
        }

        public function getList($wf_id = -1, $task_type = -1, $node_type = -1, $node_status = -1, $role_id = -1){
            $this->getQueryBuilder()->select('wf_node.*, wr.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_node.wf_id')
                                    ->leftJoin('wf_role wr', 'wr.wf_role_id = wf_node.wf_role_id')
                                    ->orderBy('wf_node.wf_node_type');
            if($wf_id != -1){
              $this->getQueryBuilder()->where('wf_node.wf_id', $wf_id);
            }
            if($task_type != -1){
              $this->getQueryBuilder()->where('wf_node.wf_node_task_type', $task_type);
            }
            if($node_type != -1){
              $this->getQueryBuilder()->where('wf_node.wf_node_type', $node_type);
            }
            if($node_status != -1){
              $this->getQueryBuilder()->where('wf_node.wf_node_status', $node_status);
            }
            if($role_id != -1){
              $this->getQueryBuilder()->where('wf_node.wf_role_id', $role_id);
            }
            return $this->db->getAll();
        }

        public function getStartNodeForWorkflow($wf_id, $status = -1){
            $this->getQueryBuilder()->select('wf_node.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_node.wf_id')
                                    ->where('wf_node.wf_node_type', 1) //1 = start event
                                    ->where('wf_node.wf_id', $wf_id);
            if($status != -1){
              $this->getQueryBuilder()->where('wf_node.wf_node_status', $status);
            }
            return $this->db->get();
        }

        public function getEndNodeForWorkflow($wf_id, $status = -1){
            $this->getQueryBuilder()->select('wf_node.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_node.wf_id')
                                    ->where('wf_node.wf_node_type', 3) //3 = end event
                                    ->where('wf_node.wf_id', $wf_id);
            if($status != -1){
              $this->getQueryBuilder()->where('wf_node.wf_node_status', $status);
            }
            return $this->db->get();
        }

        public function getInfo($id){
            $this->getQueryBuilder()->select('wf_node.*, wr.wf_role_name')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_node.wf_id')
                                    ->leftJoin('wf_role wr', 'wr.wf_role_id = wf_node.wf_role_id')
                                    ->where('wf_node.wf_node_id', $id);
            return $this->db->get();
        }

 
    }
