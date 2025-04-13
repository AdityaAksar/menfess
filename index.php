<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        include "./php/koneksi.php";
        session_start();

        if (!isset($_SESSION['is_login'])) {
            header("Location: login.php");
            exit();
        }

        // Handle post submission
        if(isset($_POST["kirim_post"])){
            $category = $_POST['category'];
            $post_content = $_POST['post_content_form'];
            $user_id = $_SESSION['id_user'];

            if($category == "Pilih Kategori Pesan") {
                $category = 1;
            }

            // Use prepared statement for security
            $stmt = $db->prepare("INSERT INTO post (content, id_user, id_category) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $post_content, $user_id, $category);
            
            if($stmt->execute()) {
                echo "<script>
                    Swal.fire({
                        title: 'Upload Berhasil',
                        text: 'Pesan telah terkirim!',
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

        // Handle comment submission
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
                
                // Use prepared statement for security
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

        // Get all posts
        $post_query = "
            SELECT post.id_post, post.content, post.tanggal_posting, user.name
            FROM post
            JOIN user ON post.id_user = user.id_user
            ORDER BY post.tanggal_posting DESC";
        $result_post = mysqli_query($db, $post_query);

        // Function to get comments for a specific post
        function getCommentsForPost($db, $post_id) {
            $stmt = $db->prepare("
                SELECT comment.comment_content, comment.tanggal_komentar, user.name
                FROM comment
                JOIN user ON comment.id_user = user.id_user
                WHERE comment.id_post = ?
                ORDER BY comment.tanggal_komentar DESC
            ");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();
            return $stmt->get_result();
        }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 mb-5 bg-white rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/menfess.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                Menfess
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Untuk Anda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Terbaru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Paling Dicari</a>
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
                            <li><a href="#" class="dropdown-item">Profil</a></li>
                            <li><a href="#" class="dropdown-item">Ganti Password</a></li>
                            <li><a href="logout.php" class="dropdown-item">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <button type="button" class="btn btn-primary mx-5 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Buat Postingan</button>
    
    <!-- Post Creation Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Postingan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="category" class="col-form-label">Pilih Kategori Postingan</label>
                            <select class="form-select" aria-label="Default select example" id="category" name="category" required>
                                <option value="" selected>Pilih Kategori Pesan</option>
                                <option value="1">Umum</option>
                                <option value="2">Sekolah</option>
                                <option value="3">Kerja</option>
                                <option value="4">Romansa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" rows="10" id="message-text" name="post_content_form" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="kirim_post">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <?php 
            while ($row = mysqli_fetch_array($result_post)) {
                $post_id = $row['id_post'];
                echo "<div class='col-12 mb-4'>
                    <div class='card mx-auto' style='max-width: 600px;'>
                        <div class='card-body'>
                            <h5 class='card-title mb-3'>".htmlspecialchars($row["name"])."</h5>
                            <h6 class='card-subtitle mb-2 text-body-secondary'>".htmlspecialchars($row["tanggal_posting"])."</h6>
                            <p class='card-text'>".htmlspecialchars($row["content"])."</p>
                            <a href='#' class='btn btn-secondary'>
                                <img src='./node_modules/bootstrap-icons/icons/hand-thumbs-up.svg'> 0 Like
                            </a>
                            <a href='#' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#commentModal' 
                                onclick='loadComments($post_id)'>
                                <img src='./node_modules/bootstrap-icons/icons/chat.svg'> Comment
                            </a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
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
                            <div class='col-12 mb-4' id="comment-container">
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
        // Set post ID in the form
        document.getElementById('comment_post_id').value = postId;
        
        // Clear and show loading message
        const commentContainer = document.getElementById('comment-container');
        commentContainer.innerHTML = '<p class="text-center">Memuat komentar...</p>';
        
        // Load comments via AJAX
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