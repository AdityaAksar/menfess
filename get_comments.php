<?php
include "./php/koneksi.php";
session_start();

if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    die("Post ID tidak valid");
}

$post_id = (int)$_GET['post_id'];

// Gunakan prepared statement
$stmt = $db->prepare("
    SELECT comment.comment_content, comment.tanggal_komentar, user.name
    FROM comment
    JOIN user ON comment.id_user = user.id_user
    WHERE comment.id_post = ?
    ORDER BY comment.tanggal_komentar DESC
");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result_comment = $stmt->get_result();

if ($result_comment && $result_comment->num_rows > 0) {
    while ($row = $result_comment->fetch_assoc()) {
        echo "<div class='col-12 mb-2'>
            <div class='card mx-auto' style='max-width: 800px;'>
                <div class='card-body'>
                    <h5 class='card-title mb-3'>".htmlspecialchars($row["name"])."</h5>
                    <h6 class='card-subtitle mb-2 text-body-secondary'>".htmlspecialchars($row["tanggal_komentar"])."</h6>
                    <p class='card-text'>".htmlspecialchars($row["comment_content"])."</p>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<p class='text-center'>Belum ada komentar. Jadilah yang pertama berkomentar!</p>";
}

$stmt->close();
?>