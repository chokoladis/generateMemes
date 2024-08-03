<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/lib/preloader.php');

    use Main\Classes\Img;

    $img = new Img();

    $arValues = $img->handlerPostValues();
    $arImg = $arValues['resImg'];
    $arText = $arValues['resText'];
    $opts = $arValues['options'];
    
    $index = strtotime('now'); // + random string
    foreach( $arText as $text ){
        
        if ($img->textToImg($arText['value'], $opts, $arText['width'], $arText['heigth'], $index)){
            $resImgText = imagecreatefrompng(ROOT_DIR.TEMP_IMG_DIR.'temp_text_'.$index.'.png');
        } else {
            return jsonResponse(false, errors: ['write_text_img' => 'Ошибка при вносе текста на картинку']);
        }
        
        // функция изменения размера
        // $img->createThumb();
    
        // // Альтернатива без ресайза
        $prevI = $index - 1;
        if (file_exists(ROOT_DIR.GENERATED_IMG_DIR.'success_meme'.$prevI.'.jpeg')){
            $thumb = imagecreatefromjpeg(ROOT_DIR.GENERATED_IMG_DIR.'success_meme'.$prevI.'.jpeg');
        } else{
            $thumb = imagecreatefromjpeg($arImg['src']);
        }   

        // imagecopy($thumb, $resImgText, $posX, $posY, 0, 0, $width, $heigth);

        $place_save = ROOT_DIR.GENERATED_IMG_DIR.'success_meme'.$index.'.png';
        if (imagejpeg($thumb, $place_save)){
            $response = [
                'success' => true,
                'result' => $place_save
            ];
        } else {
            $response = [
                'success' => false,
                'errors' => 'Ошибка формирования картинки'
            ];
        }

        imagedestroy($thumb);

        $index++;
    }


    Img::clearDir(TEMP_IMG_DIR);
?>