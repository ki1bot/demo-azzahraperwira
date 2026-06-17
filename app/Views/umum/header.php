<div class="bg-az-green text-white text-sm py-2 px-4 hidden md:block">
    <div class="container mx-auto flex justify-between">
        <span>
            <a href="https://wa.me/6285215585570" target="_blank" class="wa-link">
                <i class="fab fa-whatsapp wa-icon"></i>
                <span>0852-1558-5570</span>
            </a>
            |
            <a href="https://wa.me/6287881701715" target="_blank" class="wa-link">
                <i class="fab fa-whatsapp wa-icon"></i>
                <span>0878-8170-1715</span>
            </a>
        </span>

        <span>Selamat Datang di Website Resmi Yayasan Az-Zahra Perwira</span>
    </div>
</div>

<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-black text-az-green italic">AZ-ZAHRA PERWIRA</h1>

        <button id="menu-btn" class="md:hidden text-az-green focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <div id="mobile-menu" class="hidden md:flex md:items-center md:space-x-6 font-semibold absolute md:static top-16 left-0 w-full bg-white md:w-auto p-4 md:p-0 shadow-md md:shadow-none flex-col md:flex-row space-y-2 md:space-y-0">
            <a href="<?= base_url('index.php/home/beranda') ?>" class="block px-4 py-3 rounded-lg hover:bg-emerald-50 hover:text-az-green transition-all md:p-0 md:hover:bg-transparent">
                Home
            </a>

            <a href="<?= base_url('index.php/home/profile') ?>" class="block px-4 py-3 rounded-lg hover:bg-emerald-50 hover:text-az-green transition-all md:p-0 md:hover:bg-transparent">
                Profile
            </a>

            <a href="<?= base_url('index.php/home/tenagaPengajar') ?>" class="block px-4 py-3 rounded-lg hover:bg-emerald-50 hover:text-az-green transition-all md:p-0 md:hover:bg-transparent">
                Tenaga Pengajar
            </a>

            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex justify-between w-full items-center px-4 py-3 rounded-lg hover:bg-emerald-50 hover:text-az-green transition-all md:p-0 md:hover:bg-transparent">
                    Unit Layanan ▾
                </button>

                <div x-show="open" x-transition class="md:absolute md:bg-white md:shadow-xl md:py-2 md:mt-2 md:w-48 md:rounded-lg md:border-t-4 md:border-az-green z-50 w-full bg-gray-50 mt-1 rounded-lg">
                    <a href="<?= base_url('index.php/home/unitKBTK') ?>" class="block px-4 py-3 hover:bg-emerald-100 md:py-2">
                        KB-TK
                    </a>

                    <a href="<?= base_url('index.php/home/unitTPQ') ?>" class="block px-4 py-3 hover:bg-emerald-100 md:py-2">
                        TPQ dan RTQ
                    </a>

                    <a href="<?= base_url('index.php/home/unitDC') ?>" class="block px-4 py-3 hover:bg-emerald-100 md:py-2">
                        Daycare
                    </a>

                    <a href="<?= base_url('index.php/home/unitLansia') ?>" class="block px-4 py-3 hover:bg-emerald-100 md:py-2">
                        Pondok Lansia
                    </a>
                </div>
            </div>

            <a href="<?= base_url('index.php/home/informasi') ?>" class="block px-4 py-3 rounded-lg hover:bg-emerald-50 hover:text-az-green transition-all md:p-0 md:hover:bg-transparent">
                Informasi
            </a>

            <a href="<?= base_url('admin/login/index.php') ?>" class="inline-flex items-center justify-center w-full md:w-auto h-10 px-5 rounded-xl bg-az-green text-white text-sm font-bold hover:bg-emerald-700 hover:shadow-md transition-all duration-300 md:ml-1">
                Login
            </a>
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
