<?php
/**
 * 数据库常用操作封装
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

/**
 * 建立数据库连接
 * @return MySQLi 数据库连接对象
 */
function connect () {
  // 载入配置文件
  $config = require('../config.php');

  // 建立与数据库的连接
  $connection = mysqli_connect(
    $config['BAIXIU_DB_HOST'],
    $config['BAIXIU_DB_USER'],
    $config['BAIXIU_DB_PASSWORD'],
    $config['BAIXIU_DB_NAME']
  );

  // 如果数据库连接失败，打印错误信息
  if (!$connection) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
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
