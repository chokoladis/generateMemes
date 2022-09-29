<?

// function drawBorder(&$img, $w, $h, &$color, $thickness = 1) {
//     $x1 = 0; 
//     $y1 = 0; 
//     $x2 = $w - 10; 
//     $y2 = $h; 

//     for($i = 0; $i < $thickness; $i++) 
//     { 
//         ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color); 
//     } 
// }

$response = '';

function getName($n = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function addHistory($opts){

    $img = $opts['img_source'];

    $nameFile = getName();

    imagejpeg($img, 'D:\installed\OSPanel\domains\localhost\historylog\temp\t' .$nameFile. '.jpeg', '40%');

    $params = [
        'img_source' => $thumb, 
        'text_source' => $resImgText,
        'posX' => $posX,
        'posY' => $posY, 
        'imgX' => 0,
        'imgY' => 0,
        'width' => $width,
        'heigth' => $heigth
    ];
}

function clear_dir($dir, $rmdir = false)
{
	if ($objs = glob($dir . '/*')) {
		foreach($objs as $obj) {
			is_dir($obj) ? clear_dir($obj, true) : unlink($obj);
		}
	}
	if ($rmdir) {
		rmdir($dir);
	}
}

function textToImg($stockText, $opts, $w, $h, $i){
    
    $textColor = explode(',', $opts['text_color']);
    $border = $opts['border'];

    $image = imagecreatetruecolor($w, $h);

    // Установка прозрачного фона
    imagealphablending($image, true);
    imagesavealpha($image, true);
    imagefill($image,0,0,0x7fff0000);
    
    // if ($border == true){
    //     $borderColor = imagecolorallocate($image, $textColor[0], $textColor[1] ,$textColor[2]);
    //     drawBorder($image, $w, $h, $borderColor, 2);
    // }   

    $font = "D:\installed\OSPanel\domains\localhost\arial.ttf";

    // var_dump($textColor);

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


$arrImg = $_POST['img'];
$arrText = $_POST['arr_text'];

$imgSrc = $arrImg['src'];
$imgW = $arrImg['w_client'];
$imgH = $arrImg['h_client'];

$opts = $_POST['opts'];

$index = 0;
$n = count($arrText);
foreach( $arrText as $text ){

    $posX = $text['x'];
    $posY = $text['y'];
    $width = $text['w'];
    $heigth = $text['h'];
    $width += 60;
    $heigth += 10;
    $value = $text['value'];
    
    textToImg($value, $opts, $width, $heigth, $index);

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
    if (file_exists('custom_meme'.$prevI.'.jpeg')){
        $thumb = imagecreatefromjpeg('custom_meme'.$prevI.'.jpeg');
    } else{
        $thumb = imagecreatefromjpeg($resizeImg);
    }

   
    // Альтернатива без ресайза
    // $prevI = $index - 1;
    // if (file_exists('custom_meme'.$prevI.'.jpeg')){
    //     $thumb = imagecreatefromjpeg('custom_meme'.$prevI.'.jpeg');
    // } else{
    //     $thumb = imagecreatefromjpeg($imgSrc);
    // }   

    imagecopy($thumb, $resImgText, $posX, $posY, 0, 0, $width, $heigth);

    $place_save = 'custom_meme'.$index.'.jpeg';
    if (imagejpeg($thumb, $place_save)){
        // output response
        $response .= 'custom_meme.jpeg';

        // create historyLog cell
        $params = [
            'img_source' => $thumb, 
            'text_source' => $resImgText,
            'posX' => $posX,
            'posY' => $posY, 
            'imgX' => 0,
            'imgY' => 0,
            'width' => $width,
            'heigth' => $heigth
        ];

        addHistory($params);
    }

    imagedestroy($thumb);

    $index++;
}

if ($response != ''){
    echo '{ "status": "ok", "data": "'.$response.'"}';
} else {
    echo '{ "status": "error", "data": "error in output data"}';
}

$dir =  'temp';
clear_dir($dir);
?>