<?

use Main\Classes\Img;

require_once($_SERVER['DOCUMENT_ROOT'].'/gen.meme/lib/preloader.php');

$action = $_GET['action'];

switch ($action) {
    case 'loadCustomImg':

        $arCustomImg = $_FILES['file'];

        if (empty($arCustomImg)){
            echo jsonResponse(false, errors: ['Вы не загрузили картинку']);
            return;
        }

        echo Img::handlerCustomImg($arCustomImg);
        break;
    default:
        # code...
        break;
}