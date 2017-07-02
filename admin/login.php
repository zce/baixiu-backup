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

  // 只有数据库才“知道”用户名密码是否正确，所以必须通过查询数据库验证用户名和密码

  // 1. 建立与数据的连接
  $connection = mysqli_connect(
    $config['BAIXIU_DB_HOST'],
    $config['BAIXIU_DB_USER'],
    $config['BAIXIU_DB_PASSWORD'],
    $config['BAIXIU_DB_NAME']
  );

  if (!$connection) {
    // 链接数据库失败，打印错误信息
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
  }

  // 根据用户名查询用户信息
  $result = mysqli_query($connection, 'select * from users where email = \'' . $username . '\' limit 1');

  if ($result) {
    if (mysqli_num_rows($result)) {
      // 获取结果中的内容
      $row = mysqli_fetch_assoc($result);

      // 比对密码
      if ($row['password'] === $password) {
        // 启用新会话或使用已有会话
        session_start();

        // 记住登录状态
        $_SESSION['is_login'] = true;

        // 跳转到后台首页
        header('Location: /admin/');

        // 结束执行
        exit();
      } else {
        // 密码错误
        $message = '用户名或密码错误！';
      }
    } else {
      // 用户名错误
      $message = '用户名或用户名错误！';
    }

    // 释放资源
    mysqli_free_result($result);
  } else {
    // 查询失败
    $message = '出现错误，请稍后再试！';
  }

  // 2. 关闭与数据库之间的连接
  mysqli_close($connection);
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
