<?php
/**
 * 后台入口
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入头部
require '../inc/admin-header.php';

// 载入数据操作函数
require '../inc/db-helper.php';

// 获取 querystring 中的 page 参数
// 没有的话 默认为 1
$page = isset($_GET['page']) ? $_GET['page'] : '1';
// 转换为整数类型
$page = intval($page) !== 0 ? intval($page) : 1;

// 定义每页显示的数量
$size = 10;

// 查询总条数
$total_count = intval(query('select count(1) from posts')[0][0]);

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
  echo '<h1>404 Not Found</h1>';
  // 结束执行
  exit();
}

$sql = 'select
  posts.id,
  posts.title,
  posts.created,
  posts.status,
  categories.name as category_name,
  users.nickname as author_name
from posts
inner join users on posts.user_id = users.id
inner join categories on posts.category_id = categories.id
limit ' . ($page - 1) * $size . ', ' . $size;

// 查询全部文章数据
$posts = query($sql);

/**
 * 将英文状态描述转换为中文
 * @param  String $status 英文状态
 * @return String         中文状态
 */
function convert_status ($status) {
  switch ($status) {
    case 'drafted':
      return '草稿';
    case 'published':
      return '已发布';
    case 'trashed':
      return '回收站';
    default:
      return '未知';
  }
}

/**
 * 格式化日期
 * @param  String $created 时间字符串
 * @return String          格式化后的时间字符串
 */
function format_date ($created) {
  // 设置默认时区！！！
  date_default_timezone_set('UTC');
  // 转换为时间戳
  $timestamp = strtotime($created);
  // 格式化并返回
  return date('Y年m月d日 <b\r> H:i:s', $timestamp);
}
?>
<div class="page-title">
  <h1>所有文章</h1>
  <a href="post-new.html" class="btn btn-primary btn-xs">写文章</a>
  <div class="input-group pull-right">
    <input type="text" class="form-control" placeholder="搜索文章标题">
    <span class="input-group-btn">
      <button class="btn btn-default" type="button">搜索</button>
    </span>
  </div>
</div>
<form class="form-inline" action="">
  <select name="" class="form-control input-sm">
    <option value="">批量操作</option>
    <option value="">删除</option>
  </select>
  <button class="btn btn-default btn-sm">应用</button>
  <select name="" class="form-control input-sm">
    <option value="">所有分类</option>
    <option value="">未分类</option>
  </select>
  <select name="" class="form-control input-sm">
    <option value="">所有状态</option>
    <option value="">草稿</option>
    <option value="">已发布</option>
  </select>
  <button class="btn btn-default btn-sm">筛选</button>
  <ul class="pagination pagination-sm pull-right">
    <?php if ($page - 1 > 0) : ?>
    <li><a href="?page=<?php echo $page - 1; ?>">上一页</a></li>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
    <li<?php echo $i === $page ? ' class="active"' : '' ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
    <?php endfor; ?>
    <?php if ($page + 1 <= $total_pages) : ?>
    <li><a href="?page=<?php echo $page + 1; ?>">下一页</a></li>
    <?php endif; ?>
  </ul>
</form>
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th class="text-center" width="40"><input type="checkbox"></th>
      <th>标题</th>
      <th>作者</th>
      <th>分类</th>
      <th class="text-center">发表时间</th>
      <th class="text-center">状态</th>
      <th class="text-center" width="100">操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($posts as $i => $item) { ?>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td><?php echo $item['title']; ?></td>
      <td><?php echo $item['author_name']; ?></td>
      <td><?php echo $item['category_name']; ?></td>
      <td class="text-center"><?php echo format_date($item['created']); ?></td>
      <td class="text-center"><?php echo convert_status($item['status']); ?></td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<form class="form-inline" action="">
  <select name="" class="form-control input-sm">
    <option value="">批量操作</option>
    <option value="">删除</option>
  </select>
  <button class="btn btn-default btn-sm">应用</button>
  <select name="" class="form-control input-sm">
    <option value="">所有分类</option>
    <option value="">未分类</option>
  </select>
  <select name="" class="form-control input-sm">
    <option value="">所有状态</option>
    <option value="">草稿</option>
    <option value="">已发布</option>
  </select>
  <button class="btn btn-default btn-sm">筛选</button>
  <ul class="pagination pagination-sm pull-right">
    <li><a href="#">上一页</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">下一页</a></li>
  </ul>
</form>
<?php
$page = 'posts';
// 载入底部
require '../inc/admin-footer.php';
