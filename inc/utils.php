<?php
/**
 * 工具函数
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

/**
 * 获取当前访问网站的根 URL
 * @return String 网站的根 URL
 */
function get_root_url () {
  $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
  $url .= $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
  return $url;
}
