const filterButtons = document.querySelectorAll('.btn');
const items = document.querySelectorAll('.orders__item');

filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    const category = button.getAttribute('data-category');

    // добавляем класс active выбранной кнопке и убираем его у других
    filterButtons.forEach(btn => {
      btn.classList.remove('active');
    });
    button.classList.add('active');

    // отображаем или скрываем элементы в зависимости от категории
    items.forEach(item => {
      if (item.classList.contains(category)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
});
