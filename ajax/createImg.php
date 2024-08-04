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
    $subDir = md5(strtotime('now').$ip); // 'sail'.rand(10,500)
    $i = 1;

    if (file_exists($mainDir.$subDir) && is_dir($mainDir.$subDir)){
        Img::clearDir($mainDir.$subDir);
    } else {
        mkdir($mainDir.$subDir);
    }

    foreach( $arText as $text ){

        $arRes = $img->textToImg($text['value'], $opts, $text['width'], $text['heigth'], $subDir);

        if ($arRes['success']){
            $resImgText = imagecreatefrompng($arRes['temp_name']);
        } else {
            return jsonResponse(false, errors: ['write_text_img' => 'Ошибка при вносе текста на картинку']);
        }
        
        

        // функция изменения размера
        // $img->createThumb();
    
        $method = 'imagecreatefrom'.$arImg['ext'];
        if (!function_exists($method)){
            $method = 'imagecreatefromjpeg';
        }

        // Альтернатива без ресайза
        $prev = $i - 1;
        if (file_exists($mainDir.'success_meme'.$prev.'.png')){ // prev
            $thumb = imagecreatefrompng($mainDir.'success_meme'.$prev.'.png');
        } else {
            $thumb = $method($arImg['src']);
        }   

        // imagecopy($thumb, $resImgText, $posX, $posY, 0, 0, $width, $heigth);

        $place_save = $mainDir.'success_meme'.$i.'.png';
        if (imagepng($thumb, $place_save)){
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

        $i++;
    }

    // Img::clearDir($mainDir.$subDir, true);

    return $response;
?>