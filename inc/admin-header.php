<?php
/**
 * 后台公共头部区域代码
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 启用新会话或使用已有会话
session_start();

// 判断是否登录成功
$is_login = $_SESSION['is_login'];
if (!isset($is_login) || $is_login !== true) {
  // 没有登录
  header('Location: /admin/login.php');
  exit();
}

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
