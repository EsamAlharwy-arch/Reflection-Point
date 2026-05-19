<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRVault Viewer - {{ $file->filename }}</title>
    <!-- Use vanilla CSS -->
    <style>
        :root {
            --bg-color: #0f172a;
            --surface-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --primary-color: #3b82f6;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            
            /* Anti-Download & Anti-Selection CSS */
            user-select: none;
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        .header {
            background-color: var(--surface-color);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .file-info {
            display: flex;
            flex-direction: column;
        }

        .filename {
            font-weight: 600;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-meta {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .security-badge {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid rgba(16, 185, 129, 0.2);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .viewer-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            position: relative;
            overflow: hidden;
            background-image: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        }

        .media-content {
            max-width: 100%;
            max-height: calc(100vh - 80px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            pointer-events: none; /* Helps deter right click save on img */
            -webkit-user-drag: none;
            -webkit-touch-callout: none;
        }
        
        .media-wrapper {
            position: relative;
            padding: 2rem;
        }

        iframe.pdf-viewer {
            width: 100%;
            height: calc(100vh - 80px); /* Fill screen minus header */
            border: none;
            background-color: #323639;
        }
    </style>
</head>
<body oncontextmenu="return false;">

    <header class="header">
        <div class="file-info">
            <span class="filename">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                {{ $file->filename }}
            </span>
            <span class="file-meta">{{ number_format($file->size / 1024 / 1024, 2) }} MB • {{ strtoupper(explode('/', $file->mime_type)[1] ?? 'FILE') }}</span>
        </div>
        <div class="security-badge">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Secure View
        </div>
    </header>

    @if(str_starts_with($file->mime_type, 'image/'))
        <div class="viewer-container">
            <div class="media-wrapper">
                <img src="{{ route('viewer.stream', $file->token) }}" alt="Secure Image" class="media-content">
            </div>
        </div>
    @elseif(str_starts_with($file->mime_type, 'video/'))
        <div class="viewer-container">
            <div class="media-wrapper">
                <video src="{{ route('viewer.stream', $file->token) }}" class="media-content" style="pointer-events: auto;" controls controlsList="nodownload noplaybackrate" disablePictureInPicture></video>
            </div>
        </div>
    @elseif($file->mime_type === 'application/pdf')
        <!-- Integrate fully offline PDF.js -->
        <iframe class="pdf-viewer" src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(route('viewer.stream', $file->token)) }}#toolbar=0" title="PDF Viewer"></iframe>
    @else
        <div class="viewer-container" style="text-align: center; padding: 2rem;">
            <div style="background: rgba(15, 23, 42, 0.8); padding: 3rem; border-radius: 1rem; border: 1px solid var(--border-color);">
                <svg width="64" height="64" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 1rem;">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <h3>Cannot Preview File</h3>
                <p class="file-meta" style="margin-top: 0.5rem; max-width: 300px;">This file type ({{ $file->mime_type }}) cannot be securely previewed in the browser.</p>
            </div>
        </div>
    @endif

    <script>
        // Disable keyboard shortcuts for print, save, copy
        document.addEventListener('keydown', function(e) {
            if (
                (e.ctrlKey && e.key === 'p') || // Print
                (e.ctrlKey && e.key === 's') || // Save
                (e.ctrlKey && e.key === 'c') || // Copy
                (e.ctrlKey && e.key === 'x') || // Cut
                (e.ctrlKey && e.key === 'u') || // View source
                (e.key === 'F12')               // DevTools
            ) {
                e.preventDefault();
                return false;
            }
        });
        
        // Prevent drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>
