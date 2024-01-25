function recaptchaCallback(response) {
    document.getElementById('recaptcha-response').value = response;
}

document.getElementById('form2').addEventListener('submit', function(e) {
    e.preventDefault(); // Отменить обычную отправку формы

    // Получить данные формы
    var form = e.target;
    var formData = new FormData(form);

    // Добавить параметр doGo в данные формы
    formData.append("doGo", "true");

    // Создать XMLHttpRequest объект
    var xhr = new XMLHttpRequest();

    // Открыть соединение и отправить запрос
    xhr.open('POST', form.getAttribute('action'));

    // Задать обработчик события
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Капча заполнена
                window.location.href = 'index.php';
            } else {
                // Капча не заполнена
                alert('Пожалуйста, заполните капчу.');
            }
        }
    };

    // Отправить данные формы с использованием send()
    xhr.send(formData);
});

