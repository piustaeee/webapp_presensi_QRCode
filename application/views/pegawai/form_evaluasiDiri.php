    <style>
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }

        .progress {
            height: 10px;
        }
    </style>

    <body class="bg-light">
        <header class="">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center">
                        <div>
                            <h1 class="h4 mb-0">Presensi: <?= $this->session->userdata('nama')  ?></h1>
                            <p class="text-muted mb-0">NIP: <?= $this->session->userdata('nip') ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="container py-5">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ringkasan Presensi Tahun Ini</h5>
                            <canvas id="presensiTahunan"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Presensi Bulan Ini (Juni 2023)</h5>
                            <?php
                            $persentaseHadir = ($dataHadir / $hariKerja) * 100; // Hitung persentase kehadiran
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Total Hari Kerja: <?php echo $hariKerja ?></span>
                                <span class="font-weight-bold">Kehadiran: <?php echo $dataHadir ?>/<?php echo $hariKerja ?></span>
                            </div>
                            <div class="progress mb-3">
                                <div
                                    class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: <?php echo $persentaseHadir; ?>%;"
                                    aria-valuenow="<?php echo $persentaseHadir; ?>"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    <?php echo round($persentaseHadir, 1); ?>%
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Hadir Tepat Waktu
                                    <span class="badge badge-primary badge-pill"><?= $dataTepatWaktu ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Terlambat
                                    <span class="badge badge-warning badge-pill"><?= $dataTerlambat ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Izin
                                    <span class="badge badge-info badge-pill"><?= $dataIzin  ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Tanpa Keterangan
                                    <span class="badge badge-danger badge-pill"><?= $dataAlpa ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Detail Presensi</h5>
                    <div class="filter-section">
                        <label for="year-select">Pilih Tahun:</label>
                        <select id="year-select" class="form-control">
                            <?php
                            $startYear = 2000;
                            $endYear = date('Y');

                            $currentYear = date('Y');
                            for ($year = $startYear; $year <= $endYear; $year++) {
                                $selected = ($year == $currentYear) ? 'selected' : '';
                                echo "<option value=\"$year\" $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-section">
                        <label for="month-select">Pilih Bulan:</label>
                        <select id="month-select" class="form-control">
                            <?php
                            $currentMonth = date('m');
                            $months = [
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ];

                            foreach ($months as $month => $monthName) {
                                $selected = ($month == $currentMonth) ? 'selected' : '';
                                echo "<option value=\"$month\" $selected>$monthName</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <br>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Awal Istirahat</th>
                                    <th>Jam Akhir Istirahat</th>
                                    <th>Jam Pulang</th>
                                    <th>Keterangan</th>
                                    <th>Status Telat</th>
                                    <th>Status Lembur</th>
                                </tr>
                            </thead>
                            <tbody id="presensi-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <button onclick="printPresensi()">Cetak Presensi</button>
            </div>


        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const grafikPresensi = <?php echo json_encode($grafikPresensi); ?>;
                const jumlahPresensi = Array(12).fill(0);
                grafikPresensi.forEach(item => {
                    const bulan = parseInt(item.bulan) - 1; // Konversi bulan ke indeks (0 untuk Jan, 11 untuk Des)
                    jumlahPresensi[bulan] = parseInt(item.jumlah_presensi); // Simpan jumlah presensi pada bulan tersebut
                });
                const ctx = document.getElementById('presensiTahunan').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'], // Label bulan
                        datasets: [{
                            label: 'Jumlah Presensi',
                            data: jumlahPresensi,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

            });
        </script>




        <script>
            $(document).ready(function() {
                function loadPresensiData(year, month) {
                    $.ajax({
                        url: '<?= base_url("EvaluasiDiri/isAjax") ?>',
                        type: 'GET',
                        data: {
                            year: year,
                            month: month
                        },
                        dataType: 'json',
                        success: function(response) {
                            let tableBody = $('#presensi-table-body');
                            tableBody.empty();

                            if (response.length > 0) {
                                response.forEach(item => {
                                    let row = `
                            <tr style="text-align: center;">
                                <td>${item.tanggal_presensi}</td>
                                <td>${item.jam_masuk ? item.jam_masuk : '-'}</td>
                                <td>${item.jam_mulai_istirahat ? item.jam_mulai_istirahat : '-'}</td>
                                <td>${item.jam_akhir_istirahat ? item.jam_akhir_istirahat : '-'}</td>
                                <td>${item.jam_pulang ? item.jam_pulang : '-'}</td>
                                <td>
                                 <span class="badge ${item.status_hadir === 'H' ? 'badge-success' : (item.status_hadir === 'I' ? 'badge-warning' : (item.status_hadir === 'A' ? 'badge-danger' : ''))}">
                                         ${item.status_hadir === 'H' ? 'Hadir' : (item.status_hadir === 'I' ? 'Izin' : (item.status_hadir === 'A' ? 'Alpa' : ''))}
                                 </span>
                                </td>
                                <td>${item.status_telat == 1 ? 'Iya' : 'Tidak'}</td>
                                <td>${item.status_lembur == 1 ? 'Iya' : 'Tidak'}</td>
                            </tr>`;
                                    tableBody.append(row);
                                });
                            } else {
                                tableBody.append('<tr><td colspan="8" class="text-center">Tidak ada data presensi.</td></tr>');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data.');
                        }
                    });
                }

                // Event listener untuk dropdown
                $('#year-select, #month-select').on('change', function() {
                    let year = $('#year-select').val();
                    let month = $('#month-select').val();
                    loadPresensiData(year, month);
                });

                // Muat data awal
                loadPresensiData($('#year-select').val(), $('#month-select').val());
            });
        </script>

        <script>
            function formatDate(dateString) {
                let date = new Date(dateString);
                let day = String(date.getDate()).padStart(2, '0'); // Dapatkan hari dengan format dua digit
                let month = String(date.getMonth() + 1).padStart(2, '0'); // Dapatkan bulan dengan format dua digit (bulan dimulai dari 0)
                let year = date.getFullYear().toString(); // Ambil dua digit terakhir tahun
                return `${day}-${month}-${year}`; // Format menjadi dd-mm-yy
            }

            function printPresensi() {
                let content = `
        <html>
            <head>
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
                        padding: 12px 15px;
                        text-align: left;
                        border: 1px solid #ddd;
                        font-size: 14px;
                    }}
                </style>
            </head>
            <body>
                <h3>Presensi Pegawai</h3>
                <p>Nama Pegawai: <?= $this->session->userdata('nama') ?></p>
                <p>NIP: <?= $this->session->userdata('nip') ?></p>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari/Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Awal Istirahat</th>
                            <th>Jam Akhir Istirahat</th>
                            <th>Jam Pulang</th>
                            <th>Ket</th>
                            <th>Status Telat</th>
                            <th>Status Lembur</th>
                        </tr>
                    </thead>
                    <tbody>
    `;

                let no = 1; // Inisialisasi nomor urut

                $('#presensi-table-body tr').each(function() {
                    let row = $(this).html(); // Ambil isi baris
                    // Ambil dan format tanggal (asumsikan tanggal ada di kolom pertama)
                    let dateCell = $(this).find('td').eq(0).text(); // Ambil tanggal dari kolom pertama
                    let formattedDate = formatDate(dateCell); // Format tanggal
                    row = row.replace(dateCell, formattedDate); // Gantikan tanggal yang ada dengan format baru

                    // Tambahkan nomor urut pada kolom pertama
                    content += `<tr><td>${no}</td>${row}</tr>`;
                    no++; // Increment nomor urut
                });

                content += `
            </tbody>
        </table>
    </body>
</html>
        `;

                let newWindow = window.open('', '_blank', 'width=1000, height=600');
                newWindow.document.write(content);
                newWindow.document.close();
                newWindow.print();
            }
        </script>
    </body>

    </html>