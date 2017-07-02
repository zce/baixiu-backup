<?php
/**
 * 登录
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入配置文件
$config = require('../config.php');

// 判断当前是否是 POST 请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 是则用户名密码比对逻辑
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 判断用户名密码是否匹配
  if ($username === 'admin' && $password === 'wanglei') {
    header('Location: /index.php');
    exit();
  } else {
    $message = '用户名或密码错误！';
  }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>后台管理系统</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <div class="login-wrap">
      <div class="avatar">
        <img src="/static/uploads/monkey.png" class="img-circle" alt="用户头像">
      </div>
      <form action="login.php" method="post">
        <?php if (isset($message)) : ?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $message; ?>
        </div>
        <?php endif; ?>
        <div class="form-group form-group-lg">
          <label for="username" class="sr-only">用户名</label>
          <?php if (isset($username)) : ?>
          <input id="username" name="username" type="text" class="form-control" placeholder="用户名" value="<?php echo $username; ?>" autofocus>
          <?php else : ?>
          <input id="username" name="username" type="text" class="form-control" placeholder="用户名" autofocus>
          <?php endif; ?>
        </div>
        <div class="form-group form-group-lg">
          <label for="username" class="sr-only">密码</label>
          <input id="password" name="password" type="password" class="form-control" placeholder="密码">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登 录</button>
      </form>
    </div>
  </div>
</body>
</html>
