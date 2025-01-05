<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kelola Presensi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .title h1 {
            color: #333;
            font-size: 24px;
        }

        .date {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .save-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .save-btn:hover {
            background: #45a049;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-box {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .add-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .add-form input, .add-form select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .add-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-btn:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .status-select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .status-hadir {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-ijin {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .status-alpa {
            background-color: #ffebee;
            color: #c62828;
        }

        .keterangan-input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .add-form {
                grid-template-columns: 1fr;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">
                <h1>Kelola Presensi Karyawan</h1>
                <div class="date" id="current-date"></div>
            </div>
            <button class="save-btn" onclick="savePresensi()">
                💾 Simpan Presensi
            </button>
        </div>

        <div class="search-container">
            <input type="text" class="search-box" id="searchInput" placeholder="Cari berdasarkan NIP atau Nama..." oninput="searchKaryawan()">
        </div>

        <div class="add-form">
            <input type="text" id="newNip" placeholder="NIP">
            <input type="text" id="newNama" placeholder="Nama Karyawan">
            <input type="text" id="newJabatan" placeholder="Jabatan">
            <select id="newStatus">
                <option value="hadir">Hadir</option>
                <option value="ijin">Ijin</option>
                <option value="alpa">Alpa</option>
            </select>
            <button class="add-btn" onclick="addKaryawan()">➕ Tambah Karyawan</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="karyawanTable">
                <!-- Data will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        // Initial data
        let karyawanData = [
            { id: 1, nip: "001", nama: "Ahmad Fadillah", jabatan: "Staff IT", status: "hadir", keterangan: "" },
            { id: 2, nip: "002", nama: "Siti Aminah", jabatan: "Staff Finance", status: "ijin", keterangan: "Sakit" },
            { id: 3, nip: "003", nama: "Budi Santoso", jabatan: "Staff HR", status: "alpa", keterangan: "Tidak ada keterangan" },
            { id: 4, nip: "004", nama: "Dewi Putri", jabatan: "Staff Marketing", status: "hadir", keterangan: "" }
        ];

        // Set current date
        function setCurrentDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date().toLocaleDateString('id-ID', options);
            document.getElementById('current-date').textContent = today;
        }

        // Render table
        function renderTable(data = karyawanData) {
            const tableBody = document.getElementById('karyawanTable');
            tableBody.innerHTML = '';

            data.forEach(karyawan => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${karyawan.nip}</td>
                    <td>${karyawan.nama}</td>
                    <td>${karyawan.jabatan}</td>
                    <td>
                        <select class="status-select status-${karyawan.status}" onchange="updateStatus(${karyawan.id}, this.value)">
                            <option value="hadir" ${karyawan.status === 'hadir' ? 'selected' : ''}>Hadir</option>
                            <option value="ijin" ${karyawan.status === 'ijin' ? 'selected' : ''}>Ijin</option>
                            <option value="alpa" ${karyawan.status === 'alpa' ? 'selected' : ''}>Alpa</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="keterangan-input" value="${karyawan.keterangan}"
                            onchange="updateKeterangan(${karyawan.id}, this.value)">
                    </td>
                    <td>
                        <button class="delete-btn" onclick="deleteKaryawan(${karyawan.id})">🗑️</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Add new karyawan
        function addKaryawan() {
            const nip = document.getElementById('newNip').value;
            const nama = document.getElementById('newNama').value;
            const jabatan = document.getElementById('newJabatan').value;
            const status = document.getElementById('newStatus').value;

            if (nip && nama && jabatan) {
                const newKaryawan = {
                    id: karyawanData.length + 1,
                    nip,
                    nama,
                    jabatan,
                    status,
                    keterangan: ""
                };

                karyawanData.push(newKaryawan);
                renderTable();

                // Clear form
                document.getElementById('newNip').value = '';
                document.getElementById('newNama').value = '';
                document.getElementById('newJabatan').value = '';
                document.getElementById('newStatus').value = 'hadir';
            } else {
                alert('Mohon isi semua data karyawan!');
            }
        }

        // Update status
        function updateStatus(id, newStatus) {
            const karyawan = karyawanData.find(k => k.id === id);
            if (karyawan) {
                karyawan.status = newStatus;
                renderTable();
            }
        }

        // Update keterangan
        function updateKeterangan(id, newKeterangan) {
            const karyawan = karyawanData.find(k => k.id === id);
            if (karyawan) {
                karyawan.keterangan = newKeterangan;
            }
        }

        // Delete karyawan
        function deleteKaryawan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')) {
                karyawanData = karyawanData.filter(k => k.id !== id);
                renderTable();
            }
        }

        // Search function
        function searchKaryawan() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filteredData = karyawanData.filter(k =>
                k.nama.toLowerCase().includes(searchTerm) ||
                k.nip.toLowerCase().includes(searchTerm)
            );
            renderTable(filteredData);
        }

        // Save presensi
        function savePresensi() {
            // Here you would typically send the data to a server
            alert('Data presensi berhasil disimpan!');
            console.log('Saved data:', karyawanData);
        }

        // Initialize
        setCurrentDate();
        renderTable();
    </script>
</body>
</html>