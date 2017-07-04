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
<div class="jumbotron">
  <h1>Hello world</h1>
  <h2>站点内容统计：</h2>
  <p>
    <ul>
      <li><strong><?php echo $post_count; ?></strong>篇文章（<strong><?php echo $draft_count; ?></strong>篇草稿）</li>
      <li><strong><?php echo $category_count; ?></strong>个分类</li>
      <li><strong><?php echo $comment_count; ?></strong>条评论（<strong><?php echo $held_count; ?></strong>条待审核）</li>
    </ul>
  </p>
  <p><a class="btn btn-primary btn-lg" href="post-new.html" role="button">写文章</a></p>
</div>
<?php
// 载入底部
require '../inc/admin-footer.php';
