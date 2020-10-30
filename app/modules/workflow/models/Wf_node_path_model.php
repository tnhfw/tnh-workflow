<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_node_path_model extends Model {

      protected $table = 'wf_node_path';
      protected $primaryKey = 'wf_np_id';
        
        public function __construct(){
            parent::__construct();
        }

         public function getNodesPathForWorkflow($wf_id, $from_id = -1, $to_id = -1){
            $this->getQueryBuilder()->select('wf_node_path.*, frole.wf_role_name from_role_name, trole.wf_role_name to_role_name, fnode.wf_node_name from_name, fnode.wf_node_task_type from_task_type, fnode.wf_node_type from_type, fnode.wf_node_script from_script, fnode.wf_node_service from_service, fnode.wf_node_status from_status, tnode.wf_node_name to_name, tnode.wf_node_task_type to_task_type, tnode.wf_node_type to_type, tnode.wf_node_script to_script, tnode.wf_node_service to_service, tnode.wf_node_status to_status')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_node_path.wf_id')
                                    ->leftJoin('wf_node fnode', 'fnode.wf_node_id = wf_node_path.wf_node_from_id')
                                    ->leftJoin('wf_node tnode', 'tnode.wf_node_id = wf_node_path.wf_node_to_id')
                                    ->leftJoin('wf_role frole', 'frole.wf_role_id = fnode.wf_role_id')
                                    ->leftJoin('wf_role trole', 'trole.wf_role_id = tnode.wf_role_id')
                                    ->where('wf_node_path.wf_id', $wf_id)
                                    ->orderBy('fnode.wf_node_type')
                                    ->orderBy('tnode.wf_node_type');
            if($from_id != -1){
              $this->getQueryBuilder()->where('wf_node_path.wf_node_from_id', $from_id);
            }
            if($to_id != -1){
              $this->getQueryBuilder()->where('wf_node_path.wf_node_to_id', $to_id);
            }
            return $this->db->getAll();
        }

        public function getNextNodeForWorkflow($wf_id, $from_id = -1, $status = -1){
            $this->getQueryBuilder()->select('tnode.*')
                                    ->from($this->table)
                                    ->join('workflow wf', 'wf.wf_id = wf_node_path.wf_id')
                                    ->join('wf_node fnode', 'fnode.wf_node_id = wf_node_path.wf_node_from_id')
                                    ->join('wf_node tnode', 'tnode.wf_node_id = wf_node_path.wf_node_to_id')
                                    ->where('wf_node_path.wf_id', $wf_id)
                                    ->where('wf_node_path.wf_node_from_id', $from_id);
            if($status != -1){
              $this->getQueryBuilder()->where('tnode.wf_node_status', $status);
            }
            return $this->db->get();
        }

         public function getNextNodeDecisionListForWorkflow($wf_id, $from_id = -1, $status = -1){
            $this->getQueryBuilder()->select('tnode.*, wf_node_path.*')
                                    ->from($this->table)
                                    ->join('workflow wf', 'wf.wf_id = wf_node_path.wf_id')
                                    ->join('wf_node fnode', 'fnode.wf_node_id = wf_node_path.wf_node_from_id')
                                    ->join('wf_node tnode', 'tnode.wf_node_id = wf_node_path.wf_node_to_id')
                                    ->where('wf_node_path.wf_id', $wf_id)
                                    ->where('wf_node_path.wf_node_from_id', $from_id)
                                    ->orderBy('wf_node_path.wf_np_order');
            if($status != -1){
              $this->getQueryBuilder()->where('tnode.wf_node_status', $status);
            }
            return $this->db->getAll();
        }
 
    }
