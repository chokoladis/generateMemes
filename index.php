<? require_once(THEMPLATE_DIR.'header.php'); ?>
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
                    foreach ($arImg as $value) {
                        ?><div class="img">
                            <img src="" data-src="" alt="">
                        </div><?
                    }
                ?>
            </div>
        </div>
    </section>

    <div class="modal">
        <div class="btn close">
            <i class="fas fa-times"></i>
        </div>
        <form action="createImg.php" method="psot">
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
<? require_once(THEMPLATE_DIR.'footer.php'); ?>