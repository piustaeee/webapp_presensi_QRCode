<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            width: 100%;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            width: 19rem;
            margin: 1rem;
        }

        h2 {
            text-align: center;
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: white;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #333;
            outline: none;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.8rem;
        }

        .remember-me {
            display: flex;
            /* align-items: center; */
        }

        .remember-me input {
            margin-right: 0.5rem;
            margin-top: -0.3rem;
        }

        .forgot-password {
            color: #333;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #555;
        }

        .signup-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.8rem;
        }

        .signup-link a {
            color: #333;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }




        /* test */
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* background: linear-gradient(45deg, #1a1a1a, #4a148c); */
            background: black;
            font-family: Arial, sans-serif;
            overflow: hidden;
            position: relative;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            z-index: 1;
        }



        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 1);
            pointer-events: none;
            animation: float 4s infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            25% {
                transform: translateY(-20px) translateX(10px);
            }

            50% {
                transform: translateY(-35px) translateX(-10px);
            }

            75% {
                transform: translateY(-20px) translateX(8px);
            }
        }

        .moving-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgb(2, 0, 36);
            background: rgb(44, 62, 80);
            background: linear-gradient(201deg, rgba(44, 62, 80, 1) 0%, rgba(78, 117, 156, 1) 53%, rgba(61, 132, 185, 1) 100%);

            filter: blur(100px);
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <link rel="stylesheet" href="<?php echo base_url('assets/costum/js/sweetalert2.min.css')  ?>">
    <script src="<?php echo base_url('assets/costum/js/sweetalert2.min.js')  ?>"></script>



</head>

<body>
    <div class="moving-gradient"></div>
    <div class="login-container">
        <h2>Selamat Datang</h2>
        <form id="login-form" method="post" action="<?= base_url('Login');  ?>">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo !empty(get_cookie('loginUsername'))
                                                                            ? get_cookie('loginUsername')
                                                                            : set_value('username'); ?>">
                <?= form_error('username', '<small style="color:red; padding-left:3;">', '</small>'); ?>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" value="<?php echo !empty(get_cookie('loginPassword')) ? get_cookie('loginPassword') : ''; ?>">
                    <button type="button" id="toggle-password" aria-label="Toggle password visibility">
                        👁️
                    </button>

                </div>
                <?= form_error('password', '<small style="color:red; padding-left:3;">', '</small>'); ?>
            </div>
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember-me" name="remember-me" <?php echo (get_cookie('loginUsername') ? 'checked' : ''); ?>>
                    <label for="remember-me">ingat saya</label>
                </div>
            </div>
            <button type="submit" class="submit-btn">Masuk</button>
        </form>
    </div>





    <script>
        <?php if ($this->session->flashdata('error')) : ?>
            Swal.fire({
                title: 'Login Gagal!',
                text: '<?= $this->session->flashdata('error'); ?>',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        <?php endif; ?>
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('toggle-password');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
            });
        });
    </script>

    <script>
        // Create floating particles
        function createParticles() {
            const particleCount = 20;
            const body = document.querySelector('body');

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                // Random size between 10px and 30px
                const size = Math.random() * 20 + 10;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;

                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 4}s`;

                body.appendChild(particle);
            }
        }

        // Initialize particles
        createParticles();
    </script>

</body>

</html>