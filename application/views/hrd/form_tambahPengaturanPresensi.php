<style>
    /* Remove blue background from today's date */
    .ui-state-highlight {
        background-color: transparent !important;
        color: inherit !important;
    }

    /* Change the selected date color */
    .ui-state-active {
        background-color: #ededea !important;
    }
</style>
<script>
    $(function() {
        let selectedDates = [];

        // Restore previously selected dates if available
        const existingDates = $('#tanggal_libur').val();
        if (existingDates) {
            selectedDates = existingDates.split(', ');
        }

        $(document).ready(function() {
            const currentDate = new Date();

            $("#calendar").datepicker({
                numberOfMonths: [1, 1],
                defaultViewDate: {
                    year: currentDate.getFullYear(),
                    month: currentDate.getMonth()
                }, // Set the default view date to the current month
                onSelect: function(dateText) {
                    if (selectedDates.includes(dateText)) {
                        // Remove date if it's already selected
                        selectedDates = selectedDates.filter(date => date !== dateText);
                    } else {
                        // Add new selected date
                        selectedDates.push(dateText);
                    }
                    $("#tanggal_libur").val(selectedDates.join(", "));
                },
                beforeShowDay: function(date) {
                    // Highlight already selected dates
                    const dateString = $.datepicker.formatDate('mm/dd/yy', date);
                    const isSelected = selectedDates.includes(dateString);
                    return [true, isSelected ? "highlighted" : ""];
                }
            });
        });


        // Add CSS for highlighted dates
        $("<style type='text/css'> .highlighted a { background-color: #83FF87 !important; color: white !important; border-radius: 10%; } </style>").appendTo("head");
    });
</script>
<div class="container w-100">
    <h1>Pengaturan Jadwal presensi</h1>
    <form id="attendanceSettingsForm" action="<?= base_url('Admin/PengaturanPresensi/addPresensi') ?>" method="POST">
        <div class="form-group">
            <label for="bulan_presensi">Bulan:</label>
            <select id="bulan_presensi" name="bulan_presensi">
                <option value="1" <?= set_select('bulan_presensi', '1') ?>>Januari</option>
                <option value="2" <?= set_select('bulan_presensi', '2') ?>>Februari</option>
                <option value="3" <?= set_select('bulan_presensi', '3') ?>>Maret</option>
                <option value="4" <?= set_select('bulan_presensi', '4') ?>>April</option>
                <option value="5" <?= set_select('bulan_presensi', '5') ?>>Mei</option>
                <option value="6" <?= set_select('bulan_presensi', '6') ?>>Juni</option>
                <option value="7" <?= set_select('bulan_presensi', '7') ?>>Juli</option>
                <option value="8" <?= set_select('bulan_presensi', '8') ?>>Agustus</option>
                <option value="9" <?= set_select('bulan_presensi', '9') ?>>September</option>
                <option value="10" <?= set_select('bulan_presensi', '10') ?>>Oktober</option>
                <option value="11" <?= set_select('bulan_presensi', '11') ?>>November</option>
                <option value="12" <?= set_select('bulan_presensi', '12') ?>>Desember</option>
            </select>
            <?= form_error('bulan_presensi', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="tahun_presensi">Tahun:</label>
            <input type="number" id="tahun_presensi" name="tahun_presensi" min="2023" max="2100" value="<?= set_value('tahun_presensi') ?>">
            <?= form_error('tahun_presensi', '<div class="text-danger">', '</div>'); ?>

        </div>



        <div class="form-group">
            <label>Hari Kerja:</label>
            <div class="days-container">
                <input type="checkbox" id="senin" name="hari_kerja[]" value="Senin" class="day-checkbox">
                <label for="senin" class="day-label">Senin</label>

                <input type="checkbox" id="selasa" name="hari_kerja[]" value="Selasa" class="day-checkbox">
                <label for="selasa" class="day-label">Selasa</label>

                <input type="checkbox" id="rabu" name="hari_kerja[]" value="Rabu" class="day-checkbox">
                <label for="rabu" class="day-label">Rabu</label>

                <input type="checkbox" id="kamis" name="hari_kerja[]" value="Kamis" class="day-checkbox">
                <label for="kamis" class="day-label">Kamis</label>
                <input type="checkbox" id="jumat" name="hari_kerja[]" value="Jumat" class="day-checkbox">
                <label for="jumat" class="day-label">Jumat</label>

                <input type="checkbox" id="sabtu" name="hari_kerja[]" value="Sabtu" class="day-checkbox">
                <label for="sabtu" class="day-label">Sabtu</label>

                <input type="checkbox" id="minggu" name="hari_kerja[]" value="Minggu" class="day-checkbox">
                <label for="minggu" class="day-label">Minggu</label>
            </div>
            <?= form_error('hari_kerja[]', '<div class="text-danger">', '</div>'); ?>
        </div>



        <div class="form-group">
            <label for="jam_masuk">Absensi Jam Masuk:</label>
            <input type="time" id="jam_masuk" name="jam_masuk" value="<?= set_value('jam_masuk') ?>">
            <?= form_error('jam_masuk', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="jam_pulang">Absensi Jam Pulang:</label>
            <input type="time" id="jam_pulang" name="jam_pulang" value="<?= set_value('jam_pulang') ?>">
            <?= form_error('jam_pulang', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="durasi_telat">Durasi Keterlambatan (Menit):</label>
            <input type="number" id="durasi_telat" name="durasi_telat" min="0" value="<?= set_value('durasi_telat') ?>">
            <?= form_error('durasi_telat', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="jam_mulai_istirahat">Waktu Istirahat:</label>
            <input type="time" id="jam_mulai_istirahat" name="jam_mulai_istirahat" value="<?= set_value('jam_mulai_istirahat') ?>">
            <?= form_error('jam_mulai_istirahat', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="jam_akhir_istirahat">Waktu Istirahat Berakhir:</label>
            <input type="time" id="jam_akhir_istirahat" name="jam_akhir_istirahat" value="<?= set_value('jam_akhir_istirahat') ?>">
            <?= form_error('jam_akhir_istirahat', '<div class="text-danger">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label for="tanggal_libur">Tanggal Libur:</label>
            <div id="calendar"></div>
            <input type="hidden" id="tanggal_libur" name="tanggal_libur" value="<?= set_value('tanggal_libur') ?>">
            <?= form_error('tanggal_libur', '<div class="text-danger">', '</div>'); ?>
        </div>

        <div class="form-group">
            <label for="kd_jabatan">Jabatan:</label>
            <select id="kd_jabatan" name="kd_jabatan">
                <?php foreach ($jabatan as $row) : ?>
                    <option value="<?= $row['kd_jabatan'] ?>" <?= set_select('kd_jabatan', $row['kd_jabatan']) ?>>
                        <?= $row['nama_jabatan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= form_error('kd_jabatan', '<div class="text-danger">', '</div>'); ?>

        </div>
        <div class="form-group">
            <label for="status_presensi">Status Absensi:</label>
            <select id="status_presensi" name="status_presensi">
                <option value="1" <?= set_select('status_presensi', 'active') ?>>Aktif</option>
                <option value="0" <?= set_select('status_presensi', 'inactive') ?>>Tidak Aktif</option>
            </select>
            <?= form_error('status_presensi', '<div class="text-danger">', '</div>'); ?>
            <p class="text-warning">NB: Status Tidak Aktif akan disimpan sebagai Draft </p>

        </div>

        <div class="button-group justify-content-end">
            <button type="submit">Simpan</button>
        </div>

    </form>
</div>


<script>
    <?php if ($this->session->flashdata('erroradd')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<?= $this->session->flashdata('erroradd') ?>',
        });
    <?php endif; ?>







    // $(function() {
    //     var selectedDates = [];

    //     $("#calendar").datepicker({
    //         numberOfMonths: [1, 1],
    //         onSelect: function(dateText) {
    //             if (selectedDates.includes(dateText)) {
    //                 selectedDates = selectedDates.filter(date => date !== dateText);
    //             } else {
    //                 selectedDates.push(dateText);
    //             }
    //             $("#tanggal_libur").val(selectedDates.join(", "));

    //             $(this).find(".ui-datepicker-current-day a").toggleClass("highlighted");
    //         },
    //         beforeShowDay: function(date) {
    //             var dateString = $.datepicker.formatDate('mm/dd/yy', date);
    //             return [true, selectedDates.includes(dateString) ? "highlighted" : ""];
    //         }
    //     });

    //     // Add CSS rule dynamically for highlighted class
    //     $("<style type='text/css'> .highlighted a { background-color: #ffeb3b !important; } </style>").appendTo("head");
    // });
</script>