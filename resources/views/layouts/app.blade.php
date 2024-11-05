<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Tamu')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo_bpsdm.png') }}" alt="Logo">
    </div>

    <div id="mySidenav" class="sidenav">
        <!-- Beranda -->
        <a href="{{ route('dashboard') }}" class="navbar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home-alt"></i> Beranda
        </a>
        
        <!-- Pengunjung -->
        <a href="{{ route('pengunjung') }}" class="navbar-item {{ Request::routeIs('pengunjung') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengunjung
        </a>
        <a href="#" class="navbar-item">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
        <a href="#" class="navbar-item navbar-item-keluar" role="button" tabindex="0">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
        <!-- Modal Logout -->
        <div id="logoutModal" class="modal" role="dialog" aria-modal="true">
            <div class="modal-content">
                <h2>Konfirmasi Logout</h2>
                <p>Apakah Anda yakin ingin keluar?</p>
                <div class="modal-buttons">
                    <button type="button" id="confirmLogout" class="btn-confirm">Ya</button>
                    <button type="button" id="cancelLogout" class="btn-cancel">Tidak</button>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;" autocomplete="off">
            @csrf
        </form>
    </div>

    <div id="main">
        <div id="page-loader" class="page-loader">
            <div class="loader"></div>
        </div>
        <div id="main-container">
            <div id="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let isLoggingOut = false;
            const navLinks = document.querySelectorAll('.navbar-item[data-target]');
            const pageContent = document.getElementById('page-content');
            const pageLoader = document.getElementById('page-loader');
            const mainContainer = document.getElementById('main-container');
            // Logout
            const logoutLink = document.querySelector('.navbar-item-keluar');
            const logoutModal = document.getElementById('logoutModal');
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');
            const logoutForm = document.getElementById('logout-form');

            if (logoutLink && logoutModal && confirmLogout && cancelLogout && logoutForm) {
                // Tampilkan modal saat link logout diklik
                logoutLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    logoutModal.style.display = 'block';
                });

                // Konfirmasi logout
                confirmLogout.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!isLoggingOut) {
                        isLoggingOut = true;
                        logoutForm.submit();
                    }
                });

                // Batalkan logout
                cancelLogout.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    logoutModal.style.display = 'none';
                    isLoggingOut = false;
                });

                // Tutup modal jika mengklik di luar modal
                window.addEventListener('click', function(e) {
                    if (e.target === logoutModal) {
                        logoutModal.style.display = 'none';
                        isLoggingOut = false;
                    }
                });

                // Tambahkan event listener untuk tombol ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && logoutModal.style.display === 'block') {
                        logoutModal.style.display = 'none';
                        isLoggingOut = false;
                    }
                });
            }

            // Prevent form submission on enter key
            document.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && logoutModal.style.display === 'block') {
                    e.preventDefault();
                    return false;
                }
            });

            // Disable autocomplete for the entire modal
            logoutModal.setAttribute('autocomplete', 'off');
        

            function showLoader() {
                pageLoader.classList.add('show');
                mainContainer.classList.add('hidden');
            }

            function hideLoader() {
                pageLoader.classList.remove('show');
                mainContainer.classList.remove('hidden');
            }

            function loadContent(url) {
                showLoader();
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('#page-content').innerHTML;
                        const newStyles = doc.querySelector('style');
                        const newScripts = doc.querySelectorAll('script');

                        setTimeout(() => {
                            pageContent.innerHTML = newContent;
                            
                            // Tambahkan style baru
                            if (newStyles) {
                                document.head.appendChild(newStyles);
                            }
                            
                            // Jalankan script baru
                            newScripts.forEach(script => {
                                const newScript = document.createElement('script');
                                newScript.textContent = script.textContent;
                                document.body.appendChild(newScript);
                            });

                            hideLoader();
                            updateActiveNavItem(url);
                            
                            // Inisialisasi kalender jika ada
                            if (typeof initializeCalendar === 'function') {
                                initializeCalendar();
                            }
                            
                            // Inisialisasi fungsi-fungsi dashboard jika ada
                            if (url.includes('dashboard')) {
                                if (typeof applyFilter === 'function') {
                                    applyFilter();
                                }
                                if (typeof sortTable === 'function') {
                                    sortTable(0);
                                }
                                if (typeof searchTable === 'function') {
                                    searchTable();
                                }
                                if (typeof applyTableAnimation === 'function') {
                                    applyTableAnimation();
                                }
                            }
                            
                            // Inisialisasi fungsi report page jika ada
                            if (url.includes('report')) {
                                if (typeof initializeReportPage === 'function' && !window.reportPageInitialized) {
                                    initializeReportPage();
                                    window.reportPageInitialized = true;
                                }
                            }
                        }, 500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        hideLoader();
                    });
            }

            function updateActiveNavItem(path) {
                navLinks.forEach(link => {
                    const linkPath = '/' + link.getAttribute('data-target');
                    if (linkPath === path) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!this.classList.contains('active')) {
                        const target = this.getAttribute('data-target');
                        const url = `/${target}`;
                        loadContent(url);
                        history.pushState(null, '', url);
                    }
                });
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                loadContent(window.location.pathname);
            });

            // Load initial content if not on the dashboard
            if (window.location.pathname !== '/dashboard') {
                loadContent(window.location.pathname);
            }

            // Clock functionality
            function updateClock() {
                const now = new Date();
                
                document.documentElement.style.setProperty('--timer-day', "'" + now.toLocaleString('id-ID', { weekday: 'long' }) + "'");
                document.documentElement.style.setProperty('--timer-hours', "'" + now.getHours().toString().padStart(2, '0') + "'");
                document.documentElement.style.setProperty('--timer-minutes', "'" + now.getMinutes().toString().padStart(2, '0') + "'");
                document.documentElement.style.setProperty('--timer-seconds', "'" + now.getSeconds().toString().padStart(2, '0') + "'");
            }

            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);
        });

        function ensureHeaderSolid() {
            const header = document.querySelector('.header');
            if (header) {
                header.style.setProperty('--background-header', "url('{{ asset('images/background_header.png') }}')");
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
            }
        }

        // Panggil fungsi ini setelah konten dimuat
        ensureHeaderSolid();

        // Tambahkan ke dalam fungsi loadContent
        function loadContent(url) {
            showLoader();
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('#page-content').innerHTML;
                    const newStyles = doc.querySelector('style');
                    const newScripts = doc.querySelectorAll('script');

                    setTimeout(() => {
                        pageContent.innerHTML = newContent;
                        
                        // Tambahkan style baru
                        if (newStyles) {
                            document.head.appendChild(newStyles);
                        }
                        
                        // Jalankan script baru
                        newScripts.forEach(script => {
                            const newScript = document.createElement('script');
                            newScript.textContent = script.textContent;
                            document.body.appendChild(newScript);
                        });

                        hideLoader();
                        updateActiveNavItem(url);
                        
                        // Inisialisasi kalender jika ada
                        if (typeof initializeCalendar === 'function') {
                            initializeCalendar();
                        }
                        
                        // Inisialisasi fungsi-fungsi dashboard jika ada
                        if (url.includes('dashboard')) {
                            if (typeof applyFilter === 'function') {
                                applyFilter();
                            }
                            if (typeof sortTable === 'function') {
                                sortTable(0);
                            }
                            if (typeof searchTable === 'function') {
                                searchTable();
                            }
                            if (typeof applyTableAnimation === 'function') {
                                applyTableAnimation();
                            }
                        }
                        
                        // Inisialisasi fungsi report page jika ada
                        if (url.includes('report')) {
                            if (typeof initializeReportPage === 'function' && !window.reportPageInitialized) {
                                initializeReportPage();
                                window.reportPageInitialized = true;
                            }
                        }
                    }, 500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoader();
                });
        }

        // Panggil juga saat halaman di-refresh
        window.addEventListener('load', ensureHeaderSolid);

        window.addEventListener('load', function() {
            const header = document.querySelector('.header');
            console.log('Header height on load:', header.offsetHeight);
        });

        window.addEventListener('beforeunload', function() {
            const header = document.querySelector('.header');
            console.log('Header height before unload:', header.offsetHeight);
        });

        window.addEventListener('load', function() {
            const header = document.querySelector('.header');
            console.log('Header height:', header.offsetHeight);
            console.log('Header background-image:', getComputedStyle(header).backgroundImage);
        });
    </script>
    <!-- Tambahkan ini sebelum tag </body> -->
    <!-- <script src="{{ asset('js/calendar.js') }}"></script> -->
    @yield('scripts')
</body>
</html>