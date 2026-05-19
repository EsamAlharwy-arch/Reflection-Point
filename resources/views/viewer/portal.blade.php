<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRVault - Welcome Portal</title>
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #050811;
            --surface-color: rgba(17, 24, 39, 0.4);
            --border-color: rgba(255, 255, 255, 0.08);
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --accent-glow: rgba(59, 130, 246, 0.25);
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Cairo', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-y: auto;
            position: relative;
            padding: 3rem 1rem;
            
            /* Animated gradient background */
            background-image: radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                              radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.12) 0%, transparent 50%);
        }

        /* Abstract glowing blobs for premium feel */
        .glow-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: var(--primary-gradient);
            filter: blur(140px);
            opacity: 0.15;
            z-index: 0;
            animation: floatGlow 15s infinite alternate ease-in-out;
        }

        .blob-1 { top: -100px; left: -100px; }
        .blob-2 { bottom: -100px; right: -100px; animation-delay: -5s; }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(80px, 50px) scale(1.2); }
        }

        .portal-container {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 800px;
            padding: 2.5rem;
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                        0 0 40px rgba(59, 130, 246, 0.08);
            margin: 1.5rem;
            animation: fadeInScale 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes fadeInScale {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Logo Branding */
        .brand {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 900;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.03em;
        }

        .brand svg {
            color: #3b82f6;
            filter: drop-shadow(0 0 10px rgba(59,130,246,0.5));
        }

        /* Large Glowing QR Section */
        .qr-outer-ring {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.3) 100%);
            padding: 8px;
            border-radius: 2rem;
            margin-bottom: 2rem;
            position: relative;
            box-shadow: 0 0 35px var(--accent-glow);
            animation: borderPulse 3s infinite alternate ease-in-out;
        }

        @keyframes borderPulse {
            0% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.15); }
            100% { box-shadow: 0 0 45px rgba(139, 92, 246, 0.35); }
        }

        .qr-inner-wrapper {
            background: white;
            padding: 1.75rem;
            border-radius: 1.75rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qr-inner-wrapper svg {
            width: 320px;
            height: 320px;
            display: block;
        }

        /* Instructions & Typography */
        .instructions-header {
            margin-bottom: 0.5rem;
        }
        
        .title-ar {
            font-family: 'Cairo', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: white;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }

        .title-en {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #e5e7eb;
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
        }

        .sub-instructions {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            font-size: 0.925rem;
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 550px;
        }

        .wifi-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: 1.25rem;
            text-transform: uppercase;
        }

        /* Bottom Controls / Admin Link */
        .bottom-actions {
            position: absolute;
            bottom: 1.5rem;
            right: 2rem;
            z-index: 100;
        }

        .admin-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.25);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .admin-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border-color);
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .portal-container {
                padding: 2rem;
                margin: 1.5rem 1rem;
            }
            .qr-inner-wrapper svg {
                width: 270px;
                height: 270px;
            }
            .title-ar { font-size: 1.6rem; }
            .title-en { font-size: 1.3rem; }
        }

        @media (max-width: 480px) {
            .portal-container {
                padding: 1.5rem 1rem;
                border-radius: 1.75rem;
            }
            .brand {
                font-size: 1.75rem;
                margin-bottom: 1rem;
            }
            .qr-outer-ring {
                padding: 5px;
                border-radius: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .qr-inner-wrapper {
                padding: 1rem;
                border-radius: 1.25rem;
            }
            .qr-inner-wrapper svg {
                width: 210px;
                height: 210px;
            }
            .title-ar { font-size: 1.35rem; }
            .title-en { font-size: 1.1rem; }
            .sub-instructions {
                padding: 0.75rem;
                font-size: 0.85rem;
            }
            .bottom-actions {
                position: static;
                margin-top: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Glowing backgrounds -->
    <div class="glow-blob blob-1"></div>
    <div class="glow-blob blob-2"></div>

    <!-- Main QR Container -->
    <div class="portal-container">
        
        <!-- Branding Logo -->
        <div class="brand">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Reflection Point 
        </div>

        <!-- Pulse Glowing Barcode Outer -->
        <div class="qr-outer-ring">
            <div class="qr-inner-wrapper">
                <!-- Massive QR Code pointing directly to public files repository /vault -->
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(320)->margin(0)->generate($vaultPortalUrl) !!}
            </div>
        </div>

        <!-- Instructions (Arabic & English) -->
        <div class="instructions-header">
            <h2 class="title-ar">امسح الباركود بهاتفك لتصفح الملفات</h2>
            <h3 class="title-en">Scan QR Code to Browse Documents</h3>
        </div>

        <div class="sub-instructions">
            <p style="margin-bottom: 0.5rem; direction: rtl; text-align: center; font-family: 'Cairo', sans-serif;">
                الرجاء التأكد من اتصال هاتفك بشبكة الواي فاي (Wi-Fi) الخاصة بنا أولاً، ثم قم بمسح هذا الباركود للوصول إلى مستودع المستندات والملفات الآمن.
            </p>
            <p style="font-size: 0.85rem; opacity: 0.8; font-style: italic; direction: ltr; text-align: center;">
Please make sure your phone is connected to our Wi-Fi network first, then scan this barcode to access the secure document and file repository.            </p>
        </div>

        <!-- Local connection notice -->
        <div class="wifi-badge">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-right: 0.25rem;">
                <path d="M12 20h.01M8.5 16.5a5 5 0 017 0M5 13a10 10 0 0114 0M1.5 9.5a15 15 0 0121 0"></path>
            </svg>
            Local Network Secured Viewer
        </div>

    </div>

    <!-- Admin Panel Backdoor -->
    <div class="bottom-actions">
        <a href="{{ route('login') }}" class="admin-link">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Admin Panel / لوحة التحكم
        </a>
    </div>

</body>
</html>
