<?php
/**
 * 删除分类
 */

require '../functions.php';

if (!empty($_GET['items'])) {
  // items 格式就是以英文半角逗号分隔的 ID
  // 执行非查询语句
  execute(sprintf('delete from categories where id in (%s)', $_GET['items']));
}

// 获取删除后跳转到的目标链接，优先跳转到来源页面，否则跳转到文章列表
$target = empty($_SERVER['HTTP_REFERER']) ? '/admin/categories.php' : $_SERVER['HTTP_REFERER'];
header('Location: ' . $target);
