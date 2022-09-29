// функции

function modal(param){
   
  var bg_src = null;
  if (typeof(param) == 'string'){
    bg_src = 'img/'+param;
    console.log(bg_src);  
  } else {
    bg_src = $(param).attr('data-src');
  }
  

  $('.modal').addClass('modal_show');
  // $('.modal .img').css('background-image','url('+bg_src+')');
  $('.modal .img').empty();
  $('.modal .img').append('<img src="'+bg_src+'"/>');
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


// вывод всех шаблонов для мемов 
let arr = $('.content .img');
let i = 1;
for (let key of arr){
  $(key).css('background-image','url(img/meme'+i+'.jpg)');
  $(key).attr('data-src', 'img/meme'+i+'.jpg');
  i++
}

// Обработчики событий

$('.main #file').change(function(){
  modal($("#file")[0].files[0].name);
});

$('.main .img').on('click', function(){
  modal($(this));
});

$('.modal .close').on('click', function(){
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
  $('.text_color').toggleClass('text_white');
  $('.text_color').text($('.text_color').css('content'));

  if ($('.text_color').hasClass('text_white')){
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
  
  const select_meme = $('.modal .img img')[0];
  const img = {
    src: select_meme.currentSrc,
    h_client: select_meme.clientHeight,
    w_client: select_meme.clientWidth,
    h_real: select_meme.naturalHeight,
    w_real: select_meme.naturalWidth
  };
  // console.log(img);
  let arr_text = [];

  if ($('.modal textarea').length < 1){
    UIkit.notification({
      message: 'У вас нет текстовых полей, что генерировать то? (:',
      status: 'warning',
      pos: 'bottom-left',
      timeout: 4000
    });
    return false;
  }
  for ( let text of $('.modal textarea')){
    text = {
      y: text.offsetTop,
      x: text.offsetLeft,
      h: text.clientHeight,
      w: text.clientWidth,
      value: text.value
    }
    arr_text.push(text);
  }

  let opts = {
    text_color,
    border
  };

  let send_data = {
    img,
    arr_text,
    opts
  };

  // console.log(send_data);  

  $.ajax({
    url:'createImg.php',
    method: 'post',
    data: send_data,
    dataType: 'html',
    // contentType: "application/json",
    success: function(data){
      console.log(data);
      let response = JSON.parse(data);
      console.log(response);

      $('.slider .response').empty();
      if (response.status == 'ok'){
        console.log('success');
        console.log(response.data);
        $('.slider .response').append('<img src="'+response.data+'"/>');
        $('.slider .response').css('display','block');
      }

    }
  })
});