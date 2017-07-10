<?php
/**
 * 项目配置文件
 */

// 设置默认时区！！！PRC 中华人民共和国
date_default_timezone_set('PRC');

/**
 * 数据库主机
 */
define('DB_HOST', '127.0.0.1');

/**
 * 数据库用户名
 */
define('DB_USER', 'root');

/**
 * 数据库密码
 */
define('DB_PASS', 'wanglei');

/**
 * 数据库名称
 */
define('DB_NAME', 'baixiu');

/**
 * 网站根目录
 */
define('ROOT_PATH', dirname(__FILE__));

/**
 * 上传文件目录
 */
define('UPLOAD_PATH', '/static/uploads/' . date('Y'));

if (!file_exists(ROOT_PATH . UPLOAD_PATH)) {
  mkdir(ROOT_PATH . UPLOAD_PATH, 0777, true);
}
