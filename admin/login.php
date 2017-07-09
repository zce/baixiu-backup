<?php
/**
 * 登录页
 */

require '../functions.php';

// 判断是否为表单提交请求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 是表单提交，接收表单数据，执行登录校验逻辑
  if (!isset($_POST['email']) || $_POST['email'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
    // 没有正确填写表单，错误提示
    $message = '请正确填写表单！';
  } else {
    // 1. 接收表单提交内容
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. 连接数据库根据邮箱查询用户
    $data = query(sprintf("select * from users where email = '%s' limit 1;", $email));

    // 3. 判断用户名与密码是否正确
    if (isset($data[0])) {
      // 存在该用户
      $user = $data[0];
      // 判断密码是否相同
      if ($user['password'] == $password) {
        // 登录成功
        // Session 中记录登录用户 ID 维护登录状态
        session_start();
        $_SESSION['current_user_id'] = $user['id'];
        // 跳转到后台首页
        header('Location: /admin/index.php');
        // 结束执行
        exit;
      } else {
        // 密码错误
        $message = '用户名与密码不匹配！';
      }
    } else {
      // 用户名不存在
      $message = '用户名与密码不匹配！';
    }
  }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in « Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="login.php" method="post">
      <img class="avatar" src="/static/uploads/monkey.png">
      <?php if (isset($message)) : ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif; ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <?php if (isset($email)) : ?>
        <input id="email" name="email" type="email" class="form-control" value="<?php echo $email; ?>" placeholder="邮箱" autofocus>
        <?php else : ?>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button type="submit" class="btn btn-primary btn-block">登 录</button>
    </form>
  </div>
</body>
</html>
