<?php
/**
 * 后台入口
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入头部
require '../inc/admin-header.php';

// 载入封装的 query 函数
require '../inc/db-helper.php';

// 载入工具函数
require '../inc/utils.php';

// 如果是表单提交，则保存数据
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $_SESSION['current_user_id'],
    $_POST['category']
  );

  // 执行 SQL
  if (execute($sql) > 0) {
    // 跳转
    header('Location: posts.php');
    exit();
  } else {
    $message = '保存失败，请完整填写或修改 slug';
  }
}

// 查询全部分类数据
$categories = query('select * from categories');
?>
<div class="page-title">
  <h1>写文章</h1>
</div>
<?php if (isset($message)) : ?>
<div class="alert alert-danger">
  <strong>错误！</strong><?php echo $message; ?>
</div>
<?php endif; ?>
<form class="row" action="post-new.php" method="post" enctype="multipart/form-data">
  <div class="col-md-9">
    <div class="form-group">
      <label for="title">标题</label>
      <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
    </div>
    <div class="form-group">
      <label for="content">标题</label>
      <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="slug">Slug</label>
      <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
      <p class="help-block"><?php echo get_root_url(); ?>/post/<strong>slug</strong>/</p>
    </div>
    <div class="form-group">
      <label for="feature">特色图像</label>
      <!-- show when image chose -->
      <img class="help-block thumbnail" src="/static/assets/img/course.png" style="display: none">
      <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
    </div>
    <div class="form-group">
      <label for="category">所属分类</label>
      <select id="category" class="form-control" name="category">
        <?php foreach ($categories as $item) { ?>
        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="created">发布时间</label>
      <input id="created" class="form-control" name="created" type="datetime-local">
    </div>
    <div class="form-group">
      <label for="status">状态</label>
      <select id="status" class="form-control" name="status">
        <option value="draft">草稿</option>
        <option value="publish">已发布</option>
      </select>
    </div>
    <div class="form-group">
      <button class="btn btn-default" type="submit">保存草稿</button>
      <button class="btn btn-primary" type="submit">发布</button>
    </div>
  </div>
</form>
<?php
// 定义页面标识，在 admin-footer 中辨别不同页面
$page = 'post-new';
// 载入底部
require '../inc/admin-footer.php';
