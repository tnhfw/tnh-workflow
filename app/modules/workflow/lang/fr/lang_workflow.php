<?php
    defined('ROOT_PATH') || exit('Access denied');
    
	/**
     * Workflow language messages (French) 
     */
    
    // texte commun
    $lang['wf_txt_valide'] = 'Valider';
    $lang['wf_txt_back'] = 'Retour';
    $lang['wf_txt_edit'] = 'Modifier';
    $lang['wf_txt_cancel'] = 'Annuler';
    $lang['wf_txt_detail'] = 'Détail';
    $lang['wf_txt_create'] = 'Créer';
    $lang['wf_txt_workflow_add_role'] = 'Ajouter un rôle';
    $lang['wf_txt_workflow_task_add_actor'] = 'Ajouter un acteur';
    $lang['wf_txt_workflow_add_node'] = 'Ajouter un noeud';
    $lang['wf_txt_workflow_add_node_path'] = 'Ajouter le chemin du noeud';
    $lang['wf_txt_workflow_node_add_outcome'] = 'Ajouter le résultat du noeud';
    $lang['wf_txt_action'] = 'Action';
    $lang['wf_txt_delete'] = 'Supprimer';
    $lang['wf_txt_yes'] = 'Oui';
    $lang['wf_txt_no'] = 'Non';
    $lang['wf_txt_none'] = 'Aucun';
    $lang['wf_txt_reason'] = 'Raison';
    $lang['wf_txt_task_state_processing'] = 'Traitement';
    $lang['wf_txt_task_state_completed'] = 'Terminé';
    $lang['wf_txt_task_state_canceled'] = 'Annulé';
    $lang['wf_txt_instance_state_processing'] = 'Traitement';
    $lang['wf_txt_instance_state_completed'] = 'Terminé';
    $lang['wf_txt_instance_state_canceled'] = 'Annulé';
    $lang['wf_txt_task_cancel_trigger_user'] = 'Par utilisateur';
    $lang['wf_txt_task_cancel_trigger_system'] = 'Par système';
    $lang['wf_txt_node_condition_type_outcome'] = 'Résultat';
    $lang['wf_txt_node_condition_type_entity'] = 'Propriété de l\'entité';
    $lang['wf_txt_node_condition_type_script_result'] = 'Résultat du script';
    $lang['wf_txt_node_condition_type_service_result'] = 'Résultat du service';
    $lang['wf_txt_workflow_state_active'] = 'Actif';
    $lang['wf_txt_workflow_state_deactive'] = 'Désactivé';
    $lang['wf_txt_node_task_type_user'] = 'Noeud utilisateur';
    $lang['wf_txt_node_task_type_decision'] = 'Noeud de décision';
    $lang['wf_txt_node_task_type_script'] = 'Noeud de script';
    $lang['wf_txt_node_task_type_service'] = 'Noeud de service';
    $lang['wf_txt_node_type_start'] = 'Noeud de début';
    $lang['wf_txt_node_type_intermediate'] = 'Noeud intermédiaire';
    $lang['wf_txt_node_type_end'] = 'Noeud de fin';
    $lang['wf_txt_start_workflow_validation'] = 'Lancer la validation du workflow';
    $lang['wf_txt_workflow_validation_instance_detail'] = 'Détail de l\'instance de workflow';
    $lang['wf_txt_workflow_detail'] = 'Détail du workflow';
    $lang['wf_txt_workflow_task_validation_outcome_result'] = 'Résultat';


    //des champs
    $lang['wf_field_user'] = 'Utilisateur';
    $lang['wf_field_role'] = 'Rôle';
    $lang['wf_field_task'] = 'Tâche';
    $lang['wf_field_instance'] = 'Instance';
    $lang['wf_field_workflow'] = 'Workflow';
    $lang['wf_field_outcome'] = 'Résultat';
    $lang['wf_field_node'] = 'Noeud';
    $lang['wf_field_node_path_node_from'] = 'Noeud de';
    $lang['wf_field_node_path_node_to'] = 'Noeud vers';
    $lang['wf_field_workflow_id'] = 'ID de workflow';
    $lang['wf_field_workflow_name'] = 'Nom du workflow';
    $lang['wf_field_workflow_desc'] = 'Description';
    $lang['wf_field_workflow_state'] = 'État';
    $lang['wf_field_inst_id'] = 'ID d\'instance';
    $lang['wf_field_inst_state'] = 'État';
    $lang['wf_field_inst_desc'] = 'Description';
    $lang['wf_field_inst_start_date'] = 'Date de début';
    $lang['wf_field_inst_end_date'] = 'Date de fin';
    $lang['wf_field_inst_entity_id'] = 'ID d\'entité';
    $lang['wf_field_inst_entity_name'] = 'Nom de l\'entité';
    $lang['wf_field_inst_entity_detail'] = 'Détail de l\'entité';
    $lang['wf_field_inst_start_comment'] = 'Commentaire de lancement';
    $lang['wf_field_inst_start_by'] = 'Lancer par';
    $lang['wf_field_node_id'] = 'ID du noeud';
    $lang['wf_field_node_name'] = 'Libellé';
    $lang['wf_field_node_task_type'] = 'Type de tâche';
    $lang['wf_field_node_type'] = 'Type de noeud';
    $lang['wf_field_node_validation_role'] = 'Rôle de validation';
    $lang['wf_field_node_script'] = 'Script';
    $lang['wf_field_node_service'] = 'Service';
    $lang['wf_field_node_service_args'] = 'Argument de la méthode de service';
    $lang['wf_field_node_state'] = 'État';
    $lang['wf_field_node_oc_id'] = 'ID de résultat';
    $lang['wf_field_node_oc_code'] = 'Code de résultat';
    $lang['wf_field_node_oc_name'] = 'Libellé du résultat';
    $lang['wf_field_node_path_id'] = 'ID de chemin';
    $lang['wf_field_node_path_name'] = 'Libellé';
    $lang['wf_field_node_path_cond_type'] = 'Type de cond.';
    $lang['wf_field_node_path_cond_name'] = 'Nom de cond.';
    $lang['wf_field_node_path_cond_operator'] = 'Opérateur';
    $lang['wf_field_node_path_cond_value'] = 'Valeur de cond.';
    $lang['wf_field_node_path_cond_outcome_value'] = 'Valeur du résultat';
    $lang['wf_field_node_path_is_default'] = 'Est-ce par défaut?';
    $lang['wf_field_node_path_order'] = 'Ordre d\'exécution';
    $lang['wf_field_role_id'] = 'ID de rôle';
    $lang['wf_field_role_name'] = 'Libellé du rôle';
    $lang['wf_field_user_role_id'] = 'ID';
    $lang['wf_field_task_id'] = 'ID de tâche';
    $lang['wf_field_task_state'] = 'État';
    $lang['wf_field_task_cancel_trigger'] = 'Raison d\'annulation';
    $lang['wf_field_task_comment'] = 'Commentaire';
    $lang['wf_field_task_start_time'] = 'Date de début';
    $lang['wf_field_task_end_time'] = 'Date de fin';
    $lang['wf_field_task_node'] = 'Noeud de tâche';
    $lang['wf_field_task_actor'] = 'Validateur';
    $lang['wf_field_task_outcome_result'] = 'Résultat';
    
    // Messages de base de données
    $lang['wf_txt_database_no_data'] = 'Aucun enregistrement trouvé';
    $lang['wf_txt_database_insert_ok'] = 'Les données ont été enregistrées avec succès';
    $lang['wf_txt_database_insert_warning'] = 'Certaines données n\'ont pas été enregistrées pour une raison inconnue.';
    $lang['wf_txt_database_update_ok'] = 'Les données ont été modifiées avec succès';
    $lang['wf_txt_database_delete_ok'] = 'Les données ont bien été supprimées';
    $lang['wf_txt_database_insert_error'] = 'Une erreur s\'est produite lors de l\'enregistrement des données';
    $lang['wf_txt_database_update_error'] = 'Une erreur s\'est produite lors de la modification des données';
    $lang['wf_txt_database_delete_error'] = 'Une erreur s\'est produite lors de la suppression des données';
    $lang['wf_txt_database_data_not_exists'] = 'Impossible de trouver l\'enregistrement que vous recherchez, veuillez réessayer plus tard.';

    // Légende du formulaire
    $lang['wf_workflow_fle_create'] = 'Ajout d\'un workflow';
    $lang['wf_workflow_fle_edit'] = 'Mise à jour du workflow';
    $lang['wf_workflow_node_fle_create'] = 'Ajouter un noeud pour le workflow [%s]';
    $lang['wf_workflow_node_fle_edit'] = 'Mise à jour du noeud de workflow';
    $lang['wf_workflow_node_path_fle_create'] = 'Ajouter un chemin de noeud pour le workflow [%s]';
    $lang['wf_workflow_node_path_fle_edit'] = 'Mise à jour du chemin du noeud de workflow';
    $lang['wf_workflow_role_fle_create'] = 'Ajouter un rôle pour le workflow [%s]';
    $lang['wf_workflow_role_fle_edit'] = 'Mise à jour du rôle de workflow';
    $lang['wf_workflow_outcome_fle_create'] = 'Ajouter un résultat pour le noeud [%s]';
    $lang['wf_workflow_outcome_fle_edit'] = 'Mise à jour des résultats du noeud de workflow';
    $lang['wf_workflow_task_validation_fle'] = 'Validation du workflow';
    $lang['wf_workflow_instance_fle_start'] = 'Lancer la validation du workflow pour l\'entité [%s]';
    $lang['wf_workflow_instance_fle_actor_create'] = 'Ajouter des acteurs pour l\'instance de workflow [%s]';
    

    // espace réservé de formulaire
    $lang['wf_fp_workflow_name'] = 'Entrez le nom du workflow';
    $lang['wf_fp_workflow_desc'] = 'Entrez la description du workflow';
    $lang['wf_fp_workflow_node_name'] = 'Entrez le nom du noeud du workflow';
    $lang['wf_fp_workflow_node_script'] = 'Définition de script PHP';
    $lang['wf_fp_workflow_node_service_arg'] = 'Argument(s) de la méthode de service. Exemple: arg1, arg2, argn ';
    $lang['wf_fp_workflow_node_path_name'] = 'Entrez le nom du chemin du noeud de workflow';
    $lang['wf_fp_workflow_node_path_cond_name'] = 'Entrez le nom de la condition du chemin du noeud de workflow (Entité uniquement)';
    $lang['wf_fp_workflow_node_path_cond_value'] = 'Entrez la valeur de condition du chemin du noeud de workflow';
    $lang['wf_fp_workflow_node_path_order'] = 'Entrez l\'ordre d\'exécution du chemin du noeud de workflow (utilisé dans le noeud de décision)';
    $lang['wf_fp_workflow_role_name'] = 'Entrez le nom du rôle de workflow';
    $lang['wf_fp_workflow_node_outcome_code'] = 'Entrez le code de résultat du noeud de workflow';
    $lang['wf_fp_workflow_node_outcome_name'] = 'Entrez le nom du résultat du noeud de workflow';
    $lang['wf_fp_workflow_task_validation_comment'] = 'Entrez le commentaire de validation de la tâche de workflow';
    $lang['wf_fp_workflow_instance_desc'] = 'Entrez la description de l\'instance';
    $lang['wf_fp_workflow_instance_entity_detail'] = 'Entrez les détails de l\'entité';
    $lang['wf_fp_workflow_instance_start_comment'] = 'Entrer le commentaire de début';
    
    // quelques messages
    $lang['wf_txt_active_data_warning'] = 'Êtes-vous sûr de vouloir activer cet élément?';
    $lang['wf_txt_delete_data_warning'] = 'Êtes-vous sûr de vouloir supprimer les éléments?';
    $lang['wf_txt_delete_selected_data_warning'] = 'Êtes-vous sûr de vouloir supprimer les éléments sélectionnés?';
    $lang['wf_txt_node_already_exists_error'] = 'Le noeud existe déjà pour ce workflow!';
    $lang['wf_txt_start_node_already_exists_error'] = 'Le noeud de démarrage existe déjà pour ce workflow!';
    $lang['wf_txt_end_node_already_exists_error'] = 'Le noeud final existe déjà pour ce workflow!';
    $lang['wf_txt_role_required_for_user_node_error'] = 'Svp c\'est le noeud utilisateur, choisissez le rôle de validation dans la liste!';
    $lang['wf_txt_script_required_for_script_node_error'] = 'Svp c\'est le noeud script, entrez le script !';
    $lang['wf_txt_service_required_for_service_node_error'] = 'Svp c\'est le noeud service, sélectionnez le service!';
    $lang['wf_txt_service_arg_required_for_service_method_error'] = 'Veuillez saisir l’argument de méthode de service requis!';
    $lang['wf_txt_node_path_node_from_or_to_not_exists_error'] = 'Le noeud de ou vers n\'existe pas !';
    $lang['wf_txt_node_path_already_exists_error'] = 'Le chemin du noeud existe déjà pour ce workflow !';
    $lang['wf_txt_start_node_is_destination_node_error'] = 'Le noeud de départ ne peut pas être le noeud de destination !';
    $lang['wf_txt_end_node_is_source_node_error'] = 'Le noeud final ne peut pas être le noeud source !';
    $lang['wf_txt_source_destination_node_is_same_error'] = 'Le noeud source et le noeud de destination ne peuvent pas être identiques !';
    $lang['wf_txt_decision_node_for_source_destination_error'] = 'Le noeud source et le noeud de destination ne peuvent pas être le noeud de décision!';
    $lang['wf_txt_multiple_destination_path_for_no_decision_node_error'] = 'Seul le noeud de décision peut avoir plusieurs chemins de destination !';
    $lang['wf_txt_condition_operator_required_error'] = 'Veuillez choisir un opérateur de condition';
    $lang['wf_txt_condition_value_required_error'] = 'Veuillez saisir la valeur de la condition';
    $lang['wf_txt_condition_outcome_value_required_error'] = 'Veuillez choisir la valeur du résultat pour le type de résultat';
    $lang['wf_txt_condition_entity_name_required_error'] = 'Veuillez saisir le nom de la condition pour le type d\'entité';
    $lang['wf_txt_role_already_exists_error'] = 'Le rôle existe déjà pour ce workflow !';
    $lang['wf_txt_add_outcome_not_user_task_or_start_end_node_error'] = 'Ce n\'est pas un noeud utilisateur ou le noeud de début/fin impossible d\'ajouter de résultat!';
    $lang['wf_txt_outcome_already_exists_error'] = 'Le résultat existe déjà pour ce noeud !';
    $lang['wf_txt_no_outcome_for_user_task_warning'] = 'Impossible de trouver des résultats pour la tâche utilisateur [%s] veuillez configurer ce noeud !';
    $lang['wf_txt_validation_task_not_valid_error'] = 'La tâche n\'est pas valide ou n\'existe pas ou vous n\'êtes pas le validateur actuel !';
    $lang['wf_txt_validation_entiy_not_found_error'] = 'Impossible de trouver l\'entité !';
    $lang['wf_txt_validation_instance_not_found_error'] = 'L\'instance de workflow n\'existe pas!';
    $lang['wf_txt_validation_instance_state_not_valid_error'] = 'Le statut de l\'instance de workflow n\'est pas valide ou est déjà terminé!';
    $lang['wf_txt_validation_success'] = 'Validation du workflow réussie !';
    $lang['wf_txt_validation_success_and_finish_no_next_node_or_end_node'] = 'Le workflow est validé avec succès et le workflow se termine car le noeud suivant n\'existe pas ou le noeud final est atteint !';
    $lang['wf_txt_validation_success_and_finish_no_actors_for_user_node'] = 'Workflow validé avec succès et workflow se termine car le noeud utilisateur n\'a pas d\'acteurs de validation !';
    $lang['wf_txt_validation_success_and_finish_no_path_for_decision_node'] = 'Le workflow est validé avec succès et le workflow se termine parce que le noeud de décision n\'a pas un noeud suivant, il se peut que les conditions ne correspondent pas !';
    $lang['wf_txt_validation_already_start_error'] = 'La validation du workflow a déjà commencé!';
    $lang['wf_txt_validation_workflow_not_valid_error'] = 'Le workflow n\'existe pas ou n\'est pas actif!';
    $lang['wf_txt_validation_workflow_start_node_not_valid_error'] = 'Le workflow n\'a pas un noeud de démarrage ou n\'est pas actif !';
    $lang['wf_txt_validation_workflow_end_node_not_valid_error'] = 'Le workflow n\'a pas un noeud final ou n\'est pas actif!';
    $lang['wf_txt_validation_start_success'] = 'Le workflow a démarré avec succès!';
    $lang['wf_txt_validation_start_success_and_finish_no_next_node_or_end_node'] = 'Le workflow a démarré avec succès et le workflow s\'est terminé car le noeud suivant n\'existe pas ou le noeud final est atteint!';
    $lang['wf_txt_validation_start_success_and_finish_no_actors_for_user_node'] = 'Le workflow a démarré avec succès et le workflow se termine parce que le noeud utilisateur n\'a pas d\'acteurs de validation !';
    $lang['wf_txt_validation_start_success_and_finish_no_path_for_decision_node'] = 'Le workflow a démarré avec succès et le workflow se termine parce que le noeud de décision n\'a pas le noeud suivant, les conditions peuvent ne pas correspondre !';
    $lang['wf_txt_validation_cancel_instance_state_not_valid_error'] = 'Workflow déjà terminé ou annulé !';
    $lang['wf_txt_validation_cancel_instance_success'] = 'Workflow annulé avec succès! ';
    $lang['wf_txt_validation_add_user_role_instance_state_not_valid_error'] = 'Le workflow n\'existe pas ou est déjà terminé ou annulé !';
    $lang['wf_txt_validation_add_user_role_instance_success'] = 'Acteurs ajoutés avec succès!';
    $lang['wf_txt_validation_delete_user_role_instance_state_not_valid_error'] = 'Le workflow n\'existe pas ou est déjà terminé ou annulé !';
    $lang['wf_txt_validation_delete_user_role_instance_success'] = 'Acteurs supprimés avec succès !';
    $lang['wf_txt_workflow_instance_cancel_warning'] = 'Êtes-vous sûr de vouloir annuler cette instance de workflow ?';
    $lang['wf_txt_workflow_task_validation_warning'] = 'Êtes-vous sûr de vouloir valider cette tâche de workflow ?';
    $lang['wf_txt_workflow_task_delete_actor_warning'] = 'Êtes-vous sûr de vouloir supprimer cet acteur de validation ?';
    $lang['wf_txt_workflow_validation_start_warning'] = 'Êtes-vous sûr de vouloir démarrer la validation du workflow ?';
    // en-tête de pages
    $lang['wf_page_header_workflow_list'] = 'Liste des workflows';
    $lang['wf_page_header_workflow_instances'] = 'Instances de workflow';
    $lang['wf_page_header_workflow_instance_detail'] = 'Détail de l\'instance de workflow';
    $lang['wf_page_header_workflow_my_tasks'] = 'Mes tâches de workflow';
    $lang['wf_page_header_workflow_detail'] = 'Détail du workflow [%s]';
    $lang['wf_page_header_workflow_detail_roles'] = 'Rôles de workflow';
    $lang['wf_page_header_workflow_detail_nodes'] = 'Noeuds de workflow';
    $lang['wf_page_header_workflow_detail_nodes_path'] = 'Chemin des noeuds de workflow';
    $lang['wf_page_header_workflow_node_detail'] = 'Détail du noeud de workflow [%s]';
    $lang['wf_page_header_workflow_node_detail_outcomes'] = 'Résultats des noeuds';
    $lang['wf_page_header_workflow_instance_entity_detail'] = 'Détail de l\'entité';
    $lang['wf_page_header_workflow_instance_validation_actors'] = 'Acteurs de validation';
    $lang['wf_page_header_workflow_instance_tasks'] = 'Tâches';
    
    // menus
    $lang['wf_menu_workflow_config'] = 'Configuration du workflow';
    $lang['wf_menu_workflow_validation'] = 'Validation du workflow';
    $lang['wf_menu_workflow_validation_instances'] = 'Instances de workflow';
    $lang['wf_menu_workflow_validation_my_task'] = 'Mes tâches';

    
