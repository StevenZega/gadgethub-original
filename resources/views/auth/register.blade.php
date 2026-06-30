<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | GadgetHub</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #0f172a;
        }

        .glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-5xl grid md:grid-cols-2 rounded-3xl overflow-hidden shadow-2xl">

        <div class="hidden md:flex flex-col justify-center bg-gradient-to-br from-blue-600 to-cyan-400 p-12 text-white">
            <h1 class="text-5xl font-bold leading-tight">
                GadgetHub
            </h1>

            <p class="mt-6 text-lg text-blue-100">
                Belanja gadget modern dengan pengalaman e-commerce yang cepat, simpel, dan elegan.
            </p>

            <div class="mt-10 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                    <p>Smartphone & Accessories</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                    <p>Gaming Gear Premium</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                    <p>Fast Delivery & Secure Payment</p>
                </div>
            </div>
        </div>

        <div class="glass p-10 md:p-14 text-white">

            <div class="mb-10">
                <h2 class="text-4xl font-bold">
                    Create Account
                </h2>

                <p class="text-slate-400 mt-2">
                    Join GadgetHub and start shopping today.
                </p>
            </div>

            <form method="POST" action="/register" class="space-y-6">
                @csrf

                <div>
                    <label class="block mb-2 text-sm text-slate-300">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your name"
                        class="w-full px-5 py-4 rounded-2xl bg-slate-900 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                    >
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-300">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        class="w-full px-5 py-4 rounded-2xl bg-slate-900 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                    >
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-300">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Create password"
                        class="w-full px-5 py-4 rounded-2xl bg-slate-900 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400"
                    >
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm text-slate-300">
                        Role
                    </label>
                    
                    <input type="hidden" name="role" id="selected-role" value="">

                    <button 
                        type="button"
                        id="dropdown-btn"
                        class="w-full px-5 py-4 rounded-2xl bg-slate-900 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 text-left flex justify-between items-center transition duration-300"
                    >
                        <span id="dropdown-label" class="text-slate-400">Select Role</span>
                        <i id="dropdown-arrow" class="bi bi-chevron-down text-slate-400 transition-transform duration-300"></i>
                    </button>

                    <div 
                        id="dropdown-menu"
                        class="absolute z-50 w-full mt-2 bg-slate-900/90 border border-slate-700 rounded-2xl shadow-xl overflow-hidden backdrop-blur-lg max-h-0 opacity-0 pointer-events-none transition-all duration-300 ease-out"
                    >
                        <div 
                            data-value="customer" 
                            class="dropdown-item px-5 py-3.5 hover:bg-cyan-500 hover:text-slate-900 cursor-pointer flex items-center gap-3 transition duration-200"
                        >
                            <i class="bi bi-person-fill text-lg"></i> Customer
                        </div>
                        <div 
                            data-value="admin" 
                            class="dropdown-item px-5 py-3.5 hover:bg-cyan-500 hover:text-slate-900 cursor-pointer flex items-center gap-3 transition duration-200"
                        >
                            <i class="bi bi-shield-lock-fill text-lg"></i> Admin
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-4 rounded-2xl bg-cyan-400 hover:bg-cyan-300 text-slate-900 font-bold transition duration-300"
                >
                    Register
                </button>
            </form>

            <p class="mt-8 text-center text-slate-400">
                Already have an account?
                <a href="/login" class="text-cyan-400 hover:underline">
                    Login
                </a>
            </p>

        </div>
    </div>

    <script>
        const dropdownBtn = document.getElementById('dropdown-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const dropdownLabel = document.getElementById('dropdown-label');
        const selectedRoleInput = document.getElementById('selected-role');
        const dropdownItems = document.querySelectorAll('.dropdown-item');

        dropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = dropdownMenu.classList.contains('opacity-100');
            if (isOpen) closeDropdown(); else openDropdown();
        });

        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                const text = this.textContent.trim();

                selectedRoleInput.value = value;
                dropdownLabel.textContent = text;
                dropdownLabel.classList.remove('text-slate-400');
                dropdownLabel.classList.add('text-white', 'font-medium');

                closeDropdown();
            });
        });

        document.addEventListener('click', () => closeDropdown());

        function openDropdown() {
            dropdownMenu.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
            dropdownMenu.classList.add('max-h-40', 'opacity-100');
            dropdownArrow.classList.add('rotate-180', 'text-cyan-400');
            dropdownBtn.classList.add('ring-2', 'ring-cyan-400');
        }

        function closeDropdown() {
            dropdownMenu.classList.remove('max-h-40', 'opacity-100');
            dropdownMenu.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
            dropdownArrow.classList.remove('rotate-180', 'text-cyan-400');
            dropdownBtn.classList.remove('ring-2', 'ring-cyan-400');
        }
    </script>

</body>
</html>