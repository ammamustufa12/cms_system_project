  <style>
      #scrollbar {
          height: 100vh;
          /* Full screen height */
          overflow-y: auto;
          /* Enable vertical scrolling */
          padding-right: 4px;
          /* Optional: space for scrollbar */
      }

      /* Menu Control Position & Alignment Styles */
      .menu-control-wrapper {
          position: relative;
          width: 100%;
          margin-bottom: 10px;
      }

      /* Position Controls */
      .menu-control-wrapper.position-top {
          order: -1;
          /* Move to top */
      }

      .menu-control-wrapper.position-bottom {
          order: 999;
          /* Move to bottom */
      }

      .menu-control-wrapper.position-custom {
          order: 0;
          /* Default position */
      }

      /* Alignment Controls */
      .menu-control-wrapper.align-left .nav-link {
          text-align: left;
          justify-content: flex-start;
      }

      .menu-control-wrapper.align-center .nav-link {
          text-align: center;
          justify-content: center;
      }

      .menu-control-wrapper.align-right .nav-link {
          text-align: right;
          justify-content: flex-end;
      }

      /* Menu Control Styling */
      .menu-control-wrapper .nav-item {
          width: 100%;
      }

      .menu-control-wrapper .nav-link {
          display: flex;
          align-items: center;
          padding: 10px 15px;
          transition: all 0.3s ease;
      }

      .menu-control-wrapper .nav-link i {
          margin-right: 10px;
          font-size: 18px;
      }

      .menu-control-wrapper .menu-dropdown {
          padding-left: 20px;
      }

      .menu-control-wrapper .menu-dropdown .nav-link {
          padding: 8px 15px;
          font-size: 14px;
      }

      /* Active State */
      .menu-control-wrapper .nav-item.active .nav-link {
          background-color: rgba(0, 123, 255, 0.1);
          border-left: 3px solid #007bff;
      }

      .menu-control-wrapper .nav-link.active {
          color: #007bff;
          font-weight: 500;
      }
  </style>
  <div id="scrollbar">
      <div class="container-fluid">
          <div id="two-column-menu">
          </div>
          <ul class="navbar-nav" id="navbar-nav">
              @if (request()->routeIs(['config.*']))

                  @php
                      // For config routes, use route-specific sidebar-left menu type
                      // This ensures menu items added from config sidebar-left page appear only in config sidebar
                      $menuType = 'sidebar-left-config';

                      // Get menu items from database - get ALL visible and active items
                      $menuItems = \App\Models\MenuItem::ofType($menuType)
                          ->root()
                          ->where('is_visible', true)
                          ->where('is_active', true)
                          ->with([
                              'children' => function ($query) {
                                  $query->where('is_visible', true)->where('is_active', true)->orderBy('sort_order');
                              },
                          ])
                          ->orderBy('sort_order')
                          ->get();
                  @endphp

                  {{-- Menu Control - Simple Format like sidebar.blade copy.php --}}
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

                  {{-- Database Menu Items - Display like Menu Control --}}
                  @if ($menuItems->count() > 0)
                      @foreach ($menuItems as $item)
                          @php
                              $hasChildren = $item->children && $item->children->count() > 0;
                              $url = \App\Helpers\MenuHelper::getMenuItemUrl($item);
                              $target = $item->target_window === '_blank' ? ' target="_blank"' : '';
                              $icon = $item->icon ?? 'ri-menu-line';
                              $isActive = request()->url() === $url || request()->routeIs($item->url ?? '');

                              // Check if icon is a URL or class
                              $isIconUrl =
                                  $icon &&
                                  (str_starts_with($icon, 'http://') ||
                                      str_starts_with($icon, 'https://') ||
                                      str_starts_with($icon, '/') ||
                                      str_starts_with($icon, 'uploaded://'));
                              $iconHtml = '';
                              if ($isIconUrl) {
                                  // Icon is an image URL
                                  $iconHtml =
                                      '<img src="' .
                                      e($icon) .
                                      '" alt="icon" style="width: 18px; height: 18px; margin-right: 8px; vertical-align: middle;">';
                              } else {
                                  // Icon is a CSS class
                                  $iconHtml = '<i class="' . e($icon) . '"></i>';
                              }

                              // Generate unique collapse ID
                              $collapseId = 'sidebar' . Str::slug($item->title) . $item->id;
                          @endphp

                          <li class="nav-item{{ $isActive ? ' active' : '' }}" draggable="true"
                              data-menu-item-id="{{ $item->id }}"
                              data-menu-item-parent="{{ $item->parent_id ?? '' }}" style="cursor: move;">
                              @if ($hasChildren)
                                  {{-- Menu Item with Children - Collapse/Expand like Menu Control --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="#{{ $collapseId }}" data-bs-toggle="collapse" role="button"
                                      aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                      aria-controls="{{ $collapseId }}">
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                                  <div class="collapse menu-dropdown{{ $isActive ? ' show' : '' }}"
                                      id="{{ $collapseId }}">
                                      <ul class="nav nav-sm flex-column">
                                          @foreach ($item->children as $child)
                                              @php
                                                  $childUrl = \App\Helpers\MenuHelper::getMenuItemUrl($child);
                                                  $childTarget =
                                                      $child->target_window === '_blank' ? ' target="_blank"' : '';
                                                  $childActive =
                                                      request()->url() === $childUrl || request()->routeIs($child->url);
                                                  $childIcon = $child->icon ?? null;

                                                  // Check if child icon is a URL or class
                                                  $childIsIconUrl =
                                                      $childIcon &&
                                                      (str_starts_with($childIcon, 'http://') ||
                                                          str_starts_with($childIcon, 'https://') ||
                                                          str_starts_with($childIcon, '/') ||
                                                          str_starts_with($childIcon, 'uploaded://'));
                                                  $childIconHtml = '';
                                                  if ($childIcon) {
                                                      if ($childIsIconUrl) {
                                                          // Child icon is an image URL
                                                          $childIconHtml =
                                                              '<img src="' .
                                                              e($childIcon) .
                                                              '" alt="icon" style="width: 16px; height: 16px; margin-right: 6px; vertical-align: middle;">';
                                                      } else {
                                                          // Child icon is a CSS class
                                                          $childIconHtml =
                                                              '<i class="' .
                                                              e($childIcon) .
                                                              '" style="font-size: 14px;"></i> ';
                                                      }
                                                  }
                                              @endphp
                                              <li class="nav-item">
                                                  <a href="{{ $childUrl }}"
                                                      class="nav-link{{ $childActive ? ' active' : '' }}"{{ $childTarget }}>
                                                      {!! $childIconHtml !!}{{ $child->title }}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @else
                                  {{-- Menu Item without Children - Simple Link --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="{{ $url }}"{{ $target }}>
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                              @endif
                          </li>
                      @endforeach
                  @endif
                  {{-- Default Menu Control is always shown, followed by database menu items --}}
              @elseif (request()->routeIs(['setup.*', 'content-types.*', 'page.index']))

                  @php
                      // For setup routes, use route-specific sidebar-left menu type
                      // This ensures menu items added from setup sidebar-left page appear only in setup sidebar
                      $menuType = 'sidebar-left-setup';

                      // Get menu items from database - get ALL visible and active items
                      $menuItems = \App\Models\MenuItem::ofType($menuType)
                          ->root()
                          ->where('is_visible', true)
                          ->where('is_active', true)
                          ->with([
                              'children' => function ($query) {
                                  $query->where('is_visible', true)->where('is_active', true)->orderBy('sort_order');
                              },
                          ])
                          ->orderBy('sort_order')
                          ->get();
                  @endphp

                  {{-- Menu Control - Simple Format like sidebar.blade copy.php --}}
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarmenucontrol">
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

                  {{-- Database Menu Items - Display like Menu Control --}}
                  @if ($menuItems->count() > 0)
                      @foreach ($menuItems as $item)
                          @php
                              $hasChildren = $item->children && $item->children->count() > 0;
                              $url = \App\Helpers\MenuHelper::getMenuItemUrl($item);
                              $target = $item->target_window === '_blank' ? ' target="_blank"' : '';
                              $icon = $item->icon ?? 'ri-menu-line';
                              $isActive = request()->url() === $url || request()->routeIs($item->url ?? '');

                              // Check if icon is a URL or class
                              $isIconUrl =
                                  $icon &&
                                  (str_starts_with($icon, 'http://') ||
                                      str_starts_with($icon, 'https://') ||
                                      str_starts_with($icon, '/') ||
                                      str_starts_with($icon, 'uploaded://'));
                              $iconHtml = '';
                              if ($isIconUrl) {
                                  // Icon is an image URL
                                  $iconHtml =
                                      '<img src="' .
                                      e($icon) .
                                      '" alt="icon" style="width: 18px; height: 18px; margin-right: 8px; vertical-align: middle;">';
                              } else {
                                  // Icon is a CSS class
                                  $iconHtml = '<i class="' . e($icon) . '"></i>';
                              }

                              // Generate unique collapse ID
                              $collapseId = 'sidebar' . Str::slug($item->title) . $item->id;
                          @endphp

                          <li class="nav-item{{ $isActive ? ' active' : '' }}" draggable="true"
                              data-menu-item-id="{{ $item->id }}"
                              data-menu-item-parent="{{ $item->parent_id ?? '' }}" style="cursor: move;">
                              @if ($hasChildren)
                                  {{-- Menu Item with Children - Collapse/Expand like Menu Control --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="#{{ $collapseId }}" data-bs-toggle="collapse" role="button"
                                      aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                      aria-controls="{{ $collapseId }}">
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                                  <div class="collapse menu-dropdown{{ $isActive ? ' show' : '' }}"
                                      id="{{ $collapseId }}">
                                      <ul class="nav nav-sm flex-column">
                                          @foreach ($item->children as $child)
                                              @php
                                                  $childUrl = \App\Helpers\MenuHelper::getMenuItemUrl($child);
                                                  $childTarget =
                                                      $child->target_window === '_blank' ? ' target="_blank"' : '';
                                                  $childActive =
                                                      request()->url() === $childUrl || request()->routeIs($child->url);
                                                  $childIcon = $child->icon ?? null;

                                                  // Check if child icon is a URL or class
                                                  $childIsIconUrl =
                                                      $childIcon &&
                                                      (str_starts_with($childIcon, 'http://') ||
                                                          str_starts_with($childIcon, 'https://') ||
                                                          str_starts_with($childIcon, '/') ||
                                                          str_starts_with($childIcon, 'uploaded://'));
                                                  $childIconHtml = '';
                                                  if ($childIcon) {
                                                      if ($childIsIconUrl) {
                                                          // Child icon is an image URL
                                                          $childIconHtml =
                                                              '<img src="' .
                                                              e($childIcon) .
                                                              '" alt="icon" style="width: 16px; height: 16px; margin-right: 6px; vertical-align: middle;">';
                                                      } else {
                                                          // Child icon is a CSS class
                                                          $childIconHtml =
                                                              '<i class="' .
                                                              e($childIcon) .
                                                              '" style="font-size: 14px;"></i> ';
                                                      }
                                                  }
                                              @endphp
                                              <li class="nav-item">
                                                  <a href="{{ $childUrl }}"
                                                      class="nav-link{{ $childActive ? ' active' : '' }}"{{ $childTarget }}>
                                                      {!! $childIconHtml !!}{{ $child->title }}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @else
                                  {{-- Menu Item without Children - Simple Link --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="{{ $url }}"{{ $target }}>
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                              @endif
                          </li>
                      @endforeach
                  @endif
                  {{-- Default Menu Control is always shown, followed by database menu items --}}
              @elseif(request()->routeIs('active-area.*'))

                  @php
                      // For active-area routes, use route-specific sidebar-left menu type
                      // This ensures menu items added from active-area sidebar-left page appear only in active-area sidebar
                      $menuType = 'sidebar-left-active-area';

                      // Get menu items from database - get ALL visible and active items
                      $menuItems = \App\Models\MenuItem::ofType($menuType)
                          ->root()
                          ->where('is_visible', true)
                          ->where('is_active', true)
                          ->with([
                              'children' => function ($query) {
                                  $query->where('is_visible', true)->where('is_active', true)->orderBy('sort_order');
                              },
                          ])
                          ->orderBy('sort_order')
                          ->get();
                  @endphp

                  {{-- Menu Control - Simple Format like sidebar.blade copy.php --}}
                  <li class="nav-item">
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="sidebarmenucontrol">
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

                  {{-- Database Menu Items - Display like Menu Control --}}
                  @if ($menuItems->count() > 0)
                      @foreach ($menuItems as $item)
                          @php
                              $hasChildren = $item->children && $item->children->count() > 0;
                              $url = \App\Helpers\MenuHelper::getMenuItemUrl($item);
                              $target = $item->target_window === '_blank' ? ' target="_blank"' : '';
                              $icon = $item->icon ?? 'ri-menu-line';
                              $isActive = request()->url() === $url || request()->routeIs($item->url ?? '');

                              // Check if icon is a URL or class
                              $isIconUrl =
                                  $icon &&
                                  (str_starts_with($icon, 'http://') ||
                                      str_starts_with($icon, 'https://') ||
                                      str_starts_with($icon, '/') ||
                                      str_starts_with($icon, 'uploaded://'));
                              $iconHtml = '';
                              if ($isIconUrl) {
                                  // Icon is an image URL
                                  $iconHtml =
                                      '<img src="' .
                                      e($icon) .
                                      '" alt="icon" style="width: 18px; height: 18px; margin-right: 8px; vertical-align: middle;">';
                              } else {
                                  // Icon is a CSS class
                                  $iconHtml = '<i class="' . e($icon) . '"></i>';
                              }

                              // Generate unique collapse ID
                              $collapseId = 'sidebar' . Str::slug($item->title) . $item->id;
                          @endphp

                          <li class="nav-item{{ $isActive ? ' active' : '' }}" draggable="true"
                              data-menu-item-id="{{ $item->id }}"
                              data-menu-item-parent="{{ $item->parent_id ?? '' }}" style="cursor: move;">
                              @if ($hasChildren)
                                  {{-- Menu Item with Children - Collapse/Expand like Menu Control --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="#{{ $collapseId }}" data-bs-toggle="collapse" role="button"
                                      aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                                      aria-controls="{{ $collapseId }}">
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                                  <div class="collapse menu-dropdown{{ $isActive ? ' show' : '' }}"
                                      id="{{ $collapseId }}">
                                      <ul class="nav nav-sm flex-column">
                                          @foreach ($item->children as $child)
                                              @php
                                                  $childUrl = \App\Helpers\MenuHelper::getMenuItemUrl($child);
                                                  $childTarget =
                                                      $child->target_window === '_blank' ? ' target="_blank"' : '';
                                                  $childActive =
                                                      request()->url() === $childUrl || request()->routeIs($child->url);
                                                  $childIcon = $child->icon ?? null;

                                                  // Check if child icon is a URL or class
                                                  $childIsIconUrl =
                                                      $childIcon &&
                                                      (str_starts_with($childIcon, 'http://') ||
                                                          str_starts_with($childIcon, 'https://') ||
                                                          str_starts_with($childIcon, '/') ||
                                                          str_starts_with($childIcon, 'uploaded://'));
                                                  $childIconHtml = '';
                                                  if ($childIcon) {
                                                      if ($childIsIconUrl) {
                                                          // Child icon is an image URL
                                                          $childIconHtml =
                                                              '<img src="' .
                                                              e($childIcon) .
                                                              '" alt="icon" style="width: 16px; height: 16px; margin-right: 6px; vertical-align: middle;">';
                                                      } else {
                                                          // Child icon is a CSS class
                                                          $childIconHtml =
                                                              '<i class="' .
                                                              e($childIcon) .
                                                              '" style="font-size: 14px;"></i> ';
                                                      }
                                                  }
                                              @endphp
                                              <li class="nav-item">
                                                  <a href="{{ $childUrl }}"
                                                      class="nav-link{{ $childActive ? ' active' : '' }}"{{ $childTarget }}>
                                                      {!! $childIconHtml !!}{{ $child->title }}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @else
                                  {{-- Menu Item without Children - Simple Link --}}
                                  <a class="nav-link menu-link{{ $isActive ? ' active' : '' }}"
                                      href="{{ $url }}"{{ $target }}>
                                      {!! $iconHtml !!} <span>{{ $item->title }}</span>
                                  </a>
                              @endif
                          </li>
                      @endforeach
                  @endif
                  {{-- Default Menu Control is always shown, followed by database menu items --}}
              @else


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
                      <a class="nav-link menu-link" href="#decentralized" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="decentralized">
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
                      <a class="nav-link menu-link" href="#frontendMenu" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="frontendMenu">
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
                  </li> --}}


                  <!-- CONNECTION MANAGEMENT -->
                  {{-- <li class="menu-title"><span>Connection Management</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-settings-3-line"></i> Settings</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-node-tree"></i>
                          Connection Type</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-layout-2-line"></i>
                          Connection Layout</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-search-line"></i>
                          Search & Filter</a></li>

                  <!-- INCOME -->
                  <li class="menu-title"><span>Income</span></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-group-line"></i>
                          Sales Team</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i
                              class="ri-shopping-cart-line"></i> eCommerce</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-bill-line"></i>
                          Recurring Billing</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-store-2-line"></i>
                          Marketplace</a></li>
                  <li class="nav-item"><a class="nav-link menu-link" href="#"><i class="ri-links-line"></i>
                          Connected Network</a></li>






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
                      <a class="nav-link menu-link" href="#HUMANRESOURCES" data-bs-toggle="collapse" role="button"
                          aria-expanded="false" aria-controls="HUMANRESOURCES">
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
                  </li> --}}





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
                  <li class="nav-item"><a class="nav-link menu-link" href=""><i class="ri-apps-2-line"></i>
                          Categories</a></li>

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
                      <a class="nav-link menu-link" href="#sidebarmenucontrol" data-bs-toggle="collapse"
                          role="button" aria-expanded="false" aria-controls="sidebarmenucontrol">
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

  @if (request()->routeIs(['config.*']))
      <script>
          // Menu Control Position & Alignment Functions
          window.setMenuControlPosition = function(position) {
              const wrapper = document.getElementById('menuControlWrapper');
              if (wrapper) {
                  // Remove existing position classes
                  wrapper.classList.remove('position-top', 'position-bottom', 'position-custom');
                  // Add new position class
                  wrapper.classList.add('position-' + position);

                  // Save to session/localStorage
                  sessionStorage.setItem('menu_control_position', position);

                  // Optional: Send to server to persist
                  fetch('{{ url('admin/config/menu-control/settings') }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                              'content') || ''
                      },
                      body: JSON.stringify({
                          position: position
                      })
                  }).catch(err => console.log('Settings save optional'));
              }
          };

          window.setMenuControlAlignment = function(align) {
              const wrapper = document.getElementById('menuControlWrapper');
              if (wrapper) {
                  // Remove existing alignment classes
                  wrapper.classList.remove('align-left', 'align-center', 'align-right');
                  // Add new alignment class
                  wrapper.classList.add('align-' + align);

                  // Save to session/localStorage
                  sessionStorage.setItem('menu_control_align', align);

                  // Optional: Send to server to persist
                  fetch('{{ url('admin/config/menu-control/settings') }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                              'content') || ''
                      },
                      body: JSON.stringify({
                          align: align
                      })
                  }).catch(err => console.log('Settings save optional'));
              }
          };

          // Load saved settings on page load
          document.addEventListener('DOMContentLoaded', function() {
              const savedPosition = sessionStorage.getItem('menu_control_position') || 'top';
              const savedAlign = sessionStorage.getItem('menu_control_align') || 'left';

              if (document.getElementById('menuControlWrapper')) {
                  setMenuControlPosition(savedPosition);
                  setMenuControlAlignment(savedAlign);
              }
          });

          // Menu Item Management Functions
          window.toggleMenuActive = function(itemId, element) {
              element.classList.toggle('active');
              const isActive = element.classList.contains('active');

              fetch('/admin/config/menu-management/items/' + itemId, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                              'content') || ''
                      },
                      body: JSON.stringify({
                          is_active: isActive
                      })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (!data.success) {
                          element.classList.toggle('active');
                          alert('Error updating menu item status');
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      element.classList.toggle('active');
                  });
          };

          window.toggleMenuVisibility = function(itemId, isVisible) {
              fetch('/admin/config/menu-management/items/' + itemId, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                              'content') || ''
                      },
                      body: JSON.stringify({
                          is_visible: isVisible
                      })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (!data.success) {
                          alert('Error updating menu item visibility');
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                  });
          };

          window.toggleSubMenu = function(element) {
              const menuItem = element.closest('li');
              if (menuItem) {
                  const subMenu = menuItem.querySelector('.sidebar-sub-menu');
                  if (subMenu) {
                      if (subMenu.style.display === 'none' || !subMenu.style.display) {
                          subMenu.style.display = 'block';
                          element.innerHTML = '⌄';
                      } else {
                          subMenu.style.display = 'none';
                          element.innerHTML = '▶';
                      }
                  }
              }
          };

          window.addSubMenuItem = function(parentId) {
              // Redirect to sidebar-left page with parent pre-selected
              window.location.href = '{{ route('config.menu-management.sidebar-left') }}?parent=' + parentId;
          };

          window.editSidebarMenuItem = function(itemId) {
              // Redirect to sidebar-left page with item to edit
              window.location.href = '{{ route('config.menu-management.sidebar-left') }}?edit=' + itemId;
          };

          window.deleteSidebarMenuItem = function(itemId) {
              if (confirm('Are you sure you want to delete this menu item?')) {
                  fetch('/admin/config/menu-management/items/' + itemId, {
                          method: 'DELETE',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                  'content') || ''
                          }
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              location.reload();
                          } else {
                              alert('Error deleting menu item: ' + (data.message || 'Unknown error'));
                          }
                      })
                      .catch(error => {
                          console.error('Error:', error);
                          alert('Error deleting menu item. Please try again.');
                      });
              }
          };

          document.addEventListener('DOMContentLoaded', function() {
              let draggedElement = null;

              // Get all draggable menu items in sidebar
              const menuItems = document.querySelectorAll('[data-menu-item-id]');

              menuItems.forEach(item => {
                  // Drag start
                  item.addEventListener('dragstart', function(e) {
                      draggedElement = this;
                      this.style.opacity = '0.5';
                      e.dataTransfer.effectAllowed = 'move';
                      e.dataTransfer.setData('text/html', this.outerHTML);
                      e.dataTransfer.setData('text/plain', this.dataset.menuItemId);
                  });

                  // Drag end
                  item.addEventListener('dragend', function(e) {
                      this.style.opacity = '1';
                      document.querySelectorAll('.drag-over-sidebar').forEach(el => {
                          el.classList.remove('drag-over-sidebar');
                      });
                      draggedElement = null;
                  });

                  // Drag over
                  item.addEventListener('dragover', function(e) {
                      e.preventDefault();
                      e.dataTransfer.dropEffect = 'move';

                      if (draggedElement && draggedElement !== this) {
                          // Don't allow dropping on itself or its children
                          if (this.contains(draggedElement)) {
                              return;
                          }

                          this.classList.add('drag-over-sidebar');
                          this.style.backgroundColor = '#e3f2fd';
                      }
                  });

                  // Drag leave
                  item.addEventListener('dragleave', function(e) {
                      this.classList.remove('drag-over-sidebar');
                      this.style.backgroundColor = '';
                  });

                  // Drop
                  item.addEventListener('drop', function(e) {
                      e.preventDefault();
                      this.classList.remove('drag-over-sidebar');
                      this.style.backgroundColor = '';

                      if (draggedElement && draggedElement !== this) {
                          const draggedId = draggedElement.dataset.menuItemId;
                          const targetId = this.dataset.menuItemId;
                          const targetParentId = this.dataset.menuItemParent;

                          // Don't allow dropping on itself or its children
                          if (this.contains(draggedElement)) {
                              return;
                          }

                          // Check if we're creating a submenu (dropping on a parent item)
                          const isParentItem = !targetParentId || targetParentId === '';
                          const draggedParentId = draggedElement.dataset.menuItemParent || '';

                          if (isParentItem && draggedParentId !== targetId) {
                              // Create submenu - update parent_id in database
                              updateMenuItemParent(draggedId, targetId);
                          } else if (!isParentItem) {
                              // Move within same level or reorder
                              updateMenuItemParent(draggedId, targetParentId);
                          }
                      }
                  });
              });

              // Function to update parent_id in database
              function updateMenuItemParent(itemId, parentId) {
                  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                  fetch('/admin/config/menu-management/items/' + itemId, {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': csrfToken,
                              'Accept': 'application/json',
                              'X-Requested-With': 'XMLHttpRequest'
                          },
                          body: JSON.stringify({
                              parent_id: parentId ? parseInt(parentId) : null
                          })
                      })
                      .then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              // Reload page to show updated menu structure
                              setTimeout(() => {
                                  window.location.reload();
                              }, 500);
                          } else {
                              alert('Error updating menu: ' + (data.message || 'Unknown error'));
                          }
                      })
                      .catch(error => {
                          console.error('Error:', error);
                          alert('Error updating menu. Please try again.');
                      });
              }

              // Add CSS for drag-over effect
              const style = document.createElement('style');
              style.textContent = `
              [data-menu-item-id].drag-over-sidebar {
                  border: 2px dashed #007bff !important;
                  border-radius: 4px;
              }
              [data-menu-item-id] {
                  transition: background-color 0.2s;
              }
          `;
              document.head.appendChild(style);
          });
      </script>
  @endif
