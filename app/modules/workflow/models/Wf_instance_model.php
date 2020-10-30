<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Wf_instance_model extends Model {

      protected $table = 'wf_instance';
      protected $primaryKey = 'wf_inst_id';
        
        public function __construct(){
            parent::__construct();
        }

        public function getForEntity($entity_id, $entity_name, $canceled = false){
          $this->getQueryBuilder()->select('wf_instance.*')
                                  ->from($this->table)
                                  ->where('wf_instance.wf_inst_entity_id', $entity_id)
                                  ->where('wf_instance.wf_inst_entity_name', $entity_name);
            if(! $canceled){
              $this->getQueryBuilder()->where('wf_instance.wf_inst_state', '!=', 'C');
            }
            return $this->db->get();
        }

        public function getList($begin_date = null, $end_date = null, $offset = -1, $limit = -1, $wf_id = -1, $state = -1, $entity_name = '', $start_by_id = -1){
            $this->getQueryBuilder()->select('wf_instance.*, u.user_name start_user_name, wf.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_instance.wf_id')
                                    ->leftJoin('users u', 'u.user_id = wf_instance.start_by_id')
                                    ->orderBy('wf_instance.wf_inst_start_date', 'DESC');
            if($offset != -1 && $limit != -1){
              $this->getQueryBuilder()->limit($offset, $limit);
            }
            if($begin_date != null){
              $this->getQueryBuilder()->where('wf_inst_start_date', '>=', $begin_date);
            }
            if($end_date != null){
              $this->getQueryBuilder()->limit('wf_inst_end_date', '<=', $end_date);
            }
            if($wf_id != -1){
              $this->getQueryBuilder()->where('wf_instance.wf_id', $wf_id);
            }
            if($state != -1){
              $this->getQueryBuilder()->where('wf_instance.wf_inst_state', $state);
            }
            if($entity_name != ''){
              $this->getQueryBuilder()->where('wf_instance.wf_inst_entity_name', $entity_name);
            }
            if($start_by_id != -1){
              $this->getQueryBuilder()->where('wf_instance.start_by_id', $start_by_id);
            }
            return $this->db->getAll();
        }

        public function getInfo($inst_id, $state = -1){
            $this->getQueryBuilder()->select('wf_instance.*, u.user_name start_user_name, wf.*')
                                    ->from($this->table)
                                    ->leftJoin('workflow wf', 'wf.wf_id = wf_instance.wf_id')
                                    ->leftJoin('users u', 'u.user_id = wf_instance.start_by_id')
                                    ->where('wf_instance.wf_inst_id', $inst_id);
            if($state != -1){
              $this->getQueryBuilder()->where('wf_instance.wf_inst_state', $state);
            }
            return $this->db->get();
        }
    }
