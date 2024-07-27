<?php

namespace Main\Classes;

// idea create library from DB with pictures from folder on PC and WEB links
Class Img{

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

    public function clear_dir($dir, $rmdir = false)
    {
        if ($objs = glob($dir . '/*')) {
            foreach($objs as $obj) {
                is_dir($obj) ? self::clear_dir($obj, true) : unlink($obj);
            }
        }
        if ($rmdir) {
            rmdir($dir);
        }
    }

    public function textToImg($stockText, $opts, $w, $h, $i){
        
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
    
        $font = "arial.ttf";
    
        var_dump($textColor);
    
        // Create some colors
        $setColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
        $grey = imagecolorallocate($image, 128, 128, 128);
        // Add some shadow to the text
        imagettftext($image, 16, 0, 11, 21, $grey, $font, $stockText);
    
        // Add the text
        imagettftext($image, 16, 0, 10, 20, $setColor, $font, $stockText);
    
        header('Content-Type: image/png; charset=utf-8');
        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($image, 'temp/temp_text_'.$i.'.png');
    }
    

}
 

?>