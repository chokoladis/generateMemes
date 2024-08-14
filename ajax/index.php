<?

use Main\Classes\Img;
use Main\Classes\Lang;

require_once($_SERVER['DOCUMENT_ROOT'].'/gen.meme/lib/preloader.php');

$action = $_GET['action'];

switch ($action) {
    case 'loadCustomImg':

        $arCustomImg = $_FILES['file'];;

        if (empty($arCustomImg)){
            echo jsonResponse(false, errors: [ Lang::getText('ajax.you_not_load_img') ]);
            return;
        }

        echo Img::handlerCustomImg($arCustomImg);
        break;
    default:
        # code...
        break;
}