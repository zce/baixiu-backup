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
        <li class="active">
          <a href="index.html"><i class="glyphicon glyphicon-dashboard"></i>仪表盘</a>
        </li>
        <li>
          <a href="#posts-sub" class="collapsed" data-toggle="collapse">
            <i class="glyphicon glyphicon-pushpin"></i>文章<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="posts-sub" class="list-unstyled collapse">
            <li><a href="posts.html">所有文章</a></li>
            <li><a href="post-new.html">写文章</a></li>
            <li><a href="categories.html">分类目录</a></li>
          </ul>
        </li>
        <li>
          <a href="comments.html"><i class="glyphicon glyphicon-comment"></i>评论</a>
        </li>
        <li>
          <a href="users.html"><i class="glyphicon glyphicon-user"></i>用户</a>
        </li>
        <li>
          <a href="#settings-sub" class="collapsed" data-toggle="collapse">
            <i class="glyphicon glyphicon-cog"></i>设置<i class="arrow glyphicon glyphicon-chevron-right"></i>
          </a>
          <ul id="settings-sub" class="list-unstyled collapse">
            <li><a href="nav-menus.html">导航菜单</a></li>
            <li><a href="slides.html">图片轮播</a></li>
            <li><a href="settings.html">网站设置</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <script src="/static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
