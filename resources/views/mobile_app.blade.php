<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/style.css', 'resources/js/app.js'])

	<style>
        body {
            overscroll-behavior-y: auto;
        }

        .pull-to-refresh {
            position: fixed;
            top: -50px;
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: top 0.7s ease-in-out;
        }

        .pull-to-refresh.visible {
            top: 0;
        }

        .tweets {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div id="root"></div>

    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="{{ asset('ion.sound-3.0.7/ion.sound.min.js') }}"></script>
    <script>
        ion.sound({
            sounds: [{
                name: "bell_ring"
            }, ],

            // main config
            path: "../ion.sound-3.0.7/sounds/",
            preload: true,
            multiplay: true,
            volume: 0.9
        });

        const updateMessageSound = () => {
            ion.sound.play("bell_ring");
        }

        const onBackPressed = () => {
            if (typeof window.backButtonHandel === "function") {
                backButtonHandel();
            } else {
                AndroidInterface.showToast("Hello JS APP");
            }
        }
    </script>
</body>

</html>
