<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .grid-container {
            display: grid;
            gap: 20px;
        }
        
        .grid-item {
            padding: 20px;
        }
        
        .preview-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        
        .preview-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .preview-content {
            min-height: 400px;
        }
        
        .loading {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <h1 class="preview-title">Page Preview</h1>
        <div class="preview-actions">
            <a href="javascript:window.close()" class="btn btn-secondary">
                <i class="ri-close-line"></i> Close
            </a>
            <a href="javascript:window.print()" class="btn btn-primary">
                <i class="ri-printer-line"></i> Print
            </a>
        </div>
    </div>
    
    <div class="preview-content" id="previewContent">
        <div class="loading">
            <i class="ri-loader-4-line" style="font-size: 2rem; animation: spin 1s linear infinite;"></i>
            <p>Loading preview...</p>
        </div>
    </div>

    <script>
        // Get preview content from localStorage
        const previewId = '{{ $previewId }}';
        const previewContent = document.getElementById('previewContent');
        
        try {
            const savedPreview = localStorage.getItem(`preview_${previewId}`);
            
            if (savedPreview) {
                const previewData = JSON.parse(savedPreview);
                previewContent.innerHTML = previewData.content;
            } else {
                previewContent.innerHTML = `
                    <div class="error">
                        <i class="ri-error-warning-line"></i>
                        <strong>Preview not found!</strong><br>
                        The preview content could not be loaded. Please try generating a new preview from the page builder.
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading preview:', error);
            previewContent.innerHTML = `
                <div class="error">
                    <i class="ri-error-warning-line"></i>
                    <strong>Error loading preview!</strong><br>
                    There was an error loading the preview content. Please try again.
                </div>
            `;
        }
        
        // Add spin animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>

