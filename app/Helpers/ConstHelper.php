<?php
namespace App\Helpers;
use Config;

class ConstHelper
{
    //to display dynamic FAILED_DB_CONSTRAINT_DELETE_MESSAGE from const.php
    public static function getFailedDbConstraintDeleteMessage($PARENT_MENU, $CHILD_MENU)
    {
        $msg = Config::get('const.FAILED_DB_CONSTRAINT_DELETE_MESSAGE');
        if($PARENT_MENU != '') {
            $msg = str_replace('PARENT_MENU', $PARENT_MENU, $msg);
        }
        if($CHILD_MENU != '') {
            $msg = str_replace('CHILD_MENU', $CHILD_MENU, $msg);
        }

        return $msg;
    }
}