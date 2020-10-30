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
            $logger->setLogger('FUNCTION::' . __FUNCTION__);
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
            $logger->setLogger('FUNCTION::' . __FUNCTION__);
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
            $logger->setLogger('FUNCTION::' . __FUNCTION__);
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

    if(! function_exists('find_next_node_for_decision_node')){
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
        function find_next_node_for_decision_node($inst_id, $entity, $decisionNode, $previousNode, $previousNodeServiceResult, $previousNodeScriptResult){
            $logger = new Log();
            $logger->setLogger('FUNCTION::' . __FUNCTION__);
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
