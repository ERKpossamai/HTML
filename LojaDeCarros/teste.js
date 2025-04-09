let index = 0;

function moveSlide() {
    const slides = document.querySelectorAll(".carrossel img");
    const totalSlides = slides.length;

    index = (index + 1) % totalSlides; // Avança uma imagem por vez e volta para a primeira

    const carrossel = document.querySelector(".carrossel");
    carrossel.style.transform = `translateX(-${index * 100}%)`;
}
setInterval(moveSlide, 3000);