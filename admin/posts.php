<?php
/**
 * 文章列表
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'posts';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

// 处理筛选逻辑
// ==================================================

// 筛选条件（默认为 1 = 1，相当于没有条件）
$where = '1 = 1';
$query = '';

// 处理分类筛选参数
if (!empty($_GET['c']) && $_GET['c'] != 'all') {
  $where .= ' and posts.category_id = ' . $_GET['c'];
  $query .= '&c=' . $_GET['c'];
}

// 状态筛选参数
if (!empty($_GET['s']) && $_GET['s'] != 'all') {
  $where .= ' and posts.status = \'' . $_GET['s'] . '\'';
  $query .= '&s=' . $_GET['s'];
}

// 处理分页
// ==================================================

// 定义每页显示的数量
$size = 10;

// 获取page 参数 没有的话 默认为 1
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;

// 查询总条数
$total_count = intval(query('select count(1) from posts where ' . $where)[0][0]);

// 计算总页数
$total_pages = ceil($total_count / $size);

// 检查 $page 范围
if ($page <= 0) {
  // 跳转到第一页
  header('Location: /admin/posts.php?p=1' . $query);
  exit;
}
if ($page > $total_pages) {
  // 跳转到最后一页
  header('Location: /admin/posts.php?p=' . $total_pages . $query);
  exit;
}

// 查询数据
// ==================================================

// 查询文章数据
$posts = query('select
  posts.id,
  posts.title,
  posts.created,
  posts.status,
  categories.name as category_name,
  users.nickname as author_name
from posts
inner join users on posts.user_id = users.id
inner join categories on posts.category_id = categories.id
where ' . $where . '
order by posts.created desc
limit ' . ($page - 1) * $size . ', ' . $size);

// 查询全部分类数据
$categories = query('select * from categories');

// 转换函数
// ==================================================

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
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="logout.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm btn-delete" href="post-delete.php?items=" style="display: none">批量删除</a>
        <form class="form-inline" action="posts.php" method="get">
          <select name="c" class="form-control input-sm">
            <option value="all">所有分类</option>
            <?php foreach ($categories as $item) { ?>
            <option value="<?php echo $item['id']; ?>"<?php echo isset($_GET['c']) && $_GET['c'] == $item['id'] ? ' selected' : ''; ?>>
              <?php echo $item['name']; ?>
            </option>
            <?php } ?>
          </select>
          <select name="s" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted"<?php echo isset($_GET['s']) && $_GET['s'] == 'drafted' ? ' selected' : ''; ?>>草稿</option>
            <option value="published"<?php echo isset($_GET['s']) && $_GET['s'] == 'published' ? ' selected' : ''; ?>>已发布</option>
            <option value="trashed"<?php echo isset($_GET['s']) && $_GET['s'] == 'trashed' ? ' selected' : ''; ?>>回收站</option>
          </select>
          <button type="submit" class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <?php pagination($page, $total_pages, '?p=%d' . $query); ?>
        </ul>
      </div>
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
          <?php foreach ($posts as $item) { ?>
          <tr>
            <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id']; ?>"></td>
            <td><?php echo $item['title']; ?></td>
            <td><?php echo $item['author_name']; ?></td>
            <td><?php echo $item['category_name']; ?></td>
            <td class="text-center"><?php echo format_date($item['created']); ?></td>
            <td class="text-center"><?php echo convert_status($item['status']); ?></td>
            <td class="text-center">
              <a href="post-edit.php?item=<?php echo $item['id']; ?>" class="btn btn-default btn-xs">编辑</a>
              <a href="post-delete.php?items=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php require 'inc/aside.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script>
    $(function () {
      var $tdCheckbox = $('td > input[type=checkbox]')
      var $thCheckbox = $('th > input[type=checkbox]')
      var $btnDelete = $('.btn-delete')

      $tdCheckbox.on('change', function () {
        // 要删除的文章 ID
        var items = []
        // 找到每一个选中的文章
        $tdCheckbox.each(function (i, item) {
          if ($(item).prop('checked')) {
            // 通过 checkbox 上的 data-id 获取到当前对应的文章 ID
            var id = parseInt($(item).data('id'))
            id && items.push(id)
          }
        })
        // 有选中就显示，没选中就隐藏
        items.length ? $btnDelete.fadeIn() : $btnDelete.fadeOut()
        // 批量删除按钮链接参数
        $btnDelete.prop('search', '?items=' + items.join(','))
      })

      // 全选 / 全不选
      $thCheckbox.on('change', function () {
        var checked = $(this).prop('checked')
        $tdCheckbox.prop('checked', checked).trigger('change')
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
