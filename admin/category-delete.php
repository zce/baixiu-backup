<?php
/**
 * 删除分类
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

require '../inc/db-helper.php';

if (isset($_GET['items']) && $items = $_GET['items']) {
  // items 格式就是以英文半角逗号分隔的 ID
  $sql = sprintf('delete from categories where id in (%s)', $items);
  // 执行非查询语句
  execute($sql);
}

// 获取删除后跳转到的目标链接，优先跳转到来源页面，否则跳转到文章列表
$target = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'categories.php';
// 跳转
header('Location: ' . $target);
