
  $('.close-popup').click(function() {
    $('.popup-bg').fadeOut(800);
    $('html').removeClass('no-scroll');
    $('.request__form')[0].reset();
    $('.request__form')[0].reset();
  });

  // BURGER


document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("burger").addEventListener("click", function() {
      document.querySelector("header").classList.toggle("open")
  })
})


$('.request__form').submit(function(e) {
  e.preventDefault(); // отменяем стандартное поведение формы
  var form_data = $(this).serialize(); // преобразуем данные формы в строку для отправки на сервер
  var captchaResponse = grecaptcha.getResponse(); // получаем значение капчи
  if (captchaResponse == "") { // если капча не заполнена
    alert("Пожалуйста, заполните капчу"); // выводим alert с просьбой заполнить капчу
  } else {
    // если капча заполнена, отправляем данные на обработчик
    $.ajax({
      type: 'POST', // метод запроса
      url: 'php/add_form.php', // адрес обработчика формы
      data: form_data, // данные формы
      success: function(response) {
        if (response.indexOf('Error') === -1) { // если ответ содержит слово 'Error', значит произошла ошибка
          $('#order_id').text(response); // выводим ID заказа в попапе
          $('.popup-bg').fadeIn(800);
          $('html').addClass('no-scroll');
        } else {
          alert('Произошла ошибка при добавлении заказа');
        }
      }
    });
  }
});