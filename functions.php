<?php
/**
 * 常用函数封装
 */

// 载入配置文件
require_once 'config.php';

/**
 * 建立数据库连接
 * @return MySQLi 数据库连接对象
 */
function connect () {
  // 建立与数据库的连接
  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // 如果数据库连接失败，打印错误信息
  if (!$connection) {
    // 生产环境不能输出具体的错误信息（不安全）
    die('<h1>Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() . '</h1>');
  }

  return $connection;
}

/**
 * 执行一个查询语句，返回查询到的数据
 * @param  String $sql SQL 语句
 * @return Array       查询到的数据
 */
function query ($sql) {
  // 获取与数据库之间的连接
  $connection = connect();

  // 执行 SQL 语句，获取一个查询对象
  $result = mysqli_query($connection, $sql);

  // 创建一个空的数组，用于存放每一行的数据
  $data = array();

  // 查询失败返回空数据
  if (!$result) return $data;

  // 遍历每一行，将每一行转换为一个关联数组或索引数组，放到数组中
  while ($row = mysqli_fetch_array($result)) {
    $data[] = $row;
  }

  // 释放查询资源
  mysqli_free_result($result);

  // 关闭数据库连接
  mysqli_close($connection);

  // 返回数据
  return $data;
}

/**
 * 执行一个非查询语句，返回执行语句后受影响的行数
 * @param  String  $sql 非查询语句
 * @return Integer      执行语句后受影响的行数
 */
function execute ($sql) {
  // 获取与数据库之间的连接
  $connection = connect();

  // 执行 SQL 语句，获取一个查询对象
  $result = mysqli_query($connection, $sql);

  // 获取执行语句后受影响的行数
  $affected_rows = mysqli_affected_rows($connection);

  // 关闭数据库连接
  mysqli_close($connection);

  // 返回受影响行数
  return $affected_rows;
}

/**
 * 获取当前登录用户信息
 * @return array 当前登录用户信息
 */
function get_user_info () {
  // 启动会话
  session_start();

  // 获取会话中的用户 ID
  if (isset($_SESSION['current_user_id'])) {
    // 根据 ID 查询用户信息
    $data = query(sprintf("select * from users where id = %d limit 1;", intval($_SESSION['current_user_id'])));
    if (isset($data[0])) {
      // 存在用户
      return $data[0];
    }
  }

  // 会话信息中没有用户 ID 或是没有查询到对应 ID 的用户（没有登录）
  // 跳转到登录页面
  header('Location: /admin/login.php');
  // 结束代码执行
  exit();
}
