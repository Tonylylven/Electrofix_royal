$('.open-popup').click(function(e) {
  e.preventDefault();
  $('.popup-bg').fadeIn(800);
  $('html').addClass('no-scroll');
  $('#burger').addClass('burger-disabled');
});

$('.close-popup, .close-popup2').click(function() {
  $('.popup-bg, .popup-bg2').fadeOut(800);
  $('html').removeClass('no-scroll');
  $('#burger').removeClass('burger-disabled');
});

const popupBg = document.querySelector('.popup-bg');
const popupBg2 = document.querySelector('.popup-bg2');

// Открытие первого попапа
const link = document.querySelector('.popup__link');

link.addEventListener('click', function(e) {
  e.preventDefault();
  popupBg.style.display = 'none';
  popupBg2.style.display = 'block';
  $('#burger').addClass('burger-disabled');
});

// Открытие второго попапа
const link2 = document.querySelector('.popup2__link');

link2.addEventListener('click', function(e) {
  e.preventDefault();
  popupBg2.style.display = 'none';
  popupBg.style.display = 'block';
  $('#burger').addClass('burger-disabled');
});


// 3 попап

$('.problems__button').click(function(e) {
  e.preventDefault();
  $('.popup-bg3').fadeIn(800);
  $('html').addClass('no-scroll');
  $('#burger').addClass('burger-disabled');
});

$('.close-popup3').click(function() {
  $('.popup-bg3').fadeOut(800);
  $('html').removeClass('no-scroll');
  $('#burger').removeClass('burger-disabled');
});

// BURGER

document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("burger").addEventListener("click", function() {
    document.querySelector("header").classList.toggle("open");
  });
});
