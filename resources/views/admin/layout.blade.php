<!DOCTYPE html>
    <title>Gadget Store Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 270px;
            height: 100vh;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(18px);
            border-right: 1px solid rgba(255,255,255,0.08);
            padding: 30px 22px;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 45px;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 10px 30px rgba(59,130,246,0.3);
        }
        .logo h3 {
            font-size: 1.2rem;
            margin: 0;
            font-weight: 700;
        }

        .logo span {
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .menu-title {
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #cbd5e1;
            padding: 14px 18px;
            border-radius: 18px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(37,99,235,0.25);
        }

        .main-content {
            margin-left: 270px;
            padding: 30px;
        }

        .topbar {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

         .topbar h2 {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .topbar p {
            color: #94a3b8;
            margin: 0;
        }

        .search-box {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            padding: 12px 18px;
            color: white;
            width: 280px;
        }

        .search-box::placeholder {
            color: #94a3b8;
        }

        .card-modern {
            background: rgba(238, 227, 227, 0.06);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        }

        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            width: 160px;
            height: 160px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .stats-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 18px;
        }

         .stats-title {
            overflow: hidden;
        }

        .table-modern thead {
            background: #111827;
            color: white;
        }

        .table-modern td,
        .table-modern th {
            vertical-align: middle;
            padding: 16px;
        }

        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 16px;
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: #111827;
            box-shadow: none;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand">
        <i class="bi bi-shop"></i> AdminStore
    </div>

    <a href="{{ route('products.index') }}" class="nav-link active">
        <i class="bi bi-box-seam me-2"></i> Produk
    </a>

    <a href="#" class="nav-link">
        <i class="bi bi-bar-chart-line me-2"></i> Statistik
    </a>

    <a href="#" class="nav-link">
        <i class="bi bi-person-circle me-2"></i> Admin
    </a>
</div>

<div class="main-content">

    <div class="topbar">
        <div>
            <h4 class="mb-0 fw-bold">Dashboard Penjualan</h4>
            <small class="text-muted">Kelola produk dan penjualan dengan mudah</small>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-dark btn-modern">
                <i class="bi bi-plus-circle"></i> Produk Baru
            </button>
        </div>
    </div>

    @yield('content')
</div>

</body>
</html>