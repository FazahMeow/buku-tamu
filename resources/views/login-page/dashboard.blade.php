@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div id="page-content">
    <div class="container">
        <!-- Visitor Table Section -->
        <div class="table-container">
            <div class="table-header">
                <h2>Daftar Pengunjung</h2>
                <div class="search-filter-container">
                    <div class="search-wrapper">
                        <input type="text" id="searchBar" class="search-bar" placeholder="Cari pengunjung..." onkeyup="searchTable()">
                    </div>
                    <button class="filter-button" onclick="openFilterPopup()" title="Filter">
                        <i class="fas fa-filter"></i>
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
                    <tr>
                        <td>3</td>
                        <td>Bindol nidd</td>
                        <td>55344434890</td>
                        <td>mikolk@example.com</td>
                        <td>Falling</td>
                        <td>B-React</td>
                        <td>None</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Mulyono</td>
                        <td>54443267890</td>
                        <td>fufufafa@example.com</td>
                        <td>Konoha Government</td>
                        <td>Hahahihi</td>
                        <td>None</td>
                    </tr>
                    <!-- Tambahkan data pengunjung lainnya -->
                </tbody>
            </table>
        </div>
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
</div>
@endsection

@section('scripts')
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

    // Script untuk efek hover yang memengaruhi halaman utama
    document.querySelectorAll('.navbar-menu a').forEach(link => {
        link.addEventListener('mouseenter', () => {
            document.getElementById('main').style.backgroundColor = '#e0f7fa';
        });
        link.addEventListener('mouseleave', () => {
            document.getElementById('main').style.backgroundColor = '#f5f5f5';
        });
    });
</script>
@endsection
