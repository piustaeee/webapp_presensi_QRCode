<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .account-settings {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .account-settings h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="account-settings">
        <h1>Pengaturan Akun Pegawai</h1>
        <form id="settingsForm">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" placeholder="Nama Lengkap" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="phone">Nomor Telepon:</label>
            <input type="tel" id="phone" name="phone" placeholder="Nomor Telepon" required>

            <label for="password">Kata Sandi Baru:</label>
            <input type="password" id="password" name="password" placeholder="Kata Sandi Baru" required>

            <button type="button" onclick="updateAccount()">Simpan Perubahan</button>
        </form>
    </div>
    <script>
        function updateAccount() {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const password = document.getElementById("password").value;

            if (name && email && phone && password) {
                alert("Perubahan akun berhasil disimpan!");
            } else {
                alert("Harap lengkapi semua bidang.");
            }
        }
    </script>
</body>

</html>