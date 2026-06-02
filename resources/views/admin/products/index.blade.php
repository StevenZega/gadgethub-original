<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - GadgetHub</title>
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
        .card-modern { background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(16px); border-radius: 28px; padding: 28px; box-shadow: 0 15px 40px rgba(0,0,0,0.25); }
        .btn-modern { background: linear-gradient(135deg, #2563eb, #06b6d4); border: none; color: white; padding: 12px 24px; border-radius: 16px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-modern:hover { opacity: 0.9; transform: scale(1.02); color: white; }
        .table-hover tbody tr:hover { background-color: rgba(255, 255, 255, 0.03) !important; transition: 0.2s; }
    </style>
</head>
<body>

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-white">Inventory Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">+ Tambah Produk</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('products.show', $product->id) }}'">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="" style="width: 45px; height: 45px; object-fit: cover;" 
                                 class="rounded shadow-sm me-3">
                            <div>
                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        {{-- Logika Stok yang Diperbaiki --}}
                        @if($product->stock <= 0)
                            <span class="badge bg-danger px-3">Habis</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark px-3">Hampir Habis: {{ $product->stock }}</span>
                        @else
                            <span class="badge bg-success px-3">Tersedia</span>
                        @endif
                    </td>
                    <td class="text-center" onclick="event.stopPropagation();">
                        <div class="btn-group">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                            
                            {{-- Form Delete dengan ID unik untuk SweetAlert --}}
                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $product->id }})">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h4 class="m-0 fw-bold">Inventory Produk</h4>
                <small class="text-muted">Kelola produk dan stok toko di sini</small>
            </div>
            <div>
                <span class="badge bg-secondary px-3 py-2 rounded-pill">Status: Admin Aktif</span>
            </div>
        </div>

        <div class="card-modern">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <a href="{{ route('products.create') }}" class="btn-modern">
                    <i class="bi bi-plus-lg"></i> Tambah Produk
                </a>
            </div>

            <div class="table-responsive rounded-4 border border-secondary border-opacity-25 overflow-hidden">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase tracking-wider small">
                        <tr>
                            <th class="ps-4 py-3 text-dark fw-bold">Produk</th>
                            <th class="py-3 text-dark fw-bold">Harga</th>
                            <th class="py-3 text-dark fw-bold">Stok</th>
                            <th class="text-center py-3 text-dark fw-bold" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr style="cursor: pointer;" onclick="window.location='{{ route('products.show', $product->id) }}'">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width: 45px; height: 45px; object-fit: cover;" class="rounded border border-secondary border-opacity-50 me-3">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="bi bi-image text-muted m-auto"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-white">{{ $product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-semibold text-info">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3">
                                @if($product->stock <= 0)
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 px-3 py-2 rounded-pill">Habis</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-3 py-2 rounded-pill text-dark">Hampir Habis: {{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-3 py-2 rounded-pill">Tersedia</span>
                                @endif
                            </td>
                            <td class="text-center py-3" onclick="event.stopPropagation();">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning rounded px-2.5">Edit</a>
                                    
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded px-2.5" onclick="confirmDelete({{ $product->id }})">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Produk?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#1e293b',
                customClass: {
                    popup: 'rounded-4 border border-secondary shadow-lg',
                    title: 'fw-bold text-white',
                    htmlContainer: 'text-muted'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#1e293b',
                customClass: {
                    popup: 'rounded-4 border border-secondary shadow-lg',
                    title: 'fw-bold text-white',
                    htmlContainer: 'text-muted'
                }
            });
        @endif
    </script>
</body>
</html>