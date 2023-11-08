<?php 
session_start();
// Pastikan sesi benar-benar ada sebelum dihapus
if (isset($_SESSION)) {
    session_regenerate_id(true);
    session_unset();
    session_destroy();
}
header("Location: login.php");
exit;
?>
