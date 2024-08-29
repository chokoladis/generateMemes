<?

require_once($_SERVER['DOCUMENT_ROOT'].'/gen.meme/lib/preloader.php');

use Main\Classes\Img;
use Main\Classes\Lang;
use Main\Controllers\OriginalMemeController;
use Main\Models\OriginalMeme;

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
    case 'view':

        if (!isset($_POST['path']))
            echo jsonResponse(false, errors: [ Lang::getText('ajax.not_all_params_set') ]);

        preg_match('/meme[\d]+\.[a-z]{3,4}/ui', $_POST['path'], $matches);

        if (empty($matches))
            echo jsonResponse(false, errors: [ Lang::getText('ajax.id_must_be_bigger') ]);

        $model = new OriginalMeme;
        $meme = $model->findOne(['path' => $matches[0]], type: 'LIKE');
        var_dump($meme);

        OriginalMemeController::view($meme);

        break;
    case 'like': 
        break;
    default:
        # code...
        break;
}