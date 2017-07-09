<?php
/**
 * 分类管理
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'post-add';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

// 如果是表单提交，则保存数据
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['slug']) || empty($_POST['title']) || empty($_POST['created']) || empty($_POST['content']) || empty($_POST['status']) || empty($_POST['category'])) {
    // 表单元素存在空
    $message = '请完整填写所有内容';
  } else if (query(sprintf("select count(1) from posts where slug = '%s'", $_POST['slug']))[0][0] > 0) {
    // slug 已经存在
    $message = '别名已经存在';
  } else {
    // 接收文件
    $feature = null;
    if (isset($_FILES['feature']) && $_FILES['feature']['size']) {
      // 保存文件到上传目录
      if (move_uploaded_file($_FILES['feature']['tmp_name'], '../static/uploads/' . $_FILES['feature']['name'])) {
        $feature = '/static/uploads/' . $_FILES['feature']['name'];
      }
    }

    // 接收其他参数拼接 SQL
    $sql = sprintf(
      "insert into posts values (null, '%s', '%s', '%s', '%s', '%s', '%s', null, %d, %d)",
      $_POST['slug'],
      $_POST['title'],
      $feature,
      $_POST['created'],
      $_POST['content'],
      $_POST['status'],
      $current_user['id'],
      $_POST['category']
    );

    // 执行 SQL
    if (execute($sql) > 0) {
      // 跳转
      header('Location: /admin/posts.php');
      exit();
    } else {
      $message = '保存失败，请重试';
    }
  }
}

// 查询全部分类数据
$categories = query('select * from categories');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/simplemde/simplemde.min.css">
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)) : ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif; ?>
      <form class="row" action="post-add.php" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"><?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" value="<?php echo isset($_POST['slug']) ? $_POST['slug'] : ''; ?>" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong><?php echo isset($_POST['slug']) ? $_POST['slug'] : 'slug'; ?></strong>/</p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file" placeholder="feature">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <?php foreach ($categories as $item) { ?>
              <option value="<?php echo $item['id']; ?>"<?php echo isset($_POST['category']) && $_POST['category'] == $item['id'] ? ' selected' : ''; ?>><?php echo $item['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" value="<?php echo isset($_POST['created']) ? $_POST['created'] : ''; ?>">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted"<?php echo isset($_POST['status']) && $_POST['status'] == 'drafted' ? ' selected' : ''; ?>>草稿</option>
              <option value="published"<?php echo isset($_POST['status']) && $_POST['status'] == 'published' ? ' selected' : ''; ?>>已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php require 'inc/aside.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/simplemde/simplemde.min.js"></script>
  <script>
    // 本地图片预览
    $('#feature').on('change', function () {
      // 为选中的文件对象创建一个临时的 URL
      var url = window.URL.createObjectURL(this.files[0])
      // 显示这个图片
      $(this).siblings('.help-block').attr('src', url).fadeIn()
    })

    // URL 预览
    $('#slug').on('input', function () {
      var slug = $(this).val() || 'slug'
      $(this).siblings('.help-block').children().text(slug)
    })

    new SimpleMDE({
      element: $('#content')[0],
      // 拼写检查
      spellChecker: false,
      // 禁止下载在线 font-awesome
      autoDownloadFontAwesome: false
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
