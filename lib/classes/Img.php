<?php

namespace Main\Classes;

// idea create library from DB with pictures from folder on PC and WEB links
Class Img{

    public function handlerPostValues() {

        $arImg = $_POST['img'];
        $arText = $_POST['arText'];

        if (empty($arImg) || empty($arText)){
            return jsonResponse(success:false, errors: ['empty_data' => 'Заполните все данные']);
        }

        $filePath = ROOT_DIR.$arImg['src'];
        
        $resImg = [
            'src' => ROOT_DIR.$arImg['src'], // todo
            'ext' => pathinfo($filePath, PATHINFO_EXTENSION),
            'size' => filesize($filePath),
            'imgW' => intval($arImg['w_client']),
            'imgH' => intval($arImg['h_client']),
        ];

        foreach( $arText as $key => $text ){

            $resText[$key] = [
                'posX' => intval($text['x']),
                'posY' => intval($text['y']),
                'width' => intval($text['w']) + 60,
                'heigth' => intval($text['h']) + 10,
                'value' => Helper::secureInput($text['value']),
            ];
        }

        // todo
        $opts = $_POST['opts'];

        
        $arValues = [
            'resImg' => $resImg,
            'resText' => $resText,
            'options' => $opts
        ];

        return $arValues;
    }

    public function drawBorder(&$img, $w, $h, &$color, $thickness = 1) {
        $x1 = 0; 
        $y1 = 0; 
        $x2 = $w - 10; 
        $y2 = $h; 
    
        for($i = 0; $i < $thickness; $i++) 
        { 
            ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color); 
        }
    }

    public static function clearDir($dir, $rmdir = false)
    {
        if ($objs = glob($dir . '/*')) {
            foreach($objs as $obj) {
                is_dir($obj) ? self::clearDir($obj, true) : unlink($obj);
            }
        }
        if ($rmdir) {
            rmdir($dir);
        }
    }

    public function textToImg($stockText, $opts, $w, $h, $i){
        
        try {
            $textColor = explode(',', $opts['text_color']);
            $border = $opts['border'];
        
            $image = imagecreatetruecolor($w, $h);
        
            // Установка прозрачного фона
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagefill($image,0,0,0x7fff0000);
            
            // if ($border == true){
            //     $borderColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
            //     self::drawBorder($image, $w, $h, $borderColor, 2);
            // }   
        
            $font = ROOT_DIR."/assets/fonts/arial.ttf";
        
            // Create some colors
            $setColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
            $grey = imagecolorallocate($image, 128, 128, 128);
            // Add some shadow to the text
            imagettftext($image, 16, 0, 11, 21, $grey, $font, $stockText);
        
            // Add the text
            imagettftext($image, 16, 0, 10, 20, $setColor, $font, $stockText);
        
            header('Content-Type: image/png; charset=utf-8');
            
            // start todo here
            return imagepng($image, ROOT_DIR.TEMP_IMG_DIR.'temp_text_'.$i.'.png');

        } catch (\Throwable $th){
            throw $th;
        }
    }

    public function createThumb(){

        // if (!file_exists(ROOT_DIR.TEMP_IMG_DIR.'resize_img0.png')){
        //     header('Content-Type: image/jpeg');

        //     // получение страых и новых размеров
        //     list($oldW, $oldH) = getimagesize($imgSrc);
        
        //     if ($imgW == $oldW && $imgH == $oldH){
        //         $resizeImg = $imgSrc;
        //     } else {
        //         // загрузка
        //         $thumb = imagecreatetruecolor($imgW, $imgH);
        //         $source = imagecreatefromjpeg($imgSrc);
            
        //         // изменение размера
        //         imagecopyresized($thumb, $source, 0, 0, 0, 0, $imgW, $imgH, $oldW, $oldH);
        //         imagejpeg($thumb, ROOT_DIR.TEMP_IMG_DIR.'resize_img'.$index.'.png');
        //         $resizeImg = TEMP_IMG_DIR.'resize_img'.$index.'.png';
        //     }
            
        // } else {
        //     $resizeImg = TEMP_IMG_DIR.'resize_img0.png';
        // }

        // $prevI = $index - 1;
        // if (file_exists(GENERATED_IMG_DIR.'success_meme'.$prevI.'.png')){
        //     $thumb = imagecreatefromjpeg(GENERATED_IMG_DIR.'success_meme'.$prevI.'.png');
        // } else{
        //     $thumb = imagecreatefromjpeg(ROOT_DIR.$resizeImg);
        // }
    }
    

}
 

?>