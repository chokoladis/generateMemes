<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/lib/preloader.php');

    use Main\Classes\Img;

    $img = new Img();

    // clear values
    $arrImg = $_POST['img'];
    $arrText = $_POST['arText'];

    $imgSrc = ROOT_DIR.$arrImg['src'];
    $imgW = $arrImg['w_client'];
    $imgH = $arrImg['h_client'];

    $opts = $_POST['opts'];

    $index = strtotime('now');
    foreach( $arrText as $text ){

        $posX = $text['x'];
        $posY = $text['y'];
        $width = $text['w'];
        $heigth = $text['h'];
        $width += 60;
        $heigth += 10;
        $value = $text['value'];
        
        $img->textToImg($value, $opts, $width, $heigth, $index);

        $resImgText = imagecreatefrompng(ROOT_DIR.TEMP_IMG_DIR.'temp_text_'.$index.'.png');
        
        // функция изменения размера
    
        if (!file_exists(ROOT_DIR.TEMP_IMG_DIR.'resize_img0.jpeg')){
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
                imagejpeg($thumb, ROOT_DIR.TEMP_IMG_DIR.'resize_img'.$index.'.jpeg');
                $resizeImg = TEMP_IMG_DIR.'resize_img'.$index.'.jpeg';
            }
            
        } else {
            $resizeImg = TEMP_IMG_DIR.'resize_img0.jpeg';
        }
    
        $prevI = $index - 1;
        if (file_exists(GENERATED_IMG_DIR.'success_meme'.$prevI.'.jpeg')){
            $thumb = imagecreatefromjpeg(GENERATED_IMG_DIR.'success_meme'.$prevI.'.jpeg');
        } else{
            $thumb = imagecreatefromjpeg(ROOT_DIR.$resizeImg);
        }

    
        // // Альтернатива без ресайза
        // // $prevI = $index - 1;
        // // if (file_exists('success_meme'.$prevI.'.jpeg')){
        // //     $thumb = imagecreatefromjpeg('success_meme'.$prevI.'.jpeg');
        // // } else{
        // //     $thumb = imagecreatefromjpeg($imgSrc);
        // // }   

        imagecopy($thumb, $resImgText, $posX, $posY, 0, 0, $width, $heigth);

        $place_save = ROOT_DIR.GENERATED_IMG_DIR.'success_meme'.$index.'.jpeg';
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