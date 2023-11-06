<?php 
    function verifyString($string){
        if (strpos($string, ' ') == false) {
            return false;
        }else{
            return true;
        }
    }
?>