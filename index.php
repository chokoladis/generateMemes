<?

require_once($_SERVER['DOCUMENT_ROOT'] . '/gen.meme/lib/preloader.php');
require_once(THEMPLATE_DIR . 'header.php');

use Main\Classes\Helper;
use Main\Classes\Lang;

?>
<section class="main">
    <div class="uk-container">
        <div class="title">
            <p><?=Lang::getText('main.choose_pic_for_meme')?></p>
            <form action="">
                <p><?=Lang::getText('or')?>
                    <label class="input-file">
                        <input type="file" name="file" id="file">
                        <span class="input-file-text"><?=Lang::getText('main.load_your')?></span>
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
                        <div class="btn-create"><?=Lang::getText('main.btn_create')?></div>
                    </div>
                <?
                }
            } else {
                ?>
                <p class="alert-warning"><?=Lang::getText('main.not_picture')?></p>
            <?
            }
            ?>
        </div>
    </div>
</section>

<? require_once(THEMPLATE_DIR . 'footer.php'); ?>