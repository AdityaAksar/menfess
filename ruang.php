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
                        <a class="nav-link" aria-current="page" href="index.php">Untuk Anda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Terbaru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Paling Dicari</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="ruang.php">Ruang</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a role="button" class="btn btn-primary px-3 me-2">
                    Masuk
                    </a>
                    <a role="button" class="btn btn-primary me-3" href="signup.html">
                    Daftar
                    </a>
                </div>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <h5 class="mx-5">Komunitas Anda</h5>
    <div class="row row-cols-1 row-cols-md-3 g-4 mx-4">
        <div class="col">
            <div class="card h-100 shadow p-3 mb-3 bg-white rounded">
            <img src="./img/frieren.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary">Jelajahi</a>
            </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow p-3 mb-3 bg-white rounded">
            <img src="./img/frieren.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary">Jelajahi</a>
            </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow p-3 mb-3 bg-white rounded">
            <img src="./img/frieren.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary">Jelajahi</a>
            </div>
            </div>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/snippets.js"></script>
</body>
</html>