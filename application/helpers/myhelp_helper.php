<?php
if (!function_exists('convertHariToEnglish')) {
    function convertHariToEnglish($hari)
    {
        $hariIndoToEng = [
            'Senin'    => 'Monday',
            'Selasa'   => 'Tuesday',
            'Rabu'     => 'Wednesday',
            'Kamis'    => 'Thursday',
            'Jumat'    => 'Friday',
            'Sabtu'    => 'Saturday',
            'Minggu'   => 'Sunday',
        ];

        return isset($hariIndoToEng[$hari]) ? $hariIndoToEng[$hari] : null;
    }
}

if (!function_exists('hitungHariKerja')) {
    function hitungHariKerja($bulan, $tahun, $hariKerjaEnglish, $tanggalLibur)
    {
        $hariKerjaDalamBulan = 0;
        $totalHariDalamBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        $tanggalLiburArray = array_map(function ($tanggal) {
            $tanggal = trim($tanggal);
            $date = DateTime::createFromFormat('m/d/Y', $tanggal);
            return $date ? $date->format('Y-m-d') : null;
        }, explode(',', $tanggalLibur));

        $tanggalLiburArray = array_filter($tanggalLiburArray);
        for ($tanggal = 1; $tanggal <= $totalHariDalamBulan; $tanggal++) {
            $formattedDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal);
            $date = DateTime::createFromFormat('Y-m-d', $formattedDate);

            if ($date) {
                $hari = $date->format('l');
                if (in_array($hari, $hariKerjaEnglish) && !in_array($formattedDate, $tanggalLiburArray)) {
                    $hariKerjaDalamBulan++;
                }
            }
        }
        return $hariKerjaDalamBulan;
    }
}
