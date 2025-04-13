<?php
session_start();
require_once __DIR__ . '/php/koneksi.php';

// Debugging: Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek login
if (!isset($_SESSION['id_user'])) {
    die("Error: Anda harus login terlebih dahulu");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $id_user = intval($_SESSION['id_user']);
    
    // Debug: Tampilkan nilai variabel
    echo "Debug: post_id=$post_id, id_user=$id_user<br>";

    // 1. Cek apakah post ada
    $check_post = mysqli_prepare($db, "SELECT id_post FROM post WHERE id_post = ?");
    mysqli_stmt_bind_param($check_post, "i", $post_id);
    mysqli_stmt_execute($check_post);
    $post_exists = mysqli_stmt_get_result($check_post);
    
    if (mysqli_num_rows($post_exists) === 0) {
        die("Error: Postingan tidak ditemukan");
    }

    // 2. Cek apakah like sudah ada
    $check_like = mysqli_prepare($db, "SELECT id_like FROM likes WHERE id_post = ? AND id_user = ?");
    mysqli_stmt_bind_param($check_like, "ii", $post_id, $id_user);
    mysqli_stmt_execute($check_like);
    $like_exists = mysqli_stmt_get_result($check_like);

    if (mysqli_num_rows($like_exists) > 0) {
        // Unlike
        $delete = mysqli_prepare($db, "DELETE FROM likes WHERE id_post = ? AND id_user = ?");
        mysqli_stmt_bind_param($delete, "ii", $post_id, $id_user);
        mysqli_stmt_execute($delete);
        echo "Debug: Like dihapus<br>";
    } else {
        // Like
        $insert = mysqli_prepare($db, "INSERT INTO likes (id_post, id_user, tanggal_like) VALUES (?, ?, NOW())");
        mysqli_stmt_bind_param($insert, "ii", $post_id, $id_user);
        $result = mysqli_stmt_execute($insert);
        
        if (!$result) {
            echo "Error: " . mysqli_error($db) . "<br>";
        } else {
            echo "Debug: Like ditambahkan<br>";
        }
    }
    
    // Redirect kembali
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    die("Error: Request tidak valid");
}
?>