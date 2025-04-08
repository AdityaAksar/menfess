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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        session_start();
        include "./php/koneksi.php";
        
        if (isset($_SESSION['is_login'])) {
            header("Location: index.php");
            exit();
        }
        if(isset($_POST["login"])) {
            $email = $_POST['email'];
            $password = trim($_POST['password']); 

            error_log("Input password: " . $password);
            
            $query = "SELECT name, email, password FROM USER WHERE email = '$email'";
            $result = mysqli_query($db, $query);
            
            if(mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                error_log("User data from DB: " . print_r($user, true));
                
                if(password_verify($password, $user['password']) || $password === $user['password']) {
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['is_login'] = true;
                    
                    // Verifikasi session sebelum redirect
                    error_log("Session before redirect: " . print_r($_SESSION, true));
                    
                    // Beri sedikit delay untuk memastikan session tersimpan
                    sleep(1);
                    header("Location: index.php");
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Password salah',
                            icon: 'error'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Email tidak terdaftar',
                        icon: 'error'
                    });
                </script>";
            }
        }
    ?>
    <div class="form-container">
        <h1 class="text-center mb-2">Masuk Dulu Yuk..</h1>
        <p class="text-center mb-4">Menfess merupakan platform digital untuk kamu yang malu buat confess ke pujaan hati kamu :v</p>
        <form class="needs-validation" novalidate method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Example@domain.com" required>
                <div class="invalid-feedback">
                    Harap masukkan email yang sesuai
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan kata sandi kamu disini" required>
                </div>
                <div class="invalid-feedback">
                    Harap masukkan password yang sesuai 
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Ingat aku?</label>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="signup.php">Belum Punya Akun?</a>
                <a href="#">Lupa Kata Sandi?</a>
            </div>
            <button type="submit" class="btn w-100" name="login">Masuk</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/snippets.js"></script>
</body>
</html>