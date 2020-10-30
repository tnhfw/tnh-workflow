<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * Library used for workflow node using service task type
     */
    class WFServiceTaskLib {

        /**
         * This is a test method to demonstrate of service node use
         * @param  int $inst_id the instance id
         * @param  string $str     example string
         * @return string
         */
        public function test($inst_id, $str){
            $random = null;
             for($i = 0; $i < 1; $i++){
             $random .= $str[mt_rand() % strlen($str)];
             }
             return $random;
        }


        /**
         * Used to update the entity state
         * @param mixed $entity_id the entity id
         * @param int $state     the entity state
         */
        public function setLeaveState($entity_id, $state){
            $obj = & get_instance();
            $obj->loader->model('leave_model');
            $obj->leave_model->update($entity_id, array('leav_state' => $state));
        }
    }
