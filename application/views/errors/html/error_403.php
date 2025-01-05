<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background-color: #8B0000; /* Dark red */
            color: #ffffff;
        }
        .container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        p {
            font-size: 1.5rem;
            margin-top: 1rem;
        }
        .home-link {
            margin-top: 2rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            color: #ffffff;
            background-color: #4a4a8a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .home-link:hover {
            background-color: #6a6aaa;
        }
        .space {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .asteroid {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: #ffffff;
            border-radius: 50%;
            opacity: 0.5;
            animation: float 20s infinite linear;
        }
        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0);
            }
            100% {
                transform: translateY(-100vh) translateX(100vw);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <p>Maaf! Akses Terlarang.</p>
        <a href="/" class="home-link">Kembali Ke Menu Utama</a>
    </div>
    <div class="space" id="space"></div>

    <script>
        // Create asteroids
        const space = document.getElementById('space');
        for (let i = 0; i < 100; i++) {
            const asteroid = document.createElement('div');
            asteroid.classList.add('asteroid');
            asteroid.style.left = `${Math.random() * 100}%`;
            asteroid.style.top = `${Math.random() * 100}%`;
            asteroid.style.animationDuration = `${15 + Math.random() * 15}s`;
            space.appendChild(asteroid);
        }
    </script>
</body>
</html>
