        
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
            <div class="copyright">
                никакие права не защищены. 2022-2024
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit-icons.min.js"></script>
    <script src="/gen.meme/assets/js/jquery.js"></script>
    <script src="/gen.meme/assets/js/script.js"></script>
    <!-- Top.Mail.Ru counter -->
    <script type="text/javascript">
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "3544855", type: "pageView", start: (new Date()).getTime()});
    (function (d, w, id) {
    if (d.getElementById(id)) return;
    var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
    ts.src = "https://top-fwz1.mail.ru/js/code.js";
    var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
    if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "tmr-code");
    </script>
    <noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3544855;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
    <!-- /Top.Mail.Ru counter -->
</body>
</html>