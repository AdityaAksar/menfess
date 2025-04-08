<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar -Menfess</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #6CD638;
        }
        .form-container {
            background-color: #aee891;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-container h1 {
            color: #006400;
        }
        .form-container p {
            color: #228B22;
        }
        .form-container label {
            color: #006400;
        }
        .form-container .form-control {
            border-color: #32CD32;
        }
        .form-container .btn {
            background-color: #32CD32;
            color: white;
        }
        .form-container .btn:hover {
            background-color: #228B22;
        }
        .form-container .form-check-label, .form-container a {
            color: #32CD32;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <?php
        session_start(); 

        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit();
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        include "./php/koneksi.php";
        if(isset($_POST["register"])) {
            $email = $_POST['email'];
            $nama = $_POST['name'];
            $password = $_POST['password'];
            
            $sql = "INSERT INTO USER (email, password, name) VALUES ('$email', '$password', '$nama')";

            $check = mysqli_query($db, "SELECT * FROM USER WHERE email = '$email'");
            if(mysqli_num_rows($check) > 0) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Email sudah terdaftar',
                        icon: 'error'
                    });
                </script>";
            } else {
                if(mysqli_query($db, $sql)) {
                    echo "<script>
                        Swal.fire({
                            title: 'Pendaftaran berhasil',
                            text: 'Silahkan login menggunakan email: " . $email . "',
                            icon: 'success',
                            confirmButtonText: 'Login Sekarang'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'login.php';
                            }
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
        }
    ?>
    <div class="form-container">
        <h1 class="text-center mb-2">Daftar Dulu Yuk..</h1>
        <p class="text-center mb-4">Menfess merupakan platform digital untuk kamu yang malu buat confess ke pujaan hati kamu :v</p>
        <form class="needs-validation" novalidate method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Example@domain.com" required>
                <div class="invalid-feedback">
                    Harap masukkan email yang sesuai
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Samaran Kamu" required>
                <div class="invalid-feedback">
                    Harap masukkan Nama yang sesuai
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukan kata sandi kamu disini" required>
                </div>
                <div class="invalid-feedback">
                    Harap masukkan password yang sesuai 
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Ingat aku?</label>
                </div>
                <a href="login.html">Sudah punya akun</a>
            </div>
            <button type="submit" class="btn w-100" name="register">Daftar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/snippets.js"></script>
</body>
</html>
