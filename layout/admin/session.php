<?php
session_start();
if (isset($_SESSION['session_email'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/login');
}