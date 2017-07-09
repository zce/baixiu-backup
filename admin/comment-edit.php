<?php
/**
 * 编辑评论+删除评论
 */

require '../functions.php';

// 设置响应类型为 JSON
header('Content-Type: application/json');

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  // 删除评论
  if (!empty($_GET['items'])) {
    // items 格式就是以英文半角逗号分隔的 ID
    // 执行非查询语句
    execute(sprintf('delete from comments where id in (%s)', $_GET['items']));
  }
  // 删除成功
  echo json_encode(array(
    'success' => true
  ));
} else if (isset($_GET['action']) && $_GET['action'] == 'approve') {
  // 批准评论
  if (!empty($_GET['items'])) {
    // items 格式就是以英文半角逗号分隔的 ID
    // 执行非查询语句
    execute(sprintf('update comments set status = \'approved\' where id in (%s)', $_GET['items']));
  }
  // 修改成功
  echo json_encode(array(
    'success' => true
  ));
} else if (isset($_GET['action']) && $_GET['action'] == 'reject') {
  // 拒绝评论
  if (!empty($_GET['items'])) {
    // items 格式就是以英文半角逗号分隔的 ID
    // 执行非查询语句
    execute(sprintf('update comments set status = \'rejected\' where id in (%s)', $_GET['items']));
  }
  // 修改成功
  echo json_encode(array(
    'success' => true
  ));
}
