<!DOCTYPE html>
<html>
<head>
    <title>Page Builder</title>
    <link href="{{ asset('vvvebjs/css/editor.css') }}" rel="stylesheet">
    <link href="{{ asset('vvvebjs/libs/builder/icons/style.min.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Must have this exact structure -->
    <div id="vvveb-builder">
        <div class="vvveb-builder-content">
            <iframe id="vvveb-editor-iframe" class="vvveb-editor-iframe"></iframe>
        </div>
    </div>

    <!-- Load jQuery first -->
    <script src="{{ asset('vvvebjs/libs/jquery/jquery.min.js') }}"></script>
    <!-- Then load builder -->
    <script src="{{ asset('vvvebjs/js/vvvebjs.js') }}"></script>

    <!-- Then builder components -->
    <script src="{{ asset('vvvebjs/libs/builder/builder.js') }}"></script>

    <script>
    $(document).ready(function() {
        // Verify all required components are loaded
        if (typeof Vvveb === 'undefined') {
            console.error('VVVeB core not loaded');
            return;
        }
        
        if (typeof Vvveb.Builder === 'undefined') {
            console.error('Builder component not loaded');
            return;
        }

        // Initialize with proper parameters
        Vvveb.Builder.init('{{ url("/") }}', {
            editorSelector: '#vvveb-builder',
            iframeUrl: '{{ url("/blank.html") }}', // Create this file
            saveUrl: '{{ route("page.save") }}',
            components: '{{ asset("vvvebjs/libs/builder/components.json") }}'
        });
    });
    </script>
</body>
</html>