<?php
$inputPassword = '2121024';
$hashedPassword = '$2y$10$UBFu9wShWT/tbkxzTAWr2.D3e8Nh6CmwJapZQLckWh384n8UFwPqe';

if (password_verify($inputPassword, $hashedPassword)) {
    echo "Password is correct!";
} else {
    echo "Password is incorrect!";
}



