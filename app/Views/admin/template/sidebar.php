<div id="sidebar">
  <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
      <div class="d-flex justify-content-between align-items-center">
        <div class="logo">
          <a href="<?= base_url('dashboard'); ?>">
            <h5 class="mt-3 text-primary"><?= $_page->settings['company_name']; ?></h5>
            <!-- <img src="<?= base_url(); ?>public/assets/compiled/svg/logo.svg" alt="Logo" srcset=""> -->
          </a>
        </div>
        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
              <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
              <g transform="translate(-210 -1)">
                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                <circle cx="220.5" cy="11.5" r="4"></circle>
                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
              </g>
            </g>
          </svg>
          <div class="form-check form-switch fs-6">
            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
            <label class="form-check-label"></label>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
            <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
            </path>
          </svg>
        </div>
        <div class="sidebar-toggler  x">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item  d-none <?= (@$_page->menu == false) ? ' active' : '' ?>">
          <a href="<?= base_url('false'); ?>" class='sidebar-link '>
            <i class="bi bi-grid-fill"></i>
            <span>false</span>
          </a>
        </li>

        <li class="sidebar-item  <?= (@$_page->menu == 'dashboard') ? 'active' : '' ?>">
          <a href="<?= base_url('dashboard'); ?>" class='sidebar-link '>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>



        <?php if (hasPermissions('users_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'users') ? 'active' : '' ?>">
            <a href="<?= base_url('users'); ?>" class='sidebar-link '>
              <i class="fas fa-users"></i>
              <span>Users</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('activity_log_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'activity_log') ? 'active' : '' ?>">
            <a href="<?= base_url('activitylogs'); ?>" class='sidebar-link '>
              <i class="fas fa-history"></i>
              <span>Activity Logs</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('roles_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'roles') ? 'active' : '' ?>">
            <a href="<?= base_url('roles'); ?>" class='sidebar-link '>
              <i class="fas fa-lock"></i>
              <span>Manage Roles</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('permissions_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'permissions') ? 'active' : '' ?>">
            <a href="<?= base_url('permissions'); ?>" class='sidebar-link '>
              <i class="fas fa-user"></i>
              <span class="text-capitalize">
                Manage Permissions
              </span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('backup_db')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'backup') ? 'active' : '' ?>">
            <a href="<?= base_url('backup'); ?>" class='sidebar-link '>
              <i class="fas fa-database"></i>
              <span class="text-capitalize">
                Backup
              </span>
            </a>
          </li>
        <?php endif; ?>

        <?php
        $hasCompany = hasPermissions('company_settings');
        $hasGeneral = hasPermissions('general_settings');
        $hasEmailTemplates = hasPermissions('email_templates_list');
        ?>
        <?php if ($hasGeneral || $hasCompany || $hasEmailTemplates) : ?>
          <li class="sidebar-item  has-sub <?= (@$_page->menu == 'settings') ? 'active' : '' ?>">
            <a href="#" class='sidebar-link'>
              <i class="fas fa-cog"></i>
              <span>Settings</span>
            </a>

            <!-- submenu submenu-open -->
            <!-- submenu submenu-closed -->
            <ul class="submenu <?= ($_page->menu == 'settings') ? 'submenu-open' : ''; ?>">

              <?php if ($hasGeneral) : ?>

                <li class="submenu-item <?php echo (@$_page->submenu == 'general') ? 'active' : '' ?> ">
                  <a href="<?= base_url('settings/general') ?>" class="submenu-link">General Settings</a>

                </li>
              <?php endif; ?>

              <?php if ($hasCompany) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'company') ? 'active' : '' ?>">
                  <a href="<?= base_url('settings/company') ?>" class="submenu-link">Company Setting </a>

                </li>
              <?php endif; ?>

              <?php if ($hasEmailTemplates) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'email_templates') ? 'active' : '' ?>">
                  <a href="<?= base_url('settings/email_templates') ?>" class="submenu-link">Email Templates</a>

                </li>
              <?php endif; ?>

            </ul>


          </li>
        <?php endif; ?>

        <?php if (hasPermissions('departments_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'departments') ? 'active' : '' ?>">
            <a href="<?= base_url('departments'); ?>" class='sidebar-link '>
              <i class="bi bi-grid-fill"></i>
              <span class="text-capitalize">
                Departments
              </span>
            </a>
          </li>
        <?php endif; ?>


        <?php if (hasPermissions('sections_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'sections') ? 'active' : '' ?>">
            <a href="<?= base_url('sections'); ?>" class='sidebar-link '>
              <i class="bi bi-grid-fill"></i>
              <span class="text-capitalize">
                Sections
              </span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('planned_materials_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'planned_materials') ? 'active' : '' ?>">
            <a href="<?= base_url('planned_materials'); ?>" class='sidebar-link '>
              <i class="bi bi-grid-fill"></i>
              <span class="text-capitalize">
                Planned Materials
              </span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('planned_curing_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'planned_curing') ? 'active' : '' ?>">
            <a href="<?= base_url('planned_curing'); ?>" class='sidebar-link '>
              <i class="bi bi-grid-fill"></i>
              <span class="text-capitalize">
                Planned Curing
              </span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (hasPermissions('planned_inbound_list')) : ?>
          <li class="sidebar-item  <?= (@$_page->menu == 'planned_inbound') ? 'active' : '' ?>">
            <a href="<?= base_url('planned_inbound'); ?>" class='sidebar-link '>
              <i class="bi bi-grid-fill"></i>
              <span class="text-capitalize">
                Planned Inbound
              </span>
            </a>
          </li>
        <?php endif; ?>


        <?php
        $hasChartBuilding = hasPermissions('chart_building');
        $hasChartCuring = hasPermissions('chart_curing');
        $hasTableBuilding = hasPermissions('table_building');
        $hasInboundList = hasPermissions('inbound_list');
        $hasInboundRim = hasPermissions('inbound_rim');
        ?>
        <?php if ($hasInboundRim || $hasInboundList || $hasChartCuring || $hasChartBuilding || $hasTableBuilding) : ?>
          <li class="sidebar-item  has-sub <?= (@$_page->menu == 'laporan') ? 'active' : '' ?>">
            <a href="#" class='sidebar-link'>
              <i class="bi bi-grid-fill"></i>
              <span>Laporan</span>
            </a>

            <!-- submenu submenu-open -->
            <!-- submenu submenu-closed -->
            <ul class="submenu <?= ($_page->menu == 'laporan') ? 'submenu-open' : ''; ?>">

              <?php if ($hasChartBuilding) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'chart_building') ? 'active' : '' ?>">
                  <a href="<?= base_url('laporan/chart_building') ?>" class="submenu-link">Chart Building </a>

                </li>

              <?php endif; ?>

              <?php if ($hasTableBuilding) : ?>
                <li class="submenu-item  <?php echo (@$_page->submenu == 'table_building') ? 'active' : '' ?>">
                  <a href="<?= base_url('laporan/table_building/all') ?>" class="submenu-link">Table Building </a>

                </li>
              <?php endif; ?>

              <?php if ($hasChartCuring) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'chart_curing') ? 'active' : '' ?>">
                  <a href="<?= base_url('laporan/chart_curing') ?>" class="submenu-link">Chart Curing </a>

                </li>

              <?php endif; ?>

              <?php if ($hasInboundList) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'inbound_list') ? 'active' : '' ?>">
                  <a href="<?= base_url('laporan/inbound') ?>" class="submenu-link">Laporan Inbound </a>

                </li>

              <?php endif; ?>

              <?php if ($hasInboundRim) : ?>

                <li class="submenu-item  <?php echo (@$_page->submenu == 'inbound_rim') ? 'active' : '' ?>">
                  <a href="<?= base_url('laporan/inbound_rim') ?>" class="submenu-link">Laporan Inbound Rim</a>

                </li>

              <?php endif; ?>

            </ul>


          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</div>