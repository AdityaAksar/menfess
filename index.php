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
                        <a class="nav-link" href="#">Ruang</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./node_modules/bootstrap-icons/icons/person-circle.svg" alt="" height="22">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Profil</a></li>
                            <li><a href="#" class="dropdown-item">Ganti Password</a></li>
                            <li><a href="#" class="dropdown-item">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- <div class="d-flex align-items-center">
                    <a role="button" class="btn btn-primary px-3 me-2">
                      Masuk
                    </a>
                    <a role="button" class="btn btn-primary me-3" href="signup.html">
                      Daftar
                    </a>
                </div> -->
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Buat Postingan</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Postingan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" rows="10" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/snippets.js"></script>
</body>
</html>