      <?php
        if(!function_exists('generateChild')) {
          function generateChild($menu){
            $childs = $menu->childs;
            $html = '<ul class="nav nav-treeview">';
            foreach ($childs as $key => $child) {
              $html .= '<li class="nav-item">';
              $html .= "<a href='{$child->link}' class='nav-link'>";
              $html .= "<i class='nav-icon {$child->icon}'></i>";
              $html .= "<p>{$child->name}";
              $html .= !$child->is_last ? '<i class="right fas fa-angle-left"></i>' : "";
              $html .= "</p>";
              $html .= '</a>';
              $html .= (!$child->is_last) ? generateChild($child) : '';
              $html .= '</li>';
            }
            $html .= '</ul>';

            return $html;
          }
        }
      ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php
          foreach ($menus as $key => $menu) {
        ?>
          <li class="nav-item">
            <a href="<?=$menu->link?>" class="nav-link">
              <i class="nav-icon <?=$menu->icon?>"></i>
              <p>
                <?=$menu->name?>
                <?php if(!$menu->is_last) { ?>
                  <i class="right fas fa-angle-left"></i>
                <?php } ?>
              </p>
            </a>
            <?=(!$menu->is_last ? generateChild($menu) : "")?>
          </li>
        <?php
          }
        ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->