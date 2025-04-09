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
        

        error_log("Session data: " . print_r($_SESSION, true));
        if(isset($_POST["kirim"])){
            $category = $_POST['category'];
            $content = $_POST['content'];
            $user_id = $_SESSION['id_user'];
            

            if($category == "Pilih Kategori Pesan") {
                $category=1;
            }
            
            $content = mysqli_real_escape_string($db, $content);
            $sql = "INSERT INTO post (content, id_user, id_category) VALUES ('$content', $user_id, $category)";
            if(mysqli_query($db, $sql)) {
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
                        text: '".mysqli_error($db)."',
                        icon: 'error'
                    });
                </script>";
            }
        }
        $card_content = " ";
        $card_user = " ";
        $card_time = " "; 

        $query = "
        SELECT post.content, post.tanggal_posting, user.name
        from post
        join user on post.id_user=user.id_user";
        $result = mysqli_query($db, $query);
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
                            Halo, <?php echo $_SESSION['name']; ?>
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
                            <select class="form-select" aria-label="Default select example" id="category" name="category">
                                <option selected>Pilih Kategori Pesan</option>
                                <option value="1">Umum</option>
                                <option value="2">Sekolah</option>
                                <option value="3">Kerja</option>
                                <option value="4">Romansa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" rows="10" id="message-text" name="content"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="kirim">Kirim</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class='col-12 mb-4'>
            <?php 
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='col-12 mb-4'>
                        <div class='card mx-auto' style='max-width: 600px;'>
                            <div class='card-body'>
                                <h5 class='card-title mb-3'>".$row["name"]."</h5>
                                <h6 class='card-subtitle mb-2 text-body-secondary'>".$row["tanggal_posting"]."</h6>
                                <p class='card-text'>".$row["content"]."</p>
                                <a href='#' class='card-link'>
                                    <img src='./node_modules/bootstrap-icons/icons/hand-thumbs-up.svg'> 0 Like
                                </a>
                            </div>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/snippets.js"></script>
</body>
</html>