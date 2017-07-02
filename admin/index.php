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
  // 没有设置
  header('Location: /admin/login.php');
  exit();
}
?>
<h1>后台脚本</h1>
<p><?php echo $config['BAIXIU_DB_HOST']; ?></p>
