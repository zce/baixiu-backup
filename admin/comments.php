<?php
/**
 * 评论管理
 */

require '../functions.php';

// 定义当前页面标识变量，用于在 `aside.php` 文件中区分
$current_page = 'comments';

// 获取当前登录用户（登录状态检查）
$current_user = get_user_info();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right"></ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="140">操作</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <?php require 'inc/aside.php'; ?>

  <script id="comment-tmpl" type="text/x-jsrender">
    {{if success}}
    {{for data}}
    <tr class="{{: status === 'held' ? 'warning' : status === 'rejected' ? 'danger' : '' }}">
      <td class="text-center"><input type="checkbox" data-id="{{: id }}"></td>
      <td>{{: author }}</td>
      <td>{{: content }}</td>
      <td>《{{: post_title }}》</td>
      <td>{{: created}}</td>
      <td>{{: status === 'held' ? '待审' : status === 'rejected' ? '拒绝' : '准许' }}</td>
      <td class="text-center">
        {{if status ===  'held'}}
        <button class="btn btn-info btn-xs" data-id="{{: id }}">批准</button>
        <button class="btn btn-warning btn-xs" data-id="{{: id }}">拒绝</button>
        {{/if}}
        <button class="btn btn-danger btn-xs" data-id="{{: id }}">删除</button>
      </td>
    </tr>
    {{/for}}
    {{else}}
    <tr>
      <td colspan="7">{{: message }}</td>
    </tr>
    {{/if}}
  </script>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script>
    var $pagination = $('.pagination')
    var $commentTmpl = $('#comment-tmpl')
    var $tbody = $('table > tbody')
    var $btnBatch = $('.btn-batch')
    var selectedItems = []
    var currentPage = parseInt(window.localStorage.getItem('last_comments_page')) || 1
    var paginationOptions = {
      first: false,
      prev: '&laquo;',
      next: '&raquo;',
      last: false,
      startPage: currentPage,
      totalPages: 100,
      onPageClick: function (event, page) {
        currentPage = page
        window.localStorage.setItem('last_comments_page', currentPage)
        load()
      }
    }

    function load () {
      var size = 20
      $.get('/admin/comment-list.php', { p: currentPage, s: size }, function (res) {
        // 分页组件()
        paginationOptions.totalPages = Math.ceil(res.total_count / size)
        $pagination.twbsPagination(paginationOptions)
        // 模板引擎渲染
        var html = $commentTmpl.render(res)
        $tbody.html(html)
        $('th > input[type=checkbox]').trigger('change')
      })
    }

    $(function () {
      // 第一次获取数据
      load()

      // approve / reject / delete / select
      $tbody
        .on('click', '.btn-info', function (e) {
          $.get('/admin/comment-edit.php', { action: 'approve', items: $(e.target).data('id') }, function (res) {
            res.success && load()
          })
        })
        .on('click', '.btn-warning', function (e) {
          $.get('/admin/comment-edit.php', { action: 'reject', items: $(e.target).data('id') }, function (res) {
            res.success && load()
          })
        })
        .on('click', '.btn-danger', function (e) {
          $.get('/admin/comment-edit.php', { action: 'delete', items: $(e.target).data('id') }, function (res) {
            res.success && load()
          })
        })
        .on('change', 'input[type=checkbox]', function (e) {
          if ($(e.target).prop('checked')) {
            selectedItems.push($(e.target).data('id'))
          } else {
            selectedItems.splice(selectedItems.indexOf($(e.target).data('id')), 1)
          }
          selectedItems.length ? $btnBatch.fadeIn() : $btnBatch.fadeOut()
        })

      // 全选 / 全不选
      $('th > input[type=checkbox]').on('change', function () {
        var checked = $(this).prop('checked')
        $('td > input[type=checkbox]').prop('checked', checked).trigger('change')
      })

      // 批量操作
      $btnBatch
        .on('click', '.btn-info', function (e) {
          $.get('/admin/comment-edit.php', { action: 'approve', items: selectedItems.join(',') }, function (res) {
            res.success && load()
          })
        })
        .on('click', '.btn-warning', function (e) {
          $.get('/admin/comment-edit.php', { action: 'reject', items: selectedItems.join(',') }, function (res) {
            res.success && load()
          })
        })
        .on('click', '.btn-danger', function (e) {
          $.get('/admin/comment-edit.php', { action: 'delete', items: selectedItems.join(',') }, function (res) {
            res.success && load()
          })
        })
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
