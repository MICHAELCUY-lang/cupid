<?php
session_start();

// Konfigurasi Database
$servername = "localhost";
$username = "u287442801_cupid";
$password = "Cupid1234!";
$dbname = "u287442801_cupid";

// Buat koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Fungsi untuk memeriksa apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk memastikan user harus login
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}

// Fungsi untuk mengecek user yang sudah login dan seharusnya diarahkan ke dashboard
function checkLoggedIn() {
    if (isLoggedIn()) {
        redirect('dashboard.php');
    }
}

// Fungsi untuk sanitasi input
function sanitizeInput($input) {
    global $conn;
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($input))));
}