<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Tamu</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
        }

        .header {
            background-color: #00bcd4;
            color: white;
            padding: 15px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-icon {
            font-size: 30px;
            cursor: pointer;
        }

        .container {
            padding: 20px;
        }

        .card {
            display: inline-block;
            width: 23%;
            padding: 20px;
            margin: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card-total {
            background-color: #00bcd4;
            color: white;
        }

        .card-today {
            background-color: #f44336;
            color: white;
        }

        .clock, .calendar {
            font-size: 3em;
            margin: 100px 0;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #00bcd4;
            color: white;
            cursor: pointer;
            user-select: none;
        }

        th:hover {
            background-color: #008ba3;
        }

        th::after {
            content: '\00a0\25B2\25BC';
            font-size: 0.8em;
            opacity: 0.5;
        }

        /* Side Navbar Styles */
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1001;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            margin-top: 60px; /* To account for fixed header */
            padding: 16px;
            transition: margin-left 0.5s;
        }

        .content-overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }

        /* Filter Button and Pop-up Styles */
        .filter-button {
            background-color: #00bcd4;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
        }

        .filter-button img {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        .filter-button:hover {
            background-color: #008ba3;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Filter Button and Pop-up Styles */
        .filter-popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1002;
        }

        .filter-popup h2 {
            margin-top: 0;
        }

        .filter-popup input, .filter-popup button {
            margin: 10px 0;
            padding: 5px;
            width: 100%;
        }

        .filter-popup button {
            background-color: #00bcd4;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .filter-popup button:hover {
            background-color: #008ba3;
        }

        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Search Bar and Filter Button Styles */
        .search-filter-container {
            display: flex;
            align-items: center;
        }

        .search-bar {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="menu-icon" onclick="openNav()">&#9776;</span>
        <h1>Dashboard Admin Tamu</h1>
        <div></div> <!-- Empty div for flex spacing -->
    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Dashboard</a>
        <a href="#">Pengunjung</a>
        <a href="#">Laporan</a>
        <a href="#">Pengaturan</a>
    </div>

    <div id="main">
        <div class="container">
            <!-- Visitor Table Section -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Daftar Pengunjung</h2>
                    <div class="search-filter-container">
                        <input type="text" id="searchBar" class="search-bar" placeholder="Cari pengunjung..." onkeyup="searchTable()">
                        <button class="filter-button" onclick="openFilterPopup()">
                            <img src="{{ asset('icons/filter-icon.svg') }}" alt="Filter">
                            Filter
                        </button>
                    </div>
                </div>
                <table id="visitorTable">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">No</th>
                            <th onclick="sortTable(1)">Nama</th>
                            <th onclick="sortTable(2)">Nomor HP</th>
                            <th onclick="sortTable(3)">Email</th>
                            <th onclick="sortTable(4)">Instansi</th>
                            <th onclick="sortTable(5)">Tujuan</th>
                            <th onclick="sortTable(6)">Keterangan</th>
                        </tr>
                    
                    </thead>
                    <tbody id="visitorTableBody">
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>1234567890</td>
                            <td>johndoe@example.com</td>
                            <td>XYZ Corp</td>
                            <td>Meeting</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Alohn Doe</td>
                            <td>5534567890</td>
                            <td>lohndoe@example.com</td>
                            <td>ABC Corp</td>
                            <td>Ngyseeing</td>
                            <td>None</td>
                        </tr>
                        <!-- Tambahkan data pengunjung lainnya -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Script untuk jam, kalender, dan filter -->
        <script>
            function applyFilter() {
                const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
                const instansiFilter = document.getElementById('instansiFilter').value.toLowerCase();
                const dateFilter = document.getElementById('dateFilter').value;

                const rows = document.getElementById('visitorTableBody').getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const name = rows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
                    const instansi = rows[i].getElementsByTagName('td')[4].innerText.toLowerCase();
                    const date = rows[i].getElementsByTagName('td')[7].innerText; // Assuming you add a date column

                    const nameMatch = name.includes(nameFilter);
                    const instansiMatch = instansi.includes(instansiFilter);
                    const dateMatch = dateFilter === '' || date === dateFilter;

                    if (nameMatch && instansiMatch && dateMatch) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }

                closeFilterPopup();
            }

            function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("visitorTable");
                switching = true;
                dir = "asc";
                
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    
                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        
                        if (dir == "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else {
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
            }

            @if(session('success'))
                <div>
                    {{session('success')}}
                </div>
            @endif

            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
                document.getElementById("overlay").style.display = "block";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("overlay").style.display = "none";
            }

            function openFilterPopup() {
                document.getElementById("filterPopup").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            }

            function closeFilterPopup() {
                document.getElementById("filterPopup").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            }

            function searchTable() {
                const searchInput = document.getElementById('searchBar').value.toLowerCase();
                const rows = document.getElementById('visitorTableBody').getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const rowData = rows[i].textContent.toLowerCase();
                    if (rowData.includes(searchInput)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        </script>
    </div>

    <div id="filterPopup" class="filter-popup">
        <span class="close-popup" onclick="closeFilterPopup()">&times;</span>
        <h2>Filter Pengunjung</h2>
        <form id="filterForm">
            <input type="text" id="nameFilter" placeholder="Nama">
            <input type="text" id="instansiFilter" placeholder="Instansi">
            <input type="date" id="dateFilter">
            <button type="button" onclick="applyFilter()">Terapkan Filter</button>
        </form>
    </div>

    <div id="overlay" class="content-overlay" onclick="closeNav()"></div>
</body>
</html>
