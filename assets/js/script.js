// функции
async function loadCustomImg(modal, file) {

  let data = new FormData()
  data.append('file', file.files[0])

  let response = await fetch('/gen.meme/ajax/index.php?action=loadCustomImg', {
    method: 'POST',
    body: data
  });

  if (response.ok) {

    let json = await response.json();

    if (json.success) {
      $(modal).find('.img').append('<img src="' + json.result.tempPath + '"/>');
    } else {
      alert("Ошибки - " + json.errors);
    }

  } else {
    alert("Ошибка HTTP: " + response.status);
  }
}

function modal(modal, param) {

  $(modal).find('.img').empty();

  if (param.files) {
    loadCustomImg(modal, param);
  } else {
    const imgSrc = $(param).find('img').attr('data-src');
    $(modal).find('.img').append('<img src="' + imgSrc + '"/>');
  }

  UIkit.modal(modal).show();

  // UIkit.notification({
  //   message: 'Заполните строку поиска',
  //   status: 'primary',
  //   pos: 'bottom-left',
  //   timeout: 4000
  // });
}

function addInput(id, posX, posY) {
  $('.work_area .img').append('<textarea id="' + id + '"></textarea>');
  $('.work_area textarea#' + id).css('left', posX);
  $('.work_area textarea#' + id).css('top', posY);
}

function checkInputCreated() {
  const inputs = $('.modal textarea');
  if ($(inputs).length < 1) {
    return false;
  } else {
    return true;
  }
}

// Обработчики событий
$(function () {

  var text_color = '255,255,255';
  var border = false;

  $('.border').text($('.border').css('content'));
  $('.text_color').text($('.text_color').css('content'));

  $('.main #file').change(() => {
    _tmr.push({ id: '3544855', type: 'reachGoal', goal: 'load_custom_img' });
    modal('#modal-create-meme', $("#file")[0]);
  });

  $('.main .img').on('click', function () {
    _tmr.push({ id: '3544855', type: 'reachGoal', goal: 'click_original_img' });
    modal('#modal-create-meme', $(this));
  });

  $('.modal .close').on('click', () => {
    $('.modal').removeClass('modal_show');
  });

  $('body').on('click', '.modal .img img', function (e) {
    const target = this.getBoundingClientRect();
    const x = e.clientX - target.left;
    const y = e.clientY - target.top;

    let inputId = 'text1';
    let i = 1;

    const inputs = $('.modal textarea');
    if (inputs.length != 0) {
      for (let input of inputs) {

        inputId = $(input).attr('id');
        inputId += i;

        i++;

        if (i > 8) {
          // console.error('Может хватит уже текста*??');

          UIkit.notification({
            message: 'Дядь, куда тебе столько полей?',
            status: 'warning',
            pos: 'bottom-left',
            timeout: 4000
          });
          return;
        }
      }
    }

    addInput(inputId, x, y);

    if (checkInputCreated()) {
      $('.modal .tools').removeClass('disable');
    } else {
      $('.modal .tools').addClass('disable');
    }
  });

  // функция изменения цвета текста
  $('.text_color').on('click', function () {
    $(this).toggleClass('text_white');
    $(this).text($('.text_color').css('content'));

    if ($(this).hasClass('text_white')) {
      text_color = '255,255,255';
    } else {
      text_color = '0,0,0';
    }
  });

  $('.border').on('click', function () {
    $('.border').toggleClass('border_set');
    $('.border').text($('.border').css('content'));

    if ($('.border').hasClass('border_set')) {
      border = true;
    } else {
      border = false;
    }
  });

  $('.del_all').on('click', function () {
    $('.modal textarea').remove();
  });

  $('body').on('keydown', 'textarea', function (e) {
    // 1 windows , 2 macos
    if (e.code == 'Delete' || (e.code == 'Backspace' && e.metaKey)) {
      $(this).remove()
    }
  });

  // change theme
  $('header .btn').on('click', () => {
    $('html').toggleClass('ligth');
  });

  $('.generate.btn').on('click', function () {

    _tmr.push({ id: '3544855', type: 'reachGoal', goal: 'try_create' });

    const select_meme = $('.modal .img img');
    const img = {
      src: select_meme.attr('src'),
      h_client: select_meme[0].clientHeight,
      w_client: select_meme[0].clientWidth,
    };

    let arText = [];

    for (let text of $('.modal textarea')) {
      text = {
        y: text.offsetTop,
        x: text.offsetLeft,
        h: text.clientHeight,
        w: text.clientWidth,
        value: text.value
      }
      arText.push(text);
    }

    const opts = {
      text_color,
      border
    };

    const send_data = {
      img,
      arText,
      opts
    };

    $.ajax({
      url: '/gen.meme/ajax/createImg.php',
      method: 'post',
      data: send_data,
      success: function (json) {
        // console.log(json);

        $('#modal-new-meme').find('p').removeClass();

        if (json.success) {
          _tmr.push({ id: '3544855', type: 'reachGoal', goal: 'success_create' });
          $('#modal-new-meme').find('img').attr('src', json.result);
          $('#modal-new-meme').find('p').addClass('success');
          $('#modal-new-meme').find('p').text('Ваш мем готов, сохраните к себе на устройство.');
          UIkit.modal('#modal-create-meme').hide();
        } else {
          $('#modal-new-meme').find('p').addClass('error');
          $('#modal-new-meme').find('p').text(json.error);
        }

        UIkit.modal('#modal-new-meme').show();
      }
    })
  });
});
