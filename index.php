<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gen.meme</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
   <header>
    <div class="uk-container">
        <h1>Суперпупермегаультрасексипушкабомба генератор мемов 2022</h1>
        <span class="btn" title="смена темы">
            <img src="img/change_theme.png" alt="">
        </span>
    </div>
   </header>
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
                <div class="img" id="img1"></div>
                <div class="img" id="img2"></div>
                <div class="img" id="img3"></div>
                <div class="img" id="img4"></div>
                <div class="img" id="img5"></div>
                <div class="img" id="img6"></div>
                <div class="img" id="img7"></div>
                <div class="img" id="img8"></div>
                <div class="img" id="img9"></div>
                <div class="img" id="img10"></div>
                <div class="img" id="img11"></div>
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


    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.9/dist/js/uikit-icons.min.js"></script>
    <script src="js/JQuery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>