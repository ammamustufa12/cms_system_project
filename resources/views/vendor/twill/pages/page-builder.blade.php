<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #1a1a1a;
            color: #ffffff;
            overflow: hidden;
            height: 100vh;
        }

        .page-builder {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #1a1a1a;
        }
        
        /* Header Styles - Exact match to image */
        .builder-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            height: 60px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-center {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-header {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            color: white;
        }

        .btn-save {
            background: #28a745;
        }

        .btn-save:hover {
            background: #218838;
        }

        .btn-export {
            background: #17a2b8;
        }

        .btn-export:hover {
            background: #138496;
        }

        .btn-import {
            background: #6c757d;
        }

        .btn-import:hover {
            background: #5a6268;
        }

        .device-toggle {
            display: flex;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 4px;
        }

        .device-btn {
            padding: 8px 16px;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.7);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            min-width: 80px;
        }

        .device-btn.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .device-size {
            font-size: 10px;
            opacity: 0.8;
            font-weight: 400;
        }

        .btn-global {
            background: #ffc107;
            color: #212529;
        }

        .btn-global:hover {
            background: #e0a800;
        }

        .btn-navigator {
            background: #fd7e14;
        }

        .btn-navigator:hover {
            background: #e8650e;
        }

        .btn-templates {
            background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-templates:hover {
            background: linear-gradient(135deg, #5a32a3 0%, #7d3c98 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(111, 66, 193, 0.3);
        }

        .btn-undo, .btn-redo {
            background: #6c757d;
        }

        .btn-undo:hover, .btn-redo:hover {
            background: #5a6268;
        }

        .btn-preview {
            background: #20c997;
        }

        .btn-preview:hover {
            background: #1aa179;
        }
        
        /* Main Content */
        .builder-content {
            flex: 1;
            display: flex;
            overflow: hidden;
            background: #1a1a1a;
        }
        
        /* Left Sidebar - Widgets - Exact match to image */
        .builder-sidebar {
            width: 280px;
            background: #2d2d2d;
            border-right: 1px solid #404040;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 15px;
            background: #2d2d2d;
            border-bottom: 1px solid #404040;
        }

        .sidebar-tools {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        .tool-btn {
            background: transparent;
            border: none;
            color: #aaa;
            padding: 8px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .tool-btn.active {
            background: rgba(102, 126, 234, 0.2);
            color: #667eea;
        }

        .tool-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-tabs {
            display: flex;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            padding: 2px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: #aaa;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            justify-content: center;
        }

        .tab-btn.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .tab-btn:hover {
            color: #fff;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
        }

        .widget-search {
            width: 100%;
            padding: 10px 12px 10px 40px;
            background: #3a3a3a;
            border: 1px solid #404040;
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
        }

        .widget-search:focus {
            outline: none;
            border-color: #667eea;
        }

        .widget-search::placeholder {
            color: #aaa;
        }

        .search-actions {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 4px;
        }

        .search-action-btn {
            background: transparent;
            border: none;
            color: #aaa;
            padding: 4px;
            cursor: pointer;
            border-radius: 3px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            font-size: 12px;
        }

        .search-action-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }

        .widget-category {
            margin-bottom: 0;
        }

        .category-header {
            padding: 12px 20px;
            background: #333;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 1px solid #404040;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.2s;
        }

        .category-header span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-header span i {
            font-size: 16px;
            color: #667eea;
        }

        .category-header:hover {
            background: #3a3a3a;
        }

        .category-content {
            padding: 15px 20px;
            background: #2d2d2d;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .widget-item {
            background: #3a3a3a;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 15px;
            cursor: grab;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-height: 80px;
            justify-content: center;
        }
        
        .widget-item:hover {
            background: #404040;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }
        
        .widget-item:active {
            cursor: grabbing;
        }
        
        .widget-item .widget-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
        }
        
        .widget-item .widget-info {
            flex: 1;
        }
        
        .widget-item .widget-info h6 {
            margin: 0;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
            line-height: 1.2;
        }
        
        /* Canvas Area - Exact match to image */
        .builder-canvas {
            flex: 1;
            background: #f8f9fa;
            overflow-y: auto;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .canvas-header {
            padding: 15px 20px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .canvas-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .canvas-actions {
            display: flex;
            gap: 8px;
        }

        .btn-clear {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-clear:hover {
            background: #c82333;
        }
        
        .canvas-area {
            flex: 1;
            min-height: 600px;
            border: 2px dashed #dee2e6;
            margin: 20px;
            border-radius: 12px;
            padding: 20px;
            background: #fff;
            position: relative;
            transition: all 0.3s;
        }

        .canvas-area.drag-over {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .canvas-placeholder {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .canvas-placeholder i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .canvas-placeholder h4 {
            margin-bottom: 10px;
            color: #495057;
        }
        
        .canvas-placeholder p {
            margin: 0;
            font-size: 16px;
        }

        .device-info {
            margin-top: 15px;
            padding: 8px 16px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            display: inline-block;
        }

        .device-info small {
            color: #667eea;
            font-weight: 500;
        }
        
        .builder-element {
            background: #fff;
            border: 2px solid transparent;
            border-radius: 8px;
            margin: 10px 0;
            padding: 15px;
            position: relative;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .builder-element:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }
        
        .builder-element.selected {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
        }
        
        .element-actions {
            position: absolute;
            top: -10px;
            right: -10px;
            display: none;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            padding: 4px;
            z-index: 10;
        }
        
        .builder-element:hover .element-actions {
            display: block;
        }
        
        .element-actions .btn {
            padding: 4px 8px;
            font-size: 12px;
            margin: 0 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-duplicate {
            background: #6c757d;
            color: white;
        }
        
        /* Right Sidebar - Properties - Exact match to image */
        .builder-properties {
            width: 320px;
            background: #2d2d2d;
            border-left: 1px solid #404040;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .properties-header {
            padding: 15px;
            background: #333;
            border-bottom: 1px solid #404040;
            font-weight: 600;
            font-size: 16px;
            color: #fff;
        }

        .properties-content {
            flex: 1;
            padding: 20px;
        }

        .property-group {
            margin-bottom: 25px;
        }

        .property-group h6 {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #404040;
        }
        
        .range-slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #404040;
            outline: none;
            -webkit-appearance: none;
        }
        
        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
        }
        
        .range-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            border: none;
        }
        
        .color-picker {
            width: 100%;
            height: 40px;
            border: 1px solid #404040;
            border-radius: 6px;
            cursor: pointer;
            background: none;
        }
        
        .btn-group .btn {
            padding: 8px 12px;
            border: 1px solid #404040;
            background: #2d2d2d;
            color: #fff;
            transition: all 0.2s;
        }
        
        .btn-group .btn:hover {
            background: #404040;
            border-color: #667eea;
        }
        
        .btn-group .btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            color: #ccc;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #404040;
            border-radius: 6px;
            background: #3a3a3a;
            color: #fff;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #404040;
            border-radius: 6px;
            background: #3a3a3a;
            color: #fff;
            font-size: 14px;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
        }

        .color-picker {
            width: 100%;
            height: 40px;
            border: 1px solid #404040;
            border-radius: 6px;
            background: #3a3a3a;
            cursor: pointer;
        }

        .range-slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #404040;
            outline: none;
            -webkit-appearance: none;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
        }

        .range-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            border: none;
        }

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #404040;
            color: #ccc;
        }

        .btn-outline:hover {
            background: #404040;
            color: #fff;
        }

        /* Responsive Design - Exact Device Sizes */
        .canvas-area.desktop {
            max-width: 100%;
            margin: 20px;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            background: #fff;
            min-height: 600px;
        }

        .canvas-area.tablet {
            max-width: 768px;
            width: 768px;
            height: 1024px;
            margin: 20px auto;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
        }

        .canvas-area.mobile {
            max-width: 375px;
            width: 375px;
            height: 667px;
            margin: 20px auto;
            border: 2px dashed #dee2e6;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Device Frame Styling */
        .canvas-area.tablet::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 3px solid #333;
            border-radius: 15px;
            pointer-events: none;
            z-index: -1;
        }

        .canvas-area.mobile::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border: 3px solid #333;
            border-radius: 25px;
            pointer-events: none;
            z-index: -1;
        }

        /* Device Labels */
        .canvas-area.tablet::after {
            content: 'iPad (768×1024)';
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .canvas-area.mobile::after {
            content: 'iPhone (375×667)';
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Responsive Canvas Content */
        .canvas-area.desktop .canvas-placeholder {
            padding: 60px 20px;
        }

        .canvas-area.tablet .canvas-placeholder {
            padding: 40px 20px;
            font-size: 14px;
        }

        .canvas-area.mobile .canvas-placeholder {
            padding: 30px 15px;
            font-size: 12px;
        }

        .canvas-area.tablet .canvas-placeholder i {
            font-size: 3rem;
        }

        .canvas-area.mobile .canvas-placeholder i {
            font-size: 2.5rem;
        }

        /* Device-specific element sizing */
        .canvas-area.tablet .builder-element {
            margin: 8px 0;
            padding: 12px;
        }

        .canvas-area.mobile .builder-element {
            margin: 6px 0;
            padding: 10px;
        }

        .canvas-area.tablet .builder-element h2 {
            font-size: 1.5rem;
        }

        .canvas-area.mobile .builder-element h2 {
            font-size: 1.25rem;
        }

        .canvas-area.tablet .builder-element p {
            font-size: 14px;
        }

        .canvas-area.mobile .builder-element p {
            font-size: 13px;
        }

        /* Animations */
        .sortable-ghost {
            opacity: 0.4;
        }
        
        .sortable-chosen {
            transform: rotate(2deg);
        }
        
        .sortable-drag {
            transform: rotate(2deg);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #2d2d2d;
        }

        ::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h4 {
            margin-bottom: 10px;
            color: #495057;
        }

        .empty-state p {
            margin: 0;
            font-size: 16px;
        }

        /* Drop Zone Styles */
        .drop-zone {
            transition: all 0.3s ease;
            position: relative;
        }

        .drop-zone.drag-over {
            background: rgba(102, 126, 234, 0.1) !important;
            border-color: #667eea !important;
            transform: scale(1.02);
        }

        .drop-zone:hover {
            background: rgba(102, 126, 234, 0.05) !important;
            border-color: #999 !important;
        }

        /* Nested Element Styles */
        .nested-element {
            margin: 5px 0;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            background: #fff;
        }

        .nested-element:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .nested-element.selected {
            border-color: #28a745;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
        }

        /* Container Widget Styles */
        .container, .grid-container, .section, .column {
            position: relative;
        }

        .container:hover, .grid-container:hover, .section:hover, .column:hover {
            border-color: #667eea !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        /* Grid Item Styles */
        .grid-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .grid-item:hover {
            border-color: #667eea !important;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        /* Editable Text Styles */
        .editable-text {
            transition: all 0.3s ease;
        }

        .editable-text:hover {
            border-color: #667eea !important;
            background: rgba(102, 126, 234, 0.05);
        }

        .editable-text:focus {
            outline: none;
            border-color: #667eea !important;
            background: rgba(102, 126, 234, 0.1);
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        /* Image Upload Styles */
        .image-placeholder:hover, .video-placeholder:hover {
            border-color: #667eea !important;
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.02);
        }

        .image-widget, .video-widget {
            position: relative;
        }

        .uploaded-image, .uploaded-video {
            transition: all 0.3s ease;
        }

        .uploaded-image:hover, .uploaded-video:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Upload Button Styles */
        .upload-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .image-widget:hover .upload-btn, .video-widget:hover .upload-btn {
            opacity: 1;
        }

        .media-library-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
        }

        .image-widget:hover .media-library-btn {
            opacity: 1;
        }

        /* Media Library Modal Styles */
        .media-item:hover {
            transform: scale(1.02) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .media-item.selected {
            border-color: #007bff !important;
            transform: scale(1.05) !important;
            box-shadow: 0 4px 12px rgba(0,123,255,0.3);
        }

        .selection-indicator {
            transition: all 0.3s ease;
        }

        /* Drag and drop visual feedback */
        .image-placeholder.dragover {
            border-color: #007bff !important;
            background-color: #f8f9ff !important;
            transform: scale(1.02);
        }

        /* Template editing styles */
        [contenteditable="true"]:focus {
            outline: none;
            border-color: #007bff !important;
            background-color: #f8f9ff !important;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        [contenteditable="true"]:hover {
            border-color: #007bff !important;
            background-color: #f8f9ff !important;
        }

        /* Template elements */
        .template-element {
            position: relative;
            transition: all 0.3s ease;
        }

        .template-element:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .template-element:hover::after {
            content: "Click to edit";
            position: absolute;
            top: -25px;
            left: 0;
            background: #007bff;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 1000;
        }

        /* Plus Options Container */
        .plus-options-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Layout Selector Styles */
        .layout-selector-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Widget Selector Styles */
        .widget-selector-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .layout-plus-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            margin-bottom: 20px;
        }

        .layout-plus-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .layout-plus-icon i {
            font-size: 24px;
            color: white;
            transition: transform 0.3s ease;
        }

        .layout-plus-icon:hover i {
            transform: rotate(90deg);
        }

        /* Widget Plus Icon Styles */
        .widget-plus-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .widget-plus-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .widget-plus-icon i {
            font-size: 24px;
            color: white;
            transition: transform 0.3s ease;
        }

        .widget-plus-icon:hover i {
            transform: rotate(90deg);
        }

        .layout-options {
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 15px;
            z-index: 1000;
            min-width: 300px;
            animation: slideDown 0.3s ease;
            max-height: 400px;
            overflow-y: auto;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .layout-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .layout-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .layout-option:hover {
            border-color: #667eea;
            background: #f0f4ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .layout-preview {
            width: 60px;
            height: 40px;
            display: flex;
            gap: 1px;
            margin-bottom: 6px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 3px;
            background: white;
        }

        .preview-column {
            flex: 1;
            background: #667eea;
            border-radius: 2px;
            opacity: 0.7;
        }

        .preview-column.small {
            flex: 0.3;
        }

        .preview-column.large {
            flex: 0.7;
        }

        .preview-column.sidebar {
            flex: 0.3;
        }

        .preview-column.main {
            flex: 0.7;
        }

        .preview-row {
            width: 100%;
            height: 12px;
            background: #667eea;
            border-radius: 2px;
            margin-bottom: 2px;
            opacity: 0.7;
        }

        .preview-row.header {
            background: #28a745;
        }

        .preview-row.content {
            background: #667eea;
        }

        .preview-row.footer {
            background: #6c757d;
        }

        .layout-option span {
            font-size: 10px;
            font-weight: 500;
            color: #495057;
            text-align: center;
        }

        /* Widget Options Styles */
        .widget-options {
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 15px;
            z-index: 1000;
            min-width: 300px;
            animation: slideDown 0.3s ease;
            max-height: 400px;
            overflow-y: auto;
        }

        .widget-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .widget-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .widget-option:hover {
            border-color: #28a745;
            background: #f0fff4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
        }

        .widget-preview {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #28a745;
            border-radius: 8px;
            margin-bottom: 6px;
            color: white;
            font-size: 18px;
        }

        .widget-option span {
            font-size: 10px;
            font-weight: 500;
            color: #495057;
            text-align: center;
        }

        /* Layout Templates */
        .layout-template {
            display: none;
        }

        .layout-template.active {
            display: block;
        }

        .single-column-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .two-columns-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .three-columns-layout {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .two-columns-unequal-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }

        .header-content-footer-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-content-layout {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 20px;
        }

        .layout-section {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .layout-section:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .layout-section.drag-over {
            border-color: #667eea;
            background: #f0f4ff;
            transform: scale(1.02);
        }

        /* Mobile Responsive Layout Options */
        @media (max-width: 768px) {
            .layout-options {
                min-width: 280px;
                padding: 10px;
            }
            
            .layout-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .layout-option {
                padding: 8px;
            }
            
        .layout-preview {
            width: 50px;
            height: 35px;
        }
    }

    /* Notification System */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    }

    .notification.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification.error {
        background: #dc3545;
    }

    .notification.warning {
        background: #ffc107;
        color: #212529;
    }

    /* Layout Design Modal Styles */
    .layout-design-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        border: 2px dashed #e9ecef;
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .modal-actions {
        display: flex;
        gap: 8px;
    }

    .modal-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: #6c757d;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .modal-btn:hover {
        background: #5a6268;
    }

    .modal-body {
        padding: 24px;
    }

    .structure-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
    }

    .structure-option {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .structure-option:hover {
        transform: translateY(-2px);
    }

    .structure-option.active {
        transform: scale(1.05);
    }

    .structure-option.active::after {
        content: '';
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        background: #6f42c1;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(111, 66, 193, 0.3);
    }

    .structure-preview {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .structure-option:hover .structure-preview {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .structure-option.active .structure-preview {
        border-color: #6f42c1;
        background: #f8f0ff;
    }

    /* Preview Layout Styles */
    .preview-single-column {
        width: 100%;
        height: 40px;
        background: #dee2e6;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }

    .preview-two-equal {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-two-equal .preview-col {
        flex: 1;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-two-unequal {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-two-unequal .preview-col-small {
        flex: 0.3;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-two-unequal .preview-col-large {
        flex: 0.7;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-three-equal {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-three-equal .preview-col {
        flex: 1;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-three-unequal {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-three-unequal .preview-col-small {
        flex: 0.25;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-three-unequal .preview-col-large {
        flex: 0.5;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-four-squares {
        width: 100%;
        height: 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 2px;
    }

    .preview-square {
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-top-single-bottom-two {
        width: 100%;
        height: 40px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .preview-row-full {
        flex: 1;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-row-two {
        flex: 1;
        display: flex;
        gap: 2px;
    }

    .preview-row-two .preview-col {
        flex: 1;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-left-tall-right-two {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-col-tall {
        flex: 0.4;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-col-two {
        flex: 0.6;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .preview-col-two .preview-row {
        flex: 1;
        background: #dee2e6;
        border-radius: 4px;
    }

    .preview-left-tall-middle-two-right-tall {
        width: 100%;
        height: 40px;
        display: flex;
        gap: 2px;
    }

    .preview-top-two-bottom-single {
        width: 100%;
        height: 40px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

        .preview-top-single-middle-two-bottom-single {
            width: 100%;
            height: 40px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* Simple Plus Icons Styles */
        .simple-plus-icons {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .simple-plus-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .simple-plus-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .simple-plus-icon i {
            font-size: 20px;
            color: white;
            transition: transform 0.3s ease;
        }

        .simple-plus-icon:hover i {
            transform: rotate(90deg);
        }

        .simple-plus-icon.green {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .simple-plus-icon.black {
            background: linear-gradient(135deg, #333 0%, #000 100%);
        }

        .simple-plus-icon.purple {
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
        }

        .simple-plus-icon.blue {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .drag-text {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
            text-align: center;
        }

        /* Layout Templates Styles */
        .layout-template {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 20px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            margin: 10px 0;
        }

        .layout-template.single-column-layout {
            flex-direction: column;
        }

        .layout-template.two-columns-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .layout-template.three-columns-layout {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .layout-template.four-columns-layout {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 10px;
        }

        .layout-template.two-unequal-layout {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 10px;
        }

        .layout-template.header-content-footer-layout {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .layout-template.sidebar-content-layout {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 10px;
        }

        .layout-template.grid-2x2-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 10px;
        }

        .layout-section {
            min-height: 100px;
            background: white;
            border: 2px dashed #007bff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            padding: 20px;
        }

        .layout-section:hover {
            border-color: #0056b3;
            background: #f8f9ff;
        }

        .layout-section.drag-over {
            border-color: #28a745;
            background: #f8fff8;
        }

        /* Layout Controls */
        .layout-controls {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #007bff;
            border-radius: 20px;
            padding: 5px 10px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .layout-section:hover .layout-controls {
            opacity: 1;
        }

        .control-btn {
            background: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            color: #007bff;
            transition: all 0.3s ease;
        }

        .control-btn:hover {
            background: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .control-btn:active {
            transform: scale(0.95);
        }

        /* Width Controls */
        .width-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 123, 255, 0.9);
            border-radius: 6px;
            padding: 8px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .layout-section:hover .width-controls {
            opacity: 1;
        }

        .width-btn {
            background: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 10px;
            cursor: pointer;
            color: #007bff;
            transition: all 0.3s ease;
        }

        .width-btn:hover {
            background: #007bff;
            color: white;
        }

        .width-btn.active {
            background: #28a745;
            color: white;
        }

        /* Padding Controls */
        .padding-controls {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(40, 167, 69, 0.9);
            border-radius: 6px;
            padding: 8px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .layout-section:hover .padding-controls {
            opacity: 1;
        }

        .padding-btn {
            background: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 10px;
            cursor: pointer;
            color: #28a745;
            transition: all 0.3s ease;
        }

        .padding-btn:hover {
            background: #28a745;
            color: white;
        }

        .padding-btn.active {
            background: #dc3545;
            color: white;
        }

        /* Layout Size Classes */
        .layout-small {
            padding: 10px !important;
            min-height: 60px !important;
        }

        .layout-medium {
            padding: 20px !important;
            min-height: 100px !important;
        }

        .layout-large {
            padding: 40px !important;
            min-height: 150px !important;
        }

        .layout-extra-large {
            padding: 60px !important;
            min-height: 200px !important;
        }

        /* Width Classes */
        .width-25 { width: 25% !important; }
        .width-33 { width: 33.333% !important; }
        .width-50 { width: 50% !important; }
        .width-66 { width: 66.666% !important; }
        .width-75 { width: 75% !important; }
        .width-100 { width: 100% !important; }

        .layout-section:hover {
            border-color: #0056b3;
            background: #f8f9ff;
        }

        .layout-section.drag-over {
            border-color: #28a745;
            background: #f8fff8;
        }

        .drop-placeholder {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>

<body>
<div class="page-builder">
    <!-- Builder Header -->
    
    <div class="builder-header">
        <div class="header-left">
            <button class="btn-header btn-save" id="saveBtn">
                <i class="ri-save-line"></i>Save
            </button>
            <button class="btn-header btn-export" id="exportBtn">
                <i class="ri-download-line"></i>Export HTML
            </button>
            <button class="btn-header btn-export" id="exportJsonBtn">
                <i class="ri-code-line"></i>Export JSON
            </button>
            <button class="btn-header btn-import" id="importBtn">
                <i class="ri-upload-line"></i>Import
            </button>
            <button class="btn-header btn-import" id="loadBtn">
                <i class="ri-folder-open-line"></i>Load
            </button>
        </div>
        
        <div class="header-center">
            <div class="device-toggle">
                <button class="device-btn active" data-device="desktop">
                    <i class="ri-computer-line"></i> Desktop
                    <span class="device-size">1920×1080</span>
                </button>
                <button class="device-btn" data-device="tablet">
                    <i class="ri-tablet-line"></i> Tablet
                    <span class="device-size">768×1024</span>
                </button>
                <button class="device-btn" data-device="mobile">
                    <i class="ri-smartphone-line"></i> Mobile
                    <span class="device-size">375×667</span>
                </button>
            </div>
        </div>
        
        <div class="header-right">
            <button class="btn-header btn-global" id="globalBtn">
                <i class="ri-global-line"></i>Global
            </button>
            <button class="btn-header btn-navigator" id="navigatorBtn">
                <i class="ri-navigation-line"></i>Navigator
            </button>
            <button class="btn-header btn-templates" id="templatesBtn">
                <i class="ri-layout-line"></i>Templates
            </button>
            <button class="btn-header btn-undo" id="undoBtn">
                <i class="ri-arrow-left-line"></i>Undo
            </button>
            <button class="btn-header btn-redo" id="redoBtn">
                <i class="ri-arrow-right-line"></i>Redo
            </button>
            <button class="btn-header btn-preview" id="previewBtn">
                <i class="ri-eye-line"></i>Preview
            </button>
        </div>
    </div>

    <!-- Builder Content -->
    <div class="builder-content">
        <!-- Left Sidebar - Widgets -->
        <div class="builder-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-tools">
                    <button class="tool-btn" title="Structure">
                        <i class="ri-layout-3-line"></i>
                    </button>
                    <button class="tool-btn active" title="Elements">
                        <i class="ri-crosshair-line"></i>
                    </button>
                    <button class="tool-btn" title="Settings">
                        <i class="ri-settings-3-line"></i>
                    </button>
                </div>
                
                <div class="sidebar-tabs">
                    <button class="tab-btn active" data-tab="components">
                        <i class="ri-layout-3-line"></i> Components
                    </button>
                    <button class="tab-btn" data-tab="blocks">
                        <i class="ri-file-text-line"></i> Blocks
                    </button>
                </div>
                
                <div class="search-container">
                    <i class="ri-search-line"></i>
                    <input type="text" placeholder="Search components" class="widget-search" id="widgetSearch">
                    <div class="search-actions">
                        <button class="search-action-btn" title="Minimize">
                            <i class="ri-subtract-line"></i>
                        </button>
                        <button class="search-action-btn" title="Add">
                            <i class="ri-add-line"></i>
                        </button>
                        <button class="search-action-btn" title="Close">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-content" id="componentsContent">
            <!-- Base Components -->
            <div class="widget-category">
                <div class="category-header" data-category="base">
                        <span><i class="ri-layout-line"></i> Base</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <div class="category-content" id="base-widgets">
                        <div class="widget-item" draggable="true" data-widget="heading">
                            <div class="widget-icon">
                                <i class="ri-h-1"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Heading</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="image">
                            <div class="widget-icon">
                                <i class="ri-image-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Image</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="background">
                            <div class="widget-icon">
                                <i class="ri-palette-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Background</h6>
                            </div>
                        </div>
                    <div class="widget-item" draggable="true" data-widget="divider">
                            <div class="widget-icon">
                        <i class="ri-separator"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Horizontal Rule</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="form">
                            <div class="widget-icon">
                                <i class="ri-file-list-line"></i>
                        </div>
                        <div class="widget-info">
                                <h6>Form</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="input">
                            <div class="widget-icon">
                        <i class="ri-input-method-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Input</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="textarea">
                            <div class="widget-icon">
                        <i class="ri-text-wrap"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Text Area</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="select">
                            <div class="widget-icon">
                        <i class="ri-arrow-down-s-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Select Input</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="checkbox">
                            <div class="widget-icon">
                        <i class="ri-checkbox-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Checkbox</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="radio">
                            <div class="widget-icon">
                        <i class="ri-radio-button-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Radio Button</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="link">
                            <div class="widget-icon">
                        <i class="ri-links-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Link</h6>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Basic Widgets -->
            <div class="widget-category">
                    <div class="category-header" data-category="basic">
                        <span><i class="ri-file-text-line"></i> Basic</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                    <div class="category-content" id="basic-widgets">
                        <div class="widget-item" draggable="true" data-widget="heading">
                            <div class="widget-icon">
                                <i class="ri-h-1"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Heading</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="paragraph">
                            <div class="widget-icon">
                                <i class="ri-text"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Text Editor</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="image">
                            <div class="widget-icon">
                                <i class="ri-image-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Image</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="video">
                            <div class="widget-icon">
                                <i class="ri-video-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Video</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="button">
                            <div class="widget-icon">
                                <i class="ri-button-circle-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Button</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="icon">
                            <div class="widget-icon">
                                <i class="ri-star-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Icon</h6>
                            </div>
                        </div>
                </div>
            </div>

                <!-- Media Widgets -->
            <div class="widget-category">
                    <div class="category-header" data-category="media">
                        <span><i class="ri-image-2-line"></i> Media</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                    <div class="category-content" id="media-widgets">
                        <div class="widget-item" draggable="true" data-widget="gallery">
                            <div class="widget-icon">
                                <i class="ri-gallery-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Gallery</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="carousel">
                            <div class="widget-icon">
                                <i class="ri-slideshow-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Carousel</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="audio">
                            <div class="widget-icon">
                                <i class="ri-music-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Audio</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="map">
                            <div class="widget-icon">
                                <i class="ri-map-pin-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Map</h6>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Forms Widgets -->
            <div class="widget-category">
                    <div class="category-header" data-category="forms">
                        <span><i class="ri-form-line"></i> Forms</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                    <div class="category-content" id="forms-widgets">
                        <div class="widget-item" draggable="true" data-widget="form">
                            <div class="widget-icon">
                                <i class="ri-file-list-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Form</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="input">
                            <div class="widget-icon">
                                <i class="ri-input-method-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Input</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="textarea">
                            <div class="widget-icon">
                                <i class="ri-text-wrap"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Textarea</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="select">
                            <div class="widget-icon">
                        <i class="ri-arrow-down-s-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Select</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="checkbox">
                            <div class="widget-icon">
                                <i class="ri-checkbox-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Checkbox</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="radio">
                            <div class="widget-icon">
                                <i class="ri-radio-button-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Radio</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Widgets -->
                <div class="widget-category">
                    <div class="category-header" data-category="advanced">
                        <span><i class="ri-settings-3-line"></i> Advanced</span>
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                    <div class="category-content" id="advanced-widgets">
                    <div class="widget-item" draggable="true" data-widget="tabs">
                            <div class="widget-icon">
                        <i class="ri-layout-2-line"></i>
                            </div>
                        <div class="widget-info">
                            <h6>Tabs</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="accordion">
                            <div class="widget-icon">
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Accordion</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="modal">
                            <div class="widget-icon">
                                <i class="ri-window-line"></i>
                            </div>
                        <div class="widget-info">
                                <h6>Modal</h6>
                        </div>
                    </div>
                        <div class="widget-item" draggable="true" data-widget="counter">
                            <div class="widget-icon">
                                <i class="ri-number-1"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Counter</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="progress">
                            <div class="widget-icon">
                                <i class="ri-bar-chart-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Progress</h6>
                            </div>
                        </div>
                        <div class="widget-item" draggable="true" data-widget="testimonial">
                            <div class="widget-icon">
                                <i class="ri-chat-quote-line"></i>
                            </div>
                            <div class="widget-info">
                                <h6>Testimonial</h6>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Layout Section -->
            <div class="widget-category">
                <div class="category-header" data-category="layouts">
                    <span><i class="ri-layout-line"></i> Layouts</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <div class="category-content" id="layout-widgets">
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="single-column">
                        <div class="widget-icon">
                            <i class="ri-layout-line" style="color: #28a745;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Single Column</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="two-columns">
                        <div class="widget-icon">
                            <i class="ri-layout-2-line" style="color: #007bff;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Two Columns</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="three-columns">
                        <div class="widget-icon">
                            <i class="ri-layout-3-line" style="color: #6f42c1;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Three Columns</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="four-columns">
                        <div class="widget-icon">
                            <i class="ri-layout-4-line" style="color: #fd7e14;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Four Columns</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="two-unequal">
                        <div class="widget-icon">
                            <i class="ri-layout-left-line" style="color: #20c997;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Two Unequal</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="header-content-footer">
                        <div class="widget-icon">
                            <i class="ri-layout-top-line" style="color: #dc3545;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Header/Content/Footer</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="sidebar-content">
                        <div class="widget-icon">
                            <i class="ri-layout-sidebar-line" style="color: #6c757d;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>Sidebar + Content</h6>
                        </div>
                    </div>
                    <div class="widget-item" draggable="true" data-widget="layout" data-layout="grid-2x2">
                        <div class="widget-icon">
                            <i class="ri-grid-line" style="color: #e83e8c;"></i>
                        </div>
                        <div class="widget-info">
                            <h6>2x2 Grid</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Content Types -->
            <div class="widget-category">
                <div class="category-header" data-category="content-types">
                        <span><i class="ri-file-text-line"></i> Your Content Types</span>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <div class="category-content" id="content-types-widgets">
                        @if(isset($contentTypes) && count($contentTypes) > 0)
                    @foreach($contentTypes as $contentType)
                        <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="{{ $contentType['slug'] }}">
                                    <div class="widget-icon">
                            <i class="{{ $contentType['icon'] ?? 'ri-file-text-line' }}" style="color: {{ $contentType['color'] ?? '#667eea' }};"></i>
                                    </div>
                            <div class="widget-info">
                                <h6>{{ $contentType['name'] ?? 'Content Type' }}</h6>
                            </div>
                        </div>
                    @endforeach
                        @else
                            <!-- Sample Content Types for Demo -->
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="blog-post">
                                <div class="widget-icon">
                                    <i class="ri-article-line" style="color: #28a745;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Blog Post</h6>
                                </div>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="product">
                                <div class="widget-icon">
                                    <i class="ri-shopping-bag-line" style="color: #dc3545;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Product</h6>
                                </div>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="team-member">
                                <div class="widget-icon">
                                    <i class="ri-user-line" style="color: #17a2b8;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Team Member</h6>
                                </div>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="testimonial">
                                <div class="widget-icon">
                                    <i class="ri-chat-quote-line" style="color: #ffc107;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Testimonial</h6>
                                </div>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="portfolio">
                                <div class="widget-icon">
                                    <i class="ri-briefcase-line" style="color: #6f42c1;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Portfolio</h6>
                                </div>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="content-type" data-content-type="event">
                                <div class="widget-icon">
                                    <i class="ri-calendar-line" style="color: #fd7e14;"></i>
                                </div>
                                <div class="widget-info">
                                    <h6>Event</h6>
                </div>
            </div>
            @endif
                    </div>
                </div>
            </div>

            <div class="sidebar-content" id="blocksContent" style="display: none;">
                <div class="empty-state">
                    <i class="ri-file-text-line"></i>
                    <h4>Blocks</h4>
                    <p>Pre-built blocks will appear here</p>
                </div>
            </div>
        </div>

        <!-- Center Canvas -->
        <div class="builder-canvas">
            <div class="canvas-header">
                <div class="canvas-title">CANVAS</div>
                <div class="canvas-actions">
                    <button class="btn-clear" id="clearBtn">Clear</button>
                    <button class="btn-layout" id="layoutBtn" style="background: #667eea; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; margin-left: 8px;">
                        <i class="ri-layout-line"></i> Layout
                    </button>
                </div>
            </div>
            <div class="canvas-area desktop" id="canvasArea">
                <div class="canvas-placeholder">
                    <div class="simple-plus-icons">
                        <!-- Green Plus Icon -->
                        <div class="simple-plus-icon green" id="greenPlusIcon">
                            <i class="ri-add-line"></i>
                        </div>
                        
                        <!-- Black Plus Icon -->
                        <div class="simple-plus-icon black" id="blackPlusIcon">
                            <i class="ri-add-line"></i>
                        </div>
                        
                        <!-- Purple Plus Icon -->
                        <div class="simple-plus-icon purple" id="purplePlusIcon">
                            <i class="ri-add-line"></i>
                        </div>
                        
                        <!-- Blue Plus Icon -->
                        <div class="simple-plus-icon blue" id="bluePlusIcon">
                            <i class="ri-add-line"></i>
                        </div>
                    </div>
                    <p class="drag-text">Drag widget here</p>
                    
                    <!-- Layout Design Modal -->
                    <div class="layout-design-modal" id="layoutDesignModal" style="display: none;">
                        <div class="modal-overlay">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Select your structure</h3>
                                    <div class="modal-actions">
                                        <button class="modal-btn" id="modalBackBtn">
                                            <i class="ri-arrow-left-line"></i>
                                        </button>
                                        <button class="modal-btn" id="modalCloseBtn">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="structure-grid">
                                        <!-- Row 1 -->
                                        <div class="structure-option" data-layout="single-column-down">
                                            <div class="structure-preview">
                                                <div class="preview-single-column">
                                                    <i class="ri-arrow-down-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="single-column-right">
                                            <div class="structure-preview">
                                                <div class="preview-single-column">
                                                    <i class="ri-arrow-right-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="two-equal-columns">
                                            <div class="structure-preview">
                                                <div class="preview-two-equal">
                                                    <div class="preview-col"></div>
                                                    <div class="preview-col"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="two-unequal-left">
                                            <div class="structure-preview">
                                                <div class="preview-two-unequal">
                                                    <div class="preview-col-small"></div>
                                                    <div class="preview-col-large"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="three-equal-columns">
                                            <div class="structure-preview">
                                                <div class="preview-three-equal">
                                                    <div class="preview-col"></div>
                                                    <div class="preview-col"></div>
                                                    <div class="preview-col"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="three-unequal-middle">
                                            <div class="structure-preview">
                                                <div class="preview-three-unequal">
                                                    <div class="preview-col-small"></div>
                                                    <div class="preview-col-large"></div>
                                                    <div class="preview-col-small"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Row 2 -->
                                        <div class="structure-option" data-layout="four-squares">
                                            <div class="structure-preview">
                                                <div class="preview-four-squares">
                                                    <div class="preview-square"></div>
                                                    <div class="preview-square"></div>
                                                    <div class="preview-square"></div>
                                                    <div class="preview-square"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="top-single-bottom-two">
                                            <div class="structure-preview">
                                                <div class="preview-top-single-bottom-two">
                                                    <div class="preview-row-full"></div>
                                                    <div class="preview-row-two">
                                                        <div class="preview-col"></div>
                                                        <div class="preview-col"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option active" data-layout="left-tall-right-two">
                                            <div class="structure-preview">
                                                <div class="preview-left-tall-right-two">
                                                    <div class="preview-col-tall"></div>
                                                    <div class="preview-col-two">
                                                        <div class="preview-row"></div>
                                                        <div class="preview-row"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="left-tall-middle-two-right-tall">
                                            <div class="structure-preview">
                                                <div class="preview-left-tall-middle-two-right-tall">
                                                    <div class="preview-col-tall"></div>
                                                    <div class="preview-col-two">
                                                        <div class="preview-row"></div>
                                                        <div class="preview-row"></div>
                                                    </div>
                                                    <div class="preview-col-tall"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="top-two-bottom-single">
                                            <div class="structure-preview">
                                                <div class="preview-top-two-bottom-single">
                                                    <div class="preview-row-two">
                                                        <div class="preview-col"></div>
                                                        <div class="preview-col"></div>
                                                    </div>
                                                    <div class="preview-row-full"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="structure-option" data-layout="top-single-middle-two-bottom-single">
                                            <div class="structure-preview">
                                                <div class="preview-top-single-middle-two-bottom-single">
                                                    <div class="preview-row-full"></div>
                                                    <div class="preview-row-two">
                                                        <div class="preview-col"></div>
                                                        <div class="preview-col"></div>
                                                    </div>
                                                    <div class="preview-row-full"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Properties -->
        <div class="builder-properties">
            <div class="properties-header">
                SETTINGS
            </div>
            <div class="properties-content" id="propertiesContent">
                <div class="empty-state">
                    <i class="ri-cursor-line"></i>
                    <h4>Select an Element</h4>
                    <p>Click on any element to edit its properties</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Templates Modal -->
<div class="modal fade" id="templatesModal" tabindex="-1" aria-labelledby="templatesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templatesModalLabel">
                    <i class="ri-layout-line me-2"></i>Page Templates
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Templates Grid -->
                        <div class="templates-grid" id="templatesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; max-height: 500px; overflow-y: auto;">
                            <!-- Template items will be loaded here -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Create Custom Template -->
                        <div class="create-template-section">
                            <h6>Create Custom Template</h6>
                            <div class="mb-3">
                                <label for="templateName" class="form-label">Template Name</label>
                                <input type="text" class="form-control" id="templateName" placeholder="Enter template name">
                            </div>
                            <div class="mb-3">
                                <label for="templateDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="templateDescription" rows="3" placeholder="Describe your template"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="templateCategory" class="form-label">Category</label>
                                <select class="form-select" id="templateCategory">
                                    <option value="business">Business</option>
                                    <option value="portfolio">Portfolio</option>
                                    <option value="blog">Blog</option>
                                    <option value="ecommerce">E-commerce</option>
                                    <option value="landing">Landing Page</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" onclick="saveCurrentPageAsTemplate()">
                                <i class="ri-save-line me-1"></i> Save Current Page as Template
                            </button>
                        </div>
                        
                        <!-- Template Categories -->
                        <div class="template-categories mt-4">
                            <h6>Filter by Category</h6>
                            <div class="btn-group-vertical w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm active" onclick="filterTemplates('all')">All Templates</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('business')">Business</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('portfolio')">Portfolio</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('blog')">Blog</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('ecommerce')">E-commerce</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('landing')">Landing Page</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="filterTemplates('custom')">My Templates</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="importTemplateBtn" disabled>Import Template</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvasArea = document.getElementById('canvasArea');
    const propertiesContent = document.getElementById('propertiesContent');
    const saveBtn = document.getElementById('saveBtn');
    const previewBtn = document.getElementById('previewBtn');
    const clearBtn = document.getElementById('clearBtn');
    const exportBtn = document.getElementById('exportBtn');
    const exportJsonBtn = document.getElementById('exportJsonBtn');
    const importBtn = document.getElementById('importBtn');
    const loadBtn = document.getElementById('loadBtn');
    const deviceBtns = document.querySelectorAll('.device-btn');
    const categoryHeaders = document.querySelectorAll('.category-header');
    
    let selectedElement = null;
    let elementCounter = 0;
    let currentDevice = 'desktop';
    let history = [];
    let historyIndex = -1;

    // Widget templates
    const widgetTemplates = {
        // Layout Widgets
        container: '<div class="container" style="padding: 20px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; min-height: 100px;"><div class="row"><div class="col-12"><div class="drop-zone" style="min-height: 50px; border: 2px dashed #ccc; border-radius: 6px; padding: 10px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column; gap: 10px;"><div class="drop-placeholder">Drop content here</div></div></div></div></div>',
        grid: '<div class="grid-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 20px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; min-height: 100px;"><div class="grid-item drop-zone" style="background: #fff; padding: 20px; border-radius: 6px; border: 2px dashed #ccc; min-height: 50px; display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column; gap: 10px;">Drop content here</div><div class="grid-item drop-zone" style="background: #fff; padding: 20px; border-radius: 6px; border: 2px dashed #ccc; min-height: 50px; display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column; gap: 10px;">Drop content here</div></div>',
        section: '<div class="section" style="padding: 40px 0; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; margin: 20px 0; min-height: 100px;"><div class="container"><div class="row"><div class="col-12"><div class="drop-zone" style="min-height: 50px; border: 2px dashed #ccc; border-radius: 6px; padding: 10px; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column; gap: 10px;">Drop content here</div></div></div></div></div>',
        column: '<div class="column" style="padding: 20px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; margin: 10px 0; min-height: 50px;"><div class="drop-zone" style="min-height: 30px; border: 2px dashed #ccc; border-radius: 6px; padding: 10px; background: rgba(248,249,250,0.5); display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column; gap: 10px;">Drop content here</div></div>',
        spacer: '<div class="spacer" style="height: 50px; background: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; color: #6c757d; margin: 20px 0;">Spacer</div>',
        divider: '<div class="divider" style="height: 2px; background: #dee2e6; margin: 20px 0;"></div>',
        
        // Basic Widgets
        heading: '<h2 class="editable-text" contenteditable="true" style="margin: 20px 0; color: #333; min-height: 30px; border: 2px dashed transparent; padding: 5px; border-radius: 4px; cursor: text;">Click to edit heading</h2>',
        paragraph: '<p class="editable-text" contenteditable="true" style="margin: 20px 0; line-height: 1.6; color: #333; min-height: 30px; border: 2px dashed transparent; padding: 5px; border-radius: 4px; cursor: text;">Your paragraph text goes here. You can edit this content by clicking on it.</p>',
        image: '<div class="image-widget" style="text-align: center; margin: 20px 0; position: relative;"><div class="image-placeholder" style="background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; padding: 40px; cursor: pointer; transition: all 0.3s;"><i class="ri-image-add-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 10px;"></i><p style="color: #6c757d; margin: 0;">Click to upload image or drag & drop</p><input type="file" accept="image/*" style="display: none;" class="image-upload-input"></div><img src="" alt="Uploaded Image" style="max-width: 100%; height: auto; border-radius: 8px; display: none;" class="uploaded-image"></div>',
        background: '<div class="background-widget" style="padding: 30px; margin: 20px 0; border: 2px dashed #dee2e6; border-radius: 8px; text-align: center; cursor: pointer; background: #f8f9fa; transition: all 0.3s;"><i class="ri-palette-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 10px;"></i><h4 style="margin: 0 0 10px; color: #333;">Background Section</h4><p style="color: #6c757d; margin: 0;">Click to customize background</p><div class="background-options" style="display: none; margin-top: 20px; text-align: left;"><div style="margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 600;">Background Type:</label><select class="background-type" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"><option value="color">Solid Color</option><option value="gradient">Gradient</option><option value="image">Background Image</option></select></div><div class="color-options" style="margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 600;">Background Color:</label><input type="color" class="background-color" value="#ffffff" style="width: 100%; height: 40px; border: none; border-radius: 4px; cursor: pointer;"></div><div class="gradient-options" style="display: none; margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 600;">Gradient Colors:</label><div style="display: flex; gap: 10px;"><input type="color" class="gradient-color-1" value="#007bff" style="width: 50%; height: 40px; border: none; border-radius: 4px; cursor: pointer;"><input type="color" class="gradient-color-2" value="#6f42c1" style="width: 50%; height: 40px; border: none; border-radius: 4px; cursor: pointer;"></div><select class="gradient-direction" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-top: 10px;"><option value="to right">Left to Right</option><option value="to bottom">Top to Bottom</option><option value="to bottom right">Diagonal</option><option value="135deg">135° Angle</option></select></div><div class="image-options" style="display: none; margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 600;">Background Image:</label><input type="file" class="background-image-input" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></div><div style="display: flex; gap: 10px;"><button class="apply-background" style="flex: 1; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Apply Background</button><button class="reset-background" style="flex: 1; padding: 10px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Reset</button></div></div></div>',
        video: '<div class="video-widget" style="text-align: center; margin: 20px 0; position: relative;"><div class="video-placeholder" style="background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; padding: 40px; cursor: pointer; transition: all 0.3s;"><i class="ri-video-add-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 10px;"></i><p style="color: #6c757d; margin: 0;">Click to upload video</p><input type="file" accept="video/*" style="display: none;" class="video-upload-input"></div><video controls style="max-width: 100%; height: auto; border-radius: 8px; display: none;" class="uploaded-video"><source src="" type="video/mp4">Your browser does not support the video tag.</video></div>',
        button: '<div style="text-align: center; margin: 20px 0;"><button class="btn btn-primary editable-text" contenteditable="true" style="padding: 12px 24px; border: none; border-radius: 6px; background: #007bff; color: white; cursor: pointer; min-width: 100px; border: 2px dashed transparent;">Click Me</button></div>',
        icon: '<div style="text-align: center; margin: 20px 0;"><i class="ri-star-line" style="font-size: 3rem; color: #ffc107;"></i></div>',
        
        // Media Widgets
        gallery: '<div class="gallery" style="margin: 20px 0;"><div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;"><img src="https://via.placeholder.com/200x150" alt="Gallery 1" style="width: 100%; height: auto; border-radius: 6px;"><img src="https://via.placeholder.com/200x150" alt="Gallery 2" style="width: 100%; height: auto; border-radius: 6px;"><img src="https://via.placeholder.com/200x150" alt="Gallery 3" style="width: 100%; height: auto; border-radius: 6px;"></div></div>',
        carousel: '<div class="carousel" style="margin: 20px 0; background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;"><i class="ri-slideshow-line" style="font-size: 2rem; color: #6c757d;"></i><p style="margin-top: 10px; color: #6c757d;">Carousel placeholder</p></div>',
        audio: '<div class="audio" style="margin: 20px 0; background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;"><i class="ri-music-line" style="font-size: 2rem; color: #6c757d;"></i><p style="margin-top: 10px; color: #6c757d;">Audio placeholder</p></div>',
        map: '<div class="map" style="margin: 20px 0; background: #f8f9fa; padding: 40px; border-radius: 8px; text-align: center; border: 2px dashed #dee2e6;"><i class="ri-map-pin-line" style="font-size: 2rem; color: #6c757d;"></i><p style="margin-top: 10px; color: #6c757d;">Map placeholder</p></div>',
        
        // Forms Widgets
        form: '<div class="form" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px;"><form><div style="margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 500;">Name:</label><input type="text" style="width: 100%; padding: 8px; border: 1px solid #dee2e6; border-radius: 4px;"></div><div style="margin-bottom: 15px;"><label style="display: block; margin-bottom: 5px; font-weight: 500;">Email:</label><input type="email" style="width: 100%; padding: 8px; border: 1px solid #dee2e6; border-radius: 4px;"></div><button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Submit</button></form></div>',
        input: '<div style="margin: 20px 0;"><label style="display: block; margin-bottom: 5px; font-weight: 500;">Input Field:</label><input type="text" placeholder="Enter text..." style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px;"></div>',
        textarea: '<div style="margin: 20px 0;"><label style="display: block; margin-bottom: 5px; font-weight: 500;">Textarea:</label><textarea placeholder="Enter your message..." style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px; min-height: 100px; resize: vertical;"></textarea></div>',
        select: '<div style="margin: 20px 0;"><label style="display: block; margin-bottom: 5px; font-weight: 500;">Select Option:</label><select style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px;"><option>Option 1</option><option>Option 2</option><option>Option 3</option></select></div>',
        checkbox: '<div style="margin: 20px 0;"><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="margin-right: 10px;">Checkbox option</label></div>',
        radio: '<div style="margin: 20px 0;"><label style="display: flex; align-items: center; cursor: pointer;"><input type="radio" name="radio-group" style="margin-right: 10px;">Radio option</label></div>',
        
        // Advanced Widgets
        tabs: '<div class="tabs" style="margin: 20px 0;"><div class="tab-headers" style="display: flex; border-bottom: 2px solid #dee2e6;"><div class="tab-header active" style="padding: 10px 20px; cursor: pointer; border-bottom: 2px solid #007bff; background: #f8f9fa;">Tab 1</div><div class="tab-header" style="padding: 10px 20px; cursor: pointer; background: #f8f9fa;">Tab 2</div></div><div class="tab-content" style="padding: 20px; background: #fff; border: 1px solid #dee2e6; border-top: none;">Tab content goes here.</div></div>',
        accordion: '<div class="accordion" style="margin: 20px 0;"><div class="accordion-item" style="border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 10px;"><div class="accordion-header" style="padding: 15px; background: #f8f9fa; cursor: pointer; border-radius: 8px 8px 0 0; font-weight: 500;">Accordion Item 1</div><div class="accordion-content" style="padding: 15px; display: none; background: #fff; border-radius: 0 0 8px 8px;">Accordion content goes here.</div></div></div>',
        modal: '<div class="modal" style="margin: 20px 0; background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border: 2px dashed #dee2e6;"><i class="ri-window-line" style="font-size: 2rem; color: #6c757d;"></i><p style="margin-top: 10px; color: #6c757d;">Modal placeholder</p></div>',
        counter: '<div class="counter" style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px; margin: 20px 0;"><div style="font-size: 3rem; font-weight: bold; color: #007bff;">0</div><div style="color: #6c757d;">Count</div></div>',
        progress: '<div class="progress" style="margin: 20px 0;"><div style="background: #e9ecef; height: 20px; border-radius: 10px; overflow: hidden;"><div style="background: #007bff; height: 100%; width: 50%; transition: width 0.3s;"></div></div><div style="text-align: center; margin-top: 10px; color: #6c757d;">50% Complete</div></div>',
        testimonial: '<div class="testimonial" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;"><div style="font-size: 1.2rem; color: #333; margin-bottom: 15px; font-style: italic;">"This is a great testimonial."</div><div style="font-weight: 500; color: #666;">- Customer Name</div></div>'
    };

    // Content types data
    const contentTypes = @json($contentTypes ?? []);

    // Initialize sidebar tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const componentsContent = document.getElementById('componentsContent');
    const blocksContent = document.getElementById('blocksContent');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const tab = this.dataset.tab;
            if (tab === 'components') {
                componentsContent.style.display = 'block';
                blocksContent.style.display = 'none';
            } else {
                componentsContent.style.display = 'none';
                blocksContent.style.display = 'block';
            }
        });
    });

    // Initialize search functionality
    const widgetSearch = document.getElementById('widgetSearch');
    widgetSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const widgetItems = document.querySelectorAll('.widget-item');
        
        widgetItems.forEach(item => {
            const widgetName = item.querySelector('h6').textContent.toLowerCase();
            const category = item.closest('.widget-category');
            
            if (widgetName.includes(searchTerm)) {
                item.style.display = 'flex';
                category.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide empty categories
        document.querySelectorAll('.widget-category').forEach(category => {
            const visibleItems = category.querySelectorAll('.widget-item[style*="display: flex"], .widget-item:not([style*="display: none"])');
            if (visibleItems.length === 0 && searchTerm !== '') {
                category.style.display = 'none';
            } else {
                category.style.display = 'block';
            }
        });
    });

    // Initialize category toggles
    categoryHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const category = this.dataset.category;
            const content = document.getElementById(category + '-widgets');
            const icon = this.querySelector('i:last-child');
            
            if (content.style.display === 'none') {
                content.style.display = 'grid';
                icon.className = 'ri-arrow-down-s-line';
            } else {
                content.style.display = 'none';
                icon.className = 'ri-arrow-right-s-line';
            }
        });
    });

    // Initialize device toggle
    deviceBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            deviceBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentDevice = this.dataset.device;
            canvasArea.className = `canvas-area ${currentDevice}`;
            
            // Update device info
            const deviceInfo = canvasArea.querySelector('.device-info small');
            if (deviceInfo) {
                switch(currentDevice) {
                    case 'desktop':
                        deviceInfo.textContent = 'Desktop View - Full Width (1920×1080)';
                        break;
                    case 'tablet':
                        deviceInfo.textContent = 'Tablet View - iPad (768×1024)';
                        break;
                    case 'mobile':
                        deviceInfo.textContent = 'Mobile View - iPhone (375×667)';
                        break;
                }
            }
        });
    });

    // Drag and drop functionality
    document.querySelectorAll('.widget-item').forEach(item => {
        item.addEventListener('dragstart', function(e) {
            const widget = this.dataset.widget;
            const contentType = this.dataset.contentType;
            const layoutType = this.dataset.layout;
            
            if (widget === 'layout' && layoutType) {
                // Handle layout drag
                e.dataTransfer.setData('text/plain', 'layout');
                e.dataTransfer.setData('layout-type', layoutType);
            } else if (widget === 'content-type' && contentType) {
                e.dataTransfer.setData('text/plain', widget + ':' + contentType);
            } else {
                e.dataTransfer.setData('text/plain', widget);
            }
        });
    });

    // Global drag over handler
    document.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    // Global drag leave handler
    document.addEventListener('dragleave', function(e) {
        // Only remove drag-over if leaving the entire document
        if (!e.relatedTarget || !document.contains(e.relatedTarget)) {
            document.querySelectorAll('.drag-over').forEach(el => {
                el.classList.remove('drag-over');
            });
        }
    });

    // Canvas area drop handler
    canvasArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    canvasArea.addEventListener('dragleave', function(e) {
        if (!this.contains(e.relatedTarget)) {
        this.classList.remove('drag-over');
        }
    });

    canvasArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const data = e.dataTransfer.getData('text/plain');
        const layoutType = e.dataTransfer.getData('layout-type');
        
        if (layoutType) {
            // Handle layout drop
            createLayoutFromSidebar(layoutType);
        } else {
            // Handle widget drop
            const parts = data.split(':');
            const widgetType = parts[0];
            const contentTypeSlug = parts[1];
            
            addWidget(widgetType, contentTypeSlug);
        }
    });

    // Drop zone handlers
    function setupDropZones() {
        document.querySelectorAll('.drop-zone').forEach(dropZone => {
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('drag-over');
            });

            dropZone.addEventListener('dragleave', function(e) {
                if (!this.contains(e.relatedTarget)) {
                    this.classList.remove('drag-over');
                }
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');
                
                const data = e.dataTransfer.getData('text/plain');
                const parts = data.split(':');
                const widgetType = parts[0];
                const contentTypeSlug = parts[1];
                
                addWidgetToDropZone(this, widgetType, contentTypeSlug);
            });
        });
    }

    function addWidget(type, contentTypeSlug = null) {
        const elementId = 'element_' + (++elementCounter);
        let template = widgetTemplates[type];
        
        // Handle content type widgets
        if (type === 'content-type' && contentTypeSlug) {
            const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
            if (contentType) {
                template = contentType.component_html || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentType.name + '</div>';
            } else {
                // Sample content type templates
                const sampleContentTypes = {
                    'blog-post': '<div class="blog-post" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;"><h3 style="color: #333; margin-bottom: 10px;">Blog Post Title</h3><p style="color: #666; margin-bottom: 15px;">Blog post excerpt goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #999; font-size: 14px;">By Author Name</span><span style="color: #999; font-size: 14px;">Dec 15, 2023</span></div></div>',
                    'product': '<div class="product" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/200x150" alt="Product" style="width: 100%; max-width: 200px; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Product Name</h4><p style="color: #666; margin-bottom: 15px;">Product description goes here...</p><div style="font-size: 1.5rem; font-weight: bold; color: #28a745;">$99.99</div></div>',
                    'team-member': '<div class="team-member" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/150x150" alt="Team Member" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 5px;">John Doe</h4><p style="color: #666; margin-bottom: 10px;">CEO & Founder</p><p style="color: #999; font-size: 14px;">Team member bio goes here...</p></div>',
                    'testimonial': '<div class="testimonial" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;"><div style="font-size: 1.2rem; color: #333; margin-bottom: 15px; font-style: italic;">"This is an amazing testimonial from our satisfied customer."</div><div style="display: flex; align-items: center; justify-content: center; gap: 10px;"><img src="https://via.placeholder.com/50x50" alt="Customer" style="width: 50px; height: 50px; border-radius: 50%;"><div><div style="font-weight: 500; color: #333;">Jane Smith</div><div style="color: #666; font-size: 14px;">Customer</div></div></div></div>',
                    'portfolio': '<div class="portfolio" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px;"><img src="https://via.placeholder.com/300x200" alt="Portfolio" style="width: 100%; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Project Title</h4><p style="color: #666; margin-bottom: 15px;">Project description goes here...</p><div style="display: flex; gap: 10px;"><span style="background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Web Design</span><span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Development</span></div></div>',
                    'event': '<div class="event" style="margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;"><h4 style="color: #333; margin-bottom: 10px;">Event Title</h4><p style="color: #666; margin-bottom: 15px;">Event description goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #007bff; font-weight: 500;">Dec 25, 2023</span><span style="color: #666;">2:00 PM - 4:00 PM</span></div></div>'
                };
                template = sampleContentTypes[contentTypeSlug] || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentTypeSlug + '</div>';
            }
        }
        
        if (template) {
            const elementDiv = document.createElement('div');
            elementDiv.className = 'builder-element';
            elementDiv.id = elementId;
            elementDiv.dataset.type = type;
            if (contentTypeSlug) {
                elementDiv.dataset.contentType = contentTypeSlug;
            }
            elementDiv.innerHTML = `
                <div class="element-actions">
                    <button class="btn btn-edit" onclick="editElement('${elementId}')">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-duplicate" onclick="duplicateElement('${elementId}')">
                        <i class="ri-file-copy-line"></i>
                    </button>
                    <button class="btn btn-delete" onclick="deleteElement('${elementId}')">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
                ${template}
            `;
            
            // Remove placeholder if it exists
            const placeholder = canvasArea.querySelector('.canvas-placeholder');
            if (placeholder) {
                placeholder.remove();
            }
            
            canvasArea.appendChild(elementDiv);
            
            // Add click handler for selection
            elementDiv.addEventListener('click', function(e) {
                e.stopPropagation();
                selectElement(this);
            });

            // Setup drop zones for container widgets
            if (['container', 'grid', 'section', 'column'].includes(type)) {
                setupDropZones();
            }

            // Setup inline editing and uploads
            setupInlineEditing(elementDiv);

            // Save to history
            saveToHistory();
        }
    }

    function addWidgetToDropZone(dropZone, type, contentTypeSlug = null) {
        const elementId = 'element_' + (++elementCounter);
        let template = widgetTemplates[type];
        
        // Handle content type widgets
        if (type === 'content-type' && contentTypeSlug) {
            const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
            if (contentType) {
                template = contentType.component_html || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentType.name + '</div>';
            } else {
                // Sample content type templates
                const sampleContentTypes = {
                    'blog-post': '<div class="blog-post" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;"><h3 style="color: #333; margin-bottom: 10px;">Blog Post Title</h3><p style="color: #666; margin-bottom: 15px;">Blog post excerpt goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #999; font-size: 14px;">By Author Name</span><span style="color: #999; font-size: 14px;">Dec 15, 2023</span></div></div>',
                    'product': '<div class="product" style="margin: 10px 0; padding: 15px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/200x150" alt="Product" style="width: 100%; max-width: 200px; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Product Name</h4><p style="color: #666; margin-bottom: 15px;">Product description goes here...</p><div style="font-size: 1.5rem; font-weight: bold; color: #28a745;">$99.99</div></div>',
                    'team-member': '<div class="team-member" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/150x150" alt="Team Member" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 5px;">John Doe</h4><p style="color: #666; margin-bottom: 10px;">CEO & Founder</p><p style="color: #999; font-size: 14px;">Team member bio goes here...</p></div>',
                    'testimonial': '<div class="testimonial" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;"><div style="font-size: 1.2rem; color: #333; margin-bottom: 15px; font-style: italic;">"This is an amazing testimonial from our satisfied customer."</div><div style="display: flex; align-items: center; justify-content: center; gap: 10px;"><img src="https://via.placeholder.com/50x50" alt="Customer" style="width: 50px; height: 50px; border-radius: 50%;"><div><div style="font-weight: 500; color: #333;">Jane Smith</div><div style="color: #666; font-size: 14px;">Customer</div></div></div></div>',
                    'portfolio': '<div class="portfolio" style="margin: 10px 0; padding: 15px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px;"><img src="https://via.placeholder.com/300x200" alt="Portfolio" style="width: 100%; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Project Title</h4><p style="color: #666; margin-bottom: 15px;">Project description goes here...</p><div style="display: flex; gap: 10px;"><span style="background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Web Design</span><span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Development</span></div></div>',
                    'event': '<div class="event" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;"><h4 style="color: #333; margin-bottom: 10px;">Event Title</h4><p style="color: #666; margin-bottom: 15px;">Event description goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #007bff; font-weight: 500;">Dec 25, 2023</span><span style="color: #666;">2:00 PM - 4:00 PM</span></div></div>'
                };
                template = sampleContentTypes[contentTypeSlug] || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentTypeSlug + '</div>';
            }
        }
        
        if (template) {
            // Create the widget element
            const elementDiv = document.createElement('div');
            elementDiv.className = 'builder-element nested-element';
            elementDiv.id = elementId;
            elementDiv.dataset.type = type;
            if (contentTypeSlug) {
                elementDiv.dataset.contentType = contentTypeSlug;
            }
            elementDiv.innerHTML = `
                <div class="element-actions">
                    <button class="btn btn-edit" onclick="editElement('${elementId}')">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-duplicate" onclick="duplicateElement('${elementId}')">
                        <i class="ri-file-copy-line"></i>
                    </button>
                    <button class="btn btn-delete" onclick="deleteElement('${elementId}')">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
                ${template}
            `;
            
            // Add to drop zone (don't replace existing content)
            dropZone.appendChild(elementDiv);
            
            // Hide placeholder text if content exists
            if (dropZone.children.length > 1) {
                const placeholder = dropZone.querySelector('.drop-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            }
            
            // Add click handler for selection
            elementDiv.addEventListener('click', function(e) {
                e.stopPropagation();
                selectElement(this);
            });

            // Setup drop zones for container widgets
            if (['container', 'grid', 'section', 'column'].includes(type)) {
                setupDropZones();
            }

            // Setup inline editing and uploads
            setupInlineEditing(elementDiv);

            // Save to history
            saveToHistory();
        }
    }

    function selectElement(element) {
        // Remove previous selection
        document.querySelectorAll('.builder-element').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Select current element
        element.classList.add('selected');
        selectedElement = element;
        
        // Update properties panel
        updatePropertiesPanel(element);
    }

    function updatePropertiesPanel(element) {
        const type = element.dataset.type;
        const contentType = element.dataset.contentType;
        
        let propertiesHtml = `
            <div class="property-group">
                <h6>${type.charAt(0).toUpperCase() + type.slice(1).replace('-', ' ')} Settings</h6>
        `;
        
        if (type === 'content-type' && contentType) {
            const contentTypeData = contentTypes.find(ct => ct.slug === contentType);
            propertiesHtml += `
                <div class="form-group">
                    <label class="form-label">Content Type</label>
                    <input type="text" class="form-control" value="${contentTypeData?.name || 'Content Type'}" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Fields Count</label>
                    <input type="text" class="form-control" value="${contentTypeData?.fields_count || 0} fields" readonly>
                </div>
            `;
        }
        
        // Typography Settings for text elements
        if (['heading', 'paragraph', 'button'].includes(type)) {
            propertiesHtml += `
                <div class="property-group">
                    <h6>Typography</h6>
                    <div class="form-group">
                        <label class="form-label">Font Family</label>
                        <select class="form-select" onchange="applyStyle('font-family', this.value)">
                            <option value="Inter, sans-serif">Inter</option>
                            <option value="Arial, sans-serif">Arial</option>
                            <option value="Helvetica, sans-serif">Helvetica</option>
                            <option value="Georgia, serif">Georgia</option>
                            <option value="Times New Roman, serif">Times New Roman</option>
                            <option value="Courier New, monospace">Courier New</option>
                            <option value="Verdana, sans-serif">Verdana</option>
                            <option value="Poppins, sans-serif">Poppins</option>
                            <option value="Roboto, sans-serif">Roboto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Font Size</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="12" max="72" value="16" onchange="applyStyle('font-size', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="16" value="16" style="width: 30%;" onchange="applyStyle('font-size', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Font Weight</label>
                        <select class="form-select" onchange="applyStyle('font-weight', this.value)">
                            <option value="300">Light (300)</option>
                            <option value="400">Normal (400)</option>
                            <option value="500">Medium (500)</option>
                            <option value="600">Semi Bold (600)</option>
                            <option value="700">Bold (700)</option>
                            <option value="800">Extra Bold (800)</option>
                            <option value="900">Black (900)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Line Height</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="1" max="3" step="0.1" value="1.6" onchange="applyStyle('line-height', this.value)">
                            <input type="number" class="form-control" placeholder="1.6" value="1.6" step="0.1" style="width: 30%;" onchange="applyStyle('line-height', this.value)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Text Align</label>
                        <div class="btn-group" style="width: 100%;">
                            <button class="btn btn-outline" onclick="applyStyle('text-align', 'left')" title="Left">
                                <i class="ri-align-left"></i>
                            </button>
                            <button class="btn btn-outline" onclick="applyStyle('text-align', 'center')" title="Center">
                                <i class="ri-align-center"></i>
                            </button>
                            <button class="btn btn-outline" onclick="applyStyle('text-align', 'right')" title="Right">
                                <i class="ri-align-right"></i>
                            </button>
                            <button class="btn btn-outline" onclick="applyStyle('text-align', 'justify')" title="Justify">
                                <i class="ri-align-justify"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Text Color</label>
                        <input type="color" class="color-picker" value="#333333" onchange="applyStyle('color', this.value)">
                    </div>
                </div>
            `;
        }
        
        // Image/Video specific settings
        if (['image', 'video'].includes(type)) {
            propertiesHtml += `
                <div class="property-group">
                    <h6>Media Settings</h6>
                    <div class="form-group">
                        <label class="form-label">Width</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="100" max="800" value="400" onchange="applyStyle('width', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="400" value="400" style="width: 30%;" onchange="applyStyle('width', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Height</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="100" max="600" value="300" onchange="applyStyle('height', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="300" value="300" style="width: 30%;" onchange="applyStyle('height', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Border Radius</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="0" max="50" value="8" onchange="applyStyle('border-radius', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="8" value="8" style="width: 30%;" onchange="applyStyle('border-radius', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Object Fit</label>
                        <select class="form-select" onchange="applyStyle('object-fit', this.value)">
                            <option value="cover">Cover</option>
                            <option value="contain">Contain</option>
                            <option value="fill">Fill</option>
                            <option value="scale-down">Scale Down</option>
                        </select>
                    </div>
                </div>
            `;
        }
        
        // Container Settings
        propertiesHtml += `
                <div class="property-group">
                    <h6>Dimensions & Spacing</h6>
                    <div class="form-group">
                        <label class="form-label">Width</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="100%" value="100%" style="width: 70%;" onchange="applyStyle('width', this.value)">
                            <select class="form-select" style="width: 30%;" onchange="applyStyle('width', this.value)">
                                <option value="100%">100%</option>
                                <option value="75%">75%</option>
                                <option value="50%">50%</option>
                                <option value="25%">25%</option>
                                <option value="auto">Auto</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Height</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="auto" value="auto" style="width: 70%;" onchange="applyStyle('height', this.value)">
                            <select class="form-select" style="width: 30%;" onchange="applyStyle('height', this.value)">
                                <option value="auto">Auto</option>
                                <option value="100vh">100vh</option>
                                <option value="50vh">50vh</option>
                                <option value="300px">300px</option>
                                <option value="200px">200px</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Margin</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Top" value="0" style="width: 25%;" onchange="applyStyle('margin-top', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Right" value="0" style="width: 25%;" onchange="applyStyle('margin-right', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Bottom" value="0" style="width: 25%;" onchange="applyStyle('margin-bottom', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Left" value="0" style="width: 25%;" onchange="applyStyle('margin-left', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Padding</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Top" value="0" style="width: 25%;" onchange="applyStyle('padding-top', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Right" value="0" style="width: 25%;" onchange="applyStyle('padding-right', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Bottom" value="0" style="width: 25%;" onchange="applyStyle('padding-bottom', this.value + 'px')">
                            <input type="text" class="form-control" placeholder="Left" value="0" style="width: 25%;" onchange="applyStyle('padding-left', this.value + 'px')">
                        </div>
                    </div>
                </div>
                
                <div class="property-group">
                    <h6>Background & Border</h6>
                    <div class="form-group">
                        <label class="form-label">Background Color</label>
                        <input type="color" class="color-picker" value="#ffffff" onchange="applyStyle('background-color', this.value)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Border Width</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="0" max="10" value="0" onchange="applyStyle('border-width', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="0" value="0" style="width: 30%;" onchange="applyStyle('border-width', this.value + 'px')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Border Color</label>
                        <input type="color" class="color-picker" value="#dee2e6" onchange="applyStyle('border-color', this.value)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Border Radius</label>
                        <div class="btn-group" style="width: 100%;">
                            <input type="range" class="range-slider" min="0" max="50" value="0" onchange="applyStyle('border-radius', this.value + 'px')">
                            <input type="number" class="form-control" placeholder="0" value="0" style="width: 30%;" onchange="applyStyle('border-radius', this.value + 'px')">
                        </div>
                    </div>
                </div>
                
                <div class="property-group">
                    <h6>Layout</h6>
                    <div class="form-group">
                        <label class="form-label">Display</label>
                        <select class="form-select" onchange="applyStyle('display', this.value)">
                            <option value="block">Block</option>
                            <option value="inline">Inline</option>
                            <option value="inline-block">Inline Block</option>
                            <option value="flex">Flex</option>
                            <option value="grid">Grid</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <select class="form-select" onchange="applyStyle('position', this.value)">
                            <option value="static">Static</option>
                            <option value="relative">Relative</option>
                            <option value="absolute">Absolute</option>
                            <option value="fixed">Fixed</option>
                            <option value="sticky">Sticky</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Float</label>
                        <select class="form-select" onchange="applyStyle('float', this.value)">
                            <option value="none">None</option>
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                </div>
        `;
        
        propertiesContent.innerHTML = propertiesHtml;
    }

    // Apply style to selected element
    function applyStyle(property, value) {
        if (selectedElement) {
            // Find the actual content element (not the wrapper)
            let targetElement = selectedElement;
            
            // For text elements, apply to the editable element
            if (selectedElement.querySelector('.editable-text')) {
                targetElement = selectedElement.querySelector('.editable-text');
            }
            // For image/video elements, apply to the img/video tag
            else if (selectedElement.querySelector('img, video')) {
                targetElement = selectedElement.querySelector('img, video');
            }
            
            targetElement.style[property] = value;
            
            // Save to history
            saveToHistory();
        }
    }
    
    // Make applyStyle globally available
    window.applyStyle = applyStyle;

    // Global functions for element actions
    window.editElement = function(elementId) {
        const element = document.getElementById(elementId);
        selectElement(element);
    };

    window.duplicateElement = function(elementId) {
        const element = document.getElementById(elementId);
        const clonedElement = element.cloneNode(true);
        clonedElement.id = 'element_' + (++elementCounter);
        element.parentNode.insertBefore(clonedElement, element.nextSibling);
        
        // Re-add event listeners
        clonedElement.addEventListener('click', function(e) {
            e.stopPropagation();
            selectElement(this);
        });
        
        saveToHistory();
    };

    window.deleteElement = function(elementId) {
        const element = document.getElementById(elementId);
        element.remove();
        
        // Show placeholder if no elements left
        if (canvasArea.children.length === 0) {
            canvasArea.innerHTML = `
                <div class="canvas-placeholder">
                    <i class="ri-drag-drop-line"></i>
                    <h4>Start Building Your Page</h4>
                    <p>Drag widgets from the left sidebar to start building your page</p>
                </div>
            `;
        }
        
        // Clear selection
        selectedElement = null;
        propertiesContent.innerHTML = `
            <div class="empty-state">
                <i class="ri-cursor-line"></i>
                <h4>Select an Element</h4>
                <p>Click on any element to edit its properties</p>
            </div>
        `;
        
        saveToHistory();
    };

    // History management
    function saveToHistory() {
        const currentState = canvasArea.innerHTML;
        history = history.slice(0, historyIndex + 1);
        history.push(currentState);
        historyIndex++;
        
        // Limit history size
        if (history.length > 50) {
            history.shift();
            historyIndex--;
        }
    }

    function undo() {
        if (historyIndex > 0) {
            historyIndex--;
            canvasArea.innerHTML = history[historyIndex];
            reattachEventListeners();
        }
    }

    function redo() {
        if (historyIndex < history.length - 1) {
            historyIndex++;
            canvasArea.innerHTML = history[historyIndex];
            reattachEventListeners();
        }
    }

    function reattachEventListeners() {
        document.querySelectorAll('.builder-element').forEach(element => {
            element.addEventListener('click', function(e) {
                e.stopPropagation();
                selectElement(this);
            });
        });
        
        // Setup drop zones for container widgets
        setupDropZones();
        
        // Setup inline editing for all elements
        document.querySelectorAll('.builder-element').forEach(element => {
            setupInlineEditing(element);
        });
    }

    // Helper function to apply background to parent element
    function applyBackgroundToParent(backgroundWidget, backgroundStyle) {
        const parent = backgroundWidget.parentElement;
        if (parent) {
            // Apply background to parent
            parent.style.cssText += backgroundStyle;
            
            // Hide options panel
            const options = backgroundWidget.querySelector('.background-options');
            if (options) {
                options.style.display = 'none';
            }
            
            // Save to history
            saveToHistory();
        }
    }

    // Setup inline editing and file uploads
    function setupInlineEditing(element) {
        // Setup editable text elements
        element.querySelectorAll('.editable-text').forEach(editable => {
            editable.addEventListener('click', function(e) {
                e.stopPropagation();
                this.focus();
            });

            editable.addEventListener('blur', function() {
                saveToHistory();
            });

            editable.addEventListener('input', function() {
                // Auto-save on typing
                clearTimeout(this.saveTimeout);
                this.saveTimeout = setTimeout(() => {
                    saveToHistory();
                }, 1000);
            });
        });

        // Setup image upload with Media Library integration
        element.querySelectorAll('.image-widget').forEach(imageWidget => {
            const placeholder = imageWidget.querySelector('.image-placeholder');
            const uploadInput = imageWidget.querySelector('.image-upload-input');
            const uploadedImage = imageWidget.querySelector('.uploaded-image');

            placeholder.addEventListener('click', function() {
                openMediaLibrary(imageWidget);
            });

            // Drag and drop functionality
            placeholder.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.borderColor = '#007bff';
                this.style.backgroundColor = '#f8f9ff';
                this.style.transform = 'scale(1.02)';
            });

            placeholder.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.borderColor = '#dee2e6';
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'scale(1)';
            });

            placeholder.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.borderColor = '#dee2e6';
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'scale(1)';
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleImageUpload(files[0], imageWidget);
                }
            });

            uploadInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleImageUpload(file, imageWidget);
                }
            });

            // Add media library button
            if (!imageWidget.querySelector('.media-library-btn')) {
                const mediaBtn = document.createElement('button');
                mediaBtn.className = 'media-library-btn';
                mediaBtn.innerHTML = '<i class="ri-image-line"></i> Media Library';
                mediaBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    openMediaLibrary(imageWidget);
                });
                imageWidget.appendChild(mediaBtn);
            }

            // Add upload button
            if (!imageWidget.querySelector('.upload-btn')) {
                const uploadBtn = document.createElement('button');
                uploadBtn.className = 'upload-btn';
                uploadBtn.innerHTML = '<i class="ri-upload-line"></i> Upload';
                uploadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    uploadInput.click();
                });
                imageWidget.appendChild(uploadBtn);
            }
        });

        // Setup background widget
        element.querySelectorAll('.background-widget').forEach(backgroundWidget => {
            const backgroundOptions = backgroundWidget.querySelector('.background-options');
            const backgroundType = backgroundWidget.querySelector('.background-type');
            const colorOptions = backgroundWidget.querySelector('.color-options');
            const gradientOptions = backgroundWidget.querySelector('.gradient-options');
            const imageOptions = backgroundWidget.querySelector('.image-options');
            const applyBtn = backgroundWidget.querySelector('.apply-background');
            const resetBtn = backgroundWidget.querySelector('.reset-background');

            // Toggle options panel
            backgroundWidget.addEventListener('click', function(e) {
                if (e.target === backgroundWidget || e.target.closest('.background-widget')) {
                    backgroundOptions.style.display = backgroundOptions.style.display === 'none' ? 'block' : 'none';
                }
            });

            // Background type change
            backgroundType.addEventListener('change', function() {
                const type = this.value;
                colorOptions.style.display = type === 'color' ? 'block' : 'none';
                gradientOptions.style.display = type === 'gradient' ? 'block' : 'none';
                imageOptions.style.display = type === 'image' ? 'block' : 'none';
            });

            // Apply background
            applyBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const type = backgroundType.value;
                let backgroundStyle = '';

                if (type === 'color') {
                    const color = backgroundWidget.querySelector('.background-color').value;
                    backgroundStyle = `background-color: ${color};`;
                } else if (type === 'gradient') {
                    const color1 = backgroundWidget.querySelector('.gradient-color-1').value;
                    const color2 = backgroundWidget.querySelector('.gradient-color-2').value;
                    const direction = backgroundWidget.querySelector('.gradient-direction').value;
                    backgroundStyle = `background: linear-gradient(${direction}, ${color1}, ${color2});`;
                } else if (type === 'image') {
                    const fileInput = backgroundWidget.querySelector('.background-image-input');
                    const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            backgroundStyle = `background-image: url('${e.target.result}'); background-size: cover; background-position: center;`;
                            applyBackgroundToParent(backgroundWidget, backgroundStyle);
                        };
                        reader.readAsDataURL(file);
                        return;
                    }
                }

                applyBackgroundToParent(backgroundWidget, backgroundStyle);
            });

            // Reset background
            resetBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const parent = backgroundWidget.parentElement;
                if (parent) {
                    parent.style.background = '';
                    parent.style.backgroundImage = '';
                    parent.style.backgroundSize = '';
                    parent.style.backgroundPosition = '';
                }
                backgroundOptions.style.display = 'none';
                saveToHistory();
            });
        });

        // Setup video upload
        element.querySelectorAll('.video-widget').forEach(videoWidget => {
            const placeholder = videoWidget.querySelector('.video-placeholder');
            const uploadInput = videoWidget.querySelector('.video-upload-input');
            const uploadedVideo = videoWidget.querySelector('.uploaded-video');

            placeholder.addEventListener('click', function() {
                uploadInput.click();
            });

            uploadInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadedVideo.querySelector('source').src = e.target.result;
                        uploadedVideo.load();
                        uploadedVideo.style.display = 'block';
                        placeholder.style.display = 'none';
                        saveToHistory();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Add upload button
            if (!videoWidget.querySelector('.upload-btn')) {
                const uploadBtn = document.createElement('button');
                uploadBtn.className = 'upload-btn';
                uploadBtn.innerHTML = '<i class="ri-upload-line"></i> Upload';
                uploadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    uploadInput.click();
                });
                videoWidget.appendChild(uploadBtn);
            }
        });
    }

    // Event handlers
    saveBtn.addEventListener('click', function() {
        const content = canvasArea.innerHTML;
        
        // Clean content for saving (remove editor styles)
        const cleanContent = cleanContentForSave(content);
        
        // Generate a unique page ID
        const pageId = window.currentPageId || 'page_' + Date.now();
        
        // Save to localStorage for now
        const pageData = {
            content: cleanContent,
            originalContent: content,
            timestamp: new Date().toISOString(),
            pageId: pageId
        };
        
        localStorage.setItem(`saved_page_${pageId}`, JSON.stringify(pageData));
        localStorage.setItem('currentPageId', pageId);
        window.currentPageId = pageId;
        
        showNotification('Page saved successfully!', 'success');
        
        // Try to save to server if route exists
        try {
            fetch(`{{ route('page.builder.save') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    content: cleanContent,
                    page_id: pageId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Page also saved to server');
                }
            })
            .catch(error => {
                console.log('Server save failed, but local save succeeded');
            });
        } catch (error) {
            console.log('Server route not available, using localStorage only');
        }
    });

    // Clean content for saving (remove editor styles)
    function cleanContentForSave(content) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        
        // Remove editor-specific classes and styles
        tempDiv.querySelectorAll('.builder-element').forEach(element => {
            element.classList.remove('builder-element', 'selected', 'nested-element');
            element.style.border = '';
            element.style.boxShadow = '';
        });
        
        // Remove element actions
        tempDiv.querySelectorAll('.element-actions').forEach(action => {
            action.remove();
        });
        
        // Remove drop zones and placeholders
        tempDiv.querySelectorAll('.drop-zone').forEach(dropZone => {
            dropZone.classList.remove('drop-zone');
            dropZone.style.border = '';
            dropZone.style.background = '';
            dropZone.style.minHeight = '';
            dropZone.style.display = '';
            dropZone.style.alignItems = '';
            dropZone.style.justifyContent = '';
            dropZone.style.color = '';
            dropZone.style.flexDirection = '';
            dropZone.style.gap = '';
            dropZone.style.padding = '';
            dropZone.style.borderRadius = '';
        });
        
        // Remove placeholder text
        tempDiv.querySelectorAll('.drop-placeholder').forEach(placeholder => {
            placeholder.remove();
        });
        
        // Clean container styles
        tempDiv.querySelectorAll('.container, .grid-container, .section, .column').forEach(container => {
            container.style.background = '';
            container.style.border = '';
            container.style.borderRadius = '';
            container.style.padding = '';
            container.style.margin = '';
            container.style.minHeight = '';
        });
        
        // Clean grid item styles
        tempDiv.querySelectorAll('.grid-item').forEach(item => {
            item.style.background = '';
            item.style.border = '';
            item.style.borderRadius = '';
            item.style.padding = '';
            item.style.minHeight = '';
            item.style.display = '';
            item.style.alignItems = '';
            item.style.justifyContent = '';
            item.style.color = '';
            item.style.flexDirection = '';
            item.style.gap = '';
        });
        
        // Clean editable text styles
        tempDiv.querySelectorAll('.editable-text').forEach(text => {
            text.style.border = '';
            text.style.background = '';
            text.style.boxShadow = '';
            text.style.minHeight = '';
            text.style.padding = '';
            text.style.borderRadius = '';
            text.style.cursor = '';
        });
        
        // Clean upload placeholders
        tempDiv.querySelectorAll('.image-placeholder, .video-placeholder').forEach(placeholder => {
            placeholder.style.display = 'none';
        });
        
        // Clean upload buttons
        tempDiv.querySelectorAll('.upload-btn').forEach(btn => {
            btn.remove();
        });
        
        return tempDiv.innerHTML;
    }

    clearBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear all elements?')) {
            canvasArea.innerHTML = `
                <div class="canvas-placeholder">
                    <i class="ri-drag-drop-line"></i>
                    <h4>Start Building Your Page</h4>
                    <p>Drag widgets from the left sidebar to start building your page</p>
                </div>
            `;
            selectedElement = null;
            propertiesContent.innerHTML = `
                <div class="empty-state">
                    <i class="ri-cursor-line"></i>
                    <h4>Select an Element</h4>
                    <p>Click on any element to edit its properties</p>
                </div>
            `;
            saveToHistory();
        }
    });

    exportBtn.addEventListener('click', function() {
        const content = canvasArea.innerHTML;
        const blob = new Blob([`
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exported Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .builder-element { border: none !important; }
        .element-actions { display: none !important; }
    </style>
</head>
<body>
    ${content}
</body>
</html>
        `], { type: 'text/html' });
        
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'page-export.html';
        a.click();
        URL.revokeObjectURL(url);
    });

    exportJsonBtn.addEventListener('click', function() {
        const elements = Array.from(canvasArea.querySelectorAll('.builder-element')).map(el => ({
            type: el.dataset.type,
            contentType: el.dataset.contentType,
            content: el.innerHTML.replace(/<div class="element-actions">.*?<\/div>/s, '')
        }));
        
        const data = {
            elements: elements,
            device: currentDevice,
            exportedAt: new Date().toISOString()
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'page-export.json';
        a.click();
        URL.revokeObjectURL(url);
    });

    previewBtn.addEventListener('click', function() {
        const content = canvasArea.innerHTML;
        const cleanContent = cleanContentForSave(content);
        
        // Generate a unique preview ID
        const previewId = 'preview_' + Date.now();
        
        // Save preview content to localStorage
        localStorage.setItem(`preview_${previewId}`, JSON.stringify({
            content: cleanContent,
            timestamp: new Date().toISOString()
        }));
        
        // Open preview in new window with proper route
        const previewUrl = `{{ url('/') }}/preview/${previewId}`;
        window.open(previewUrl, '_blank');
    });

    // Load saved page functionality
    function loadSavedPage(pageId) {
        // For now, we'll use localStorage to store and load pages
        // This can be replaced with actual API calls when routes are set up
        const savedPage = localStorage.getItem(`saved_page_${pageId}`);
        
        if (savedPage) {
            try {
                const pageData = JSON.parse(savedPage);
                canvasArea.innerHTML = pageData.content;
                
                // Reattach event listeners
                reattachEventListeners();
                
                // Save to history
                saveToHistory();
                
                showNotification('Page loaded successfully!', 'success');
            } catch (error) {
                console.error('Error parsing saved page:', error);
                showNotification('Error loading page: Invalid data format', 'error');
            }
        } else {
            showNotification('Page not found. Please save a page first.', 'warning');
        }
    }

    // Check for page ID in URL or load from localStorage
    const urlParams = new URLSearchParams(window.location.search);
    const pageId = urlParams.get('page_id') || localStorage.getItem('currentPageId');
    
    if (pageId) {
        loadSavedPage(pageId);
    }

    // Load button event handler
    loadBtn.addEventListener('click', function() {
        // Get all saved pages from localStorage
        const savedPages = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && key.startsWith('saved_page_')) {
                try {
                    const pageData = JSON.parse(localStorage.getItem(key));
                    savedPages.push({
                        id: pageData.pageId,
                        timestamp: pageData.timestamp,
                        preview: pageData.content.substring(0, 100) + '...'
                    });
                } catch (error) {
                    console.error('Error parsing page data:', error);
                }
            }
        }
        
        if (savedPages.length === 0) {
            showNotification('No saved pages found. Please save a page first.', 'warning');
            return;
        }
        
        // Create a simple list of saved pages
        let pageList = 'Saved Pages:\n\n';
        savedPages.forEach((page, index) => {
            pageList += `${index + 1}. ID: ${page.id}\n   Saved: ${new Date(page.timestamp).toLocaleString()}\n   Preview: ${page.preview}\n\n`;
        });
        
        const pageId = prompt(pageList + '\nEnter Page ID to load:');
        if (pageId) {
            loadSavedPage(pageId);
        }
    });

    document.getElementById('undoBtn').addEventListener('click', undo);
    document.getElementById('redoBtn').addEventListener('click', redo);

    // Click outside to deselect
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.builder-element')) {
            document.querySelectorAll('.builder-element').forEach(el => {
                el.classList.remove('selected');
            });
            selectedElement = null;
            propertiesContent.innerHTML = `
                <div class="empty-state">
                    <i class="ri-cursor-line"></i>
                    <h4>Select an Element</h4>
                    <p>Click on any element to edit its properties</p>
                </div>
            `;
        }
    });

    // Initialize sortable for reordering elements
    new Sortable(canvasArea, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        handle: '.builder-element',
        onEnd: function() {
            saveToHistory();
        }
    });

    // Layout Selector Functionality
    const layoutPlusIcon = document.getElementById('layoutPlusIcon');
    const layoutOptions = document.getElementById('layoutOptions');
    const layoutBtn = document.getElementById('layoutBtn');
    let isLayoutOptionsVisible = false;

    // Widget Selector Functionality
    const widgetPlusIcon = document.getElementById('widgetPlusIcon');
    const widgetOptions = document.getElementById('widgetOptions');
    let isWidgetOptionsVisible = false;

    // Toggle layout options
    layoutPlusIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        isLayoutOptionsVisible = !isLayoutOptionsVisible;
        
        if (isLayoutOptionsVisible) {
            layoutOptions.style.display = 'block';
            layoutPlusIcon.style.transform = 'rotate(45deg)';
        } else {
            layoutOptions.style.display = 'none';
            layoutPlusIcon.style.transform = 'rotate(0deg)';
        }
    });

    // Widget plus icon functionality
    widgetPlusIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        isWidgetOptionsVisible = !isWidgetOptionsVisible;
        
        if (isWidgetOptionsVisible) {
            widgetOptions.style.display = 'block';
            widgetPlusIcon.style.transform = 'rotate(45deg)';
        } else {
            widgetOptions.style.display = 'none';
            widgetPlusIcon.style.transform = 'rotate(0deg)';
        }
    });

    // Simple Plus Icons Click Handlers
    const greenPlusIcon = document.getElementById('greenPlusIcon');
    const blackPlusIcon = document.getElementById('blackPlusIcon');
    const purplePlusIcon = document.getElementById('purplePlusIcon');
    const bluePlusIcon = document.getElementById('bluePlusIcon');

    if (greenPlusIcon) {
        greenPlusIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Green Plus Icon Clicked!', 'success');
            // Add your functionality here
        });
    }

    if (blackPlusIcon) {
        blackPlusIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Black Plus Icon Clicked!', 'success');
            // Add your functionality here
        });
    }

    if (purplePlusIcon) {
        purplePlusIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Purple Plus Icon Clicked!', 'success');
            // Add your functionality here
        });
    }

    if (bluePlusIcon) {
        bluePlusIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            showNotification('Blue Plus Icon Clicked!', 'success');
            // Add your functionality here
        });
    }

    // Layout button functionality
    layoutBtn.addEventListener('click', function() {
        // Show layout design modal
        const layoutDesignModal = document.getElementById('layoutDesignModal');
        layoutDesignModal.style.display = 'block';
    });

    // Modal functionality
    const layoutDesignModal = document.getElementById('layoutDesignModal');
    const modalBackBtn = document.getElementById('modalBackBtn');
    const modalCloseBtn = document.getElementById('modalCloseBtn');

    // Close modal functions
    function closeLayoutModal() {
        layoutDesignModal.style.display = 'none';
    }

    modalBackBtn.addEventListener('click', closeLayoutModal);
    modalCloseBtn.addEventListener('click', closeLayoutModal);

    // Close modal when clicking overlay
    layoutDesignModal.addEventListener('click', function(e) {
        if (e.target === layoutDesignModal || e.target.classList.contains('modal-overlay')) {
            closeLayoutModal();
        }
    });

    // Structure option selection
    document.querySelectorAll('.structure-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.structure-option').forEach(opt => {
                opt.classList.remove('active');
            });
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Get layout type
            const layoutType = this.dataset.layout;
            
            // Create layout based on selection
            createLayoutFromModal(layoutType);
            
            // Close modal
            closeLayoutModal();
        });
    });

    // Close options when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.layout-selector-container') && !e.target.closest('.btn-layout')) {
            layoutOptions.style.display = 'none';
            layoutPlusIcon.style.transform = 'rotate(0deg)';
            isLayoutOptionsVisible = false;
        }
        
        if (!e.target.closest('.widget-selector-container')) {
            widgetOptions.style.display = 'none';
            widgetPlusIcon.style.transform = 'rotate(0deg)';
            isWidgetOptionsVisible = false;
        }
    });

    // Layout option selection
    document.querySelectorAll('.layout-option').forEach(option => {
        option.addEventListener('click', function() {
            const layoutType = this.dataset.layout;
            createLayout(layoutType);
            
            // Hide layout options
            layoutOptions.style.display = 'none';
            layoutPlusIcon.style.transform = 'rotate(0deg)';
            isLayoutOptionsVisible = false;
        });
    });

    // Widget option selection
    document.querySelectorAll('.widget-option').forEach(option => {
        option.addEventListener('click', function() {
            const widgetType = this.dataset.widget;
            addWidget(widgetType);
            
            // Hide widget options
            widgetOptions.style.display = 'none';
            widgetPlusIcon.style.transform = 'rotate(0deg)';
            isWidgetOptionsVisible = false;
        });
    });

    // Create layout from modal selection
    function createLayoutFromModal(layoutType) {
        // Remove placeholder
        const placeholder = canvasArea.querySelector('.canvas-placeholder');
        if (placeholder) {
            placeholder.remove();
        }

        let layoutHTML = '';
        
        switch(layoutType) {
            case 'single-column-down':
            case 'single-column-right':
                layoutHTML = `
                    <div class="layout-template single-column-layout active">
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Drop content here</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-equal-columns':
                layoutHTML = `
                    <div class="layout-template two-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-unequal-left':
                layoutHTML = `
                    <div class="layout-template two-columns-unequal-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Main Content</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'three-equal-columns':
                layoutHTML = `
                    <div class="layout-template three-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="center">
                            <div class="drop-placeholder">Center Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'three-unequal-middle':
                layoutHTML = `
                    <div class="layout-template three-columns-unequal-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Main Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Sidebar</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'four-squares':
                layoutHTML = `
                    <div class="layout-template four-squares-layout active">
                        <div class="layout-section drop-zone" data-section="top-left">
                            <div class="drop-placeholder">Top Left</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="top-right">
                            <div class="drop-placeholder">Top Right</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-left">
                            <div class="drop-placeholder">Bottom Left</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-right">
                            <div class="drop-placeholder">Bottom Right</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'top-single-bottom-two':
                layoutHTML = `
                    <div class="layout-template top-single-bottom-two-layout active">
                        <div class="layout-section drop-zone" data-section="header">
                            <div class="drop-placeholder">Header</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'left-tall-right-two':
                layoutHTML = `
                    <div class="layout-template left-tall-right-two-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="top-content">
                            <div class="drop-placeholder">Top Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-content">
                            <div class="drop-placeholder">Bottom Content</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'left-tall-middle-two-right-tall':
                layoutHTML = `
                    <div class="layout-template left-tall-middle-two-right-tall-layout active">
                        <div class="layout-section drop-zone" data-section="left-sidebar">
                            <div class="drop-placeholder">Left Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="top-content">
                            <div class="drop-placeholder">Top Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-content">
                            <div class="drop-placeholder">Bottom Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right-sidebar">
                            <div class="drop-placeholder">Right Sidebar</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'top-two-bottom-single':
                layoutHTML = `
                    <div class="layout-template top-two-bottom-single-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="footer">
                            <div class="drop-placeholder">Footer</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'top-single-middle-two-bottom-single':
                layoutHTML = `
                    <div class="layout-template top-single-middle-two-bottom-single-layout active">
                        <div class="layout-section drop-zone" data-section="header">
                            <div class="drop-placeholder">Header</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="footer">
                            <div class="drop-placeholder">Footer</div>
                        </div>
                    </div>
                `;
                break;
        }
        
        canvasArea.innerHTML = layoutHTML;
        
        // Setup drop zones for the new layout
        setupLayoutDropZones();
        
        // Save to history
        saveToHistory();
    }

    // Create layout from sidebar drag
    function createLayoutFromSidebar(layoutType) {
        // Remove placeholder
        const placeholder = canvasArea.querySelector('.canvas-placeholder');
        if (placeholder) {
            placeholder.remove();
        }

        let layoutHTML = '';
        
        switch(layoutType) {
            case 'single-column':
                layoutHTML = `
                    <div class="layout-template single-column-layout active">
                        <div class="layout-section drop-zone" data-section="content">
                            <div class="width-controls">
                                <button class="width-btn" data-width="25">25%</button>
                                <button class="width-btn" data-width="50">50%</button>
                                <button class="width-btn active" data-width="100">100%</button>
                            </div>
                            <div class="padding-controls">
                                <button class="padding-btn" data-padding="small">S</button>
                                <button class="padding-btn active" data-padding="medium">M</button>
                                <button class="padding-btn" data-padding="large">L</button>
                                <button class="padding-btn" data-padding="extra-large">XL</button>
                            </div>
                            <div class="drop-placeholder">Content Area</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-columns':
                layoutHTML = `
                    <div class="layout-template two-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'three-columns':
                layoutHTML = `
                    <div class="layout-template three-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="center">
                            <div class="drop-placeholder">Center Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'four-columns':
                layoutHTML = `
                    <div class="layout-template four-columns-layout active">
                        <div class="layout-section drop-zone" data-section="col1">
                            <div class="drop-placeholder">Column 1</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="col2">
                            <div class="drop-placeholder">Column 2</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="col3">
                            <div class="drop-placeholder">Column 3</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="col4">
                            <div class="drop-placeholder">Column 4</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-unequal':
                layoutHTML = `
                    <div class="layout-template two-unequal-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Main Content</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'header-content-footer':
                layoutHTML = `
                    <div class="layout-template header-content-footer-layout active">
                        <div class="layout-section drop-zone" data-section="header">
                            <div class="drop-placeholder">Header</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="content">
                            <div class="drop-placeholder">Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="footer">
                            <div class="drop-placeholder">Footer</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'sidebar-content':
                layoutHTML = `
                    <div class="layout-template sidebar-content-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="content">
                            <div class="drop-placeholder">Main Content</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'grid-2x2':
                layoutHTML = `
                    <div class="layout-template grid-2x2-layout active">
                        <div class="layout-section drop-zone" data-section="top-left">
                            <div class="drop-placeholder">Top Left</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="top-right">
                            <div class="drop-placeholder">Top Right</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-left">
                            <div class="drop-placeholder">Bottom Left</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="bottom-right">
                            <div class="drop-placeholder">Bottom Right</div>
                        </div>
                    </div>
                `;
                break;
        }
        
        canvasArea.innerHTML = layoutHTML;
        
        // Setup drop zones for the new layout
        setupLayoutDropZones();
        
        // Setup layout controls
        setupLayoutControls();
        
        // Save to history
        saveToHistory();
        
        showNotification(`Layout "${layoutType.replace('-', ' ')}" created successfully!`, 'success');
    }

    // Create layout based on selected type
    function createLayout(layoutType) {
        // Remove placeholder
        const placeholder = canvasArea.querySelector('.canvas-placeholder');
        if (placeholder) {
            placeholder.remove();
        }

        let layoutHTML = '';
        
        switch(layoutType) {
            case 'back-to-start':
                // Reset to original placeholder
                canvasArea.innerHTML = `
                    <div class="canvas-placeholder">
                        <div class="layout-selector-container">
                            <div class="layout-plus-icon" id="layoutPlusIcon">
                                <i class="ri-add-line"></i>
                            </div>
                            <div class="layout-options" id="layoutOptions" style="display: none;">
                                <div class="layout-grid">
                                    <div class="layout-option" data-layout="single-column">
                                        <div class="layout-preview">
                                            <div class="preview-column"></div>
                                        </div>
                                        <span>Single Column</span>
                                    </div>
                                    <div class="layout-option" data-layout="two-columns">
                                        <div class="layout-preview">
                                            <div class="preview-column"></div>
                                            <div class="preview-column"></div>
                                        </div>
                                        <span>Two Columns</span>
                                    </div>
                                    <div class="layout-option" data-layout="three-columns">
                                        <div class="layout-preview">
                                            <div class="preview-column"></div>
                                            <div class="preview-column"></div>
                                            <div class="preview-column"></div>
                                        </div>
                                        <span>Three Columns</span>
                                    </div>
                                    <div class="layout-option" data-layout="two-columns-unequal">
                                        <div class="layout-preview">
                                            <div class="preview-column small"></div>
                                            <div class="preview-column large"></div>
                                        </div>
                                        <span>Two Columns (Unequal)</span>
                                    </div>
                                    <div class="layout-option" data-layout="header-content-footer">
                                        <div class="layout-preview">
                                            <div class="preview-row header"></div>
                                            <div class="preview-row content"></div>
                                            <div class="preview-row footer"></div>
                                        </div>
                                        <span>Header/Content/Footer</span>
                                    </div>
                                    <div class="layout-option" data-layout="sidebar-content">
                                        <div class="layout-preview">
                                            <div class="preview-column sidebar"></div>
                                            <div class="preview-column main"></div>
                                        </div>
                                        <span>Sidebar + Content</span>
                                    </div>
                                    <div class="layout-option" data-layout="back-to-start">
                                        <div class="layout-preview">
                                            <div class="preview-column" style="background: #6c757d;"></div>
                                        </div>
                                        <span>Back to Start</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Start Building Your Page</h4>
                        <p>Click the + icon to choose a layout or drag widgets from the sidebar</p>
                        <div class="device-info">
                            <small>Desktop View - Full Width</small>
                        </div>
                    </div>
                `;
                
                // Reattach event listeners
                reattachLayoutEventListeners();
                saveToHistory();
                return;
                
            case 'single-column':
                layoutHTML = `
                    <div class="layout-template single-column-layout active">
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Drop content here</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-columns':
                layoutHTML = `
                    <div class="layout-template two-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'three-columns':
                layoutHTML = `
                    <div class="layout-template three-columns-layout active">
                        <div class="layout-section drop-zone" data-section="left">
                            <div class="drop-placeholder">Left Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="center">
                            <div class="drop-placeholder">Center Column</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="right">
                            <div class="drop-placeholder">Right Column</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'two-columns-unequal':
                layoutHTML = `
                    <div class="layout-template two-columns-unequal-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="main">
                            <div class="drop-placeholder">Main Content</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'header-content-footer':
                layoutHTML = `
                    <div class="layout-template header-content-footer-layout active">
                        <div class="layout-section drop-zone" data-section="header">
                            <div class="drop-placeholder">Header</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="content">
                            <div class="drop-placeholder">Content</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="footer">
                            <div class="drop-placeholder">Footer</div>
                        </div>
                    </div>
                `;
                break;
                
            case 'sidebar-content':
                layoutHTML = `
                    <div class="layout-template sidebar-content-layout active">
                        <div class="layout-section drop-zone" data-section="sidebar">
                            <div class="drop-placeholder">Sidebar</div>
                        </div>
                        <div class="layout-section drop-zone" data-section="content">
                            <div class="drop-placeholder">Content</div>
                        </div>
                    </div>
                `;
                break;
        }
        
        canvasArea.innerHTML = layoutHTML;
        
        // Setup drop zones for the new layout
        setupLayoutDropZones();
        
        // Save to history
        saveToHistory();
    }

    // Setup layout controls (width and padding)
    function setupLayoutControls() {
        // Width controls
        document.querySelectorAll('.width-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const section = this.closest('.layout-section');
                const width = this.dataset.width;
                
                // Remove active class from all width buttons in this section
                section.querySelectorAll('.width-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Apply width class
                section.className = section.className.replace(/width-\d+/g, '');
                section.classList.add(`width-${width}`);
                
                showNotification(`Width set to ${width}%`, 'success');
            });
        });
        
        // Padding controls
        document.querySelectorAll('.padding-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const section = this.closest('.layout-section');
                const padding = this.dataset.padding;
                
                // Remove active class from all padding buttons in this section
                section.querySelectorAll('.padding-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Apply padding class
                section.className = section.className.replace(/layout-(small|medium|large|extra-large)/g, '');
                section.classList.add(`layout-${padding}`);
                
                showNotification(`Padding set to ${padding}`, 'success');
            });
        });
    }

    // Setup drop zones for layout sections
    function setupLayoutDropZones() {
        document.querySelectorAll('.layout-section').forEach(section => {
            section.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('drag-over');
            });

            section.addEventListener('dragleave', function(e) {
                if (!this.contains(e.relatedTarget)) {
                    this.classList.remove('drag-over');
                }
            });

            section.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');
                
                const data = e.dataTransfer.getData('text/plain');
                const parts = data.split(':');
                const widgetType = parts[0];
                const contentTypeSlug = parts[1];
                
                addWidgetToLayoutSection(this, widgetType, contentTypeSlug);
            });
        });
    }

    // Add widget to layout section
    function addWidgetToLayoutSection(section, type, contentTypeSlug = null) {
        const elementId = 'element_' + (++elementCounter);
        let template = widgetTemplates[type];
        
        // Handle content type widgets
        if (type === 'content-type' && contentTypeSlug) {
            const contentType = contentTypes.find(ct => ct.slug === contentTypeSlug);
            if (contentType) {
                template = contentType.component_html || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentType.name + '</div>';
            } else {
                // Sample content type templates
                const sampleContentTypes = {
                    'blog-post': '<div class="blog-post" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;"><h3 style="color: #333; margin-bottom: 10px;">Blog Post Title</h3><p style="color: #666; margin-bottom: 15px;">Blog post excerpt goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #999; font-size: 14px;">By Author Name</span><span style="color: #999; font-size: 14px;">Dec 15, 2023</span></div></div>',
                    'product': '<div class="product" style="margin: 10px 0; padding: 15px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/200x150" alt="Product" style="width: 100%; max-width: 200px; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Product Name</h4><p style="color: #666; margin-bottom: 15px;">Product description goes here...</p><div style="font-size: 1.5rem; font-weight: bold; color: #28a745;">$99.99</div></div>',
                    'team-member': '<div class="team-member" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;"><img src="https://via.placeholder.com/150x150" alt="Team Member" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 5px;">John Doe</h4><p style="color: #666; margin-bottom: 10px;">CEO & Founder</p><p style="color: #999; font-size: 14px;">Team member bio goes here...</p></div>',
                    'testimonial': '<div class="testimonial" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; text-align: center;"><div style="font-size: 1.2rem; color: #333; margin-bottom: 15px; font-style: italic;">"This is an amazing testimonial from our satisfied customer."</div><div style="display: flex; align-items: center; justify-content: center; gap: 10px;"><img src="https://via.placeholder.com/50x50" alt="Customer" style="width: 50px; height: 50px; border-radius: 50%;"><div><div style="font-weight: 500; color: #333;">Jane Smith</div><div style="color: #666; font-size: 14px;">Customer</div></div></div></div>',
                    'portfolio': '<div class="portfolio" style="margin: 10px 0; padding: 15px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px;"><img src="https://via.placeholder.com/300x200" alt="Portfolio" style="width: 100%; height: auto; border-radius: 6px; margin-bottom: 15px;"><h4 style="color: #333; margin-bottom: 10px;">Project Title</h4><p style="color: #666; margin-bottom: 15px;">Project description goes here...</p><div style="display: flex; gap: 10px;"><span style="background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Web Design</span><span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Development</span></div></div>',
                    'event': '<div class="event" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;"><h4 style="color: #333; margin-bottom: 10px;">Event Title</h4><p style="color: #666; margin-bottom: 15px;">Event description goes here...</p><div style="display: flex; justify-content: space-between; align-items: center;"><span style="color: #007bff; font-weight: 500;">Dec 25, 2023</span><span style="color: #666;">2:00 PM - 4:00 PM</span></div></div>'
                };
                template = sampleContentTypes[contentTypeSlug] || '<div class="content-type-placeholder" style="padding: 20px; border: 2px dashed #dee2e6; text-align: center; color: #6c757d;">Content Type: ' + contentTypeSlug + '</div>';
            }
        }
        
        if (template) {
            // Create the widget element
            const elementDiv = document.createElement('div');
            elementDiv.className = 'builder-element nested-element';
            elementDiv.id = elementId;
            elementDiv.dataset.type = type;
            if (contentTypeSlug) {
                elementDiv.dataset.contentType = contentTypeSlug;
            }
            elementDiv.innerHTML = `
                <div class="element-actions">
                    <button class="btn btn-edit" onclick="editElement('${elementId}')">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-duplicate" onclick="duplicateElement('${elementId}')">
                        <i class="ri-file-copy-line"></i>
                    </button>
                    <button class="btn btn-delete" onclick="deleteElement('${elementId}')">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
                ${template}
            `;
            
            // Hide placeholder text
            const placeholder = section.querySelector('.drop-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
            
            // Add to section
            section.appendChild(elementDiv);
            
            // Add click handler for selection
            elementDiv.addEventListener('click', function(e) {
                e.stopPropagation();
                selectElement(this);
            });

            // Setup inline editing and uploads
            setupInlineEditing(elementDiv);

            // Save to history
            saveToHistory();
        }
    }

    // Reattach layout event listeners
    function reattachLayoutEventListeners() {
        // Reattach layout plus icon click
        const newLayoutPlusIcon = document.getElementById('layoutPlusIcon');
        const newLayoutOptions = document.getElementById('layoutOptions');
        
        if (newLayoutPlusIcon && newLayoutOptions) {
            newLayoutPlusIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                isLayoutOptionsVisible = !isLayoutOptionsVisible;
                
                if (isLayoutOptionsVisible) {
                    newLayoutOptions.style.display = 'block';
                    newLayoutPlusIcon.style.transform = 'rotate(45deg)';
                } else {
                    newLayoutOptions.style.display = 'none';
                    newLayoutPlusIcon.style.transform = 'rotate(0deg)';
                }
            });
        }
        
        // Reattach widget plus icon click
        const newWidgetPlusIcon = document.getElementById('widgetPlusIcon');
        const newWidgetOptions = document.getElementById('widgetOptions');
        
        if (newWidgetPlusIcon && newWidgetOptions) {
            newWidgetPlusIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                isWidgetOptionsVisible = !isWidgetOptionsVisible;
                
                if (isWidgetOptionsVisible) {
                    newWidgetOptions.style.display = 'block';
                    newWidgetPlusIcon.style.transform = 'rotate(45deg)';
                } else {
                    newWidgetOptions.style.display = 'none';
                    newWidgetPlusIcon.style.transform = 'rotate(0deg)';
                }
            });
        }
        
        // Reattach layout option clicks
        document.querySelectorAll('.layout-option').forEach(option => {
            option.addEventListener('click', function() {
                const layoutType = this.dataset.layout;
                createLayout(layoutType);
                
                // Hide layout options
                if (newLayoutOptions) {
                    newLayoutOptions.style.display = 'none';
                }
                if (newLayoutPlusIcon) {
                    newLayoutPlusIcon.style.transform = 'rotate(0deg)';
                }
                isLayoutOptionsVisible = false;
            });
        });

        // Reattach widget option clicks
        document.querySelectorAll('.widget-option').forEach(option => {
            option.addEventListener('click', function() {
                const widgetType = this.dataset.widget;
                addWidget(widgetType);
                
                // Hide widget options
                if (newWidgetOptions) {
                    newWidgetOptions.style.display = 'none';
                }
                if (newWidgetPlusIcon) {
                    newWidgetPlusIcon.style.transform = 'rotate(0deg)';
                }
                isWidgetOptionsVisible = false;
            });
        });
    }

    // Notification System
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create new notification
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Initialize with empty state
    saveToHistory();
});

// Templates Integration
let selectedTemplateId = null;
let currentFilter = 'all';

// Pre-built templates data
const preBuiltTemplates = [
    {
        id: 1,
        name: 'Business Landing Page',
        description: 'Professional business landing page with hero section, features, and contact form',
        category: 'business',
        thumbnail: 'https://picsum.photos/400/300?random=1',
        content: `
            <div class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 20px; text-align: center;">
                <h1 style="font-size: 3rem; margin-bottom: 20px;">Next Generation Website Builder</h1>
                <p style="font-size: 1.2rem; margin-bottom: 30px;">Build stunning websites with our drag-and-drop page builder</p>
                <button class="btn btn-primary btn-lg">Get Started</button>
            </div>
            <div class="features-section" style="padding: 60px 20px; background: #f8f9fa;">
                <div class="container">
                    <h2 style="text-align: center; margin-bottom: 40px;">Features</h2>
                    <div class="row">
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <i class="ri-drag-drop-line" style="font-size: 3rem; color: #007bff; margin-bottom: 15px;"></i>
                            <h4>Drag & Drop</h4>
                            <p>Easy drag and drop interface</p>
                        </div>
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <i class="ri-responsive-line" style="font-size: 3rem; color: #007bff; margin-bottom: 15px;"></i>
                            <h4>Responsive</h4>
                            <p>Mobile-first responsive design</p>
                        </div>
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <i class="ri-palette-line" style="font-size: 3rem; color: #007bff; margin-bottom: 15px;"></i>
                            <h4>Customizable</h4>
                            <p>Fully customizable templates</p>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 2,
        name: 'Portfolio Showcase',
        description: 'Creative portfolio template with project gallery and about section',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=2',
        content: `
            <div class="hero-section" style="background: #1a1a1a; color: white; padding: 100px 20px; text-align: center;">
                <h1 style="font-size: 4rem; margin-bottom: 20px;">Creative Portfolio</h1>
                <p style="font-size: 1.3rem; margin-bottom: 30px;">Showcasing creative work and projects</p>
            </div>
            <div class="projects-section" style="padding: 60px 20px;">
                <div class="container">
                    <h2 style="text-align: center; margin-bottom: 40px;">Featured Projects</h2>
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <img src="https://picsum.photos/300/200?random=3" alt="Project 1" style="width: 100%; border-radius: 4px; margin-bottom: 15px;">
                                <h4>Project 1</h4>
                                <p>Description of the project</p>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <img src="https://picsum.photos/300/200?random=4" alt="Project 2" style="width: 100%; border-radius: 4px; margin-bottom: 15px;">
                                <h4>Project 2</h4>
                                <p>Description of the project</p>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <img src="https://picsum.photos/300/200?random=5" alt="Project 3" style="width: 100%; border-radius: 4px; margin-bottom: 15px;">
                                <h4>Project 3</h4>
                                <p>Description of the project</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 3,
        name: 'Blog Homepage',
        description: 'Clean blog template with featured posts and sidebar',
        category: 'blog',
        thumbnail: 'https://picsum.photos/400/300?random=6',
        content: `
            <div class="blog-header" style="background: #007bff; color: white; padding: 60px 20px; text-align: center;">
                <h1 style="font-size: 3rem; margin-bottom: 20px;">My Blog</h1>
                <p style="font-size: 1.2rem;">Sharing thoughts and insights</p>
            </div>
            <div class="blog-content" style="padding: 40px 20px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="blog-post" style="margin-bottom: 40px; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px;">
                                <img src="https://picsum.photos/600/300?random=7" alt="Blog Post" style="width: 100%; border-radius: 4px; margin-bottom: 20px;">
                                <h2>Featured Blog Post</h2>
                                <p style="color: #6c757d; margin-bottom: 15px;">Published on January 15, 2024</p>
                                <p>This is a sample blog post content. You can edit this text and add your own content here.</p>
                                <button class="btn btn-primary">Read More</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                                <h4>Recent Posts</h4>
                                <ul style="list-style: none; padding: 0;">
                                    <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none;">Recent Post 1</a></li>
                                    <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none;">Recent Post 2</a></li>
                                    <li style="margin-bottom: 10px;"><a href="#" style="text-decoration: none;">Recent Post 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 4,
        name: 'E-commerce Store',
        description: 'Online store template with product showcase and shopping cart',
        category: 'ecommerce',
        thumbnail: 'https://picsum.photos/400/300?random=8',
        content: `
            <div class="store-header" style="background: #28a745; color: white; padding: 40px 20px; text-align: center;">
                <h1 style="font-size: 3rem; margin-bottom: 20px;">Online Store</h1>
                <p style="font-size: 1.2rem;">Quality products at great prices</p>
            </div>
            <div class="products-section" style="padding: 60px 20px;">
                <div class="container">
                    <h2 style="text-align: center; margin-bottom: 40px;">Featured Products</h2>
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/250/200?random=9" alt="Product 1" style="width: 100%;">
                                <div style="padding: 15px;">
                                    <h5>Product 1</h5>
                                    <p style="color: #28a745; font-weight: bold;">$29.99</p>
                                    <button class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/250/200?random=10" alt="Product 2" style="width: 100%;">
                                <div style="padding: 15px;">
                                    <h5>Product 2</h5>
                                    <p style="color: #28a745; font-weight: bold;">$39.99</p>
                                    <button class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/250/200?random=11" alt="Product 3" style="width: 100%;">
                                <div style="padding: 15px;">
                                    <h5>Product 3</h5>
                                    <p style="color: #28a745; font-weight: bold;">$49.99</p>
                                    <button class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/250/200?random=12" alt="Product 4" style="width: 100%;">
                                <div style="padding: 15px;">
                                    <h5>Product 4</h5>
                                    <p style="color: #28a745; font-weight: bold;">$59.99</p>
                                    <button class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 5,
        name: 'Landing Page',
        description: 'High-converting landing page with call-to-action and testimonials',
        category: 'landing',
        thumbnail: 'https://picsum.photos/400/300?random=13',
        content: `
            <div class="hero-section" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; padding: 100px 20px; text-align: center;">
                <h1 style="font-size: 4rem; margin-bottom: 20px;">Transform Your Business</h1>
                <p style="font-size: 1.3rem; margin-bottom: 30px;">Join thousands of satisfied customers</p>
                <button class="btn btn-light btn-lg" style="margin-right: 15px;">Get Started Now</button>
                <button class="btn btn-outline-light btn-lg">Learn More</button>
            </div>
            <div class="testimonials-section" style="padding: 80px 20px; background: #f8f9fa;">
                <div class="container">
                    <h2 style="text-align: center; margin-bottom: 50px;">What Our Customers Say</h2>
                    <div class="row">
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <p style="font-style: italic; margin-bottom: 20px;">"This service changed our business completely!"</p>
                                <h5>John Doe</h5>
                                <small>CEO, Company Inc.</small>
                            </div>
                        </div>
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <p style="font-style: italic; margin-bottom: 20px;">"Amazing results in just 30 days!"</p>
                                <h5>Jane Smith</h5>
                                <small>Marketing Director</small>
                            </div>
                        </div>
                        <div class="col-md-4" style="text-align: center; padding: 20px;">
                            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <p style="font-style: italic; margin-bottom: 20px;">"Best investment we ever made!"</p>
                                <h5>Mike Johnson</h5>
                                <small>Business Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 6,
        name: 'Testimonials Section',
        description: 'Customer testimonials with quotes, names, and photos',
        category: 'business',
        thumbnail: 'https://picsum.photos/400/300?random=14',
        content: `
            <div class="testimonials-section" style="padding: 80px 20px; background: #f8f9fa;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #333;">What Our Customers Say</h2>
                        <p style="font-size: 1.1rem; color: #6c757d; max-width: 600px; margin: 0 auto;">Don't just take our word for it. Here's what our satisfied customers have to say about our services.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; height: 100%;">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: #007bff; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">JD</div>
                                <p style="font-style: italic; margin-bottom: 20px; color: #555; line-height: 1.6;">"This service completely transformed our business. The results were amazing and exceeded our expectations!"</p>
                                <h5 style="margin: 0; color: #333;">John Doe</h5>
                                <small style="color: #6c757d;">CEO, Tech Solutions Inc.</small>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; height: 100%;">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: #28a745; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">JS</div>
                                <p style="font-style: italic; margin-bottom: 20px; color: #555; line-height: 1.6;">"Outstanding service and support. The team went above and beyond to deliver exactly what we needed."</p>
                                <h5 style="margin: 0; color: #333;">Jane Smith</h5>
                                <small style="color: #6c757d;">Marketing Director, Creative Agency</small>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; height: 100%;">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: #ffc107; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">MJ</div>
                                <p style="font-style: italic; margin-bottom: 20px; color: #555; line-height: 1.6;">"Professional, reliable, and results-driven. I would definitely recommend their services to anyone."</p>
                                <h5 style="margin: 0; color: #333;">Mike Johnson</h5>
                                <small style="color: #6c757d;">Business Owner, Johnson Enterprises</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 7,
        name: 'Hero Banner Section',
        description: 'Eye-catching hero banner with image, text, and call-to-action button',
        category: 'landing',
        thumbnail: 'https://picsum.photos/400/300?random=15',
        content: `
            <div class="hero-banner" style="background: linear-gradient(135deg, rgba(0,123,255,0.8) 0%, rgba(102,126,234,0.8) 100%), url('https://picsum.photos/1200/600?random=16'); background-size: cover; background-position: center; color: white; padding: 100px 20px; text-align: center; position: relative;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h1 style="font-size: 4rem; margin-bottom: 20px; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Transform Your Business Today</h1>
                            <p style="font-size: 1.3rem; margin-bottom: 30px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3); line-height: 1.6;">Join thousands of satisfied customers who have revolutionized their business with our innovative solutions and expert support.</p>
                            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                <button class="btn btn-light btn-lg" style="padding: 15px 30px; font-size: 1.1rem; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Get Started Now</button>
                                <button class="btn btn-outline-light btn-lg" style="padding: 15px 30px; font-size: 1.1rem; font-weight: 600; border-radius: 8px; border: 2px solid white;">Learn More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 8,
        name: 'Product Banner Section',
        description: 'Product showcase banner with image, features, and pricing',
        category: 'ecommerce',
        thumbnail: 'https://picsum.photos/400/300?random=17',
        content: `
            <div class="product-banner" style="background: #ffffff; padding: 80px 20px; border-bottom: 1px solid #dee2e6;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="https://picsum.photos/500/400?random=18" alt="Featured Product" style="width: 100%; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                        </div>
                        <div class="col-md-6" style="padding-left: 40px;">
                            <h2 style="font-size: 3rem; margin-bottom: 20px; color: #333; font-weight: 700;">Premium Quality Product</h2>
                            <p style="font-size: 1.2rem; margin-bottom: 25px; color: #6c757d; line-height: 1.6;">Experience the difference with our premium quality product designed to meet all your needs with exceptional performance and reliability.</p>
                            <div style="margin-bottom: 30px;">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="ri-check-line" style="color: #28a745; font-size: 1.2rem; margin-right: 10px;"></i>
                                    <span style="color: #333;">High-quality materials</span>
                                </div>
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="ri-check-line" style="color: #28a745; font-size: 1.2rem; margin-right: 10px;"></i>
                                    <span style="color: #333;">30-day money-back guarantee</span>
                                </div>
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="ri-check-line" style="color: #28a745; font-size: 1.2rem; margin-right: 10px;"></i>
                                    <span style="color: #333;">Free shipping worldwide</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                <span style="font-size: 2.5rem; font-weight: 700; color: #007bff;">$99.99</span>
                                <span style="font-size: 1.2rem; color: #6c757d; text-decoration: line-through;">$149.99</span>
                                <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">33% OFF</span>
                            </div>
                            <button class="btn btn-primary btn-lg" style="margin-top: 25px; padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border-radius: 8px;">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 9,
        name: 'Service Banner Section',
        description: 'Service showcase banner with icon, description, and contact button',
        category: 'business',
        thumbnail: 'https://picsum.photos/400/300?random=19',
        content: `
            <div class="service-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 20px; text-align: center;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="ri-service-line" style="font-size: 3rem; color: white;"></i>
                            </div>
                            <h2 style="font-size: 3.5rem; margin-bottom: 25px; font-weight: 700;">Professional Services</h2>
                            <p style="font-size: 1.3rem; margin-bottom: 40px; opacity: 0.9; line-height: 1.6; max-width: 600px; margin-left: auto; margin-right: auto;">We provide comprehensive business solutions tailored to your specific needs. Our expert team delivers exceptional results that drive growth and success.</p>
                            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 40px;">
                                <div style="text-align: center;">
                                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">500+</div>
                                    <div style="font-size: 1rem; opacity: 0.8;">Happy Clients</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">1000+</div>
                                    <div style="font-size: 1rem; opacity: 0.8;">Projects Completed</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">5+</div>
                                    <div style="font-size: 1rem; opacity: 0.8;">Years Experience</div>
                                </div>
                            </div>
                            <button class="btn btn-light btn-lg" style="padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Get Free Consultation</button>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 10,
        name: 'Portfolio Grid - 2x2',
        description: 'Portfolio showcase with 2x2 grid layout and project titles',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=20',
        content: `
            <div class="portfolio-section" style="padding: 80px 20px; background: #ffffff;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #333; font-weight: 700;">Check Out Our Work</h2>
                        <p style="font-size: 1.1rem; color: #6c757d; max-width: 600px; margin: 0 auto;">Explore our portfolio of creative projects and innovative solutions.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                <img src="https://picsum.photos/400/300?random=21" alt="Project 1" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px; color: white;">
                                    <h5 style="margin: 0; font-size: 1.2rem;">Inception of Kix</h5>
                                    <p style="margin: 5px 0 0; opacity: 0.9; font-size: 0.9rem;">Brand Identity Design</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                <img src="https://picsum.photos/400/300?random=22" alt="Project 2" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px; color: white;">
                                    <h5 style="margin: 0; font-size: 1.2rem;">Flow of Kix</h5>
                                    <p style="margin: 5px 0 0; opacity: 0.9; font-size: 0.9rem;">Web Design</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                <img src="https://picsum.photos/400/300?random=23" alt="Project 3" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px; color: white;">
                                    <h5 style="margin: 0; font-size: 1.2rem;">Landing Page Store</h5>
                                    <p style="margin: 5px 0 0; opacity: 0.9; font-size: 0.9rem;">E-commerce Design</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                <img src="https://picsum.photos/400/300?random=24" alt="Project 4" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 20px; color: white;">
                                    <h5 style="margin: 0; font-size: 1.2rem;">Poster Maps</h5>
                                    <p style="margin: 5px 0 0; opacity: 0.9; font-size: 0.9rem;">Print Design</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 11,
        name: 'Portfolio Horizontal Row',
        description: 'Portfolio showcase with horizontal row of projects',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=25',
        content: `
            <div class="portfolio-horizontal" style="padding: 80px 20px; background: #f8f9fa;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #333; font-weight: 700;">Check Out Our Work</h2>
                        <p style="font-size: 1.1rem; color: #6c757d; max-width: 600px; margin: 0 auto;">Discover our latest creative projects and innovative solutions.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                <img src="https://picsum.photos/400/250?random=26" alt="Project 1" style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h5 style="margin: 0 0 10px; color: #333;">Architectural Vision</h5>
                                    <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">Modern architecture photography</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                <img src="https://picsum.photos/400/250?random=27" alt="Project 2" style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h5 style="margin: 0 0 10px; color: #333;">Abstract Flow</h5>
                                    <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">Liquid art and abstract design</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                <img src="https://picsum.photos/400/250?random=28" alt="Project 3" style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h5 style="margin: 0 0 10px; color: #333;">Creative Splash</h5>
                                    <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">Dynamic visual effects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 12,
        name: 'Portfolio Featured + Thumbnails',
        description: 'Portfolio with large featured project and thumbnail gallery',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=29',
        content: `
            <div class="portfolio-featured" style="padding: 80px 20px; background: #ffffff;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #333; font-weight: 700;">Check Out Our Work</h2>
                        <p style="font-size: 1.1rem; color: #6c757d; max-width: 600px; margin: 0 auto;">Featured projects and creative portfolio showcase.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                <img src="https://picsum.photos/800/500?random=30" alt="Featured Project" style="width: 100%; height: 400px; object-fit: cover;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 30px; color: white;">
                                    <h3 style="margin: 0 0 10px; font-size: 1.8rem;">Featured Project</h3>
                                    <p style="margin: 0; opacity: 0.9;">A showcase of our best creative work and innovative design solutions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding-left: 30px;">
                                <h4 style="color: #333; margin-bottom: 20px;">Recent Projects</h4>
                                <div style="display: flex; flex-direction: column; gap: 15px;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="https://picsum.photos/80/60?random=31" alt="Thumb 1" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 style="margin: 0; color: #333;">Project Alpha</h6>
                                            <small style="color: #6c757d;">Brand Design</small>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="https://picsum.photos/80/60?random=32" alt="Thumb 2" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 style="margin: 0; color: #333;">Project Beta</h6>
                                            <small style="color: #6c757d;">Web Development</small>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="https://picsum.photos/80/60?random=33" alt="Thumb 3" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 style="margin: 0; color: #333;">Project Gamma</h6>
                                            <small style="color: #6c757d;">Mobile App</small>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="https://picsum.photos/80/60?random=34" alt="Thumb 4" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 style="margin: 0; color: #333;">Project Delta</h6>
                                            <small style="color: #6c757d;">UI/UX Design</small>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="https://picsum.photos/80/60?random=35" alt="Thumb 5" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 style="margin: 0; color: #333;">Project Epsilon</h6>
                                            <small style="color: #6c757d;">Print Design</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 13,
        name: 'Portfolio Dark Theme',
        description: 'Portfolio with dark background and light text',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=36',
        content: `
            <div class="portfolio-dark" style="padding: 80px 20px; background: #1a1a1a; color: white;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: white; font-weight: 700;">Check Out Our Work</h2>
                        <p style="font-size: 1.1rem; color: #cccccc; max-width: 600px; margin: 0 auto;">Explore our creative portfolio with a modern dark theme.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="background: #2a2a2a; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.3);">
                                <img src="https://picsum.photos/400/300?random=37" alt="Project 1" style="width: 100%; height: 250px; object-fit: cover;">
                                <div style="padding: 25px;">
                                    <h5 style="margin: 0 0 10px; color: white;">Creative Vision</h5>
                                    <p style="color: #cccccc; font-size: 0.9rem; margin: 0 0 15px;">Innovative design solutions for modern businesses.</p>
                                    <button style="background: #007bff; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-size: 0.9rem; cursor: pointer;">View Project</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 30px;">
                            <div style="background: #2a2a2a; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.3);">
                                <img src="https://picsum.photos/400/300?random=38" alt="Project 2" style="width: 100%; height: 250px; object-fit: cover;">
                                <div style="padding: 25px;">
                                    <h5 style="margin: 0 0 10px; color: white;">Digital Art</h5>
                                    <p style="color: #cccccc; font-size: 0.9rem; margin: 0 0 15px;">Abstract digital art and creative expressions.</p>
                                    <button style="background: #007bff; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-size: 0.9rem; cursor: pointer;">View Project</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    },
    {
        id: 14,
        name: 'Portfolio Minimalist',
        description: 'Clean minimalist portfolio with simple layout',
        category: 'portfolio',
        thumbnail: 'https://picsum.photos/400/300?random=39',
        content: `
            <div class="portfolio-minimal" style="padding: 80px 20px; background: #ffffff;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #333; font-weight: 300;">Check Out Our Work</h2>
                        <p style="font-size: 1.1rem; color: #6c757d; max-width: 500px; margin: 0 auto;">Minimalist approach to creative portfolio presentation.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 40px;">
                            <div style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/400/250?random=40" alt="Project 1" style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px; text-align: center;">
                                    <h5 style="margin: 0 0 5px; color: #333; font-weight: 400;">Minimal Design</h5>
                                    <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">Clean and simple</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 40px;">
                            <div style="border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden;">
                                <img src="https://picsum.photos/400/250?random=41" alt="Project 2" style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px; text-align: center;">
                                    <h5 style="margin: 0 0 5px; color: #333; font-weight: 400;">Abstract Art</h5>
                                    <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">Creative expression</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    }
];

// Templates functionality
function openTemplatesModal() {
    loadTemplates();
    
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded. Please refresh the page.');
        // Fallback: show modal manually
        const modal = document.getElementById('templatesModal');
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        return;
    }
    
    new bootstrap.Modal(document.getElementById('templatesModal')).show();
}

function loadTemplates() {
    const templatesGrid = document.getElementById('templatesGrid');
    const savedTemplates = localStorage.getItem('customTemplates');
    let customTemplates = [];
    
    if (savedTemplates) {
        try {
            customTemplates = JSON.parse(savedTemplates);
        } catch (e) {
            console.error('Error loading custom templates:', e);
        }
    }
    
    const allTemplates = [...preBuiltTemplates, ...customTemplates];
    const filteredTemplates = currentFilter === 'all' ? allTemplates : allTemplates.filter(template => template.category === currentFilter);
    
    if (filteredTemplates.length === 0) {
        templatesGrid.innerHTML = `
            <div class="col-12 text-center py-4">
                <i class="ri-layout-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
                <h6>No templates found</h6>
                <p class="text-muted">Create your own template or check other categories</p>
            </div>
        `;
        return;
    }
    
    templatesGrid.innerHTML = filteredTemplates.map(template => `
        <div class="template-item" onclick="selectTemplate(${template.id})" style="cursor: pointer; border: 2px solid transparent; border-radius: 8px; overflow: hidden; transition: all 0.3s; position: relative;">
            <img src="${template.thumbnail}" alt="${template.name}" style="width: 100%; height: 200px; object-fit: cover;">
            <div style="padding: 15px; background: white;">
                <h6 style="margin: 0 0 5px 0; font-weight: 600;">${template.name}</h6>
                <p style="color: #6c757d; font-size: 0.9rem; margin: 0 0 10px 0;">${template.description}</p>
                <span style="background: #007bff; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem;">${template.category}</span>
                ${template.custom ? '<span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; margin-left: 5px;">Custom</span>' : ''}
            </div>
            <div class="selection-indicator" style="position: absolute; top: 10px; right: 10px; background: #007bff; color: white; border-radius: 50%; width: 25px; height: 25px; display: none; align-items: center; justify-content: center; font-size: 0.9rem;">
                <i class="ri-check-line"></i>
            </div>
        </div>
    `).join('');
}

function selectTemplate(templateId) {
    selectedTemplateId = templateId;
    
    // Update visual selection
    document.querySelectorAll('.template-item').forEach(item => {
        item.style.borderColor = 'transparent';
        item.style.transform = 'scale(1)';
        const indicator = item.querySelector('.selection-indicator');
        if (indicator) indicator.style.display = 'none';
    });
    
    const selectedItem = event.currentTarget;
    selectedItem.style.borderColor = '#007bff';
    selectedItem.style.transform = 'scale(1.02)';
    const indicator = selectedItem.querySelector('.selection-indicator');
    if (indicator) indicator.style.display = 'flex';
    
    // Enable import button
    document.getElementById('importTemplateBtn').disabled = false;
}

function initializeWidgets(container) {
    // Make all text elements editable
    container.querySelectorAll('h1, h2, h3, h4, h5, h6, p, span, div').forEach(element => {
        if (!element.hasAttribute('contenteditable')) {
            element.setAttribute('contenteditable', 'true');
            element.style.border = '2px dashed transparent';
            element.style.padding = '5px';
            element.style.borderRadius = '4px';
            element.style.cursor = 'text';
            element.style.minHeight = '20px';
        }
    });

    // Add hover effects for editable elements
    container.querySelectorAll('[contenteditable="true"]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.borderColor = '#007bff';
            this.style.backgroundColor = '#f8f9ff';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.borderColor = 'transparent';
            this.style.backgroundColor = 'transparent';
        });
    });

    // Make buttons clickable and editable
    container.querySelectorAll('button').forEach(button => {
        button.setAttribute('contenteditable', 'true');
        button.style.cursor = 'text';
        button.addEventListener('mouseenter', function() {
            this.style.borderColor = '#007bff';
        });
        button.addEventListener('mouseleave', function() {
            this.style.borderColor = 'transparent';
        });
    });

    // Make images editable (click to change)
    container.querySelectorAll('img').forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            openMediaLibrary(this);
        });
        img.addEventListener('mouseenter', function() {
            this.style.border = '2px dashed #007bff';
            this.style.borderRadius = '4px';
        });
        img.addEventListener('mouseleave', function() {
            this.style.border = '2px dashed transparent';
        });
    });

    // Add delete functionality to all elements
    container.querySelectorAll('*').forEach(element => {
        if (element.tagName !== 'BODY' && element.tagName !== 'HTML') {
            element.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (confirm('Delete this element?')) {
                    this.remove();
                    saveToHistory();
                }
            });
        }
    });

    // Add drag and drop for reordering
    container.querySelectorAll('*').forEach(element => {
        element.draggable = true;
        element.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', '');
            this.style.opacity = '0.5';
        });
        element.addEventListener('dragend', function(e) {
            this.style.opacity = '1';
        });
    });
}

function importTemplate() {
    if (!selectedTemplateId) return;
    
    const allTemplates = [...preBuiltTemplates];
    const savedTemplates = localStorage.getItem('customTemplates');
    if (savedTemplates) {
        try {
            allTemplates.push(...JSON.parse(savedTemplates));
        } catch (e) {
            console.error('Error loading custom templates:', e);
        }
    }
    
    const selectedTemplate = allTemplates.find(template => template.id === selectedTemplateId);
    if (selectedTemplate) {
        // Clear current canvas
        const canvasArea = document.getElementById('canvasArea');
        canvasArea.innerHTML = '';
        
        // Add template content
        canvasArea.innerHTML = selectedTemplate.content;
        
        // Re-initialize widgets
        initializeWidgets(canvasArea);
        
        // Save to history
        saveToHistory();
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('templatesModal')).hide();
        
        showNotification('Template imported successfully!', 'success');
    }
}

function filterTemplates(category) {
    currentFilter = category;
    
    // Update button states
    document.querySelectorAll('.template-categories .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.currentTarget.classList.add('active');
    
    loadTemplates();
}

function saveCurrentPageAsTemplate() {
    const templateName = document.getElementById('templateName').value;
    const templateDescription = document.getElementById('templateDescription').value;
    const templateCategory = document.getElementById('templateCategory').value;
    
    if (!templateName.trim()) {
        alert('Please enter a template name');
        return;
    }
    
    const canvasContent = document.getElementById('canvasArea').innerHTML;
    if (!canvasContent.trim()) {
        alert('Please add some content to your page before saving as template');
        return;
    }
    
    const newTemplate = {
        id: Date.now(),
        name: templateName,
        description: templateDescription,
        category: templateCategory,
        thumbnail: 'https://picsum.photos/400/300?random=' + Math.floor(Math.random() * 1000),
        content: canvasContent,
        custom: true,
        created_at: new Date().toISOString().split('T')[0]
    };
    
    const savedTemplates = localStorage.getItem('customTemplates');
    let customTemplates = [];
    if (savedTemplates) {
        try {
            customTemplates = JSON.parse(savedTemplates);
        } catch (e) {
            console.error('Error loading custom templates:', e);
        }
    }
    
    customTemplates.unshift(newTemplate);
    localStorage.setItem('customTemplates', JSON.stringify(customTemplates));
    
    // Refresh templates
    loadTemplates();
    
    // Clear form
    document.getElementById('templateName').value = '';
    document.getElementById('templateDescription').value = '';
    document.getElementById('templateCategory').value = 'custom';
    
    showNotification('Template saved successfully!', 'success');
}

// Add event listeners
document.getElementById('templatesBtn').addEventListener('click', openTemplatesModal);
document.getElementById('importTemplateBtn').addEventListener('click', importTemplate);

// Media Library Integration
let currentImageWidget = null;
let selectedMediaId = null;

function handleImageUpload(file, imageWidget) {
    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file.');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const uploadedImage = imageWidget.querySelector('.uploaded-image');
        const placeholder = imageWidget.querySelector('.image-placeholder');
        
        uploadedImage.src = e.target.result;
        uploadedImage.style.display = 'block';
        placeholder.style.display = 'none';
        
        // Also save to media library
        saveImageToMediaLibrary(file, e.target.result);
        
        saveToHistory();
    };
    reader.readAsDataURL(file);
}

function saveImageToMediaLibrary(file, dataUrl) {
    const newMediaFile = {
        id: Date.now(),
        name: file.name,
        title: file.name.split('.')[0],
        type: 'image',
        size: formatFileSize(file.size),
        url: dataUrl,
        thumbnail: dataUrl,
        created_at: new Date().toISOString().split('T')[0],
        modified_at: new Date().toISOString().split('T')[0],
        alt_text: file.name.split('.')[0],
        description: `Uploaded ${file.name}`
    };
    
    const savedMedia = localStorage.getItem('mediaFiles');
    let mediaFiles = [];
    if (savedMedia) {
        try {
            mediaFiles = JSON.parse(savedMedia);
        } catch (e) {
            console.error('Error loading media files:', e);
        }
    }
    
    mediaFiles.unshift(newMediaFile);
    localStorage.setItem('mediaFiles', JSON.stringify(mediaFiles));
}

function openMediaLibrary(imageWidget) {
    currentImageWidget = imageWidget;
    loadMediaLibrary();
    
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded. Please refresh the page.');
        // Fallback: show modal manually
        const modal = document.getElementById('mediaLibraryModal');
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        return;
    }
    
    new bootstrap.Modal(document.getElementById('mediaLibraryModal')).show();
}

function loadMediaLibrary() {
    const mediaGrid = document.getElementById('mediaGrid');
    const savedMedia = localStorage.getItem('mediaFiles');
    let mediaFiles = [];
    
    if (savedMedia) {
        try {
            mediaFiles = JSON.parse(savedMedia);
        } catch (e) {
            console.error('Error loading media files:', e);
        }
    }
    
    if (mediaFiles.length === 0) {
        mediaGrid.innerHTML = `
            <div class="col-12 text-center py-4">
                <i class="ri-image-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
                <h6>No media files found</h6>
                <p class="text-muted">Upload images to use in your page builder</p>
            </div>
        `;
        return;
    }
    
    const imageFiles = mediaFiles.filter(media => media.type === 'image');
    
    if (imageFiles.length === 0) {
        mediaGrid.innerHTML = `
            <div class="col-12 text-center py-4">
                <i class="ri-image-line" style="font-size: 3rem; color: #6c757d; margin-bottom: 15px;"></i>
                <h6>No images found</h6>
                <p class="text-muted">Upload images to use in your page builder</p>
            </div>
        `;
        return;
    }
    
    mediaGrid.innerHTML = imageFiles.map(media => `
        <div class="media-item" onclick="selectMedia(${media.id})" style="cursor: pointer; border: 2px solid transparent; border-radius: 8px; overflow: hidden; transition: all 0.3s; position: relative;">
            <img src="${media.thumbnail}" alt="${media.title}" style="width: 100%; height: 120px; object-fit: cover;">
            <div style="padding: 8px; background: white;">
                <h6 style="font-size: 0.8rem; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${media.title}</h6>
                <small class="text-muted">${media.size}</small>
                ${media.ai_generated ? '<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem; margin-left: 5px;">AI</span>' : ''}
            </div>
            <div class="selection-indicator" style="position: absolute; top: 5px; right: 5px; background: #007bff; color: white; border-radius: 50%; width: 20px; height: 20px; display: none; align-items: center; justify-content: center; font-size: 0.8rem;">
                <i class="ri-check-line"></i>
            </div>
        </div>
    `).join('');
}

function selectMedia(mediaId) {
    selectedMediaId = mediaId;
    
    // Update visual selection
    document.querySelectorAll('.media-item').forEach(item => {
        item.style.borderColor = 'transparent';
        item.style.transform = 'scale(1)';
        const indicator = item.querySelector('.selection-indicator');
        if (indicator) indicator.style.display = 'none';
    });
    
    const selectedItem = event.currentTarget;
    selectedItem.style.borderColor = '#007bff';
    selectedItem.style.transform = 'scale(1.05)';
    const indicator = selectedItem.querySelector('.selection-indicator');
    if (indicator) indicator.style.display = 'flex';
    
    // Enable select button
    document.getElementById('selectImageBtn').disabled = false;
}

function selectImage() {
    if (!selectedMediaId || !currentImageWidget) return;
    
    const savedMedia = localStorage.getItem('mediaFiles');
    if (savedMedia) {
        const mediaFiles = JSON.parse(savedMedia);
        const selectedMedia = mediaFiles.find(media => media.id === selectedMediaId);
        
        if (selectedMedia) {
            const uploadedImage = currentImageWidget.querySelector('.uploaded-image');
            const placeholder = currentImageWidget.querySelector('.image-placeholder');
            
            uploadedImage.src = selectedMedia.url;
            uploadedImage.style.display = 'block';
            placeholder.style.display = 'none';
            
            saveToHistory();
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('mediaLibraryModal')).hide();
        }
    }
}

function generateAIImage() {
    const prompt = document.getElementById('aiPrompt').value;
    if (!prompt.trim()) {
        alert('Please enter a description for AI generation');
        return;
    }
    
    // Generate AI image (same logic as media library)
    const imageUrl = generatePlaceholderImage(prompt, 'image', 'modern');
    
    // Create new media file
    const newMediaFile = {
        id: Date.now(),
        name: `ai-generated-${Date.now()}.png`,
        title: `AI Generated: ${prompt}`,
        type: 'image',
        size: '2.1 MB',
        url: imageUrl,
        thumbnail: imageUrl,
        created_at: new Date().toISOString().split('T')[0],
        modified_at: new Date().toISOString().split('T')[0],
        alt_text: `AI generated: ${prompt}`,
        description: `AI generated image: ${prompt}`,
        ai_generated: true,
        ai_prompt: prompt,
        ai_style: 'modern'
    };
    
    // Add to media files
    const savedMedia = localStorage.getItem('mediaFiles');
    let mediaFiles = [];
    if (savedMedia) {
        try {
            mediaFiles = JSON.parse(savedMedia);
        } catch (e) {
            console.error('Error loading media files:', e);
        }
    }
    
    mediaFiles.unshift(newMediaFile);
    localStorage.setItem('mediaFiles', JSON.stringify(mediaFiles));
    
    // Refresh media grid
    loadMediaLibrary();
    
    // Auto-select the new image
    setTimeout(() => {
        selectMedia(newMediaFile.id);
        document.getElementById('selectImageBtn').disabled = false;
    }, 100);
}

function generatePlaceholderImage(prompt, type, style) {
    const baseUrl = 'https://picsum.photos/800/600';
    const seed = prompt.toLowerCase().replace(/\s+/g, '-');
    
    let category = 'nature';
    if (prompt.toLowerCase().includes('logo') || prompt.toLowerCase().includes('brand')) {
        category = 'business';
    } else if (prompt.toLowerCase().includes('person') || prompt.toLowerCase().includes('people')) {
        category = 'people';
    } else if (prompt.toLowerCase().includes('tech') || prompt.toLowerCase().includes('computer')) {
        category = 'technology';
    } else if (prompt.toLowerCase().includes('food') || prompt.toLowerCase().includes('restaurant')) {
        category = 'food';
    }
    
    const categorySeeds = {
        'business': [1, 2, 3, 4, 5],
        'people': [10, 11, 12, 13, 14],
        'technology': [20, 21, 22, 23, 24],
        'food': [30, 31, 32, 33, 34],
        'nature': [40, 41, 42, 43, 44]
    };
    
    const randomSeed = categorySeeds[category][Math.floor(Math.random() * categorySeeds[category].length)];
    return `https://picsum.photos/seed/${randomSeed}/800/600`;
}

// Setup file upload for page builder
document.getElementById('pageBuilderFileInput').addEventListener('change', function(e) {
    const files = e.target.files;
    if (files.length === 0) return;
    
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const newMediaFile = {
                id: Date.now() + index,
                name: file.name,
                title: file.name.split('.')[0],
                type: 'image',
                size: formatFileSize(file.size),
                url: e.target.result,
                thumbnail: e.target.result,
                created_at: new Date().toISOString().split('T')[0],
                modified_at: new Date().toISOString().split('T')[0],
                alt_text: file.name.split('.')[0],
                description: `Uploaded ${file.name}`
            };
            
            const savedMedia = localStorage.getItem('mediaFiles');
            let mediaFiles = [];
            if (savedMedia) {
                try {
                    mediaFiles = JSON.parse(savedMedia);
                } catch (e) {
                    console.error('Error loading media files:', e);
                }
            }
            
            mediaFiles.unshift(newMediaFile);
            localStorage.setItem('mediaFiles', JSON.stringify(mediaFiles));
            
            loadMediaLibrary();
        };
        reader.readAsDataURL(file);
    });
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Setup drag and drop for upload area
document.getElementById('pageBuilderUploadArea').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = '#007bff';
    this.style.backgroundColor = '#f8f9ff';
});

document.getElementById('pageBuilderUploadArea').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.borderColor = '#dee2e6';
    this.style.backgroundColor = 'transparent';
});

document.getElementById('pageBuilderUploadArea').addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '#dee2e6';
    this.style.backgroundColor = 'transparent';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('pageBuilderFileInput').files = files;
        document.getElementById('pageBuilderFileInput').dispatchEvent(new Event('change'));
    }
});

// Click to upload
document.getElementById('pageBuilderUploadArea').addEventListener('click', function() {
    document.getElementById('pageBuilderFileInput').click();
});

// Select image button
document.getElementById('selectImageBtn').addEventListener('click', selectImage);
</script>
</body>
</html>

</body>
</html>

</html>


</html>
