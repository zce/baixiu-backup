<?php
/**
 * 导航菜单管理
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'nav-menus';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
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
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display: none;"></div>
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <label for="icon">图标 Class</label>
              <input id="icon" class="form-control" name="icon" type="text" placeholder="图标 Class">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="href">链接</label>
              <input id="href" class="form-control" name="href" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-save" type="button">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="post-delete.php?items=" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php require 'inc/aside.php'; ?>

  <script id="menu_tmpl" type="text/x-jsrender">
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td><i class="{{: icon }}"></i>{{: text }}</td>
      <td>{{: title }}</td>
      <td>{{: href }}</td>
      <td class="text-center">
        <a class="btn btn-danger btn-xs btn-delete" data-index="{{: #index }}">删除</a>
      </td>
    </tr>
  </script>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script>
    $(function () {
      var menus

      function load () {
        $.get('/admin/options.php', { key: 'nav_menus' }, function (res) {
          if (!res.success) {
            $('.alert').text('获取数据失败').fadeIn()
            return
          }
          try {
            menus = JSON.parse(res.data)
            var html = $('#menu_tmpl').render(menus)
            $('table > tbody').html(html)
          } catch (e) {
            menus = []
            console.log('parse "' + res.data + '" failed')
          }
        });
      }

      // 获取已有数据
      load()

      // 新增
      $('.btn-save').on('click', function () {
        $('.alert').empty().fadeOut()

        menus.push({
          icon: $('#icon').val(),
          text: $('#text').val(),
          title: $('#title').val(),
          href: $('#href').val()
        })

        $.post('/admin/options.php', { key: 'nav_menus', value: JSON.stringify(menus) }, function (res) {
          if (res.success) {
            // 再次加载
            load()
            $('#icon').val('')
            $('#text').val('')
            $('#title').val('')
            $('#href').val('')
          } else {
            $('.alert').text('保存失败，请重试').fadeIn()
          }
        })
      })

      // 删除
      $('table > tbody').on('click', '.btn-delete', function (e) {
        menus.splice(parseInt($(this).data('index')), 1)
         $.post('/admin/options.php', { key: 'nav_menus', value: JSON.stringify(menus) }, function (res) {
          if (res.success) {
            // 再次加载
            load()
          } else {
            $('.alert').text('保存失败，请重试').fadeIn()
          }
        })
      })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
