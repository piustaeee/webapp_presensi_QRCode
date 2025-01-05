<?php
defined('BASEPATH') or exit('No direct script access allowed');

// hrd
$route['default_controller'] = 'login';
$route['login'] = 'login/index';
$route['berandaAdmin'] = 'Admin/Dashboard/admin';
$route['rekapitulasi'] = 'Admin/ManajemenPresensi/rekapitulasi';
$route['evaluasiDiriAdmin'] = 'EvaluasiDiri/evaluasiDiriAdmin';
$route['dataPegawai'] = 'Admin/KelolaData/kelolaDataPegawai';
$route['detailDataAdmin'] = 'Admin/Dashboard/detailData';
$route['detailDataIndividu/(:num)'] = 'Admin/KelolaData/detailDataIndividu/$1';
$route['tambahData'] = 'Admin/KelolaData/tambahData';
$route['updateData/(:num)'] = 'Admin/KelolaData/updateData/$1';
$route['hapusData/(:num)'] = 'Admin/KelolaData/hapusData/$1';
$route['updateDataPegawai'] = 'Admin/KelolaData/updateDataPegawai';


$route['tambahAkun'] = 'Admin/KelolaData/tambahAkun';
$route['updateAkun'] = 'Admin/KelolaData/updateAkun';
$route['readAkunPegawai/(:num)'] = 'Admin/KelolaData/readAkunPegawai/$1';


$route['presensiAdmin'] = 'Admin/PengaturanPresensi/presensiAdmin';
$route['aturPresensi'] = 'Admin/PengaturanPresensi/aturPresensi';
$route['presensiBaru'] = 'Admin/PengaturanPresensi/presensiBaru';





$route['dataJabatan'] = 'Admin/Jabatan/tampilJabatan';
$route['updateJabatan'] = 'Admin/Jabatan/updateJabatan';



// pegawai
$route['berandaUser'] = 'User/Dashboard/user';
$route['detailDataUser'] = 'User/Dashboard/detailData';
$route['presensiUser'] = 'User/PengaturanPresensi/presensiUser';
$route['evaluasiDiriUser'] = 'EvaluasiDiri/evaluasiDiriUser';



//QrCode


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
