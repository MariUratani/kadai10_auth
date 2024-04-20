<?php
session_start(); // セッションを開始
//1.  DB接続
include("funcs.php");
$pdo = db_conn();

// ログインチェック
sschk();

// ソートの条件を受け取る
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

//２．データ登録SQL作成
$sql = "SELECT ROW_NUMBER() OVER (ORDER BY id ASC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY id ASC"; // デフォルトのソート順（id順）
switch ($sort) {
  case 'py_asc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY py ASC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY py ASC";
    break;
  case 'py_desc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY py DESC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY py DESC";
    break;
  case 'status_asc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY status ASC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY status ASC";
    break;
  case 'status_desc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY status DESC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY status DESC";
    break;
  case 'action_asc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY action ASC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY action ASC";
    break;
  case 'action_desc':
    $sql = "SELECT ROW_NUMBER() OVER (ORDER BY action DESC) AS row_num, id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY action DESC";
    break;
}

$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//３．データ表示
if ($status == false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登録内容表示</title>
  <link rel="stylesheet" href="style.css">
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://kit.fontawesome.com/e53e6d346a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    div {
      padding: 10px;
      font-size: 16px;

      td {
        border: 1px solid red;
      }
    }
  </style>
</head>

<body>
  <!-- Head[Start] -->
  <header>
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="select.php">My BOOKSHELF</a>
        </div>
        <div class="navbar-right">
          <span class="navbar-text">Hello！<?= $_SESSION["name"] ?>さん</span>

          <!-- <ul class="nav navbar-nav navbar-right"> -->
          <ul class="nav navbar-nav">
            <li>
              <a href="index.php" class="btn btn-primary">データ登録
                <i class="fas fa-plus-circle"></i>
              </a>
            </li>
            <li>
              <a href="logout.php" class="btn btn-danger">ログアウト
                <i class="fa fa-sign-out" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->


  <!-- Main[Start] -->
  <div class="container">
    <table>
      <tr>
        <th></th>
        <th>ISBN</th>
        <th>書名</th>
        <th>著者</th>

        <th>出版年 <a href="select.php?sort=py_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=py_desc"><i class="fas fa-sort-down"></i></a></th>
        <th>摘要</th>
        <th>ステータス <a href="select.php?sort=status_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=status_desc"><i class="fas fa-sort-down"></i></a></th>
        <th>アクション <a href="select.php?sort=action_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=action_desc"><i class="fas fa-sort-down"></i></a></th>
        <th></th>
        <th></th>
      </tr>

      <?php foreach ($values as $value) { ?>
        <tr>
          <td class="row-num"><?= h($value["row_num"]) ?></td>
          <td><?= h($value["isbn"]) ?></td>
          <td><?= h($value["name"]) ?></td>
          <td><?= h($value["author"]) ?></td>
          <td><?= h($value["py"]) ?></td>
          <td><?= h($value["tekiyou"]) ?></td>
          <td><?= h($value["status"]) ?></td>
          <td><?= h($value["action"]) ?></td>
          <?php if ($_SESSION['kanri_flg'] == 1) { ?>
            <td>
              <!-- <a href="detail.php?id=<?= h($value['id']) ?>" class="btn"><i class="fa-solid fa-pencil"></i></a> -->
              <a href="detail.php?id=<?= h($value['id']) ?>" class="btn btn-update"><i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>
              <form id="deleteForm_<?= h($value['id']) ?>" method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?= h($value['id']) ?>">
                <!-- <button type="button" class="btn btn-danger" onclick="deleteBook(<?= h($value['id']) ?>, '<?= h($value['name']) ?>')"><i class="fa fa-trash-o fa-lg"></i></button> -->
                <a href="#" class="btn btn-delete btn-danger" onclick="deleteBook(<?= h($value['id']) ?>, '<?= h($value['name']) ?>')"><i class="fa fa-trash-o"></i></a>
              </form>
            </td>
          <?php } else { ?>
            <td>-</td>
            <td>-</td>
          <?php } ?>
        </tr>
      <?php } ?>
    </table>
  </div>
  <!-- Main[End] -->

  <script>
    function deleteBook(id, title) {
      Swal.fire({
        title: '削除確認',
        text: `「${title}」を削除しますか？`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '削除',
        cancelButtonText: 'キャンセル'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(`deleteForm_${id}`).submit();
        }
      })
    }
  </script>
</body>

</html>