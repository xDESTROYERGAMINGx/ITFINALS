

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - CKC Information Technology</title>
  <link rel="icon" href="/img/logo.png" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS and Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #0d2a4e;
      color: #e0f0ff;
      overflow-x: hidden;
      min-height: 100vh;
      position: relative;
      z-index: 0;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('/img/bg.jpg') no-repeat center center/cover;
      filter: blur(10px) brightness(0.6);
      z-index: -1;
    }

    .navbar-blur {
      background: rgba(0, 44, 89, 0.85);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(74, 200, 224, 0.15);
    }

    .navbar-blur .navbar-brand {
      color: #4ac8e0;
      font-weight: 600;
    }

    .main-login {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding-top: 70px;
    }

    .login-card {
      background: rgba(74, 200, 224, 0.15);
      border: 1px solid rgba(74, 200, 224, 0.3);
      backdrop-filter: blur(14px);
      border-radius: 16px;
      padding: 30px;
      width: 100%;
      max-width: 400px;
      color: #e0f0ff;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    }

    .login-card h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .form-control:focus {
      border-color: #4ac8e0;
      box-shadow: 0 0 0 0.2rem rgba(74, 200, 224, 0.25);
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
    }

    .btn-login {
      background-color: #4ac8e0;
      color: #000;
      font-weight: bold;
      border: none;
    }

    .btn-login:hover {
      background-color: #3ab4cc;
    }
  </style>
</head>

<body>

<!-- Login Form -->
<div class="main-login">
  <div class="login-card">
    <h2>Login</h2>
    <form method="POST" action="/login">
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-login">Login</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

