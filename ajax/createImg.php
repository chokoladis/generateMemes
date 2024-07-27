<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/lib/preloader.php');

    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    use Main\Classes\Img;

    $img = new Img();

    $arrImg = $_POST['img'];
    $arrText = $_POST['arr_text'];

    $imgSrc = $arrImg['src'];
    $imgW = $arrImg['w_client'];
    $imgH = $arrImg['h_client'];

    $opts = $_POST['opts'];

    // var_dump($_POST);

    $index = 0;
    foreach( $arrText as $text ){

        $posX = $text['x'];
        $posY = $text['y'];
        $width = $text['w'];
        $heigth = $text['h'];
        $width += 60;
        $heigth += 10;
        $value = $text['value'];
        
        $img->textToImg($value, $opts, $width, $heigth, $index);

        $resImgText = imagecreatefrompng('temp/temp_text_'.$index.'.png');
        
        // функция изменения размера
    
        if (!file_exists('temp/resize_img0.jpeg')){
            header('Content-Type: image/jpeg');

            // получение страых и новых размеров
            list($oldW, $oldH) = getimagesize($imgSrc);
        
            if ($imgW == $oldW && $imgH == $oldH){
                $resizeImg = $imgSrc;
            } else {
                // загрузка
                $thumb = imagecreatetruecolor($imgW, $imgH);
                $source = imagecreatefromjpeg($imgSrc);
            
                // изменение размера
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $imgW, $imgH, $oldW, $oldH);
                imagejpeg($thumb, 'temp/resize_img'.$index.'.jpeg');
                $resizeImg = 'temp/resize_img'.$index.'.jpeg';
            }
            
        } else {
            $resizeImg = 'temp/resize_img0.jpeg';
        }
    
        $prevI = $index - 1;
        if (file_exists('success_meme'.$prevI.'.jpeg')){
            $thumb = imagecreatefromjpeg('success_meme'.$prevI.'.jpeg');
        } else{
            $thumb = imagecreatefromjpeg($resizeImg);
        }

    
        // Альтернатива без ресайза
        // $prevI = $index - 1;
        // if (file_exists('success_meme'.$prevI.'.jpeg')){
        //     $thumb = imagecreatefromjpeg('success_meme'.$prevI.'.jpeg');
        // } else{
        //     $thumb = imagecreatefromjpeg($imgSrc);
        // }   

        imagecopy($thumb, $resImgText, $posX, $posY, 0, 0, $width, $heigth);

        $place_save = 'success_meme'.$index.'.jpeg';
        if (imagejpeg($thumb, $place_save)){
            $response = [
                'success' => true,
                'result' => 'success_meme'.$index.'.jpeg'
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


    $dir =  'temp';
    clear_dir($dir);
    // echo $response;
?>