// функции

function modal(param){
   
  var bg_src = null;
  if (typeof(param) == 'string'){
    bg_src = 'img/'+param;
    console.log(bg_src);  
  } else {
    bg_src = $(param).find('img').attr('data-src');
  }
  console.log(bg_src);
  

  $('.modal').addClass('modal_show');
  // $('.modal .img').css('background-image','url('+bg_src+')');
  $('.modal .img').empty();
  $('.modal .img').append('<img src="'+bg_src+'"/>');

  // UIkit.notification({
  //   message: 'Заполните строку поиска',
  //   status: 'primary',
  //   pos: 'bottom-left',
  //   timeout: 4000
  // });
}

function addInput(id,posX,posY){
  $('.work_area .img').append('<textarea id="'+id+'"></textarea>');
  $('.work_area textarea#'+id).css('left',posX);
  $('.work_area textarea#'+id).css('top',posY);
}

function checkInputCreated(){
  let inputs = $('.modal textarea');
  if ($(inputs).length < 1){
    return false;
  } else {
    return true;
  }
}

// Обработчики событий
$(function(){
  $('.main #file').change(() => {
    modal($("#file")[0].files[0].name);
  });
  
  $('.main .img').on('click', function(){
    modal($(this));
  });
  
  $('.modal .close').on('click', () => {
    $('.modal').removeClass('modal_show');
  });
  
  $('body').on('click','.modal .img img', function(e){
    var target = this.getBoundingClientRect();
    var x = e.clientX - target.left;
    var y = e.clientY - target.top;
  
    let inputId = 'text1';
    let i = 1;
  
    let inputs = $('.modal textarea');
    if (inputs.length != 0){
      for (let input of inputs){
  
        inputId = $(input).attr('id');
        inputId += i;
  
        i++;
        if (i>4){
          console.error('Может хватит уже текста*??');
          UIkit.notification({
            message: 'Слишком много текстовых полей',
            status: 'warning',
            pos: 'bottom-left',
            timeout: 4000
          });
          return;
        }
      }
    }
  
    addInput(inputId,x,y);
  
    if (checkInputCreated()){
      $('.modal .tools').removeClass('disable');
    } else {
      $('.modal .tools').addClass('disable');
    }
  });
  
  $('.text_color').text($('.text_color').css('content'));
  
  var text_color = '255,255,255';
  // функция изменения цвета текста
  $('.text_color').on('click', function(){  
    $(this).toggleClass('text_white');
    $(this).text($('.text_color').css('content'));
  
    if ($(this).hasClass('text_white')){
      text_color = '255,255,255';
    } else {
      text_color = '0,0,0';
    }
  });
  
  var border = false;
  $('.border').text($('.border').css('content'));
  $('.border').on('click', function(){
    $('.border').toggleClass('border_set');
    $('.border').text($('.border').css('content'));
  
    if ($('.border').hasClass('border_set')){
      border = true;
    } else {
      border = false;
    }
  });
  
  $('.del_all').on('click', function(){
    $('.modal textarea').remove();
  });
  
  // Если textarea в фокусе и нажимается кнопка Delete текстовый блок удаляется
  $('body').on('keyup','textarea', function(e){
    if (e.code == 'Delete'){
      console.log($(this).remove());
    }
  });
  
  // смена темы
  $('header .btn').on('click', () => {
    $('html').toggleClass('ligth');
  });
  
  
  $('.generate.btn').on('click', function(){
    
    const select_meme = $('.modal .img img');
    const img = {
      src: select_meme.attr('src'),
      h_client: select_meme[0].clientHeight,
      w_client: select_meme[0].clientWidth,
    };
    
    let arText = [];
  
    for ( let text of $('.modal textarea')){
      text = {
        y: text.offsetTop,
        x: text.offsetLeft,
        h: text.clientHeight,
        w: text.clientWidth,
        value: text.value
      }
      arText.push(text);
    }
  
    let opts = {
      text_color,
      border
    };
  
    let send_data = {
      img,
      arText,
      opts
    };
  
    console.log(send_data);  
  
    $.ajax({
      url:'/ajax/createImg.php',
      method: 'post',
      data: send_data,
      // dataType: 'json',
      // contentType: "application/json",
      success: function(data){
        console.log(data);
      }
    })
  });
});
