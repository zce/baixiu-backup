<?php
/**
 * 轮播管理
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'slides';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
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
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" name="image" type="hidden">
              <input id="upload" class="form-control" type="file">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
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
                <th class="text-center">图片</th>
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

  <script id="slide_tmpl" type="text/x-jsrender">
    <tr>
      <td class="text-center"><img class="slide" src="{{: image }}"></td>
      <td>{{: title }}</td>
      <td>{{: link }}</td>
      <td class="text-center">
        <button class="btn btn-danger btn-xs btn-delete" data-index="{{: #index }}">删除</button>
      </td>
    </tr>
  </script>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script>
    $(function () {
      var slides = []

      function load () {
        $.get('/admin/options.php', { key: 'home_slides' }, function (res) {
          if (!res.success) {
            $('.alert').text('获取数据失败').fadeIn()
            return
          }
          try {
            slides = JSON.parse(res.data)
            var html = $('#slide_tmpl').render(slides)
            $('table > tbody').html(html)
          } catch (e) {
            slides = []
            console.log('parse "' + res.data + '" failed')
          }
        });
      }

      // 获取已有数据
      load()

      // 异步上传文件
      $('#upload').on('change', function () {
        // 选择文件后异步上传文件
        var formData = new FormData()
        formData.append('file', $(this).prop('files')[0])
        $.ajax({
          url: '/admin/upload.php',
          cache: false,
          contentType: false,
          processData: false,
          data: formData,
          type: 'post',
          success: function (res) {
            if (res.success) {
              $('#image').val(res.data).siblings('.help-block').attr('src', res.data).fadeIn()
            } else {
              $('#image').val('').siblings('.help-block').fadeOut()
              $('.alert').text('上传文件失败').fadeIn()
            }
          }
        })
      })

      // 新增
      $('.btn-save').on('click', function () {
        $('.alert').empty().fadeOut()

        slides.push({
          image: $('#image').val(),
          title: $('#title').val(),
          link: $('#link').val()
        })

        $.post('/admin/options.php', { key: 'home_slides', value: JSON.stringify(slides) }, function (res) {
          if (res.success) {
            // 再次加载
            load()
            $('#image').val('').siblings('.help-block').fadeOut()
            $('#title').val('')
            $('#link').val('')
          } else {
            $('.alert').text('保存失败，请重试').fadeIn()
          }
        })
      })

      // 删除
      $('table > tbody').on('click', '.btn-delete', function (e) {
        slides.splice(parseInt($(this).data('index')), 1)
         $.post('/admin/options.php', { key: 'home_slides', value: JSON.stringify(slides) }, function (res) {
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
