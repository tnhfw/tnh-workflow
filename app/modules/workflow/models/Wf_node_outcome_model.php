<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_node_outcome_model extends Model {

      protected $table = 'wf_node_outcome';
      protected $primaryKey = 'wf_oc_id';
        
        public function __construct(){
            parent::__construct();
        }

        public function getList($node_id = -1, $wf_id = -1){
            $this->getQueryBuilder()->select('wf_node_outcome.*, wn.wf_node_name')
                                    ->from($this->table)
                                    ->leftJoin('wf_node wn', 'wn.wf_node_id = wf_node_outcome.wf_node_id')
                                     ->leftJoin('workflow wf', 'wn.wf_id = wf.wf_id');
            if($node_id != -1){
              $this->getQueryBuilder()->where('wf_node_outcome.wf_node_id', $node_id);
            }
             if($wf_id != -1){
              $this->getQueryBuilder()->where('wn.wf_id', $wf_id);
            }
            return $this->db->getAll();
        }

 
    }
