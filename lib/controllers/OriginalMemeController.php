<?php

namespace Main\Controllers;

use Main\Base\Controller;
use Main\Classes\Helper;
use Main\Models\OriginalMeme;

class OriginalMemeController extends Controller {

    public static function view(OriginalMeme $model){

        $ip = Helper::getIp();
        $ip = str_replace('.', '_', $ip);
        
        $name_session = 'view_'.$ip.'_model_'.$model->getTable().'_'.$model['id'];
        $session_user_view = $_SESSION[$name_session];
        if (!$session_user_view){
            $_SESSION[$name_session] = true;

            if ($model->views()){
                // $model->views('add'); 
            }
        }
    }

    public static function like(){

    }
}