<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin Tamu')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-color: var(--secondary-color);
            color: var(--text-color);
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
            background-color: var(--primary-color);
            color: #fff;
        }

        .navbar-item i {
            margin-right: 0.5rem;
        }

        #main {
            margin-top: 80px;
            padding: 2rem;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
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

        .search-bar, .filter-button {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 5px;
        }

        .filter-button {
            background-color: var(--primary-color);
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover {
            background-color: var(--hover-color);
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">Dashboard Admin Tamu</div>
        <div class="navbar-menu">
            <a href="{{ route('dashboard') }}" class="navbar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Beranda
            </a>
            <a href="#" class="navbar-item">
                <i class="fas fa-users"></i>
                Pengunjung
            </a>
            <a href="{{ route('report') }}" class="navbar-item {{ Request::is('dashboard/report') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Laporan
            </a>
        </div>
    </nav>

    <div id="main">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
