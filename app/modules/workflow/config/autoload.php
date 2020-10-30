<?php
	defined('ROOT_PATH') || exit('Access denied');
	
	/**
	 * Workflow libraries
	 */
	$autoload['libraries'] = array('workflow/WFServiceTaskLib');

	
	/**
	 * Workflow functions
	 */
	$autoload['functions'] = array('workflow/workflow');
	
	/**
	 * Workflow languages
	 */
	$autoload['languages'] = array('workflow/workflow');
