<?

use Main\Classes\Lang;

if (!isset($_COOKIE['LANG']) || !in_array($_COOKIE['LANG'], Lang::$arLang)){
    setcookie('LANG', LANG, time()+678400);
}

$lang = isset($_COOKIE['LANG']) ? $_COOKIE['LANG'] : LANG;

require_once Lang::setLang($lang);
?>
<!DOCTYPE html>
<html lang="<?=$_COOKIE['LANG']?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="chokoladis">
    <meta name="description" content="<?=Lang::getText('main.description')?>">
    <meta name="keywords" content="<?=Lang::getText('main.keywords')?>">
    <title><?Lang::getText('main.titile')?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="/gen.meme/assets/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="/gen.meme/assets/css/style.css">
</head>
<body>
   <header>
    <div class="uk-container">
        <h1><?=Lang::getText('header.h1')?></h1>
        <nav>
            <div class="btn js-set-lang" title="<?Lang::getText('header.change_lang')?>">
                <div class="front">РУ<br><hr>EN</div>
                <div class="items">
                    <a href="/gen.meme?setLang=ru">RU</a>
                    <a href="/gen.meme?setLang=en">EN</a>
                </div>
            </div>
            <div class="btn js-change-theme" title="<?Lang::getText('header.change_theme')?>">
                <img src="/gen.meme/assets/img/change_theme.png" alt="change theme">
            </div>
        </nav>
    </div>
   </header>