<?php
    /**
     * ************************************************************************
     * WORKFLOW USEFUL FUNCTIONS DEFINITIONS
     * *************************************************************************
     */
    
    if(! function_exists('evaluate_condition')){
        /**
         * Used to evaluate condition
         * 
         * @param  mixed $operand1 the left operand
         * @param  string $operator the comparaison operator
         * @param  mixed $operand2 the right operand
         * 
         * @return boolean           if condition match or nor
         */
        function evaluate_condition($operand1, $operator, $operand2){
            $logger = new Log();
            $operand1 = htmlspecialchars_decode($operand1);
            $operand2 = htmlspecialchars_decode($operand2);
            //if operand contains " in the value
            if(strpos($operand1, '"') !== false){
                $temp = explode('"', $operand1);
                $operand1 = implode('\"', $temp);
            }
            if(strpos($operand2, '"') !== false){
                $temp = explode('"', $operand2);
                $operand2 = implode('\"', $temp);
            }
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $script = 'return "'.$operand1.'" ' . $operator . ' "'.$operand2 .'";';
            $logger->info('Evaluation condition is: "' .$script . '"');
            return eval($script);
        }
    }

    if(! function_exists('run_wf_service_node')){
        /**
         * This function is used to run service node
         * 
         * @param  string $service_definition service definition
         * @param  array $wf_params          workflow instance parameters (instance_id, entity_id, entity_name)
         * 
         * @return mixed                     the execution result
         */
        function run_wf_service_node($service_definition, $wf_params){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $obj = & get_instance();
            $obj->loader->library('workflow/WFServiceTaskLib');
            $logger->info('Service definition is: [' . $service_definition . ']');
            $exp_f_args = explode(':', $service_definition);
            $function = null;
            $args = null;
            if(array_key_exists(0, $exp_f_args)){
                $function = $exp_f_args[0];
            }
            if(array_key_exists(1, $exp_f_args)){
                $args = $exp_f_args[1];
            }
            $function = trim($function);
            $args = trim($args);
                
            $logger->info('Service method is: [' . $function . '], passed args string is: [' . $args . ']');
            if($function && method_exists($obj->wfservicetasklib, $function)){
                $args = strtr($args, $wf_params);
                $args = explode(',', $args);
                $args = array_map('trim', $args);
                $logger->info('Method args array are: ' . stringify_vars($args));
                return call_user_func_array(array($obj->wfservicetasklib, $function), $args);
            }
            else{
                show_error('Workflow service method [' . $function . '] does not exist');
            }
        }
    }

    if(! function_exists('run_wf_script_node')){
        /**
         * This function is used to run script node
         * 
         * @param  string $script_definition script definition
         * @param  array $wf_params          workflow instance parameters (instance_id, entity_id, entity_name)
         * 
         * @return mixed                     the execution result
         */
        function run_wf_script_node($script_definition, $wf_params){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $logger->info('Script definition is: [' . stringify_vars($script_definition) . ']');
            extract($wf_params);
            $obj = & get_instance();
            return eval($script_definition);
        }   
    }


    if(! function_exists('get_service_method_list')){
        /**
         * Used to return the list of service methods in the workflow library
         * 
         * @return array the service methods list
         */
        function get_service_method_list(){
            $obj = & get_instance();
            $obj->loader->library('workflow/WFServiceTaskLib');
            $methods = get_class_methods($obj->wfservicetasklib);
            $list = array();
            foreach($methods as $m){
                $pstr = array();
                $rmethod = new ReflectionMethod($obj->wfservicetasklib, $m); 
                $params = $rmethod->getParameters();
                $requiredArg = 0;
                if($params){
                    foreach($params as $p){
                        $name = $p->getName();
                        if($p->isOptional()){
                            $pstr[] = $name . ' = ' . $p->getDefaultValue();
                        }
                        else{
                            $pstr[] = $name;
                            $requiredArg++;
                        }
                    }
                }
                $list[$m]['name'] = $m . '('.implode(', ', $pstr).')';
                $list[$m]['required_arg'] = $requiredArg;
            }
            return $list;
        }
    }

    if(! function_exists('execute_decision_node')){
        /**
         * This function is used to find the next node for decision node
         * 
         * @param  int $inst_id                   the instance id
         * @param  object $entity                    the entity instance
         * @param  object $decisionNode              the decision node
         * @param  object $previousNode              the previous node
         * @param  mixed $previousNodeServiceResult the previous node service result
         * @param  mixed $previousNodeScriptResult  the previous node script result
         * 
         * @return object|null  the next node if found or null if can not found
         */
        function execute_decision_node($inst_id, $entity, $decisionNode, $previousNode, $previousNodeServiceResult, $previousNodeScriptResult){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $obj = & get_instance();
            $obj->loader->model('workflow/wf_node_path_model');
            $obj->loader->model('workflow/wf_task_model');
            $nexts = $obj->wf_node_path_model->getNextNodeDecisionListForWorkflow($decisionNode->wf_id, $decisionNode->wf_node_id, 1);
            $returnNode = null;
            $wf_task_types = get_wf_task_type_list();
            if(count($nexts) == 1){
                $logger->info('Found only one destination node for decision node [' . $decisionNode->wf_node_name . '] just use it');
                $returnNode = $nexts[0];
            }
            else{
                $pathFound = false;
                $defaultNode = null;
                foreach ($nexts as $node) {
                    if($node->wf_np_is_default && ! $defaultNode){
                        $defaultNode = $node;
                    }
                    $logger->info('Check if node path for [' .$node->wf_node_name. '], task type [' .$wf_task_types[$node->wf_node_task_type]. '] match ...');
                    //check if condition match
                    $ctype = $node->wf_np_cond_type;
                    if($ctype){
                        $operator = $node->wf_np_cond_operator;
                        $value = $node->wf_np_cond_value;
                        $valid = false;
                        $logger->info('Node condition type is: [' .$ctype. ']');
                        if($ctype == 'outcome' && isset($previousNode->wf_node_id)){
                            $oc_result = $obj->wf_task_model->getOutcomeResultForNode($inst_id, $previousNode->wf_node_id);
                            if($oc_result){
                                $valid = evaluate_condition($oc_result->code, $operator, $value); 
                            }
                        }
                        else if($ctype == 'entity' && isset($entity->{$node->wf_np_cond_name})){
                            $valid = evaluate_condition($entity->{$node->wf_np_cond_name}, $operator, $value); 
                        }
                        else if($ctype == 'service_result' && isset($previousNodeServiceResult)){
                            $valid = evaluate_condition($previousNodeServiceResult, $operator, $value); 
                        }
                        else if($ctype == 'script_result' && isset($previousNodeScriptResult)){
                            $valid = evaluate_condition($previousNodeScriptResult, $operator, $value);  
                        }
                        
                        if($valid){
                            $returnNode = $node;
                            $pathFound = true;
                            $logger->info('Condition for node [' .$node->wf_node_name. '], match stop here and use it');
                            break;
                        }
                        else{
                            $logger->info('Condition for node [' .$node->wf_node_name. '], not match');
                        }
                    }
                    else{
                        $logger->info('No condition type found for node [' .$node->wf_node_name. '], skip it');
                    }
                }
                //if can not found a path
                if(! $pathFound && $defaultNode){
                    $logger->info('No nodes conditions match use the default node [' .$defaultNode->wf_node_name. '] to continue workflow');
                    $returnNode = $defaultNode;
                }
            }
            return $returnNode;                   
        }
    }


   if(! function_exists('execute_user_node')){
        /**
         * Execute user node
         * @param  integer $inst_id the workflow instance
         * @param  integer $nodeId  the current node
         * @param  integer $roleId  the role id to validate the node
         * @return boolean          true if end node is reached otherwise false
         */
        function execute_user_node($inst_id, $nodeId, $roleId){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $obj = &get_instance();
            $obj->loader->model('workflow/wf_user_role_model');
            $obj->loader->model('workflow/wf_task_model');
            
            $endNodeReached = false;
            $actors = $obj->wf_user_role_model->getList($inst_id, $roleId);
            if(! empty($actors)){
                $params_task = array(
                    'wf_task_status' => 'I',
                    'wf_task_comment' => '',
                    'wf_task_start_time' => date('Y-m-d H:i:s'),
                    'wf_inst_id' => $inst_id,
                    'wf_node_id' => $nodeId,
                );
                foreach ($actors as $l) {
                    $params_task['user_id'] = $l->user_id;
                    $obj->wf_task_model->insert($params_task);  
                }
            }
            else{
                //no actors, workflow end here
                $logger->warning('No actors for user node [' . $nodeId . '], workflow termined.');
                $result_str = __tr('wf_txt_validation_start_success_and_finish_no_actors_for_user_node');
                $endNodeReached = true;
            }
            return $endNodeReached;
        }
    }

    if(! function_exists('execute_end_node_actions')){
        /**
         * Execute the actions after end node reached
         * @param  integer $inst_id the instance
         * @return void
         */
        function execute_end_node_actions($inst_id){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $obj = &get_instance();
            $obj->loader->model('workflow/wf_instance_model');
            $obj->loader->model('workflow/wf_task_model');
            
            $logger->info('End node reached stop workflow');
            $params_instance = array(
                'wf_inst_state' => 'T',
                'wf_inst_end_date' => date('Y-m-d H:i:s')
            );
            $obj->wf_instance_model->update($inst_id, $params_instance);
            $obj->wf_task_model->updateCond(
                                            array(
                                                'wf_inst_id' => $inst_id, 
                                                'wf_task_status' => 'I'
                                            ), 
                                            array(
                                                'wf_task_status' => 'C',
                                                'wf_task_comment' => 'Workflow termined',
                                                'wf_task_cancel_trigger' => 'S',
                                                'wf_task_end_time' => date('Y-m-d H:i:s')
                                            )
                                        );

        }
    }

    if(! function_exists('execute_workflow')){
        /**
         * Execute the workflow
         * @param  integer  $wf_id           the workflow configuration
         * @param  integer  $inst_id         the workflow instance
         * @param  object  $entity          the entity instance
         * @param  integer  $entity_id       the entity id
         * @param  string  $entity_name     the entity name
         * @param  object  $currentNode     the initial node
         * @param  boolean $isStartWorkflow whether workflow run for the first time
         * @return string                   the text result of execution
         */
        function execute_workflow($wf_id, $inst_id, $entity, $entity_id, $entity_name, $currentNode, $isStartWorkflow = false){
            $logger = new Log();
            $logger->setLogger('WFV:FUNCTION::' . __FUNCTION__);
            $obj = &get_instance();
            $obj->loader->model('workflow/wf_node_path_model');
            
            $previousNode = $currentNode;
            $previousNodeScriptResult = null;
            $previousNodeServiceResult = null;
            $previousNodeScriptId = null;
            $previousNodeServiceId = null;
            $nextNode = $obj->wf_node_path_model->getNextNodeForWorkflow($wf_id, $currentNode->wf_node_id, 1);
            $endNodeReached = false; //if already at the end node
            $stop = false; //if need sort out the loop
            $wf_task_types = get_wf_task_type_list();
            $result_str = $isStartWorkflow ? __tr('wf_txt_validation_start_success') : __tr('wf_txt_validation_success');
            while(! $stop && ! $endNodeReached){
                if(! $nextNode || is_end_node($nextNode->wf_node_type)){
                    //workflow finish here
                    $logger->info('Next node does not exist or end node reached, workflow termined.');
                    $endNodeReached = true;
                    $result_str = $isStartWorkflow 
                                            ? __tr('wf_txt_validation_start_success_and_finish_no_next_node_or_end_node')
                                            : __tr('wf_txt_validation_success_and_finish_no_next_node_or_end_node');
                    break;
                }
                $logger->info('Begin execution of node [' .$nextNode->wf_node_name. '], task type [' .$wf_task_types[$nextNode->wf_node_task_type]. '] ...');
                //first check if is user node
                if(is_user_node($nextNode->wf_node_task_type)){
                    $endNodeReached = execute_user_node($inst_id, $nextNode->wf_node_id, $nextNode->wf_role_id);
                    if($endNodeReached){
                       $result_str = $isStartWorkflow 
                                                    ? __tr('wf_txt_validation_start_success_and_finish_no_actors_for_user_node')
                                                    : __tr('wf_txt_validation_success_and_finish_no_actors_for_user_node'); 
                    }
                    $stop = true;
                    break;
                }
                 //check if is script node
                else if(is_script_node($nextNode->wf_node_task_type)){
                    //execute script
                    if($nextNode->wf_node_script){
                        $previousNodeScriptResult = run_wf_script_node($nextNode->wf_node_script, array(
                            'instance_id' => $inst_id,
                            'entity_id' => $entity_id,
                            'entity_name' => $entity_name
                        ));
                        $previousNodeScriptId = $nextNode->wf_node_id;
                        $logger->info('Previous script result is [' . $previousNodeScriptResult . ']');
                        $logger->info('Previous script node id is [' . $previousNodeScriptId . ']');
                    }
                    $previousNode = $nextNode;
                    $nextNode = $obj->wf_node_path_model->getNextNodeForWorkflow($wf_id, $nextNode->wf_node_id, 1);
                }
                 //check if is service node
                else if(is_service_node($nextNode->wf_node_task_type)){
                    //execute service
                    if($nextNode->wf_node_service){
                        $service_definition = $nextNode->wf_node_service;
                        $previousNodeServiceResult = run_wf_service_node($service_definition, array(
                            'instance_id' => $inst_id,
                            'entity_id' => $entity_id,
                            'entity_name' => $entity_name
                        ));
                        $previousNodeServiceId = $nextNode->wf_node_id;
                        $logger->info('Previous service result is [' . $previousNodeServiceResult . ']');
                        $logger->info('Previous service node id is [' . $previousNodeServiceId . ']');
                    }
                    $previousNode = $nextNode;
                    $nextNode = $obj->wf_node_path_model->getNextNodeForWorkflow($wf_id, $nextNode->wf_node_id, 1);
                }
                 //check if is decision node
                else if(is_decision_node($nextNode->wf_node_task_type)){
                    $nodeFound = execute_decision_node($inst_id, $entity, $nextNode, $previousNode, $previousNodeServiceResult, $previousNodeScriptResult);
                    if($nodeFound){
                        $previousNode = $nextNode;
                        $nextNode = $nodeFound;
                    }
                     else{
                        $result_str = $isStartWorkflow
                                                        ? __tr('wf_txt_validation_start_success_and_finish_no_path_for_decision_node')
                                                        : __tr('wf_txt_validation_success_and_finish_no_path_for_decision_node');
                        $stop = true;
                        $endNodeReached = true;
                        $logger->info('No nodes match the conditions for decision node [' . $nextNode->wf_node_name . ']');
                    }
                }
                $logger->info('End execution of node [' . $previousNode->wf_node_name . ']');
            }
            //check if we already at the end
            if($endNodeReached){
                //Execute end node actions
                execute_end_node_actions($inst_id);
            }
            return $result_str;
        }

    }

    if(! function_exists('build_flowchart')){
        /**
         * This function is used to build flowchart for the workflow
         * 
         * @param  array $nodes_path the list of node path
         * 
         * @return string  the chart string definition
         */
        function build_flowchart($nodes_path){
            $str = null;
            if(! empty($nodes_path)){
                $wf_node_path_conditions_type = get_wf_node_path_condition_type_list();
                $str .= '<div class="mermaid">';
                $styles = null;
                $str .= "graph LR\n";
                foreach($nodes_path as $l){
                    $from = null;
                    $middle = null;
                    $to = null;

                    if(is_start_node($l->from_type)){
                        $styles .= 'class ' . $l->wf_node_from_id . ' startNodeStyle;' . "\n";
                        $from = $l->wf_node_from_id . '(("' . $l->from_name . '"))';
                    }
                    else if(is_decision_node($l->from_task_type)){
                        $from = $l->wf_node_from_id . '{"' . $l->from_name . '"}' ."\n";
                        $styles .= 'class ' . $l->wf_node_from_id . ' decisionNodeStyle;' . "\n";
                    }
                    else{
                        $fa = 'fa:fa-users ';
                        if(is_script_node($l->from_task_type)){
                            $fa = 'fa:fa-code  ';
                        }
                        if(is_service_node($l->from_task_type)){
                            $fa = 'fa:fa-cogs  ';
                        }
                        $from = $l->wf_node_from_id . '("' . $fa . $l->from_name.'")';
                    }

                    if(is_end_node($l->to_type)){
                        $styles .= 'class ' . $l->wf_node_to_id . ' endNodeStyle;' . "\n";
                        $to = $l->wf_node_to_id . '(("' . $l->to_name . '"))';
                    }
                    else if(is_decision_node($l->to_task_type)){
                        $to = $l->wf_node_to_id . '{"' . $l->to_name . '"}' ."\n";
                        $styles .= 'class ' . $l->wf_node_to_id . ' decisionNodeStyle;' . "\n";
                    }
                    else{
                        $fa = 'fa:fa-users ';
                        if(is_script_node($l->to_task_type)){
                            $fa = 'fa:fa-code  ';
                        }
                        if(is_service_node($l->to_task_type)){
                            $fa = 'fa:fa-cogs  ';
                        }
                        $to = $l->wf_node_to_id . '("' . $fa . $l->to_name . '")';
                    }

                    if($l->wf_np_name){
                        $middle = '|"' .$l->wf_np_name. '"|';
                    }
                    else if($l->wf_np_cond_type){
                        if($l->wf_np_cond_type != 'entity'){
                            $middle = '|"' . (isset($wf_node_path_conditions_type[$l->wf_np_cond_type]) ? $wf_node_path_conditions_type[$l->wf_np_cond_type] : ''). ' ' .$l->wf_np_cond_operator .' ' .htmlspecialchars($l->wf_np_cond_value). '"|';
                        }
                        else{
                            $middle = '|"' . $l->wf_np_cond_name. ' ' .$l->wf_np_cond_operator .' ' .htmlspecialchars($l->wf_np_cond_value). '"|';
                        }
                    }

                    if(is_user_node($l->from_task_type) && ! is_start_node($l->from_type) && ! is_end_node($l->from_type)){
                        $styles .= 'class ' . $l->wf_node_from_id . ' userNodeStyle;' . "\n";
                    }
                    if(is_script_node($l->from_task_type)){
                        $styles .= 'class ' . $l->wf_node_from_id . ' scriptNodeStyle;' . "\n";
                    }
                    if(is_service_node($l->from_task_type)){
                        $styles .= 'class ' . $l->wf_node_from_id . ' serviceNodeStyle;' . "\n";
                    }

                    $str .= $from .'-->' .$middle . $to. "\n";
                }
                $str .= '
                classDef startNodeStyle fill:#1767d1,stroke:#333,stroke-width:2px;
                classDef endNodeStyle fill:#a019e2,stroke:#333,stroke-width:4px;
                classDef decisionNodeStyle fill:#ae2,stroke:#333,stroke-width:2px;
                classDef userNodeStyle fill:#e3a571,stroke:#333,stroke-width:2px;
                classDef scriptNodeStyle fill:#0cb0a8,stroke:#333,stroke-width:2px;
                classDef serviceNodeStyle fill:#aef,stroke:#333,stroke-width:2px;';
            
               $str .= $styles;
               $str .= '</div>';
            }
            return $str;
        }
    }


    //////////////////////////////////////// WORKFLOW STATES ////////////////////////////////////////////
    if(! function_exists('get_wf_task_state_list')){
        /**
         * Return the list of task state
         * @return array
         */
         function get_wf_task_state_list(){
            return array(
                        'I' => __tr('wf_txt_task_state_processing'),
                        'T' => __tr('wf_txt_task_state_completed'),
                        'C' => __tr('wf_txt_task_state_canceled')
                    );
        }
    }

    if(! function_exists('get_wf_instance_state_list')){
         /**
         * Return the list of workflow instance state
         * @return array 
         */
        function get_wf_instance_state_list(){
            return array(
                        'I' => __tr('wf_txt_instance_state_processing'),
                        'T' => __tr('wf_txt_instance_state_completed'),
                        'C' => __tr('wf_txt_instance_state_canceled')
                    );
        }
    }

    if(! function_exists('get_wf_task_cancel_trigger_list')){
        /**
         * Return the list of task cancel trigger list
         * @return array 
         */
        function get_wf_task_cancel_trigger_list(){
            return array(
                        'U' => __tr('wf_txt_task_cancel_trigger_user'),
                        'S' => __tr('wf_txt_task_cancel_trigger_system')
                    );
        }
    }

    if(! function_exists('get_wf_node_path_condition_type_list')){
        /**
         * Return the list of node path condition type
         * @return array 
         */
        function get_wf_node_path_condition_type_list(){
            return array(
                        'outcome' => __tr('wf_txt_node_condition_type_outcome'),
                        'entity' => __tr('wf_txt_node_condition_type_entity'),
                        'script_result' => __tr('wf_txt_node_condition_type_script_result'),
                        'service_result' => __tr('wf_txt_node_condition_type_service_result')
                    );
        }
    }

    if(! function_exists('get_wf_node_path_condition_operator_list')){
         /**
         * Return the list of node path condition operator
         * @return array 
         */
        function get_wf_node_path_condition_operator_list(){
            return array(
                        '==' => '=',
                        '>' => '>',
                        '<' => '<',
                        '>=' => '>=',
                        '<=' => '<=',
                        '!=' => '<>'
                    );
        }
    }

    if(! function_exists('get_wf_state_list')){
         /**
         * Return the list of workflow state
         * @return array 
         */
        function get_wf_state_list(){
            return array(
                        '1' => __tr('wf_txt_workflow_state_active'),
                        '0' => __tr('wf_txt_workflow_state_deactive')
                    );
        }
    }

    if(! function_exists('get_wf_task_type_list')){
         /**
         * Return the list of task type
         * @return array 
         */
        function get_wf_task_type_list(){
            return array(
                        '1' => __tr('wf_txt_node_task_type_user'),
                        '2' => __tr('wf_txt_node_task_type_decision'),
                        '3' => __tr('wf_txt_node_task_type_script'),
                        '4' => __tr('wf_txt_node_task_type_service')
                    );
        }
    }

    if(! function_exists('get_wf_node_type_list')){
         /**
         * Return the list of node type
         * @return array 
         */
        function get_wf_node_type_list(){
            return array(
                        '1' => __tr('wf_txt_node_type_start'),
                        '2' => __tr('wf_txt_node_type_intermediate'),
                        '3' => __tr('wf_txt_node_type_end')
                    );
        }
    }

    if(! function_exists('is_user_node')){
        /**
         * Check if the node is a user node
         * @param  int  $id the value
         * @return boolean
         */
        function is_user_node($id){
            return $id == 1;
        }
    }

    if(! function_exists('is_decision_node')){
        /**
         * Check if the node is a decision node
         * @param  int  $id the value
         * @return boolean
         */
        function is_decision_node($id){
            return $id == 2;
        }
    }

    if(! function_exists('is_script_node')){
        /**
         * Check if the node is a script node
         * @param  int  $id the value
         * @return boolean
         */
        function is_script_node($id){
            return $id == 3;
        }
    }


    if(! function_exists('is_service_node')){
        /**
         * Check if the node is a service node
         * @param  int  $id the value
         * @return boolean
         */
        function is_service_node($id){
            return $id == 4;
        }
    }

    if(! function_exists('is_start_node')){
        /**
         * Check if the node is a start node
         * @param  int  $id the value
         * @return boolean
         */
         function is_start_node($id){
            return $id == 1;
        }
    }

    if(! function_exists('is_intermediate_node')){
        /**
         * Check if the node is an intermediate node
         * @param  int  $id the value
         * @return boolean
         */
         function is_intermediate_node($id){
            return $id == 2;
        }
    }

    if(! function_exists('is_end_node')){
        /**
         * Check if the node is an end node
         * @param  int  $id the value
         * @return boolean
         */
         function is_end_node($id){
            return $id == 3;
        }
    }
