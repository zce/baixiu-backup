<?php
/**
 * 分页获取评论数据 JSON
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入封装的 query 函数
require '../inc/db-helper.php';

// 设置响应类型为 JSON
header('Content-Type: application/json');

// 获取 querystring 中的 page 参数
// 没有的话 默认为 1
$page = isset($_GET['page']) ? $_GET['page'] : '1';
// 转换为整数类型
$page = intval($page) !== 0 ? intval($page) : 1;

// 定义每页显示的数量
$size = 2;

// 查询总条数
$total_count = intval(query('select count(1) from comments')[0][0]);

// 计算总页数
$total_pages = ceil($total_count / $size);

// 检查 $page 范围
if ($page <= 0 || $page > $total_pages) {
  // 肯定不存在的页码，没有必要继续执行了
  // 清空响应流
  ob_clean();
  // 设置 404 状态码
  http_response_code(404);
  // 界面提示
  echo json_encode(array(
    'success' => false,
    'message' => 'Not found'
  ));
  // 结束执行
  exit();
}

$sql = 'select comments.*, posts.title as post_title from comments
inner join posts on comments.post_id = posts.id
order by comments.created desc
limit ' . ($page - 1) * $size . ', ' . $size;

$comments = query($sql);

echo json_encode(array(
  'success' => true,
  'data' => $comments,
  'total_count' => $total_count
));
