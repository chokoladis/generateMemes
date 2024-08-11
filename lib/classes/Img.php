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
            'src' => $filePath, // todo handler
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

    public function textToImg($stockText, $opts, $w, $h, $subDir, $i){
        
        try {
            $textColor = explode(',', $opts['text_color']);
            $border = $opts['border'];
        
            $image = imagecreatetruecolor($w, $h);
        
            // Установка прозрачного фона
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagefill($image,0,0,0x7fff0000);
            
            if ($border == true){
                $borderColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
                self::drawBorder($image, $w, $h, $borderColor, 2);
            }   
        
            $font = ROOT_DIR."/assets/fonts/arial.ttf";
        
            $setColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
            $grey = imagecolorallocate($image, 128, 128, 128);
            imagettftext($image, 16, 0, 11, 21, $grey, $font, $stockText); // тень
            imagettftext($image, 16, 0, 10, 20, $setColor, $font, $stockText); // текст

            // header('Content-Type: image/png; charset=utf-8');

            $tempDir = ROOT_DIR.TEMP_IMG_DIR;

            $imgTextName = 'img_text_'.$i.'.png';
            $imgTextPath = $tempDir.$subDir.$imgTextName;            

            $imgTextWrite = imagepng($image, $imgTextPath);
            return ['success' => $imgTextWrite, 'temp_name' => $imgTextPath];

        } catch (\Throwable $th){
            throw $th;
        }
    }

    public function setResizeThumb(array $arImg, string $pathdir, int $i){

        $imgSrc = $arImg['src'];

        if (!file_exists($pathdir.'resize_img.png')){
            // header('Content-Type: image/jpeg');

            // получение страых и новых размеров
            list($oldW, $oldH) = getimagesize($imgSrc);
            
            $imgW = $arImg['imgW'];
            $imgH = $arImg['imgH'];
        
            if ($imgW == $oldW && $imgH == $oldH){
                $resizeImg = $imgSrc;
            } else {
                // загрузка
                $thumb = imagecreatetruecolor($imgW, $imgH);
                $source = imagecreatefromjpeg($imgSrc);
            
                // изменение размера
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $imgW, $imgH, $oldW, $oldH);
                
                $resizeImg = $pathdir.'resize_img.png';
                imagejpeg($thumb, $resizeImg);
            }
            
        } else {
            $resizeImg = $pathdir.'resize_img.png';
        }

        return $resizeImg;
    }
    
    public function getMethod(string $ext){
        
        $method = 'imagecreatefrom'.$ext;

        if (!function_exists($method)){
            $method = 'imagecreatefromjpeg';
        }

        return $method;
    }

    public function makeSubdir(string $subDir){

        $mainDir = ROOT_DIR.GENERATED_IMG_DIR;
        $tempDir = ROOT_DIR.TEMP_IMG_DIR;

        if (file_exists($mainDir.$subDir) && is_dir($mainDir.$subDir)){
            self::clearDir($mainDir.$subDir);
        } else {
            mkdir($mainDir.$subDir);
        }
        
        if (!file_exists($tempDir.$subDir)){
            mkdir($tempDir.$subDir);
        }
    }

}
 

?>