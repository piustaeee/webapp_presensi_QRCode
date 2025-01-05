<style>
    body {
        line-height: 1.6;
        color: var(--text-color);
        background-color: var(--background-color);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1,
    h2,
    h3 {
        color: var(--third-color);
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: var(--card-background);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card h3 {
        margin-top: 0;
        font-size: 1.2em;
        color: var(--third-color);
    }

    .stat-card p {
        font-size: 2em;
        font-weight: bold;
        margin: 10px 0;
        color: var(--third-color);
    }

    .stat-card span {
        color: var(--secondary-color);
    }

    .chart-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card {
        flex: 1 1 calc(50% - 10px);
        min-width: 300px;
        background-color: var(--card-background);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .chart-card h2 {
        color: var(--third-color);
    }

    .attendance-list,
    .hr-info-card {
        background-color: var(--card-background);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .attendance-list h2,
    .hr-info-card h2 {
        color: var(--third-color);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    th {
        background-color: #2c3e50;
        color: var(--background-color);
    }

    .progress-bar {
        width: 100%;
        background-color: var(--border-color);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress {
        height: 10px;
        background-color: var(--green-color);
        width: 0;
        transition: width 0.5s ease-in-out;
    }

    #workCalendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--card-background);
        border-radius: 4px;
        font-size: 0.9em;
        color: var(--text-color);
    }

    .calendar-day.today {
        background-color: var(--third-color);
        color: var(--background-color);
    }

    .calendar-day:not(.current-month) {
        opacity: 0.5;
    }

    .employee-performance {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        background-color: var(--third-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--background-color);
        font-weight: bold;
    }

    .employee-info {
        flex-grow: 1;
    }

    .employee-name {
        font-weight: bold;
        color: var(--third-color);
    }

    .employee-role {
        font-size: 0.9em;
        color: var(--secondary-color);
    }

    .performance-score {
        font-weight: bold;
        color: var(--third-color);
    }

    .tabs {
        display: flex;
        margin-bottom: 20px;
    }

    .tab {
        padding: 10px 20px;
        background-color: var(--card-background);
        border: none;
        transition: background-color 0.3s ease;
        color: var(--text-color);
    }

    .tab.active {
        background-color: var(--third-color);
        color: var(--background-color);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    @media (max-width: 768px) {
        .chart-card {
            flex: 1 1 100%;
        }
    }
</style>

<div class="container">
    <header class="dashboard-header">
        <h1>Dashboard Presensi dan Informasi HR</h1>
    </header>

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total Pegawai</h3>
            <p><?= isset($sumPegawai) ? $sumPegawai : 'Data tidak tersedia'; ?></p>
            <span>Orang</span>
        </div>
        <div class="stat-card">
            <h3>Hadir Hari Ini</h3>
            <p><?= isset($dataHadir) && $dataHadir > 0 ? $dataHadir : '0'; ?></p>
            <span>Orang</span>
        </div>
        <div class="stat-card">
            <h3>Izin Hari Ini</h3>
            <p><?= isset($dataIzin) && $dataIzin > 0 ? $dataIzin : '0'; ?></p>
            <span>Orang</span>
        </div>
        <div class="stat-card">
            <h3>Alpa Hari Ini</h3>
            <p><?= isset($dataAlpa) && $dataAlpa > 0 ? $dataAlpa : '0'; ?></p>
            <span>Orang</span>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart-card">
            <h2>Grafik Kehadiran Pegawai</h2>
            <canvas id="attendanceChart"></canvas>
        </div>
        <div class="chart-card">
            <h2>Kalender Kerja</h2>
            <div id="workCalendar"></div>
        </div>
    </div>

    <div id="attendanceTab" class="tab-content active">
        <div class="attendance-list">
            <h2>Daftar Presensi Tepat Waktu</h2>
            <table>
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Jumlah Tepat Waktu</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody id="attendanceTableBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    fetch('Admin/Dashboard/isAjax')
        .then(response => response.json())
        .then(attendanceData => {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Kehadiran',
                        data: attendanceData,
                        backgroundColor: '#4e759c',
                        borderColor: 'rgba(0, 0, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#333333'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#333333'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#333333'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching attendance data:', error));


    // Work Calendar
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

    // Attendance List
    const attendanceData = <?= json_encode($dataPresensiCurrentMonth); ?>;
    const hariKerja = <?= isset($hariKerja) ? $hariKerja : 0; ?>; // Default to 0 if hariKerja is null or not set

    const tableBody = document.getElementById('attendanceTableBody');
    attendanceData.forEach((employee, index) => {
        const row = tableBody.insertRow();
        row.insertCell(0).textContent = index + 1;
        row.insertCell(1).textContent = employee.nama;
        row.insertCell(2).textContent = employee.total_presensi;

        const percentageCell = row.insertCell(3);
        const percentage = hariKerja > 0 ? (employee.total_presensi / hariKerja) * 100 : 0; // Handle division by zero
        const progressBar = document.createElement('div');
        progressBar.className = 'progress-bar';
        const progress = document.createElement('div');
        progress.className = 'progress';
        progress.style.width = `${percentage}%`;
        progressBar.appendChild(progress);
        percentageCell.appendChild(progressBar);
    });

    // Tab Functionality
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab');

            tabs.forEach(t => t.classList.remove('active'));

            tabContents.forEach(content => content.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(`${tabId}Tab`).classList.add('active');
        });
    });

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