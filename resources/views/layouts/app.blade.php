<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Tamu')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f5f7fa;
            --text-color: #333;
            --light-text: #777;
            --border-color: #e0e0e0;
            --hover-color: #3a7bd5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('{{ asset('images/background_list.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .navbar-menu {
            display: flex;
            gap: 1rem;
        }

        .navbar-item {
            text-decoration: none;
            color: var(--light-text);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navbar-item:hover, .navbar-item.active {
            font-weight: bold;
        }

        .navbar-item i {
            margin-right: 0.5rem;
        }

        #main {
            position: relative;
            margin-top: 100px;
            margin-left: 250px;
            margin-right: auto;
            max-width: 1200px;
            border-radius: 10px;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            font-family: 'Roboto', sans-serif;
        }

        h1, h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .table-container {
            overflow-x: auto;
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--secondary-color);
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .search-filter-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .search-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .search-bar {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23aaa" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
            background-repeat: no-repeat;
            background-position: 0.75rem center;
            background-size: 1rem;
        }

        .search-bar::placeholder {
            font-style: italic;
            color: #aaa;
        }

        .filter-button {
            background-color: #fff;
            color: var(--primary-color);
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .filter-button i {
            font-size: 1.2rem;
        }

        .filter-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1001;
        }

        .close-popup {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .content-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        #page-content {
            opacity: 1;
            transition: opacity 0.3s ease;
            position: relative;
        }

        #page-content.fade-out {
            opacity: 0;
        }

        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .page-loader.show {
            opacity: 1;
            visibility: visible;
        }

        .loader {
            width: 28px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #E3AAD6;
            transform-origin: top;
            display: grid;
            animation: l3-0 1s infinite linear;
        }
        .loader::before,
        .loader::after {
        content: "";
        grid-area: 1/1;
        background:#F4DD51;
        border-radius: 50%;
        transform-origin: top;
        animation: inherit;
        animation-name: l3-1;
        }
        .loader::after {
        background: #F10C49;
        --s:180deg;
        }

        @keyframes l3-0 {
            0%,20% {transform: rotate(0)}
            100%   {transform: rotate(360deg)}
        }
        @keyframes l3-1 {
            50% {transform: rotate(var(--s,90deg))}
            100% {transform: rotate(0)}
        }

        #main-container {
            transition: opacity 0.3s ease;
            opacity: 1;
        }

        #main-container.hidden {
            opacity: 0;
        }

        /* Halaman Report */
        .report-container {
            padding: 20px;
        }
        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .stat-box {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            width: 48%;
        }

        .calendar-box {
            background-color: #fff;
            width: 30%;
        }
        .stat-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 48%;
            display: flex;
            align-items: center;
        }
        .total-visitors {
            background-color: #00ffff;
        }
        .today-visitors {
            background-color: #ff0000;
            color: #fff;
        }
        .stat-box i {
            font-size: 1.2rem;
            margin-right: 10px;
        }
        .stat-content h3 {
            margin: 0;
            font-size: 12px;
        }
        .stat-content h4 {
            margin: 0;
            font-size: 0.9rem;
        }
        .stat-content p {
            margin: 0;
            font-size: 12px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin: 5px 0 0;
        }

        .clock {
            &-day {
                &:before {
                    content: var(--timer-day);
                }
            }
            &-hours {
                &:before {
                    content: var(--timer-hours);
                }
            }
            &-minutes {
                &:before {
                content: var(--timer-minutes);
                }
            }
            &-seconds {
                &:before {
                content: var(--timer-seconds);
                }
            }
        }

        .clock {
            &-container {
                margin-top: 30px;
                margin-bottom: 30px;
                background-color: #080808;
                border-radius: 5px;
                padding: 60px 20px;
                box-shadow: 1px 1px 5px rgba(255,255,255,.15), 0 15px 90px 30px rgba(0,0,0,.25);
                display: flex;
            }
            &-col {
                text-align: center;
                margin-right: 40px;
                margin-left: 40px;
                min-width: 90px;
                position: relative;
                &:not(:last-child):before,
                &:not(:last-child):after{
                content: "";
                background-color: rgba(255,255,255,.3);
                height: 5px;
                width: 5px;
                border-radius: 50%;
                display: block;
                position: absolute;
                right: -42px;
                }
                &:not(:last-child):before {
                top: 35%;
                }
                &:not(:last-child):after {
                top: 50%;
                }
            }
            &-timer {
                &:before {
                color: #fff;
                font-size: 4.2rem;
                text-transform: uppercase;
                }
            }
            &-label {
                color: rgba(255,255,255,.35);
                text-transform: uppercase;
                font-size: .7rem;
                margin-top: 10px;
            }
        }

        .clock-day:before {
            content: var(--timer-day);
        }
        .clock-hours:before {
            content: var(--timer-hours);
        }
        .clock-minutes:before {
            content: var(--timer-minutes);
        }
        .clock-seconds:before {
            content: var(--timer-seconds);
        }

        @media (max-width: 825px) {
            .clock-container {
            flex-direction: column;
                padding-top: 40px;
                padding-bottom: 40px;
            }
            .clock-col {
                & + & {
                margin-top: 20px;
                }
                &:before,
                &:after {
                display: none!important;
                }
            }
        }

        #current-time {
            font-size: 2.5rem;
            margin: 10px 0 0;
        }
        .chart-stats-row {
         display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .chart-calendar-container {
            width: 65%;
        }
        .monthly-visitors-chart, .calendar-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }   
        .monthly-visitors-chart h3, .table-header-report h3{
            color: var(--primary-color);
        }
        /* .monthly-visitors-chart {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 65%;
        } */
        .chart-placeholder {
            height: 200px;
            background-color: #f0f0f0;
            margin-bottom: 10px;
        }
        .chart-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }
        .chart-labels span {
            font-size: 0.8rem;
            color: #666;
        }
        .visitor-table {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Gaya untuk header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 10px 40px;
            z-index: 1;
        }

        .header img {
            height: 50px;
            margin-right: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        /* Gaya untuk side navbar */
        .sidenav {
            height: calc(100% - 60px);
            width: 190px;
            position: fixed;
            z-index: 2;
            top: 100px;
            left: 0;
            overflow-x: hidden;
            transition: 0.5s;
            font-family: 'Roboto', sans-serif;
        }

        .sidenav a {
            padding: 15px 8px 15px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #181C14; /* Mengubah warna teks menjadi lebih terang */
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            background-color: rgb(233, 239, 236);
        }

        .sidenav a.active {
            font-weight: bold; /* Membuat item aktif menjadi bold */
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo_bpsdm.png') }}" alt="Logo">
    </div>

    <div id="mySidenav" class="sidenav">
        <a href="{{ route('dashboard') }}" class="navbar-item {{ Request::is('dashboard') ? 'active' : '' }}" data-target="dashboard">
            <i class="fas fa-home-alt"></i> Beranda
        </a>
        <a href="#" class="navbar-item">
            <i class="fas fa-users"></i> Pengunjung
        </a>
        <a href="{{ route('report') }}" class="navbar-item {{ Request::is('dashboard/report') ? 'active' : '' }}" data-target="report">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
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
            const navLinks = document.querySelectorAll('.navbar-item[data-target]');
            const pageContent = document.getElementById('page-content');
            const pageLoader = document.getElementById('page-loader');
            const mainContainer = document.getElementById('main-container');

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

                        setTimeout(() => {
                            pageContent.innerHTML = newContent;
                            hideLoader();
                            updateActiveNavItem(url);
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
                
                document.documentElement.style.setProperty('--timer-day', "'" + now.toLocaleString('id-ID', { weekday: 'short' }) + "'");
                document.documentElement.style.setProperty('--timer-hours', "'" + now.getHours().toString().padStart(2, '0') + "'");
                document.documentElement.style.setProperty('--timer-minutes', "'" + now.getMinutes().toString().padStart(2, '0') + "'");
                document.documentElement.style.setProperty('--timer-seconds', "'" + now.getSeconds().toString().padStart(2, '0') + "'");
            }

            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
</body>
</html>