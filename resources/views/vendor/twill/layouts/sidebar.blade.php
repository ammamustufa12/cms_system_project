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
                  <a class="nav-link menu-link" href="" data-bs-toggle="collapse" role="button"
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
                  <a class="nav-link menu-link" href="{{ route('page.builder') }}">
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
                          <li class="nav-item"><a href="/admin/categories/create" class="nav-link">Add Category</a>
                          </li>
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






          </ul>
      </div>
      <!-- Sidebar -->
  </div>
