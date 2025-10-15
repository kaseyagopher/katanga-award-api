<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katanga Award | Intro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}">
  <!-- Import des icônes Material Symbols -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

  <style>
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }

    body.fade-out {
      animation: fadeOut 1s forwards;
    }

    html, body {
      height: 100%;
      overflow: hidden;
      background-color: black;
    }

    /* Style pour les icônes Material */
    .material-symbols-outlined {
      font-variation-settings:
        'FILL' 1,
        'wght' 600,
        'GRAD' 0,
        'opsz' 24;
    }
  </style>
</head>
<body class="flex items-center justify-center h-screen relative overflow-hidden bg-black">

  <!-- Logo et texte -->
  <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4 sm:p-20 z-10">
    <img src="{{ asset('logo kataward.png') }}" alt="Katanga Award" class="w-24 sm:w-32 md:w-48 mb-4 sm:mb-6 drop-shadow-lg">
    <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold text-[#fbcd43] drop-shadow-lg">
      Katanga Awards
    </h1>
    <p class="text-white text-base sm:text-lg md:text-xl mt-2">16<sup>ème</sup> Édition</p>
  </div>

  <!-- Minuteur -->
  <div id="timerDisplay"
       class="absolute top-6 left-1/2 -translate-x-1/2 bg-black/60 text-white font-semibold px-4 py-1 rounded-full text-sm sm:text-base z-20">
    Temps restant : <span id="timer">30</span>s
  </div>

  <!-- Vidéo plein écran -->
  <video id="introVideo" autoplay muted playsinline class="absolute inset-0 w-full h-full object-contain bg-black">
    <source src="{{ asset('TVC_KATANGA AWARDS 16 - SHORT.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la lecture vidéo.
  </video>

  <!-- Superposition sombre -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Bouton Toggle Son (avec icône Material) -->
  <button id="soundToggle"
          class="absolute bottom-6 left-6 bg-[#fbcd43] text-black font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg hover:bg-[#A28224] transition z-20 flex items-center gap-2">
    <span id="soundIcon" class="material-symbols-outlined text-lg sm:text-xl">volume_off</span>
  </button>

  <!-- Bouton Passer -->
  <button id="skipButton"
          class="absolute bottom-6 right-6 sm:bottom-8 sm:right-8 bg-[#fbcd43] text-black font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg hover:bg-[#A28224] transition z-20 text-sm sm:text-base">
      Passer
  </button>

  <script>
    const video = document.getElementById('introVideo');
    const skipButton = document.getElementById('skipButton');
    const soundToggle = document.getElementById('soundToggle');
    const soundIcon = document.getElementById('soundIcon');
    const timerElement = document.getElementById('timer');
    const redirectUrl = "{{ route('user.index') }}";

    let timeLeft = 30;
    let timerInterval;

    // Démarrer le minuteur
    function startTimer() {
      timerInterval = setInterval(() => {
        timeLeft--;
        timerElement.textContent = timeLeft;
        if (timeLeft <= 0) {
          clearInterval(timerInterval);
          endIntro();
        }
      }, 1000);
    }

    // Redirection avec fondu
    function endIntro() {
      document.body.classList.add('fade-out');
      setTimeout(() => window.location.href = redirectUrl, 800);
    }

    // Toggle son avec icône Material
    soundToggle.addEventListener('click', () => {
      video.muted = !video.muted;
      if (video.muted) {
        soundIcon.textContent = "volume_off";
      } else {
        soundIcon.textContent = "volume_up";
        video.play(); // s'assure que la vidéo joue
      }
    });

    // Redirection automatique à la fin de la vidéo
    video.addEventListener('ended', endIntro);

    // Redirection si on clique sur passer
    skipButton.addEventListener('click', endIntro);

    // Lancer le minuteur
    window.addEventListener('load', startTimer);
  </script>

</body>
</html>
