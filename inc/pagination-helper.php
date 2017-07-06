<?php
/**
 * 数据库常用操作封装
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

/**
 * 输出分页链接
 * @param  Integer $page    当前页码
 * @param  Integer $total   总页数
 * @param  String  $format  链接模板，%d 会被替换为具体页数
 * @param  Integet $visible 可见页码数量（可选参数，默认为 5）
 * @example
 *   <?php pagination(2, 10, '/list?page=%d', 5); ?>
 */
function pagination ($page, $total, $format, $visible = 5) {
  // 计算起始页码
  // 当前页左侧应有几个页码数，如果一共是 5 个，则左边是 2 个，右边是两个
  $left = floor($visible / 2);
  // 开始页码
  $begin = $page - $left;
  // 确保开始不能小于 1
  $begin = $begin < 1 ? 1 : $begin;
  // 结束页码
  $end = $begin + $visible - 1;
  // 确保结束不能大于最大值 $total
  $end = $end > $total ? $total : $end;
  // 如果 $end 变了，$begin 也要跟着一起变
  $begin = $end - $visible + 1;
  // 确保开始不能小于 1
  $begin = $begin < 1 ? 1 : $begin;

  // 上一页
  if ($page - 1 > 0) {
    printf('<li><a href="%s">上一页</a></li>', sprintf($format, $page - 1));
  }

  // 数字页码
  for ($i = $begin; $i <= $end; $i++) {
    // 经过以上的计算 $i 的类型可能是 float 类型，所以此处用 == 比较合适
    $activeClass = $i == $page ? ' class="active"' : '';
    printf('<li%s><a href="%s">%d</a></li>', $activeClass, sprintf($format, $i), $i);
  }

  // 下一页
  if ($page + 1 <= $total) {
    printf('<li><a href="%s">下一页</a></li>', sprintf($format, $page + 1));
  }
}
