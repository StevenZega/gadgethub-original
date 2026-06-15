<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GadgetHub - Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0f172a] text-white font-sans selection:bg-blue-600 selection:text-white">

    <nav class="bg-[#0f172a]/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 text-slate-400 hover:text-blue-400 transition text-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Toko
                </a>
                <span class="text-xs font-bold tracking-widest text-slate-500 uppercase">Profil Akun</span>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center gap-3 text-sm animate-fade-in">
                <i class="bi bi-check-circle-fill text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white/5 border border-white/10 rounded-3xl p-8 md:p-12 backdrop-blur-md relative overflow-hidden shadow-2xl shadow-blue-500/5">
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-b border-white/10 pb-8 mb-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-24 h-24 rounded-full border border-white/10 overflow-hidden bg-slate-800 flex items-center justify-center shadow-lg">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto {{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-person-fill text-slate-500 text-5xl"></i>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-black tracking-tight mb-1">{{ $user->name }}</h1>
                        <p class="inline-flex items-center gap-1.5 py-0.5 px-2.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span> Member GadgetHub VIP
                        </p>
                    </div>
                </div>
                
                <button type="button" onclick="openModal()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-blue-600/20 transition transform active:scale-95">
                    <i class="bi bi-pencil-square"></i> Edit Profil Saya
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white/4 p-5 border border-white/5 rounded-2xl">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Nama Lengkap</span>
                    <span class="text-base font-semibold text-slate-200">{{ $user->name }}</span>
                </div>

                <div class="bg-white/4 p-5 border border-white/5 rounded-2xl">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Alamat Email</span>
                    <span class="text-base font-semibold text-cyan-400 font-mono">{{ $user->email }}</span>
                </div>

                <div class="bg-white/4 p-5 border border-white/5 rounded-2xl">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Nomor Telepon / WA</span>
                    <span class="text-base font-semibold text-slate-200">{{ $user->phone ?? '-' }}</span>
                </div>

                <div class="bg-white/4 p-5 border border-white/5 rounded-2xl">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Bergabung Sejak</span>
                    <span class="text-base font-medium text-slate-300">
                        {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}
                    </span>
                </div>

                <div class="bg-white/4 p-5 border border-white/5 rounded-2xl md:col-span-2">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Alamat Pengiriman Paket (Default)</span>
                        <span class="text-[9px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-md font-bold uppercase">Aktif</span>
                    </div>
                    <p class="text-sm font-medium text-slate-300 leading-relaxed">
                        {{ $user->address ?? 'Belum mengatur alamat default. Silakan edit profil untuk menambahkan alamat utama Anda.' }}
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/5 flex items-center gap-3 text-xs text-slate-500">
                <i class="bi bi-shield-lock-fill text-blue-500/70 text-lg"></i>
                <span>Seluruh data informasi kredensial akun Anda dilindungi dengan enkripsi end-to-end framework Laravel.</span>
            </div>
        </div>
    </main>

    <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden animate-fade-in">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal()"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-[#1e293b] border border-white/10 rounded-3xl max-w-xl w-full p-6 md:p-8 shadow-2xl overflow-hidden transform transition-all">
                
                <div class="flex justify-between items-center pb-4 mb-6 border-b border-white/10">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="bi bi-person-gear text-blue-400"></i> Perbarui Data Profil
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-white transition">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Foto Profil Baru</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer bg-white/5 border border-white/10 p-2 rounded-xl focus:outline-none">
                        <span class="text-[10px] text-slate-500 mt-1 block">*Format: JPG, JPEG, PNG (Maks 2MB)</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-white/5 border border-white/10 focus:border-blue-500 focus:outline-none rounded-xl px-4 py-2.5 text-sm text-slate-200 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-white/5 border border-white/10 focus:border-blue-500 focus:outline-none rounded-xl px-4 py-2.5 text-sm text-slate-200 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789" class="w-full bg-white/5 border border-white/10 focus:border-blue-500 focus:outline-none rounded-xl px-4 py-2.5 text-sm text-slate-200 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Alamat Lengkap Pengiriman Default</label>
                        <textarea name="address" rows="3" placeholder="Tuliskan alamat lengkap pengiriman paket beserta kode pos..." class="w-full bg-white/5 border border-white/10 focus:border-blue-500 focus:outline-none rounded-xl px-4 py-2.5 text-sm text-slate-200 transition leading-relaxed">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5 mt-6">
                        <button type="button" onclick="closeModal()" class="bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 px-5 py-2.5 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl text-xs font-semibold shadow-lg shadow-blue-600/20 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
        }

        function closeModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
        }
    </script>
</body>
</html>