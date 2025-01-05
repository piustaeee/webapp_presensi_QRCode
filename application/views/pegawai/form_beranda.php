    <style>
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }

        .progress {
            height: 10px;
        }

        .status-badge {
            font-size: 0.75rem;
        }

        #workCalendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            padding: 10px;
            background-color: #f3f4f6;
            /* Warna latar untuk kontras */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Setiap hari di kalender */
        .calendar-day {
            aspect-ratio: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 8px;
            font-size: 0.9em;
            transition: transform 0.3s, background-color 0.3s;
            cursor: pointer;
            color: #333333;
        }

        /* Hari ini */
        .calendar-day.today {
            background-color: #007bff;
            /* Warna utama */
            color: #ffffff;
            font-weight: bold;
        }

        /* Hari di luar bulan saat ini */
        .calendar-day:not(.current-month) {
            color: black;
            opacity: 0.7;
        }

        /* Efek hover pada hari */
        .calendar-day:hover {
            background-color: #f0f8ff;
            transform: scale(1.05);
        }

        /* Header kalender */
        .chart-card h2 {
            text-align: center;
            color: #333;
            margin-bottom: 16px;
            font-size: 1.5em;
            font-weight: bold;
        }

        .badge-infos {
            background-color: #e0e0e0;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            color: #fff;
            background-color: #ccc;
            font-size: 14px;
            margin-top: 10px;
        }

        .checkmark.checked {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>

    <body>

        <header class="">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center">
                        <div>
                            <h1 class="h4 mb-0">Selamat datang, <?= $this->session->userdata('nama')  ?></h1>
                            <p class="text-muted mb-0">Pegawai NIP: <?= $this->session->userdata('nip')  ?></p>
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
                            <h5 class="card-title">Jadwal Presensi Harian</h5>
                            <p class="card-text text-muted">Lakukan check-in dan check-out di sini</p>
                            <div class="d-flex justify-content-between">
                                <div class="text-center d-flex flex-column align-items-center">
                                    <p>Presensi <br> Masuk</p>
                                    <span class="badge badge-infos">Jam: <?= $jadwalmasuk ?></span>
                                    <div class="checkmark <?= $cekjadwalmasuk ?>">✓</div>
                                </div>
                                <div class="text-center d-flex flex-column align-items-center">
                                    <p>Presensi Awal Istirahat</p>
                                    <span class="badge badge-infos">Jam: <?= $jadwalistirahatawal ?></span>
                                    <div class="checkmark <?= $cekjadwalistirahatawal ?>">✓</div>
                                </div>
                                <div class="text-center d-flex flex-column align-items-center">
                                    <p>Presensi Akhir Istirahat</p>
                                    <span class="badge badge-infos">Jam: <?= $jadwalistirahatakhir ?></span>
                                    <div class="checkmark <?= $cekjadwalistirahatakhir ?>">✓</div>
                                </div>
                                <div class="text-center d-flex flex-column align-items-center">
                                    <p>Presensi <br> Pulang</p>
                                    <span class="badge badge-infos">Jam: <?= $jadwalpulang ?></span>
                                    <div class="checkmark <?= $cekjadwalpulang ?>">✓</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Presensi Bulan Ini</h5>
                            <?php
                            $persentaseHadir = ($dataHadir / $hariKerja) * 100;
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

            <div class="chart-container mb-5">
                <div class="chart-card">
                    <h2>Kalender Kerja</h2>
                    <div id="workCalendar"></div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Presensi Terakhir</h5>
                    <p class="card-text text-muted">Catatan presensi terakhir Anda</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Presensi</th>
                                    <th>Presensi Masuk</th>
                                    <th>Presensi Awal Istirahat</th>
                                    <th>Presensi Akhir Istirahat</th>
                                    <th>Presensi Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPresensi as $data): ?>
                                    <tr>
                                        <td><?= (!empty($data['tanggal_presensi'])) ? date('d-m-Y', strtotime($data['tanggal_presensi'])) : '-' ?></td>
                                        <td><?= (!empty($data['jam_masuk'])) ? date('H:i', strtotime($data['jam_masuk'])) : '-' ?></td>
                                        <td><?= (!empty($data['jam_mulai_istirahat'])) ? date('H:i', strtotime($data['jam_mulai_istirahat'])) : '-' ?></td>
                                        <td><?= (!empty($data['jam_akhir_istirahat'])) ? date('H:i', strtotime($data['jam_akhir_istirahat'])) : '-' ?></td>
                                        <td><?= (!empty($data['jam_pulang'])) ? date('H:i', strtotime($data['jam_pulang'])) : '-' ?></td>
                                        <td>
                                            <span class="badge <?php echo ($data['status_hadir'] == 'H') ? 'badge-success' : (($data['status_hadir'] == 'I') ? 'badge-warning' : 'badge-danger'); ?>">
                                                <?= $data['status_hadir'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const presensiBtn = document.getElementById('presensiBtn');
                const presensiStatus = document.getElementById('presensiStatus');
                let isCheckedIn = false;

                presensiBtn.addEventListener('click', function() {
                    isCheckedIn = !isCheckedIn;
                    if (isCheckedIn) {
                        presensiBtn.classList.remove('btn-success');
                        presensiBtn.classList.add('btn-danger');
                        presensiBtn.innerHTML = '<i class="fas fa-times-circle mr-2"></i> Check Out';
                        presensiStatus.textContent = 'Anda sudah melakukan check-in hari ini';
                    } else {
                        presensiBtn.classList.remove('btn-danger');
                        presensiBtn.classList.add('btn-success');
                        presensiBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Check In';
                        presensiStatus.textContent = 'Anda belum melakukan check-in hari ini';
                    }
                });
            });


            function generateCalendar(year, month) {
                const calendarContainer = document.getElementById("workCalendar");
                calendarContainer.innerHTML = "";

                const today = new Date();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startingDay = firstDay.getDay();

                // Add day labels
                const dayLabels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                dayLabels.forEach(day => {
                    const dayLabel = document.createElement('div');
                    dayLabel.className = 'calendar-day';
                    dayLabel.textContent = day;
                    calendarContainer.appendChild(dayLabel);
                });

                // Add empty cells for days before the first of the month
                for (let i = 0; i < startingDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day';
                    calendarContainer.appendChild(emptyDay);
                }

                // Add days of the month
                for (let i = 1; i <= daysInMonth; i++) {
                    const day = document.createElement('div');
                    day.className = 'calendar-day';
                    if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        day.classList.add('today');
                    }
                    day.textContent = i;
                    calendarContainer.appendChild(day);
                }
            }

            // Generate calendar for current month
            const currentDate = new Date();
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            <?php if ($this->session->flashdata('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '<?= $this->session->flashdata('success') ?>'
                });
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= $this->session->flashdata('error') ?>'
                });
            <?php endif; ?>

            <?php if ($this->session->flashdata('info')): ?>
                Swal.fire({
                    icon: 'info',
                    // title: 'Sukses!',
                    text: '<?= $this->session->flashdata('info') ?>'
                });
            <?php endif; ?>
        </script>


    </body>

    </html>