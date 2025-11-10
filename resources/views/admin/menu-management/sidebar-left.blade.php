@extends('twill::layouts.main')

@section('title', 'Menu Links - Toolbar')

@section('content')
<style>
    .menu-management-container {
        width: 100%;
        min-height: calc(100vh - 100px);
        padding: 15px;
        background: #f8f9fa;
    }
    
    .left-panel {
        background: white;
        border-radius: 8px;
        padding: 15px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        width: 100%;
        max-height: calc(100vh - 200px);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .menu-management-container {
            padding: 10px;
        }
        
        .left-panel {
            padding: 10px;
        }
        
        .search-filter-controls {
            padding: 10px 15px;
        }
        
        .search-input-group input {
            width: 150px !important;
        }
        
        .d-flex.gap-3 {
            gap: 10px !important;
        }
        
        .btn {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .breadcrumb {
            font-size: 12px;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .menu-management-container {
            padding: 5px;
        }
        
        .left-panel {
            padding: 8px;
        }
        
        .search-filter-controls {
            padding: 8px 10px;
        }
        
        .search-input-group {
            flex-direction: column;
            gap: 5px;
        }
        
        .search-input-group input {
            width: 100% !important;
        }
        
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 8px !important;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 12px;
            min-height: 44px; /* Touch-friendly size */
        }
        
        .menu-item {
            padding: 12px;
            margin: 8px 0;
            min-height: 60px; /* Touch-friendly size */
        }
        
        .menu-item input[type="text"] {
            font-size: 16px; /* Prevent zoom on iOS */
        }
        
        .actions button {
            width: 44px;
            height: 44px;
            font-size: 16px;
            margin: 0 2px;
        }
        
        .drag-handle {
            font-size: 20px;
            padding: 10px;
        }
        
        .toggle-switch {
            width: 60px;
            height: 30px;
        }
        
        .toggle-switch::after {
            width: 26px;
            height: 26px;
        }
        
        .toggle-switch.active::after {
            transform: translateX(30px);
        }
        
        /* Touch-friendly modal */
        .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px);
        }
        
        .modal-body {
            padding: 15px;
        }
        
        .form-control {
            min-height: 44px;
            font-size: 16px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
        }
    }
    
    /* Touch interactions */
    @media (hover: none) and (pointer: coarse) {
        .menu-item:hover {
            transform: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .menu-item:active {
            transform: scale(0.98);
            background: #e9ecef;
        }
        
        .btn:active {
            transform: scale(0.95);
        }
        
        .actions button:active {
            transform: scale(0.9);
        }
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 15px;
        margin: 8px 0;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        cursor: move;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .menu-item:hover {
        background: #e9ecef;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .menu-item.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .menu-item.drag-over {
        border: 2px dashed #007bff;
        background: #e3f2fd;
    }
    
    .menu-item .drag-handle {
        cursor: grab;
        margin-right: 15px;
        color: #6c757d;
        font-size: 18px;
        font-weight: bold;
    }
    
    .menu-item .drag-handle:active {
        cursor: grabbing;
    }
    
    .menu-item input[type="text"] {
        border: none;
        background: transparent;
        font-size: 16px;
        font-weight: 500;
        flex: 1;
        margin: 0 10px;
    }
    
    .menu-item input[type="text"]:focus {
        outline: none;
        background: white;
        border: 1px solid #007bff;
        border-radius: 4px;
        padding: 5px;
    }
    
    .menu-item .menu-url {
        flex: 1.5;
        min-width: 200px;
        max-width: 400px;
        font-size: 14px;
        font-weight: 400;
        color: #6c757d;
    }
    
    .menu-item .menu-url:focus {
        color: #212529;
    }
    
    .menu-item .toggle-switch {
        position: relative;
        width: 50px;
        height: 25px;
        background: #ccc;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .menu-item .toggle-switch.active {
        background: #007bff;
    }
    
    .menu-item .toggle-switch::after {
        content: '';
        position: absolute;
        width: 21px;
        height: 21px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: transform 0.3s;
    }
    
    .menu-item .toggle-switch.active::after {
        transform: translateX(25px);
    }
    
    .menu-item .actions {
        display: flex;
        gap: 8px;
        margin-left: 10px;
    }
    
    .menu-item .actions button {
        width: 30px;
        height: 30px;
        border: none;
        background: #007bff;
        color: white;
        border-radius: 50%;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .menu-item .actions button:hover {
        background: #0056b3;
    }
    
    .sub-menu {
        margin-left: 40px;
        border-left: 3px solid #dee2e6;
        padding-left: 20px;
        margin-top: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .sub-menu-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        margin: 5px 0;
        padding: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .sub-menu-item:hover {
        background: #e3f2fd;
        border-color: #007bff;
        transform: translateX(5px);
    }
    
    .sub-menu-item.dragging {
        opacity: 0.7;
        transform: rotate(2deg) scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .sub-menu-item.drag-over {
        border: 2px dashed #007bff;
        background: #e3f2fd;
        transform: scale(1.02);
    }
    
    /* Drop zone indicators */
    .drop-zone {
        border: 2px dashed #007bff;
        background: #e3f2fd;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        color: #007bff;
        font-weight: 500;
        margin: 10px 0;
        transition: all 0.3s ease;
    }
    
    .drop-zone:hover {
        background: #bbdefb;
        border-color: #0056b3;
    }
    
    .drop-zone.active {
        background: #007bff;
        color: white;
        border-color: #0056b3;
    }
    
    /* Expand/Collapse animations */
    .sub-menu.collapsed {
        max-height: 0;
        overflow: hidden;
        padding: 0 15px;
        margin: 0;
        opacity: 0;
    }
    
    .sub-menu.expanded {
        max-height: 1000px;
        opacity: 1;
    }
    
    /* Visual hierarchy indicators */
    .menu-item.has-submenu {
        border-left: 4px solid #007bff;
        background: linear-gradient(90deg, #e3f2fd 0%, #f8f9fa 100%);
    }
    
    .menu-item.has-submenu .expand-icon {
        color: #007bff;
        font-weight: bold;
        font-size: 18px;
        transition: transform 0.3s ease;
    }
    
    .menu-item.has-submenu .expand-icon:hover {
        transform: scale(1.2);
        color: #0056b3;
    }
    
    /* Drag and drop visual feedback */
    .menu-item.drag-over {
        border: 2px dashed #28a745;
        background: #d4edda;
        transform: scale(1.02);
    }
    
    .menu-item.drag-over::after {
        content: "Drop here to create sub-menu";
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
    }
    
    /* Sub-menu creation animation */
    @keyframes subMenuCreation {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        50% {
            opacity: 0.7;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .sub-menu.newly-created {
        animation: subMenuCreation 0.5s ease-out;
    }
    
    /* Mobile touch improvements */
    @media (max-width: 768px) {
        .sub-menu {
            margin-left: 20px;
            padding-left: 15px;
        }
        
        .sub-menu-item {
            padding: 10px;
            margin: 3px 0;
        }
        
        .menu-item.drag-over::after {
            font-size: 10px;
            padding: 2px 6px;
        }
    }
    
    /* Menu Type Selector Styles */
    .menu-type-selector {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
        min-width: 200px;
    }
    
    .menu-type-selector .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .menu-type-selector .form-control {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        background: white;
        transition: all 0.3s ease;
    }
    
    .menu-type-selector .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Menu Type Specific Styling */
    .menu-type-toolbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .menu-type-top-menu {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .menu-type-bottom-menu {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .menu-type-breadcrumbs {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .menu-type-sidebar-right {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .menu-type-sidebar-left {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
    }
    
    .menu-type-footer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .menu-type-mobile {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        color: #333;
    }
    
    .menu-type-admin {
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        color: white;
    }
    
    .menu-type-user {
        background: linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%);
        color: #333;
    }
    
    /* Responsive menu type selector */
    @media (max-width: 768px) {
        .menu-type-selector {
            min-width: 150px;
            padding: 8px 12px;
        }
        
        .menu-type-selector .form-label {
            font-size: 11px;
        }
        
        .menu-type-selector .form-control {
            font-size: 12px;
        }
    }
    
    .mega-menu-section {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin: 10px 0;
    }
    
    .mega-menu-columns {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin: 15px 0;
    }
    
    .mega-menu-column {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
    }
    
    .mega-menu-column input {
        width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 8px;
        margin: 5px 0;
    }
    
    .radio-group {
        display: flex;
        gap: 15px;
        margin: 10px 0;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .alignment-buttons {
        display: flex;
        gap: 5px;
    }
    
    .alignment-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #dee2e6;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .alignment-btn.active {
        background: #007bff;
        color: white;
    }
    
    .expand-icon {
        cursor: pointer;
        color: #6c757d;
        font-size: 16px;
    }
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        color: #6c757d;
    }
    
    .breadcrumb-separator {
        color: #6c757d;
    }
    
    .breadcrumb-item.active {
        color: #007bff;
        font-weight: 500;
    }
    
    .breadcrumb-navigation {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
        padding: 0;
    }
    
    .breadcrumb-navigation .breadcrumb-item {
        color: #6c757d;
        font-weight: normal;
    }
    
    .breadcrumb-navigation .breadcrumb-item.active {
        color: #333;
        font-weight: 500;
    }
    
    .breadcrumb-navigation .breadcrumb-separator {
        color: #6c757d;
        margin: 0 5px;
    }
    
    /* Simple Breadcrumb Styles */
    
    /* Responsive breadcrumb */
    @media (max-width: 768px) {
        .breadcrumb-simple {
            padding: 6px 8px;
            font-size: 12px;
        }
        
        .breadcrumb-simple .breadcrumb-separator {
            margin: 0 4px;
        }
        
        .breadcrumb-simple i {
            font-size: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .breadcrumb-simple {
            padding: 4px 6px;
            font-size: 11px;
            flex-wrap: wrap;
        }
        
        .breadcrumb-simple .breadcrumb-item {
            margin: 2px 0;
        }
    }
    
    .search-filter-controls {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    
    .search-input-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .search-input-group input {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
    }
    
    .search-input-group button {
        border: 1px solid #dee2e6;
        background: white;
        color: #6c757d;
        border-radius: 4px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }
    
    .search-input-group button:hover {
        background: #e9ecef;
        color: #333;
    }
    
    .btn-outline-secondary {
        border: 1px solid #dee2e6;
        background: white;
        color: #6c757d;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background: #e9ecef;
        color: #333;
        border-color: #adb5bd;
    }
    
    .btn-warning {
        background: #ffc107;
        border: 1px solid #ffc107;
        color: #000;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-warning:hover {
        background: #e0a800;
        border-color: #d39e00;
        color: #000;
    }
    
    .btn-primary {
        background: #007bff;
        border: 1px solid #007bff;
        color: white;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: #0056b3;
        border-color: #004085;
    }
    
    .size-option, .layout-option, .view-option, .color-option {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin: 8px 0;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .size-option:hover, .layout-option:hover, .view-option:hover, .color-option:hover {
        background: #e9ecef;
        border-color: #adb5bd;
    }
    
    .size-option.selected, .layout-option.selected, .view-option.selected, .color-option.selected {
        background: #e3f2fd;
        border-color: #007bff;
        color: #007bff;
    }
    
    .level-item {
        padding: 10px;
        margin: 8px 0;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
    }
    
    .level-content {
        display: none;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
    }
    
    .level-item.active .level-content {
        display: block;
    }
    
    .background-image-preview {
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
    
    /* Mega Menu Modal Styles */
    .mega-columns-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        background: #f8f9fa;
    }
    
    .mega-column-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .mega-column-item:last-child {
        margin-bottom: 0;
    }
    
    .column-content {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
        margin-top: 10px;
    }
    
    .mega-menu-preview {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .preview-content {
        text-align: center;
        color: #6c757d;
    }
    
    /* Mega Menu Preview Styles */
    .mega-menu-preview .mega-menu-demo {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 600px;
    }
    
    .mega-menu-demo .demo-columns {
        display: grid;
        gap: 20px;
        margin-top: 15px;
    }
    
    .mega-menu-demo .demo-column {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 15px;
    }
    
    .mega-menu-demo .demo-column h6 {
        color: #007bff;
        font-weight: 600;
        margin-bottom: 10px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }
    
    .mega-menu-demo .demo-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .mega-menu-demo .demo-column li {
        padding: 5px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .mega-menu-demo .demo-column li:last-child {
        border-bottom: none;
    }
    
    .mega-menu-demo .demo-column a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .mega-menu-demo .demo-column a:hover {
        color: #007bff;
    }
    
    /* Responsive Mega Menu */
    @media (max-width: 768px) {
        .mega-columns-container {
            max-height: 300px;
        }
        
        .mega-column-item {
            padding: 10px;
        }
        
        .mega-menu-preview {
            min-height: 150px;
            padding: 15px;
        }
    }
</style>

<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 80px;padding-left:30px;">
    <div>
        <h2 class="mb-0">MENU LINKS - <span id="currentMenuType">Sidebar Left - {{ ucfirst($routePrefix ?? 'Config') }}</span></h2>
        <small class="text-muted">Manage menu items for {{ ucfirst($routePrefix ?? 'Config') }} section sidebar</small>
    </div>
    <div class="d-flex align-items-center gap-3">
        <!-- Menu Control Menu -->
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="menuControlDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-folder-3-line me-1"></i> Menu Control
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuControlDropdown">
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.toolbar') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.toolbar') }}">
                    <i class="ri-menu-line me-2"></i>ToolBar
                </a></li>
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.top-menu') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.top-menu') }}">
                    <i class="ri-menu-2-line me-2"></i>Top Menu
                </a></li>
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.breadcrumbs') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.breadcrumbs') }}">
                    <i class="ri-links-line me-2"></i>Breadcrumbs
                </a></li>
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.sidebar-left') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.sidebar-left') }}">
                    <i class="ri-layout-sidebar-line me-2"></i>Sidebar Left
                </a></li>
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.sidebar-right') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.sidebar-right') }}">
                    <i class="ri-layout-right-line me-2"></i>Sidebar Right
                </a></li>
                <li><a class="dropdown-item{{ request()->routeIs($routePrefix . '.menu-management.bottom-menu') ? ' active' : '' }}" href="{{ route($routePrefix . '.menu-management.bottom-menu') }}">
                    <i class="ri-menu-unfold-line me-2"></i>Bottom Menu
                </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Search and Filter Controls -->
<div class="search-filter-controls mb-4">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <!-- Search Input -->
        <div class="search-input-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Search menu items..." style="width: 200px;" onkeyup="searchMenuItems(this.value)">
            <button class="btn btn-outline-secondary" onclick="clearSearch()">
                <i class="ri-search-line"></i>
            </button>
        </div>
        
        <!-- Filter Options -->
        <button class="btn btn-outline-secondary">
            Filter Options <i class="ri-arrow-down-s-line ms-1"></i>
        </button>
        
        <!-- Clear Button -->
        <button class="btn btn-outline-secondary" onclick="clearAllFilters()">Clear</button>
        
        <!-- Ordering Dropdown -->
        <select class="form-control" style="width: 150px;">
            <option>Ordering ascending</option>
            <option>Ordering descending</option>
            <option>Name A-Z</option>
            <option>Name Z-A</option>
        </select>
        
        <!-- Items Per Page -->
        <select class="form-control" style="width: 80px;">
            <option>20</option>
            <option>50</option>
            <option>100</option>
        </select>
        
        <!-- Second Search -->
        <div class="search-input-group">
            <i class="ri-search-line me-2"></i>
            <input type="text" class="form-control" placeholder="Search for candidate na" style="width: 200px;">
        </div>
        
        <!-- Action Buttons -->
        <div class="ms-auto d-flex gap-2">
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#newMenuModal">
                <i class="ri-add-line me-1"></i> New Menu
            </button>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                <i class="ri-upload-line me-1"></i> Bulk Import
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#defaultSettingsModal">
                Default Settings
            </button>
        </div>
    </div>
</div>

<div class="menu-management-container">
    <!-- Left Panel: Menu Links Management -->
    <div class="left-panel">
        <div class="menu-links-list" id="menu-links-list">
            @php
                // Debug: Check if menuItems exist
                $hasItems = isset($menuItems) && $menuItems->count() > 0;
            @endphp
            @if($hasItems)
                @foreach($menuItems as $item)
                    @php
                        $hasChildren = $item->children && $item->children->count() > 0;
                        $menuData = json_encode([
                            'title' => $item->title,
                            'alias' => $item->alias,
                            'menuType' => $item->menu_type,
                            'menuItemType' => $item->menu_item_type,
                            'url' => $item->url,
                            'icon' => $item->icon,
                            'targetWindow' => $item->target_window,
                            'accessLevel' => $item->access_level,
                            'styling' => $item->styling,
                            'advanced' => $item->advanced,
                            'megaMenuSettings' => $item->mega_menu_settings,
                        ]);
                    @endphp
                    
                    <!-- Menu Item: {{ $item->title }} -->
                    <div class="menu-item" draggable="true" data-id="{{ $item->id }}" data-menu-data="{{ htmlspecialchars($menuData, ENT_QUOTES, 'UTF-8') }}">
                        <span class="drag-handle">⋮⋮</span>
                        <input type="checkbox" {{ $item->is_visible ? 'checked' : '' }} onchange="updateMenuVisibility({{ $item->id }}, this.checked)">
                        <input type="text" value="{{ $item->title }}" class="menu-name" onchange="updateMenuTitle({{ $item->id }}, this.value)">
                        <div class="toggle-switch {{ $item->is_active ? 'active' : '' }}" onclick="toggleSwitch(this)"></div>
                        @if($hasChildren)
                            <span class="expand-icon" onclick="toggleSubMenuExpand(this, '{{ $item->id }}')" style="cursor: pointer;">⌄</span>
                        @endif
                        <div class="actions">
                            @if($item->mega_menu_settings)
                                <button title="Mega Menu Settings" onclick="openMegaMenuSettings('{{ $item->id }}')" style="background: #28a745;">🎨</button>
                            @endif
                            <button title="Add" onclick="addSubItem('{{ $item->id }}')">+</button>
                            <button title="Edit" onclick="editMenuItem('{{ $item->id }}')">✏️</button>
                            <button title="Delete" onclick="deleteMenuItem('{{ $item->id }}')" style="background: #dc3545;">🗑️</button>
                        </div>
                    </div>
                    
                    @if($hasChildren)
                        <!-- Sub-menu Items for {{ $item->title }} -->
                        <div class="sub-menu" id="submenu-{{ $item->id }}" style="display: block;">
                            @foreach($item->children as $child)
                                @php
                                    $childMenuData = json_encode([
                                        'title' => $child->title,
                                        'alias' => $child->alias,
                                        'menuType' => $child->menu_type,
                                        'menuItemType' => $child->menu_item_type,
                                        'url' => $child->url,
                                        'icon' => $child->icon,
                                        'targetWindow' => $child->target_window,
                                        'accessLevel' => $child->access_level,
                                        'styling' => $child->styling,
                                        'advanced' => $child->advanced,
                                    ]);
                                @endphp
                                <div class="menu-item" draggable="true" data-id="{{ $child->id }}" data-menu-data="{{ htmlspecialchars($childMenuData, ENT_QUOTES, 'UTF-8') }}">
                                    <span class="drag-handle">⋮⋮</span>
                                    <input type="checkbox" {{ $child->is_visible ? 'checked' : '' }} onchange="updateMenuVisibility({{ $child->id }}, this.checked)">
                                    <input type="text" value="{{ $child->title }}" class="menu-name" onchange="updateMenuTitle({{ $child->id }}, this.value)">
                                    <div class="toggle-switch {{ $child->is_active ? 'active' : '' }}" onclick="toggleSwitch(this)"></div>
                                    <div class="actions">
                                        <button title="Add" onclick="addSubItem('{{ $child->id }}')">+</button>
                                        <button title="Edit" onclick="editMenuItem('{{ $child->id }}')">✏️</button>
                                        <button title="Delete" onclick="deleteMenuItem('{{ $child->id }}')" style="background: #dc3545;">🗑️</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @else
                <!-- No menu items found - show placeholder message -->
                <div class="text-center p-5 text-muted">
                    <p>No menu items found. Click "New Menu" button to create your first menu item.</p>
                </div>
            @endif
        </div>
        
        <!-- Menu Control - Same Style as Menu Items -->
        <div class="menu-item" draggable="true" data-id="menu-control" data-type="menu-control" style="margin-top: 20px;">
            <span class="drag-handle">⋮⋮</span>
            <input type="checkbox" checked onchange="updateMenuControlVisibility(this.checked)">
            <input type="text" value="Menu Control" class="menu-name" onchange="updateMenuControlName(this.value)" placeholder="Menu Name">
            <input type="text" value="" class="menu-url" onchange="updateMenuControlUrl(this.value)" placeholder="URL (optional)" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
            <div class="toggle-switch active" onclick="toggleMenuControlSwitch(this)"></div>
            <span class="expand-icon" id="menuControlExpand" onclick="toggleMenuControl()" style="cursor: pointer; margin-left: 10px;">⌄</span>
        </div>
        
        <div class="sub-menu" id="menuControlSubmenu" style="display: block; margin-left: 20px;">
            <div class="menu-item" draggable="true" data-id="menu-control-toolbar" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.toolbar') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-toolbar', this.checked)">
                <input type="text" value="ToolBar" class="menu-name" onchange="updateMenuControlItemName('menu-control-toolbar', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.toolbar') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-toolbar', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-toolbar')"></div>
            </div>
            <div class="menu-item" draggable="true" data-id="menu-control-top-menu" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.top-menu') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-top-menu', this.checked)">
                <input type="text" value="Top Menu" class="menu-name" onchange="updateMenuControlItemName('menu-control-top-menu', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.top-menu') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-top-menu', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-top-menu')"></div>
            </div>
            <div class="menu-item" draggable="true" data-id="menu-control-breadcrumbs" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.breadcrumbs') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-breadcrumbs', this.checked)">
                <input type="text" value="Breadcrumbs" class="menu-name" onchange="updateMenuControlItemName('menu-control-breadcrumbs', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.breadcrumbs') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-breadcrumbs', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-breadcrumbs')"></div>
            </div>
            <div class="menu-item" draggable="true" data-id="menu-control-sidebar-left" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.sidebar-left') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-sidebar-left', this.checked)">
                <input type="text" value="Sidebar Left" class="menu-name" onchange="updateMenuControlItemName('menu-control-sidebar-left', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.sidebar-left') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-sidebar-left', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-sidebar-left')"></div>
            </div>
            <div class="menu-item" draggable="true" data-id="menu-control-sidebar-right" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.sidebar-right') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-sidebar-right', this.checked)">
                <input type="text" value="Sidebar Right" class="menu-name" onchange="updateMenuControlItemName('menu-control-sidebar-right', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.sidebar-right') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-sidebar-right', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-sidebar-right')"></div>
            </div>
            <div class="menu-item" draggable="true" data-id="menu-control-bottom-menu" data-type="menu-control-item" data-url="{{ route($routePrefix . '.menu-management.bottom-menu') }}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" checked onchange="updateMenuControlItemVisibility('menu-control-bottom-menu', this.checked)">
                <input type="text" value="Bottom Menu" class="menu-name" onchange="updateMenuControlItemName('menu-control-bottom-menu', this.value)" placeholder="Menu Name">
                <input type="text" value="{{ route($routePrefix . '.menu-management.bottom-menu') }}" class="menu-url" onchange="updateMenuControlItemUrl('menu-control-bottom-menu', this.value)" placeholder="URL" style="flex: 1; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                <div class="toggle-switch active" onclick="toggleMenuControlItemSwitch(this, 'menu-control-bottom-menu')"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Route-specific menu type
    const currentMenuType = '{{ $menuType ?? "sidebar-left-config" }}';
    const routePrefix = '{{ $routePrefix ?? "config" }}';
    
    // Helper function to get base URL for API calls
    function getApiBaseUrl() {
        // All routes have /admin/ prefix (Twill adds it automatically)
        return '/admin/' + routePrefix + '/menu-management';
    }
    
    // Add interactivity to the menu management interface
    document.addEventListener('DOMContentLoaded', function() {
        let draggedElement = null;
        let menuControlInitialIndex = null;
        let menuControlPositionChanged = false;
        
        // Toggle switch functionality
        window.toggleSwitch = function(element) {
            element.classList.toggle('active');
            const menuItem = element.closest('.menu-item');
            const itemId = menuItem.dataset.id;
            const isActive = element.classList.contains('active');
            
            // Update database via AJAX
            if (itemId) {
                fetch(getApiBaseUrl() + '/items/' + itemId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ is_active: isActive })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        element.classList.toggle('active');
                        showNotification('Error updating menu item status', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    element.classList.toggle('active');
                });
            }
        };
        
        // Toggle sub-menu expand/collapse
        window.toggleSubMenuExpand = function(element, itemId) {
            const subMenu = document.getElementById('submenu-' + itemId);
            if (subMenu) {
                if (subMenu.style.display === 'none' || !subMenu.style.display) {
                    subMenu.style.display = 'block';
                    element.innerHTML = '⌄';
                } else {
                    subMenu.style.display = 'none';
                    element.innerHTML = '▶';
                }
            }
        };
        
        // Toggle Menu Control expand/collapse
        window.toggleMenuControl = function() {
            const subMenu = document.getElementById('menuControlSubmenu');
            const expandIcon = document.getElementById('menuControlExpand');
            if (subMenu && expandIcon) {
                if (subMenu.style.display === 'none' || !subMenu.style.display) {
                    subMenu.style.display = 'block';
                    expandIcon.innerHTML = '⌄';
                } else {
                    subMenu.style.display = 'none';
                    expandIcon.innerHTML = '▶';
                }
            }
        };
        
        // Menu Control Functions - Save to localStorage
        window.updateMenuControlName = function(name) {
            if (!name || name.trim() === '') {
                showNotification('Menu name cannot be empty', 'error');
                return;
            }
            const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
            menuControlData.name = name.trim();
            localStorage.setItem('menuControlData', JSON.stringify(menuControlData));
            showNotification('Menu Control name updated!', 'success');
        };
        
        window.updateMenuControlUrl = function(url) {
            const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
            menuControlData.url = url.trim();
            localStorage.setItem('menuControlData', JSON.stringify(menuControlData));
            if (url.trim()) {
                showNotification('Menu Control URL updated!', 'success');
            }
        };
        
        window.updateMenuControlVisibility = function(isVisible) {
            const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
            menuControlData.isVisible = isVisible;
            localStorage.setItem('menuControlData', JSON.stringify(menuControlData));
            showNotification('Menu Control visibility updated!', 'success');
        };
        
        window.toggleMenuControlSwitch = function(element) {
            element.classList.toggle('active');
            const isActive = element.classList.contains('active');
            const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
            menuControlData.isActive = isActive;
            localStorage.setItem('menuControlData', JSON.stringify(menuControlData));
            showNotification('Menu Control status updated!', 'success');
        };
        
        // Menu Control Item Functions
        window.updateMenuControlItemName = function(itemId, name) {
            if (!name || name.trim() === '') {
                showNotification('Menu name cannot be empty', 'error');
                return;
            }
            const menuControlItems = JSON.parse(localStorage.getItem('menuControlItems') || '{}');
            if (!menuControlItems[itemId]) menuControlItems[itemId] = {};
            menuControlItems[itemId].name = name.trim();
            localStorage.setItem('menuControlItems', JSON.stringify(menuControlItems));
            showNotification('Menu item name updated!', 'success');
        };
        
        window.updateMenuControlItemUrl = function(itemId, url) {
            const menuControlItems = JSON.parse(localStorage.getItem('menuControlItems') || '{}');
            if (!menuControlItems[itemId]) menuControlItems[itemId] = {};
            menuControlItems[itemId].url = url.trim();
            localStorage.setItem('menuControlItems', JSON.stringify(menuControlItems));
            
            // Update data-url attribute for navigation
            const menuItem = document.querySelector(`[data-id="${itemId}"]`);
            if (menuItem) {
                menuItem.setAttribute('data-url', url.trim());
            }
            
            showNotification('Menu item URL updated!', 'success');
        };
        
        window.updateMenuControlItemVisibility = function(itemId, isVisible) {
            const menuControlItems = JSON.parse(localStorage.getItem('menuControlItems') || '{}');
            if (!menuControlItems[itemId]) menuControlItems[itemId] = {};
            menuControlItems[itemId].isVisible = isVisible;
            localStorage.setItem('menuControlItems', JSON.stringify(menuControlItems));
            showNotification('Menu item visibility updated!', 'success');
        };
        
        window.toggleMenuControlItemSwitch = function(element, itemId) {
            element.classList.toggle('active');
            const isActive = element.classList.contains('active');
            const menuControlItems = JSON.parse(localStorage.getItem('menuControlItems') || '{}');
            if (!menuControlItems[itemId]) menuControlItems[itemId] = {};
            menuControlItems[itemId].isActive = isActive;
            localStorage.setItem('menuControlItems', JSON.stringify(menuControlItems));
            showNotification('Menu item status updated!', 'success');
        };
        
        // Load saved Menu Control data on page load
        const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
        if (menuControlData.name) {
            const nameInput = document.querySelector('[data-id="menu-control"] .menu-name');
            if (nameInput) nameInput.value = menuControlData.name;
        }
        if (menuControlData.url) {
            const urlInput = document.querySelector('[data-id="menu-control"] .menu-url');
            if (urlInput) urlInput.value = menuControlData.url;
        }
        
        const menuControlItems = JSON.parse(localStorage.getItem('menuControlItems') || '{}');
        Object.keys(menuControlItems).forEach(itemId => {
            const item = menuControlItems[itemId];
            const menuItem = document.querySelector(`[data-id="${itemId}"]`);
            if (menuItem) {
                if (item.name) {
                    const nameInput = menuItem.querySelector('.menu-name');
                    if (nameInput) nameInput.value = item.name;
                }
                if (item.url) {
                    const urlInput = menuItem.querySelector('.menu-url');
                    if (urlInput) urlInput.value = item.url;
                    menuItem.setAttribute('data-url', item.url);
                }
            }
        });
        
        // Show Save Position Button
        window.showSavePositionButton = function(menuControlElement) {
            // Remove existing button if any
            hideSavePositionButton();
            
            console.log('Creating Save Position Button', menuControlElement);
            
            // Create save button container
            const buttonContainer = document.createElement('div');
            buttonContainer.id = 'saveMenuControlPositionBtn';
            buttonContainer.style.cssText = 'margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 6px; border: 1px dashed #28a745; display: flex; align-items: center; gap: 10px;';
            
            // Create info text
            const infoText = document.createElement('span');
            infoText.innerHTML = '⚠️ Position changed!';
            infoText.style.cssText = 'color: #856404; font-weight: 500; margin-right: auto;';
            buttonContainer.appendChild(infoText);
            
            // Create save button
            const saveButton = document.createElement('button');
            saveButton.className = 'btn btn-success btn-sm';
            saveButton.innerHTML = '<i class="ri-save-line me-1"></i> Save Position';
            saveButton.onclick = function() {
                saveMenuControlPosition();
            };
            
            // Create cancel button
            const cancelButton = document.createElement('button');
            cancelButton.className = 'btn btn-secondary btn-sm';
            cancelButton.innerHTML = 'Cancel';
            cancelButton.onclick = function() {
                hideSavePositionButton();
                menuControlPositionChanged = false;
            };
            
            buttonContainer.appendChild(saveButton);
            buttonContainer.appendChild(cancelButton);
            
            // Insert button container after Menu Control item (before sub-menu if exists)
            if (menuControlElement && menuControlElement.parentNode) {
                const subMenu = menuControlElement.nextElementSibling;
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    menuControlElement.parentNode.insertBefore(buttonContainer, subMenu);
                    console.log('Button inserted before sub-menu');
                } else {
                    menuControlElement.parentNode.insertBefore(buttonContainer, menuControlElement.nextSibling);
                    console.log('Button inserted after Menu Control');
                }
            } else {
                console.error('Menu Control element or parent not found');
            }
        };
        
        // Hide Save Position Button
        window.hideSavePositionButton = function() {
            const existingBtn = document.getElementById('saveMenuControlPositionBtn');
            if (existingBtn) {
                existingBtn.remove();
            }
        };
        
        // Save Menu Control Position
        window.saveMenuControlPosition = function() {
            const menuControlItem = document.querySelector('[data-id="menu-control"], [data-type="menu-control"]');
            
            if (!menuControlItem) {
                showNotification('Menu Control not found', 'error');
                return;
            }
            
            // Try to find menu-links-list first, otherwise use parent container
            const menuList = document.getElementById('menu-links-list') || menuControlItem.closest('.left-panel') || menuControlItem.parentNode;
            
            if (!menuList) {
                showNotification('Menu list not found', 'error');
                return;
            }
            
            // Get all menu items (excluding sub-menu items)
            const allItems = Array.from(menuList.querySelectorAll('.menu-item:not(.sub-menu .menu-item)'));
            
            // Get current index
            const currentIndex = allItems.indexOf(menuControlItem);
            
            if (currentIndex === -1) {
                showNotification('Could not determine position', 'error');
                return;
            }
            
            // Save to localStorage
            const menuControlData = JSON.parse(localStorage.getItem('menuControlData') || '{}');
            menuControlData.position = currentIndex;
            menuControlData.savedAt = new Date().toISOString();
            localStorage.setItem('menuControlData', JSON.stringify(menuControlData));
            
            // Hide save button
            hideSavePositionButton();
            
            // Show success notification
            showNotification('Menu Control position saved successfully!', 'success');
            
            menuControlPositionChanged = false;
        };
        
        // Update menu visibility
        window.updateMenuVisibility = function(itemId, isVisible) {
            fetch(getApiBaseUrl() + '/items/' + itemId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ is_visible: isVisible })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    showNotification('Error updating menu item visibility', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };
        
        // Update menu title
        window.updateMenuTitle = function(itemId, title) {
            if (!title || title.trim() === '') {
                showNotification('Menu title cannot be empty', 'error');
                return;
            }
            
            fetch(getApiBaseUrl() + '/items/' + itemId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ title: title.trim() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Menu title updated successfully!', 'success');
                } else {
                    showNotification('Error updating menu title', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating menu title', 'error');
            });
        };
        
        // Alignment button functionality
        window.setAlignment = function(element) {
            document.querySelectorAll('.alignment-btn').forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
        };
        
        // Menu item actions
        document.querySelectorAll('.menu-item .actions button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const action = this.getAttribute('title');
                
                if (action === 'Edit') {
                    // Get menu item data
                    const menuItem = this.closest('.menu-item');
                    const title = menuItem.querySelector('.menu-name').value;
                    const isChecked = menuItem.querySelector('input[type="checkbox"]').checked;
                    const isActive = menuItem.querySelector('.toggle-switch').classList.contains('active');
                    
                    // Open modal for editing
                    openEditModal(title, isChecked, isActive);
                } else if (action === 'Add') {
                    // Open modal for adding sub-item
                    openAddSubItemModal();
                }
            });
        });
        
        // Add click navigation for Menu Control sub-items (but not when clicking inputs)
        document.querySelectorAll('[data-type="menu-control-item"]').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't navigate if clicking on input fields, buttons, or drag handle
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || 
                    e.target.classList.contains('drag-handle') || e.target.classList.contains('toggle-switch') ||
                    e.target.closest('.actions')) {
                    return;
                }
                
                const url = this.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            });
        });
        
        // Enhanced Drag and Drop functionality with Sub-menu Creation
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            // Drag start
            item.addEventListener('dragstart', function(e) {
                draggedElement = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', this.outerHTML);
                e.dataTransfer.setData('text/plain', this.dataset.id);
                
                // Track initial position if it's Menu Control
                if (this.dataset.type === 'menu-control' || this.dataset.id === 'menu-control') {
                    // Try to find menu-links-list first, otherwise use parent container
                    const menuList = document.getElementById('menu-links-list') || this.closest('.left-panel') || this.parentNode;
                    if (menuList) {
                        const allItems = Array.from(menuList.querySelectorAll('.menu-item:not(.sub-menu .menu-item)'));
                        menuControlInitialIndex = allItems.indexOf(this);
                    }
                }
                
                // Add touch support for mobile
                if (e.touches && e.touches.length > 0) {
                    e.preventDefault();
                }
            });
            
            // Drag end
            item.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                
                // Check if Menu Control position changed
                if ((this.dataset.type === 'menu-control' || this.dataset.id === 'menu-control') && menuControlInitialIndex !== null) {
                    // Try to find menu-links-list first, otherwise use parent container
                    const menuList = document.getElementById('menu-links-list') || this.closest('.left-panel') || this.parentNode;
                    if (menuList) {
                        const allItems = Array.from(menuList.querySelectorAll('.menu-item:not(.sub-menu .menu-item)'));
                        const newIndex = allItems.indexOf(this);
                        console.log('Menu Control Position Check:', {
                            initialIndex: menuControlInitialIndex,
                            newIndex: newIndex,
                            changed: newIndex !== menuControlInitialIndex
                        });
                        if (newIndex !== menuControlInitialIndex && newIndex !== -1) {
                            menuControlPositionChanged = true;
                            console.log('Showing Save Position Button');
                            showSavePositionButton(this);
                        } else {
                            menuControlPositionChanged = false;
                            hideSavePositionButton();
                        }
                    }
                } else {
                    hideSavePositionButton();
                }
                
                draggedElement = null;
                menuControlInitialIndex = null;
                
                // Remove all drag-over classes
                document.querySelectorAll('.drag-over').forEach(el => {
                    el.classList.remove('drag-over');
                });
            });
            
            // Drag over
            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                
                // Add visual feedback for drop zones
                this.classList.add('drag-over');
                
                // Show sub-menu creation hint
                if (draggedElement && draggedElement !== this) {
                    showDropHint(this, 'Drop here to create sub-menu');
                }
            });
            
            // Drag leave
            item.addEventListener('dragleave', function(e) {
                this.classList.remove('drag-over');
                hideDropHint();
            });
            
            // Drop
            item.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                hideDropHint();
                
                if (draggedElement && draggedElement !== this) {
                    const draggedId = draggedElement.dataset.id;
                    const targetId = this.dataset.id;
                    
                    // Check if we're creating a sub-menu
                    if (shouldCreateSubMenu(this, draggedElement)) {
                        createSubMenu(this, draggedElement);
                    } else {
                        // Regular reordering
                        const parent = this.parentNode;
                        const nextSibling = this.nextSibling;
                        
                        // Remove dragged element from its current position
                        draggedElement.parentNode.removeChild(draggedElement);
                        
                        // Insert dragged element before the current element
                        parent.insertBefore(draggedElement, this);
                        
                        // Show success message
                        showNotification('Menu item reordered successfully!', 'success');
                    }
                }
            });
            
            // Touch support for mobile drag and drop
            let touchStartY = 0;
            let touchStartX = 0;
            let isDragging = false;
            
            item.addEventListener('touchstart', function(e) {
                touchStartY = e.touches[0].clientY;
                touchStartX = e.touches[0].clientX;
                isDragging = false;
            }, { passive: true });
            
            item.addEventListener('touchmove', function(e) {
                if (!isDragging) {
                    const touchY = e.touches[0].clientY;
                    const touchX = e.touches[0].clientX;
                    const deltaY = Math.abs(touchY - touchStartY);
                    const deltaX = Math.abs(touchX - touchStartX);
                    
                    if (deltaY > 10 || deltaX > 10) {
                        isDragging = true;
                        this.classList.add('dragging');
                        showNotification('Drag to reorder menu items', 'info');
                    }
                }
            }, { passive: true });
            
            item.addEventListener('touchend', function(e) {
                if (isDragging) {
                    this.classList.remove('dragging');
                    isDragging = false;
                }
            }, { passive: true });
        });
        
        // Sub-menu Creation Helper Functions
        function shouldCreateSubMenu(targetItem, draggedItem) {
            // Don't create sub-menu if dragging onto a sub-menu item
            if (targetItem.closest('.sub-menu')) {
                return false;
            }
            
            // Don't create sub-menu if dragging a sub-menu item
            if (draggedItem.closest('.sub-menu')) {
                return false;
            }
            
            // Create sub-menu if dragging onto a main menu item
            return true;
        }
        
        function createSubMenu(parentItem, childItem) {
            // Remove child from its current position
            childItem.parentNode.removeChild(childItem);
            
            // Check if parent already has a sub-menu
            let subMenu = parentItem.nextElementSibling;
            if (!subMenu || !subMenu.classList.contains('sub-menu')) {
                // Create new sub-menu container
                subMenu = document.createElement('div');
                subMenu.className = 'sub-menu';
                subMenu.style.display = 'block';
                
                // Insert after parent item
                parentItem.parentNode.insertBefore(subMenu, parentItem.nextSibling);
                
                // Add expand icon to parent
                const expandIcon = parentItem.querySelector('.expand-icon');
                if (!expandIcon) {
                    const icon = document.createElement('span');
                    icon.className = 'expand-icon';
                    icon.innerHTML = '⌄';
                    icon.onclick = function() {
                        toggleSubMenu(subMenu);
                    };
                    parentItem.appendChild(icon);
                }
            }
            
            // Add child to sub-menu
            childItem.classList.add('sub-menu-item');
            subMenu.appendChild(childItem);
            
            // Update child's data attributes
            childItem.dataset.parentId = parentItem.dataset.id;
            
            // Re-initialize drag and drop for the moved item
            initializeDragAndDrop(childItem);
            
            // Show success message
            showNotification('Sub-menu created successfully!', 'success');
            
            // Highlight the new sub-menu
            subMenu.style.background = '#d4edda';
            setTimeout(() => {
                subMenu.style.background = '';
            }, 2000);
        }
        
        function toggleSubMenu(subMenu) {
            if (subMenu.style.display === 'none') {
                subMenu.style.display = 'block';
                subMenu.previousElementSibling.querySelector('.expand-icon').innerHTML = '⌄';
            } else {
                subMenu.style.display = 'none';
                subMenu.previousElementSibling.querySelector('.expand-icon').innerHTML = '▶';
            }
        }
        
        function showDropHint(element, message) {
            // Remove existing hints
            hideDropHint();
            
            const hint = document.createElement('div');
            hint.className = 'drop-hint';
            hint.textContent = message;
            hint.style.cssText = `
                position: absolute;
                background: #007bff;
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 12px;
                z-index: 1000;
                pointer-events: none;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            `;
            
            // Position hint relative to element
            const rect = element.getBoundingClientRect();
            hint.style.left = rect.left + 'px';
            hint.style.top = (rect.bottom + 5) + 'px';
            
            document.body.appendChild(hint);
        }
        
        function hideDropHint() {
            const existingHint = document.querySelector('.drop-hint');
            if (existingHint) {
                existingHint.remove();
            }
        }
        
        // Enhanced drag and drop for sub-menu items
        function initializeDragAndDrop(item) {
            // Remove existing listeners
            item.removeEventListener('dragstart', handleDragStart);
            item.removeEventListener('dragend', handleDragEnd);
            item.removeEventListener('dragover', handleDragOver);
            item.removeEventListener('dragleave', handleDragLeave);
            item.removeEventListener('drop', handleDrop);
            
            // Add new listeners
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragend', handleDragEnd);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('dragleave', handleDragLeave);
            item.addEventListener('drop', handleDrop);
        }
        
        function handleDragStart(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);
            e.dataTransfer.setData('text/plain', this.dataset.id);
        }
        
        function handleDragEnd(e) {
            this.classList.remove('dragging');
            draggedElement = null;
            document.querySelectorAll('.drag-over').forEach(el => {
                el.classList.remove('drag-over');
            });
            hideDropHint();
        }
        
        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.classList.add('drag-over');
            
            if (draggedElement && draggedElement !== this) {
                const isSubMenu = this.closest('.sub-menu');
                const draggedIsSubMenu = draggedElement.closest('.sub-menu');
                
                if (isSubMenu && !draggedIsSubMenu) {
                    showDropHint(this, 'Drop here to move to sub-menu');
                } else if (!isSubMenu && draggedIsSubMenu) {
                    showDropHint(this, 'Drop here to move to main menu');
                } else {
                    showDropHint(this, 'Drop here to reorder');
                }
            }
        }
        
        function handleDragLeave(e) {
            this.classList.remove('drag-over');
            hideDropHint();
        }
        
        function handleDrop(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            hideDropHint();
            
            if (draggedElement && draggedElement !== this) {
                const targetParent = this.closest('.sub-menu');
                const draggedParent = draggedElement.closest('.sub-menu');
                
                // Move between main menu and sub-menu
                if (targetParent && !draggedParent) {
                    // Moving from main to sub-menu
                    moveToSubMenu(this, draggedElement);
                } else if (!targetParent && draggedParent) {
                    // Moving from sub-menu to main
                    moveToMainMenu(this, draggedElement);
                } else {
                    // Regular reordering within same level
                    const parent = this.parentNode;
                    draggedElement.parentNode.removeChild(draggedElement);
                    parent.insertBefore(draggedElement, this);
                    showNotification('Menu item reordered successfully!', 'success');
                }
            }
        }
        
        function moveToSubMenu(targetItem, draggedItem) {
            // Remove from current position
            draggedItem.parentNode.removeChild(draggedItem);
            
            // Add to sub-menu
            const subMenu = targetItem.closest('.sub-menu');
            draggedItem.dataset.parentId = subMenu.previousElementSibling.dataset.id;
            subMenu.appendChild(draggedItem);
            
            // Re-initialize drag and drop
            initializeDragAndDrop(draggedItem);
            
            showNotification('Moved to sub-menu successfully!', 'success');
        }
        
        function moveToMainMenu(targetItem, draggedItem) {
            // Remove from sub-menu
            draggedItem.parentNode.removeChild(draggedItem);
            
            // Add to main menu
            const mainContainer = document.getElementById('menu-links-list');
            mainContainer.appendChild(draggedItem);
            
            // Remove parent reference
            delete draggedItem.dataset.parentId;
            
            // Re-initialize drag and drop
            initializeDragAndDrop(draggedItem);
            
            showNotification('Moved to main menu successfully!', 'success');
        }
        
        // Notification function - Make it globally accessible
        window.showNotification = function(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());
            
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed custom-notification`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            
            // Add icon based on type
            let icon = '';
            switch(type) {
                case 'success':
                    icon = '<i class="ri-check-line me-2"></i>';
                    break;
                case 'error':
                case 'danger':
                    icon = '<i class="ri-error-warning-line me-2"></i>';
                    break;
                case 'warning':
                    icon = '<i class="ri-alert-line me-2"></i>';
                    break;
                default:
                    icon = '<i class="ri-information-line me-2"></i>';
            }
            
            notification.innerHTML = `
                ${icon}${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 150);
                }
            }, 4000);
        }
        
        // Add smooth animations
        const style = document.createElement('style');
        style.textContent = `
            .menu-item {
                transition: all 0.3s ease;
            }
            .menu-item.dragging {
                transform: rotate(5deg) scale(1.05);
                z-index: 1000;
            }
            .menu-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
        `;
        document.head.appendChild(style);
    });
    
    // Old saveNewMenu function removed - using enhanced version below with API calls
    
    // Open edit modal
    function openEditModal(title, isChecked, isActive) {
        // Set form values
        document.querySelector('#newMenuModal input[type="text"]').value = title;
        document.querySelectorAll('#newMenuModal input[type="text"]')[1].value = title.toLowerCase().replace(/\s+/g, '-');
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
    }
    
    // Open add sub-item modal
    function openAddSubItemModal() {
        // Reset form for new sub-item
        document.querySelector('#newMenuModal input[type="text"]').value = '';
        document.querySelectorAll('#newMenuModal input[type="text"]')[1].value = '';
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
    }
    
    // Add sub-item function - Opens modal with parent pre-selected
    window.addSubItem = function(parentId) {
        console.log('addSubItem called with parentId:', parentId);
        
        // Reset form
        resetMenuForm();
        
        // Populate parent items dropdown first
        populateParentItems();
        
        // Set parent item in dropdown after a small delay to ensure dropdown is populated
        setTimeout(() => {
            const parentSelect = document.getElementById('parentItem');
            if (parentSelect) {
                console.log('Setting parent value:', parentId, 'Available options:', Array.from(parentSelect.options).map(opt => ({value: opt.value, text: opt.text})));
                parentSelect.value = parentId;
                
                // Verify the value was set
                if (parentSelect.value === parentId) {
                    console.log('Parent value set successfully');
                } else {
                    console.error('Failed to set parent value. Current value:', parentSelect.value);
                    // Try setting by finding the option
                    const option = Array.from(parentSelect.options).find(opt => opt.value === String(parentId));
                    if (option) {
                        parentSelect.selectedIndex = option.index;
                        console.log('Parent value set via option index');
                    }
                }
                
                // Trigger change event to update UI if needed
                parentSelect.dispatchEvent(new Event('change'));
            } else {
                console.error('Parent select element not found!');
            }
        }, 200);
        
        // Open modal for adding sub-item
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
        
        // Show notification
        showNotification('Please fill the form to create a sub-menu item. Parent is pre-selected.', 'info');
    };
    
    // Edit menu item function
    window.editMenuItem = function(itemId) {
        const menuItem = document.querySelector(`[data-id="${itemId}"]`);
        if (!menuItem) return;
        
        const title = menuItem.querySelector('.menu-name').value;
        const isChecked = menuItem.querySelector('input[type="checkbox"]').checked;
        const isActive = menuItem.querySelector('.toggle-switch').classList.contains('active');
        
        // Set form values
        document.querySelector('#newMenuModal input[type="text"]').value = title;
        document.querySelectorAll('#newMenuModal input[type="text"]')[1].value = title.toLowerCase().replace(/\s+/g, '-');
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
        
        // Store the item ID for updating
        window.editingItemId = itemId;
    };
    
    // Delete menu item function
    window.deleteMenuItem = function(itemId) {
        if (confirm('Are you sure you want to delete this menu item?')) {
            // Delete from database via API
            fetch(getApiBaseUrl() + '/items/' + itemId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const menuItem = document.querySelector(`[data-id="${itemId}"]`);
                    if (menuItem) {
                        // Also remove sub-menu if exists
                        const subMenu = menuItem.nextElementSibling;
                        if (subMenu && subMenu.classList.contains('sub-menu')) {
                            subMenu.remove();
                        }
                        
                        menuItem.remove();
                        
                        // Check if menu list is empty and show placeholder
                        const menuList = document.getElementById('menu-links-list');
                        const remainingItems = menuList.querySelectorAll('.menu-item:not([data-type="menu-control"])');
                        if (remainingItems.length === 0) {
                            const placeholder = document.createElement('div');
                            placeholder.className = 'text-center p-5 text-muted';
                            placeholder.innerHTML = '<p>No menu items found. Click "New Menu" button to create your first menu item.</p>';
                            menuList.appendChild(placeholder);
                        }
                        
                        // Update parent items dropdown
                        populateParentItems();
                        
                        showNotification('Menu item deleted successfully!', 'success');
                    }
                } else {
                    showNotification(data.message || 'Error deleting menu item!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error deleting menu item: ' + error.message, 'error');
            });
        }
    };
    
    // Default Settings Modal Functions
    window.selectSize = function(element) {
        document.querySelectorAll('.size-option').forEach(option => {
            option.classList.remove('selected');
            option.querySelector('.ri-check-line')?.remove();
        });
        element.classList.add('selected');
        element.innerHTML += '<i class="ri-check-line ms-auto text-primary"></i>';
    };
    
    window.selectLayout = function(element) {
        document.querySelectorAll('.layout-option').forEach(option => {
            option.classList.remove('selected');
            option.querySelector('.ri-check-line')?.remove();
        });
        element.classList.add('selected');
        element.innerHTML += '<i class="ri-check-line ms-auto text-primary"></i>';
    };
    
    window.selectView = function(element) {
        document.querySelectorAll('.view-option').forEach(option => {
            option.classList.remove('selected');
            option.querySelector('.ri-check-line')?.remove();
        });
        element.classList.add('selected');
        element.innerHTML += '<i class="ri-check-line ms-auto text-primary"></i>';
    };
    
    window.selectColorType = function(element) {
        document.querySelectorAll('.color-option').forEach(option => {
            option.classList.remove('selected');
            option.querySelector('.ri-check-line')?.remove();
        });
        element.classList.add('selected');
        element.innerHTML += '<i class="ri-check-line ms-auto text-primary"></i>';
    };
    
    window.saveDefaultSettings = function() {
        // Get selected options
        const selectedSize = document.querySelector('.size-option.selected span').textContent;
        const selectedLayout = document.querySelector('.layout-option.selected span').textContent;
        const selectedView = document.querySelector('.view-option.selected span').textContent;
        const selectedColorType = document.querySelector('.color-option.selected span').textContent;
        
        // Get color values
        const backgroundColor = document.querySelector('#defaultSettingsModal input[type="color"]').value;
        const backgroundText = document.querySelector('#defaultSettingsModal input[type="text"]').value;
        
        // Show success message
        showNotification('Default settings saved successfully!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('defaultSettingsModal'));
        modal.hide();
        
        console.log('Settings saved:', {
            size: selectedSize,
            layout: selectedLayout,
            view: selectedView,
            colorType: selectedColorType,
            backgroundColor: backgroundColor,
            backgroundText: backgroundText
        });
    };
    
    // Initialize drag and drop for a specific element
    function initializeDragAndDrop(item) {
        // Drag start
        item.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);
        });
        
        // Drag end
        item.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            draggedElement = null;
        });
        
        // Drag over
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.classList.add('drag-over');
        });
        
        // Drag leave
        item.addEventListener('dragleave', function(e) {
            this.classList.remove('drag-over');
        });
        
        // Drop
        item.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            if (draggedElement && draggedElement !== this) {
                const parent = this.parentNode;
                const nextSibling = this.nextSibling;
                
                // Remove dragged element from its current position
                draggedElement.parentNode.removeChild(draggedElement);
                
                // Insert dragged element before the current element
                parent.insertBefore(draggedElement, this);
                
                // Show success message
                showNotification('Menu item reordered successfully!', 'success');
            }
        });
    }
    
    // Search functionality
    window.searchMenuItems = function(searchTerm) {
        const menuItems = document.querySelectorAll('.menu-item');
        const searchTermLower = searchTerm.toLowerCase();
        
        menuItems.forEach(item => {
            const menuName = item.querySelector('.menu-name').value.toLowerCase();
            const isVisible = menuName.includes(searchTermLower);
            
            if (searchTerm === '' || isVisible) {
                item.style.display = 'flex';
                item.style.opacity = '1';
            } else {
                item.style.display = 'none';
                item.style.opacity = '0';
            }
        });
        
        // Also search in sub-menus
        const subMenus = document.querySelectorAll('.sub-menu');
        subMenus.forEach(subMenu => {
            const subItems = subMenu.querySelectorAll('.menu-item');
            let hasVisibleItems = false;
            
            subItems.forEach(item => {
                const menuName = item.querySelector('.menu-name').value.toLowerCase();
                const isVisible = menuName.includes(searchTermLower);
                
                if (searchTerm === '' || isVisible) {
                    item.style.display = 'flex';
                    item.style.opacity = '1';
                    hasVisibleItems = true;
                } else {
                    item.style.display = 'none';
                    item.style.opacity = '0';
                }
            });
            
            // Show/hide sub-menu based on visible items
            if (searchTerm === '' || hasVisibleItems) {
                subMenu.style.display = 'block';
            } else {
                subMenu.style.display = 'none';
            }
        });
    };
    
    // Clear search
    window.clearSearch = function() {
        document.getElementById('searchInput').value = '';
        searchMenuItems('');
    };
    
    // Clear all filters
    window.clearAllFilters = function() {
        document.getElementById('searchInput').value = '';
        searchMenuItems('');
        
        // Reset ordering
        const orderingSelect = document.querySelector('select[style*="width: 150px"]');
        if (orderingSelect) {
            orderingSelect.value = 'Ordering ascending';
        }
        
        // Reset items per page
        const itemsPerPageSelect = document.querySelector('select[style*="width: 80px"]');
        if (itemsPerPageSelect) {
            itemsPerPageSelect.value = '20';
        }
        
        showNotification('All filters cleared!', 'info');
    };
    
    // Auto-generate alias from title
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('menuTitle');
        const aliasInput = document.getElementById('menuAlias');
        
        if (titleInput && aliasInput) {
            titleInput.addEventListener('input', function() {
                const alias = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                aliasInput.value = alias;
            });
        }
        
        // Handle menu item type changes
        const menuItemTypeSelect = document.getElementById('menuItemType');
        if (menuItemTypeSelect) {
            menuItemTypeSelect.addEventListener('change', function() {
                toggleDynamicFields(this.value);
            });
        }
        
        // Populate parent items
        populateParentItems();
    });
    
    // Toggle dynamic fields based on menu item type
    function toggleDynamicFields(itemType) {
        // Hide all dynamic fields
        document.getElementById('urlField').style.display = 'none';
        document.getElementById('pageField').style.display = 'none';
        document.getElementById('categoryField').style.display = 'none';
        document.getElementById('productField').style.display = 'none';
        document.getElementById('customHtmlField').style.display = 'none';
        
        // Show relevant field
        switch(itemType) {
            case 'url':
                document.getElementById('urlField').style.display = 'block';
                break;
            case 'page':
                document.getElementById('pageField').style.display = 'block';
                break;
            case 'category':
                document.getElementById('categoryField').style.display = 'block';
                break;
            case 'product':
                document.getElementById('productField').style.display = 'block';
                break;
            case 'custom':
                document.getElementById('customHtmlField').style.display = 'block';
                break;
        }
    }
    
    // Populate parent items dropdown
    function populateParentItems() {
        const parentSelect = document.getElementById('parentItem');
        if (!parentSelect) return;
        
        // Clear existing options except first
        parentSelect.innerHTML = '<option value="">Root Level (No Parent)</option>';
        
        // Get all root-level menu items only (not submenu items)
        const menuItems = document.querySelectorAll('#menu-links-list > .menu-item:not(.sub-menu .menu-item)');
        menuItems.forEach(item => {
            // Skip menu control items
            if (item.dataset.type === 'menu-control' || item.dataset.id === 'menu-control') {
                return;
            }
            
            const title = item.querySelector('.menu-name')?.value;
            const id = item.dataset.id;
            
            if (title && id) {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = title;
                parentSelect.appendChild(option);
            }
        });
    }
    
    // Reset form function
    function resetMenuForm() {
        document.getElementById('menuTitle').value = '';
        document.getElementById('menuAlias').value = '';
        document.getElementById('menuType').value = '';
        document.getElementById('parentItem').value = '';
        document.getElementById('menuOrder').value = '0';
        document.getElementById('targetWindow').value = '_self';
        document.getElementById('accessLevel').value = 'public';
        document.getElementById('menuItemType').value = '';
        document.getElementById('menuUrl').value = '';
        document.getElementById('selectedPage').value = '';
        document.getElementById('selectedCategory').value = '';
        document.getElementById('selectedProduct').value = '';
        document.getElementById('customHtml').value = '';
        
        // Hide all dynamic fields
        toggleDynamicFields('');
        
        // Clear editing state
        window.editingItemId = null;
    }
    
    // Create menu item HTML from server response
    function createMenuItemHTML(menuItem, parentId) {
        const menuData = {
            title: menuItem.title,
            alias: menuItem.alias,
            menuType: menuItem.menu_type,
            menuItemType: menuItem.menu_item_type,
            url: menuItem.url,
            icon: menuItem.icon,
            targetWindow: menuItem.target_window,
            accessLevel: menuItem.access_level,
            styling: menuItem.styling,
            advanced: menuItem.advanced
        };
        
        // Check if item has children (from database or existing DOM)
        const hasChildren = (menuItem.children && Array.isArray(menuItem.children) && menuItem.children.length > 0) || false;
        const isActive = menuItem.is_active ? 'active' : '';
        const isVisible = menuItem.is_visible !== false; // Default to true if not specified
        const expandIcon = hasChildren ? '<span class="expand-icon" onclick="toggleSubMenuExpand(this, \'' + menuItem.id + '\')" style="cursor: pointer;">⌄</span>' : '';
        
        // Escape menu data for HTML attribute
        const menuDataStr = JSON.stringify(menuData).replace(/'/g, "&#39;").replace(/"/g, "&quot;");
        
        let html = `
            <div class="menu-item" draggable="true" data-id="${menuItem.id}" data-menu-data="${menuDataStr}">
                <span class="drag-handle">⋮⋮</span>
                <input type="checkbox" ${isVisible ? 'checked' : ''} onchange="updateMenuVisibility(${menuItem.id}, this.checked)">
                <input type="text" value="${escapeHtml(menuItem.title)}" class="menu-name" onchange="updateMenuTitle(${menuItem.id}, this.value)">
                <div class="toggle-switch ${isActive}" onclick="toggleSwitch(this)"></div>
                ${expandIcon}
                <div class="actions">
                    <button title="Add" onclick="addSubItem('${menuItem.id}')">+</button>
                    <button title="Edit" onclick="editMenuItem('${menuItem.id}')">✏️</button>
                    <button title="Delete" onclick="deleteMenuItem('${menuItem.id}')" style="background: #dc3545;">🗑️</button>
                </div>
            </div>
        `;
        
        // Add sub-menu container if has children (children will be loaded from database on page load)
        if (hasChildren && menuItem.children && Array.isArray(menuItem.children) && menuItem.children.length > 0) {
            html += `<div class="sub-menu" id="submenu-${menuItem.id}" style="display: block;">`;
            menuItem.children.forEach(child => {
                html += createMenuItemHTML(child, menuItem.id);
            });
            html += `</div>`;
        }
        
        return html;
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? text.replace(/[&<>"']/g, m => map[m]) : '';
    }
    
    // Enhanced edit function
    window.editMenuItem = function(itemId) {
        const menuItem = document.querySelector(`[data-id="${itemId}"]`);
        if (!menuItem) return;
        
        // Get stored data
        let menuData = {};
        if (menuItem.dataset.menuData) {
            try {
                menuData = JSON.parse(menuItem.dataset.menuData);
            } catch (e) {
                console.error('Error parsing menu data:', e);
            }
        }
        
        // Fallback to basic data
        const title = menuData.title || menuItem.querySelector('.menu-name').value;
        const alias = menuData.alias || title.toLowerCase().replace(/\s+/g, '-');
        
        // Populate form
        document.getElementById('menuTitle').value = title;
        document.getElementById('menuAlias').value = alias;
        document.getElementById('menuType').value = menuData.menuType || '';
        document.getElementById('parentItem').value = menuData.parentItem || '';
        document.getElementById('menuOrder').value = menuData.menuOrder || '0';
        document.getElementById('targetWindow').value = menuData.targetWindow || '_self';
        document.getElementById('accessLevel').value = menuData.accessLevel || 'public';
        document.getElementById('menuItemType').value = menuData.menuItemType || '';
        
        // Show relevant dynamic field
        toggleDynamicFields(menuData.menuItemType || '');
        
        // Populate dynamic content
        if (menuData.menuItemType) {
            switch(menuData.menuItemType) {
                case 'url':
                    document.getElementById('menuUrl').value = menuData.dynamicContent || '';
                    break;
                case 'page':
                    document.getElementById('selectedPage').value = menuData.dynamicContent || '';
                    break;
                case 'category':
                    document.getElementById('selectedCategory').value = menuData.dynamicContent || '';
                    break;
                case 'product':
                    document.getElementById('selectedProduct').value = menuData.dynamicContent || '';
                    break;
                case 'custom':
                    document.getElementById('customHtml').value = menuData.dynamicContent || '';
                    break;
            }
        }
        
        // Update parent items list
        populateParentItems();
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
        
        // Store the item ID for updating
        window.editingItemId = itemId;
    };
    
    // Open add menu modal
    window.openAddMenuModal = function() {
        // Reset form
        resetMenuForm();
        
        // Populate parent items
        populateParentItems();
        
        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('newMenuModal'));
        modal.show();
    };
    
    // Breadcrumb navigation functionality
    window.navigateBreadcrumb = function(section) {
        // Add loading animation to breadcrumb
        const breadcrumb = document.getElementById('mainBreadcrumb');
        breadcrumb.style.opacity = '0.6';
        
        // Show loading notification
        showNotification('Navigating to ' + section + '...', 'info');
        
        // Simulate navigation delay
        setTimeout(() => {
            switch(section) {
                case 'configuration':
                    // Navigate to configuration section
                    showNotification('Loading Configuration...', 'info');
                    // Here you would typically redirect or load configuration content
                    // window.location.href = '/admin/configuration';
                    break;
                    
                case 'menu-links':
                    // Navigate to menu links section
                    showNotification('Loading Menu Links...', 'info');
                    // Here you would typically redirect or load menu links content
                    // window.location.href = '/admin/menu-links';
                    break;
                    
                default:
                    showNotification('Navigation not implemented for: ' + section, 'warning');
            }
            
            // Reset breadcrumb opacity
            breadcrumb.style.opacity = '1';
        }, 1000);
    };
    
    // Dynamic breadcrumb update function
    window.updateBreadcrumb = function(newPath) {
        const breadcrumb = document.getElementById('mainBreadcrumb');
        
        // Clear existing breadcrumb items except the first one
        const items = breadcrumb.querySelectorAll('.breadcrumb-item:not(:first-child)');
        items.forEach(item => item.remove());
        
        // Add new breadcrumb items based on path
        const pathSegments = newPath.split('/');
        let currentPath = '';
        
        pathSegments.forEach((segment, index) => {
            currentPath += segment;
            
            // Create separator
            if (index > 0) {
                const separator = document.createElement('li');
                separator.className = 'breadcrumb-separator';
                separator.textContent = '>';
                breadcrumb.appendChild(separator);
            }
            
            // Create breadcrumb item
            const item = document.createElement('li');
            item.className = index === pathSegments.length - 1 ? 'breadcrumb-item active' : 'breadcrumb-item';
            
            if (index === pathSegments.length - 1) {
                // Last item (active)
                item.innerHTML = `<i class="ri-layout-sidebar-line me-1"></i>${segment}`;
            } else {
                // Clickable item
                item.innerHTML = `<a href="#" onclick="navigateBreadcrumb('${currentPath}')" class="breadcrumb-link">
                    <i class="ri-menu-line me-1"></i>${segment}
                </a>`;
            }
            
            breadcrumb.appendChild(item);
        });
        
        // Add animation to new items
        const newItems = breadcrumb.querySelectorAll('.breadcrumb-item:not(:first-child)');
        newItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('breadcrumb-item');
        });
    };
    
    // Breadcrumb history management
    window.breadcrumbHistory = [];
    
    window.addToBreadcrumbHistory = function(path, title) {
        window.breadcrumbHistory.push({ path, title, timestamp: Date.now() });
        
        // Keep only last 10 items
        if (window.breadcrumbHistory.length > 10) {
            window.breadcrumbHistory.shift();
        }
    };
    
    window.getBreadcrumbHistory = function() {
        return window.breadcrumbHistory;
    };
    
    // Initialize breadcrumb functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add initial breadcrumb to history
        addToBreadcrumbHistory('configuration/menu-links/sidebar-right', 'Sidebar Right');
        
        // Add keyboard navigation support
        document.addEventListener('keydown', function(e) {
            if (e.altKey && e.key === 'ArrowLeft') {
                // Alt + Left Arrow - Go back in breadcrumb
                if (window.breadcrumbHistory.length > 1) {
                    const previous = window.breadcrumbHistory[window.breadcrumbHistory.length - 2];
                    navigateBreadcrumb(previous.path);
                }
            }
        });
        
        // Add breadcrumb tooltips
        const breadcrumbLinks = document.querySelectorAll('.breadcrumb-link');
        breadcrumbLinks.forEach(link => {
            link.setAttribute('title', 'Click to navigate to ' + link.textContent.trim());
        });
    });
    
    // Mega Menu Settings Functions
    window.openMegaMenuSettings = function(menuId) {
        // Open mega menu modal
        const modal = new bootstrap.Modal(document.getElementById('megaMenuModal'));
        modal.show();
        
        // Store current menu ID
        window.currentMegaMenuId = menuId;
        
        // Initialize preview
        updateMegaMenuPreview();
    };
    
    // Layout Type Selection
    window.selectLayoutType = function(type) {
        document.querySelectorAll('[onclick*="selectLayoutType"]').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        updateMegaMenuPreview();
    };
    
    // Position Selection
    window.selectPosition = function(position) {
        document.querySelectorAll('[onclick*="selectPosition"]').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        updateMegaMenuPreview();
    };
    
    // Background Type Selection
    window.selectBgType = function(type) {
        document.querySelectorAll('[onclick*="selectBgType"]').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        // Show/hide relevant settings
        document.getElementById('colorBgSettings').style.display = type === 'color' ? 'block' : 'none';
        document.getElementById('imageBgSettings').style.display = type === 'image' ? 'block' : 'none';
        document.getElementById('gradientBgSettings').style.display = type === 'gradient' ? 'block' : 'none';
        
        updateMegaMenuPreview();
    };
    
    // Add Mega Menu Column
    window.addMegaMenuColumn = function() {
        const container = document.getElementById('megaMenuColumns');
        const columnCount = container.children.length + 1;
        
        const newColumn = document.createElement('div');
        newColumn.className = 'mega-column-item';
        newColumn.setAttribute('data-column', columnCount);
        newColumn.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Column ${columnCount}</h6>
                <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-outline-primary" onclick="moveColumn('${columnCount}', 'up')">↑</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="moveColumn('${columnCount}', 'down')">↓</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeColumn('${columnCount}')">×</button>
                </div>
            </div>
            <div class="form-group mb-2">
                <label class="form-label">Column Width</label>
                <select class="form-control" id="col${columnCount}Width">
                    <option value="1">1/12</option>
                    <option value="2">2/12</option>
                    <option value="3" selected>3/12</option>
                    <option value="4">4/12</option>
                    <option value="6">6/12</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label class="form-label">Content Type</label>
                <select class="form-control" id="col${columnCount}Type" onchange="changeColumnType('${columnCount}', this.value)">
                    <option value="menu">Menu Links</option>
                    <option value="html">HTML Content</option>
                    <option value="image">Image</option>
                    <option value="widget">Widget</option>
                </select>
            </div>
            <div id="col${columnCount}Content" class="column-content">
                <div class="form-group mb-2">
                    <label class="form-label">Menu Title</label>
                    <input type="text" class="form-control" id="col${columnCount}Title" value="New Column">
                </div>
                <div class="form-group mb-2">
                    <label class="form-label">Menu Items</label>
                    <textarea class="form-control" id="col${columnCount}Items" rows="4" placeholder="Enter menu items, one per line"></textarea>
                </div>
            </div>
        `;
        
        container.appendChild(newColumn);
        updateMegaMenuPreview();
        showNotification('New column added successfully!', 'success');
    };
    
    // Remove Column
    window.removeColumn = function(columnId) {
        if (confirm('Are you sure you want to remove this column?')) {
            const column = document.querySelector(`[data-column="${columnId}"]`);
            if (column) {
                column.remove();
                updateMegaMenuPreview();
                showNotification('Column removed successfully!', 'success');
            }
        }
    };
    
    // Move Column
    window.moveColumn = function(columnId, direction) {
        const column = document.querySelector(`[data-column="${columnId}"]`);
        if (!column) return;
        
        if (direction === 'up') {
            const prevSibling = column.previousElementSibling;
            if (prevSibling) {
                column.parentNode.insertBefore(column, prevSibling);
            }
        } else if (direction === 'down') {
            const nextSibling = column.nextElementSibling;
            if (nextSibling) {
                column.parentNode.insertBefore(nextSibling, column);
            }
        }
        
        updateMegaMenuPreview();
    };
    
    // Change Column Type
    window.changeColumnType = function(columnId, type) {
        const contentDiv = document.getElementById(`col${columnId}Content`);
        if (!contentDiv) return;
        
        let content = '';
        switch(type) {
            case 'menu':
                content = `
                    <div class="form-group mb-2">
                        <label class="form-label">Menu Title</label>
                        <input type="text" class="form-control" id="col${columnId}Title" value="Menu Title">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Menu Items</label>
                        <textarea class="form-control" id="col${columnId}Items" rows="4" placeholder="Enter menu items, one per line"></textarea>
                    </div>
                `;
                break;
            case 'html':
                content = `
                    <div class="form-group mb-2">
                        <label class="form-label">HTML Content</label>
                        <textarea class="form-control" id="col${columnId}Html" rows="6" placeholder="Enter HTML content here..."></textarea>
                    </div>
                `;
                break;
            case 'image':
                content = `
                    <div class="form-group mb-2">
                        <label class="form-label">Image URL</label>
                        <input type="url" class="form-control" id="col${columnId}Image" placeholder="Enter image URL">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Image Alt Text</label>
                        <input type="text" class="form-control" id="col${columnId}Alt" placeholder="Alt text for image">
                    </div>
                `;
                break;
            case 'widget':
                content = `
                    <div class="form-group mb-2">
                        <label class="form-label">Widget Type</label>
                        <select class="form-control" id="col${columnId}Widget">
                            <option value="search">Search Box</option>
                            <option value="newsletter">Newsletter Signup</option>
                            <option value="social">Social Links</option>
                            <option value="contact">Contact Info</option>
                        </select>
                    </div>
                `;
                break;
        }
        
        contentDiv.innerHTML = content;
        updateMegaMenuPreview();
    };
    
    // Update Mega Menu Preview
    function updateMegaMenuPreview() {
        const preview = document.getElementById('megaMenuPreview');
        if (!preview) return;
        
        // Get current settings
        const layoutType = document.querySelector('[onclick*="selectLayoutType"].active')?.textContent || 'Grid';
        const gridColumns = document.getElementById('gridColumns')?.value || '3';
        const width = document.getElementById('megaMenuWidth')?.value || '800';
        const height = document.getElementById('megaMenuHeight')?.value || '400';
        const bgColor = document.getElementById('bgColor')?.value || '#ffffff';
        const borderRadius = document.getElementById('borderRadius')?.value || '8';
        
        // Generate preview HTML
        let previewHTML = `
            <div class="mega-menu-demo" style="
                width: ${Math.min(width, 600)}px;
                height: ${Math.min(height, 300)}px;
                background-color: ${bgColor};
                border-radius: ${borderRadius}px;
                padding: 20px;
            ">
                <h6 style="color: #007bff; margin-bottom: 15px;">Mega Menu Preview</h6>
                <div class="demo-columns" style="display: grid; grid-template-columns: repeat(${gridColumns}, 1fr); gap: 15px;">
        `;
        
        // Add columns
        const columns = document.querySelectorAll('.mega-column-item');
        columns.forEach((column, index) => {
            const title = document.getElementById(`col${index + 1}Title`)?.value || `Column ${index + 1}`;
            const items = document.getElementById(`col${index + 1}Items`)?.value || '';
            const itemsList = items.split('\n').filter(item => item.trim()).map(item => `<li><a href="#">${item.trim()}</a></li>`).join('');
            
            previewHTML += `
                <div class="demo-column">
                    <h6>${title}</h6>
                    <ul>${itemsList}</ul>
                </div>
            `;
        });
        
        previewHTML += `
                </div>
            </div>
        `;
        
        preview.innerHTML = previewHTML;
    }
    
    // Save Mega Menu Settings
    window.saveMegaMenuSettings = function() {
        // Collect all settings
        const settings = {
            layoutType: document.querySelector('[onclick*="selectLayoutType"].active')?.textContent || 'Grid',
            gridColumns: document.getElementById('gridColumns')?.value || '3',
            width: document.getElementById('megaMenuWidth')?.value || '800',
            height: document.getElementById('megaMenuHeight')?.value || '400',
            position: document.querySelector('[onclick*="selectPosition"].active')?.textContent || 'Left',
            animation: document.getElementById('megaMenuAnimation')?.value || 'fade',
            bgType: document.querySelector('[onclick*="selectBgType"].active')?.textContent || 'Color',
            bgColor: document.getElementById('bgColor')?.value || '#ffffff',
            bgImage: document.getElementById('bgImageUrl')?.value || '',
            gradientColor1: document.getElementById('gradientColor1')?.value || '#007bff',
            gradientColor2: document.getElementById('gradientColor2')?.value || '#6f42c1',
            borderStyle: document.getElementById('borderStyle')?.value || 'solid',
            borderWidth: document.getElementById('borderWidth')?.value || '1',
            borderColor: document.getElementById('borderColor')?.value || '#dee2e6',
            borderRadius: document.getElementById('borderRadius')?.value || '8',
            shadowX: document.getElementById('shadowX')?.value || '0',
            shadowY: document.getElementById('shadowY')?.value || '4',
            shadowBlur: document.getElementById('shadowBlur')?.value || '8',
            shadowSpread: document.getElementById('shadowSpread')?.value || '0',
            shadowColor: document.getElementById('shadowColor')?.value || '#000000',
            zIndex: document.getElementById('megaZIndex')?.value || '1000',
            opacity: document.getElementById('megaOpacity')?.value || '1',
            customCSS: document.getElementById('customCSS')?.value || '',
            mobileBreakpoint: document.getElementById('mobileBreakpoint')?.value || '768',
            mobileBehavior: document.getElementById('mobileBehavior')?.value || 'collapse'
        };
        
        // Collect column data
        const columns = [];
        document.querySelectorAll('.mega-column-item').forEach((column, index) => {
            const columnData = {
                id: index + 1,
                width: document.getElementById(`col${index + 1}Width`)?.value || '3',
                type: document.getElementById(`col${index + 1}Type`)?.value || 'menu',
                title: document.getElementById(`col${index + 1}Title`)?.value || '',
                content: document.getElementById(`col${index + 1}Items`)?.value || ''
            };
            columns.push(columnData);
        });
        
        settings.columns = columns;
        
        // Store settings
        localStorage.setItem('megaMenuSettings_' + window.currentMegaMenuId, JSON.stringify(settings));
        
        // Show success message
        showNotification('Mega menu settings saved successfully!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('megaMenuModal'));
        modal.hide();
        
        console.log('Mega Menu Settings:', settings);
    };
    
    // Upload Background Image
    window.uploadBgImage = function() {
        // Create file input
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function(e) {
            const file = e.target.files[0];
            if (file) {
                // In a real application, you would upload the file to your server
                // For now, we'll create a local URL
                const url = URL.createObjectURL(file);
                document.getElementById('bgImageUrl').value = url;
                updateMegaMenuPreview();
                showNotification('Image uploaded successfully!', 'success');
            }
        };
        input.click();
    };
    
        // Initialize opacity slider
        document.addEventListener('DOMContentLoaded', function() {
            const opacitySlider = document.getElementById('megaOpacity');
            const opacityValue = document.getElementById('opacityValue');
            
            if (opacitySlider && opacityValue) {
                opacitySlider.addEventListener('input', function() {
                    opacityValue.textContent = this.value;
                    updateMegaMenuPreview();
                });
            }
            
            // Add event listeners for real-time preview updates
            const previewInputs = [
                'gridColumns', 'megaMenuWidth', 'megaMenuHeight', 'bgColor', 
                'borderRadius', 'shadowX', 'shadowY', 'shadowBlur', 'shadowSpread', 'shadowColor'
            ];
            
            previewInputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateMegaMenuPreview);
                    element.addEventListener('change', updateMegaMenuPreview);
                }
            });
        });
        
        // Menu Item Styling Functions
        window.selectMenuBgType = function(type) {
            document.querySelectorAll('[onclick*="selectMenuBgType"]').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Show/hide relevant settings
            document.getElementById('menuColorBg').style.display = type === 'color' ? 'block' : 'none';
            document.getElementById('menuGradientBg').style.display = type === 'gradient' ? 'block' : 'none';
            document.getElementById('menuImageBg').style.display = type === 'image' ? 'block' : 'none';
        };
        
        // Upload Menu Background Image
        window.uploadMenuBgImage = function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    document.getElementById('menuBgImage').value = url;
                    showNotification('Menu background image uploaded successfully!', 'success');
                }
            };
            input.click();
        };
        
        // Initialize menu styling functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Color picker synchronization
            const colorInputs = [
                { color: 'menuBgColor', text: 'menuBgColorText' },
                { color: 'menuTextColor', text: 'menuTextColorText' },
                { color: 'menuHoverBg', text: 'menuHoverBgText' },
                { color: 'menuHoverText', text: 'menuHoverTextText' },
                { color: 'menuBorderColor', text: 'menuBorderColorText' },
                { color: 'menuShadowColor', text: 'menuShadowColorText' }
            ];
            
            colorInputs.forEach(({ color, text }) => {
                const colorInput = document.getElementById(color);
                const textInput = document.getElementById(text);
                
                if (colorInput && textInput) {
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value;
                    });
                    
                    textInput.addEventListener('input', function() {
                        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                            colorInput.value = this.value;
                        }
                    });
                }
            });
            
            // Animation duration slider
            const animationSlider = document.getElementById('menuAnimationDuration');
            const animationValue = document.getElementById('animationDurationValue');
            
            if (animationSlider && animationValue) {
                animationSlider.addEventListener('input', function() {
                    animationValue.textContent = this.value + 's';
                });
            }
            
            // Conditional display logic
            const showForSelect = document.getElementById('menuShowFor');
            const customConditionDiv = document.getElementById('customConditionDiv');
            
            if (showForSelect && customConditionDiv) {
                showForSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customConditionDiv.style.display = 'block';
                    } else {
                        customConditionDiv.style.display = 'none';
                    }
                });
            }
            
            // Form validation
            const menuForm = document.querySelector('#newMenuModal form');
            if (menuForm) {
                menuForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    validateMenuForm();
                });
            }
        });
        
        // Menu form validation
        function validateMenuForm() {
            const title = document.getElementById('menuTitle').value.trim();
            const menuType = document.getElementById('menuType').value;
            const menuItemType = document.getElementById('menuItemType').value;
            
            let isValid = true;
            
            // Validate title
            if (!title) {
                showFieldError('menuTitle', 'Please enter a menu title');
                isValid = false;
            } else {
                clearFieldError('menuTitle');
            }
            
            // Validate menu type
            if (!menuType) {
                showFieldError('menuType', 'Please select a menu type');
                isValid = false;
            } else {
                clearFieldError('menuType');
            }
            
            // Validate menu item type
            if (!menuItemType) {
                showFieldError('menuItemType', 'Please select a menu item type');
                isValid = false;
            } else {
                clearFieldError('menuItemType');
            }
            
            // Validate dynamic content based on type
            if (menuItemType === 'url') {
                const url = document.getElementById('menuUrl').value.trim();
                if (!url) {
                    showFieldError('menuUrl', 'Please enter a URL');
                    isValid = false;
                } else if (!isValidUrl(url)) {
                    showFieldError('menuUrl', 'Please enter a valid URL');
                    isValid = false;
                } else {
                    clearFieldError('menuUrl');
                }
            }
            
            if (isValid) {
                saveNewMenu();
            } else {
                showNotification('Please fix the errors above', 'error');
            }
        }
        
        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const feedback = field.nextElementSibling;
            
            field.classList.add('is-invalid');
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = message;
            }
        }
        
        function clearFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            field.classList.remove('is-invalid');
        }
        
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }
        
        // Enhanced save function with styling data - Already global via window
        window.saveNewMenu = function() {
            // Get basic form values
            const title = document.getElementById('menuTitle').value.trim();
            const alias = document.getElementById('menuAlias').value.trim();
            // Use route-specific menu type instead of form value
            const menuType = currentMenuType;
            const parentItem = document.getElementById('parentItem')?.value || '';
            const menuOrder = document.getElementById('menuOrder')?.value || '0';
            const targetWindow = document.getElementById('targetWindow')?.value || '_self';
            const accessLevel = document.getElementById('accessLevel')?.value || 'public';
            const menuItemType = document.getElementById('menuItemType')?.value || '';
            
            console.log('Form Values:', {
                title,
                menuType,
                parentItem,
                menuItemType,
                hasParent: parentItem !== ''
            });
            
            // Get styling data
            const styling = {
                background: {
                    type: document.querySelector('[onclick*="selectMenuBgType"].active')?.textContent || 'Color',
                    color: document.getElementById('menuBgColor')?.value || '#ffffff',
                    gradient1: document.getElementById('menuGradient1')?.value || '#007bff',
                    gradient2: document.getElementById('menuGradient2')?.value || '#6f42c1',
                    gradientDirection: document.getElementById('menuGradientDirection')?.value || 'to right',
                    image: document.getElementById('menuBgImage')?.value || '',
                    imagePosition: document.getElementById('menuImagePosition')?.value || 'center'
                },
                text: {
                    color: document.getElementById('menuTextColor')?.value || '#333333',
                    hoverColor: document.getElementById('menuHoverText')?.value || '#007bff'
                },
                hover: {
                    background: document.getElementById('menuHoverBg')?.value || '#e3f2fd',
                    animation: document.getElementById('menuHoverAnimation')?.value || 'none',
                    duration: document.getElementById('menuAnimationDuration')?.value || '0.3'
                },
                border: {
                    style: document.getElementById('menuBorderStyle')?.value || 'none',
                    width: document.getElementById('menuBorderWidth')?.value || '1',
                    color: document.getElementById('menuBorderColor')?.value || '#dee2e6',
                    radius: document.getElementById('menuBorderRadius')?.value || '4'
                },
                shadow: {
                    x: document.getElementById('menuShadowX')?.value || '0',
                    y: document.getElementById('menuShadowY')?.value || '2',
                    blur: document.getElementById('menuShadowBlur')?.value || '4',
                    spread: document.getElementById('menuShadowSpread')?.value || '0',
                    color: document.getElementById('menuShadowColor')?.value || '#000000'
                }
            };
            
            // Get advanced settings
            const advanced = {
                cssClasses: document.getElementById('menuCssClasses')?.value || '',
                customCss: document.getElementById('menuCustomCss')?.value || '',
                onClick: document.getElementById('menuOnClick')?.value || '',
                onHover: document.getElementById('menuOnHover')?.value || '',
                titleAttr: document.getElementById('menuTitleAttr')?.value || '',
                relAttr: document.getElementById('menuRelAttr')?.value || '',
                metaDesc: document.getElementById('menuMetaDesc')?.value || '',
                ariaLabel: document.getElementById('menuAriaLabel')?.value || '',
                role: document.getElementById('menuRole')?.value || '',
                lazyLoad: document.getElementById('menuLazyLoad')?.checked || false,
                preload: document.getElementById('menuPreload')?.checked || false,
                gaEvent: document.getElementById('menuGaEvent')?.value || '',
                trackingId: document.getElementById('menuTrackingId')?.value || '',
                showFor: document.getElementById('menuShowFor')?.value || 'all',
                customCondition: document.getElementById('menuCustomCondition')?.value || '',
                cacheDuration: document.getElementById('menuCacheDuration')?.value || '0'
            };
            
            // Get dynamic content based on item type
            let dynamicContent = '';
            let dynamicLabel = '';
            
            switch(menuItemType) {
                case 'url':
                    dynamicContent = document.getElementById('menuUrl').value.trim();
                    dynamicLabel = 'URL';
                    break;
                case 'page':
                    dynamicContent = document.getElementById('selectedPage').value;
                    dynamicLabel = 'Page';
                    break;
                case 'category':
                    dynamicContent = document.getElementById('selectedCategory').value;
                    dynamicLabel = 'Category';
                    break;
                case 'product':
                    dynamicContent = document.getElementById('selectedProduct').value;
                    dynamicLabel = 'Product';
                    break;
                case 'custom':
                    dynamicContent = document.getElementById('customHtml').value.trim();
                    dynamicLabel = 'Custom HTML';
                    break;
            }
            
            // Validation
            if (!title) {
                showNotification('Please enter a title for the menu item!', 'error');
                document.getElementById('menuTitle').focus();
                return;
            }
            
            if (!menuType) {
                showNotification('Menu type is not set!', 'error');
                return;
            }
            
            if (!menuItemType) {
                showNotification('Please select a menu item type!', 'error');
                document.getElementById('menuItemType').focus();
                return;
            }
            
            if (menuItemType !== 'custom' && !dynamicContent) {
                showNotification(`Please select a ${dynamicLabel.toLowerCase()}!`, 'error');
                return;
            }
            
            // Prepare data for API
            const parentIdValue = (parentItem && parentItem !== '') ? parseInt(parentItem) : null;
            
            console.log('Parent Item Info:', {
                rawValue: parentItem,
                parsedValue: parentIdValue,
                isSubmenu: parentIdValue !== null
            });
            
            const apiData = {
                menu_type: menuType,
                title: title,
                alias: alias || title.toLowerCase().replace(/\s+/g, '-'),
                menu_item_type: menuItemType,
                url: dynamicContent || '#',
                icon: null, // Icon field can be added later if needed
                parent_id: parentIdValue,
                sort_order: parseInt(menuOrder) || 0,
                is_active: true,
                is_visible: true,
                target_window: targetWindow || '_self',
                access_level: accessLevel || 'public',
                styling: styling || null,
                advanced: advanced || null
            };
            
            // Check if we're editing an existing item
            if (window.editingItemId) {
                // Update existing item via API
                const updateUrl = getApiBaseUrl() + '/items/' + window.editingItemId;
                
                console.log('Updating menu item:', apiData);
                console.log('API URL:', updateUrl);
                
                fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(apiData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Server error: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Update existing item in DOM
                        const existingItem = document.querySelector(`[data-id="${window.editingItemId}"]`);
                        if (existingItem) {
                            const nameInput = existingItem.querySelector('.menu-name');
                            if (nameInput) nameInput.value = title;
                            
                            // Update stored data
                            existingItem.dataset.menuData = JSON.stringify({
                                title, alias, menuType, parentItem, menuOrder, 
                                targetWindow, accessLevel, menuItemType, dynamicContent,
                                styling, advanced
                            });
                            
                            // Apply styling
                            applyMenuStyling(existingItem, styling);
                        }
                        
                        showNotification('Menu item "' + title + '" updated successfully!', 'success');
                        
                        // Clear editing state
                        window.editingItemId = null;
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('newMenuModal'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Reset form
                        resetMenuForm();
                    } else {
                        showNotification(data.message || 'Error updating menu item!', 'error');
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                            const firstError = Object.values(data.errors)[0];
                            if (firstError && firstError.length > 0) {
                                showNotification(firstError[0], 'error');
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error updating menu item: ' + error.message, 'error');
                });
                
                // Return early to prevent creating new item
                return;
            } else {
                // Create new item via API
                const saveUrl = getApiBaseUrl() + '/item';
                
                console.log('=== SAVING MENU ITEM ===');
                console.log('API URL:', saveUrl);
                console.log('Form parentItem value:', parentItem);
                console.log('Parsed parentIdValue:', parentIdValue);
                console.log('Full API Data:', apiData);
                console.log('Is Submenu:', parentIdValue !== null);
                
                fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(apiData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Server error: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success && data.menu_item) {
                        const menuItem = data.menu_item;
                        
                        console.log('Menu item received from server:', {
                            id: menuItem.id,
                            title: menuItem.title,
                            parent_id: menuItem.parent_id,
                            menu_type: menuItem.menu_type
                        });
                        
                        // Remove "No menu items" message if exists
                        const noItemsMsg = document.querySelector('#menu-links-list .text-center.p-5.text-muted');
                        if (noItemsMsg) {
                            noItemsMsg.remove();
                        }
                        
                        // Create menu item HTML
                        const menuItemHtml = createMenuItemHTML(menuItem, parentItem);
                        
                        // Determine where to add the item
                        let targetContainer = document.getElementById('menu-links-list');
                        
                        // Check if this is a submenu item (has parent_id)
                        const actualParentId = menuItem.parent_id || (parentItem && parentItem !== '' ? parseInt(parentItem) : null);
                        
                        console.log('Adding menu item to DOM:', {
                            menuItemId: menuItem.id,
                            menuItemParentId: menuItem.parent_id,
                            formParentItem: parentItem,
                            actualParentId: actualParentId,
                            isSubmenu: actualParentId !== null,
                            parentIdType: typeof actualParentId
                        });
                        
                        if (actualParentId) {
                            // Find parent item and add to its sub-menu
                            const parentElement = document.querySelector(`[data-id="${actualParentId}"]`);
                            console.log('Parent element search:', {
                                searchingFor: actualParentId,
                                found: parentElement !== null,
                                parentElement: parentElement
                            });
                            
                            if (parentElement) {
                                let subMenu = parentElement.nextElementSibling;
                                if (!subMenu || !subMenu.classList.contains('sub-menu')) {
                                    console.log('Creating new sub-menu container');
                                    subMenu = document.createElement('div');
                                    subMenu.className = 'sub-menu';
                                    subMenu.id = 'submenu-' + actualParentId;
                                    subMenu.style.display = 'block';
                                    parentElement.parentNode.insertBefore(subMenu, parentElement.nextSibling);
                                    
                                    // Add expand icon to parent if not exists
                                    if (!parentElement.querySelector('.expand-icon')) {
                                        const expandIcon = document.createElement('span');
                                        expandIcon.className = 'expand-icon';
                                        expandIcon.innerHTML = '⌄';
                                        expandIcon.onclick = function() {
                                            toggleSubMenuExpand(expandIcon, actualParentId);
                                        };
                                        expandIcon.style.cursor = 'pointer';
                                        parentElement.appendChild(expandIcon);
                                    }
                                } else {
                                    console.log('Sub-menu already exists');
                                }
                                targetContainer = subMenu;
                                console.log('Submenu found/created, adding item to submenu');
                            } else {
                                console.error('Parent element not found for parent_id:', actualParentId);
                                console.log('Available menu items:', Array.from(document.querySelectorAll('.menu-item')).map(item => ({
                                    id: item.dataset.id,
                                    title: item.querySelector('.menu-name')?.value
                                })));
                                // Fallback: add to root level if parent not found
                                targetContainer = document.getElementById('menu-links-list');
                                showNotification('Warning: Parent not found, adding to root level', 'warning');
                            }
                        } else {
                            console.log('Root level item, adding to main list');
                        }
                        
                        // Add menu item to DOM
                        console.log('Adding HTML to container:', targetContainer);
                        targetContainer.insertAdjacentHTML('beforeend', menuItemHtml);
                        
                        // Re-initialize drag and drop for new item
                        const newItem = targetContainer.querySelector(`[data-id="${menuItem.id}"]`);
                        if (newItem) {
                            console.log('New item added successfully:', newItem);
                            initializeDragAndDrop(newItem);
                            
                            // Scroll to new item
                            newItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            
                            // Highlight new item briefly
                            newItem.style.background = '#d4edda';
                            setTimeout(() => {
                                newItem.style.background = '';
                            }, 2000);
                        } else {
                            console.error('New item not found in DOM after insertion!');
                        }
                        
                        // Update parent items dropdown
                        populateParentItems();
                        
                        showNotification('New menu item "' + title + '" saved successfully!', 'success');
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('newMenuModal'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Reset form
                        resetMenuForm();
                    } else {
                        const errorMsg = data.message || 'Error saving menu item!';
                        console.error('Save failed:', data);
                        showNotification(errorMsg, 'error');
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                            // Show first validation error
                            const firstError = Object.values(data.errors)[0];
                            if (firstError && firstError.length > 0) {
                                showNotification(firstError[0], 'error');
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error saving menu item:', error);
                    showNotification('Error saving menu item: ' + error.message, 'error');
                });
                
                // Return early to prevent DOM manipulation before API call completes
                return;
            }
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newMenuModal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset form
            resetMenuForm();
        };
        
        // Apply styling to menu item
        function applyMenuStyling(element, styling) {
            if (!element || !styling) return;
            
            const style = element.style;
            
            // Background
            if (styling.background.type === 'Color') {
                style.backgroundColor = styling.background.color;
            } else if (styling.background.type === 'Gradient') {
                style.background = `linear-gradient(${styling.background.gradientDirection}, ${styling.background.gradient1}, ${styling.background.gradient2})`;
            } else if (styling.background.type === 'Image') {
                style.backgroundImage = `url(${styling.background.image})`;
                style.backgroundPosition = styling.background.imagePosition;
                style.backgroundSize = 'cover';
                style.backgroundRepeat = 'no-repeat';
            }
            
            // Text color
            style.color = styling.text.color;
            
            // Border
            if (styling.border.style !== 'none') {
                style.border = `${styling.border.width}px ${styling.border.style} ${styling.border.color}`;
            }
            style.borderRadius = `${styling.border.radius}px`;
            
            // Shadow
            if (styling.shadow.x || styling.shadow.y || styling.shadow.blur) {
                style.boxShadow = `${styling.shadow.x}px ${styling.shadow.y}px ${styling.shadow.blur}px ${styling.shadow.spread}px ${styling.shadow.color}`;
            }
            
            // Add CSS classes
            if (styling.advanced && styling.advanced.cssClasses) {
                element.className += ' ' + styling.advanced.cssClasses;
            }
        }
</script>

<!-- New Menu Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add/Edit Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Panel: Menu Link Details -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Menu Link Details</h6>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control" id="menuTitle" placeholder="Enter menu title" required>
                            <div class="invalid-feedback">Please enter a valid title.</div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Alias</label>
                            <input type="text" class="form-control" id="menuAlias" placeholder="auto-generated from title">
                            <small class="text-muted">The Alias will be used as part of the URL.</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Menu Type</label>
                            <input type="text" class="form-control" value="Sidebar Left - {{ ucfirst($routePrefix ?? 'Config') }}" readonly style="background-color: #e9ecef;">
                            <small class="text-muted">Menu items will appear in {{ ucfirst($routePrefix ?? 'Config') }} section sidebar only</small>
                            <input type="hidden" id="menuType" value="{{ $menuType ?? 'sidebar-left-config' }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Parent Item</label>
                            <select class="form-control" id="parentItem">
                                <option value="">Root Level (No Parent)</option>
                            </select>
                            <small class="text-muted">Select a parent item to create a sub-menu.</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Ordering</label>
                            <input type="number" class="form-control" id="menuOrder" value="0" min="0" max="999">
                            <small class="text-muted">Lower numbers appear first.</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Target Window</label>
                            <select class="form-control" id="targetWindow">
                                <option value="_self">Same Window</option>
                                <option value="_blank">New Window</option>
                                <option value="_parent">Parent Window</option>
                                <option value="_top">Top Window</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Access Level</label>
                            <select class="form-control" id="accessLevel">
                                <option value="public">Public</option>
                                <option value="registered">Registered Users</option>
                                <option value="admin">Admin Only</option>
                                <option value="super">Super Users</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Menu Item Type *</label>
                            <select class="form-control" id="menuItemType" required>
                                <option value="">Select Item Type</option>
                                <option value="url">URL Link</option>
                                <option value="page">Page</option>
                                <option value="category">Category</option>
                                <option value="product">Product</option>
                                <option value="custom">Custom HTML</option>
                            </select>
                            <div class="invalid-feedback">Please select a menu item type.</div>
                        </div>
                        
                        <div class="form-group mb-3" id="urlField" style="display: none;">
                            <label class="form-label">URL *</label>
                            <input type="url" class="form-control" id="menuUrl" placeholder="https://example.com">
                            <div class="invalid-feedback">Please enter a valid URL.</div>
                        </div>
                        
                        <div class="form-group mb-3" id="pageField" style="display: none;">
                            <label class="form-label">Select Page *</label>
                            <select class="form-control" id="selectedPage">
                                <option value="">Choose a page</option>
                                <option value="home">Home</option>
                                <option value="about">About Us</option>
                                <option value="contact">Contact</option>
                                <option value="services">Services</option>
                                <option value="products">Products</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3" id="categoryField" style="display: none;">
                            <label class="form-label">Select Category *</label>
                            <select class="form-control" id="selectedCategory">
                                <option value="">Choose a category</option>
                                <option value="electronics">Electronics</option>
                                <option value="clothing">Clothing</option>
                                <option value="books">Books</option>
                                <option value="home">Home & Garden</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3" id="productField" style="display: none;">
                            <label class="form-label">Select Product *</label>
                            <select class="form-control" id="selectedProduct">
                                <option value="">Choose a product</option>
                                <option value="laptop">Laptop</option>
                                <option value="phone">Smartphone</option>
                                <option value="tablet">Tablet</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3" id="customHtmlField" style="display: none;">
                            <label class="form-label">Custom HTML *</label>
                            <textarea class="form-control" id="customHtml" rows="4" placeholder="Enter custom HTML content"></textarea>
                        </div>
                    </div>
                    
                    <!-- Right Panel: Styling and Advanced -->
                    <div class="col-md-6">
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#content-tab" data-bs-toggle="tab">Content</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#style-tab" data-bs-toggle="tab">Style</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#advanced-tab" data-bs-toggle="tab">Advanced</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="content-tab">
                                <h6 class="mb-3">Icon</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Display</label>
                                    <select class="form-control">
                                        <option>Inline Block</option>
                                        <option>Block</option>
                                        <option>Inline</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Position</label>
                                    <select class="form-control">
                                        <option>Static</option>
                                        <option>Relative</option>
                                        <option>Absolute</option>
                                    </select>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label class="form-label">Top</label>
                                        <select class="form-control">
                                            <option>auto</option>
                                            <option>0px</option>
                                            <option>10px</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Left</label>
                                        <select class="form-control">
                                            <option>auto</option>
                                            <option>0px</option>
                                            <option>10px</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Bottom</label>
                                        <select class="form-control">
                                            <option>auto</option>
                                            <option>0px</option>
                                            <option>10px</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Right</label>
                                        <select class="form-control">
                                            <option>auto</option>
                                            <option>0px</option>
                                            <option>10px</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Float</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary active">X</button>
                                        <button class="btn btn-outline-secondary">≡</button>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Opacity</label>
                                    <input type="range" class="form-control" min="0" max="1" step="0.1" value="1">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Background</label>
                                        <input type="color" class="form-control" value="#000000">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Text Color</label>
                                        <input type="color" class="form-control" value="#ffffff">
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Typography</h6>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Font size</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" value="16 px">
                                            <select class="form-control">
                                                <option>px</option>
                                                <option>em</option>
                                                <option>rem</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Font weight</label>
                                        <select class="form-control">
                                            <option>Normal</option>
                                            <option>Bold</option>
                                            <option>Light</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Font family</label>
                                    <select class="form-control">
                                        <option></option>
                                        <option>Arial</option>
                                        <option>Helvetica</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Text align</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary active">⫸</button>
                                        <button class="btn btn-outline-secondary">⫷</button>
                                        <button class="btn btn-outline-secondary">⫸</button>
                                        <button class="btn btn-outline-secondary">⫷</button>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Line height</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" value="24 px">
                                            <select class="form-control">
                                                <option>px</option>
                                                <option>em</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Letter spacing</label>
                                        <select class="form-control">
                                            <option></option>
                                            <option>0px</option>
                                            <option>1px</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Text decoration</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary active">X</button>
                                        <button class="btn btn-outline-secondary">U</button>
                                        <button class="btn btn-outline-secondary">S</button>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Decoration Color</label>
                                    <input type="color" class="form-control" value="#ffffff">
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="style-tab">
                                <!-- Menu Item Styling -->
                                <h6 class="mb-3">Menu Item Styling</h6>
                                
                                <!-- Background Settings -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Background Type</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary active" onclick="selectMenuBgType('color')">Color</button>
                                        <button class="btn btn-outline-secondary" onclick="selectMenuBgType('gradient')">Gradient</button>
                                        <button class="btn btn-outline-secondary" onclick="selectMenuBgType('image')">Image</button>
                                    </div>
                                </div>
                                
                                <!-- Color Background -->
                                <div id="menuColorBg" class="menu-bg-settings">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Background Color</label>
                                        <div class="d-flex gap-2">
                                            <input type="color" class="form-control" id="menuBgColor" value="#ffffff" style="width: 60px;">
                                            <input type="text" class="form-control" id="menuBgColorText" value="#ffffff">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Gradient Background -->
                                <div id="menuGradientBg" class="menu-bg-settings" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gradient Colors</label>
                                        <div class="d-flex gap-2">
                                            <input type="color" class="form-control" id="menuGradient1" value="#007bff" style="width: 60px;">
                                            <input type="color" class="form-control" id="menuGradient2" value="#6f42c1" style="width: 60px;">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gradient Direction</label>
                                        <select class="form-control" id="menuGradientDirection">
                                            <option value="to right">Left to Right</option>
                                            <option value="to bottom">Top to Bottom</option>
                                            <option value="to bottom right">Diagonal</option>
                                            <option value="45deg">45 Degrees</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Image Background -->
                                <div id="menuImageBg" class="menu-bg-settings" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Background Image</label>
                                        <div class="d-flex gap-2">
                                            <input type="url" class="form-control" id="menuBgImage" placeholder="Image URL">
                                            <button class="btn btn-outline-secondary" onclick="uploadMenuBgImage()">Upload</button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Image Position</label>
                                        <select class="form-control" id="menuImagePosition">
                                            <option value="center">Center</option>
                                            <option value="top">Top</option>
                                            <option value="bottom">Bottom</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Text Color -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Text Color</label>
                                    <div class="d-flex gap-2">
                                        <input type="color" class="form-control" id="menuTextColor" value="#333333" style="width: 60px;">
                                        <input type="text" class="form-control" id="menuTextColorText" value="#333333">
                                    </div>
                                </div>
                                
                                <!-- Hover Effects -->
                                <h6 class="mb-3 mt-4">Hover Effects</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Hover Background</label>
                                    <div class="d-flex gap-2">
                                        <input type="color" class="form-control" id="menuHoverBg" value="#e3f2fd" style="width: 60px;">
                                        <input type="text" class="form-control" id="menuHoverBgText" value="#e3f2fd">
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Hover Text Color</label>
                                    <div class="d-flex gap-2">
                                        <input type="color" class="form-control" id="menuHoverText" value="#007bff" style="width: 60px;">
                                        <input type="text" class="form-control" id="menuHoverTextText" value="#007bff">
                                    </div>
                                </div>
                                
                                <!-- Border Settings -->
                                <h6 class="mb-3 mt-4">Border</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Style</label>
                                    <select class="form-control" id="menuBorderStyle">
                                        <option value="none">None</option>
                                        <option value="solid">Solid</option>
                                        <option value="dashed">Dashed</option>
                                        <option value="dotted">Dotted</option>
                                    </select>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Border Width</label>
                                        <input type="number" class="form-control" id="menuBorderWidth" value="1" min="0" max="10">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Border Color</label>
                                        <input type="color" class="form-control" id="menuBorderColor" value="#dee2e6" style="width: 100px;">
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Radius</label>
                                    <input type="number" class="form-control" id="menuBorderRadius" value="4" min="0" max="50">
                                </div>
                                
                                <!-- Shadow Effects -->
                                <h6 class="mb-3 mt-4">Shadow</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Box Shadow</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" class="form-control" id="menuShadowX" value="0" placeholder="X">
                                        <input type="number" class="form-control" id="menuShadowY" value="2" placeholder="Y">
                                        <input type="number" class="form-control" id="menuShadowBlur" value="4" placeholder="Blur">
                                        <input type="number" class="form-control" id="menuShadowSpread" value="0" placeholder="Spread">
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Shadow Color</label>
                                    <input type="color" class="form-control" id="menuShadowColor" value="#000000" style="width: 100px;">
                                </div>
                                
                                <!-- Animation -->
                                <h6 class="mb-3 mt-4">Animation</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Hover Animation</label>
                                    <select class="form-control" id="menuHoverAnimation">
                                        <option value="none">None</option>
                                        <option value="scale">Scale</option>
                                        <option value="slide">Slide</option>
                                        <option value="fade">Fade</option>
                                        <option value="bounce">Bounce</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Animation Duration</label>
                                    <input type="range" class="form-control" id="menuAnimationDuration" min="0.1" max="2" step="0.1" value="0.3">
                                    <small class="text-muted">Duration: <span id="animationDurationValue">0.3s</span></small>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="advanced-tab">
                                <!-- Advanced Settings -->
                                <h6 class="mb-3">Advanced Settings</h6>
                                
                                <!-- CSS Classes -->
                                <div class="form-group mb-3">
                                    <label class="form-label">CSS Classes</label>
                                    <input type="text" class="form-control" id="menuCssClasses" placeholder="custom-class another-class">
                                    <small class="text-muted">Add custom CSS classes separated by spaces</small>
                                </div>
                                
                                <!-- Custom CSS -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Custom CSS</label>
                                    <textarea class="form-control" id="menuCustomCss" rows="4" placeholder="/* Custom CSS for this menu item */
.menu-item {
    /* Your custom styles here */
}"></textarea>
                                </div>
                                
                                <!-- JavaScript Events -->
                                <h6 class="mb-3 mt-4">JavaScript Events</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">OnClick Event</label>
                                    <input type="text" class="form-control" id="menuOnClick" placeholder="functionName() or alert('Hello')">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">OnHover Event</label>
                                    <input type="text" class="form-control" id="menuOnHover" placeholder="functionName() or console.log('Hovered')">
                                </div>
                                
                                <!-- SEO Settings -->
                                <h6 class="mb-3 mt-4">SEO Settings</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Title Attribute</label>
                                    <input type="text" class="form-control" id="menuTitleAttr" placeholder="Tooltip text">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Rel Attribute</label>
                                    <select class="form-control" id="menuRelAttr">
                                        <option value="">None</option>
                                        <option value="nofollow">No Follow</option>
                                        <option value="noopener">No Opener</option>
                                        <option value="noreferrer">No Referrer</option>
                                        <option value="external">External</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="menuMetaDesc" rows="2" placeholder="Meta description for SEO"></textarea>
                                </div>
                                
                                <!-- Accessibility -->
                                <h6 class="mb-3 mt-4">Accessibility</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">ARIA Label</label>
                                    <input type="text" class="form-control" id="menuAriaLabel" placeholder="Accessible label for screen readers">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-control" id="menuRole">
                                        <option value="">Default</option>
                                        <option value="button">Button</option>
                                        <option value="link">Link</option>
                                        <option value="menuitem">Menu Item</option>
                                        <option value="tab">Tab</option>
                                    </select>
                                </div>
                                
                                <!-- Performance -->
                                <h6 class="mb-3 mt-4">Performance</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Lazy Loading</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="menuLazyLoad">
                                        <label class="form-check-label" for="menuLazyLoad">
                                            Enable lazy loading for this menu item
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Preload</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="menuPreload">
                                        <label class="form-check-label" for="menuPreload">
                                            Preload this menu item's content
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Analytics -->
                                <h6 class="mb-3 mt-4">Analytics</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Google Analytics Event</label>
                                    <input type="text" class="form-control" id="menuGaEvent" placeholder="menu_click">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Custom Tracking ID</label>
                                    <input type="text" class="form-control" id="menuTrackingId" placeholder="tracking_id_123">
                                </div>
                                
                                <!-- Conditional Display -->
                                <h6 class="mb-3 mt-4">Conditional Display</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Show Only For</label>
                                    <select class="form-control" id="menuShowFor">
                                        <option value="all">All Users</option>
                                        <option value="logged_in">Logged In Users</option>
                                        <option value="guests">Guest Users</option>
                                        <option value="admin">Admin Users</option>
                                        <option value="custom">Custom Condition</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3" id="customConditionDiv" style="display: none;">
                                    <label class="form-label">Custom Condition</label>
                                    <input type="text" class="form-control" id="menuCustomCondition" placeholder="user.role === 'premium'">
                                </div>
                                
                                <!-- Cache Settings -->
                                <h6 class="mb-3 mt-4">Cache Settings</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Cache Duration</label>
                                    <select class="form-control" id="menuCacheDuration">
                                        <option value="0">No Cache</option>
                                        <option value="300">5 Minutes</option>
                                        <option value="3600">1 Hour</option>
                                        <option value="86400">1 Day</option>
                                        <option value="604800">1 Week</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveNewMenu()">Save Menu</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Settings Modal -->
<div class="modal fade" id="defaultSettingsModal" tabindex="-1" aria-labelledby="defaultSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="defaultSettingsModalLabel">Admin Styling - Sidebar Right Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column - Sidebar Configuration -->
                    <div class="col-md-4">
                        <h6 class="mb-3">SIZE</h6>
                        <div class="size-options">
                            <div class="size-option selected" onclick="selectSize(this)">
                                <i class="ri-layout-line me-2"></i>
                                <span>Default</span>
                                <i class="ri-check-line ms-auto text-primary"></i>
                            </div>
                            <div class="size-option" onclick="selectSize(this)">
                                <i class="ri-compress-line me-2"></i>
                                <span>Compact</span>
                            </div>
                            <div class="size-option" onclick="selectSize(this)">
                                <i class="ri-dashboard-line me-2"></i>
                                <span>Small (Icon View)</span>
                            </div>
                            <div class="size-option" onclick="selectSize(this)">
                                <i class="ri-eye-line me-2"></i>
                                <span>Small Hover View</span>
                            </div>
                        </div>
                        
                        <h6 class="mb-3 mt-4">LAYOUT</h6>
                        <div class="layout-options">
                            <div class="layout-option selected" onclick="selectLayout(this)">
                                <i class="ri-layout-line me-2"></i>
                                <span>Vertical</span>
                                <i class="ri-check-line ms-auto text-primary"></i>
                            </div>
                            <div class="layout-option" onclick="selectLayout(this)">
                                <i class="ri-layout-4-line me-2"></i>
                                <span>Horizontal</span>
                            </div>
                            <div class="layout-option" onclick="selectLayout(this)">
                                <i class="ri-layout-grid-line me-2"></i>
                                <span>Two Column</span>
                            </div>
                        </div>
                        
                        <h6 class="mb-3 mt-4">VIEW</h6>
                        <div class="view-options">
                            <div class="view-option selected" onclick="selectView(this)">
                                <i class="ri-eye-line me-2"></i>
                                <span>Default</span>
                                <i class="ri-check-line ms-auto text-primary"></i>
                            </div>
                            <div class="view-option" onclick="selectView(this)">
                                <i class="ri-layout-2-line me-2"></i>
                                <span>Detached</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Middle Column - Sidebar Color Configuration -->
                    <div class="col-md-4">
                        <h6 class="mb-3">SIDEBAR COLOR</h6>
                        <p class="text-muted mb-3">Choose a color of Sidebar</p>
                        
                        <div class="color-options mb-3">
                            <div class="color-option" onclick="selectColorType(this)">
                                <i class="ri-image-line me-2"></i>
                                <span>Image</span>
                            </div>
                            <div class="color-option selected" onclick="selectColorType(this)">
                                <i class="ri-palette-line me-2"></i>
                                <span>Color</span>
                                <i class="ri-check-line ms-auto text-primary"></i>
                            </div>
                            <div class="color-option" onclick="selectColorType(this)">
                                <i class="ri-gradienter-line me-2"></i>
                                <span>Gradient</span>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Background</label>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" value="rgba(0, 0, 0, 0)">
                                <input type="color" class="form-control" style="width: 50px;" value="#000000">
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Background Image</label>
                            <div class="background-image-preview mb-2" style="width: 100%; height: 100px; background: linear-gradient(45deg, #ff6b6b, #4ecdc4); border-radius: 4px;"></div>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Enter image URL">
                                <button class="btn btn-outline-secondary">Set image</button>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Repeat</label>
                                <select class="form-control">
                                    <option>repeat-x</option>
                                    <option>repeat-y</option>
                                    <option>repeat</option>
                                    <option>no-repeat</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Size</label>
                                <select class="form-control">
                                    <option>Default</option>
                                    <option>Cover</option>
                                    <option>Contain</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Position x</label>
                                <select class="form-control">
                                    <option>Left</option>
                                    <option>Center</option>
                                    <option>Right</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Position y</label>
                                <select class="form-control">
                                    <option>Top</option>
                                    <option>Center</option>
                                    <option>Bottom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Default Level Style -->
                    <div class="col-md-4">
                        <h6 class="mb-3">Default Level Style</h6>
                        
                        <div class="level-styles">
                            <div class="level-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Level 1</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                                <div class="level-content">
                                    <div class="form-group mb-2">
                                        <label class="form-label">Background</label>
                                        <input type="color" class="form-control" value="#007bff">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="form-label">Text Color</label>
                                        <input type="color" class="form-control" value="#ffffff">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="level-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Level 2</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            
                            <div class="level-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Level 3</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                            
                            <div class="level-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Level 4</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary btn-sm mt-3">
                            <i class="ri-add-line me-1"></i>+ Level
                        </button>
                        
                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <strong>Note:</strong> I also want to be able to control the active link display styling.<br>
                                Example: be able to change the background color on an active menu link so visually I can see what menu link I'm in.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveDefaultSettings()">Save Settings</button>
            </div>
        </div>
    </div>
</div>

<!-- Mega Menu Settings Modal -->
<div class="modal fade" id="megaMenuModal" tabindex="-1" aria-labelledby="megaMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="megaMenuModalLabel">Mega Menu Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Panel: Layout & Structure -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Layout & Structure</h6>
                        
                        <!-- Layout Type -->
                        <div class="form-group mb-3">
                            <label class="form-label">Layout Type</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary active" onclick="selectLayoutType('grid')">Grid</button>
                                <button class="btn btn-outline-primary" onclick="selectLayoutType('list')">List</button>
                                <button class="btn btn-outline-primary" onclick="selectLayoutType('mixed')">Mixed</button>
                            </div>
                        </div>
                        
                        <!-- Grid Settings -->
                        <div class="form-group mb-3">
                            <label class="form-label">Grid Columns</label>
                            <select class="form-control" id="gridColumns">
                                <option value="2">2 Columns</option>
                                <option value="3" selected>3 Columns</option>
                                <option value="4">4 Columns</option>
                                <option value="5">5 Columns</option>
                                <option value="6">6 Columns</option>
                            </select>
                        </div>
                        
                        <!-- Width Settings -->
                        <div class="form-group mb-3">
                            <label class="form-label">Mega Menu Width</label>
                            <div class="d-flex gap-2">
                                <input type="number" class="form-control" id="megaMenuWidth" value="800" placeholder="Width">
                                <select class="form-control" style="width: 80px;">
                                    <option>px</option>
                                    <option>%</option>
                                    <option>vw</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Height Settings -->
                        <div class="form-group mb-3">
                            <label class="form-label">Mega Menu Height</label>
                            <div class="d-flex gap-2">
                                <input type="number" class="form-control" id="megaMenuHeight" value="400" placeholder="Height">
                                <select class="form-control" style="width: 80px;">
                                    <option>px</option>
                                    <option>vh</option>
                                    <option>auto</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Position Settings -->
                        <div class="form-group mb-3">
                            <label class="form-label">Position</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary active" onclick="selectPosition('left')">Left</button>
                                <button class="btn btn-outline-secondary" onclick="selectPosition('center')">Center</button>
                                <button class="btn btn-outline-secondary" onclick="selectPosition('right')">Right</button>
                            </div>
                        </div>
                        
                        <!-- Animation Settings -->
                        <div class="form-group mb-3">
                            <label class="form-label">Animation</label>
                            <select class="form-control" id="megaMenuAnimation">
                                <option value="fade">Fade In</option>
                                <option value="slide">Slide Down</option>
                                <option value="zoom">Zoom In</option>
                                <option value="flip">Flip</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Right Panel: Styling & Design -->
                    <div class="col-md-6">
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#mega-style-tab" data-bs-toggle="tab">Style</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#mega-content-tab" data-bs-toggle="tab">Content</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#mega-advanced-tab" data-bs-toggle="tab">Advanced</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content">
                            <!-- Style Tab -->
                            <div class="tab-pane fade show active" id="mega-style-tab">
                                <!-- Background Settings -->
                                <h6 class="mb-3">Background</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Background Type</label>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary active" onclick="selectBgType('color')">Color</button>
                                        <button class="btn btn-outline-secondary" onclick="selectBgType('image')">Image</button>
                                        <button class="btn btn-outline-secondary" onclick="selectBgType('gradient')">Gradient</button>
                                    </div>
                                </div>
                                
                                <!-- Color Background -->
                                <div id="colorBgSettings">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Background Color</label>
                                        <div class="d-flex gap-2">
                                            <input type="color" class="form-control" id="bgColor" value="#ffffff" style="width: 60px;">
                                            <input type="text" class="form-control" id="bgColorText" value="#ffffff">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Image Background -->
                                <div id="imageBgSettings" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Background Image</label>
                                        <div class="d-flex gap-2">
                                            <input type="url" class="form-control" id="bgImageUrl" placeholder="Image URL">
                                            <button class="btn btn-outline-secondary" onclick="uploadBgImage()">Upload</button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Image Position</label>
                                        <select class="form-control" id="bgImagePosition">
                                            <option value="center">Center</option>
                                            <option value="top">Top</option>
                                            <option value="bottom">Bottom</option>
                                            <option value="left">Left</option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Image Size</label>
                                        <select class="form-control" id="bgImageSize">
                                            <option value="cover">Cover</option>
                                            <option value="contain">Contain</option>
                                            <option value="auto">Auto</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Gradient Background -->
                                <div id="gradientBgSettings" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gradient Colors</label>
                                        <div class="d-flex gap-2">
                                            <input type="color" class="form-control" id="gradientColor1" value="#007bff" style="width: 60px;">
                                            <input type="color" class="form-control" id="gradientColor2" value="#6f42c1" style="width: 60px;">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gradient Direction</label>
                                        <select class="form-control" id="gradientDirection">
                                            <option value="to right">Left to Right</option>
                                            <option value="to bottom">Top to Bottom</option>
                                            <option value="to bottom right">Diagonal</option>
                                            <option value="45deg">45 Degrees</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Border Settings -->
                                <h6 class="mb-3 mt-4">Border</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Style</label>
                                    <select class="form-control" id="borderStyle">
                                        <option value="none">None</option>
                                        <option value="solid">Solid</option>
                                        <option value="dashed">Dashed</option>
                                        <option value="dotted">Dotted</option>
                                        <option value="double">Double</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Width</label>
                                    <input type="number" class="form-control" id="borderWidth" value="1" min="0" max="10">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Color</label>
                                    <input type="color" class="form-control" id="borderColor" value="#dee2e6" style="width: 100px;">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Border Radius</label>
                                    <input type="number" class="form-control" id="borderRadius" value="8" min="0" max="50">
                                </div>
                                
                                <!-- Shadow Settings -->
                                <h6 class="mb-3 mt-4">Shadow</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Box Shadow</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" class="form-control" id="shadowX" value="0" placeholder="X">
                                        <input type="number" class="form-control" id="shadowY" value="4" placeholder="Y">
                                        <input type="number" class="form-control" id="shadowBlur" value="8" placeholder="Blur">
                                        <input type="number" class="form-control" id="shadowSpread" value="0" placeholder="Spread">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Shadow Color</label>
                                    <input type="color" class="form-control" id="shadowColor" value="#000000" style="width: 100px;">
                                </div>
                            </div>
                            
                            <!-- Content Tab -->
                            <div class="tab-pane fade" id="mega-content-tab">
                                <h6 class="mb-3">Content Management</h6>
                                
                                <!-- Add Column -->
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary" onclick="addMegaMenuColumn()">
                                        <i class="ri-add-line me-1"></i>Add Column
                                    </button>
                                </div>
                                
                                <!-- Columns Container -->
                                <div id="megaMenuColumns" class="mega-columns-container">
                                    <!-- Column 1 -->
                                    <div class="mega-column-item" data-column="1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6>Column 1</h6>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-outline-primary" onclick="moveColumn('1', 'up')">↑</button>
                                                <button class="btn btn-sm btn-outline-primary" onclick="moveColumn('1', 'down')">↓</button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="removeColumn('1')">×</button>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Column Width</label>
                                            <select class="form-control" id="col1Width">
                                                <option value="1">1/12</option>
                                                <option value="2">2/12</option>
                                                <option value="3" selected>3/12</option>
                                                <option value="4">4/12</option>
                                                <option value="6">6/12</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-label">Content Type</label>
                                            <select class="form-control" id="col1Type" onchange="changeColumnType('1', this.value)">
                                                <option value="menu">Menu Links</option>
                                                <option value="html">HTML Content</option>
                                                <option value="image">Image</option>
                                                <option value="widget">Widget</option>
                                            </select>
                                        </div>
                                        <div id="col1Content" class="column-content">
                                            <div class="form-group mb-2">
                                                <label class="form-label">Menu Title</label>
                                                <input type="text" class="form-control" id="col1Title" value="Categories">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="form-label">Menu Items</label>
                                                <textarea class="form-control" id="col1Items" rows="4" placeholder="Enter menu items, one per line">Electronics
Clothing
Books
Home & Garden</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Advanced Tab -->
                            <div class="tab-pane fade" id="mega-advanced-tab">
                                <h6 class="mb-3">Advanced Settings</h6>
                                
                                <!-- Z-Index -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Z-Index</label>
                                    <input type="number" class="form-control" id="megaZIndex" value="1000">
                                </div>
                                
                                <!-- Opacity -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Opacity</label>
                                    <input type="range" class="form-control" id="megaOpacity" min="0" max="1" step="0.1" value="1">
                                    <small class="text-muted">Current: <span id="opacityValue">1</span></small>
                                </div>
                                
                                <!-- Custom CSS -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Custom CSS</label>
                                    <textarea class="form-control" id="customCSS" rows="4" placeholder="Enter custom CSS here..."></textarea>
                                </div>
                                
                                <!-- Responsive Settings -->
                                <h6 class="mb-3">Responsive Settings</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Mobile Breakpoint</label>
                                    <select class="form-control" id="mobileBreakpoint">
                                        <option value="768">768px</option>
                                        <option value="992">992px</option>
                                        <option value="1200">1200px</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Mobile Behavior</label>
                                    <select class="form-control" id="mobileBehavior">
                                        <option value="collapse">Collapse to Accordion</option>
                                        <option value="hide">Hide Completely</option>
                                        <option value="stack">Stack Vertically</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Preview Section -->
                <div class="mt-4">
                    <h6 class="mb-3">Live Preview</h6>
                    <div id="megaMenuPreview" class="mega-menu-preview">
                        <div class="preview-content">
                            <p class="text-muted">Preview will appear here...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveMegaMenuSettings()">Save Settings</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal" tabindex="-1" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkImportModalLabel">
                    <i class="ri-upload-line me-2"></i> Bulk Import Menu Items
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="importTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="excel-tab" data-bs-toggle="tab" data-bs-target="#excel-pane" type="button" role="tab">
                            <i class="ri-file-excel-line me-1"></i> Excel File
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="text-tab" data-bs-toggle="tab" data-bs-target="#text-pane" type="button" role="tab">
                            <i class="ri-file-text-line me-1"></i> Text/JSON
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content" id="importTabContent">
                    <!-- Excel Tab -->
                    <div class="tab-pane fade show active" id="excel-pane" role="tabpanel">
                        <div class="alert alert-info">
                            <strong>Excel Format:</strong>
                            <ul class="mb-0 mt-2">
                                <li>First row should contain headers: <code>Title</code>, <code>URL</code>, <code>Parent Title</code> (optional), <code>Icon</code> (optional), <code>Sort Order</code> (optional)</li>
                                <li>Supported formats: .xlsx, .xls, .csv</li>
                                <li>Example: Title in column A, URL in column B, Parent Title in column C</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="excelFileInput" class="form-label">Upload Excel File</label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="excelFileInput" 
                                accept=".xlsx,.xls,.csv"
                                onchange="handleExcelFile(event)">
                            <small class="form-text text-muted">Select Excel file (.xlsx, .xls) or CSV file</small>
                        </div>
                        
                        <div id="excelPreview" class="mt-3" style="display: none;">
                            <h6>Preview:</h6>
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-bordered">
                                    <thead id="excelPreviewHead"></thead>
                                    <tbody id="excelPreviewBody"></tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="importFromExcel()">
                                    <i class="ri-upload-line me-1"></i> Import from Excel
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Text/JSON Tab -->
                    <div class="tab-pane fade" id="text-pane" role="tabpanel">
                        <div class="alert alert-info">
                            <strong>Format Options:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>JSON Format:</strong> Array of menu items with properties (title, url, parent_title, etc.)</li>
                                <li><strong>Simple Format:</strong> One item per line: <code>Title|URL|Parent Title (optional)</code></li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bulkImportTextarea" class="form-label">Menu Items List</label>
                            <textarea 
                                class="form-control" 
                                id="bulkImportTextarea" 
                                rows="15" 
                                placeholder='JSON Format Example:&#10;[&#10;  {"title": "Home", "url": "/", "menu_item_type": "url"},&#10;  {"title": "About", "url": "/about", "menu_item_type": "url"},&#10;  {"title": "Services", "url": "/services", "parent_title": "About", "menu_item_type": "url"}&#10;]&#10;&#10;Simple Format Example:&#10;Home|/&#10;About|/about&#10;Services|/services|About'></textarea>
                        </div>
                        
                        <div class="alert alert-warning">
                            <strong>Note:</strong> Parent items must be listed before their children in simple format.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="importTextBtn" onclick="bulkImportMenus()" style="display: none;">
                    <i class="ri-upload-line me-1"></i> Import Menu Items
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load SheetJS library for Excel parsing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Store parsed Excel data
    let excelData = [];
    
    // Handle Excel file upload
    window.handleExcelFile = function(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                
                // Get first sheet
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                // Convert to JSON
                const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                
                if (jsonData.length === 0) {
                    showNotification('Excel file is empty!', 'error');
                    return;
                }
                
                // Process Excel data
                excelData = processExcelData(jsonData);
                
                // Show preview
                showExcelPreview(excelData);
                
            } catch (error) {
                console.error('Error reading Excel file:', error);
                showNotification('Error reading Excel file: ' + error.message, 'error');
            }
        };
        
        reader.readAsArrayBuffer(file);
    };
    
    // Process Excel data to menu items format
    function processExcelData(jsonData) {
        if (jsonData.length === 0) return [];
        
        // First row is headers
        const headers = jsonData[0].map(h => (h || '').toString().toLowerCase().trim());
        
        // Find column indices
        const titleIndex = headers.findIndex(h => h.includes('title') || h.includes('name'));
        const urlIndex = headers.findIndex(h => h.includes('url') || h.includes('link'));
        const parentIndex = headers.findIndex(h => h.includes('parent'));
        const iconIndex = headers.findIndex(h => h.includes('icon'));
        const sortIndex = headers.findIndex(h => h.includes('sort') || h.includes('order'));
        
        // If no headers found, assume first row is data
        let dataStartRow = 1;
        if (titleIndex === -1 && urlIndex === -1) {
            // No headers, assume first row is data
            dataStartRow = 0;
        }
        
        const menuItems = [];
        
        for (let i = dataStartRow; i < jsonData.length; i++) {
            const row = jsonData[i];
            if (!row || row.length === 0) continue;
            
            const item = {
                title: (row[titleIndex] || row[0] || '').toString().trim(),
                url: (row[urlIndex] || row[1] || '#').toString().trim(),
                parent_title: parentIndex >= 0 ? (row[parentIndex] || '').toString().trim() : null,
                icon: iconIndex >= 0 ? (row[iconIndex] || '').toString().trim() : null,
                sort_order: sortIndex >= 0 ? parseInt(row[sortIndex]) || i - dataStartRow : i - dataStartRow,
                menu_item_type: 'url',
                is_active: true,
                is_visible: true
            };
            
            if (item.title) {
                menuItems.push(item);
            }
        }
        
        return menuItems;
    }
    
    // Show Excel preview
    function showExcelPreview(data) {
        if (data.length === 0) {
            document.getElementById('excelPreview').style.display = 'none';
            return;
        }
        
        const previewHead = document.getElementById('excelPreviewHead');
        const previewBody = document.getElementById('excelPreviewBody');
        
        // Create header
        previewHead.innerHTML = '<tr><th>Title</th><th>URL</th><th>Parent Title</th><th>Icon</th><th>Sort Order</th></tr>';
        
        // Create body
        previewBody.innerHTML = '';
        data.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.title || ''}</td>
                <td>${item.url || '#'}</td>
                <td>${item.parent_title || '-'}</td>
                <td>${item.icon || '-'}</td>
                <td>${item.sort_order || index}</td>
            `;
            previewBody.appendChild(row);
        });
        
        document.getElementById('excelPreview').style.display = 'block';
    }
    
    // Import from Excel
    window.importFromExcel = function() {
        if (excelData.length === 0) {
            showNotification('No data to import!', 'error');
            return;
        }
        
        const menuType = currentMenuType;
        
        // Process menu items
        const rootItems = [];
        const childItems = [];
        
        excelData.forEach((item) => {
            if (!item.parent_title || item.parent_title === '') {
                rootItems.push({
                    menu_type: menuType,
                    title: item.title,
                    alias: item.title.toLowerCase().replace(/\s+/g, '-'),
                    menu_item_type: item.menu_item_type || 'url',
                    url: item.url || '#',
                    icon: item.icon || null,
                    parent_id: null,
                    sort_order: item.sort_order || 0,
                    is_active: item.is_active !== undefined ? item.is_active : true,
                    is_visible: item.is_visible !== undefined ? item.is_visible : true,
                    target_window: item.target_window || '_self',
                    access_level: item.access_level || 'public'
                });
            } else {
                childItems.push(item);
            }
        });
        
        // Import menu items
        importMenuItemsBulk(rootItems, childItems, menuType);
    };
    
    // Update import button visibility based on active tab
    document.addEventListener('DOMContentLoaded', function() {
        const excelTab = document.getElementById('excel-tab');
        const textTab = document.getElementById('text-tab');
        const importTextBtn = document.getElementById('importTextBtn');
        
        if (excelTab && textTab && importTextBtn) {
            excelTab.addEventListener('shown.bs.tab', function() {
                importTextBtn.style.display = 'none';
            });
            
            textTab.addEventListener('shown.bs.tab', function() {
                importTextBtn.style.display = 'inline-block';
            });
        }
    });
    
    // Bulk Import Functions
    window.bulkImportMenus = function() {
        const importText = document.getElementById('bulkImportTextarea').value.trim();
        
        if (!importText) {
            showNotification('Please enter menu items list!', 'error');
            return;
        }
        
        let menuItems = [];
        
        try {
            // Try to parse as JSON
            menuItems = JSON.parse(importText);
            
            // If it's not an array, wrap it
            if (!Array.isArray(menuItems)) {
                menuItems = [menuItems];
            }
        } catch (e) {
            // If JSON parsing fails, try to parse as simple text format
            // Format: Title|URL|Parent Title (optional)
            const lines = importText.split('\n').filter(line => line.trim());
            menuItems = lines.map((line, index) => {
                const parts = line.split('|').map(p => p.trim());
                return {
                    title: parts[0] || `Menu Item ${index + 1}`,
                    url: parts[1] || '#',
                    parent_title: parts[2] || null,
                    menu_item_type: 'url',
                    sort_order: index,
                    is_active: true,
                    is_visible: true
                };
            });
        }
        
        if (menuItems.length === 0) {
            showNotification('No menu items found in the list!', 'error');
            return;
        }
        
        console.log('Importing menu items:', menuItems);
        
        // Get current menu type
        const menuType = currentMenuType;
        
        // Process menu items and create parent-child mapping
        const processedItems = [];
        const titleToIdMap = {}; // Map to track created items by title
        
        // First pass: Create all root items
        menuItems.forEach((item, index) => {
            if (!item.parent_title || item.parent_title === '') {
                processedItems.push({
                    menu_type: menuType,
                    title: item.title || `Menu Item ${index + 1}`,
                    alias: item.alias || item.title?.toLowerCase().replace(/\s+/g, '-') || `menu-item-${index + 1}`,
                    menu_item_type: item.menu_item_type || 'url',
                    url: item.url || item.link || '#',
                    icon: item.icon || null,
                    parent_id: null,
                    sort_order: item.sort_order !== undefined ? item.sort_order : index,
                    is_active: item.is_active !== undefined ? item.is_active : true,
                    is_visible: item.is_visible !== undefined ? item.is_visible : true,
                    target_window: item.target_window || '_self',
                    access_level: item.access_level || 'public',
                    styling: item.styling || null,
                    advanced: item.advanced || null
                });
            }
        });
        
        // Second pass: Create child items (will be handled after parent items are created)
        const childItems = menuItems.filter(item => item.parent_title && item.parent_title !== '');
        
        // Import menu items via API
        importMenuItemsBulk(processedItems, childItems, menuType);
    };
    
    // Function to import menu items in bulk
    async function importMenuItemsBulk(rootItems, childItems, menuType) {
        showNotification('Importing menu items...', 'info');
        
        try {
            // First, create all root items
            let createdItems = [];
            let parentTitleMap = {}; // Map parent titles to IDs
            
            for (let i = 0; i < rootItems.length; i++) {
                const item = rootItems[i];
                try {
                    const response = await fetch(getApiBaseUrl() + '/item', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(item)
                    });
                    
                    const data = await response.json();
                    if (data.success && data.menu_item) {
                        createdItems.push(data.menu_item);
                        parentTitleMap[item.title] = data.menu_item.id;
                        console.log(`Created root item: ${item.title} (ID: ${data.menu_item.id})`);
                    }
                } catch (error) {
                    console.error(`Error creating item ${item.title}:`, error);
                }
            }
            
            // Now create child items
            for (let i = 0; i < childItems.length; i++) {
                const item = childItems[i];
                const parentId = parentTitleMap[item.parent_title];
                
                if (!parentId) {
                    console.warn(`Parent "${item.parent_title}" not found for item "${item.title}"`);
                    continue;
                }
                
                const childItem = {
                    menu_type: menuType,
                    title: item.title || `Child Item ${i + 1}`,
                    alias: item.alias || item.title?.toLowerCase().replace(/\s+/g, '-') || `child-item-${i + 1}`,
                    menu_item_type: item.menu_item_type || 'url',
                    url: item.url || item.link || '#',
                    icon: item.icon || null,
                    parent_id: parentId,
                    sort_order: item.sort_order !== undefined ? item.sort_order : i,
                    is_active: item.is_active !== undefined ? item.is_active : true,
                    is_visible: item.is_visible !== undefined ? item.is_visible : true,
                    target_window: item.target_window || '_self',
                    access_level: item.access_level || 'public',
                    styling: item.styling || null,
                    advanced: item.advanced || null
                };
                
                try {
                    const response = await fetch(getApiBaseUrl() + '/item', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(childItem)
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        console.log(`Created child item: ${item.title} under parent ${item.parent_title}`);
                    }
                } catch (error) {
                    console.error(`Error creating child item ${item.title}:`, error);
                }
            }
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('bulkImportModal'));
            if (modal) {
                modal.hide();
            }
            
            // Clear textarea
            document.getElementById('bulkImportTextarea').value = '';
            
            // Reload page to show new items
            showNotification(`Successfully imported ${createdItems.length} menu items!`, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
            
        } catch (error) {
            console.error('Error importing menu items:', error);
            showNotification('Error importing menu items: ' + error.message, 'error');
        }
    }
</script>

@endsection