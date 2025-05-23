document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.navegation');

  toggle.addEventListener('click', () => {
    nav.classList.toggle('active');
  });
});