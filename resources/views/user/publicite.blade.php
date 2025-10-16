<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Katanga Awards | Intro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <style>
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; visibility: hidden; }
    }
    body.fade-out { animation: fadeOut 1s forwards; }
    html, body {
      height: 100%;
      overflow: hidden;
      background-color: black;
    }
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 24;
    }
  </style>
</head>

<body class="flex items-center justify-center h-screen relative overflow-hidden bg-black">

  <!-- Vidéo -->
  <video id="introVideo" autoplay muted playsinline class="absolute inset-0 w-full h-full object-contain bg-black z-0">
    <source src="{{ asset('TVC_KATANGA AWARDS 16 - SHORT.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la lecture vidéo.
  </video>

  <!-- Overlay -->
  <div class="absolute inset-0 z-10"></div>

  <!-- Logo -->
  <div class="absolute top-4 left-1/2 -translate-x-1/2 md:left-12 md:translate-x-0 z-20">
    <img src="{{ asset('image-katanga-login.jpg') }}" alt="Katanga Award"
         class="w-60 sm:w-32 md:w-32 drop-shadow-lg rounded-full">
  </div>

  <!-- Barre supérieure : boutons et minuteur -->
  <div class="absolute top-[3px] left-0 right-0 flex justify-between items-center px-6 z-30">

    <!-- Bouton Son -->
    <button id="soundToggle"
            class="bg-[#fbcd43] text-black font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg hover:bg-[#A28224] transition flex items-center gap-2">
      <span id="soundIcon" class="material-symbols-outlined text-lg sm:text-xl">volume_off</span>
    </button>

    <!-- Minuteur -->
    <div id="timerDisplay"
         class="bg-black/60 text-white font-semibold px-4 py-1 rounded-full text-sm sm:text-base">
      Temps restant : <span id="timer">--</span>s
    </div>

    <!-- Bouton Passer -->
    <button id="skipButton"
            class="bg-[#fbcd43] text-black font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg hover:bg-[#A28224] transition text-sm sm:text-base">
      Passer
    </button>
  </div>

  <script>
    const video = document.getElementById('introVideo');
    const skipButton = document.getElementById('skipButton');
    const soundToggle = document.getElementById('soundToggle');
    const soundIcon = document.getElementById('soundIcon');
    const timerElement = document.getElementById('timer');
    const redirectUrl = "{{ route('user.index') }}";
    let duration = 0;

    // Quand la vidéo charge, on récupère sa durée
    video.addEventListener('loadedmetadata', () => {
      duration = Math.floor(video.duration);
      timerElement.textContent = duration;

      const interval = setInterval(() => {
        const timeLeft = Math.max(0, Math.ceil(duration - video.currentTime));
        timerElement.textContent = timeLeft;
        if (timeLeft <= 0) clearInterval(interval);
      }, 500);
    });

    // Fin d’intro
    function endIntro() {
      document.body.classList.add('fade-out');
      setTimeout(() => window.location.href = redirectUrl, 800);
    }

    // Toggle du son
    soundToggle.addEventListener('click', () => {
      video.muted = !video.muted;
      soundIcon.textContent = video.muted ? "volume_off" : "volume_up";
      if (!video.paused) video.play();
    });

    // Événements
    video.addEventListener('ended', endIntro);
    skipButton.addEventListener('click', endIntro);
  </script>

</body>
</html>
