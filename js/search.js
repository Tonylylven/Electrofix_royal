$(document).ready(function () {
    $('.check__input').keyup(function () {
      var id = $(this).val();
  
      $.ajax({
        url: 'php/search.php',
        type: 'post',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
          $('.check__result').empty(); // Очистка результатов перед выводом новых результатов
          
          if (response.status === 'success') {
            var html = '<div>' +
              '<p>Производитель: ' + response.manufacturer + '</p>' +
              '<p>Модель: ' + response.model + '</p>' +
              '<p>Статус ремонта: ' + response.status_repair + '</p>' +
              '<p>Неисправность: ' + response.component + '</p>' +
              '<p>Дата начала работ: ' + response.start_date + '</p>' +
              '</div>';
  
            $('.check__result').html(html);
          } else {
            $('.check__result').html('<p>Заказ не найден</p>');
          }
        },
        error: function () {
          $('.check__result').empty(); // Очистка результатов при возникновении ошибки
        }
      });
    });
  });