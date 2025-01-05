<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin: 15px 0 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        background-color: #4CAF50;
        color: #fff;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 20px;
    }

    button:hover {
        background-color: #45a049;
    }

    .valid {
        color: green;
    }

    .invalid {
        color: red;
    }
</style>

<body>
    <div class="container">
        <h2>Update Akun Pegawai</h2>
        <form action="<?php echo base_url('Admin/KelolaData/updateAkunPegawai') ?>" method="POST">
            <!-- Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" maxlength="100" required placeholder="Masukkan email Anda" value="<?= $email ?>" readonly>
            <small class="form-text text-muted">Email dapat diubah pada bagian data pegawai.</small>

            <input type="hidden" name="nip" value="<?= $nip ?>">
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="old_username" value="<?= $username ?>">


            <!-- Username -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" maxlength="50" placeholder="Masukkan username" value="<?= $username ?>">
            <?= form_error('username', '<div class="text-danger">', '</div>'); ?>

            <!-- Password -->
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" onkeyup="checkPasswordStrength()">
            </div>
            <?= form_error('password', '<div class="text-danger">', '</div>'); ?>

            <div id="password-validation" style="margin-left:1rem;">
                <ul>
                    <li id="length" class="invalid">Minimal 6 karakter</li>
                    <li id="uppercase" class="invalid">Minimal 1 huruf kapital</li>
                    <li id="lowercase" class="invalid">Minimal 1 huruf kecil</li>
                    <li id="number" class="invalid">Minimal 1 angka</li>
                    <li id="special" class="invalid">Minimal 1 karakter khusus (!, @, #, $, dll.)</li>

                </ul>
            </div>

            <!-- Status Akun -->
            <label for="status_akun">Status Akun:</label>
            <select id="status_akun" name="status_akun" required>
                <option value="1" <?= ($status_akun == '1') ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?= ($status_akun == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>

            <!-- Submit Button -->
            <button type="submit">Update Akun</button>
        </form>

    </div>

    <script>
        // Validasi password secara real-time
        // Validasi password secara real-time
        function checkPasswordStrength() {
            var password = document.getElementById('password').value;

            // Aturan validasi
            var length = document.getElementById('length');
            var uppercase = document.getElementById('uppercase');
            var lowercase = document.getElementById('lowercase');
            var number = document.getElementById('number');
            var special = document.getElementById('special');
            var submitButton = document.querySelector('button[type="submit"]'); // Tombol submit

            // Jika password kosong, lewati pemeriksaan
            if (password === '') {
                // Reset semua indikator ke "tidak valid"
                length.classList.remove('valid');
                length.classList.add('invalid');
                uppercase.classList.remove('valid');
                uppercase.classList.add('invalid');
                lowercase.classList.remove('valid');
                lowercase.classList.add('invalid');
                number.classList.remove('valid');
                number.classList.add('invalid');
                special.classList.remove('valid');
                special.classList.add('invalid');

                // Aktifkan tombol submit karena password dianggap tidak wajib
                submitButton.disabled = false;
                return;
            }

            // Validasi panjang
            if (password.length >= 6) {
                length.classList.remove('invalid');
                length.classList.add('valid');
            } else {
                length.classList.remove('valid');
                length.classList.add('invalid');
            }

            // Validasi huruf besar
            if (/[A-Z]/.test(password)) {
                uppercase.classList.remove('invalid');
                uppercase.classList.add('valid');
            } else {
                uppercase.classList.remove('valid');
                uppercase.classList.add('invalid');
            }

            // Validasi huruf kecil
            if (/[a-z]/.test(password)) {
                lowercase.classList.remove('invalid');
                lowercase.classList.add('valid');
            } else {
                lowercase.classList.remove('valid');
                lowercase.classList.add('invalid');
            }

            // Validasi angka
            if (/[0-9]/.test(password)) {
                number.classList.remove('invalid');
                number.classList.add('valid');
            } else {
                number.classList.remove('valid');
                number.classList.add('invalid');
            }

            // Validasi karakter khusus
            if (/[^A-Za-z0-9]/.test(password)) {
                special.classList.remove('invalid');
                special.classList.add('valid');
            } else {
                special.classList.remove('valid');
                special.classList.add('invalid');
            }

            // Memeriksa apakah semua validasi berhasil
            if (
                password.length >= 6 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[^A-Za-z0-9]/.test(password)
            ) {
                // Jika semua validasi terpenuhi, aktifkan tombol submit
                submitButton.disabled = false;
            } else {
                // Jika tidak memenuhi, nonaktifkan tombol submit
                submitButton.disabled = true;
            }
        }


        // Mencegah form submit jika password tidak valid
        document.querySelector('form').addEventListener('submit', function(event) {
            var submitButton = document.querySelector('button[type="submit"]');
            if (submitButton.disabled) {
                event.preventDefault(); // Mencegah pengiriman form
                alert("Password tidak memenuhi kriteria!");
            }
        });
    </script>

</body>

</html>