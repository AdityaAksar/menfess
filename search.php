<?php
include "./php/koneksi.php";
session_start();

if (!isset($_SESSION['is_login'])) {
    header("Location: login.php");
    exit();
}

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 mb-5 bg-white rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/menfess.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                Menfess
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Untuk Anda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ruang.php">Ruang</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./node_modules/bootstrap-icons/icons/person-circle.svg" alt="" height="22">
                            Halo, <?php echo htmlspecialchars($_SESSION['name']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php" class="dropdown-item">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari Postingan" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4">Hasil Pencarian untuk "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        
        <?php
        if(isset($_POST["kirim_comment"])) {
            $comment_content = trim($_POST['comment_content_form'] ?? '');
            $id_postingan = (int)($_POST['id_post'] ?? 0);
            
            if($id_postingan <= 0 || empty($comment_content)) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Post ID dan isi komentar harus diisi',
                        icon: 'error'
                    });
                </script>";
            } else {
                $user_id = $_SESSION['id_user'];
                
                $stmt = $db->prepare("INSERT INTO comment (id_post, id_user, comment_content) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $id_postingan, $user_id, $comment_content);
                
                if($stmt->execute()) {
                    echo "<script>
                        Swal.fire({
                            title: 'Upload Berhasil',
                            text: 'Komentar telah terkirim!',
                            icon: 'success',
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: '".addslashes($stmt->error)."',
                            icon: 'error'
                        });
                    </script>";
                }
                $stmt->close();
            }
        }
        if (!empty($searchQuery)) {
            $stmt = $db->prepare("
                SELECT p.*, u.name, 
                (SELECT COUNT(*) FROM likes l WHERE l.id_post = p.id_post) AS like_count
                FROM post p
                JOIN user u ON p.id_user = u.id_user
                WHERE p.content LIKE ?
                ORDER BY p.tanggal_posting DESC
            ");
            $searchParam = "%" . $searchQuery . "%";
            $stmt->bind_param("s", $searchParam);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $post_id = $row['id_post'];
                    $user_id = $_SESSION['id_user'];
                    
                    // Check if user liked this post
                    $like_check_query = "SELECT id_like FROM likes WHERE id_post = $post_id AND id_user = $user_id";
                    $like_check_result = mysqli_query($db, $like_check_query);
                    $is_liked = mysqli_num_rows($like_check_result) > 0;
                    
                    $like_btn_class = $is_liked ? 'btn-success' : 'btn-secondary';
                    
                    echo '<div class="col-12 mb-4">
                        <div class="card mx-auto" style="max-width: 600px;">
                            <div class="card-body">
                                <h5 class="card-title mb-3">'.htmlspecialchars($row["name"]).'</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">'.htmlspecialchars($row["tanggal_posting"]).'</h6>
                                <p class="card-text">'.nl2br(htmlspecialchars($row["content"])).'</p>
                                <form action="like.php" method="POST" class="d-inline">
                                    <input type="hidden" name="post_id" value="'.$post_id.'">
                                    <button type="submit" class="btn '.$like_btn_class.'">
                                        <img src="./node_modules/bootstrap-icons/icons/hand-thumbs-up.svg"> 
                                        '.$row['like_count'].' Like
                                    </button>
                                </form>
                                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#commentModal" 
                                    onclick="loadComments('.$post_id.')">
                                    <img src="./node_modules/bootstrap-icons/icons/chat.svg"> Comment
                                </a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Tidak ditemukan hasil untuk pencarian Anda.</p>';
            }
            $stmt->close();
        } else {
            echo '<p>Silakan masukkan kata kunci pencarian.</p>';
        }
        ?>
    </div>

    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Komentar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 mb-4" id="comment-container">
                                <p class="text-center">Memuat komentar...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" id="comment-form">
                    <div class="modal-footer d-flex flex-column">
                        <div class="mb-1 w-100">
                            <input type="hidden" name="id_post" id="comment_post_id" value="">
                            <label for="message-text" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" rows="3" id="message-text" name="comment_content_form" required></textarea>
                        </div>
                        <div class="mb-3 w-100">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="kirim_comment">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function loadComments(postId) {
        document.getElementById('comment_post_id').value = postId;
        
        const commentContainer = document.getElementById('comment-container');
        commentContainer.innerHTML = '<p class="text-center">Memuat komentar...</p>';
        
        fetch(`get_comments.php?post_id=${postId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                commentContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                commentContainer.innerHTML = '<p class="text-center text-danger">Gagal memuat komentar</p>';
            });
    }
    </script>
</body>
</html>