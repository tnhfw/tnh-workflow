<?php
    defined('ROOT_PATH') || exit('Access denied');

    /**
     * 
     */
    class Users_model extends Model {

      protected $table = 'users';
      protected $primaryKey = 'user_id';
        
        public function __construct(){
            parent::__construct();
        }

 
    }
