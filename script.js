document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".slide");
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");
    const indicatorsContainer = document.querySelector(".slider-indicators");
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
        updateIndicators(index);
    }

    function updateIndicators(index) {
        indicatorsContainer.innerHTML = "";
        slides.forEach((_, i) => {
            const indicator = document.createElement("span");
            indicator.classList.add("indicator");
            if (i === index) indicator.classList.add("active");
            indicator.addEventListener("click", () => showSlide(i));
            indicatorsContainer.appendChild(indicator);
        });
    }

    prevButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    });

    nextButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    });

    showSlide(currentIndex);
    const lightbox = GLightbox({ selector: ".glightbox" });
});


// Inicialização do Fancybox fora do DOMContentLoaded, sem duplicar
document.addEventListener('DOMContentLoaded', function () {
    const videoWrapper = document.getElementById('video-wrapper');
    const videoOverlay = document.getElementById('video-overlay');
    const videoId = 'x3VuNWZW07Q';

    // Função para carregar o vídeo automaticamente
    function loadVideo() {
        const iframe = document.createElement('iframe');
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('allow', 'autoplay');
        // Adicionado autoplay=1 e mute=1 na URL do vídeo
        iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&rel=0&showinfo=0`);
        iframe.style.position = 'absolute';
        iframe.style.top = '0';
        iframe.style.left = '0';
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        iframe.style.border = 'none';
        iframe.style.borderRadius = '2rem';

        if (videoOverlay) {
            videoOverlay.style.opacity = '0';
            videoOverlay.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                videoOverlay.remove();
            }, 300);
        }

        videoWrapper.appendChild(iframe);
    }

    // Carrega o vídeo após um pequeno delay para garantir que a página carregou
    setTimeout(loadVideo, 1000);

    // Mantém o evento de clique como fallback
    if (videoOverlay) {
        videoOverlay.addEventListener('click', loadVideo);
    }

    const demoBtn = document.querySelector('.demo-btn');

    demoBtn.addEventListener('mouseover', function () {
        this.style.transform = 'translateY(-2px)';
    });

    demoBtn.addEventListener('mouseout', function () {
        this.style.transform = 'translateY(0)';
    });

    demoBtn.addEventListener('click', function () {
        alert('Demo em construção!');
    });

    // Verifica se os elementos existem antes de inicializar
    const galleryLinks = document.querySelectorAll('[data-fancybox="gallery"]');

    if (galleryLinks.length > 0) {
        Fancybox.bind('[data-fancybox="gallery"]', {
            groupAll: true,
            Toolbar: {
                display: ['close', 'slideshow', 'fullscreen', 'thumbs', 'download'],
            },
            Thumbs: {
                autoStart: true,
            },
            Image: {
                zoom: true,
            },
            Carousel: {
                transition: 'slide',
                infinite: false,
                items: 29,
            }
        });
    }

    const galleryLinks1 = document.querySelectorAll('[data-fancybox="gallery1"]');

    if (galleryLinks.length > 0) {
        Fancybox.bind('[data-fancybox="gallery1"]', {
            groupAll: true,
            Toolbar: {
                display: ['close', 'slideshow', 'fullscreen', 'thumbs', 'download'],
            },
            Thumbs: {
                autoStart: true,
            },
            Image: {
                zoom: true,
            },
            Carousel: {
                transition: 'slide',
                infinite: false,
                items: 29,
            }
        });
    }
});

// Funcionalidade do botão "Veja Mais"
const vejaMaisBtn = document.querySelector('.veja-mais-btn');
const diferenciaisGrid2 = document.querySelector('.diferenciais-grid-2');

if (vejaMaisBtn && diferenciaisGrid2) {
    // Inicialmente esconde o grid
    diferenciaisGrid2.style.display = 'none';

    vejaMaisBtn.addEventListener('click', function () {
        const isExpanded = diferenciaisGrid2.style.display === 'grid';

        if (!isExpanded) {
            // Mostrar o grid
            diferenciaisGrid2.style.display = 'grid';
            vejaMaisBtn.innerHTML = 'Mostrar Menos <span class="veja-mais-btn-icon"><i class="fas fa-chevron-up"></i></span>';
            diferenciaisGrid2.classList.add('active');
        } else {
            // Esconder o grid
            diferenciaisGrid2.style.display = 'none';
            vejaMaisBtn.innerHTML = 'Mostrar Mais <span class="veja-mais-btn-icon"><i class="fas fa-chevron-down"></i></span>';
            diferenciaisGrid2.classList.remove('active');
        }
    });
}
