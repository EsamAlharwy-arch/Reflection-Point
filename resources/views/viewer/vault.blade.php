<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflection point - Secure Files Repository</title>
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #090d16;
            --surface-color: #111827;
            --surface-card: #1f2937;
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --accent-glow: rgba(59, 130, 246, 0.15);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.05) 0%, transparent 40%);
            background-attachment: fixed;
            
            /* Anti-copy/selection measures */
            user-select: none;
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* Glassmorphic Navigation */
        .navbar {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 1.25rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .security-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success-color);
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }

        .container {
            max-width: 1400px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        /* Header Layout */
        .header-section {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .header-section h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .header-section p {
            color: var(--text-muted);
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Interactive Filters & Search */
        .controls-wrapper {
            background: rgba(17, 24, 39, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .search-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 280px;
        }

        .search-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            width: 1.25rem;
            height: 1.25rem;
        }

        .search-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3.25rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            background-color: rgba(9, 13, 22, 0.6);
            color: var(--text-main);
            outline: none;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.25s;
        }

        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .layout-toggle {
            display: flex;
            background: rgba(9, 13, 22, 0.6);
            border: 1px solid var(--border-color);
            padding: 0.25rem;
            border-radius: 0.75rem;
            gap: 0.25rem;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: inherit;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .toggle-btn.active {
            background: var(--surface-card);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Filter Tabs */
        .tabs-row {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none; /* Firefox */
        }

        .tabs-row::-webkit-scrollbar {
            display: none; /* Safari & Chrome */
        }

        .tab-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 0.6rem 1.25rem;
            border-radius: 9999px;
            cursor: pointer;
            white-space: nowrap;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.25s;
        }

        .tab-item:hover {
            border-color: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .tab-item.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .stats-counter {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Grid View Layout */
        .files-container.grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .files-container.grid-layout .file-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
        }

        .files-container.grid-layout .file-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 
                        0 0 15px var(--accent-glow);
        }

        .files-container.grid-layout .icon-preview {
            background: rgba(255, 255, 255, 0.02);
            height: 140px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        /* Color-coded file previews inside grid */
        .file-card[data-type="pdf"] .icon-preview {
            background: radial-gradient(circle, rgba(239, 68, 68, 0.08) 0%, transparent 70%);
            color: #ef4444;
        }
        .file-card[data-type="image"] .icon-preview {
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            color: #10b981;
        }
        .file-card[data-type="video"] .icon-preview {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            color: #3b82f6;
        }
        .file-card[data-type="other"] .icon-preview {
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
            color: #8b5cf6;
        }

        .files-container.grid-layout .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            flex: 1;
        }

        .files-container.grid-layout .file-name {
            font-size: 1rem;
            font-weight: 600;
            color: white;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-all;
            height: 2.8rem;
        }

        .files-container.grid-layout .meta-info {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: auto;
        }

        .badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* List View Layout */
        .files-container.list-layout {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .files-container.list-layout .file-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.75rem 1.25rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1.25rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .files-container.list-layout .file-card:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.02);
            transform: translateX(4px);
        }

        .files-container.list-layout .icon-preview {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .files-container.list-layout .card-body {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            flex: 1;
            gap: 1.5rem;
        }

        .files-container.list-layout .file-name {
            font-size: 1rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-all;
            flex: 1;
        }

        .files-container.list-layout .meta-info {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-shrink: 0;
        }

        /* Filter states classes */
        .file-card.hidden {
            display: none !important;
        }

        /* Empty State */
        .empty-state {
            display: none;
            padding: 6rem 2rem;
            text-align: center;
            color: var(--text-muted);
            background-color: var(--surface-color);
            border-radius: 1.25rem;
            border: 2px dashed var(--border-color);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
        }

        .empty-state svg {
            color: var(--text-muted);
            opacity: 0.4;
        }

        .empty-state h3 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn-clear {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        
        .btn-clear:hover {
            opacity: 0.9;
        }

        /* Full Screen Viewer Modal Overlay */
        .viewer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 9, 15, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 9999;
            display: none;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .viewer-overlay.active {
            display: flex;
            opacity: 1;
        }

        .viewer-header {
            padding: 1rem 2rem;
            background: rgba(17, 24, 39, 0.6);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10000;
        }

        .viewer-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 60%;
            word-break: break-all;
        }

        .viewer-close-btn {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 700;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .viewer-close-btn:hover {
            background: #dc2626;
        }

        .viewer-body {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: calc(100vh - 65px);
        }

        .viewer-iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: transparent;
        }

        /* Loading Spinner inside Modal */
        .viewer-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer styling */
        .footer {
            margin-top: 5rem;
            padding: 2.5rem 0;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .navbar { padding: 1rem 1.25rem; }
            .header-section h1 { font-size: 1.85rem; }
            .container { margin: 1.5rem auto; }
            
            .files-container.list-layout .file-card {
                padding: 0.75rem;
                gap: 0.75rem;
            }
            .files-container.list-layout .card-body {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.35rem;
            }
            
            .viewer-header { padding: 0.75rem 1rem; }
            .viewer-title { font-size: 0.95rem; max-width: 50%; }
        }
    </style>
</head>
<body oncontextmenu="return false;">

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Reflection point
        </div>
        <div class="security-indicator">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <path d="M20 6L9 17l-5-5"></path>
            </svg>
            Secure Viewer Active
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        
        <!-- Header -->
        <header class="header-section">
            <h1>Secure Document Vault</h1>
            <p>Select a file to securely view it in place. Saving or printing is strictly prohibited.</p>
        </header>

        <!-- Search, View Switch, Categories Controls -->
        <div class="controls-wrapper">
            
            <!-- Search & View Toggle -->
            <div class="search-row">
                <div class="search-box">
                    <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search through synced files...">
                </div>

                <!-- Grid/List Switcher -->
                <div class="layout-toggle">
                    <button class="toggle-btn active" id="gridToggleBtn" onclick="switchLayout('grid')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        Grid
                    </button>
                    <button class="toggle-btn" id="listToggleBtn" onclick="switchLayout('list')">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg>
                        List
                    </button>
                </div>
            </div>

            <!-- Categories Tabs & Filter Count -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div class="tabs-row" id="tabsRow">
                    <button class="tab-item active" onclick="filterCategory('all', this)">All Files</button>
                    <button class="tab-item" onclick="filterCategory('pdf', this)">Documents (PDF)</button>
                    <button class="tab-item" onclick="filterCategory('image', this)">Images</button>
                    <button class="tab-item" onclick="filterCategory('video', this)">Videos</button>
                    <button class="tab-item" onclick="filterCategory('other', this)">Others</button>
                </div>
                
                <div class="stats-counter">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span id="counterText">Showing {{ $files->count() }} of {{ $files->count() }} files</span>
                </div>
            </div>

        </div>

        <!-- Files List/Grid Wrapper -->
        <div class="files-container grid-layout" id="filesContainer">
            
            @if($files->count() > 0)
                @foreach($files as $file)
                    @php
                        // Detect file categories
                        $type = 'other';
                        $mime = $file->mime_type;
                        if ($mime === 'application/pdf') {
                            $type = 'pdf';
                        } elseif (str_starts_with($mime, 'image/')) {
                            $type = 'image';
                        } elseif (str_starts_with($mime, 'video/')) {
                            $type = 'video';
                        }
                    @endphp
                    
                    <!-- File Card -->
                    <div class="file-card" data-type="{{ $type }}" data-name="{{ strtolower($file->filename) }}" onclick="openSecureViewer('{{ $file->token }}', '{{ addslashes($file->filename) }}')">
                        
                        <!-- Grid View Preview -->
                        <div class="icon-preview">
                            @if($type === 'pdf')
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <path d="M16 13H8m8 4H8"></path>
                                </svg>
                            @elseif($type === 'image')
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            @elseif($type === 'video')
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                </svg>
                            @else
                                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                            @endif
                        </div>

                        <!-- Card Body (Grid Details) / Content (List Details) -->
                        <div class="card-body">
                            <div class="file-name" title="{{ $file->filename }}">{{ $file->filename }}</div>
                            <div class="meta-info">
                                <span class="badge">{{ number_format($file->size / 1024 / 1024, 2) }} MB</span>
                                <span class="badge">{{ strtoupper($type) }}</span>
                            </div>
                        </div>

                    </div>
                @endforeach
            @endif

        </div>

        <!-- Empty State -->
        <div class="empty-state" id="emptyState">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <h3>No files found</h3>
            <p>Try refining your search keyword or clearing the filters.</p>
            <button class="btn-clear" onclick="clearAllFilters()">Clear Filters & Search</button>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} Reflection point. Powered by Secure Offline Storage.</p>
        <p style="margin-top: 0.5rem; opacity: 0.5; font-size: 0.75rem;">Unauthorized duplication or tampering will log user IP address.</p>
    </footer>

    <!-- Secure Full Screen Viewer Modal -->
    <div class="viewer-overlay" id="viewerOverlay">
        
        <!-- Viewer Header -->
        <header class="viewer-header">
            <div class="viewer-title" id="viewerTitle">Secure File Preview</div>
            <button class="viewer-close-btn" onclick="closeSecureViewer()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Close Document
            </button>
        </header>

        <!-- Viewer Body -->
        <div class="viewer-body">
            <!-- Spinner -->
            <div class="viewer-loader" id="viewerLoader">
                <div class="spinner"></div>
                <span>Securing document preview...</span>
            </div>
            <!-- Secure Iframe Sandbox -->
            <iframe src="" class="viewer-iframe" id="viewerIframe" sandbox="allow-scripts allow-same-origin allow-forms"></iframe>
        </div>
    </div>

    <!-- Interactive Scripts & Security Handlers -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const filesContainer = document.getElementById('filesContainer');
        const emptyState = document.getElementById('emptyState');
        const counterText = document.getElementById('counterText');
        const fileCards = Array.from(document.querySelectorAll('.file-card'));
        const viewerOverlay = document.getElementById('viewerOverlay');
        const viewerTitle = document.getElementById('viewerTitle');
        const viewerIframe = document.getElementById('viewerIframe');
        const viewerLoader = document.getElementById('viewerLoader');

        let activeCategory = 'all';
        let searchQuery = '';

        // 1. Live Instant Search Filter
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase().trim();
            applyFilters();
        });

        // 2. Category Tab Filter
        function filterCategory(category, buttonElement) {
            // Update active state in tabs
            const tabs = document.querySelectorAll('.tab-item');
            tabs.forEach(tab => tab.classList.remove('active'));
            buttonElement.classList.add('active');

            activeCategory = category;
            applyFilters();
        }

        // 3. Main Filter Combinator (Search + Category)
        function applyFilters() {
            let visibleCount = 0;

            fileCards.forEach(card => {
                const type = card.getAttribute('data-type');
                const name = card.getAttribute('data-name');

                const matchesCategory = (activeCategory === 'all' || type === activeCategory);
                const matchesSearch = (searchQuery === '' || name.includes(searchQuery));

                if (matchesCategory && matchesSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Handle empty states & stats counters
            if (visibleCount === 0) {
                filesContainer.style.display = 'none';
                emptyState.style.display = 'flex';
            } else {
                filesContainer.style.display = filesContainer.classList.contains('grid-layout') ? 'grid' : 'flex';
                emptyState.style.display = 'none';
            }

            counterText.textContent = `Showing ${visibleCount} of ${fileCards.length} files`;
        }

        // 4. Layout Switcher (Grid <=> List)
        function switchLayout(layout) {
            const gridBtn = document.getElementById('gridToggleBtn');
            const listBtn = document.getElementById('listToggleBtn');

            if (layout === 'grid') {
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                
                filesContainer.classList.remove('list-layout');
                filesContainer.classList.add('grid-layout');
                
                if (emptyState.style.display !== 'flex') {
                    filesContainer.style.display = 'grid';
                }
            } else {
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                
                filesContainer.classList.remove('grid-layout');
                filesContainer.classList.add('list-layout');

                if (emptyState.style.display !== 'flex') {
                    filesContainer.style.display = 'flex';
                }
            }
        }

        // 5. Clear filters button action
        function clearAllFilters() {
            searchInput.value = '';
            searchQuery = '';
            
            // Activate first tab
            const firstTab = document.querySelector('.tab-item');
            filterCategory('all', firstTab);
        }

        // 6. Secure Full Screen Viewer Controls
        function openSecureViewer(token, filename) {
            // Lock body scroll
            document.body.style.overflow = 'hidden';

            viewerTitle.textContent = `Viewing Document: ${filename}`;
            viewerLoader.style.opacity = '1';
            viewerLoader.style.display = 'flex';
            
            // Build absolute stream route URL inside sandboxed iframe
            const viewUrl = `/view/${token}`;
            viewerIframe.src = viewUrl;

            // Display overlay
            viewerOverlay.style.display = 'flex';
            setTimeout(() => {
                viewerOverlay.classList.add('active');
            }, 10);

            // Hide spinner when iframe finishes loading
            viewerIframe.onload = () => {
                viewerLoader.style.opacity = '0';
                setTimeout(() => {
                    viewerLoader.style.display = 'none';
                }, 300);
            };
        }

        function closeSecureViewer() {
            // Unlock body scroll
            document.body.style.overflow = '';
            
            viewerOverlay.classList.remove('active');
            
            setTimeout(() => {
                viewerOverlay.style.display = 'none';
                viewerIframe.src = '';
            }, 300);
        }

        // 7. Strict Keyboard Security & Prints block
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

        // 8. Prevent Drag and Drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>
