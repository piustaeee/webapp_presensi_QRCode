<style>
  .bodytabel {
    max-height: 400px;
    overflow-y: auto;
    display: block;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

  .add-form input,
  .add-form select {
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

  th,
  td {
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

<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <h1>Kelola Presensi Karyawan</h1>
        <div class="date" id="current-date"></div>
      </div>
    </div>

    <div class="search-form d-flex w-100">
      <div class="form-group col-4 mr-2">
        <input type="text" id="searchNip" class="form-control" placeholder="Cari Nama atau NIP Pegawai" oninput="filterData()">
      </div>
      <div class="form-group col-4 mr-2">
        <input type="text" id="searchJabatan" class="form-control" placeholder="Cari Berdasarkan  Jabatan" oninput="filterData()">
      </div>
      <div class="form-group col-3 mr-2">
        <select id="searchStatus" class="form-control" onchange="filterData()">
          <option value="">Semua Status</option>
          <option value="H">Hadir</option>
          <option value="I">Ijin</option>
          <option value="A">Alpa</option>
        </select>
      </div>
    </div>


    <table>
      <thead>
        <tr>
          <th>NIP</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="karyawanTable">
      </tbody>
    </table>
  </div>
  <script>
    // Fungsi filter data berdasarkan input pencarian
    function filterData() {
      const searchNip = document.getElementById('searchNip').value.toLowerCase();
      const searchJabatan = document.getElementById('searchJabatan').value.toLowerCase();
      const searchStatus = document.getElementById('searchStatus').value;

      // Ambil data karyawan yang sudah ada
      fetch('Admin/ManajemenPresensi/isAjax')
        .then(response => response.json())
        .then(data => {
          // Saring data sesuai dengan input pencarian
          const filteredData = data.filter(karyawan => {
            const nipMatch = karyawan.nip.toLowerCase().includes(searchNip) || karyawan.nama.toLowerCase().includes(searchNip);
            const jabatanMatch = karyawan.nama_jabatan.toLowerCase().includes(searchJabatan);
            const statusMatch = searchStatus ? karyawan.status_hadir === searchStatus : true;

            return nipMatch && jabatanMatch && statusMatch;
          });

          // Render tabel dengan data yang sudah disaring
          renderTable(filteredData);
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    // Fungsi untuk menampilkan tabel karyawan
    function renderTable(data) {
      const tableBody = document.getElementById('karyawanTable');
      tableBody.innerHTML = '';

      data.forEach(karyawan => {
        let statusClass = 'status-default';
        let statusLabel = 'Belum Presensi';

        // Periksa status yang dikirim dari server (status_hadir: H, I, A)
        if (karyawan.status_hadir === 'H') {
          statusClass = 'status-hadir'; // Hadir
          statusLabel = 'Hadir';
        } else if (karyawan.status_hadir === 'I') {
          statusClass = 'status-ijin'; // Ijin
          statusLabel = 'Ijin';
        } else if (karyawan.status_hadir === 'A') {
          statusClass = 'status-alpa'; // Alpa
          statusLabel = 'Alpa';
        }

        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${karyawan.nip}</td>
        <td>${karyawan.nama}</td>
        <td>${karyawan.nama_jabatan}</td>
        <td>
          <select class="status-select ${statusClass}" onchange="updateStatus('${karyawan.nip}', this.value)" data-nip="${karyawan.nip}">
            <option value="" ${karyawan.status_hadir === '' ? 'selected' : ''}>Belum Presensi</option>
            <option value="H" class="status-success" ${karyawan.status_hadir === 'H' ? 'selected' : ''}>Hadir</option>
            <option value="I" class="status-warning" ${karyawan.status_hadir === 'I' ? 'selected' : ''}>Ijin</option>
            <option value="A" class="status-danger" ${karyawan.status_hadir === 'A' ? 'selected' : ''}>Alpa</option>
          </select>
        </td>
      `;
        tableBody.appendChild(row);
      });
    }

    // Set current date
    function setCurrentDate() {
      const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      };
      const today = new Date().toLocaleDateString('id-ID', options);
      document.getElementById('current-date').textContent = today;
    }

    document.addEventListener('DOMContentLoaded', () => {
      fetchKaryawanData();
      setCurrentDate(); // Update the date on page load
    });

    function fetchKaryawanData() {
      fetch('Admin/ManajemenPresensi/isAjax')
        .then(response => response.json())
        .then(data => {
          renderTable(data);
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    // Fungsi untuk mengupdate status presensi
    function updateStatus(nip, newStatus) {
      fetch('Admin/ManajemenPresensi/updateStatusAjax', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            nip: nip,
            status_hadir: newStatus,
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: data.message || 'Status updated successfully!'
            });

            const statusSelect = document.querySelector(`select[data-nip="${nip}"]`);
            statusSelect.classList.remove('status-hadir', 'status-ijin', 'status-alpa', 'status-default');

            if (newStatus === 'H') {
              statusSelect.classList.add('status-hadir');
            } else if (newStatus === 'I') {
              statusSelect.classList.add('status-ijin');
            } else if (newStatus === 'A') {
              statusSelect.classList.add('status-alpa');
            } else {
              statusSelect.classList.add('status-default');
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.message || 'Failed to update status.'
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'There was an error updating the status.'
          });
        });
    }
  </script>









  <div class="container mt-5">
    <h2 class="text-center">Rekapitulasi Absensi Pegawai</h2>

    <!-- Filter Section -->
    <div class="row mt-4">
      <div class="col-md-3">
        <input type="text" id="searchNama" class="form-control" placeholder="Cari Nama atau NIP Pegawai">
      </div>
      <div class="col-md-2">
        <input type="text" id="searchJabatan2" class="form-control" placeholder="Cari Jabatan">
      </div>
      <div class="col-md-2">
        <select id="statusFilter" class="form-control">
          <option value="">Status Kehadiran</option>
          <option value="H">Hadir</option>
          <option value="I">Izin</option>
          <option value="A">Alpa</option>
        </select>
      </div>
      <div class="col-md-2">
        <input type="month" id="dateFilter" class="form-control">
      </div>
      <div class="col-md-3">
        <button class="btn btn-primary" onclick="applyFilters()">Terapkan Filter</button>
        <button class="btn btn-secondary" onclick="resetFilters()">Reset Filter</button>
      </div>
    </div>

    <!-- Table Section -->
    <div class="table-responsive mt-4">
      <table class="table table-bordered table-hover">
        <thead class="thead-dark">
          <tr class="text-center">
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Tanggal Presensi</th>
            <th>Jam Masuk</th>
            <th>Jam Awal Istirahat</th>
            <th>Jam Akhir Istirahat</th>
            <th>Jam Pulang</th>
            <th>Ket</th>
            <th>Telat</th>
            <th>Lembur</th>
          </tr>
        </thead>
        <tbody id="attendanceTable">
          <!-- Rows will be dynamically generated here -->
        </tbody>
      </table>
    </div>
    <button class="btn btn-success" onclick="cetakPresensi()">Cetak Presensi</button>
  </div>

  <script>
    function applyFilters() {
      const searchNama = document.getElementById('searchNama').value.toLowerCase();
      const searchJabatan = document.getElementById('searchJabatan2').value.toLowerCase();
      const statusFilter = document.getElementById('statusFilter').value;
      const dateFilter = document.getElementById('dateFilter').value;

      const rows = document.querySelectorAll('#attendanceTable tr');
      rows.forEach(row => {
        const nama = row.cells[1].textContent.toLowerCase();
        const nip = row.cells[2].textContent.toLowerCase();
        const jabatan = row.cells[3].textContent.toLowerCase();
        const tanggalPresensi = row.cells[4].textContent.toLowerCase();
        const statusKehadiran = row.cells[9].textContent.toLowerCase();

        let isMatch = true;

        // Filter logic
        if (searchNama && !nama.includes(searchNama) && !nip.includes(searchNama)) {
          isMatch = false;
        }
        if (searchJabatan && !jabatan.includes(searchJabatan)) {
          isMatch = false;
        }
        if (statusFilter && statusKehadiran !== statusFilter.toLowerCase()) {
          isMatch = false;
        }
        if (dateFilter && !tanggalPresensi.startsWith(dateFilter)) {
          isMatch = false;
        }

        // Show or hide the row based on filter
        row.style.display = isMatch ? '' : 'none';
      });
    }

    // Reset Filters
    function resetFilters() {
      document.getElementById('searchNama').value = '';
      document.getElementById('searchJabatan2').value = '';
      document.getElementById('statusFilter').value = '';
      document.getElementById('dateFilter').value = '';
      applyFilters(); // Reapply filter to reset view
    }

    // Fetch and Render Data
    function fetchAttendanceData() {
      fetch('Admin/ManajemenPresensi/isAjaxRekap')
        .then(response => response.json())
        .then(dataRekap => {
          renderAttendanceTable(dataRekap);
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    function renderAttendanceTable(dataRekap) {
      const tableBody = document.getElementById('attendanceTable');
      tableBody.innerHTML = '';

      function formatTime(time) {
        if (!time || time === '-') return '-';
        const [hours, minutes] = time.split(':');
        return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
      }

      dataRekap.forEach((attendance, index) => {
        const row = document.createElement('tr');
        row.classList.add('text-center');

        row.innerHTML = `
      <td>${index + 1}</td>
      <td>${attendance.nama || '-'}</td>
      <td>${attendance.nip || '-'}</td>
      <td>${attendance.nama_jabatan || '-'}</td>
      <td>${attendance.tanggal_presensi || '-'}</td>
      <td>${formatTime(attendance.jam_masuk)}</td>
      <td>${formatTime(attendance.jam_mulai_istirahat)}</td>
      <td>${formatTime(attendance.jam_akhir_istirahat)}</td>
      <td>${formatTime(attendance.jam_pulang)}</td>
      <td>${attendance.status_hadir || '-'}</td>
      <td>${attendance.status_telat === '1' ? 'Ya' : (attendance.status_telat === '0' ? 'Tidak' : '-')}</td>
      <td>${attendance.status_lembur === '1' ? 'Ya' : (attendance.status_lembur === '0' ? 'Tidak' : '-')}</td>
    `;

        tableBody.appendChild(row);
      });
    }

    document.addEventListener('DOMContentLoaded', fetchAttendanceData);
  </script>

  <script>
    function cetakPresensi() {
      // Ambil elemen tabel
      const table = document.querySelector('.table-responsive').innerHTML;

      // Buat jendela cetak baru
      const printWindow = window.open('', '', 'width=800,height=600');
      printWindow.document.write(`
      <html>
        <head>
          <title>Cetak Presensi</title>
          <style>
            body {
              font-family: Arial, sans-serif;
              margin: 20px;
            }
            table {
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 20px;
            }
            th, td {
              border: 1px solid #ddd;
              text-align: center;
              padding: 8px;
            }
            th {
              background-color: #f4f4f4;
            }
          </style>
        </head>
        <body>
          <h2 class="text-center">Rekapitulasi Absensi Pegawai</h2>
          ${table}
        </body>
      </html>
    `);

      // Cetak isi jendela
      printWindow.document.close();
      printWindow.print();
    }
  </script>