<?php
    //IDs of all top admins (admins that can modify other admins)
    //Can be extended or changed in the future.
    $ADMIN_ID = 33;
    $EXEC1_ID = 34;
    $EXEC2_ID = 35;
    
    $TOP_ADMINS = array($ADMIN_ID, $EXEC1_ID, $EXEC2_ID);
    
    //define("ADMIN_ID", 33);
    //define("EXEC1_ID", 34);
    //define("EXEC2_ID", 35);
    //define("TOP_ADMINS", array(ADMIN_ID, EXEC1_ID, EXEC2_ID));
    
    define("INVALID_AUTHORITY_MESSAGE", 'You do not have the authority for this action.'); 
    
    function isTopAdmin($id){
        //$top = TOP_ADMINS;
        global $TOP_ADMINS;
        //echo $TOP_ADMINS;
        return in_array($id, $TOP_ADMINS);
    }?>