<div class="site-menubar">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu" data-plugin="menu">
          <li class="site-menu-category">Menu</li>
          <li class="site-menu-item has-sub">
            <a href="<?= base_url('dashboard'); ?>">
              <i class="site-menu-icon fa-tachometer" aria-hidden="true"></i>
              <span class="site-menu-title">Dashboard</span>
            </a>
          </li>
          <?php
          $roleid = $user['role_id'];
          if ($roleid == 14 || $roleid == 15) {
            include('menu_inventor.php');
            include('menu_verifikasi.php');
            include('menu_kasatker.php');
            include('menu_admin.php');
          }
          ?>

          <?php
          $roleid = $user['role_id'];
          if ($roleid == 16) {
            include('menu_kasatker.php');
          }
          ?>

          <?php
          $roleid = $user['role_id'];
          if ($roleid == 17) {
            include('menu_verifikasi.php');
          }
          ?>

          <?php
          $roleid = $user['role_id'];
          if ($roleid == 18) {
            include('menu_inventor.php');
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="site-menubar-footer">
  </div>
</div>