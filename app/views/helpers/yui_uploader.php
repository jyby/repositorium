<?php  
    class YuiUploadComponent extends Object {     
        var $name = 'YuiUploadComponent'; 
    /** 
     * Restore session from POST field if possible. 
     * This is required because flash plugin does not send cookies, through which Cake usually keeps track of sessions. 
     * @param Object &$controller pointer to calling controller 
     * @author Andrew 
     */ 
        function startup(&$controller) { 
            if(isset($_POST[Configure::read('Session.cookie')])) {  
                $controller->Session->id($_POST[Configure::read('Session.cookie')]); 
            } 
        } 
    } 
?> 