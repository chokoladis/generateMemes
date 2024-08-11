        
    <div class="modal" id="modal-create-meme" uk-modal>
        <div class="btn close">
            <i class="fas fa-times"></i>
        </div>
            <form action="/ajax/createImg.php" method="post" class="uk-modal-dialog" uk-overflow-auto>
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

    <div id="modal-new-meme" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <img src="" width="100%" height="100%" alt="">
            <p></p>
        </div>
    </div>
    <footer>
        <div class="uk-container">
            <ul>
                <li>Автор: <a href="https://github.com/chokoladis">chokoladis</a></li>
                <!-- <li></li> -->
            </ul>
            <div class="copyright">
                никакие права не защищены, даже конституцией. 2022-2024
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit-icons.min.js"></script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>