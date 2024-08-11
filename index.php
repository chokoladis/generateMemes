<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/preloader.php');
require_once(THEMPLATE_DIR . 'header.php');

use Main\Classes\Helper;

?>
<section class="main">
    <div class="uk-container">
        <div class="title">
            <p>Выберите картинку для мема</p>
            
        </div>
        <div class="content">
            <?

            $files = Helper::searchOriginalImg();

            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = ORIGINAL_IMG_DIR . $file;
            ?>
                    <div class="img">
                        <img src="<?= $path ?>" data-src="<?= $path ?>" alt="">
                    </div>
                <?
                }
            } else {
                ?>
                <p class="alert-warning">Нету картинок для мемов</p>
            <?
            }
            ?>
        </div>
    </div>
</section>

<? require_once(THEMPLATE_DIR . 'footer.php'); ?>