<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/gen.meme/lib/preloader.php'); // submodule
require_once(THEMPLATE_DIR . 'header.php');

use Main\Classes\Helper;

?>
<section class="main">
    <div class="uk-container">
        <div class="title">
            <p>Выберите картинку для мема</p>
            <form action="">
                <p>или
                    <label class="input-file">
                        <input type="file" name="file" id="file">
                        <span class="input-file-text">загрузите свою</span>           
                    </label>
                </p>
            </form>
        </div>
        <div class="content">
            <?

            $files = Helper::searchOriginalImg();

            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = '/gen.meme/'. ORIGINAL_IMG_DIR . $file;
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