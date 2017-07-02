<?php
/**
 * 后台入口
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入配置文件
$config = require('../config.php');

// 判断是否登录成功
// 获取 Cookie 中的内容
$is_login = $_COOKIE['is_login'];
if (!isset($is_login) || $is_login !== 'true') {
  // 没有设置
  header('Location: /admin/login.php');
  exit();
}
?>
<h1>后台脚本</h1>
<p><?php echo $config['BAIXIU_DB_HOST']; ?></p>
