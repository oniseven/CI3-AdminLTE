    <?php
      foreach ($menus as $key => $menu) {
    ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=$menu->link?>" class="nav-link"><?=$menu->name?></a>
      </li>
    <?php
      }
    ?>