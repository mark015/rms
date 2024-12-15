<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <li><a href="index?link=dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
      <li><a href="index?link=documents"><i class="fa fa-file"></i>Documents</a></li>

      <?php if($rowUser['role'] === 'Admin'){?>
        
      <li><a href="index?link=user"><i class="fa fa-user"></i>Users</a></li>
      <?php

      }?>
    </ul>
  </div>
</div>