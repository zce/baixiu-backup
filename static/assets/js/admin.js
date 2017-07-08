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
})
