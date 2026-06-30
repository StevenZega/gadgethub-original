<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - GadgetHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0f172a; font-family: 'Segoe UI', sans-serif; color: white; overflow-x: hidden; }
        .sidebar { position: fixed; left: 0; top: 0; width: 270px; height: 100vh; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(18px); border-right: 1px solid rgba(255,255,255,0.08); padding: 30px 22px; z-index: 100; }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 45px; font-size: 1.3rem; font-weight: 700; background: linear-gradient(135deg, #3b82f6, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-link { display: flex; align-items: center; gap: 14px; color: #cbd5e1; padding: 14px 18px; border-radius: 18px; margin-bottom: 12px; transition: all 0.3s ease; font-weight: 500; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: linear-gradient(135deg, #2563eb, #06b6d4); color: white; transform: translateX(5px); box-shadow: 0 10px 30px rgba(37,99,235,0.25); }
        .main-content { margin-left: 270px; padding: 30px; }
        .topbar { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(16px); border-radius: 28px; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .card-modern { background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(16px); border-radius: 28px; padding: 28px; box-shadow: 0 15px 40px rgba(0,0,0,0.25); transition: transform 0.3s ease; }
        .card-modern:hover { transform: translateY(-5px); border-color: rgba(59, 130, 246, 0.4); }
        .spec-input { background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: white !important; border-radius: 12px;}
        .spec-input option { background: #1e293b !important; color: white !important;} 
        .spec-input:focus { background: rgba(255,255,255,0.08) !important; color: white !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 0.2rem rgba(59,130,246,.25);}
        .spec-input::placeholder { color: rgba(255,255,255,0.5);}
        .spec-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 20px; margin-top: 20px;}
        .spec-title { color: white; font-weight: 600; margin-bottom: 20px;}
        .btn-modern { background: linear-gradient(135deg, #2563eb, #06b6d4); border: none; color: white; padding: 12px 24px; border-radius: 16px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-modern:hover { opacity: 0.9; transform: scale(1.02); color: white; }

        .text-penjelas {
            color: #f87171 !important; /* Warna Merah Cerah/Pastel (Sangat Kontras di Background Gelap) */
            font-size: 0.875rem;
            font-weight: 500;
        }
        .text-penjelas-label {
            color: #ef4444 !important; /* Warna Merah Solid untuk Judul Kecil di Dalam Card */
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-phone-vibrate text-primary"></i> GadgetHub Admin
        </div>
        <a href="{{ url('/admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
        <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill"></i> Kelola Produk
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}">
            <i class="bi bi-cart-fill"></i> Pesanan
        </a>
        
        <a href="{{ route('promos.index') }}" class="nav-link {{ Request::is('admin/promos*') ? 'active' : '' }}">
            <i class="bi bi-ticket-perforated-fill"></i> Promo
        </a>

        <a href="{{ route('admin.profile') }}" class="nav-link {{ Request::is('admin/profile*') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i> Profil Admin
        </a>

        <a href="#" class="nav-link">
            <i class="bi bi-bar-chart-line-fill"></i> Statistik
        </a>

        <form action="/logout" method="POST" class="mt-4 px-2">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-3 py-2 fw-medium">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h4 class="m-0 fw-bold">Panel Kontrol Utama</h4>
                <small class="text-white">Kelola produk dan pantau statistik penjualan gadget</small>
            </div>
            <div>
                <span class="badge bg-secondary px-3 py-2 rounded-pill">Status: Admin Aktif</span>
            </div>
        </div>

        @if(View::hasSection('content'))
            @yield('content')
        @else
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card-modern">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-white text-uppercase small mb-0 tracking-wider">Total Produk</h6>
                            <i class="bi bi-box text-primary fs-4"></i>
                        </div>
                        <h2 class="fw-bold display-6 m-0">-</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-white text-uppercase small mb-0 tracking-wider">Penjualan Hari Ini</h6>
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                        </div>
                        <h2 class="fw-bold display-6 m-0 text-success">Rp -</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-modern">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-white text-uppercase small mb-0 tracking-wider">Pesanan Masuk</h6>
                            <i class="bi bi-cart-check text-info fs-4"></i>
                        </div>
                        <h2 class="fw-bold display-6 m-0 text-info">-</h2>
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">
                    <div>
                        <h4 class="fw-bold mb-2">Selamat Datang 👋</h4>
                        <p class="text-white mb-0">Kelola semua data produk dan pantau performa toko dengan tampilan modern.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn-modern">
                        Kelola Produk
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>