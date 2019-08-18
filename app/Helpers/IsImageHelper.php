<?php 

namespace App\Helpers;

class IsImageHelper {
    /**
     * Check The is an Image Or Not
     * @return Boolean
     */

     public static function check($file){
        if(\File::exists($file)){
            $mime = mime_content_type($file);
            if(substr($mime, 0, 5) == 'image') {
                // this is an image
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
     }
}