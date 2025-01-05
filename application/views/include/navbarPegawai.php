    <style>
        .navbar {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            margin: 0 auto;
        }

        a span {
            font-size: 1.5rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none !important;
            color: white;
        }

        .logo img {
            margin-right: 0.5rem;
            border-radius: 50%;
        }

        .menu-icon {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
            margin: 0 0.5rem;
        }

        .nav-link {
            text-decoration: none;
            color: white;
            padding: 0.5rem;
            transition: color 0.3s;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--background-color);
            color: var(--primary-color);
            right: 0;
            min-width: 150px;
            padding: 0.5rem 0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            text-decoration: none;
            color: var(--secondary-color);
            padding: 0.5rem 1rem;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Desktop: Hover for dropdown */
        @media (min-width: 1001px) {
            .nav-item.dropdown:hover .dropdown-content {
                display: block;
            }
        }

        /* Mobile: Click to toggle dropdown */
        @media (max-width: 1000px) {
            .menu-icon {
                display: block;
            }

            .nav-menu {
                display: none;
                flex-direction: column;
                background-color: var(--secondary-color);
                width: 100%;
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 100;
            }

            .nav-menu.open {
                display: flex;
            }

            .dropdown-content {
                position: static;
            }

            .dropdown-content a {
                color: var(--secondary-color);
            }

            .dropdown-content a:hover {
                background-color: #ddd;
            }

            /* Mobile: Toggle dropdown on click */
            .nav-item.dropdown.active .dropdown-content {
                display: block;
            }
        }
    </style>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="logo">
                <img class="img-fluid" height="100" width="80" src="<?= base_url("assets/img/logo.png") ?>" alt=""><span>ABSENSI-APP</span>
            </a>
            <div class="menu-icon" onclick="toggleMenu()">☰</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="<?= base_url('berandaUser') ?>" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="<?= base_url('presensiUser') ?>" class="nav-link">Presensi</a></li>
                <li class="nav-item"><a href="<?= base_url('evaluasiDiriUser') ?>" class="nav-link">Evaluasi Diri</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" onclick="toggleDropdown(event)">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="<?= base_url('detailDataUser') ?>">Detail Data Diri</a>
                        <a href="<?= base_url('login') ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            document.querySelector('.nav-menu').classList.toggle('open');
        }

        function toggleDropdown(event) {
            event.preventDefault();
            const dropdown = event.target.closest('.nav-item.dropdown');
            dropdown.classList.toggle('active');
        }
    </script>