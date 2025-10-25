<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Katanga Awards | Intro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('logo kataward.png') }}" />
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
  </style>
</head>

<body class="flex items-center justify-center h-screen relative overflow-hidden bg-black">

  <img src="{{ asset('KATANGA AWARD AFFICHE CARRE PORTRAIT[1].jpg') }}"
       alt="Katanga Award"
       class="absolute inset-0 w-full h-full object-contain z-0">

  <div class="absolute inset-0 z-10"></div>

  <script>
    const skipButton = document.getElementById('skipButton');
    const redirectUrl = "{{ route('user.index') }}";

    function endIntro() {
      document.body.classList.add('fade-out');
      setTimeout(() => window.location.href = redirectUrl, 800);
    }

    setTimeout(endIntro, 5000);

    skipButton.addEventListener('click', endIntro);
  </script>

</body>
</html>
