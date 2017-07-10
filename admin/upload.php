<?php
/**
 * 接收文件上传请求
 */

// 设置响应类型为 JSON
header('Content-Type: application/json');

$file = null;
if (isset($_FILES['file']) && $_FILES['file']['size']) {
  // 保存文件到上传目录
  if (move_uploaded_file($_FILES['file']['tmp_name'], '../static/uploads/' . $_FILES['file']['name'])) {
    $file = '/static/uploads/' . $_FILES['file']['name'];
  }
}

if (!empty($file)) {
  echo json_encode(array(
    'success' => true,
    'data' => $file
  ));
} else {
  echo json_encode(array(
    'success' => false
  ));
}
