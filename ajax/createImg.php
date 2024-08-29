<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/gen.meme/lib/preloader.php');

use Main\Classes\Img;
use Main\Classes\Helper;
use Main\Classes\Lang;

$img = new Img();

$arValues = $img->handlerPostValues();

$arImg = $arValues['resImg'];
$arText = $arValues['resText'];
$opts = $arValues['options'];

$ip = Helper::getIp() ?? md5(rand(10000, 99999));
$mainDir = ROOT_DIR . GENERATED_IMG_DIR;
$tempDir = ROOT_DIR . TEMP_IMG_DIR;
$subDir = md5($ip) . '/';

$finalPathImg = '';
$i = 1;

$img->makeSubdir($subDir);

foreach ($arText as $key => $text) {

    $arRes = $img->textToImg($text['value'], $opts, $text['width'], $text['heigth'], $subDir, $i);

    if ($arRes['success']) {
        $resImgText = imagecreatefrompng($arRes['temp_name']);
    } else {
        return jsonResponse(false, errors: ['write_text_img' => Lang::getText('ajax.error.write_text_img')]);
    }

    $resizeImg = $img->setResizeThumb($arImg, $tempDir . $subDir, $i);
    $method = $img->getMethod($resizeImg);

    $prev = $i - 1;
    $partMemePath = $tempDir . $subDir . 'part_meme_' . $prev . '.png';
    if (file_exists($partMemePath)) { // prev
        $thumb = imagecreatefrompng($partMemePath);
    } else {
        $thumb = $method($resizeImg);
    }

    if (!imagecopy($thumb, $resImgText, $text['posX'], $text['posY'], 0, 0, $text['width'], $text['heigth'])) {
        return jsonResponse(false, errors: ['copy_text_img' => Lang::getText('ajax.error.copy_text_img')]);
    }

    if (array_key_last($arText) == $key) {
        $finalPathImg = $subDir . 'meme_' . time() . '.webp';
        $place_save = $mainDir . $finalPathImg;
        $methodSave = 'imagewebp';
    } else {
        $place_save = $tempDir . $subDir . 'part_meme_' . $i . '.png';
        $methodSave = 'imagepng';
    }

    if ($methodSave($thumb, $place_save)) {
        $response = [
            'success' => true,
            'result' => '/gen.meme' . GENERATED_IMG_DIR . $finalPathImg
        ];
    } else {
        $response = [
            'success' => false,
            'errors' => Lang::getText('ajax.error.forming_img')
        ];
    }


    $i++;
}

Img::clearDir($tempDir . $subDir);

header('Content-type: application/json; charset=utf-8');

echo json_encode($response, JSON_UNESCAPED_SLASHES);
