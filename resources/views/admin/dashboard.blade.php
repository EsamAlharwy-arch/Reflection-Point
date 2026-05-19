<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRVault - Admin Dashboard</title>
    <!-- Modern Dark Theme -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        :root {
            --bg-color: #0f172a;
            --surface-color: #1e293b;
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --success-color: #10b981;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--surface-color);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--primary-color); color: white; width: 100%; text-align: center; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-danger { background-color: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 0.5rem 1rem; }
        .btn-danger:hover { background-color: #ef4444; color: white; }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .header-actions h2 { font-size: 1.8rem; margin-bottom: 0.25rem; }

        /* Grid Layout */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .file-card {
            background-color: var(--surface-color);
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, border-color 0.2s;
        }

        .file-card:hover {
            transform: translateY(-5px);
            border-color: #475569;
        }

        .qr-section {
            background-color: #ffffff;
            padding: 2.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .qr-section svg {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }

        .file-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #fff;
            word-break: break-all;
            line-height: 1.4;
        }

        .file-details {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .badge {
            background: rgba(255,255,255,0.05);
            padding: 0.25rem 0.6rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            border: 1px solid rgba(255,255,255,0.1);
            font-weight: 500;
        }

        .empty-state {
            padding: 5rem 2rem;
            text-align: center;
            color: var(--text-muted);
            background-color: var(--surface-color);
            border-radius: 1rem;
            border: 1px dashed var(--border-color);
            grid-column: 1 / -1;
        }

        /* Search & Pagination */
        .search-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .search-input {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background-color: var(--bg-color);
            color: white;
            outline: none;
            min-width: 250px;
        }
        .search-input:focus {
            border-color: var(--primary-color);
        }
        
        .pagination {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 3rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            text-decoration: none;
            display: inline-block;
        }
        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        .page-item.disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }

        /* General Portal QR Card */
        .portal-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 2.25rem;
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2.5rem;
            align-items: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 0 20px rgba(59, 130, 246, 0.12);
        }
        
        @media (max-width: 768px) {
            .portal-card {
                grid-template-columns: 1fr;
                text-align: center;
                padding: 1.5rem;
            }
            .portal-qr-section {
                margin: 0 auto;
            }
        }
        
        .portal-qr-section {
            background: white;
            padding: 1rem;
            border-radius: 0.75rem;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 220px;
            height: 220px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .portal-info-section {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .portal-title-badge {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
            align-self: flex-start;
        }
        @media (max-width: 768px) {
            .portal-title-badge {
                align-self: center;
            }
        }
        
        .portal-url-box {
            display: flex;
            align-items: center;
            background: rgba(0,0,0,0.25);
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .portal-url-text {
            font-family: monospace;
            color: var(--text-muted);
            font-size: 0.9rem;
            word-break: break-all;
            flex: 1;
        }
        
        .portal-btn-group {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">QRVault</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </nav>

    <div class="container">
        @if(session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <strong>Error:</strong> {{ $errors->first() }}
            </div>
        @endif

        <!-- General Attendees Portal -->
        @php
            $vaultPortalUrl = $baseUrl . '/vault';
        @endphp
        <div class="portal-card">
            <div class="portal-qr-section" id="portal-qr-code">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->margin(1)->generate($vaultPortalUrl) !!}
            </div>
            <div class="portal-info-section">
                <div class="portal-title-badge">Attendees Access Portal</div>
                <h2 style="font-size: 1.65rem; color: white; font-weight: 700; margin-bottom: 0.25rem;">General Scannable QR Code</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 0.5rem;">
                    Display or print this QR Code at the workshop/seminar registration desk. 
                    Attendees will scan this single barcode to browse, search, and view all files securely. 
                    No login is required.
                </p>
                <div class="portal-url-box">
                    <svg width="16" height="16" fill="none" stroke="var(--text-muted)" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path></svg>
                    <span class="portal-url-text" id="portal-url-text">{{ $vaultPortalUrl }}</span>
                </div>
                <div class="portal-btn-group">
                    <button onclick="printPortalQr()" class="btn" style="background-color: var(--success-color); color: white; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print QR Code
                    </button>
                    <button onclick="copyPortalLink()" class="btn" id="btn-copy-portal" style="background-color: rgba(255,255,255,0.08); color: white; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 0.5rem;">
                        Copy Link
                    </button>
                    <a href="{{ $vaultPortalUrl }}" target="_blank" class="btn" style="background-color: var(--primary-color); color: white; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        Open Portal
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="header-actions">
            <div>
                <h2>Files Vault</h2>
                <p style="color: var(--text-muted);">Synced files ready for offline secure viewing</p>
                <form action="{{ route('admin.dashboard') }}" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Search files by name..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary" style="width: auto;">Search</button>
                    @if(request('search'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger" style="display: flex; align-items: center;">Clear</a>
                    @endif
                </form>
            </div>
            <div style="text-align: right; display: flex; flex-direction: column; gap: 1rem; align-items: flex-end;">
                <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 0.5rem; align-items: center; background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 0.5rem; border: 1px dashed var(--border-color);">
                    @csrf
                    <input type="file" name="file" required style="color: var(--text-muted); font-size: 0.875rem;" accept="image/*,video/*,application/pdf">
                    <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.4rem 1rem;">Upload File</button>
                </form>
                
                <form action="{{ route('admin.sync') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="background-color: var(--success-color); color: white; border: none; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Sync Now
                    </button>
                </form>
            </div>
        </div>

        <div class="grid-container">
            @if($files->count() > 0)
                @foreach($files as $file)
                    @php
                        $viewUrl = $baseUrl . '/view/' . $file->token;
                    @endphp
                    <div class="file-card">
                        <!-- Big QR Code Section -->
                        <div class="qr-section">
                            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->margin(1)->generate($viewUrl) !!}
                        </div>
                        
                        <!-- File Details -->
                        <div class="card-body">
                            <div class="file-name" title="{{ $file->filename }}">{{ \Illuminate\Support\Str::limit($file->filename, 50) }}</div>
                            <div class="file-details">
                                <span class="badge">{{ number_format($file->size / 1024 / 1024, 2) }} MB</span>
                                <span class="badge">{{ strtoupper(explode('/', $file->mime_type)[1] ?? 'FILE') }}</span>
                                <span class="badge">{{ $file->created_at->format('M d, H:i') }}</span>
                            </div>
                            
                            <div style="margin-top: auto; padding-top: 1rem;">
                                <a href="{{ $viewUrl }}" target="_blank" class="btn btn-primary">Preview File</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.5;">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <h3>No files found</h3>
                    <p style="margin-top: 0.5rem;">Drop files into <code>storage/app/private/uploads</code> and run the sync command.</p>
                </div>
            @endif
        </div>

        @if($files->hasPages())
            {{ $files->links('pagination::bootstrap-4') }}
        @endif
    </div>

    <!-- Interactive Scripts for Portal Card -->
    <script>
        function printPortalQr() {
            const qrSvg = document.getElementById('portal-qr-code').innerHTML;
            const url = document.getElementById('portal-url-text').textContent;
            const printWindow = window.open('', '_blank', 'width=600,height=600');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print Attendees QR Portal</title>
                    <style>
                        body {
                            font-family: 'Inter', sans-serif;
                            text-align: center;
                            padding: 3rem;
                            color: #0f172a;
                        }
                        .container {
                            max-width: 450px;
                            margin: 0 auto;
                            border: 2px solid #e2e8f0;
                            border-radius: 1.5rem;
                            padding: 3rem 2rem;
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
                        }
                        .logo {
                            font-size: 1.75rem;
                            font-weight: 800;
                            margin-bottom: 0.5rem;
                            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            display: inline-block;
                        }
                        .qr-wrapper {
                            margin: 2.5rem auto;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                        .qr-wrapper svg {
                            width: 250px;
                            height: 250px;
                        }
                        .title {
                            font-size: 1.5rem;
                            font-weight: 700;
                            margin-bottom: 1rem;
                        }
                        .subtitle {
                            color: #64748b;
                            font-size: 0.95rem;
                            margin-bottom: 1.5rem;
                            line-height: 1.5;
                        }
                        .url {
                            font-family: monospace;
                            background: #f1f5f9;
                            padding: 0.75rem;
                            border-radius: 0.5rem;
                            font-size: 0.85rem;
                            word-break: break-all;
                            color: #334155;
                            border: 1px solid #e2e8f0;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="logo">QRVault</div>
                        <div class="title">Secure Document Portal</div>
                        <div class="subtitle">Scan this QR code to access the general document repository. You can search, browse, and view all files securely without any downloads.</div>
                        <div class="qr-wrapper">\${qrSvg}</div>
                        <div class="url">\${url}</div>
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() { window.close(); }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        function copyPortalLink() {
            const urlText = document.getElementById('portal-url-text').textContent;
            navigator.clipboard.writeText(urlText).then(() => {
                const btn = document.getElementById('btn-copy-portal');
                const originalText = btn.innerHTML;
                btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="color: var(--success-color);"><path d="M20 6L9 17l-5-5"></path></svg> Copied!`;
                btn.style.borderColor = 'var(--success-color)';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.borderColor = 'var(--border-color)';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>
