<?php
/**
 * 数据库常用操作封装
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

/**
 * 输出分页链接
 * @param  Integer $page   当前页码
 * @param  Integer $total  总页数
 * @param  String  $format 链接模板，%d 会被替换为具体页数
 */
function pagination ($page, $total, $format) {
  // 上一页
  if ($page - 1 > 0) {
    printf('<li><a href="%s">上一页</a></li>', sprintf($format, $page - 1));
  }

  // 数字页码
  for ($i = 1; $i <= $total; $i++) {
    $activeClass = $i === $page ? ' class="active"' : '';
    printf('<li%s><a href="%s">%d</a></li>', $activeClass, sprintf($format, $i), $i);
  }

  // 下一页
  if ($page + 1 <= $total) {
    printf('<li><a href="%s">下一页</a></li>', sprintf($format, $page + 1));
  }
}
