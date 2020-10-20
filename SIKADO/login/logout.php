<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['nama']);
unset($_SESSION['hak_akses']);
unset($_SESSION['password']);
session_destroy();
echo "<script>alert('Terima kasih, Anda Berhasil Logout')</script>";
echo "<meta http-equiv='refresh' content='1 url=../index.html'>";
?>
