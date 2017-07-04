<?php
/**
 * 后台入口
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入配置文件
$config = require('../config.php');

// 启用新会话或使用已有会话
session_start();

// 判断是否登录成功
$is_login = $_SESSION['is_login'];
if (!isset($is_login) || $is_login !== true) {
  // 没有登录
  header('Location: /admin/login.php');
  exit();
}

// 查询界面上所需的数据
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

// 文章总数
$post_count_result = mysqli_query($connection, 'select count(1) from posts');
$post_count = mysqli_fetch_row($post_count_result)[0];
mysqli_free_result($post_count_result);

// 草稿总数
$draft_count_result = mysqli_query($connection, 'select count(1) from posts where status = \'drafted\'');
$draft_count = mysqli_fetch_row($draft_count_result)[0];
mysqli_free_result($draft_count_result);

// 分类总数
$category_count_result = mysqli_query($connection, 'select count(1) from categories');
$category_count = mysqli_fetch_row($category_count_result)[0];
mysqli_free_result($category_count_result);

// 评论总数
$comment_count_result = mysqli_query($connection, 'select count(1) from comments');
$comment_count = mysqli_fetch_row($comment_count_result)[0];
mysqli_free_result($comment_count_result);

// 待审核的评论总数
$held_count_result = mysqli_query($connection, 'select count(1) from comments where status = \'held\'');
$held_count = mysqli_fetch_row($held_count_result)[0];
mysqli_free_result($held_count_result);

// 2. 关闭与数据库之间的连接
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>后台管理系统</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <div class="container-fluid">
      <div class="header">
        <nav class="navbar navbar-custom">
          <div class="navbar-header">
            <a href="javascript:;" class="navbar-brand"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="profile.html"><i class="glyphicon glyphicon-user"></i>个人中心</a></li>
            <li><a href="login.html"><i class="glyphicon glyphicon-off"></i>退出</a></li>
          </ul>
        </nav>
      </div>
      <div class="body">
        <div class="jumbotron">
          <h1>Hello world</h1>
          <h2>站点内容统计：</h2>
          <p>
            <ul>
              <li><strong><?php echo $post_count; ?></strong>篇文章（<strong><?php echo $draft_count; ?></strong>篇草稿）</li>
              <li><strong><?php echo $category_count; ?></strong>个分类</li>
              <li><strong><?php echo $comment_count; ?></strong>条评论（<strong><?php echo $held_count; ?></strong>条待审核）</li>
            </ul>
          </p>
          <p><a class="btn btn-primary btn-lg" href="post-new.html" role="button">写文章</a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="aside">
    <div class="profile">
      <div class="avatar img-circle"><img src="/static/uploads/avatar.jpg"></div>
      <h4>布头儿</h4>
    </div>
    <div class="nav">
      <ul class="list-unstyled">
        <li class="active">
          <a href="index.html"><i class="glyphicon glyphicon-dashboard"></i>仪表盘</a>
        </li>
        <li>
          <a href="#posts-sub" class="collapsed" data-toggle="collapse">
            <i class="glyphicon glyphicon-pushpin"></i>文章<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="posts-sub" class="list-unstyled collapse">
            <li><a href="posts.html">所有文章</a></li>
            <li><a href="post-new.html">写文章</a></li>
            <li><a href="categories.html">分类目录</a></li>
          </ul>
        </li>
        <li>
          <a href="comments.html"><i class="glyphicon glyphicon-comment"></i>评论</a>
        </li>
        <li>
          <a href="users.html"><i class="glyphicon glyphicon-user"></i>用户</a>
        </li>
        <li>
          <a href="#settings-sub" class="collapsed" data-toggle="collapse">
            <i class="glyphicon glyphicon-cog"></i>设置<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="settings-sub" class="list-unstyled collapse">
            <li><a href="nav-menus.html">导航菜单</a></li>
            <li><a href="slides.html">图片轮播</a></li>
            <li><a href="settings.html">网站设置</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <script src="/static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
