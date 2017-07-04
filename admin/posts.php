<?php
/**
 * 后台入口
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

// 载入头部
require '../inc/admin-header.php';
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
    <li><a href="#">上一页</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">下一页</a></li>
  </ul>
</form>
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th class="text-center" width="40"><input type="checkbox"></th>
      <th>标题</th>
      <th>作者</th>
      <th>分类</th>
      <th>发表时间</th>
      <th>状态</th>
      <th class="text-center" width="100">操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>随便一个名称</td>
      <td>小小</td>
      <td>潮科技</td>
      <td>2016/10/07</td>
      <td>已发布</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>随便一个名称</td>
      <td>小小</td>
      <td>潮科技</td>
      <td>2016/10/07</td>
      <td>已发布</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>随便一个名称</td>
      <td>小小</td>
      <td>潮科技</td>
      <td>2016/10/07</td>
      <td>已发布</td>
      <td class="text-center">
        <a href="post-new.html" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
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
// 载入底部
require '../inc/admin-footer.php';
