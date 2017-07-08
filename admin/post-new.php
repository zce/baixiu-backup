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

// 文章总数
$post_count = query('select count(1) from posts')[0][0];

// 草稿总数
$draft_count = query('select count(1) from posts where status = \'drafted\'')[0][0];

// 分类总数
$category_count = query('select count(1) from categories')[0][0];

// 评论总数
$comment_count = query('select count(1) from comments')[0][0];

// 待审核的评论总数
$held_count = query('select count(1) from comments where status = \'held\'')[0][0];
?>
<div class="page-title">
  <h1>写文章</h1>
</div>
<form class="row" action="#" method="post">
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
      <p class="help-block">https://zce.me/post/<strong>slug</strong>/</p>
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
        <option value="1">未分类</option>
        <option value="2">潮生活</option>
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
