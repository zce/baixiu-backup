<?php
/**
 * 添加分类
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

require '../inc/db-helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['id']) && intval($_POST['id']) != 0) {
    // 传过来 ID 代表不是新增而是更新
    $sql = sprintf("update categories set slug='%s', name='%s' where id=%d", $_POST['slug'], $_POST['name'], intval($_POST['id']));
  } else {
    // 新增
    $sql = sprintf("insert into categories values (null, '%s', '%s', null)", $_POST['slug'], $_POST['name']);
  }
  // 执行
  execute($sql);
}

// 获取删除后跳转到的目标链接，优先跳转到来源页面，否则跳转到文章列表
$target = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'categories.php';
// 跳转
header('Location: ' . $target);
