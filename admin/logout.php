<?php
/**
 * 退出登录
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

session_start();

// 删除登录状态
$_SESSION['is_login'] = false;

// 跳转
header('Location: login.php');
