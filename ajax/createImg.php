<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/lib/preloader.php');

    use Main\Classes\Img;
    use Main\Classes\Helper;

    $img = new Img();

    $arValues = $img->handlerPostValues();

    $arImg = $arValues['resImg'];
    $arText = $arValues['resText'];
    $opts = $arValues['options'];
    
    $ip = Helper::getIp() ?? md5(rand(10000,99999));
    $mainDir = ROOT_DIR.GENERATED_IMG_DIR;
    $tempDir = ROOT_DIR.TEMP_IMG_DIR;
    // $subDir = md5(strtotime('now').$ip); // 'sail'.rand(10,500)
    $subDir = md5($ip).'/';
    $finalPathImg = '';
    $i = 1;

    $img->makeSubdir($subDir);

    foreach( $arText as $key => $text ){

        // var_dump($subDir);
        $arRes = $img->textToImg($text['value'], $opts, $text['width'], $text['heigth'], $subDir, $i);
        // var_dump($arRes);
        // exit;

        if ($arRes['success']){
            $resImgText = imagecreatefrompng($arRes['temp_name']);
        } else {
            return jsonResponse(false, errors: ['write_text_img' => 'Ошибка при вносе текста на картинку']);
        }
        

        // функция изменения размера
        $resizeImg = $img->setResizeThumb($arImg, $tempDir.$subDir, $i);
        $method = $img->getMethod($arImg['ext']);

        // Альтернатива без ресайза
        $prev = $i - 1;
        $partMemePath = $tempDir.$subDir.'part_meme_'.$prev.'.png';
        if (file_exists($partMemePath)){ // prev
            $thumb = imagecreatefrompng($partMemePath);
        } else {
            // $thumb = $method($arImg['src']);
            $thumb = $method($resizeImg);
        }   

        if (!imagecopy($thumb, $resImgText, $text['posX'], $text['posY'], 0, 0, $text['width'], $text['heigth'])){
            return jsonResponse(false, errors: ['copy_text_img' => 'Системная ошибка при копировании картинки']);
        }
        
        if (array_key_last($arText) == $key){
            $finalPathImg = $subDir.'meme_'.time().'.png';
            $place_save = $mainDir.$finalPathImg;
        } else {
            $place_save = $tempDir.$subDir.'part_meme_'.$i.'.png';
        }
        
        if (imagepng($thumb, $place_save)){
            $response = [
                'success' => true,
                'result' => GENERATED_IMG_DIR.$finalPathImg
            ];
        } else {
            $response = [
                'success' => false,
                'errors' => 'Ошибка формирования картинки'
            ];
        }


        // imagedestroy($thumb);

        $i++;
    }

    Img::clearDir($tempDir.$subDir, true);

    header('Content-type: application/json; charset=utf-8');

    echo json_encode($response, JSON_UNESCAPED_SLASHES);
?>