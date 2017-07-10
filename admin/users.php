<?php
/**
 * 分类管理
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'users';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

// 表单提交过来
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['email']) || empty($_POST['slug']) || empty($_POST['nickname']) || empty($_POST['password'])) {
    // 表单填写不完整
    $message = '请完整填写表单';
  } else if (empty($_POST['id'])) {
    // 没有传 ID 则代表新增
    $affected_rows = execute(sprintf(
      "insert into users values (null, '%s', '%s', '%s', '%s', NULL, 'activated', null)",
      $_POST['slug'],
      $_POST['email'],
      $_POST['password'],
      $_POST['nickname']
    ));
    if ($affected_rows != 1) {
      // 没有写入成功
      $message = '别名重复';
    }
  } else {
    // 传过来 ID 代表不是新增而是更新
    execute(sprintf(
      "update users set slug='%s', email='%s', password='%s', nickname='%s' where id=%d",
      $_POST['slug'],
      $_POST['email'],
      $_POST['password'],
      $_POST['nickname'],
      intval($_POST['id'])
    ));
  }
}

// 查询全部分类数据
$users = query('select * from users');

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
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
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)) : ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif; ?>
      <div class="row">
        <div class="col-md-4">
          <form action="users.php" method="post">
            <h2>添加新用户</h2>
            <input id="id" type="hidden" name="id">
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm btn-delete" href="user-delete.php?items=" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $item) { ?>
              <tr>
                <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id']; ?>"></td>
                <td class="text-center"><img class="avatar" src="<?php echo empty($item['avatar']) ? '/static/assets/img/monkey.png' : $item['avatar']; ?>" alt="<?php echo $item['nickname']; ?>"></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['slug']; ?></td>
                <td><?php echo $item['nickname']; ?></td>
                <td><?php echo $item['status']; ?></td>
                <td class="text-center">
                  <button class="btn btn-default btn-xs btn-edit" data-id="<?php echo $item['id']; ?>" data-email="<?php echo $item['email']; ?>" data-slug="<?php echo $item['slug']; ?>" data-nickname="<?php echo $item['nickname']; ?>" data-password="<?php echo $item['password']; ?>">编辑</button>
                  <a href="user-delete.php?items=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php require 'inc/aside.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
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

      // URL 预览
      $('#slug').on('input', function () {
        var slug = $(this).val() || 'slug'
        $(this).siblings('.help-block').children().text(slug)
      })

      // 编辑分类
      $('.btn-edit').on('click', function () {
        $('form #id').val($(this).data('id'))
        $('form #email').val($(this).data('email'))
        $('form #slug').val($(this).data('slug')).trigger('input')
        $('form #nickname').val($(this).data('nickname'))
        $('form #password').val($(this).data('password'))
        $('form button').text('保存')
        $('form h2').text('编辑分类')
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
