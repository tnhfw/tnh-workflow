<?php 
    defined('ROOT_PATH') || exit('Access denied');
 	/**
 	 * File upload language message (French) 
 	 */
 	$lang['fu_upload_err_ini_size']     = 'Le fichier téléchargé dépasse la directive upload_max_filesize dans le fichier php.ini.';
    $lang['fu_upload_err_form_size']   	= 'Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML.';
    $lang['fu_upload_err_partial']   	= 'Le fichier téléchargé n\'a été que partiellement téléchargé.';
    $lang['fu_upload_err_no_file'] 		= 'Aucun fichier n\'a été choisi. S\'il vous plait sélectionner en un.';
    $lang['fu_upload_err_no_tmp_dir']   = 'Absence d\'un dossier temporaire.';
    $lang['fu_upload_err_cant_write'] 	= 'Échec de l\'écriture du fichier sur le disque.';
    $lang['fu_upload_err_extension']    = 'Une extension PHP a arrêté le téléchargement du fichier.';
    $lang['fu_accept_file_types']  		= 'Type de fichier non autorisé';
    $lang['fu_file_uploads_disabled']   = 'L\'option de téléchargement de fichier est désactivée dans php.ini';
    $lang['fu_max_file_size']           = 'La taille du fichier téléchargé est trop grande %s';
    $lang['fu_overwritten_not_allowed'] = 'Vous ne permettez pas d’écraser un fichier existant';
	
