<?php
if (empty(session_id())) {
    session_start();
}
include('db.php');

if(!isset($_SESSION['user'])) {
    include('login.php');
} else {
    session_destroy();
    include('login.php');
}
?>