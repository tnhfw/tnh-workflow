<?php 
    defined('ROOT_PATH') || exit('Access denied');
    /**
     * Workflow language messages (English) 
     */
    
    //commons text
    $lang['wf_txt_valide'] = 'Validate';
    $lang['wf_txt_back'] = 'Back';
    $lang['wf_txt_edit'] = 'Edit';     
    $lang['wf_txt_cancel'] = 'Cancel';    
    $lang['wf_txt_detail'] = 'Detail'; 
    $lang['wf_txt_create'] = 'Create';
    $lang['wf_txt_workflow_add_role'] = 'Add role';
    $lang['wf_txt_workflow_task_add_actor'] = 'Add actor';
    $lang['wf_txt_workflow_add_node'] = 'Add node';
    $lang['wf_txt_workflow_add_node_path'] = 'Add node path';   
    $lang['wf_txt_workflow_node_add_outcome'] = 'Add node outcome';       
    $lang['wf_txt_action'] = 'Action';
    $lang['wf_txt_delete'] = 'Delete'; 
    $lang['wf_txt_yes'] = 'Yes';   
    $lang['wf_txt_no'] = 'No';
    $lang['wf_txt_none'] = 'Aucun';
    $lang['wf_txt_reason'] = 'Reason';
    $lang['wf_txt_task_state_processing'] = 'Processing';
    $lang['wf_txt_task_state_completed'] = 'Completed';
    $lang['wf_txt_task_state_canceled'] = 'Canceled';
    $lang['wf_txt_instance_state_processing'] = 'Processing';
    $lang['wf_txt_instance_state_completed'] = 'Completed';
    $lang['wf_txt_instance_state_canceled'] = 'Canceled';
    $lang['wf_txt_task_cancel_trigger_user'] = 'By user';
    $lang['wf_txt_task_cancel_trigger_system'] = 'By system';
    $lang['wf_txt_node_condition_type_outcome'] = 'Outcome';
    $lang['wf_txt_node_condition_type_entity'] = 'Entity property';
    $lang['wf_txt_node_condition_type_script_result'] = 'Script result';
    $lang['wf_txt_node_condition_type_service_result'] = 'Service result';
    $lang['wf_txt_workflow_state_active'] = 'Active';
    $lang['wf_txt_workflow_state_deactive'] = 'Deactive';
    $lang['wf_txt_node_task_type_user'] = 'User Node';
    $lang['wf_txt_node_task_type_decision'] = 'Decision Node';
    $lang['wf_txt_node_task_type_script'] = 'Script Node';
    $lang['wf_txt_node_task_type_service'] = 'Service Node';
    $lang['wf_txt_node_type_start'] = 'Start Node';
    $lang['wf_txt_node_type_intermediate'] = 'Intermediate Node';
    $lang['wf_txt_node_type_end'] = 'End Node';
    $lang['wf_txt_start_workflow_validation'] = 'Start workflow validation';
    $lang['wf_txt_workflow_validation_instance_detail'] = 'Workflow instance detail';
    $lang['wf_txt_workflow_detail'] = 'Workflow detail';
    $lang['wf_txt_workflow_task_validation_outcome_result'] = 'Result';


    //fields
    $lang['wf_field_user'] = 'User';
    $lang['wf_field_role'] = 'Role';
    $lang['wf_field_task'] = 'Task';
    $lang['wf_field_instance'] = 'Instance';
    $lang['wf_field_workflow'] = 'Workflow';
    $lang['wf_field_outcome'] = 'Outcome';
    $lang['wf_field_node'] = 'Node';
    $lang['wf_field_node_path_node_from'] = 'Node from ';
    $lang['wf_field_node_path_node_to'] = 'Node to';
    $lang['wf_field_workflow_id'] = 'Workflow ID';
    $lang['wf_field_workflow_name'] = 'Workflow name';
    $lang['wf_field_workflow_desc'] = 'Description';
    $lang['wf_field_workflow_state'] = 'State';
    $lang['wf_field_inst_id'] = 'Instance ID';
    $lang['wf_field_inst_state'] = 'State';
    $lang['wf_field_inst_desc'] = 'Description';
    $lang['wf_field_inst_start_date'] = 'Start date';
    $lang['wf_field_inst_end_date'] = 'End date';
    $lang['wf_field_inst_entity_id'] = 'Entity ID';
    $lang['wf_field_inst_entity_name'] = 'Entity name';
    $lang['wf_field_inst_entity_detail'] = 'Entity detail';
    $lang['wf_field_inst_start_comment'] = 'Start comment'; 
    $lang['wf_field_inst_start_by'] = 'Start by'; 
    $lang['wf_field_node_id'] = 'Node ID';
    $lang['wf_field_node_name'] = 'Name';
    $lang['wf_field_node_task_type'] = 'Task type';
    $lang['wf_field_node_type'] = 'Node type';
    $lang['wf_field_node_validation_role'] = 'Validation role';
    $lang['wf_field_node_script'] = 'Script';
    $lang['wf_field_node_service'] = 'Service';
    $lang['wf_field_node_service_args'] = 'Service method argument';
    $lang['wf_field_node_state'] = 'State';
    $lang['wf_field_node_oc_id'] = 'Outcome ID';
    $lang['wf_field_node_oc_code'] = 'Outcome code';
    $lang['wf_field_node_oc_name'] = 'Outcome name';
    $lang['wf_field_node_path_id'] = 'Path ID';
    $lang['wf_field_node_path_name'] = 'Name';
    $lang['wf_field_node_path_cond_type'] = 'Cond. type';
    $lang['wf_field_node_path_cond_name'] = 'Cond. name';
    $lang['wf_field_node_path_cond_operator'] = 'Cond. operator';
    $lang['wf_field_node_path_cond_value'] = 'Cond. value';
    $lang['wf_field_node_path_cond_outcome_value'] = 'Cond. outcome value';
    $lang['wf_field_node_path_is_default'] = 'Is default ?';
    $lang['wf_field_node_path_order'] = 'Execution order';
    $lang['wf_field_role_id'] = 'Role ID';
    $lang['wf_field_role_name'] = 'Role name';
    $lang['wf_field_user_role_id'] = 'ID';
    $lang['wf_field_task_id'] = 'Task ID';
    $lang['wf_field_task_state'] = 'State';
    $lang['wf_field_task_cancel_trigger'] = 'Cancel reason';
    $lang['wf_field_task_comment'] = 'Comment';
    $lang['wf_field_task_start_time'] = 'Start time';
    $lang['wf_field_task_end_time'] = 'End time';
    $lang['wf_field_task_node'] = 'Task node';
    $lang['wf_field_task_actor'] = 'Validator';
    $lang['wf_field_task_outcome_result'] = 'Result';
    
    //Database messages
    $lang['wf_txt_database_no_data'] = 'No record where found';     
    $lang['wf_txt_database_insert_ok'] = 'The data has been successfully saved';   
    $lang['wf_txt_database_insert_warning'] = 'Some data have not been saved for an unknown reason.';   
    $lang['wf_txt_database_update_ok'] = 'The data were successfully modified';      
    $lang['wf_txt_database_delete_ok'] = 'The data was successfully deleted';     
    $lang['wf_txt_database_insert_error'] = 'Error occured when saved the data';    
    $lang['wf_txt_database_update_error'] = 'Error occured when modifying data';      
    $lang['wf_txt_database_delete_error'] = 'Error occured when deleting data';   
    $lang['wf_txt_database_data_not_exists'] = 'Unable to find the record you are looked, please retry later.';

    //Form legend
    $lang['wf_workflow_fle_create'] = 'Workflow add';
    $lang['wf_workflow_fle_edit'] = 'Workflow update';
    $lang['wf_workflow_node_fle_create'] = 'Add node for workflow [%s]';
    $lang['wf_workflow_node_fle_edit'] = 'Workflow node update';
    $lang['wf_workflow_node_path_fle_create'] = 'Add node path for workflow [%s]';
    $lang['wf_workflow_node_path_fle_edit'] = 'Workflow node path update';
    $lang['wf_workflow_role_fle_create'] = 'Add role for workflow [%s]';
    $lang['wf_workflow_role_fle_edit'] = 'Workflow role update';
    $lang['wf_workflow_outcome_fle_create'] = 'Add outcome for node [%s]';
    $lang['wf_workflow_outcome_fle_edit'] = 'Workflow node outcome update';
    $lang['wf_workflow_task_validation_fle'] = 'Workflow validation';
    $lang['wf_workflow_instance_fle_start'] = 'Start workflow validation for entity [%s]';
    $lang['wf_workflow_instance_fle_actor_create'] = 'Add actors for workflow instance [%s]';
    

    //form placeholder
    $lang['wf_fp_workflow_name'] = 'Enter workflow name';
    $lang['wf_fp_workflow_desc'] = 'Enter workflow description';
    $lang['wf_fp_workflow_node_name'] = 'Enter workflow node name';
    $lang['wf_fp_workflow_node_script'] = 'PHP Script definition';
    $lang['wf_fp_workflow_node_service_arg'] = 'Service method argument(s). Example: arg1, arg2, argn';
    $lang['wf_fp_workflow_node_path_name'] = 'Enter workflow node path name';
    $lang['wf_fp_workflow_node_path_cond_name'] = 'Enter workflow node path condition name (Entity only)';
    $lang['wf_fp_workflow_node_path_cond_value'] = 'Enter workflow node path condition value';
    $lang['wf_fp_workflow_node_path_order'] = 'Enter workflow node path execution order (used in decision node)';
    $lang['wf_fp_workflow_role_name'] = 'Enter workflow role name';
    $lang['wf_fp_workflow_node_outcome_code'] = 'Enter workflow node outcome code';
    $lang['wf_fp_workflow_node_outcome_name'] = 'Enter workflow node outcome name';
    $lang['wf_fp_workflow_task_validation_comment'] = 'Enter workflow task validation comment';
    $lang['wf_fp_workflow_instance_desc'] = 'Enter instance description';
    $lang['wf_fp_workflow_instance_entity_detail'] = 'Enter entity detail';
    $lang['wf_fp_workflow_instance_start_comment'] = 'Enter start comment';
    
    //some messages
    $lang['wf_txt_active_data_warning'] = 'Are you sure you want to enable this item ?';    
    $lang['wf_txt_delete_data_warning'] = 'Are you sure you want to delete the items ?';
    $lang['wf_txt_delete_selected_data_warning'] = 'Are you sure you want to delete the selected items?';
    $lang['wf_txt_node_already_exists_error'] = 'Node already exists for this workflow !';   
    $lang['wf_txt_start_node_already_exists_error'] = 'Start Node already exists for this workflow !';
    $lang['wf_txt_end_node_already_exists_error'] = 'End Node already exists for this workflow !';   
    $lang['wf_txt_role_required_for_user_node_error'] = 'Please it is User node, choose the validation role from list !';   
    $lang['wf_txt_script_required_for_script_node_error'] = 'Please it is Script node, input the script !';
    $lang['wf_txt_service_required_for_service_node_error'] = 'Please it is Service node, select the service !';
    $lang['wf_txt_service_arg_required_for_service_method_error'] = 'Please input required service method argument !';  
    $lang['wf_txt_node_path_node_from_or_to_not_exists_error'] = 'Node from or to does not exist !'; 
    $lang['wf_txt_node_path_already_exists_error'] = 'Node path already exists for this workflow !';
    $lang['wf_txt_start_node_is_destination_node_error'] = 'Start node can not be the destination node !';
    $lang['wf_txt_end_node_is_source_node_error'] = 'End node can not be the source node !';
    $lang['wf_txt_source_destination_node_is_same_error'] = 'Source node and destination node can not be the same !';
    $lang['wf_txt_decision_node_for_source_destination_error'] = 'Source node and destination node can not be the decision node !';
    $lang['wf_txt_multiple_destination_path_for_no_decision_node_error'] = 'Only decision node can have many destination path !';
    $lang['wf_txt_condition_operator_required_error'] = 'Please choose condition operator';
    $lang['wf_txt_condition_value_required_error'] = 'Please input condition value';   
    $lang['wf_txt_condition_outcome_value_required_error'] = 'Please choose outcome value for outcome type';
    $lang['wf_txt_condition_entity_name_required_error'] = 'Please input condition name for entity type';
    $lang['wf_txt_role_already_exists_error'] = 'Role already exists for this workflow !';   
    $lang['wf_txt_add_outcome_not_user_task_or_start_end_node_error'] = 'Not a user node or is start/end node can not add outcome !';   
    $lang['wf_txt_outcome_already_exists_error'] = 'Outcome already exists for this node !';
    $lang['wf_txt_no_outcome_for_user_task_warning'] = 'Can not find outomces for user task [%s] please config this node !';
    $lang['wf_txt_validation_task_not_valid_error'] = 'Task is not valid or does not exists or you are not the current validator !';
    $lang['wf_txt_validation_entiy_not_found_error'] = 'Can not find entity !';
    $lang['wf_txt_validation_instance_not_found_error'] = 'Workflow instance does not exists !';
    $lang['wf_txt_validation_instance_state_not_valid_error'] = 'Workflow instance status is not not valid or already completed !';
    $lang['wf_txt_validation_success'] = 'Workflow validate successfuly !';
    $lang['wf_txt_validation_success_and_finish_no_next_node_or_end_node'] = 'Workflow validate successfuly and workflow finish because the next node does not exist or end node reached !';
    $lang['wf_txt_validation_success_and_finish_no_actors_for_user_node'] = 'Workflow validate successfuly and workflow finish because the user node does not have actors for validation !';
    $lang['wf_txt_validation_success_and_finish_no_path_for_decision_node'] = 'Workflow validate successfuly and workflow finish because the decision node does not have the next node, may be conditions do not match !';
    $lang['wf_txt_validation_already_start_error'] = 'Workflow validation already start !';
    $lang['wf_txt_validation_workflow_not_valid_error'] = 'Workflow does not exists or is not active !';
    $lang['wf_txt_validation_workflow_start_node_not_valid_error'] = 'Workflow does not have start event or is not active !';
    $lang['wf_txt_validation_workflow_end_node_not_valid_error'] = 'Workflow does not have end event or is not active !';
    $lang['wf_txt_validation_start_success'] = 'Workflow started successfuly !';
    $lang['wf_txt_validation_start_success_and_finish_no_next_node_or_end_node'] = 'Workflow started successfuly and workflow finish because the next node does not exist or end node reached !';
    $lang['wf_txt_validation_start_success_and_finish_no_actors_for_user_node'] = 'Workflow started successfuly and workflow finish because the user node does not have actors for validation !';
    $lang['wf_txt_validation_start_success_and_finish_no_path_for_decision_node'] = 'Workflow started successfuly and workflow finish because the decision node does not have the next node, may be conditions do not match !';
    $lang['wf_txt_validation_cancel_instance_state_not_valid_error'] = 'Workflow already completed or canceled !';
    $lang['wf_txt_validation_cancel_instance_success'] = 'Workflow canceled successfuly ! ';
    $lang['wf_txt_validation_add_user_role_instance_state_not_valid_error'] = 'Workflow does not exists or already completed or canceled !';
    $lang['wf_txt_validation_add_user_role_instance_success'] = 'Actors added successfuly !';
    $lang['wf_txt_validation_delete_user_role_instance_state_not_valid_error'] = 'Workflow does not exists or already completed or canceled !';
    $lang['wf_txt_validation_delete_user_role_instance_success'] = 'Actors deleted successfuly !';
    $lang['wf_txt_workflow_instance_cancel_warning'] = 'Are you sure you want to cancel this workflow instance ?';
    $lang['wf_txt_workflow_task_validation_warning'] = 'Are you sure you want to validate this workflow task ?';
    $lang['wf_txt_workflow_task_delete_actor_warning'] = 'Are you sure you want to delete this validation actor ?';
    $lang['wf_txt_workflow_validation_start_warning'] = 'Are you sure you want to start the workflow validation ?';
    //pages header 
    $lang['wf_page_header_workflow_list'] = 'Workflow list';
    $lang['wf_page_header_workflow_instances'] = 'Workflow instances';
    $lang['wf_page_header_workflow_instance_detail'] = 'Workflow instance detail';
    $lang['wf_page_header_workflow_my_tasks'] = 'My workflow tasks';
    $lang['wf_page_header_workflow_detail'] = 'Workflow detail [%s]';
    $lang['wf_page_header_workflow_detail_roles'] = 'Workflow roles';
    $lang['wf_page_header_workflow_detail_nodes'] = 'Workflow nodes';
    $lang['wf_page_header_workflow_detail_nodes_path'] = 'Workflow nodes path';
    $lang['wf_page_header_workflow_node_detail'] = 'Workflow node detail [%s]';
    $lang['wf_page_header_workflow_node_detail_outcomes'] = 'Nodes outcomes';
    $lang['wf_page_header_workflow_instance_entity_detail'] = 'Entity detail';
    $lang['wf_page_header_workflow_instance_validation_actors'] = 'Validation actors';
    $lang['wf_page_header_workflow_instance_tasks'] = 'Tasks';
    
    //menus
    $lang['wf_menu_workflow_config'] = 'Workflow config';
    $lang['wf_menu_workflow_validation'] = 'Workflow validation';
    $lang['wf_menu_workflow_validation_instances'] = 'Workflow instances';
    $lang['wf_menu_workflow_validation_my_task'] = 'My tasks';

    
