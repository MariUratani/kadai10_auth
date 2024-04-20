<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://kit.fontawesome.com/e53e6d346a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }

    input[type="text"],
    input[type="password"] {
      height: 30px;
      padding: 5px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .btn-primary {
      background-color: #3085d6;
      border-color: #3085d6;
    }

    .btn-primary:hover {
      background-color: #2b79c5;
      border-color: #2b79c5;
    }

    .login-container {
      max-width: 400px;
      margin: 0 auto;
    }

    .login-container fieldset {
      margin-top: 30px;
    }

    .login-container label {
      display: block;
      margin-bottom: 5px;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      margin-bottom: 10px;
    }

    .login-container input[type="submit"] {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <!-- Head[Start] -->
  <header>
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="login.php">LOGIN</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
  <form method="post" action="login_act.php">
    <div class="login-container">

      <fieldset>
        <div>
          <div>
            <label for="lid">ID:</label>
            <input type="text" name="lid" id="lid" required>
          </div>
          <div>
            <label for="lpw">PW:</label>
            <input type="password" name="lpw" id="lpw" required>
          </div>
          <!-- <input type="submit" value="ログイン" class="btn btn-primary">
          <i class="fa fa-sign-in" aria-hidden="true"></i> -->
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-sign-in" aria-hidden="true"></i> ログイン
          </button>
        </div>
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->
</body>

</html>