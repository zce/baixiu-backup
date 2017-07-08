<?php
/**
 * 后台公共底部区域代码
 *
 * @since   0.1.0 初始化
 * @version 0.1.0 初始化
 */

?>
      </div>
    </div>
  </div>

  <div class="aside">
    <div class="profile">
      <div class="avatar img-circle"><img src="/static/uploads/avatar.jpg"></div>
      <h4>布头儿</h4>
    </div>
    <div class="nav">
      <ul class="list-unstyled">
        <li<?php echo $page === 'dashboard' ? ' class="active"' : '' ?>>
          <a href="index.php"><i class="glyphicon glyphicon-dashboard"></i>仪表盘</a>
        </li>
        <li<?php echo in_array($page, array('posts', 'post-new', 'categories')) ? ' class="active"' : '' ?>>
          <a href="#posts-sub"<?php echo in_array($page, array('posts', 'post-new', 'categories')) ? '' : ' class="collapsed"' ?> data-toggle="collapse">
            <i class="glyphicon glyphicon-pushpin"></i>文章<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="posts-sub" class="list-unstyled collapse<?php echo in_array($page, array('posts', 'post-new', 'categories')) ? ' in' : '' ?>">
            <li<?php echo $page === 'posts' ? ' class="active"' : '' ?>><a href="posts.php">所有文章</a></li>
            <li<?php echo $page === 'post-new' ? ' class="active"' : '' ?>><a href="post-new.php">写文章</a></li>
            <li<?php echo $page === 'categories' ? ' class="active"' : '' ?>><a href="categories.php">分类目录</a></li>
          </ul>
        </li>
        <li<?php echo $page === 'comments' ? ' class="active"' : '' ?>>
          <a href="comments.php"><i class="glyphicon glyphicon-comment"></i>评论</a>
        </li>
        <li<?php echo $page === 'users' ? ' class="active"' : '' ?>>
          <a href="users.php"><i class="glyphicon glyphicon-user"></i>用户</a>
        </li>
        <li<?php echo in_array($page, array('nav-menus', 'slides', 'settings')) ? ' class="active"' : '' ?>>
          <a href="#settings-sub"<?php echo in_array($page, array('nav-menus', 'slides', 'settings')) ? '' : ' class="collapsed"' ?> data-toggle="collapse">
            <i class="glyphicon glyphicon-cog"></i>设置<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="settings-sub" class="list-unstyled collapse<?php echo in_array($page, array('nav-menus', 'slides', 'settings')) ? ' in' : '' ?>">
            <li<?php echo $page === 'nav-menus' ? ' class="active"' : '' ?>><a href="nav-menus.php">导航菜单</a></li>
            <li<?php echo $page === 'slides' ? ' class="active"' : '' ?>><a href="slides.php">图片轮播</a></li>
            <li<?php echo $page === 'settings' ? ' class="active"' : '' ?>><a href="settings.php">网站设置</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <script src="/static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script src="/static/assets/js/admin.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
