
@php
    $saveUrl = route('content-types.store');
@endphp

    <div id="advanced-page-builder">


        <!-- Top Toolbar -->
        <div class="builder-toolbar">
            <div class="toolbar-left">
                <button class="toolbar-btn" id="save-btn">
                    <i class="ri-save-line"></i> Save
                </button>
                <button class="toolbar-btn" id="export-html-btn">
                    <i class="ri-code-line"></i> Export HTML
                </button>
                <button class="toolbar-btn" id="export-json-btn">
                    <i class="ri-file-code-line"></i> Export JSON
                </button>
                <button class="toolbar-btn" id="import-json-btn">
                    <i class="ri-upload-line"></i> Import
                </button>
                <input type="file" id="import-file" accept=".json" style="display: none;">
            </div>
            <div class="toolbar-center">
                <div class="responsive-controls">
                    <button class="device-btn active" data-device="desktop">
                        <i class="ri-computer-line"></i> Desktop
                    </button>
                    <button class="device-btn" data-device="tablet">
                        <i class="ri-tablet-line"></i> Tablet
                    </button>
                    <button class="device-btn" data-device="mobile">
                        <i class="ri-smartphone-line"></i> Mobile
                    </button>
                </div>
            </div>
            <div class="toolbar-right">
                <button class="toolbar-btn" id="global-settings-btn">
                    <i class="ri-settings-3-line"></i> Global
                </button>
                <button class="toolbar-btn" id="navigator-btn">
                    <i class="ri-navigation-line"></i> Navigator
                </button>
                <button class="toolbar-btn" id="template-library-btn">
                    <i class="ri-layout-line"></i> Templates
                </button>
                <button class="toolbar-btn" id="undo-btn">
                    <i class="ri-arrow-go-back-line"></i> Undo
                </button>
                <button class="toolbar-btn" id="redo-btn">
                    <i class="ri-arrow-go-forward-line"></i> Redo
                </button>
                <button class="toolbar-btn" id="preview-btn">
                    <i class="ri-eye-line"></i> Preview
                </button>
            </div>
        </div>

        <!-- Main Builder Area -->
        <div class="builder-main">
            <!-- Left Sidebar - Widgets -->
            <div class="builder-sidebar left-sidebar">
                <div class="sidebar-header">
                    <h3>Widgets</h3>
                    <button class="sidebar-toggle" id="left-sidebar-toggle">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
                <div class="widgets-panel">
                    <div class="widget-category">
                        <h4>Basic</h4>
                        <div class="widget-list">
                            <div class="widget-item" draggable="true" data-widget="heading">
                                <i class="ri-h-1"></i>
                                <span>Heading</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="paragraph">
                                <i class="ri-text"></i>
                                <span>Paragraph</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="button">
                                <i class="ri-button-line"></i>
                                <span>Button</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="image">
                                <i class="ri-image-line"></i>
                                <span>Image</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="icon">
                                <i class="ri-star-line"></i>
                                <span>Icon</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="icon-box">
                                <i class="ri-layout-box-line"></i>
                                <span>Icon Box</span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-category">
                        <h4>Media</h4>
                        <div class="widget-list">
                            <div class="widget-item" draggable="true" data-widget="video">
                                <i class="ri-video-line"></i>
                                <span>Video</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="image-gallery">
                                <i class="ri-gallery-line"></i>
                                <span>Image Gallery</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="image-carousel">
                                <i class="ri-slideshow-line"></i>
                                <span>Image Carousel</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="google-maps">
                                <i class="ri-map-pin-line"></i>
                                <span>Google Maps</span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-category">
                        <h4>Interactive</h4>
                        <div class="widget-list">
                            <div class="widget-item" draggable="true" data-widget="accordion">
                                <i class="ri-list-check"></i>
                                <span>Accordion</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="tabs">
                                <i class="ri-layout-tabs-line"></i>
                                <span>Tabs</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="toggle">
                                <i class="ri-toggle-line"></i>
                                <span>Toggle</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="alert">
                                <i class="ri-alert-line"></i>
                                <span>Alert</span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-category">
                        <h4>Data Display</h4>
                        <div class="widget-list">
                            <div class="widget-item" draggable="true" data-widget="counter">
                                <i class="ri-number-1"></i>
                                <span>Counter</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="progress-bar">
                                <i class="ri-progress-1-line"></i>
                                <span>Progress Bar</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="star-rating">
                                <i class="ri-star-line"></i>
                                <span>Star Rating</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="social-icons">
                                <i class="ri-share-line"></i>
                                <span>Social Icons</span>
                            </div>
                        </div>
                    </div>
                    <div class="widget-category">
                        <h4>Layout</h4>
                        <div class="widget-list">
                            <div class="widget-item" draggable="true" data-widget="section">
                                <i class="ri-layout-3-line"></i>
                                <span>Section</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="container">
                                <i class="ri-layout-2-line"></i>
                                <span>Container</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="inner-section">
                                <i class="ri-layout-4-line"></i>
                                <span>Inner Section</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="spacer">
                                <i class="ri-space"></i>
                                <span>Spacer</span>
                            </div>
                            <div class="widget-item" draggable="true" data-widget="divider">
                                <i class="ri-drag-drop-line"></i>
                                <span>Divider</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Canvas Area -->
            <div class="builder-canvas">
                <div class="canvas-header">
                    <h3>Canvas</h3>
                    <div class="canvas-controls">
                        <button class="canvas-btn" id="clear-canvas">
                            <i class="ri-delete-bin-line"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="canvas-content" id="canvas-content">
                    <div class="empty-canvas">
                        <i class="ri-drag-drop-line"></i>
                        <h3>Drag widgets here to start building</h3>
                        <p>Choose widgets from the left sidebar and drag them to this area</p>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Settings -->
            <div class="builder-sidebar right-sidebar">
                <div class="sidebar-header">
                    <h3>Settings</h3>
                    <button class="sidebar-toggle" id="right-sidebar-toggle">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
                <div class="settings-panel" id="settings-panel">
                    <div class="no-selection">
                        <i class="ri-settings-3-line"></i>
                        <h4>No Element Selected</h4>
                        <p>Select an element to edit its properties</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Advanced Page Builder Styles */
        #advanced-page-builder {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: #1e1e1e;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #ffffff;
        }

        /* Toolbar */
        .builder-toolbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .toolbar-left, .toolbar-right {
            display: flex;
            gap: 10px;
        }

        .toolbar-center {
            display: flex;
            align-items: center;
        }

        .toolbar-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .toolbar-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .responsive-controls {
            display: flex;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 6px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .device-btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.7);
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .device-btn.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .device-btn:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        /* Main Builder Area */
        .builder-main {
            flex: 1;
            display: flex;
            height: calc(100vh - 60px);
        }

        /* Sidebars */
        .builder-sidebar {
            width: 320px;
            background: #2a2a2a;
            border-right: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
        }

        .right-sidebar {
            border-right: none;
            border-left: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header {
            padding: 20px 25px;
            background: #333333;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-toggle {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #ffffff;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.2);
        }

        /* Widgets Panel */
        .widgets-panel {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #2a2a2a;
        }

        .widget-category {
            margin-bottom: 30px;
        }

        .widget-category h4 {
            margin: 0 0 15px 0;
            font-size: 12px;
            font-weight: 700;
            color: #888888;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 12px;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .widget-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .widget-item {
            background: #3a3a3a;
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 15px;
            cursor: grab;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            user-select: none;
            position: relative;
            overflow: hidden;
        }

        .widget-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .widget-item:hover::before {
            left: 100%;
        }

        .widget-item:hover {
            border-color: #667eea;
            background: #4a4a4a;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .widget-item:active {
            cursor: grabbing;
            transform: scale(0.95);
        }

        .widget-item i {
            font-size: 28px;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .widget-item:hover i {
            color: #ffffff;
            transform: scale(1.1);
        }

        .widget-item span {
            font-size: 11px;
            font-weight: 600;
            color: #cccccc;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Canvas */
        .builder-canvas {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #1a1a1a;
        }

        .canvas-header {
            padding: 20px 25px;
            background: #2a2a2a;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .canvas-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .canvas-controls {
            display: flex;
            gap: 10px;
        }

        .canvas-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .canvas-btn:hover {
            background: linear-gradient(135deg, #ff5252, #d32f2f);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .canvas-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            position: relative;
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        }

        .empty-canvas {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #888888;
            text-align: center;
            background: rgba(255,255,255,0.02);
            border: 2px dashed rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 60px;
        }

        .empty-canvas i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #667eea;
            opacity: 0.7;
        }

        .empty-canvas h3 {
            margin: 0 0 12px 0;
            font-size: 24px;
            font-weight: 600;
            color: #ffffff;
        }

        .empty-canvas p {
            margin: 0;
            font-size: 16px;
            opacity: 0.8;
            color: #cccccc;
        }

        /* Settings Panel */
        .settings-panel {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #2a2a2a;
        }

        .no-selection {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #888888;
            text-align: center;
            background: rgba(255,255,255,0.02);
            border: 2px dashed rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 40px;
        }

        .no-selection i {
            font-size: 56px;
            margin-bottom: 20px;
            color: #667eea;
            opacity: 0.7;
        }

        .no-selection h4 {
            margin: 0 0 12px 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
        }

        .no-selection p {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
            color: #cccccc;
        }

        /* Canvas Elements */
        .canvas-element {
            position: relative;
            margin-bottom: 20px;
            border: 2px dashed transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
            min-height: 50px;
        }

        .canvas-element:hover {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.05);
        }

        .canvas-element.selected {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.1);
            box-shadow: 0 0 0 1px #3498db;
        }

        .element-controls {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #3498db;
            border-radius: 4px;
            display: none;
            align-items: center;
            gap: 4px;
            padding: 4px;
            z-index: 100;
        }

        .canvas-element:hover .element-controls {
            display: flex;
        }

        .control-btn {
            background: transparent;
            border: none;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .control-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Widget Styles */
        .widget-heading {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .widget-paragraph {
            font-size: 16px;
            color: #2c3e50;
            margin: 0;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            line-height: 1.6;
        }

        .widget-button {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 20px;
        }

        .widget-button:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .widget-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 20px 0;
        }

        .widget-video {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .widget-spacer {
            height: 50px;
            background: #e1e8ed;
            border-radius: 4px;
            margin: 20px 0;
            position: relative;
        }

        .widget-spacer::after {
            content: "Spacer";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 500;
        }

        .widget-divider {
            height: 2px;
            background: #e1e8ed;
            margin: 20px 0;
            position: relative;
        }

        .widget-divider::after {
            content: "Divider";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f8f9fa;
            padding: 0 10px;
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 500;
        }

        /* Advanced Widget Styles */
        .widget-icon {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .widget-icon i {
            font-size: 24px;
            color: #3498db;
        }

        .widget-icon-box {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .widget-icon-box .icon {
            margin-bottom: 15px;
        }

        .widget-icon-box .icon i {
            font-size: 48px;
            color: #3498db;
        }

        .widget-icon-box h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
        }

        .widget-icon-box p {
            margin: 0;
            color: #7f8c8d;
            line-height: 1.6;
        }

        /* Image Gallery */
        .widget-image-gallery {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .gallery-grid img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Image Carousel */
        .widget-image-carousel {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .carousel-container {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }

        .carousel-container img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 15px;
            transform: translateY(-50%);
        }

        .carousel-controls button {
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Google Maps */
        .widget-google-maps {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .widget-google-maps iframe {
            border-radius: 8px;
        }

        /* Accordion */
        .widget-accordion {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .accordion-item {
            border-bottom: 1px solid #e1e8ed;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            padding: 15px 0;
            cursor: pointer;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid transparent;
        }

        .accordion-header:hover {
            color: #3498db;
        }

        .accordion-content {
            padding: 15px 0;
            color: #7f8c8d;
            line-height: 1.6;
        }

        /* Tabs */
        .widget-tabs {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .tab-headers {
            display: flex;
            border-bottom: 2px solid #e1e8ed;
            margin-bottom: 20px;
        }

        .tab-header {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            color: #7f8c8d;
            font-weight: 500;
        }

        .tab-header.active {
            color: #3498db;
            border-bottom-color: #3498db;
        }

        .tab-pane {
            display: none;
            color: #2c3e50;
            line-height: 1.6;
        }

        .tab-pane.active {
            display: block;
        }

        /* Toggle */
        .widget-toggle {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-item {
            border-bottom: 1px solid #e1e8ed;
        }

        .toggle-item:last-child {
            border-bottom: none;
        }

        .toggle-header {
            padding: 15px 0;
            cursor: pointer;
            font-weight: 600;
            color: #2c3e50;
        }

        .toggle-content {
            padding: 15px 0;
            color: #7f8c8d;
            line-height: 1.6;
        }

        /* Alert */
        .widget-alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-info {
            background: #e3f2fd;
            color: #1976d2;
            border: 1px solid #bbdefb;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-warning {
            background: #fff3e0;
            color: #f57c00;
            border: 1px solid #ffcc02;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Counter */
        .widget-counter {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .counter-number {
            font-size: 48px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }

        .counter-label {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 500;
        }

        /* Progress Bar */
        .widget-progress-bar {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .progress-label {
            margin-bottom: 10px;
            font-weight: 500;
            color: #2c3e50;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e1e8ed;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .progress-fill {
            height: 100%;
            background: #3498db;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-percentage {
            text-align: right;
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Star Rating */
        .widget-star-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .stars i {
            font-size: 20px;
            color: #ffd700;
        }

        .rating-text {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Social Icons */
        .widget-social-icons {
            display: flex;
            gap: 15px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            color: #7f8c8d;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: #3498db;
            color: white;
            transform: translateY(-2px);
        }

        .social-icon i {
            font-size: 18px;
        }

        /* Inner Section */
        .widget-inner-section {
            background: #f8f9fa;
            border: 2px dashed #e1e8ed;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            min-height: 100px;
        }

        .inner-content {
            text-align: center;
            color: #7f8c8d;
        }

        /* Advanced Settings Styles */
        .settings-tabs-nav {
            display: flex;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 20px;
        }

        .tab-nav-btn {
            flex: 1;
            background: transparent;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            color: #7f8c8d;
            transition: all 0.3s ease;
        }

        .tab-nav-btn.active {
            background: white;
            color: #3498db;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .tab-nav-btn:hover {
            color: #3498db;
        }

        .settings-tab {
            display: none;
        }

        .settings-tab.active {
            display: block;
        }

        .spacing-controls {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .spacing-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }

        .spacing-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 12px;
        }

        .device-settings {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .device-group h5 {
            color: #3498db;
            margin: 10px 0 5px 0;
            font-size: 14px;
        }

        /* Tab Navigation */
        .settings-tabs-nav {
            display: flex;
            background: #2a2a2a;
            border-radius: 8px;
            padding: 4px;
            margin-top: 20px;
        }

        .tab-nav-btn {
            flex: 1;
            padding: 8px 12px;
            background: transparent;
            border: none;
            color: #b0b0b0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .tab-nav-btn:hover {
            background: #3a3a3a;
            color: #ffffff;
        }

        .tab-nav-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .settings-tab {
            display: none;
        }

        .settings-tab.active {
            display: block;
        }

        .device-setting {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3498db;
        }

        .device-setting h5 {
            margin: 0 0 10px 0;
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }

        .color-picker {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .color-picker label {
            font-size: 12px;
            font-weight: 500;
            color: #7f8c8d;
        }

        .color-picker input[type="color"] {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .color-picker input[type="text"] {
            font-size: 12px;
            padding: 6px 8px;
        }

        /* Form Enhancements */
        .form-group label {
            font-size: 13px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            font-size: 13px;
            padding: 8px 10px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 60px;
        }

        /* Checkbox Styles */
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }

        .form-group label input[type="checkbox"] {
            margin-right: 6px;
        }

        /* Animation Classes */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideInDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .animate-fadeIn { animation: fadeIn 1s ease; }
        .animate-slideInUp { animation: slideInUp 1s ease; }
        .animate-slideInDown { animation: slideInDown 1s ease; }
        .animate-zoomIn { animation: zoomIn 1s ease; }
        .animate-bounceIn { animation: bounceIn 1s ease; }

        /* Hover Effects */
        .hover-scale:hover { transform: scale(1.05); transition: transform 0.3s ease; }
        .hover-rotate:hover { transform: rotate(5deg); transition: transform 0.3s ease; }
        .hover-glow:hover { box-shadow: 0 0 20px rgba(52, 152, 219, 0.5); transition: box-shadow 0.3s ease; }
        .hover-shadow:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: box-shadow 0.3s ease; }

        /* Responsive Design for Settings */
        @media (max-width: 768px) {
            .spacing-controls {
                grid-template-columns: 1fr;
            }
            
            .settings-tabs-nav {
                flex-wrap: wrap;
            }
            
            .tab-nav-btn {
                flex: none;
                min-width: 80px;
            }
        }

        .widget-container {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
            position: relative;
            transition: all 0.3s ease;
            gap: 10px;
        }

        .widget-container:hover {
            border-color: #3498db;
            background: #e3f2fd;
        }

        .widget-container.selected {
            border-color: #2980b9;
            background: #bbdefb;
        }

        .widget-container.container-drop-zone {
            border-color: #e74c3c;
            background: #fdf2f2;
            border-style: solid;
            animation: pulse 1s infinite;
        }

        .widget-container .canvas-element {
            margin: 5px 0;
            position: relative;
        }

        .widget-container .canvas-element:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        @keyframes pulse {
            0% { border-color: #e74c3c; }
            50% { border-color: #c0392b; }
            100% { border-color: #e74c3c; }
        }

        .widget-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px 0;
            min-height: 100px;
            border: 2px dashed #e1e8ed;
            padding: 20px;
        }

        /* Settings Form */
        .settings-form {
            display: none;
        }

        .settings-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e1e8ed;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .color-picker {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .color-picker input[type="color"] {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .color-picker input[type="text"] {
            flex: 1;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .builder-sidebar {
                width: 250px;
            }
        }

        @media (max-width: 768px) {
            .builder-main {
                flex-direction: column;
            }
            
            .builder-sidebar {
                width: 100%;
                height: 200px;
                border-right: none;
                border-bottom: 1px solid #e1e8ed;
            }
            
            .widget-list {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Drag and Drop States */
        .canvas-content.drag-over {
            background: rgba(52, 152, 219, 0.1);
            border: 2px dashed #3498db;
        }

        .widget-item.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
        }

        .drop-zone {
            border: 2px dashed #3498db;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            color: #3498db;
            font-weight: 500;
            margin: 10px 0;
            transition: all 0.3s ease;
        }

        .drop-zone.active {
            background: rgba(52, 152, 219, 0.2);
            border-color: #2980b9;
        }
    </style>

    <script>
        // Advanced Page Builder JavaScript
        class AdvancedPageBuilder {
            constructor() {
                this.selectedElement = null;
                this.history = [];
                this.historyIndex = -1;
                this.currentDevice = 'desktop';
                this.widgets = {};
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.loadFromStorage();
                this.updateHistory();
                this.setupExistingContainers();
            }

            setupExistingContainers() {
                // Setup drop zones for existing containers
                const containers = document.querySelectorAll('.widget-container');
                containers.forEach(container => {
                    this.setupContainerDropZone(container);
                });
            }

            setupEventListeners() {
                // Widget drag and drop
                document.querySelectorAll('.widget-item').forEach(widget => {
                    widget.addEventListener('dragstart', (e) => this.handleDragStart(e));
                    widget.addEventListener('dragend', (e) => this.handleDragEnd(e));
                });

                // Canvas drop
                const canvas = document.getElementById('canvas-content');
                canvas.addEventListener('dragover', (e) => this.handleDragOver(e));
                canvas.addEventListener('drop', (e) => this.handleDrop(e));
                canvas.addEventListener('dragleave', (e) => this.handleDragLeave(e));

                // Toolbar buttons
                document.getElementById('save-btn').addEventListener('click', () => this.save());
                document.getElementById('export-html-btn').addEventListener('click', () => this.exportHTML());
                document.getElementById('export-json-btn').addEventListener('click', () => this.exportJSON());
                document.getElementById('undo-btn').addEventListener('click', () => this.undo());
                document.getElementById('redo-btn').addEventListener('click', () => this.redo());
                document.getElementById('preview-btn').addEventListener('click', () => this.togglePreview());
                document.getElementById('clear-canvas').addEventListener('click', () => this.clearCanvas());

                // Device controls
                document.querySelectorAll('.device-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => this.switchDevice(e.target.dataset.device));
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', (e) => this.handleKeyboard(e));
            }

            handleDragStart(e) {
                e.dataTransfer.setData('text/plain', e.target.dataset.widget);
                e.target.classList.add('dragging');
            }

            handleDragEnd(e) {
                e.target.classList.remove('dragging');
            }

            handleDragOver(e) {
                e.preventDefault();
                e.currentTarget.classList.add('drag-over');
            }

            handleDragLeave(e) {
                e.currentTarget.classList.remove('drag-over');
            }

            handleDrop(e) {
                e.preventDefault();
                e.currentTarget.classList.remove('drag-over');
                
                const widgetType = e.dataTransfer.getData('text/plain');
                this.addWidget(widgetType);
            }

            addWidget(type) {
                const canvas = document.getElementById('canvas-content');
                const emptyCanvas = canvas.querySelector('.empty-canvas');
                if (emptyCanvas) {
                    emptyCanvas.style.display = 'none';
                }

                const element = document.createElement('div');
                element.className = 'canvas-element';
                element.dataset.widgetType = type;
                element.innerHTML = this.getWidgetHTML(type);

                // Add controls
                const controls = document.createElement('div');
                controls.className = 'element-controls';
                controls.innerHTML = `
                    <button class="control-btn" onclick="builder.duplicateElement(this.parentElement.parentElement)" title="Duplicate">
                        <i class="ri-file-copy-line"></i>
                    </button>
                    <button class="control-btn" onclick="builder.deleteElement(this.parentElement.parentElement)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                `;
                element.appendChild(controls);

                // Add click handler
                element.addEventListener('click', (e) => {
                    if (e.target.closest('.element-controls')) return;
                    this.selectElement(element);
                });

                // Setup container drop zone if it's a container
                if (type === 'container') {
                    this.setupContainerDropZone(element);
                }

                canvas.appendChild(element);
                this.selectElement(element);
                this.updateHistory();
            }

            setupContainerDropZone(container) {
                // Make container a drop zone
                container.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'copy';
                    container.classList.add('container-drop-zone');
                });

                container.addEventListener('dragleave', (e) => {
                    if (!container.contains(e.relatedTarget)) {
                        container.classList.remove('container-drop-zone');
                    }
                });

                container.addEventListener('drop', (e) => {
                    e.preventDefault();
                    container.classList.remove('container-drop-zone');
                    
                    const widgetType = e.dataTransfer.getData('text/plain');
                    this.addWidgetToContainer(widgetType, container);
                });
            }

            addWidgetToContainer(widgetType, container) {
                const element = document.createElement('div');
                element.className = 'canvas-element';
                element.dataset.widgetType = widgetType;
                element.innerHTML = this.getWidgetHTML(widgetType);

                // Add controls
                const controls = document.createElement('div');
                controls.className = 'element-controls';
                controls.innerHTML = `
                    <button class="control-btn" onclick="builder.duplicateElement(this.parentElement.parentElement)" title="Duplicate">
                        <i class="ri-file-copy-line"></i>
                    </button>
                    <button class="control-btn" onclick="builder.deleteElement(this.parentElement.parentElement)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                `;
                element.appendChild(controls);

                // Add click handler
                element.addEventListener('click', (e) => {
                    if (e.target.closest('.element-controls')) return;
                    this.selectElement(element);
                });

                // Insert widget inside container
                // Remove the placeholder text first
                const placeholder = container.querySelector('p');
                if (placeholder) {
                    placeholder.remove();
                }
                
                // Add widget to container
                container.appendChild(element);
                
                // Add placeholder back if container is empty
                if (container.children.length === 0) {
                    const newPlaceholder = document.createElement('p');
                    newPlaceholder.textContent = 'Container - Drag widgets here';
                    newPlaceholder.style.margin = '0';
                    newPlaceholder.style.color = '#6c757d';
                    newPlaceholder.style.textAlign = 'center';
                    container.appendChild(newPlaceholder);
                }

                this.selectElement(element);
                this.updateHistory();
            }

            getWidgetHTML(type) {
                const widgets = {
                    // Basic Widgets
                    heading: '<h2 class="widget-heading" contenteditable="true">Click to edit heading</h2>',
                    paragraph: '<p class="widget-paragraph" contenteditable="true">Click to edit paragraph text. You can add multiple lines and format the text as needed.</p>',
                    button: '<button class="widget-button" contenteditable="true">Click Me</button>',
                    image: '<img src="https://via.placeholder.com/400x300?text=Image+Widget" alt="Image" class="widget-image">',
                    icon: '<div class="widget-icon"><i class="ri-star-line"></i><span contenteditable="true">Icon Text</span></div>',
                    'icon-box': '<div class="widget-icon-box"><div class="icon"><i class="ri-star-line"></i></div><h3 contenteditable="true">Icon Box Title</h3><p contenteditable="true">Icon box description text</p></div>',
                    
                    // Media Widgets
                    video: '<video class="widget-video" controls><source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">Your browser does not support the video tag.</video>',
                    'image-gallery': '<div class="widget-image-gallery"><div class="gallery-grid"><img src="https://via.placeholder.com/200x200?text=1" alt="Gallery 1"><img src="https://via.placeholder.com/200x200?text=2" alt="Gallery 2"><img src="https://via.placeholder.com/200x200?text=3" alt="Gallery 3"></div></div>',
                    'image-carousel': '<div class="widget-image-carousel"><div class="carousel-container"><img src="https://via.placeholder.com/600x300?text=Carousel+1" alt="Carousel 1"><div class="carousel-controls"><button class="prev">‹</button><button class="next">›</button></div></div></div>',
                    'google-maps': '<div class="widget-google-maps"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343008!2d-74.00425878459418!3d40.74844097932681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>',
                    
                    // Interactive Widgets
                    accordion: '<div class="widget-accordion"><div class="accordion-item"><div class="accordion-header" contenteditable="true">Accordion Item 1</div><div class="accordion-content" contenteditable="true">Accordion content goes here</div></div><div class="accordion-item"><div class="accordion-header" contenteditable="true">Accordion Item 2</div><div class="accordion-content" contenteditable="true">More accordion content</div></div></div>',
                    tabs: '<div class="widget-tabs"><div class="tab-headers"><div class="tab-header active" contenteditable="true">Tab 1</div><div class="tab-header" contenteditable="true">Tab 2</div></div><div class="tab-content"><div class="tab-pane active" contenteditable="true">Tab 1 content</div><div class="tab-pane" contenteditable="true">Tab 2 content</div></div></div>',
                    toggle: '<div class="widget-toggle"><div class="toggle-item"><div class="toggle-header" contenteditable="true">Toggle Item 1</div><div class="toggle-content" contenteditable="true">Toggle content goes here</div></div></div>',
                    alert: '<div class="widget-alert alert-info"><i class="ri-information-line"></i><span contenteditable="true">This is an alert message</span></div>',
                    
                    // Data Display Widgets
                    counter: '<div class="widget-counter"><div class="counter-number" data-target="100">0</div><div class="counter-label" contenteditable="true">Counter Label</div></div>',
                    'progress-bar': '<div class="widget-progress-bar"><div class="progress-label" contenteditable="true">Progress Label</div><div class="progress-bar"><div class="progress-fill" style="width: 75%"></div></div><div class="progress-percentage">75%</div></div>',
                    'star-rating': '<div class="widget-star-rating"><div class="stars"><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-line"></i></div><span class="rating-text" contenteditable="true">4.0 out of 5</span></div>',
                    'social-icons': '<div class="widget-social-icons"><a href="#" class="social-icon"><i class="ri-facebook-line"></i></a><a href="#" class="social-icon"><i class="ri-twitter-line"></i></a><a href="#" class="social-icon"><i class="ri-instagram-line"></i></a><a href="#" class="social-icon"><i class="ri-linkedin-line"></i></a></div>',
                    
                    // Layout Widgets
                    section: '<div class="widget-section"><div class="section-content"><p>Section - Drag widgets here</p></div></div>',
                    container: '<div class="widget-container"><p style="margin: 0; color: #6c757d; text-align: center;">Container - Drag widgets here</p></div>',
                    'inner-section': '<div class="widget-inner-section"><div class="inner-content"><p>Inner Section - Drag widgets here</p></div></div>',
                    spacer: '<div class="widget-spacer"></div>',
                    divider: '<div class="widget-divider"></div>'
                };
                return widgets[type] || '<div>Unknown widget</div>';
            }

            selectElement(element) {
                // Remove previous selection
                document.querySelectorAll('.canvas-element.selected').forEach(el => {
                    el.classList.remove('selected');
                });

                // Select new element
                element.classList.add('selected');
                this.selectedElement = element;
                this.showSettings(element);
            }

            showSettings(element) {
                const settingsPanel = document.getElementById('settings-panel');
                const widgetType = element.dataset.widgetType;
                
                settingsPanel.innerHTML = this.getSettingsHTML(widgetType, element);
                
                // Add event listeners to settings
                this.setupSettingsListeners(element);
                
                // Setup tab navigation
                this.setupTabNavigation();
            }

            getSettingsHTML(type, element) {
                // Container specific settings
                if (type === 'container') {
                    return this.getContainerSettingsHTML(element);
                }
                
                const baseSettings = `
                    <div class="settings-form active">
                        <h4>Widget Settings</h4>
                        
                        <!-- Content Tab -->
                        <div class="settings-tab active" id="content-tab">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content-input" placeholder="Enter content...">${element.textContent.trim()}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Link URL</label>
                                <input type="url" id="link-url" placeholder="https://example.com">
                            </div>
                            
                            <div class="form-group">
                                <label>Alt Text (for images)</label>
                                <input type="text" id="alt-text" placeholder="Alt text for accessibility">
                            </div>
                        </div>

                        <!-- Style Tab -->
                        <div class="settings-tab" id="style-tab">
                            <div class="form-group">
                                <label>Typography</label>
                                <div class="form-row">
                                    <select id="font-family">
                                        <option value="Arial">Arial</option>
                                        <option value="Helvetica">Helvetica</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Times New Roman">Times New Roman</option>
                                        <option value="Roboto">Roboto</option>
                                        <option value="Open Sans">Open Sans</option>
                                    </select>
                                    <input type="number" id="font-size" placeholder="Font Size" value="16">
                                </div>
                                <div class="form-row">
                                    <select id="font-weight">
                                        <option value="300">Light</option>
                                        <option value="400">Normal</option>
                                        <option value="500">Medium</option>
                                        <option value="600">Semi Bold</option>
                                        <option value="700">Bold</option>
                                    </select>
                                    <select id="text-align">
                                        <option value="left">Left</option>
                                        <option value="center">Center</option>
                                        <option value="right">Right</option>
                                        <option value="justify">Justify</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <input type="number" id="line-height" placeholder="Line Height" value="1.6" step="0.1">
                                    <input type="number" id="letter-spacing" placeholder="Letter Spacing" value="0" step="0.1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Colors</label>
                                <div class="form-row">
                                    <div class="color-picker">
                                        <label>Text Color</label>
                                        <input type="color" id="text-color" value="#2c3e50">
                                        <input type="text" id="text-color-hex" value="#2c3e50">
                                    </div>
                                    <div class="color-picker">
                                        <label>Background</label>
                                        <input type="color" id="bg-color" value="#ffffff">
                                        <input type="text" id="bg-color-hex" value="#ffffff">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="color-picker">
                                        <label>Border Color</label>
                                        <input type="color" id="border-color" value="#e1e8ed">
                                        <input type="text" id="border-color-hex" value="#e1e8ed">
                                    </div>
                                    <div class="color-picker">
                                        <label>Hover Color</label>
                                        <input type="color" id="hover-color" value="#3498db">
                                        <input type="text" id="hover-color-hex" value="#3498db">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Background</label>
                                <div class="form-row">
                                    <select id="bg-type">
                                        <option value="solid">Solid Color</option>
                                        <option value="gradient">Gradient</option>
                                        <option value="image">Image</option>
                                    </select>
                                    <input type="url" id="bg-image" placeholder="Image URL">
                                </div>
                                <div class="form-row">
                                    <select id="bg-position">
                                        <option value="center">Center</option>
                                        <option value="top">Top</option>
                                        <option value="bottom">Bottom</option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                    <select id="bg-size">
                                        <option value="cover">Cover</option>
                                        <option value="contain">Contain</option>
                                        <option value="auto">Auto</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Spacing</label>
                                <div class="spacing-controls">
                                    <div class="spacing-section">
                                        <label>Padding</label>
                                        <div class="form-row">
                                            <input type="number" id="padding-top" placeholder="Top" value="20">
                                            <input type="number" id="padding-right" placeholder="Right" value="20">
                                        </div>
                                        <div class="form-row">
                                            <input type="number" id="padding-bottom" placeholder="Bottom" value="20">
                                            <input type="number" id="padding-left" placeholder="Left" value="20">
                                        </div>
                                    </div>
                                    <div class="spacing-section">
                                        <label>Margin</label>
                                        <div class="form-row">
                                            <input type="number" id="margin-top" placeholder="Top" value="0">
                                            <input type="number" id="margin-right" placeholder="Right" value="0">
                                        </div>
                                        <div class="form-row">
                                            <input type="number" id="margin-bottom" placeholder="Bottom" value="0">
                                            <input type="number" id="margin-left" placeholder="Left" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Border</label>
                                <div class="form-row">
                                    <input type="number" id="border-width" placeholder="Width" value="0">
                                    <select id="border-style">
                                        <option value="solid">Solid</option>
                                        <option value="dashed">Dashed</option>
                                        <option value="dotted">Dotted</option>
                                        <option value="double">Double</option>
                                    </select>
                                </div>
                                <input type="number" id="border-radius" placeholder="Border Radius" value="8">
                            </div>

                            <div class="form-group">
                                <label>Box Shadow</label>
                                <div class="form-row">
                                    <input type="number" id="shadow-x" placeholder="X" value="0">
                                    <input type="number" id="shadow-y" placeholder="Y" value="2">
                                </div>
                                <div class="form-row">
                                    <input type="number" id="shadow-blur" placeholder="Blur" value="4">
                                    <input type="number" id="shadow-spread" placeholder="Spread" value="0">
                                </div>
                                <div class="color-picker">
                                    <label>Shadow Color</label>
                                    <input type="color" id="shadow-color" value="#000000">
                                    <input type="text" id="shadow-color-hex" value="#000000">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dimensions</label>
                                <div class="form-row">
                                    <input type="text" id="width" placeholder="Width (px, %, auto)" value="100%">
                                    <input type="text" id="height" placeholder="Height (px, %, auto)" value="auto">
                                </div>
                                <div class="form-row">
                                    <input type="text" id="min-width" placeholder="Min Width" value="0">
                                    <input type="text" id="max-width" placeholder="Max Width" value="100%">
                                </div>
                                <div class="form-row">
                                    <input type="text" id="min-height" placeholder="Min Height" value="100px">
                                    <input type="text" id="max-height" placeholder="Max Height" value="none">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Container Layout</label>
                                <div class="form-row">
                                    <div>
                                        <label>Display</label>
                                        <select id="display">
                                            <option value="block">Block</option>
                                            <option value="flex" selected>Flex</option>
                                            <option value="grid">Grid</option>
                                            <option value="inline-block">Inline Block</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Position</label>
                                        <select id="position">
                                            <option value="static">Static</option>
                                            <option value="relative" selected>Relative</option>
                                            <option value="absolute">Absolute</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div>
                                        <label>Flex Direction</label>
                                        <select id="flex-direction">
                                            <option value="row" selected>Row</option>
                                            <option value="column">Column</option>
                                            <option value="row-reverse">Row Reverse</option>
                                            <option value="column-reverse">Column Reverse</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Justify Content</label>
                                        <select id="justify-content">
                                            <option value="flex-start">Flex Start</option>
                                            <option value="center" selected>Center</option>
                                            <option value="flex-end">Flex End</option>
                                            <option value="space-between">Space Between</option>
                                            <option value="space-around">Space Around</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div>
                                        <label>Align Items</label>
                                        <select id="align-items">
                                            <option value="stretch">Stretch</option>
                                            <option value="flex-start">Flex Start</option>
                                            <option value="center" selected>Center</option>
                                            <option value="flex-end">Flex End</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Flex Wrap</label>
                                        <select id="flex-wrap">
                                            <option value="nowrap" selected>No Wrap</option>
                                            <option value="wrap">Wrap</option>
                                            <option value="wrap-reverse">Wrap Reverse</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Tab -->
                        <div class="settings-tab" id="advanced-tab">
                            <div class="form-group">
                                <label>Animations</label>
                                <div class="form-row">
                                    <select id="animation-type">
                                        <option value="none">None</option>
                                        <option value="fadeIn">Fade In</option>
                                        <option value="slideInUp">Slide In Up</option>
                                        <option value="slideInDown">Slide In Down</option>
                                        <option value="zoomIn">Zoom In</option>
                                        <option value="bounceIn">Bounce In</option>
                                    </select>
                                    <input type="number" id="animation-duration" placeholder="Duration (ms)" value="1000">
                                </div>
                                <div class="form-row">
                                    <input type="number" id="animation-delay" placeholder="Delay (ms)" value="0">
                                    <select id="animation-easing">
                                        <option value="ease">Ease</option>
                                        <option value="ease-in">Ease In</option>
                                        <option value="ease-out">Ease Out</option>
                                        <option value="ease-in-out">Ease In Out</option>
                                        <option value="linear">Linear</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Hover Effects</label>
                                <div class="form-row">
                                    <select id="hover-effect">
                                        <option value="none">None</option>
                                        <option value="scale">Scale</option>
                                        <option value="rotate">Rotate</option>
                                        <option value="glow">Glow</option>
                                        <option value="shadow">Shadow</option>
                                    </select>
                                    <input type="number" id="hover-scale" placeholder="Scale" value="1.05" step="0.01">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Z-Index</label>
                                <input type="number" id="z-index" placeholder="Z-Index" value="1">
                            </div>

                            <div class="form-group">
                                <label>Custom CSS</label>
                                <textarea id="custom-css" placeholder="/* Custom CSS */" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Responsive Tab -->
                        <div class="settings-tab" id="responsive-tab">
                            <div class="form-group">
                                <label>Device Settings</label>
                                <div class="device-settings">
                                    <div class="device-setting">
                                        <h5>Desktop</h5>
                                        <div class="form-row">
                                            <input type="number" id="desktop-font-size" placeholder="Font Size" value="16">
                                            <input type="number" id="desktop-padding" placeholder="Padding" value="20">
                                        </div>
                                    </div>
                                    <div class="device-setting">
                                        <h5>Tablet</h5>
                                        <div class="form-row">
                                            <input type="number" id="tablet-font-size" placeholder="Font Size" value="14">
                                            <input type="number" id="tablet-padding" placeholder="Padding" value="15">
                                        </div>
                                    </div>
                                    <div class="device-setting">
                                        <h5>Mobile</h5>
                                        <div class="form-row">
                                            <input type="number" id="mobile-font-size" placeholder="Font Size" value="12">
                                            <input type="number" id="mobile-padding" placeholder="Padding" value="10">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Visibility</label>
                                <div class="form-row">
                                    <label><input type="checkbox" id="hide-desktop"> Hide on Desktop</label>
                                    <label><input type="checkbox" id="hide-tablet"> Hide on Tablet</label>
                                    <label><input type="checkbox" id="hide-mobile"> Hide on Mobile</label>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="settings-tabs-nav">
                            <button class="tab-nav-btn active" data-tab="content-tab">Content</button>
                            <button class="tab-nav-btn" data-tab="style-tab">Style</button>
                            <button class="tab-nav-btn" data-tab="advanced-tab">Advanced</button>
                            <button class="tab-nav-btn" data-tab="responsive-tab">Responsive</button>
                        </div>
                    </div>
                `;

                return baseSettings;
            }

            getContainerSettingsHTML(element) {
                return `
                    <div class="settings-form active">
                        <h4>Container Settings</h4>
                        
                        <!-- Content Tab -->
                        <div class="settings-tab active" id="content-tab">
                            <div class="form-group">
                                <label>Container Content</label>
                                <textarea id="content-input" placeholder="Enter container content...">${element.textContent.trim()}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Container ID</label>
                                <input type="text" id="container-id" placeholder="container-1">
                            </div>
                            
                            <div class="form-group">
                                <label>Container Class</label>
                                <input type="text" id="container-class" placeholder="my-container">
                            </div>
                        </div>

                        <!-- Style Tab -->
                        <div class="settings-tab" id="style-tab">
                            <div class="form-group">
                                <label>Dimensions</label>
                                <div class="form-row">
                                    <input type="text" id="width" placeholder="Width (px, %, auto)" value="100%">
                                    <input type="text" id="height" placeholder="Height (px, %, auto)" value="auto">
                                </div>
                                <div class="form-row">
                                    <input type="text" id="min-width" placeholder="Min Width" value="0">
                                    <input type="text" id="max-width" placeholder="Max Width" value="100%">
                                </div>
                                <div class="form-row">
                                    <input type="text" id="min-height" placeholder="Min Height" value="100px">
                                    <input type="text" id="max-height" placeholder="Max Height" value="none">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Container Layout</label>
                                <div class="form-row">
                                    <div>
                                        <label>Display</label>
                                        <select id="display">
                                            <option value="block">Block</option>
                                            <option value="flex" selected>Flex</option>
                                            <option value="grid">Grid</option>
                                            <option value="inline-block">Inline Block</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Position</label>
                                        <select id="position">
                                            <option value="static">Static</option>
                                            <option value="relative" selected>Relative</option>
                                            <option value="absolute">Absolute</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div>
                                        <label>Flex Direction</label>
                                        <select id="flex-direction">
                                            <option value="row" selected>Row</option>
                                            <option value="column">Column</option>
                                            <option value="row-reverse">Row Reverse</option>
                                            <option value="column-reverse">Column Reverse</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Justify Content</label>
                                        <select id="justify-content">
                                            <option value="flex-start">Flex Start</option>
                                            <option value="center" selected>Center</option>
                                            <option value="flex-end">Flex End</option>
                                            <option value="space-between">Space Between</option>
                                            <option value="space-around">Space Around</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div>
                                        <label>Align Items</label>
                                        <select id="align-items">
                                            <option value="stretch">Stretch</option>
                                            <option value="flex-start">Flex Start</option>
                                            <option value="center" selected>Center</option>
                                            <option value="flex-end">Flex End</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Flex Wrap</label>
                                        <select id="flex-wrap">
                                            <option value="nowrap" selected>No Wrap</option>
                                            <option value="wrap">Wrap</option>
                                            <option value="wrap-reverse">Wrap Reverse</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Spacing</label>
                                <div class="form-row">
                                    <input type="number" id="padding" placeholder="Padding (px)" value="20">
                                    <input type="number" id="margin" placeholder="Margin (px)" value="20">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Colors</label>
                                <div class="form-row">
                                    <div>
                                        <label>Background Color</label>
                                        <input type="color" id="bg-color" value="#f8f9fa">
                                    </div>
                                    <div>
                                        <label>Text Color</label>
                                        <input type="color" id="text-color" value="#6c757d">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Border</label>
                                <div class="form-row">
                                    <input type="number" id="border-width" placeholder="Border Width" value="2">
                                    <select id="border-style">
                                        <option value="solid">Solid</option>
                                        <option value="dashed" selected>Dashed</option>
                                        <option value="dotted">Dotted</option>
                                        <option value="double">Double</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <input type="color" id="border-color" value="#dee2e6">
                                    <input type="number" id="border-radius" placeholder="Border Radius" value="8">
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Tab -->
                        <div class="settings-tab" id="advanced-tab">
                            <div class="form-group">
                                <label>Z-Index</label>
                                <input type="number" id="z-index" placeholder="Z-Index" value="1">
                            </div>
                            
                            <div class="form-group">
                                <label>Custom CSS</label>
                                <textarea id="custom-css" placeholder="/* Add custom CSS here */"></textarea>
                            </div>
                        </div>

                        <!-- Responsive Tab -->
                        <div class="settings-tab" id="responsive-tab">
                            <div class="form-group">
                                <label>Device Settings</label>
                                <div class="device-settings">
                                    <div class="device-group">
                                        <h5>Desktop</h5>
                                        <input type="text" id="desktop-width" placeholder="Width" value="100%">
                                        <input type="text" id="desktop-height" placeholder="Height" value="auto">
                                    </div>
                                    <div class="device-group">
                                        <h5>Tablet</h5>
                                        <input type="text" id="tablet-width" placeholder="Width" value="100%">
                                        <input type="text" id="tablet-height" placeholder="Height" value="auto">
                                    </div>
                                    <div class="device-group">
                                        <h5>Mobile</h5>
                                        <input type="text" id="mobile-width" placeholder="Width" value="100%">
                                        <input type="text" id="mobile-height" placeholder="Height" value="auto">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="settings-tabs-nav">
                            <button class="tab-nav-btn active" data-tab="content-tab">Content</button>
                            <button class="tab-nav-btn" data-tab="style-tab">Style</button>
                            <button class="tab-nav-btn" data-tab="advanced-tab">Advanced</button>
                            <button class="tab-nav-btn" data-tab="responsive-tab">Responsive</button>
                        </div>
                    </div>
                `;
            }

            setupSettingsListeners(element) {
                // Container specific listeners
                if (element.dataset.widgetType === 'container') {
                    this.setupContainerListeners(element);
                    return;
                }

                // Content
                const contentInput = document.getElementById('content-input');
                if (contentInput) {
                    contentInput.addEventListener('input', (e) => {
                        const editableElement = element.querySelector('[contenteditable="true"]');
                        if (editableElement) {
                            editableElement.textContent = e.target.value;
                        } else {
                            element.textContent = e.target.value;
                        }
                        this.updateHistory();
                    });
                }

                // Typography
                const fontSize = document.getElementById('font-size');
                if (fontSize) {
                    fontSize.addEventListener('input', (e) => {
                        element.style.fontSize = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                const fontFamily = document.getElementById('font-family');
                if (fontFamily) {
                    fontFamily.addEventListener('change', (e) => {
                        element.style.fontFamily = e.target.value;
                        this.updateHistory();
                    });
                }

                // Colors
                const textColor = document.getElementById('text-color');
                const textColorHex = document.getElementById('text-color-hex');
                if (textColor && textColorHex) {
                    textColor.addEventListener('input', (e) => {
                        textColorHex.value = e.target.value;
                        element.style.color = e.target.value;
                        this.updateHistory();
                    });
                    textColorHex.addEventListener('input', (e) => {
                        textColor.value = e.target.value;
                        element.style.color = e.target.value;
                        this.updateHistory();
                    });
                }

                const bgColor = document.getElementById('bg-color');
                const bgColorHex = document.getElementById('bg-color-hex');
                if (bgColor && bgColorHex) {
                    bgColor.addEventListener('input', (e) => {
                        bgColorHex.value = e.target.value;
                        element.style.backgroundColor = e.target.value;
                        this.updateHistory();
                    });
                    bgColorHex.addEventListener('input', (e) => {
                        bgColor.value = e.target.value;
                        element.style.backgroundColor = e.target.value;
                        this.updateHistory();
                    });
                }

                // Spacing
                const padding = document.getElementById('padding');
                if (padding) {
                    padding.addEventListener('input', (e) => {
                        element.style.padding = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                const margin = document.getElementById('margin');
                if (margin) {
                    margin.addEventListener('input', (e) => {
                        element.style.margin = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                // Container Layout Controls
                const width = document.getElementById('width');
                if (width) {
                    width.addEventListener('input', (e) => {
                        element.style.width = e.target.value;
                        this.updateHistory();
                    });
                }

                const height = document.getElementById('height');
                if (height) {
                    height.addEventListener('input', (e) => {
                        element.style.height = e.target.value;
                        this.updateHistory();
                    });
                }

                const minWidth = document.getElementById('min-width');
                if (minWidth) {
                    minWidth.addEventListener('input', (e) => {
                        element.style.minWidth = e.target.value;
                        this.updateHistory();
                    });
                }

                const maxWidth = document.getElementById('max-width');
                if (maxWidth) {
                    maxWidth.addEventListener('input', (e) => {
                        element.style.maxWidth = e.target.value;
                        this.updateHistory();
                    });
                }

                const minHeight = document.getElementById('min-height');
                if (minHeight) {
                    minHeight.addEventListener('input', (e) => {
                        element.style.minHeight = e.target.value;
                        this.updateHistory();
                    });
                }

                const maxHeight = document.getElementById('max-height');
                if (maxHeight) {
                    maxHeight.addEventListener('input', (e) => {
                        element.style.maxHeight = e.target.value;
                        this.updateHistory();
                    });
                }

                // Display and Position
                const display = document.getElementById('display');
                if (display) {
                    display.addEventListener('change', (e) => {
                        element.style.display = e.target.value;
                        this.updateHistory();
                    });
                }

                const position = document.getElementById('position');
                if (position) {
                    position.addEventListener('change', (e) => {
                        element.style.position = e.target.value;
                        this.updateHistory();
                    });
                }

                // Flexbox Controls
                const flexDirection = document.getElementById('flex-direction');
                if (flexDirection) {
                    flexDirection.addEventListener('change', (e) => {
                        element.style.flexDirection = e.target.value;
                        this.updateHistory();
                    });
                }

                const justifyContent = document.getElementById('justify-content');
                if (justifyContent) {
                    justifyContent.addEventListener('change', (e) => {
                        element.style.justifyContent = e.target.value;
                        this.updateHistory();
                    });
                }

                const alignItems = document.getElementById('align-items');
                if (alignItems) {
                    alignItems.addEventListener('change', (e) => {
                        element.style.alignItems = e.target.value;
                        this.updateHistory();
                    });
                }

                const flexWrap = document.getElementById('flex-wrap');
                if (flexWrap) {
                    flexWrap.addEventListener('change', (e) => {
                        element.style.flexWrap = e.target.value;
                        this.updateHistory();
                    });
                }

                // Border
                const borderWidth = document.getElementById('border-width');
                if (borderWidth) {
                    borderWidth.addEventListener('input', (e) => {
                        element.style.borderWidth = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                const borderColor = document.getElementById('border-color');
                if (borderColor) {
                    borderColor.addEventListener('input', (e) => {
                        element.style.borderColor = e.target.value;
                        this.updateHistory();
                    });
                }

                const borderRadius = document.getElementById('border-radius');
                if (borderRadius) {
                    borderRadius.addEventListener('input', (e) => {
                        element.style.borderRadius = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                // Box Shadow
                const boxShadow = document.getElementById('box-shadow');
                if (boxShadow) {
                    boxShadow.addEventListener('input', (e) => {
                        element.style.boxShadow = e.target.value;
                        this.updateHistory();
                    });
                }
            }

            setupContainerListeners(element) {
                // Content
                const contentInput = document.getElementById('content-input');
                if (contentInput) {
                    contentInput.addEventListener('input', (e) => {
                        const p = element.querySelector('p');
                        if (p) {
                            p.textContent = e.target.value;
                        }
                        this.updateHistory();
                    });
                }

                // Container ID
                const containerId = document.getElementById('container-id');
                if (containerId) {
                    containerId.addEventListener('input', (e) => {
                        element.id = e.target.value;
                        this.updateHistory();
                    });
                }

                // Container Class
                const containerClass = document.getElementById('container-class');
                if (containerClass) {
                    containerClass.addEventListener('input', (e) => {
                        element.className = 'widget-container ' + e.target.value;
                        this.updateHistory();
                    });
                }

                // Dimensions
                const width = document.getElementById('width');
                if (width) {
                    width.addEventListener('input', (e) => {
                        element.style.width = e.target.value;
                        this.updateHistory();
                    });
                }

                const height = document.getElementById('height');
                if (height) {
                    height.addEventListener('input', (e) => {
                        element.style.height = e.target.value;
                        this.updateHistory();
                    });
                }

                const minWidth = document.getElementById('min-width');
                if (minWidth) {
                    minWidth.addEventListener('input', (e) => {
                        element.style.minWidth = e.target.value;
                        this.updateHistory();
                    });
                }

                const maxWidth = document.getElementById('max-width');
                if (maxWidth) {
                    maxWidth.addEventListener('input', (e) => {
                        element.style.maxWidth = e.target.value;
                        this.updateHistory();
                    });
                }

                const minHeight = document.getElementById('min-height');
                if (minHeight) {
                    minHeight.addEventListener('input', (e) => {
                        element.style.minHeight = e.target.value;
                        this.updateHistory();
                    });
                }

                const maxHeight = document.getElementById('max-height');
                if (maxHeight) {
                    maxHeight.addEventListener('input', (e) => {
                        element.style.maxHeight = e.target.value;
                        this.updateHistory();
                    });
                }

                // Layout
                const display = document.getElementById('display');
                if (display) {
                    display.addEventListener('change', (e) => {
                        element.style.display = e.target.value;
                        this.updateHistory();
                    });
                }

                const position = document.getElementById('position');
                if (position) {
                    position.addEventListener('change', (e) => {
                        element.style.position = e.target.value;
                        this.updateHistory();
                    });
                }

                const flexDirection = document.getElementById('flex-direction');
                if (flexDirection) {
                    flexDirection.addEventListener('change', (e) => {
                        element.style.flexDirection = e.target.value;
                        this.updateHistory();
                    });
                }

                const justifyContent = document.getElementById('justify-content');
                if (justifyContent) {
                    justifyContent.addEventListener('change', (e) => {
                        element.style.justifyContent = e.target.value;
                        this.updateHistory();
                    });
                }

                const alignItems = document.getElementById('align-items');
                if (alignItems) {
                    alignItems.addEventListener('change', (e) => {
                        element.style.alignItems = e.target.value;
                        this.updateHistory();
                    });
                }

                const flexWrap = document.getElementById('flex-wrap');
                if (flexWrap) {
                    flexWrap.addEventListener('change', (e) => {
                        element.style.flexWrap = e.target.value;
                        this.updateHistory();
                    });
                }

                // Spacing
                const padding = document.getElementById('padding');
                if (padding) {
                    padding.addEventListener('input', (e) => {
                        element.style.padding = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                const margin = document.getElementById('margin');
                if (margin) {
                    margin.addEventListener('input', (e) => {
                        element.style.margin = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                // Colors
                const bgColor = document.getElementById('bg-color');
                if (bgColor) {
                    bgColor.addEventListener('input', (e) => {
                        element.style.backgroundColor = e.target.value;
                        this.updateHistory();
                    });
                }

                const textColor = document.getElementById('text-color');
                if (textColor) {
                    textColor.addEventListener('input', (e) => {
                        const p = element.querySelector('p');
                        if (p) {
                            p.style.color = e.target.value;
                        }
                        this.updateHistory();
                    });
                }

                // Border
                const borderWidth = document.getElementById('border-width');
                const borderStyle = document.getElementById('border-style');
                const borderColor = document.getElementById('border-color');
                const borderRadius = document.getElementById('border-radius');

                if (borderWidth) {
                    borderWidth.addEventListener('input', (e) => {
                        element.style.borderWidth = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                if (borderStyle) {
                    borderStyle.addEventListener('change', (e) => {
                        element.style.borderStyle = e.target.value;
                        this.updateHistory();
                    });
                }

                if (borderColor) {
                    borderColor.addEventListener('input', (e) => {
                        element.style.borderColor = e.target.value;
                        this.updateHistory();
                    });
                }

                if (borderRadius) {
                    borderRadius.addEventListener('input', (e) => {
                        element.style.borderRadius = e.target.value + 'px';
                        this.updateHistory();
                    });
                }

                // Z-Index
                const zIndex = document.getElementById('z-index');
                if (zIndex) {
                    zIndex.addEventListener('input', (e) => {
                        element.style.zIndex = e.target.value;
                        this.updateHistory();
                    });
                }

                // Custom CSS
                const customCss = document.getElementById('custom-css');
                if (customCss) {
                    customCss.addEventListener('input', (e) => {
                        // Apply custom CSS
                        const style = document.createElement('style');
                        style.textContent = `#${element.id || 'container'} { ${e.target.value} }`;
                        document.head.appendChild(style);
                        this.updateHistory();
                    });
                }
            }

            setupTabNavigation() {
                const tabButtons = document.querySelectorAll('.tab-nav-btn');
                const tabContents = document.querySelectorAll('.settings-tab');

                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const targetTab = button.dataset.tab;
                        
                        // Remove active class from all buttons and tabs
                        tabButtons.forEach(btn => btn.classList.remove('active'));
                        tabContents.forEach(tab => tab.classList.remove('active'));
                        
                        // Add active class to clicked button and target tab
                        button.classList.add('active');
                        const targetTabElement = document.getElementById(targetTab);
                        if (targetTabElement) {
                            targetTabElement.classList.add('active');
                        }
                    });
                });
            }

            duplicateElement(element) {
                const clonedElement = element.cloneNode(true);
                element.parentNode.insertBefore(clonedElement, element.nextSibling);
                
                // Add event listeners to cloned element
                clonedElement.addEventListener('click', (e) => {
                    if (e.target.closest('.element-controls')) return;
                    this.selectElement(clonedElement);
                });
                
                this.updateHistory();
            }

            deleteElement(element) {
                if (confirm('Are you sure you want to delete this element?')) {
                    element.remove();
                    this.selectedElement = null;
                    document.getElementById('settings-panel').innerHTML = `
                        <div class="no-selection">
                            <i class="ri-settings-3-line"></i>
                            <h4>No Element Selected</h4>
                            <p>Select an element to edit its properties</p>
                        </div>
                    `;
                    this.updateHistory();
                }
            }

            switchDevice(device) {
                document.querySelectorAll('.device-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-device="${device}"]`).classList.add('active');
                this.currentDevice = device;
                
                // Apply responsive styles
                this.applyResponsiveStyles();
            }

            applyResponsiveStyles() {
                // This would apply different styles based on current device
                console.log('Switching to', this.currentDevice, 'view');
            }

            applyResponsiveSettings() {
                const device = document.getElementById('responsive-device').value;
                console.log('Applying responsive settings for', device);
                // Implementation for responsive settings
            }

            togglePreview() {
                const canvas = document.getElementById('canvas-content');
                canvas.classList.toggle('preview-mode');
                
                // Hide controls in preview mode
                document.querySelectorAll('.element-controls').forEach(control => {
                    control.style.display = canvas.classList.contains('preview-mode') ? 'none' : 'flex';
                });
            }

            clearCanvas() {
                if (confirm('Are you sure you want to clear the canvas?')) {
                    document.getElementById('canvas-content').innerHTML = `
                        <div class="empty-canvas">
                            <i class="ri-drag-drop-line"></i>
                            <h3>Drag widgets here to start building</h3>
                            <p>Choose widgets from the left sidebar and drag them to this area</p>
                        </div>
                    `;
                    this.selectedElement = null;
                    this.updateHistory();
                }
            }

            handleKeyboard(e) {
                if (e.ctrlKey) {
                    switch(e.key) {
                        case 'z':
                            e.preventDefault();
                            this.undo();
                            break;
                        case 'y':
                            e.preventDefault();
                            this.redo();
                            break;
                        case 's':
                            e.preventDefault();
                            this.save();
                            break;
                    }
                }
                
                if (e.key === 'Delete' && this.selectedElement) {
                    this.deleteElement(this.selectedElement);
                }
            }

            updateHistory() {
                const state = this.getState();
                this.history = this.history.slice(0, this.historyIndex + 1);
                this.history.push(state);
                this.historyIndex++;
                
                // Limit history size
                if (this.history.length > 50) {
                    this.history.shift();
                    this.historyIndex--;
                }
            }

            undo() {
                if (this.historyIndex > 0) {
                    this.historyIndex--;
                    this.setState(this.history[this.historyIndex]);
                }
            }

            redo() {
                if (this.historyIndex < this.history.length - 1) {
                    this.historyIndex++;
                    this.setState(this.history[this.historyIndex]);
                }
            }

            getState() {
                const canvas = document.getElementById('canvas-content');
                return {
                    html: canvas.innerHTML,
                    timestamp: Date.now()
                };
            }

            setState(state) {
                const canvas = document.getElementById('canvas-content');
                canvas.innerHTML = state.html;
                
                // Re-add event listeners
                this.setupCanvasEventListeners();
            }

            setupCanvasEventListeners() {
                document.querySelectorAll('.canvas-element').forEach(element => {
                    element.addEventListener('click', (e) => {
                        if (e.target.closest('.element-controls')) return;
                        this.selectElement(element);
                    });
                });
            }

            save() {
                const state = this.getState();
                localStorage.setItem('advanced-page-builder', JSON.stringify(state));
                this.showNotification('Page saved successfully!', 'success');
            }

            loadFromStorage() {
                const saved = localStorage.getItem('advanced-page-builder');
                if (saved) {
                    try {
                        const state = JSON.parse(saved);
                        this.setState(state);
                        this.updateHistory();
                    } catch (e) {
                        console.error('Error loading saved page:', e);
                    }
                }
            }

            exportHTML() {
                const canvas = document.getElementById('canvas-content');
                const cleanHTML = this.generateCleanHTML(canvas);
                const css = this.generateProfessionalCSS();
                
                const fullHTML = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        ${css}
    </style>
</head>
<body>
    ${cleanHTML}
</body>
</html>`;
                
                this.downloadFile(fullHTML, 'professional-page.html', 'text/html');
                this.showNotification('Professional HTML exported successfully!', 'success');
            }

            generateCleanHTML(canvas) {
                const elements = canvas.querySelectorAll('.canvas-element');
                let cleanHTML = '';
                
                elements.forEach(element => {
                    const widgetType = element.dataset.widgetType;
                    const widgetContent = element.cloneNode(true);
                    
                    // Remove builder controls
                    const controls = widgetContent.querySelector('.element-controls');
                    if (controls) {
                        controls.remove();
                    }
                    
                    // Clean up container content
                    if (widgetType === 'container') {
                        const container = widgetContent.querySelector('.widget-container');
                        if (container) {
                            // Remove placeholder text
                            const placeholder = container.querySelector('p');
                            if (placeholder && placeholder.textContent.includes('Container - Drag widgets here')) {
                                placeholder.remove();
                            }
                            
                            // Clean up nested elements
                            const nestedElements = container.querySelectorAll('.canvas-element');
                            nestedElements.forEach(nested => {
                                const nestedControls = nested.querySelector('.element-controls');
                                if (nestedControls) {
                                    nestedControls.remove();
                                }
                                nested.classList.remove('canvas-element');
                                nested.classList.add('widget-content');
                            });
                            
                            cleanHTML += container.outerHTML;
                        }
                    } else {
                        // Clean up other widgets
                        widgetContent.classList.remove('canvas-element');
                        widgetContent.classList.add('widget-content');
                        cleanHTML += widgetContent.outerHTML;
                    }
                });
                
                return cleanHTML || '<div class="empty-page"><p>No content to display</p></div>';
            }

            generateProfessionalCSS() {
                return `
                    /* Reset and Base Styles */
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                        background: #fff;
                    }
                    
                    /* Container Styles */
                    .widget-container {
                        background: #f8f9fa;
                        border: 2px dashed #dee2e6;
                        border-radius: 12px;
                        padding: 30px;
                        margin: 20px 0;
                        min-height: 120px;
                        display: flex;
                        flex-direction: column;
                        gap: 15px;
                        transition: all 0.3s ease;
                    }
                    
                    .widget-container:hover {
                        border-color: #3498db;
                        background: #e3f2fd;
                        transform: translateY(-2px);
                        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
                    }
                    
                    /* Widget Content */
                    .widget-content {
                        position: relative;
                        margin: 10px 0;
                    }
                    
                    /* Typography */
                    .widget-heading {
                        font-size: 2.5rem;
                        font-weight: 700;
                        color: #2c3e50;
                        margin: 20px 0;
                        line-height: 1.2;
                        text-align: left;
                    }
                    
                    .widget-paragraph {
                        font-size: 1.1rem;
                        color: #555;
                        line-height: 1.8;
                        margin: 15px 0;
                    }
                    
                    /* Buttons */
                    .widget-button {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 15px 30px;
                        border: none;
                        border-radius: 8px;
                        font-size: 1rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        text-decoration: none;
                        display: inline-block;
                        text-align: center;
                    }
                    
                    .widget-button:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
                    }
                    
                    /* Images */
                    .widget-image {
                        max-width: 100%;
                        height: auto;
                        border-radius: 12px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                        transition: transform 0.3s ease;
                    }
                    
                    .widget-image:hover {
                        transform: scale(1.02);
                    }
                    
                    /* Icons */
                    .widget-icon {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 15px;
                        background: #f8f9fa;
                        border-radius: 8px;
                        margin: 10px 0;
                    }
                    
                    .widget-icon i {
                        font-size: 1.5rem;
                        color: #3498db;
                    }
                    
                    .widget-icon span {
                        font-weight: 500;
                        color: #2c3e50;
                    }
                    
                    /* Icon Box */
                    .widget-icon-box {
                        text-align: center;
                        padding: 30px 20px;
                        background: white;
                        border-radius: 12px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                        transition: transform 0.3s ease;
                    }
                    
                    .widget-icon-box:hover {
                        transform: translateY(-5px);
                    }
                    
                    .widget-icon-box i {
                        font-size: 3rem;
                        color: #3498db;
                        margin-bottom: 15px;
                    }
                    
                    .widget-icon-box h3 {
                        font-size: 1.5rem;
                        font-weight: 600;
                        color: #2c3e50;
                        margin-bottom: 10px;
                    }
                    
                    .widget-icon-box p {
                        color: #666;
                        line-height: 1.6;
                    }
                    
                    /* Video */
                    .widget-video {
                        width: 100%;
                        height: 400px;
                        border-radius: 12px;
                        overflow: hidden;
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                    }
                    
                    .widget-video iframe {
                        width: 100%;
                        height: 100%;
                        border: none;
                    }
                    
                    /* Gallery */
                    .widget-gallery {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                        gap: 20px;
                        margin: 20px 0;
                    }
                    
                    .widget-gallery img {
                        width: 100%;
                        height: 200px;
                        object-fit: cover;
                        border-radius: 8px;
                        transition: transform 0.3s ease;
                    }
                    
                    .widget-gallery img:hover {
                        transform: scale(1.05);
                    }
                    
                    /* Carousel */
                    .widget-carousel {
                        position: relative;
                        overflow: hidden;
                        border-radius: 12px;
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                    }
                    
                    .widget-carousel img {
                        width: 100%;
                        height: 400px;
                        object-fit: cover;
                        display: block;
                    }
                    
                    /* Maps */
                    .widget-maps {
                        width: 100%;
                        height: 400px;
                        border-radius: 12px;
                        overflow: hidden;
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                    }
                    
                    /* Accordion */
                    .widget-accordion {
                        margin: 20px 0;
                    }
                    
                    .accordion-item {
                        border: 1px solid #e0e0e0;
                        border-radius: 8px;
                        margin-bottom: 10px;
                        overflow: hidden;
                    }
                    
                    .accordion-header {
                        background: #f8f9fa;
                        padding: 15px 20px;
                        cursor: pointer;
                        font-weight: 600;
                        color: #2c3e50;
                        transition: background 0.3s ease;
                    }
                    
                    .accordion-header:hover {
                        background: #e9ecef;
                    }
                    
                    .accordion-content {
                        padding: 20px;
                        background: white;
                        color: #555;
                        line-height: 1.6;
                    }
                    
                    /* Tabs */
                    .widget-tabs {
                        margin: 20px 0;
                    }
                    
                    .tab-nav {
                        display: flex;
                        border-bottom: 2px solid #e0e0e0;
                        margin-bottom: 20px;
                    }
                    
                    .tab-btn {
                        padding: 12px 24px;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-weight: 500;
                        color: #666;
                        transition: all 0.3s ease;
                    }
                    
                    .tab-btn.active {
                        color: #3498db;
                        border-bottom: 2px solid #3498db;
                    }
                    
                    .tab-content {
                        padding: 20px 0;
                    }
                    
                    /* Progress Bar */
                    .widget-progress {
                        margin: 20px 0;
                    }
                    
                    .progress-bar {
                        width: 100%;
                        height: 8px;
                        background: #e0e0e0;
                        border-radius: 4px;
                        overflow: hidden;
                    }
                    
                    .progress-fill {
                        height: 100%;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border-radius: 4px;
                        transition: width 0.3s ease;
                    }
                    
                    /* Star Rating */
                    .widget-star-rating {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        margin: 15px 0;
                    }
                    
                    .stars {
                        display: flex;
                        gap: 2px;
                    }
                    
                    .stars i {
                        color: #ffc107;
                        font-size: 1.2rem;
                    }
                    
                    .rating-text {
                        font-weight: 500;
                        color: #666;
                    }
                    
                    /* Social Icons */
                    .widget-social-icons {
                        display: flex;
                        gap: 15px;
                        margin: 20px 0;
                    }
                    
                    .social-icon {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 40px;
                        height: 40px;
                        background: #f8f9fa;
                        border-radius: 50%;
                        color: #666;
                        text-decoration: none;
                        transition: all 0.3s ease;
                    }
                    
                    .social-icon:hover {
                        background: #3498db;
                        color: white;
                        transform: translateY(-2px);
                    }
                    
                    /* Spacer */
                    .widget-spacer {
                        height: 50px;
                    }
                    
                    /* Divider */
                    .widget-divider {
                        height: 2px;
                        background: linear-gradient(90deg, transparent, #e0e0e0, transparent);
                        margin: 30px 0;
                    }
                    
                    /* Responsive Design */
                    @media (max-width: 768px) {
                        .widget-heading {
                            font-size: 2rem;
                        }
                        
                        .widget-container {
                            padding: 20px;
                            margin: 15px 0;
                        }
                        
                        .widget-gallery {
                            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                            gap: 15px;
                        }
                        
                        .widget-social-icons {
                            justify-content: center;
                        }
                    }
                    
                    @media (max-width: 480px) {
                        .widget-heading {
                            font-size: 1.5rem;
                        }
                        
                        .widget-container {
                            padding: 15px;
                        }
                        
                        .widget-gallery {
                            grid-template-columns: 1fr;
                        }
                    }
                    
                    /* Empty Page */
                    .empty-page {
                        text-align: center;
                        padding: 100px 20px;
                        color: #666;
                    }
                    
                    .empty-page p {
                        font-size: 1.2rem;
                    }
                `;
            }

            exportJSON() {
                const state = this.getState();
                this.downloadFile(JSON.stringify(state, null, 2), 'page.json', 'application/json');
                this.showNotification('JSON exported successfully!', 'success');
            }

            generateCSS() {
                // Generate CSS from current styles
                return `
                    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                    .canvas-element { margin-bottom: 20px; }
                    .widget-heading { font-size: 24px; font-weight: bold; color: #2c3e50; }
                    .widget-paragraph { font-size: 16px; color: #2c3e50; line-height: 1.6; }
                    .widget-button { background: #3498db; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; }
                    .widget-image { max-width: 100%; height: auto; border-radius: 8px; }
                `;
            }

            downloadFile(content, filename, type) {
                const blob = new Blob([content], { type });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }

            showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.textContent = message;
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
                    color: white;
                    padding: 12px 20px;
                    border-radius: 4px;
                    z-index: 10000;
                    font-weight: 500;
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        }

        // Initialize builder when page loads
        let builder;
        document.addEventListener('DOMContentLoaded', () => {
            builder = new AdvancedPageBuilder();
        });
    </script>
