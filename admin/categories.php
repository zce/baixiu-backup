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

require '../inc/utils.php';

// 查询全部分类数据
$categories = query('select * from categories');
?>
<div class="page-title">
  <h1>分类目录</h1>
</div>
<div class="row">
  <div class="col-md-4">
    <form id="form_category" action="category-new.php" method="post">
      <h2>添加新分类目录</h2>
      <input id="id" type="hidden" name="id" >
      <div class="form-group">
        <label for="name">名称</label>
        <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
      </div>
      <div class="form-group">
        <label for="slug">Slug</label>
        <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
        <p class="help-block"><?php echo get_root_url(); ?>/category/<strong>slug</strong>/</p>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">添加</button>
      </div>
    </form>
  </div>
  <div class="col-md-8">
    <form class="form-inline">
      <!-- show when multiple checked -->
      <a id="delete" class="btn btn-danger btn-sm" href="category-delete.php?items=" style="display: none">批量删除</a>
    </form>
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th class="text-center" width="40"><input type="checkbox"></th>
          <th>名称</th>
          <th>Slug</th>
          <th class="text-center" width="100">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $item) { ?>
        <tr>
          <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id']; ?>"></td>
          <td><?php echo $item['name']; ?></td>
          <td><?php echo $item['slug']; ?></td>
          <td class="text-center">
            <button class="btn btn-info btn-xs edit-cat" data-id="<?php echo $item['id']; ?>" data-slug="<?php echo $item['slug']; ?>" data-name="<?php echo $item['name']; ?>">编辑</button>
            <a href="category-delete.php?items=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php
// 定义页面标识，在 admin-footer 中辨别不同页面
$page = 'categories';
// 载入底部
require '../inc/admin-footer.php';
