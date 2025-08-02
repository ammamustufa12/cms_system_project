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
              <li class="menu-title"><span data-key="t-menu">Menu</span></li>
              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarDashboards">
                      <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                  </a>

              </li> <!-- end Dashboard Menu -->



                 <!-- USER & ROLE MANAGEMENT -->
              <li class="menu-title"><i class="ri-shield-user-line"></i>
                  <span>User & Role Management</span>
              </li>

              <!-- Users -->
              <li class="nav-item">
                  <a class="nav-link menu-link" href="{{ route('users.index')}}">
                      <i class="ri-user-line"></i> <span>Users</span>
                  </a>
              </li>

              <!-- Roles & Permissions -->
              <li class="nav-item">
                  <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                      <i class="ri-lock-unlock-line"></i> <span>Roles</span>
                  </a>
              </li>

             {{-- <li class="nav-item">
                  <a class="nav-link menu-link" href="{{ route('permissions.index') }}">
                      <i class="ri-lock-unlock-line"></i> <span> Permissions</span>
                  </a>
              </li> --}}

              <!-- Activity Logs -->
              <li class="nav-item">
                  <a class="nav-link menu-link" href="{{ route('activity_logs.index') }}">
                      <i class="ri-history-line"></i> <span>Activity Logs</span>
                  </a>
              </li>

              <!-- Start --->



              <li class="menu-title"><i class="ri-shopping-cart-line"></i>
                  <span data-key="t-ecommerce">Content Management</span>
              </li>

              <!-- Pages -->
              <li class="nav-item">
                  <a class="nav-link menu-link" href="{{ route('page.builder')}}">
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
                  <a class="nav-link menu-link" href="#sidebarCustomContent" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarCustomContent">
                      <i class="ri-folder-3-line"></i> <span>Custom Content</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarCustomContent">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/projects" class="nav-link">Projects</a></li>
                          <li class="nav-item"><a href="/admin/case-studies" class="nav-link">Case Studies</a></li>
                          <li class="nav-item"><a href="/admin/testimonials" class="nav-link">Testimonials</a></li>
                      </ul>
                  </div>
              </li>


              <!-- End  -->
              <li class="menu-title"><i class="ri-shopping-cart-line"></i> <span
                      data-key="t-ecommerce">E-commerce</span></li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarProducts">
                      <i class="ri-store-2-line"></i> <span data-key="t-products">Products</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarProducts">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/products" class="nav-link">All Products</a></li>
                          <li class="nav-item"><a href="/admin/products/create" class="nav-link">Add Product</a></li>
                          <li class="nav-item"><a href="/admin/brands" class="nav-link">Brands</a></li>
                          <li class="nav-item"><a href="/admin/attributes" class="nav-link">Attributes</a></li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarCategories" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarCategories">
                      <i class="ri-price-tag-3-line"></i> <span data-key="t-categories">Categories</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarCategories">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/categories" class="nav-link">All Categories</a></li>
                          <li class="nav-item"><a href="/admin/categories/create" class="nav-link">Add Category</a></li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarOrders">
                      <i class="ri-file-list-3-line"></i> <span data-key="t-orders">Orders</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarOrders">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/orders" class="nav-link">All Orders</a></li>
                          <li class="nav-item"><a href="/admin/orders/pending" class="nav-link">Pending Orders</a>
                          </li>
                          <li class="nav-item"><a href="/admin/orders/completed" class="nav-link">Completed
                                  Orders</a></li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarCustomers" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarCustomers">
                      <i class="ri-user-line"></i> <span data-key="t-customers">Customers</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarCustomers">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/customers" class="nav-link">All Customers</a></li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarShipping" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarShipping">
                      <i class="ri-truck-line"></i> <span data-key="t-shipping">Shipping</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarShipping">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/shipping-methods" class="nav-link">Shipping
                                  Methods</a></li>
                          <li class="nav-item"><a href="/admin/shipping-zones" class="nav-link">Shipping Zones</a>
                          </li>
                      </ul>
                  </div>
              </li>

              <li class="nav-item">
                  <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                      aria-expanded="false" aria-controls="sidebarReports">
                      <i class="ri-bar-chart-line"></i> <span data-key="t-reports">Reports</span>
                  </a>
                  <div class="collapse menu-dropdown" id="sidebarReports">
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item"><a href="/admin/sales-report" class="nav-link">Sales Report</a></li>
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






              {{-- <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                                <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Advance UI</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="advance-ui-sweetalerts.html" class="nav-link"
                                            data-key="t-sweet-alerts">Sweet
                                            Alerts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-nestable.html" class="nav-link"
                                            data-key="t-nestable-list">Nestable
                                            List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-scrollbar.html" class="nav-link"
                                            data-key="t-scrollbar">Scrollbar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-animation.html" class="nav-link"
                                            data-key="t-animation">Animation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-tour.html" class="nav-link" data-key="t-tour">Tour</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-swiper.html" class="nav-link"
                                            data-key="t-swiper-slider">Swiper
                                            Slider</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-ratings.html" class="nav-link"
                                            data-key="t-ratings">Ratings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-highlight.html" class="nav-link"
                                            data-key="t-highlight">Highlight</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="advance-ui-scrollspy.html" class="nav-link"
                                            data-key="t-scrollSpy">ScrollSpy</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="widgets.html">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Widgets</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarForms">
                                <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Forms</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarForms">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="forms-elements.html" class="nav-link" data-key="t-basic-elements">Basic
                                            Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-select.html" class="nav-link" data-key="t-form-select"> Form
                                            Select </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-checkboxs-radios.html" class="nav-link"
                                            data-key="t-checkboxs-radios">Checkboxs & Radios</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-pickers.html" class="nav-link" data-key="t-pickers"> Pickers </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-masks.html" class="nav-link" data-key="t-input-masks">Input
                                            Masks</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-advanced.html" class="nav-link"
                                            data-key="t-advanced">Advanced</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-range-sliders.html" class="nav-link" data-key="t-range-slider">
                                            Range
                                            Slider </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-validation.html" class="nav-link"
                                            data-key="t-validation">Validation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-wizard.html" class="nav-link" data-key="t-wizard">Wizard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-editors.html" class="nav-link" data-key="t-editors">Editors</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-file-uploads.html" class="nav-link"
                                            data-key="t-file-uploads">File
                                            Uploads</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-layouts.html" class="nav-link" data-key="t-form-layouts">Form
                                            Layouts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="forms-select2.html" class="nav-link" data-key="t-select2">Select2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTables">
                                <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Tables</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarTables">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="tables-basic.html" class="nav-link" data-key="t-basic-tables">Basic
                                            Tables</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="tables-gridjs.html" class="nav-link" data-key="t-grid-js">Grid Js</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="tables-listjs.html" class="nav-link" data-key="t-list-js">List Js</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="tables-datatables.html" class="nav-link"
                                            data-key="t-datatables">Datatables</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCharts">
                                <i class="ri-pie-chart-line"></i> <span data-key="t-charts">Charts</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarCharts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#sidebarApexcharts" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarApexcharts"
                                            data-key="t-apexcharts">
                                            Apexcharts
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarApexcharts">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="charts-apex-line.html" class="nav-link" data-key="t-line">
                                                        Line
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-area.html" class="nav-link" data-key="t-area">
                                                        Area
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-column.html" class="nav-link"
                                                        data-key="t-column">
                                                        Column </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-bar.html" class="nav-link" data-key="t-bar">
                                                        Bar </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-mixed.html" class="nav-link"
                                                        data-key="t-mixed"> Mixed
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-timeline.html" class="nav-link"
                                                        data-key="t-timeline">
                                                        Timeline </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-range-area.html" class="nav-link"
                                                        data-key="t-range-area">Range Area</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-funnel.html" class="nav-link"
                                                        data-key="t-funnel">Funnel</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-candlestick.html" class="nav-link"
                                                        data-key="t-candlstick"> Candlstick </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-boxplot.html" class="nav-link"
                                                        data-key="t-boxplot">
                                                        Boxplot </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-bubble.html" class="nav-link"
                                                        data-key="t-bubble">
                                                        Bubble </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-scatter.html" class="nav-link"
                                                        data-key="t-scatter">
                                                        Scatter </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-heatmap.html" class="nav-link"
                                                        data-key="t-heatmap">
                                                        Heatmap </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-treemap.html" class="nav-link"
                                                        data-key="t-treemap">
                                                        Treemap </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-pie.html" class="nav-link" data-key="t-pie">
                                                        Pie </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-radialbar.html" class="nav-link"
                                                        data-key="t-radialbar"> Radialbar </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-radar.html" class="nav-link"
                                                        data-key="t-radar"> Radar
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-polar.html" class="nav-link"
                                                        data-key="t-polar-area">
                                                        Polar Area </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="charts-apex-slope.html" class="nav-link"><span
                                                            data-key="t-slope">Slope</span> <span
                                                            class="badge badge-pill bg-success"
                                                            data-key="t-new">New</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="charts-chartjs.html" class="nav-link" data-key="t-chartjs"> Chartjs
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="charts-echarts.html" class="nav-link" data-key="t-echarts"> Echarts
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarIcons">
                                <i class="ri-compasses-2-line"></i> <span data-key="t-icons">Icons</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarIcons">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="icons-remix.html" class="nav-link"><span
                                                data-key="t-remix">Remix</span> <span
                                                class="badge badge-pill bg-info">v4.3</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="icons-boxicons.html" class="nav-link"><span
                                                data-key="t-boxicons">Boxicons</span> <span
                                                class="badge badge-pill bg-info">v2.1.4</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="icons-materialdesign.html" class="nav-link"><span
                                                data-key="t-material-design">Material Design</span> <span
                                                class="badge badge-pill bg-info">v7.2.96</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="icons-lineawesome.html" class="nav-link" data-key="t-line-awesome">Line
                                            Awesome</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="icons-feather.html" class="nav-link"><span
                                                data-key="t-feather">Feather</span> <span
                                                class="badge badge-pill bg-info">v4.29.2</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="icons-crypto.html" class="nav-link"> <span
                                                data-key="t-crypto-svg">Crypto SVG</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarMaps">
                                <i class="ri-map-pin-line"></i> <span data-key="t-maps">Maps</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMaps">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="maps-google.html" class="nav-link" data-key="t-google">
                                            Google
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="maps-vector.html" class="nav-link" data-key="t-vector">
                                            Vector
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="maps-leaflet.html" class="nav-link" data-key="t-leaflet">
                                            Leaflet
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                                <i class="ri-share-line"></i> <span data-key="t-multi-level">Multi Level</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMultilevel">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-level-1.1"> Level 1.1 </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarAccount"
                                            data-key="t-level-1.2"> Level
                                            1.2
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarAccount">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link" data-key="t-level-2.1"> Level 2.1 </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse"
                                                        role="button" aria-expanded="false" aria-controls="sidebarCrm"
                                                        data-key="t-level-2.2"> Level 2.2
                                                    </a>
                                                    <div class="collapse menu-dropdown" id="sidebarCrm">
                                                        <ul class="nav nav-sm flex-column">
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link" data-key="t-level-3.1">
                                                                    Level 3.1
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#" class="nav-link" data-key="t-level-3.2">
                                                                    Level 3.2
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
