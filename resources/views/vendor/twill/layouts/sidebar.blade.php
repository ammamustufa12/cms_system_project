  <style>
      #scrollbar {
          height: 100vh;
          /* Full screen height */
          overflow-y: auto;
          /* Enable vertical scrolling */
          padding-right: 4px;
          /* Optional: space for scrollbar */
      }
  </style>
  <div id="scrollbar">
      <div class="container-fluid">


          <div id="two-column-menu">
          </div>
          <ul class="navbar-nav" id="navbar-nav">
              @if (request()->routeIs([
                      'config.*',
                      'admin.field-manager.*',
                      'admin.field-groups.*',
                      'admin.fields.*',
                      'admin.industries.*',
                      'admin.data-types.*',
                      'admin.profiles.*',
                      'admin.category-groups.*',
                      'admin.categories.*',
                      'config.menu-management.*',
                  ]))
                  <!-- CONFIG PAGE SIDEBAR -->
                  <!-- DEFAULT SIDEBAR -->
                  <li class="menu-title"><span data-key="t-menu">CONFIGURATION</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarDashboards">
                          <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                      </a>
                  </li> <!-- end Dashboard Menu -->

                  <li class="menu-title"><span data-key="t-menu">Organize Content</span></li>


                  <!-- Organize Content Structure -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarOrganizeContent" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarOrganizeContent">
                          <i class="ri-organization-chart"></i> <span>Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarOrganizeContent">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('admin.industries.index') }}"
                                      class="nav-link">Industry</a></li>
                              <li class="nav-item"><a href="{{ route('admin.data-types.index') }}" class="nav-link">Data
                                      Types</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('admin.profiles.index') }}"
                                      class="nav-link">Profiles</a>
                              </li>

                          </ul>
                      </div>
                  </li>




                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>Configuration</span></li>
                  <!-- Company PAGE SIDEBAR -->

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarmenucontrol">
                          <i class="ri-folder-3-line"></i> <span>Menu Control</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarmenucontrol">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">ToolBar</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Top Menu</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Breadcrumbs</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.sidebar-left') }}"
                                      class="nav-link">Sidebar Left</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.sidebar-right') }}"
                                      class="nav-link">Sidebar Right</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.bottom-menu') }}"
                                      class="nav-link">Bottom Menu</a>
                              </li>
                          </ul>
                      </div>
                  </li>


                  <!-- Roles & Permissions -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCompanyStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCompanyStructure">
                          <i class="ri-organization-chart"></i> <span>Category Manager</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCompanyStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('admin.category-groups.index') }}"
                                      class="nav-link">Category Groups</a></li>
                              <li class="nav-item"><a href="{{ route('admin.categories.index') }}"
                                      class="nav-link">View
                                      Categories</a>
                              </li>

                          </ul>
                      </div>
                  </li>

                  <!-- Activity Logs -->

                  <!-- Field Manager -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarFieldManager" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarFieldManager">
                          <i class="ri-settings-3-line"></i> <span>Field Manager</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarFieldManager">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('admin.field-manager.install') }}"
                                      class="nav-link">Install Field Type</a></li>
                              <li class="nav-item"><a href="{{ route('admin.field-groups.index') }}"
                                      class="nav-link">Field Groups</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('admin.fields.index') }}" class="nav-link">View
                                      Fields</a>
                              </li>

                          </ul>
                      </div>
                  </li>

                  <!-- Activity Logs -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCompanyStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCompanyStructure">
                          <i class="ri-organization-chart"></i> <span>List Manager</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCompanyStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Admin</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Frontend</a>
                              </li>


                          </ul>
                      </div>
                  </li>

                  <!-- Start --->





                  <!-- SYSTEM SETTINGS -->
                  <li class="menu-title"><i class="ri-settings-3-line"></i>
                      <span>SYSTEM SETTINGS</span>
                  </li>

                  <!-- Users -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-4-line"></i> <span>Global Configuration</span>
                      </a>
                  </li>

                  <!-- Roles & Permissions -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                          <i class="ri-building-line"></i> <span>Your Company</span>
                      </a>
                  </li>

                  <!-- Activity Logs -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-team-line"></i> <span>User Management</span>
                      </a>
                  </li>

                  <!-- Activity Logs -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-folder-line"></i> <span>Category Management</span>
                      </a>
                  </li>

                  <!-- Start --->


                  <!-- YOUR COMPANY -->
                  <li class="menu-title"><i class="ri-building-2-line"></i>
                      <span>YOUR COMPANY</span>
                  </li>

                  <!-- Settings -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Company List -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                          <i class="ri-list-check-2"></i> <span>Company List</span>
                      </a>
                  </li>

                  <!-- Organize Content -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarOrganizeContent" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarOrganizeContent">
                          <i class="ri-organization-chart"></i> <span>Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarOrganizeContent">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Industry</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Data Types</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Profiles</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Location Structure -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarLocationStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarLocationStructure">
                          <i class="ri-map-pin-line"></i> <span>Location Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLocationStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Field Groups</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Field Manager</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Layout Builder</a>
                              </li>
                          </ul>
                      </div>
                  </li>


                  <!-- Department Structure -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarDepartmentStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarDepartmentStructure">
                          <i class="ri-briefcase-line"></i> <span>Department Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarDepartmentStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Field Groups</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Field Manager</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Layout Builder</a>
                              </li>
                          </ul>
                      </div>
                  </li>


                  <!-- Employee Structure -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarEmployeeStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarEmployeeStructure">
                          <i class="ri-user-settings-line"></i> <span>Employee Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarEmployeeStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Field Groups</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Field Manager</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Layout Builder</a>
                              </li>
                          </ul>
                      </div>
                  </li>


                  <!-- USER MANAGEMENT -->
                  <li class="menu-title"><i class="ri-user-settings-line"></i>
                      <span>USER MANAGEMENT</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- User Group -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                          <i class="ri-group-line"></i> <span>User Group</span>
                      </a>
                  </li>

                  <!-- Activity Logs -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-team-line"></i> <span>User Management</span>
                      </a>
                  </li>

                  <!-- Access Roles -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-shield-keyhole-line"></i> <span>Access Roles</span>
                      </a>
                  </li>

                  <!-- Access Levels -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-lock-password-line"></i> <span>Access Levels</span>
                      </a>
                  </li>

                  <!-- ADMIN TEMPLATE -->
                  <li class="menu-title"><i class="ri-layout-line"></i>
                      <span>ADMIN TEMPLATE</span>
                  </li>

                  <!-- Template Structure  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-layout-grid-line"></i> <span>Template Structure</span>
                      </a>
                  </li>

                  <!-- Design -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarAdminDesign" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarAdminDesign">
                          <i class="ri-palette-line"></i> <span>Design</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarAdminDesign">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Layout</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Styling</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Toolbar</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Sidebar</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Theme  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-palette-line"></i> <span>Theme</span>
                      </a>
                  </li>

                  <!-- Components -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarComponents" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarComponents">
                          <i class="ri-puzzle-line"></i> <span>Components</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarComponents">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Base UI
                                  </a>
                                  <div class="collapse" id="sidebarBaseUI">
                                      <ul class="nav nav-sm flex-column ms-3">
                                          <li class="nav-item"><a href="#" class="nav-link">Cards</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Carousel</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Dropdowns</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Grid</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Images</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Tabs</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Accordion &
                                                  Collapse</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Modals</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Offcanvas</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Placeholders</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Progress</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Notifications</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Media object</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Embed Video</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Typography</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Lists</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">LinksNew</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">General</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Ribbons</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Utilities</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item">
                                  <a href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Advanced UI
                                  </a>
                                  <div class="collapse" id="sidebarAdvancedUI">
                                      <ul class="nav nav-sm flex-column ms-3">
                                          <li class="nav-item"><a href="#" class="nav-link">Sweet Alerts</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Nestable List</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Scrollbar</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Animation</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Tour</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Swiper Slider</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Ratings</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Highlight</a></li>
                                      </ul>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Frontend Template MANAGEMENT -->
                  <li class="menu-title"><i class="ri-shopping-bag-line"></i>
                      <span>Frontend Template</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>templates</span>
                      </a>
                  </li>

                  <!-- Design -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarFrontendDefault" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarFrontendDefault">
                          <i class="ri-palette-line"></i> <span>Default</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarFrontendDefault">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Settings</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Layout</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Colors</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Tools</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Tools</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Template   -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Template </span>
                      </a>
                  </li>

                  <!-- ADMIN TEMPLATE -->
                  <li class="menu-title"><i class="ri-layout-line"></i>
                      <span>ADMIN TEMPLATE</span>
                  </li>

                  <!-- Template Structure -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-layout-grid-line"></i> <span>Template Structure</span>
                      </a>
                  </li>

                  <!-- Design -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarDesign" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarDesign">
                          <i class="ri-palette-line"></i> <span>Design</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarDesign">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">Layout</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Styling</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Toolbar</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Sidebar</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Theme -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-palette-line"></i> <span>Theme</span>
                      </a>
                  </li>

                  <!-- Components -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarComponents" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarComponents">
                          <i class="ri-puzzle-line"></i> <span>Components</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarComponents">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Base UI
                                  </a>
                                  <div class="collapse" id="sidebarBaseUI">
                                      <ul class="nav nav-sm flex-column ms-3">
                                          <li class="nav-item"><a href="#" class="nav-link">Cards</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Carousel</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Dropdowns</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Grid</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Images</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Tabs</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item"><a href="#" class="nav-link">Accordion & Collapse</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Modals</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Offcanvas</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Placeholders</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Progress</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Notifications</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Media object</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Embed Video</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Typography</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Lists</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">LinksNew</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">General</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Ribbons</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Utilities</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- LAYOUT BUILDER -->
                  <li class="menu-title"><i class="ri-layout-masonry-line"></i>
                      <span>LAYOUT BUILDER</span>
                  </li>

                  <!-- Settings -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Admin -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-admin-line"></i> <span>Admin</span>
                      </a>
                  </li>

                  <!-- Components -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarLayoutComponents" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarLayoutComponents">
                          <i class="ri-puzzle-line"></i> <span>Components</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLayoutComponents">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">Base</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Columns</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Tab</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Accordion</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Button</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Specials</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Blocks -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarLayoutBlocks" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarLayoutBlocks">
                          <i class="ri-layout-grid-line"></i> <span>Blocks</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLayoutBlocks">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">Core</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Hero</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Bootstrap</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">etc...</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Variables -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarLayoutVariables" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarLayoutVariables">
                          <i class="ri-variable-line"></i> <span>Variables</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLayoutVariables">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">Font</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Color</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Dimensions</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">CSS Class</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Frontend -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarLayoutFrontend" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarLayoutFrontend">
                          <i class="ri-window-line"></i> <span>Frontend</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLayoutFrontend">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">(similar to admin but more
                                      options)</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Content Lists -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-list-check-2"></i> <span>Content Lists</span>
                      </a>
                  </li>


                  <!-- Admin Menu management -->
                  <li class="menu-title"><i class="ri-save-line"></i>
                      <span>Admin Menu Management</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-cloud-line"></i> <span>Settings</span>
                      </a>
                  </li>


                  <!-- Category management -->
                  <li class="menu-title"><i class="ri-save-line"></i>
                      <span>Category Management</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-cloud-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- CONNECTION MANAGEMENT -->
                  <li class="menu-title"><i class="ri-shopping-bag-line"></i>
                      <span>Connection Management</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Settings</span>
                      </a>
                  </li>
                  <!-- Connection Type  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Connection Type</span>
                      </a>
                  </li>
                  <!-- Connection Layout  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Connection Layout</span>
                      </a>
                  </li>
                  <!-- Search & Filter  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Search & Filter</span>
                      </a>
                  </li>




                  <!-- Product Management -->
                  <li class="menu-title"><i class="ri-shopping-bag-line"></i>
                      <span>Product Management</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-bag-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Content Management -->
                  <li class="menu-title"><i class="ri-file-text-line"></i>
                      <span>Content Management</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-file-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Content List Management -->
                  <li class="menu-title"><i class="ri-list-check"></i>
                      <span>Content List</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-list-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Field Types Management -->
                  <li class="menu-title"><i class="ri-input-method-line"></i>
                      <span>Field Types</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-input-method-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Import Function Management -->
                  <li class="menu-title"><i class="ri-download-line"></i>
                      <span>Import Function</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-download-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Export Function Management -->
                  <li class="menu-title"><i class="ri-upload-line"></i>
                      <span>Export Function</span>
                  </li>

                  <!-- Settings  -->

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-upload-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>


                  <!-- Income Management -->
                  <li class="menu-title"><i class="ri-money-dollar-circle-line"></i>
                      <span>Income</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-money-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Expenses Management -->
                  <li class="menu-title"><i class="ri-bank-card-line"></i>
                      <span>Expenses</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-bank-card-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- E-Commerce Management -->
                  <li class="menu-title"><i class="ri-shopping-cart-line"></i>
                      <span>E-Commerce</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-shopping-cart-settings-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Human Resources Management -->
                  <li class="menu-title"><i class="ri-team-line"></i>
                      <span>Human Resources</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Accounting Management -->
                  <li class="menu-title"><i class="ri-calculator-line"></i>
                      <span>Accounting</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- FINANCIAL Management -->
                  <li class="menu-title"><i class="ri-bank-line"></i>
                      <span>Financial</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- Taxes Management -->
                  <li class="menu-title"><i class="ri-percent-line"></i>
                      <span>Taxes</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>


                  <!-- Taxes Management -->
                  <li class="menu-title"><i class="ri-percent-line"></i>
                      <span>Taxes</span>
                  </li>

                  <!-- Settings  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- INSTALL DATASETS -->
                  <li class="menu-title"><i class="ri-database-2-line"></i>
                      <span>Install Datasets</span>
                  </li>

                  <!-- Install Datasets  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-download-cloud-line"></i> <span>Install Datasets</span>
                      </a>
                  </li>


                  <!-- Backup management -->
                  <li class="menu-title"><i class="ri-save-line"></i>
                      <span>Backup Management</span>
                  </li>

                  <!-- Backup  -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-cloud-line"></i> <span>Backup</span>
                      </a>
                  </li>

                  <!-- Start --->







                  {{-- <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarAdminTemplate" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarAdminTemplate">
                          <span>ADMIN TEMPLATE</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarAdminTemplate">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="" class="nav-link">Template Structure</a></li>
                              <li class="nav-item">
                                  <a href="#sidebarDesign" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Design
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarDesign">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="" class="nav-link">Layout</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Styling</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Toolbar</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Sidebar</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item"><a href="" class="nav-link">Theme</a></li>
                              <li class="nav-item">
                                  <a href="#sidebarComponents" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Components
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarComponents">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item">
                                              <a href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                                                  class="nav-link">
                                                  Base UI
                                              </a>
                                              <div class="collapse menu-dropdown" id="sidebarBaseUI">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Cards</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Carousel</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Dropdowns</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Grid</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Images</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Tabs</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Accordion & Collapse</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Modals</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Offcanvas</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Placeholders</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Progress</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Notifications</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Media
                                                              object</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Embed
                                                              Video</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Typography</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Lists</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Links
                                                              New</a></li>
                                                  </ul>
                                              </div>
                                          </li>
                                          <li class="nav-item">
                                              <a href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                                  class="nav-link">
                                                  Advanced UI
                                              </a>
                                              <div class="collapse menu-dropdown" id="sidebarAdvancedUI">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li class="nav-item"><a href="" class="nav-link">Sweet
                                                              Alerts</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Nestable List</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Scrollbar</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Animation</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Tour</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Swiper
                                                              Slider</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Ratings</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Highlight</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">ScrollSpy</a></li>
                                                  </ul>
                                              </div>
                                          </li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item"><a href="" class="nav-link">Widgets</a></li>
                              <li class="nav-item">
                                  <a href="#sidebarForms" data-bs-toggle="collapse" role="button" class="nav-link">
                                      Forms
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarForms">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="" class="nav-link">Basic Elements</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Form Select</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Checkboxes &
                                                  Radios</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Pickers</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Input Masks</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Advanced</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Range Slider</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Validation</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Wizard</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Editors</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">File Uploads</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Form Layouts</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Select2</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item">
                                  <a href="#sidebarTables" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Tables
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarTables">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="" class="nav-link">Basic Tables</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Grid Js</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">List Js</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Datatables</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item">
                                  <a href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                                      class="nav-link">
                                      Charts
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarCharts">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item">
                                              <a href="#sidebarApexcharts" data-bs-toggle="collapse" role="button"
                                                  class="nav-link">
                                                  Apexcharts
                                              </a>
                                              <div class="collapse menu-dropdown" id="sidebarApexcharts">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Line</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Area</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Column</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Bar</a>
                                                      </li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Mixed</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Timeline</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Range
                                                              Area</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Funnel</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Candlestick</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Boxplot</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Bubble</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Scatter</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Heatmap</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Treemap</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Pie</a>
                                                      </li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Radialbar</a></li>
                                                      <li class="nav-item"><a href=""
                                                              class="nav-link">Radar</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Polar
                                                              Area</a></li>
                                                      <li class="nav-item"><a href="" class="nav-link">Slope
                                                              New</a></li>
                                                  </ul>
                                              </div>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Chartjs</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Echarts</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item">
                                  <a href="#sidebarIcons" data-bs-toggle="collapse" role="button" class="nav-link">
                                      Icons
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarIcons">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="" class="nav-link">Remix</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Boxicons</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Material Design</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Line Awesome</a>
                                          </li>
                                          <li class="nav-item"><a href="" class="nav-link">Feather</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item">
                                  <a href="#sidebarMaps" data-bs-toggle="collapse" role="button" class="nav-link">
                                      Maps
                                  </a>
                                  <div class="collapse menu-dropdown" id="sidebarMaps">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="" class="nav-link">Google</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Vector</a></li>
                                          <li class="nav-item"><a href="" class="nav-link">Leaflet</a></li>
                                      </ul>
                                  </div>
                              </li>


                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a href="#sidebarIcons" data-bs-toggle="collapse" role="button" class="nav-link">
                          Admin Menu Management
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarIcons">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="" class="nav-link">Settings</a></li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a href="#sidebarIcons" data-bs-toggle="collapse" role="button" class="nav-link">
                          Category Management
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarIcons">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="" class="nav-link">Settings</a></li>

                          </ul>
                      </div>
                  </li>
                  <li class="nav-item">
                      <a href="#layoutBuilder" data-bs-toggle="collapse" role="button" class="nav-link">
                          Layout Builder
                      </a>
                      <div class="collapse menu-dropdown" id="layoutBuilder">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="#lbSettings" data-bs-toggle="collapse" class="nav-link">Settings</a>
                                  <div class="collapse menu-dropdown" id="lbSettings">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Admin</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Frontend</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Content Lists</a>
                                          </li>
                                      </ul>
                                  </div>
                              </li>

                              <li class="nav-item">
                                  <a href="#lbAdmin" data-bs-toggle="collapse" class="nav-link">Admin</a>
                                  <div class="collapse menu-dropdown" id="lbAdmin">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Components</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Blocks</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Variables</a></li>
                                      </ul>
                                  </div>
                              </li>

                              <li class="nav-item">
                                  <a href="#lbFrontend" data-bs-toggle="collapse" class="nav-link">Frontend</a>
                                  <div class="collapse menu-dropdown" id="lbFrontend">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Similar to Admin
                                                  (more options)</a></li>
                                      </ul>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a href="#frontendTemplate" data-bs-toggle="collapse" role="button" class="nav-link">
                          Frontend Template
                      </a>
                      <div class="collapse menu-dropdown" id="frontendTemplate">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="#templateDefault" data-bs-toggle="collapse" class="nav-link">Default
                                      Template</a>
                                  <div class="collapse menu-dropdown" id="templateDefault">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Settings</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Layout</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Colors</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Tools</a></li>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item"><a href="#" class="nav-link">Template 2</a></li>
                          </ul>
                      </div>
                  </li> --}}
                  {{-- @elseif(request()->routeIs('setup.*')) --}}
                  {{-- @elseif(request()->routeIs('setup.*')) --}}
              @elseif (request()->routeIs(['setup.*', 'content-types.*', 'page.index']))
                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>SETUP</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarDashboards">
                          <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                      </a>
                  </li> <!-- end Dashboard Menu -->
                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>Company Structure</span></li>
                  <!-- Company PAGE SIDEBAR -->

                  <!-- Company Management -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('setup.company.index') }}">
                          <i class="ri-building-line"></i> <span>Companies</span>
                      </a>
                  </li>

                  <!-- Location Management -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('setup.location.index') }}">
                          <i class="ri-map-pin-line"></i> <span>Locations</span>
                      </a>
                  </li>

                  <!-- Department Management -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('setup.department.index') }}">
                          <i class="ri-building-2-line"></i> <span>Departments</span>
                      </a>
                  </li>

                  <!-- Employee Management -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('setup.employee.index') }}">
                          <i class="ri-user-line"></i> <span>Employees</span>
                      </a>
                  </li>



                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>Configuration</span></li>
                  <!-- Company PAGE SIDEBAR -->

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarmenucontrol">
                          <i class="ri-folder-3-line"></i> <span>Menu Control</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarmenucontrol">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('setup.menu-management.toolbar') }}"
                                      class="nav-link">ToolBar</a></li>
                              <li class="nav-item"><a href="{{ route('setup.menu-management.top-menu') }}"
                                      class="nav-link">Top Menu</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('setup.menu-management.breadcrumbs') }}"
                                      class="nav-link">Breadcrumbs</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('setup.menu-management.sidebar-left') }}"
                                      class="nav-link">Sidebar Left</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('setup.menu-management.sidebar-right') }}"
                                      class="nav-link">Sidebar Right</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('setup.menu-management.bottom-menu') }}"
                                      class="nav-link">Bottom Menu</a>
                              </li>
                          </ul>
                      </div>
                  </li>



                  <li class="menu-title"><i class="ri-shopping-cart-line"></i>
                      <span data-key="t-ecommerce">Content Management</span>
                  </li>

                  <!-- Pages -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('content-types.index') }}">
                          <i class="ri-pages-line"></i> <span>Content Type</span>
                      </a>
                  </li>

                  <!-- Pages -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('pages.index') }}">
                          <i class="ri-pages-line"></i> <span>Pages</span>
                      </a>
                  </li>

                  <!-- Blog / News / Articles -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/posts">
                          <i class="ri-article-line"></i> <span>Blog Posts</span>
                      </a>
                  </li>

                  <!-- Blog Categories -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/categories">
                          <i class="ri-price-tag-3-line"></i> <span>Blog Categories</span>
                      </a>
                  </li>


                  <!-- Media Library -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/media-library">
                          <i class="ri-image-line"></i> <span>Media Library</span>
                      </a>
                  </li>

                  <!-- Menu -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('menu.index') }}">
                          <i class="ri-image-line"></i> <span>Menu</span>
                      </a>
                  </li>

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCustomContent" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCustomContent">
                          <i class="ri-folder-3-line"></i> <span>Custom Content</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCustomContent">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">Projects</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Case Studies</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Testimonials</a>
                              </li>
                          </ul>
                      </div>
                  </li>




                  <!-- End  -->


                  <!-- USER MANAGEMENT -->
                  <li class="menu-title"><span>User Management</span></li>

                  <!-- Field Groups -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-folder-2-line"></i> <span>Field Groups</span>
                      </a>
                  </li>

                  <!-- Field Manager -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-file-settings-line"></i> <span>Field Manager</span>
                      </a>
                  </li>

                  <!-- User List -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-team-line"></i> <span>User List</span>
                      </a>
                  </li>

                  <!-- Layout Builder Collapse -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#layoutBuilder" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="layoutBuilder">
                          <i class="ri-layout-2-line"></i> <span>Layout Builder</span>
                      </a>
                      <div class="collapse menu-dropdown" id="layoutBuilder">
                          <ul class="nav nav-sm flex-column">

                              <!-- Admin Submenu -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#adminSub" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="adminSub">
                                      Admin
                                  </a>
                                  <div class="collapse menu-dropdown" id="adminSub">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Capture</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Quick View</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Dashboard</a></li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Frontend Submenu -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#frontendSub" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="frontendSub">
                                      Frontend
                                  </a>
                                  <div class="collapse menu-dropdown" id="frontendSub">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Edit View</a></li>
                                          <li class="nav-item"><a href="#" class="nav-link">Detailed Page</a>
                                          </li>
                                      </ul>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Import Function -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-upload-2-line"></i> <span>Import Function</span>
                      </a>
                  </li>

                  <!-- Export Function -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-download-2-line"></i> <span>Export Function</span>
                      </a>
                  </li>

                  <!-- Bulk Changes -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-edit-2-line"></i> <span>Bulk Changes</span>
                      </a>
                  </li>


                  <!-- ADMIN MENU MANAGER -->
                  <li class="menu-title"><span>Admin Menu Manager</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-arrow-left-line"></i> <span>Left Side</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-arrow-right-line"></i> <span>Right Side</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-arrow-up-line"></i> <span>Top</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-arrow-down-line"></i> <span>Bottom</span>
                      </a>
                  </li>

                  <!-- CATEGORY MANAGEMENT -->
                  <li class="menu-title"><span>Category Management</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-folders-line"></i> <span>Category Group</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-list-check-2"></i> <span>Categories</span>
                      </a>
                  </li>


                  <!-- PRODUCT MANAGER -->
                  <li class="menu-title"><span>Product Manager</span></li>

                  <!-- Category Structure Collapse -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#categoryStructure" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="categoryStructure">
                          <i class="ri-organization-chart"></i> <span>Category Structure</span>
                      </a>
                      <div class="collapse menu-dropdown" id="categoryStructure">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link">Category Group</a></li>
                              <li class="nav-item"><a href="#" class="nav-link">Categories</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Profile Type -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-user-settings-line"></i> <span>Profile Type</span>
                      </a>
                  </li>

                  <!-- Product Type -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-shopping-basket-2-line"></i> <span>Product Type</span>
                      </a>
                  </li>


                  <!-- Centralized Collapse -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#centralized" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="centralized">
                          <i class="ri-database-2-line"></i> <span>Centralized</span>
                      </a>
                      <div class="collapse menu-dropdown" id="centralized">
                          <ul class="nav nav-sm flex-column">

                              <!-- Category Structure Nested -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#centralCategoryStructure"
                                      data-bs-toggle="collapse" role="button" aria-expanded="false"
                                      aria-controls="centralCategoryStructure">
                                      Category Structure
                                  </a>
                                  <div class="collapse menu-dropdown" id="centralCategoryStructure">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Category
                                                  Group</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Categories</a>
                                          </li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Products Nested -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#productsMenu" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="productsMenu">
                                      Products
                                  </a>
                                  <div class="collapse menu-dropdown" id="productsMenu">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Field Group</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Field
                                                  Manager</a>
                                          </li>

                                          <!-- Layout Builder Nested -->
                                          <li class="nav-item">
                                              <a class="nav-link menu-link" href="#layoutBuilder2"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="layoutBuilder2">
                                                  Layout Builder
                                              </a>
                                              <div class="collapse menu-dropdown" id="layoutBuilder2">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li class="nav-item"><a href="#"
                                                              class="nav-link">Admin</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Capture</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Quick View</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Dashboard</a></li>
                                                      <li class="nav-item"><a href="#"
                                                              class="nav-link">Frontend</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Edit View</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>
                                      </ul>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <!-- Decentralized Collapse -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#decentralized" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="decentralized">
                          <i class="ri-global-line"></i> <span>Decentralized</span>
                      </a>
                      <div class="collapse menu-dropdown" id="decentralized">
                          <ul class="nav nav-sm flex-column">

                              <!-- Category Structure Nested -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#decentralCategoryStructure"
                                      data-bs-toggle="collapse" role="button" aria-expanded="false"
                                      aria-controls="decentralCategoryStructure">
                                      Category Structure
                                  </a>
                                  <div class="collapse menu-dropdown" id="decentralCategoryStructure">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Category
                                                  Group</a>
                                          </li>
                                          <li class="nav-item"><a href="#" class="nav-link">Categories</a>
                                          </li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Products Nested -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#decentralProductsMenu"
                                      data-bs-toggle="collapse" role="button" aria-expanded="false"
                                      aria-controls="decentralProductsMenu">
                                      Products
                                  </a>
                                  <div class="collapse menu-dropdown" id="decentralProductsMenu">
                                      <ul class="nav nav-sm flex-column">
                                          <li class="nav-item"><a href="#" class="nav-link">Field
                                                  Manager</a>
                                          </li>

                                          <!-- Layout Builder Nested -->
                                          <li class="nav-item">
                                              <a class="nav-link menu-link" href="#decentralLayoutBuilder"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="decentralLayoutBuilder">
                                                  Layout Builder
                                              </a>
                                              <div class="collapse menu-dropdown" id="decentralLayoutBuilder">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li class="nav-item"><a href="#"
                                                              class="nav-link">Admin</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Capture</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Quick View</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Dashboard</a></li>
                                                      <li class="nav-item"><a href="#"
                                                              class="nav-link">Frontend</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Edit View</a></li>
                                                      <li class="nav-item ms-3"><a href="#"
                                                              class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Import Function -->
                              <li class="nav-item"><a href="#" class="nav-link">Import Function</a></li>

                              <!-- Export Function -->
                              <li class="nav-item"><a href="#" class="nav-link">Export Function</a></li>

                              <!-- Bulk Changes -->
                              <li class="nav-item"><a href="#" class="nav-link">Bulk Changes</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- CONTENT MANAGEMENT -->
                  <li class="menu-title"><span>Content Management</span></li>

                  <!-- Centralized -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#Centralized" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="Centralized">
                          <i class="ri-database-2-line"></i> <span>Centralized</span>
                      </a>
                      <div class="collapse menu-dropdown" id="Centralized">
                          <ul class="nav nav-sm flex-column">

                              <!-- Production -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#Production" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="Production">
                                      <i class="ri-building-2-line"></i> Production
                                  </a>
                                  <div class="collapse menu-dropdown" id="Production">
                                      <ul class="nav nav-sm flex-column">
                                          <li><a href="#" class="nav-link">Field Group</a></li>
                                          <li><a href="#" class="nav-link">Field Manager</a></li>
                                          <li><a href="#" class="nav-link">Layout Builder</a></li>

                                          <!-- Admin Submenu -->
                                          <li>
                                              <a class="nav-link menu-link" href="#ProductionAdmin"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ProductionAdmin">
                                                  Admin
                                              </a>
                                              <div class="collapse menu-dropdown" id="ProductionAdmin">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Capture</a></li>
                                                      <li><a href="#" class="nav-link">Quick View</a></li>
                                                      <li><a href="#" class="nav-link">Dashboard</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <!-- Frontend Submenu -->
                                          <li>
                                              <a class="nav-link menu-link" href="#ProductionFrontend"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ProductionFrontend">
                                                  Frontend
                                              </a>
                                              <div class="collapse menu-dropdown" id="ProductionFrontend">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Edit View</a></li>
                                                      <li><a href="#" class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li><a href="#" class="nav-link">Import Function</a></li>
                                          <li><a href="#" class="nav-link">Export Function</a></li>
                                          <li><a href="#" class="nav-link">Bulk Changes</a></li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Channel -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#Channel" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="Channel">
                                      <i class="ri-slideshow-2-line"></i> Channel
                                  </a>
                                  <div class="collapse menu-dropdown" id="Channel">
                                      <ul class="nav nav-sm flex-column">
                                          <li><a href="#" class="nav-link">Field Group</a></li>
                                          <li><a href="#" class="nav-link">Field Manager</a></li>
                                          <li><a href="#" class="nav-link">Layout Builder</a></li>

                                          <li>
                                              <a class="nav-link menu-link" href="#ChannelAdmin"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ChannelAdmin">
                                                  Admin
                                              </a>
                                              <div class="collapse menu-dropdown" id="ChannelAdmin">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Capture</a></li>
                                                      <li><a href="#" class="nav-link">Quick View</a></li>
                                                      <li><a href="#" class="nav-link">Dashboard</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li>
                                              <a class="nav-link menu-link" href="#ChannelFrontend"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ChannelFrontend">
                                                  Frontend
                                              </a>
                                              <div class="collapse menu-dropdown" id="ChannelFrontend">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Edit View</a></li>
                                                      <li><a href="#" class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li><a href="#" class="nav-link">Import Function</a></li>
                                          <li><a href="#" class="nav-link">Export Function</a></li>
                                          <li><a href="#" class="nav-link">Bulk Changes</a></li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Contacts -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#Contacts" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="Contacts">
                                      <i class="ri-contacts-book-line"></i> Contacts
                                  </a>
                                  <div class="collapse menu-dropdown" id="Contacts">
                                      <ul class="nav nav-sm flex-column">
                                          <li><a href="#" class="nav-link">Field Group</a></li>
                                          <li><a href="#" class="nav-link">Field Manager</a></li>
                                          <li><a href="#" class="nav-link">Layout Builder</a></li>

                                          <li>
                                              <a class="nav-link menu-link" href="#ContactsAdmin"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ContactsAdmin">
                                                  Admin
                                              </a>
                                              <div class="collapse menu-dropdown" id="ContactsAdmin">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Capture</a></li>
                                                      <li><a href="#" class="nav-link">Quick View</a></li>
                                                      <li><a href="#" class="nav-link">Dashboard</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li>
                                              <a class="nav-link menu-link" href="#ContactsFrontend"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="ContactsFrontend">
                                                  Frontend
                                              </a>
                                              <div class="collapse menu-dropdown" id="ContactsFrontend">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Edit View</a></li>
                                                      <li><a href="#" class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li><a href="#" class="nav-link">Import Function</a></li>
                                          <li><a href="#" class="nav-link">Export Function</a></li>
                                          <li><a href="#" class="nav-link">Bulk Changes</a></li>
                                      </ul>
                                  </div>
                              </li>

                              <!-- Location -->
                              <li class="nav-item">
                                  <a class="nav-link menu-link" href="#Location" data-bs-toggle="collapse"
                                      role="button" aria-expanded="false" aria-controls="Location">
                                      <i class="ri-map-pin-line"></i> Location
                                  </a>
                                  <div class="collapse menu-dropdown" id="Location">
                                      <ul class="nav nav-sm flex-column">
                                          <li><a href="#" class="nav-link">Field Group</a></li>
                                          <li><a href="#" class="nav-link">Field Manager</a></li>
                                          <li><a href="#" class="nav-link">Layout Builder</a></li>

                                          <li>
                                              <a class="nav-link menu-link" href="#LocationAdmin"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="LocationAdmin">
                                                  Admin
                                              </a>
                                              <div class="collapse menu-dropdown" id="LocationAdmin">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Capture</a></li>
                                                      <li><a href="#" class="nav-link">Quick View</a></li>
                                                      <li><a href="#" class="nav-link">Dashboard</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li>
                                              <a class="nav-link menu-link" href="#LocationFrontend"
                                                  data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                  aria-controls="LocationFrontend">
                                                  Frontend
                                              </a>
                                              <div class="collapse menu-dropdown" id="LocationFrontend">
                                                  <ul class="nav nav-sm flex-column">
                                                      <li><a href="#" class="nav-link">Edit View</a></li>
                                                      <li><a href="#" class="nav-link">Detailed Page</a></li>
                                                  </ul>
                                              </div>
                                          </li>

                                          <li><a href="#" class="nav-link">Import Function</a></li>
                                          <li><a href="#" class="nav-link">Export Function</a></li>
                                          <li><a href="#" class="nav-link">Bulk Changes</a></li>
                                      </ul>
                                  </div>
                              </li>

                          </ul>
                      </div>
                  </li>




                  <!-- FRONTEND TEMPLATE -->
                  <li class="menu-title"><span>Frontend Template</span></li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-layout-line"></i> <span>Templates</span>
                      </a>
                  </li>

                  <!-- FRONTEND MENU MANAGER -->
                  <li class="menu-title"><span>Frontend Menu Manager</span></li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-menu-line"></i> <span>Manage</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#">
                          <i class="ri-list-check-2"></i> <span>Main Menu, etc</span>
                      </a>
                  </li>

                  <!-- CONTENT LIST MANAGER -->
                  <!-- CONTENT LIST MANAGER -->
                  <li class="menu-title"><span>Content List Manager</span></li>

                  <!-- Admin Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#adminMenu" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="adminMenu">
                          <i class="ri-shield-user-line"></i> <span>Admin</span>
                      </a>
                      <div class="collapse menu-dropdown" id="adminMenu">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link"><i
                                          class="ri-folder-2-line"></i> Group Name 1</a></li>
                              <li class="nav-item"><a href="#" class="nav-link"><i
                                          class="ri-folder-2-line"></i> Group Name 2</a></li>
                          </ul>
                      </div>
                  </li>

                  <!-- Frontend Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#frontendMenu" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="frontendMenu">
                          <i class="ri-window-line"></i> <span>Frontend</span>
                      </a>
                      <div class="collapse menu-dropdown" id="frontendMenu">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="#" class="nav-link"><i
                                          class="ri-folder-2-line"></i> Group Name 1</a></li>
                              <li class="nav-item"><a href="#" class="nav-link"><i
                                          class="ri-folder-2-line"></i> Group Name 2</a></li>
                          </ul>
                      </div>
                  </li>


                  <!-- CONNECTION MANAGEMENT -->
                  <li class="menu-title"><span>Connection Management</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-settings-3-line"></i> Settings</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-node-tree"></i>
                          Connection Type</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-layout-2-line"></i> Connection Layout</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-search-line"></i> Search & Filter</a></li>

                  <!-- INCOME -->
                  <li class="menu-title"><span>Income</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-group-line"></i> Sales Team</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-shopping-cart-line"></i> eCommerce</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-bill-line"></i>
                          Recurring Billing</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-store-2-line"></i> Marketplace</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-links-line"></i> Connected Network</a></li>






                  <!-- EXPENSES -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#EXPENSES" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="EXPENSES">
                          <i class="ri-money-dollar-circle-line"></i> <span>Expenses</span>
                      </a>
                  </li>

                  <!-- E-COMMERCE -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#E-COMMERCE" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="E-COMMERCE">
                          <i class="ri-shopping-cart-2-line"></i> <span>E-Commerce</span>
                      </a>
                  </li>

                  <!-- HUMAN RESOURCES -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#HUMANRESOURCES" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="HUMANRESOURCES">
                          <i class="ri-user-settings-line"></i> <span>Human Resources</span>
                      </a>
                  </li>

                  <!-- ACCOUNTING -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#ACCOUNTING" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="ACCOUNTING">
                          <i class="ri-file-list-3-line"></i> <span>Accounting</span>
                      </a>
                  </li>

                  <!-- FINANCIAL -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#FINANCIAL" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="FINANCIAL">
                          <i class="ri-funds-box-line"></i> <span>Financial</span>
                      </a>
                  </li>

                  <!-- TAXES -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#TAXES" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="TAXES">
                          <i class="ri-funds-box-line"></i><span>Taxes</span>
                      </a>
                  </li>
              @elseif(request()->routeIs('active-area.*'))
                  <!-- SETTINGS PAGE SIDEBAR -->
                  <li class="menu-title"><i class="ri-dashboard-2-line"></i>
                      <span>DASHBOARDS</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Main Dashboard</span>
                      </a>
                  </li> <!-- end Dashboard Menu -->





                  <!-- Sales -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-building-line"></i> <span>Sales</span>
                      </a>
                  </li>

                  <!-- Financial -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-team-line"></i> <span>Financial</span>
                      </a>
                  </li>

                  <!-- Current Tasks -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-folder-line"></i> <span>Current Tasks</span>
                      </a>
                  </li>


                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>Configuration</span></li>
                  <!-- Company PAGE SIDEBAR -->

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarmenucontrol">
                          <i class="ri-folder-3-line"></i> <span>Menu Control</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarmenucontrol">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.toolbar') }}"
                                      class="nav-link">ToolBar</a></li>
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.top-menu') }}"
                                      class="nav-link">Top Menu</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.breadcrumbs') }}"
                                      class="nav-link">Breadcrumbs</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.sidebar-left') }}"
                                      class="nav-link">Sidebar Left</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.sidebar-right') }}"
                                      class="nav-link">Sidebar Right</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('active-area.menu-management.bottom-menu') }}"
                                      class="nav-link">Bottom Menu</a>
                              </li>
                          </ul>
                      </div>
                  </li>



                  <!-- Start --->
                  <!-- QUICK ACCESS PAGE SIDEBAR -->
                  <li class="menu-title"><i class="ri-speed-line"></i>
                      <span>QUICK ACCESS</span>
                  </li>


                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-folder-line"></i> <span>Link 1</span>
                      </a>
                  </li>
                  <!-- Link 2 -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="">
                          <i class="ri-folder-line"></i> <span>Link 2</span>
                      </a>
                  </li>

                  <!-- Company PAGE SIDEBAR -->
                  <li class="menu-title"><i class="ri-building-line"></i>
                      <span>Company</span>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#companyname" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="companyname">
                          <i class="ri-building-line"></i> <span>Company Name 1</span>
                      </a>
                      <div class="collapse menu-dropdown" id="companyname">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="" class="nav-link">Dashboard</a></li>
                              <li class="nav-item"><a href="" class="nav-link">Quick Access</a></li>
                              <li class="nav-item"><a href="" class="nav-link">Locations</a></li>
                              <li class="nav-item"><a href="" class="nav-link">Departments</a></li>
                              <li class="nav-item"><a href="" class="nav-link">Employees</a></li>
                          </ul>
                      </div>

                  </li>

                  <!-- MANAGE PRODUCTS -->
                  <li class="menu-title"><span>Manage Products</span></li>

                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-archive-2-line"></i> Inventory</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-apps-2-line"></i> Categories</a></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#ManageProductsCentralized" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="ManageProductsCentralized">
                          <i class="ri-database-2-line"></i> Centralized
                      </a>
                      <div class="collapse menu-dropdown" id="ManageProductsCentralized">
                          <ul class="nav nav-sm flex-column">
                              <li><a href="" class="nav-link">Centralized Products</a></li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#ManageProductsDecentralized" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="ManageProductsDecentralized">
                          <i class="ri-server-line"></i> Decentralized
                      </a>
                      <div class="collapse menu-dropdown" id="ManageProductsDecentralized">
                          <ul class="nav nav-sm flex-column">
                              <li><a href="" class="nav-link">Decentralized Products</a></li>
                          </ul>
                      </div>
                  </li>


                  <!-- MANAGE CONTENT -->
                  <li class="menu-title"><span>Manage Content</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#ManageContentCentralized" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="ManageContentCentralized">
                          <i class="ri-database-2-fill"></i> Centralized
                      </a>
                      <div class="collapse menu-dropdown" id="ManageContentCentralized">
                          <ul class="nav nav-sm flex-column">
                              <li><a href="" class="nav-link">Production</a></li>
                              <li><a href="" class="nav-link">Channel</a></li>
                              <li><a href="" class="nav-link">Contacts</a></li>
                              <li><a href="" class="nav-link">Location</a></li>
                              <li><a href="" class="nav-link">Vendor</a></li>
                              <li><a href="" class="nav-link">Internal</a></li>
                              <li><a href="" class="nav-link">Activity</a></li>
                              <li><a href="" class="nav-link">Information</a></li>
                              <li><a href="" class="nav-link">Network</a></li>
                              <li><a href="" class="nav-link">Markets</a></li>
                              <li><a href="" class="nav-link">Installer</a></li>
                              <li><a href="" class="nav-link">Affiliate</a></li>
                              <li><a href="" class="nav-link">External</a></li>
                              <li><a href="" class="nav-link">Entry</a></li>
                              <li><a href="" class="nav-link">Promote</a></li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#ManageContentDecentralized" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="ManageContentDecentralized">
                          <i class="ri-server-fill"></i> Decentralized
                      </a>
                      <div class="collapse menu-dropdown" id="ManageContentDecentralized">
                          <ul class="nav nav-sm flex-column">
                              <li><a href="" class="nav-link">Production</a></li>
                              <li><a href="" class="nav-link">Channel</a></li>
                              <li><a href="" class="nav-link">Contacts</a></li>
                              <li><a href="" class="nav-link">Location</a></li>
                              <li><a href="" class="nav-link">Vendor</a></li>
                              <li><a href="" class="nav-link">Internal</a></li>
                              <li><a href="" class="nav-link">Activity</a></li>
                              <li><a href="" class="nav-link">Information</a></li>
                              <li><a href="" class="nav-link">Network</a></li>
                              <li><a href="" class="nav-link">Markets</a></li>
                              <li><a href="" class="nav-link">Installer</a></li>
                              <li><a href="" class="nav-link">Affiliate</a></li>
                              <li><a href="" class="nav-link">External</a></li>
                              <li><a href="" class="nav-link">Entry</a></li>
                              <li><a href="" class="nav-link">Promote</a></li>
                          </ul>
                      </div>
                  </li>


                  <!-- INCOME -->
                  <li class="menu-title"><span>Income</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#Orders" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="Orders">
                          <i class="ri-shopping-bag-3-line"></i> Orders
                      </a>
                      <div class="collapse menu-dropdown" id="Orders">
                          <ul class="nav nav-sm flex-column">
                              <li><a href="" class="nav-link">E-Commerce</a></li>
                              <li><a href="" class="nav-link">Marketplaces</a></li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-user-3-line"></i> Customers</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-bar-chart-2-line"></i> Reports</a></li>


                  <!-- PURCHASE ORDER -->
                  <li class="menu-title"><span>Purchase Order</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-map-pin-time-line"></i> Tracking</a></li>


                  <!-- EXPENSES -->
                  <li class="menu-title"><span>Expenses</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-file-list-2-line"></i> Purchase Orders</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i class="ri-bill-line"></i>
                          Invoices</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-alert-line"></i> Unpaid</a></li>


                  <!-- FRONTEND DESIGN -->
                  <li class="menu-title"><span>Frontend Design</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-layout-4-line"></i> Template</a></li>


                  <!-- TASK AND ACTIVITIES -->
                  <li class="menu-title"><span>Task and Activities</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i class="ri-todo-line"></i>
                          CWF - Content Work Flow</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-customer-service-2-line"></i> CRM</a></li>


                  <!-- FUNCTIONS -->
                  <li class="menu-title"><span>Functions</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-map-pin-line"></i> Map Locator</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i
                              class="ri-shield-keyhole-line"></i> Firewall</a></li>
              @else
                  <!-- DEFAULT SIDEBAR -->
                  <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarDashboards">
                          <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                      </a>
                  </li> <!-- end Dashboard Menu -->

                  
                  <!-- SETUP PAGE SIDEBAR -->
                  <li class="menu-title"><span>Configuration</span></li>
                  <!-- Company PAGE SIDEBAR -->

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarmenucontrol">
                          <i class="ri-folder-3-line"></i> <span>Menu Control</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarmenucontrol">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}"
                                      class="nav-link">ToolBar</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}"
                                      class="nav-link">Top Menu</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}"
                                      class="nav-link">Breadcrumbs</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.sidebar-left') }}"
                                      class="nav-link">Sidebar Left</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.sidebar-right') }}"
                                      class="nav-link">Sidebar Right</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.bottom-menu') }}"
                                      class="nav-link">Bottom Menu</a>
                              </li>
                          </ul>
                      </div>
                  </li>


                  <!-- USER & ROLE MANAGEMENT -->
                  <li class="menu-title"><i class="ri-shield-user-line"></i>
                      <span>User & Role Management</span>
                  </li>

                  <!-- Users -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('users.index') }}">
                          <i class="ri-user-line"></i> <span>Users</span>
                      </a>
                  </li>

                  <!-- Roles & Permissions -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                          <i class="ri-lock-unlock-line"></i> <span>Roles</span>
                      </a>
                  </li>

                  <!-- Activity Logs -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                          <i class="ri-history-line"></i> <span>Activity Logs</span>
                      </a>
                  </li>

                  <!-- Start --->



                  {{-- <li class="menu-title"><i class="ri-shopping-cart-line"></i>
                      <span data-key="t-ecommerce">Content Management</span>
                  </li>

                  <!-- Pages -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('content-types.index') }}">
                          <i class="ri-pages-line"></i> <span>Content Type</span>
                      </a>
                  </li>

                  <!-- Pages -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="{{ route('pages.index') }}">
                          <i class="ri-pages-line"></i> <span>Pages</span>
                      </a>
                  </li>

                  <!-- Blog / News / Articles -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/posts">
                          <i class="ri-article-line"></i> <span>Blog Posts</span>
                      </a>
                  </li>

                  <!-- Global Categories -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/categories">
                          <i class="ri-price-tag-3-line"></i> <span>Global Categories</span>
                      </a>
                  </li>

                  <!-- Media Library -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/media-library">
                          <i class="ri-image-line"></i> <span>Media Library</span>
                      </a>
                  </li>

                  <!-- Custom Content Types Dropdown -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCustomContent" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCustomContent">
                          <i class="ri-folder-3-line"></i> <span>Custom Content</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCustomContent">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/content-types" class="nav-link">Content
                                      Types</a></li>
                              <li class="nav-item"><a href="/admin/field-manager" class="nav-link">Field
                                      Manager</a></li>
                              <li class="nav-item"><a href="/admin/page-builder" class="nav-link">Page Builder</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.toolbar') }}" class="nav-link">Projects</a></li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.top-menu') }}" class="nav-link">Case Studies</a>
                              </li>
                              <li class="nav-item"><a href="{{ route('config.menu-management.breadcrumbs') }}" class="nav-link">Testimonials</a>
                              </li>
                          </ul>
                      </div>
                  </li>

 --}}


                  <!-- End  -->
                  <li class="menu-title"><i class="ri-shopping-cart-line"></i> <span
                          data-key="t-ecommerce">E-commerce</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarProducts">
                          <i class="ri-store-2-line"></i> <span data-key="t-products">Products</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarProducts">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/products" class="nav-link">All Products</a>
                              </li>
                              <li class="nav-item"><a href="/admin/products/create" class="nav-link">Add
                                      Product</a>
                              </li>
                              <li class="nav-item"><a href="/admin/brands" class="nav-link">Brands</a></li>
                              <li class="nav-item"><a href="/admin/attributes" class="nav-link">Attributes</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCategories" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCategories">
                          <i class="ri-price-tag-3-line"></i> <span data-key="t-categories">Categories</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCategories">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/categories" class="nav-link">All Categories</a>
                              </li>
                              <li class="nav-item"><a href="/admin/categories/create" class="nav-link">Add
                                      Category</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarOrders">
                          <i class="ri-file-list-3-line"></i> <span data-key="t-orders">Orders</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarOrders">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/orders" class="nav-link">All Orders</a></li>
                              <li class="nav-item"><a href="/admin/orders/pending" class="nav-link">Pending
                                      Orders</a>
                              </li>
                              <li class="nav-item"><a href="/admin/orders/completed" class="nav-link">Completed
                                      Orders</a></li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarCustomers" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarCustomers">
                          <i class="ri-user-line"></i> <span data-key="t-customers">Customers</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarCustomers">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/customers" class="nav-link">All Customers</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarShipping" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarShipping">
                          <i class="ri-truck-line"></i> <span data-key="t-shipping">Shipping</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarShipping">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/shipping-methods" class="nav-link">Shipping
                                      Methods</a></li>
                              <li class="nav-item"><a href="/admin/shipping-zones" class="nav-link">Shipping
                                      Zones</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarReports">
                          <i class="ri-bar-chart-line"></i> <span data-key="t-reports">Reports</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarReports">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item"><a href="/admin/sales-report" class="nav-link">Sales Report</a>
                              </li>
                              <li class="nav-item"><a href="/admin/inventory-report" class="nav-link">Inventory
                                      Report</a></li>
                          </ul>
                      </div>
                  </li>



                  <!-- COMPANY / ERP MANAGEMENT -->
                  <li class="menu-title"><i class="ri-building-line"></i>
                      <span>Company / ERP</span>
                  </li>

                  <!-- Companies -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/companies">
                          <i class="ri-building-4-line"></i> <span>Companies</span>
                      </a>
                  </li>

                  <!-- Departments / Teams -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/departments">
                          <i class="ri-group-line"></i> <span>Departments / Teams</span>
                      </a>
                  </li>

                  <!-- Employees -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/employees">
                          <i class="ri-user-settings-line"></i> <span>Employees</span>
                      </a>
                  </li>

                  <!-- Leave Management -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/leaves">
                          <i class="ri-calendar-check-line"></i> <span>Leave Management</span>
                      </a>
                  </li>

                  <!-- Payroll -->
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/payrolls">
                          <i class="ri-money-dollar-circle-line"></i> <span>Payroll</span>
                      </a>
                  </li>


                  <!-- 📊 Finance & Invoicing -->
                  <li class="menu-title"><i class="ri-file-text-line"></i>
                      <span>Finance & Invoicing</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/invoices">
                          <i class="ri-bill-line"></i> <span>Invoices</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/payments">
                          <i class="ri-bank-card-line"></i> <span>Payments</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/refunds">
                          <i class="ri-refund-2-line"></i> <span>Refunds</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/financial-reports">
                          <i class="ri-bar-chart-2-line"></i> <span>Financial Reports</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/tax-rules">
                          <i class="ri-percent-line"></i> <span>Tax Rules</span>
                      </a>
                  </li>

                  <!-- 🔄 Import / Export Tools -->
                  <li class="menu-title"><i class="ri-upload-cloud-2-line"></i>
                      <span>Import / Export</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/import">
                          <i class="ri-upload-2-line"></i> <span>CSV / XML Import</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/export">
                          <i class="ri-download-2-line"></i> <span>Export Data</span>
                      </a>
                  </li>

                  <!-- ⚙️ System Tools -->
                  <li class="menu-title"><i class="ri-tools-line"></i>
                      <span>System Tools</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/field-manager">
                          <i class="ri-list-settings-line"></i> <span>Field Manager</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/layout-builder">
                          <i class="ri-layout-3-line"></i> <span>Layout Builder</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/workflow-manager">
                          <i class="ri-loop-right-line"></i> <span>Workflow Manager</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/audit-logs">
                          <i class="ri-file-search-line"></i> <span>Audit Logs</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/settings">
                          <i class="ri-settings-3-line"></i> <span>Settings</span>
                      </a>
                  </li>

                  <!-- 🧰 Dev & Maintenance Tools -->
                  <li class="menu-title"><i class="ri-terminal-box-line"></i>
                      <span>Dev & Maintenance</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/api-keys">
                          <i class="ri-key-line"></i> <span>API Keys / Tokens</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/queue-monitor">
                          <i class="ri-stack-line"></i> <span>Queue Monitor</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/logs">
                          <i class="ri-file-warning-line"></i> <span>Logs</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/cache-config">
                          <i class="ri-restart-line"></i> <span>Cache / Config</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/backup-restore">
                          <i class="ri-database-2-line"></i> <span>Backup & Restore</span>
                      </a>
                  </li>

                  <!-- 🌐 Marketplace Integrations -->
                  <li class="menu-title"><i class="ri-global-line"></i>
                      <span>Marketplace</span>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/google-merchant">
                          <i class="ri-google-line"></i> <span>Google Merchant</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/amazon">
                          <i class="ri-amazon-line"></i> <span>Amazon</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="/admin/facebook-shop">
                          <i class="ri-facebook-box-line"></i> <span>Facebook / Instagram Shop</span>
                      </a>
                  </li>
              @endif

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
