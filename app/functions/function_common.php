<?php
   
    function is_login(){
        $isLogin = false;
        $obj = &get_instance();
        $session_name = 'auth_session';
        $u = $obj->session->get($session_name);
        $isLogin = !empty($u)
        && !empty($u['id'])
        && !empty($u['login']);
        return $isLogin;
    }

    function auth(){
        $isLogin = is_login();
        if(!$isLogin){
            sfwarning('Please login first');
            get_instance()->response->redirect('users/login');
        }
    }

    function auth_get_params($key){
        //first check if the user is authenticated
        auth();
        $session_name = 'auth_session';
        $obj = &get_instance();
        $u = $obj->session->get($session_name);
        if(is_array($u) && isset($u[$key])){
            return $u[$key];
        }
        throw new Exception("Unknown auth session key ".$key, 1);
    }

    function get_leave_entity_name(){
        return 'leave';
    }

    if(!function_exists('get_flash')){
         function get_flash($type){
             $obj = & get_instance();
             return $obj->session->getFlash($type);
         }
    }
    
    if(!function_exists('set_flash')){
         function set_flash($type, $msg){
             $obj = & get_instance();
             $obj->session->setFlash($type, $msg);
         }
    }
    
    
    if(!function_exists('has_flash')){
         function has_flash($type){
             $obj = & get_instance();
             return $obj->session->hasFlash($type);
         }
    }

    /* =================================================================================*/
    /**
     * the prefix "f" means "flash"
     */
    if(!function_exists('fsuccess')){
         function fsuccess(){
             return get_flash('success');
         }
    }
    
    
    if(!function_exists('finfo')){
         function finfo(){
             return get_flash('info');
         }
    }
    
    if(!function_exists('ferror')){
         function ferror(){
             return get_flash('error');
         }
    }
    
    if(!function_exists('fwarning')){
         function fwarning(){
             return get_flash('warning');
         }
    }
    
    
    /* ========================================================================================================*/
    /**
     * the prefix "sf" means "set flash"
     */
    if(!function_exists('sfsuccess')){
         function sfsuccess($msg){
            set_flash('success', $msg);
         }
    }
    
    if(!function_exists('sfinfo')){
         function sfinfo($msg){
            set_flash('info', $msg);
         }
    }
    
    if(!function_exists('sferror')){
         function sferror($msg){
            set_flash('error', $msg);
         }
    }
    
    
    if(!function_exists('sfwarning')){
         function sfwarning($msg){
            set_flash('warning', $msg);
         }
    }
    /* ===========================================================================================================*/

    /* ========================================================================================================*/
    /**
     * the prefix "hf" means "has flash"
     */
    if(!function_exists('hfsuccess')){
         function hfsuccess(){
            return has_flash('success');
         }
    }
    
    if(!function_exists('hfinfo')){
         function hfinfo(){
            return has_flash('info');
         }
    }
    
    if(!function_exists('hferror')){
         function hferror(){
            return has_flash('error');
         }
    }
    
    
    if(!function_exists('hfwarning')){
         function hfwarning(){
            return has_flash('warning');
         }
    }
    /* ===========================================================================================================*/

