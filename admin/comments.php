<?php
/**
 * 评论管理
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入头部
require '../inc/admin-header.php';

// 载入封装的 query 函数
require '../inc/db-helper.php';
?>
<div class="page-title">
  <h1>所有评论</h1>
</div>
<form class="form-inline">
  <!-- show when multiple checked -->
  <a id="delete" class="btn btn-danger btn-sm" href="comment-delete.php?items=" style="display: none">批量删除</a>
  <ul class="pagination pagination-sm pull-right">
    <li><a href="#">上一页</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">下一页</a></li>
  </ul>
</form>
<table id="comments" class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th class="text-center" width="40"><input type="checkbox"></th>
      <th>作者</th>
      <th>评论</th>
      <th>评论在</th>
      <th>提交于</th>
      <th>状态</th>
      <th class="text-center" width="100">操作</th>
    </tr>
  </thead>
  <tbody>
    <tr class="danger">
      <td class="text-center"><input type="checkbox"></td>
      <td>大大</td>
      <td>楼主好人，顶一个</td>
      <td>《Hello world》</td>
      <td>2016/10/07</td>
      <td>未批准</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-info btn-xs">批准</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>大大</td>
      <td>楼主好人，顶一个</td>
      <td>《Hello world》</td>
      <td>2016/10/07</td>
      <td>已批准</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-warning btn-xs">驳回</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>大大</td>
      <td>楼主好人，顶一个</td>
      <td>《Hello world》</td>
      <td>2016/10/07</td>
      <td>已批准</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-warning btn-xs">驳回</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
  </tbody>
</table>
<?php
// 定义页面标识，在 admin-footer 中辨别不同页面
$page = 'comments';
// 载入底部
require '../inc/admin-footer.php';
