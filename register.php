<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .register-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 400px; }
        .register-container h2 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: calc(100% - 22px); padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group button { background: #007BFF; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; width: 100%; }
        .form-group button:hover { background: #0056b3; }
        .error-message { color: red; margin-top: 5px; }
        .register-link {text-align: center; margin-top:10px;}
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Daftar Akun Baru</h2>
         <?php
         if (isset($_SESSION['error'])) {
             echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
             unset($_SESSION['error']);
         }
        ?>
        <form action="register_process.php" method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required>
            </div>
             <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
             <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
          <div class="register-link">
         Sudah punya akun? <a href="login.php">Login disini</a>
    </div>
    </div>
</body>
</html>