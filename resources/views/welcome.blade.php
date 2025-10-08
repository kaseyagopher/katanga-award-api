<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carousel avec texte</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .carousel-item {
      transition: transform 0.5s ease-in-out;
      position: relative;
    }
    .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      padding: 1rem;
      text-align: center;
    }
  </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-3xl relative">
    <!-- Carousel -->
    <div id="carousel" class="overflow-hidden rounded-xl relative">
      <div class="carousel-inner flex">
        <!-- Slide 1 -->
        <div class="carousel-item flex-shrink-0 w-full">
          <img src="https://via.placeholder.com/800x400/ff7f7f/333333?text=Slide+1" class="w-full h-64 object-cover rounded-xl" alt="Slide 1">
          <div class="overlay">
            <h2 class="text-2xl font-bold">Slide 1 Titre</h2>
            <p class="mt-2 text-sm">Voici une description pour le premier slide.</p>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item flex-shrink-0 w-full">
          <img src="https://via.placeholder.com/800x400/7fbfff/333333?text=Slide+2" class="w-full h-64 object-cover rounded-xl" alt="Slide 2">
          <div class="overlay">
            <h2 class="text-2xl font-bold">Slide 2 Titre</h2>
            <p class="mt-2 text-sm">Description pour le deuxième slide.</p>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item flex-shrink-0 w-full">
          <img src="https://via.placeholder.com/800x400/7fff7f/333333?text=Slide+3" class="w-full h-64 object-cover rounded-xl" alt="Slide 3">
          <div class="overlay">
            <h2 class="text-2xl font-bold">Slide 3 Titre</h2>
            <p class="mt-2 text-sm">Description pour le troisième slide.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Contrôles -->
    <button id="prev" class="absolute top-1/2 left-2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
      &#10094;
    </button>
    <button id="next" class="absolute top-1/2 right-2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
      &#10095;
    </button>

    <!-- Indicateurs -->
    <div class="flex justify-center space-x-2 mt-4">
      <button class="indicator w-3 h-3 rounded-full bg-gray-400"></button>
      <button class="indicator w-3 h-3 rounded-full bg-gray-400"></button>
      <button class="indicator w-3 h-3 rounded-full bg-gray-400"></button>
    </div>
  </div>

  <script>
    const carousel = document.querySelector('#carousel .carousel-inner');
    const items = document.querySelectorAll('.carousel-item');
    const prev = document.getElementById('prev');
    const next = document.getElementById('next');
    const indicators = document.querySelectorAll('.indicator');

    let index = 0;

    function showSlide(i) {
      index = (i + items.length) % items.length;
      const offset = -index * 100;
      carousel.style.transform = `translateX(${offset}%)`;
      indicators.forEach((dot, idx) => dot.classList.toggle('bg-white', idx === index));
    }

    prev.addEventListener('click', () => showSlide(index - 1));
    next.addEventListener('click', () => showSlide(index + 1));
    indicators.forEach((dot, idx) => dot.addEventListener('click', () => showSlide(idx)));
    setInterval(() => showSlide(index + 1), 4000);

    showSlide(index);
  </script>

</body>
</html>
