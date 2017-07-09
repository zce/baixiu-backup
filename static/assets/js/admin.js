$(function ($) {
  var $tdCheckbox = $('td > input[type=checkbox]')
  var $thCheckbox = $('th > input[type=checkbox]')
  var $btnDelete = $('#delete')

  $tdCheckbox.on('change', function () {
    // 要删除的文章 ID
    var items = []
    // 找到每一个选中的文章
    $tdCheckbox.each(function (i, item) {
      if ($(item).prop('checked')) {
        // 通过 checkbox 上的 data-id 获取到当前对应的文章 ID
        var id = parseInt($(item).data('id'))
        id && items.push(id)
      }
    })
    // 有选中就显示，没选中就隐藏
    items.length ? $btnDelete.fadeIn() : $btnDelete.fadeOut()
    // 批量删除按钮链接参数
    $btnDelete.prop('search', '?items=' + items.join(','))
  })

  // 全选 / 全不选
  $thCheckbox.on('change', function () {
    var checked = $(this).prop('checked')
    $tdCheckbox.prop('checked', checked).trigger('change')
  })

  // Markdown 编辑器
  var editor = document.getElementById('content')
  editor && new SimpleMDE({
    element: editor,
    spellChecker: false
  })

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

  // 编辑分类
  $('.edit-cat').on('click', function () {
    $('#form_category #id').val($(this).data('id'))
    $('#form_category #slug').val($(this).data('slug')).trigger('input')
    $('#form_category #name').val($(this).data('name'))
    $('#form_category button').text('保存')
  })

  // 评论
  var $comments = $('#comments > tbody');
  if ($comments.length) {
    // AJAX 获取全部评论信息
    $.get('comment-list.php', { page: 1 }, function (res) {
      $comments.empty()
      if (!res.success) {
        $comments.append('<tr><td class="text-center" colspan="7">' + res.message + '</td></tr>')
        return
      }

      $(res.data).each(function (i, item) {
        var className = ''
        var status = ''
        switch (item.status) {
          case 'held':
            className = 'warning'
            status = '待审核'
            break
          case 'approved':
            className = 'success'
            status = '已批准'
            break
          case 'rejected':
            className = 'danger'
            status = '已拒绝'
            break
        }
        var tr = '<tr class="' + className + '">' +
                 '  <td class="text-center"><input type="checkbox"></td>' +
                 '  <td>' + item.author + '</td>' +
                 '  <td>' + item.content + '</td>' +
                 '  <td>《' + item.post_title + '》</td>' +
                 '  <td>' + item.created + '</td>' +
                 '  <td>' + status + '</td>' +
                 '  <td class="text-center">' +
                 '    <a href="post-new.html" class="btn btn-warning btn-xs">驳回</a>' +
                 '    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>' +
                 '  </td>'
                 '</tr>'
        $comments.append(tr)
      })
    })
  }
})
