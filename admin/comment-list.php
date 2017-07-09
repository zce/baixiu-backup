<?php
/**
 * 分页获取评论数据 JSON
 * TODO: 访问控制
 */

// 载入封装的 query 函数
require '../functions.php';

// 设置响应类型为 JSON
header('Content-Type: application/json');

// 定义每页显示的数量
$size = isset($_GET['s']) ? intval($_GET['s']) : 10;

// 获取page 参数 没有的话 默认为 1
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;

// 查询总条数
$total_count = intval(query('select count(1) from comments inner join posts on comments.post_id = posts.id')[0][0]);

// 计算总页数
$total_pages = ceil($total_count / $size);

// 检查 $page 范围
if ($page <= 0) {
  // 跳转到第一页
  header('Location: /admin/comment-list.php?p=1' . $query);
  exit;
}
if ($page > $total_pages) {
  // 跳转到最后一页
  header('Location: /admin/comment-list.php?p=' . $total_pages . $query);
  exit;
}

// 执行查询
$comments = query('select comments.*, posts.title as post_title from comments
inner join posts on comments.post_id = posts.id
order by comments.created desc
limit ' . ($page - 1) * $size . ', ' . $size);

// output json
echo json_encode(array(
  'success' => true,
  'data' => $comments,
  'total_count' => $total_count
));
