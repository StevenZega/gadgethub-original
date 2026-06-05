<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GadgetHub - Toko Gadget Terlengkap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<body class="bg-[#0f172a] text-white font-sans selection:bg-blue-600 selection:text-white">

    <nav class="bg-[#0f172a]/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('storage/logo/logo.png') }}" 
                            alt="GadgetHub Logo" 
                            class="h-10 w-auto object-contain transition duration-300 group-hover:scale-110">
                    </a>
                </div>

                <form method="GET" action="{{ route('user.dashboard') }}" class="flex items-center gap-2">
                    <input type="hidden" name="category" id="hidden-category" value="{{ request('category') }}">
                    <input type="hidden" name="sort" id="hidden-sort" value="{{ request('sort') }}">

                    <div class="relative flex items-center">
                        <iconify-icon 
                            icon="material-symbols-light:search-rounded" 
                            class="absolute left-3.5 text-slate-400 text-2xl pointer-events-none">
                        </iconify-icon>

                        <input
                            type="text"
                            id="search-input"
                            name="search"
                            placeholder="Cari produk..."
                            value="{{ request('search') }}"
                            class="bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 h-[38px] text-white w-56 focus:outline-none focus:border-blue-500 transition-all text-sm placeholder:text-slate-500">
                            
                        <div id="search-results"
                            class="hidden absolute top-full left-0 mt-2 w-full bg-[#1e293b] border border-white/10 rounded-xl overflow-hidden shadow-xl z-50">
                        </div>
                    </div>

                    <div class="relative id-custom-dropdown">
                        <button type="button"
                            class="bg-white/5 border border-white/10 rounded-xl px-4 h-[38px] text-slate-300 text-sm focus:outline-none focus:border-blue-500 cursor-pointer transition-all flex items-center gap-2 select-none min-w-[160px] justify-between">
                            <span>
                                @if(request('category') == 'Handphone') 📱 Handphone 
                                @elseif(request('category') == 'Laptop') 💻 Laptop 
                                @else Semua Kategori @endif
                            </span>
                            <i class="bi bi-chevron-down text-xs transition-transform duration-300 arrow-icon"></i>
                        </button>
                        
                        <div class="absolute top-[115%] left-0 w-full min-w-[170px] bg-[#1e293b]/95 backdrop-blur-xl border border-white/10 rounded-xl overflow-hidden shadow-2xl z-50 transition-all duration-300 origin-top opacity-0 scale-y-0 pointer-events-none transform">
                            <div class="p-1 flex flex-col gap-0.5">
                                <div data-value="" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Semua Kategori</div>
                                <div data-value="Handphone" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Handphone</div>
                                <div data-value="Laptop" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Laptop</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative id-custom-dropdown">
                        <button type="button"
                            class="bg-white/5 border border-white/10 rounded-xl px-4 h-[38px] text-slate-300 text-sm focus:outline-none focus:border-blue-500 cursor-pointer transition-all flex items-center gap-2 select-none min-w-[160px] justify-between">
                            <span>
                                @if(request('sort') == 'price_asc') Harga Terendah
                                @elseif(request('sort') == 'price_desc') Harga Tertinggi
                                @elseif(request('sort') == 'name_asc') Nama A-Z
                                @elseif(request('sort') == 'name_desc') Nama Z-A
                                @else Urutkan Default @endif
                            </span>
                            <i class="bi bi-chevron-down text-xs transition-transform duration-300 arrow-icon"></i>
                        </button>
                        
                        <div class="absolute top-[115%] left-0 w-full min-w-[170px] bg-[#1e293b]/95 backdrop-blur-xl border border-white/10 rounded-xl overflow-hidden shadow-2xl z-50 transition-all duration-300 origin-top opacity-0 scale-y-0 pointer-events-none transform">
                            <div class="p-1 flex flex-col gap-0.5">
                                <div data-value="" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Urutkan Default</div>
                                <div data-value="price_asc" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Harga Terendah</div>
                                <div data-value="price_desc" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Harga Tertinggi</div>
                                <div data-value="name_asc" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Nama A-Z</div>
                                <div data-value="name_desc" class="dropdown-item px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-blue-600 rounded-lg cursor-pointer transition">Nama Z-A</div>
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="flex items-center justify-center bg-blue-500/10 hover:bg-blue-600 border border-blue-500/30 hover:border-blue-500 text-blue-400 hover:text-white h-[38px] w-[38px] rounded-xl transition-all duration-300 dynamic-glow-blue shadow-lg shadow-blue-500/5 group"
                        title="Terapkan Filter">
                        <i class="bi bi-funnel-fill text-sm group-hover:scale-110 transition duration-300"></i>
                    </button>

                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center justify-center bg-white/5 hover:bg-red-500/20 border border-white/10 hover:border-red-500/40 text-slate-400 hover:text-red-400 h-[38px] w-[38px] rounded-xl transition-all duration-300 shadow-lg group"
                        title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise text-sm group-hover:rotate-[-180deg] transition duration-500"></i>
                    </a>
                </form>

                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-slate-400 hover:text-blue-400 text-xl p-1.5 transition flex items-center relative group" title="Buka Keranjang">
                        <i class="bi bi-cart-fill"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span>
                    </a>

                    <span class="text-sm text-slate-400">
                        <i class="bi bi-person-circle text-blue-400 mr-1.5"></i> Halo, <strong class="text-white">{{ auth()->user()->name }}</strong>
                    </span>
                    <form action="{{ url('/logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-300 transition flex items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden bg-[#0f172a] border-b border-white/5 py-24 px-4">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.12),transparent_45%)]"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span> Generasi Baru Belanja Gadget
            </span>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-6 bg-gradient-to-b from-white to-slate-300 bg-clip-text text-transparent">
                Temukan Gadget Masa Depanmu
            </h1>
            <p class="text-base md:text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Produk 100% original, bergaransi resmi, dan gratis ongkir ke seluruh Indonesia. Upgrade produktivitas dan gayamu sekarang!
            </p>
            <a id="btn-jelajahi" href="#katalog" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/20 hover:opacity-90 transition transform hover:-translate-y-0.5">
                Jelajahi Produk <i class="bi bi-arrow-down-short fs-5"></i>
            </a>
        </div>
    </header>

    @if(!$products->isEmpty())
    <section class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pt-16">
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-900/20 to-cyan-900/10 border border-white/10 rounded-3xl h-[340px] md:h-[400px] group/slider">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div id="slider-container" class="flex h-full w-full transition-transform duration-700 ease-out">
                @foreach($products->take(5) as $sliderProduct)
                    <div class="w-full h-full flex-shrink-0 flex flex-col md:flex-row items-center justify-between p-8 md:p-14 gap-8">
                        
                        <div class="w-full md:w-1/2 flex flex-col justify-center text-center md:text-left order-2 md:order-1">
                            <span class="text-xs uppercase font-bold tracking-widest text-cyan-400 mb-2 block">
                                🔥 Penawaran Teratas
                            </span>
                            <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight line-clamp-2 mb-3">
                                {{ $sliderProduct->name }}
                            </h2>
                            <p class="text-xl font-black text-blue-400 mb-6">
                                Rp {{ number_format($sliderProduct->price, 0, ',', '.') }}
                            </p>
                            <div>
                                <a href="{{ route('user.products.show', $sliderProduct->id) }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-blue-600 border border-white/10 hover:border-blue-500 text-white font-bold py-3 px-6 rounded-xl text-sm transition-all shadow-lg group">
                                    Lihat Detail Produk
                                    <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 h-44 md:h-full flex items-center justify-center order-1 md:order-2 relative">
                            <div class="absolute inset-0 bg-[radial-gradient(circle,rgba(255,255,255,0.04),transparent_60%)] pointer-events-none"></div>
                            @if($sliderProduct->image)
                                <img src="{{ asset('storage/' . $sliderProduct->image) }}" alt="{{ $sliderProduct->name }}" class="h-full w-auto max-w-[80%] object-contain drop-shadow-[0_20px_35px_rgba(37,99,235,0.25)] transform hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="text-slate-600 flex flex-col items-center gap-2">
                                    <i class="bi bi-image text-5xl"></i>
                                    <span class="text-xs font-bold uppercase tracking-widest">No Preview</span>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-xl bg-slate-900/60 backdrop-blur-md border border-white/10 text-white flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition-all hover:bg-blue-600 hover:border-blue-500 z-20 shadow-xl">
                <i class="bi bi-chevron-left text-lg"></i>
            </button>
            <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-xl bg-slate-900/60 backdrop-blur-md border border-white/10 text-white flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition-all hover:bg-blue-600 hover:border-blue-500 z-20 shadow-xl">
                <i class="bi bi-chevron-right text-lg"></i>
            </button>

            <div id="slider-dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                </div>
        </div>
    </section>
    @endif

    <main id="katalog" class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-3 mb-10 border-b border-white/10 pb-5">
            <div class="p-2 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400">
                <i class="bi bi-cpu-fill text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-white m-0">Katalog Gadget Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Menampilkan deretan device spesifikasi terbaik</p>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-sm">
                <i class="bi bi-patch-exclamation text-slate-500 text-5xl block mb-4"></i>
                <p class="text-slate-300 text-xl font-medium">Belum ada gadget yang tersedia saat ini.</p>
                <p class="text-slate-500 text-sm mt-2">Silakan tambahkan produk baru melalui dashboard manajemen admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($products as $product)
                    <div class="bg-white/4 rounded-2xl overflow-hidden border border-white/10 backdrop-blur-md hover:border-blue-500/40 hover:shadow-2xl hover:shadow-blue-500/5 transition duration-300 flex flex-col justify-between group relative">
                        
                        <a href="{{ route('user.products.show', $product->id) }}" class="block flex-1">
                            <div class="w-full h-44 bg-white/5 flex items-center justify-center overflow-hidden border-b border-white/5 relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="text-slate-500 flex flex-col items-center gap-2">
                                        <i class="bi bi-image text-2xl"></i>
                                        <span class="text-[10px] tracking-wider uppercase">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 pb-0">
                                <h3 class="font-bold text-sm text-slate-200 line-clamp-2 mb-2 group-hover:text-blue-400 transition" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                <div class="text-base font-black text-cyan-400">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </a>

                        <div class="p-4 pt-4 mt-3">
                            <div class="grid grid-cols-1 gap-2">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 border border-white/10 text-slate-300 font-semibold py-2 px-3 rounded-xl text-xs hover:bg-white/10 hover:text-white transition">
                                        <i class="bi bi-cart-plus"></i> + Keranjang
                                    </button>
                                </form>
                                <button type="button" class="w-full bg-blue-600 text-white font-bold py-2 px-3 rounded-xl text-xs hover:bg-blue-700 transition shadow-md shadow-blue-600/10">
                                    Checkout
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-[#0b111e] text-slate-500 py-10 border-t border-white/5 mt-32">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs tracking-wider">
            &copy; {{ date('Y') }} GADGETHUB INDONESIA. All rights reserved.
        </div>
    </nav>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnJelajahi = document.getElementById('btn-jelajahi');
        if (btnJelajahi) {
            btnJelajahi.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah hentakan instan bawaan browser
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Ambil posisi target dikurangi tinggi navbar (16px * 4 = 64px) agar tidak tertutup navbar sticky
                    const navbarOffset = 70; 
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - navbarOffset;

                    // Menggunakan window.scrollTo dengan behavior smooth
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        }

        const searchInput = document.getElementById('search-input');
        const resultsBox = document.getElementById('search-results');

        searchInput.addEventListener('keyup', async function() {
            let keyword = this.value;
            if(keyword.length < 1){
                resultsBox.classList.add('hidden');
                return;
            }
            let response = await fetch(`/search-products?search=${keyword}`);
            let products = await response.json();
            let html = '';
            products.forEach(product => {
                html += `
                    <a href="/user/products/${product.id}" class="block px-4 py-3 hover:bg-white/5 border-b border-white/5">
                        <div class="font-semibold text-white">${product.name}</div>
                        <div class="text-xs text-slate-400">${product.brand ?? ''}</div>
                    </a>
                `;
            });
            if(products.length === 0){
                html = `<div class="px-4 py-3 text-slate-400">Produk tidak ditemukan</div>`;
            }
            resultsBox.innerHTML = html;
            resultsBox.classList.remove('hidden');
        });

        // --- 2. CUSTOM DROPDOWNS SYSTEM ---
        const dropdowns = document.querySelectorAll('.id-custom-dropdown');
        dropdowns.forEach(dropdown => {
            const btn = dropdown.querySelector('button');
            const menu = dropdown.querySelector('.absolute');
            const arrow = dropdown.querySelector('.arrow-icon');
            const label = dropdown.querySelector('span');

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.id-custom-dropdown .absolute').forEach(otherMenu => {
                    if (otherMenu !== menu) {
                        otherMenu.classList.add('opacity-0', 'scale-y-0', 'pointer-events-none');
                        otherMenu.parentElement.querySelector('.arrow-icon').classList.remove('rotate-180');
                    }
                });
                menu.classList.toggle('opacity-0');
                menu.classList.toggle('scale-y-0');
                menu.classList.toggle('pointer-events-none');
                arrow.classList.toggle('rotate-180');
            });

            const items = menu.querySelectorAll('.dropdown-item');
            items.forEach(item => {
                item.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.innerHTML;

                    if(item.innerHTML.includes('Kategori')) {
                        document.getElementById('hidden-category').value = value;
                    } else if(item.innerHTML.includes('Default') || item.innerHTML.includes('Harga') || item.innerHTML.includes('Nama')) {
                        document.getElementById('hidden-sort').value = value;
                    } else {
                        const firstHidden = document.getElementById('hidden-category');
                        const secondHidden = document.getElementById('hidden-sort');
                        if(this.closest('.id-custom-dropdown').querySelector('button').innerHTML.includes('Kategori') || this.innerHTML.includes('📱') || this.innerHTML.includes('💻')) {
                            firstHidden.value = value;
                        } else {
                            secondHidden.value = value;
                        }
                    }
                    label.innerHTML = text;
                    menu.classList.add('opacity-0', 'scale-y-0', 'pointer-events-none');
                    arrow.classList.remove('rotate-180');
                });
            });
        });

        document.addEventListener('click', function() {
            document.querySelectorAll('.id-custom-dropdown .absolute').forEach(menu => {
                menu.classList.add('opacity-0', 'scale-y-0', 'pointer-events-none');
            });
            document.querySelectorAll('.arrow-icon').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
        });

        // --- 3. PREMIUM SLIDER SYSTEM ENGINE ---
        const sliderContainer = document.getElementById('slider-container');
        if (sliderContainer) {
            const slides = sliderContainer.children;
            const totalSlides = slides.length;
            const prevBtn = document.getElementById('prev-slide');
            const nextBtn = document.getElementById('next-slide');
            const dotsContainer = document.getElementById('slider-dots');
            let currentIdx = 0;
            let slideInterval;

            // Generate Indicators Dots
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.className = `w-2.5 h-2.5 rounded-full transition-all duration-300 ${i === 0 ? 'bg-blue-500 w-6' : 'bg-white/30'}`;
                dot.addEventListener('click', () => {
                    goToSlide(i);
                    resetAutoplay();
                });
                dotsContainer.appendChild(dot);
            }

            const dots = dotsContainer.children;

            function updateSliderVisuals() {
                sliderContainer.style.transform = `translateX(-${currentIdx * 100}%)`;
                Array.from(dots).forEach((dot, i) => {
                    if (i === currentIdx) {
                        dot.classList.add('bg-blue-500', 'w-6');
                        dot.classList.remove('bg-white/30');
                    } else {
                        dot.classList.remove('bg-blue-500', 'w-6');
                        dot.classList.add('bg-white/30');
                    }
                });
            }

            function goToSlide(idx) {
                currentIdx = idx;
                if (currentIdx >= totalSlides) currentIdx = 0;
                if (currentIdx < 0) currentIdx = totalSlides - 1;
                updateSliderVisuals();
            }

            function startAutoplay() {
                slideInterval = setInterval(() => {
                    goToSlide(currentIdx + 1);
                }, 5000);
            }

            function resetAutoplay() {
                clearInterval(slideInterval);
                startAutoplay();
            }

            prevBtn.addEventListener('click', () => {
                goToSlide(currentIdx - 1);
                resetAutoplay();
            });

            nextBtn.addEventListener('click', () => {
                goToSlide(currentIdx + 1);
                resetAutoplay();
            });

            startAutoplay();
        }
    });
    </script>
</body>
</html>