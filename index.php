<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/preloader.php');
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

<div class="modal">
    <div class="btn close">
        <i class="fas fa-times"></i>
    </div>
    <form action="/ajax/createImg.php" method="post">
        <div class="work_area">
            <div class="img"></div>
        </div>
        <div class="modal_footer">
            <div class="tools disable">
                <div class="text_color text_white">
                </div>
                <div class="border">
                </div>
                <div class="del_all">
                    Удалить все поля
                </div>

            </div>
            <a class="btn generate">Сгенерировать мемчик</a>
        </div>
    </form>
</div>
<? require_once(THEMPLATE_DIR . 'footer.php'); ?>