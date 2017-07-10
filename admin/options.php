<?php
/**
 * 配置选项 AJAX
 */

require '../functions.php';

// 设置响应类型为 JSON
header('Content-Type: application/json');

// 如果是 GET 请求，则获取指定配置
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (empty($_GET['key'])) {
    // echo json_encode(array(
    //   'success' => false,
    //   'message' => 'option key required'
    // ));
    // exit; // 不再往下执行
    // 查询全部数据
    $data = query('select * from `options`');
    echo json_encode(array(
      'success' => true,
      'data' => $data
    ));
    exit; // 不再往下执行
  }
  // 查询数据
  $data = query(sprintf('select `value` from `options` where `key` = \'%s\' limit 1;', $_GET['key']));
  // 返回
  if (isset($data[0][0])) {
    echo json_encode(array(
      'success' => true,
      'data' => $data[0][0]
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'message' => 'option key does not exist'
    ));
  }
  exit; // 不再往下执行
}

// 否则是更新或新增配置

if (empty($_POST['key']) || empty($_POST['value'])) {
  // 关键数据不存在
  echo json_encode(array(
    'success' => false,
    'message' => 'option key and value required'
  ));
  exit; // 不再往下执行
}

// 判断是否存在该属性
$exist = query(sprintf('select count(1) from `options` where `key` = \'%s\'', $_POST['key']))[0][0] > 0;

if ($exist) {
  $affected_rows = execute(sprintf('update `options` set `value` = \'%s\' where `key` = \'%s\'', $_POST['value'], $_POST['key']));
} else {
  $affected_rows = execute(sprintf('insert into `options` values (null, \'%s\', \'%s\')', $_POST['key'], $_POST['value']));
}

echo json_encode(array(
  'success' => $affected_rows > 0
));
