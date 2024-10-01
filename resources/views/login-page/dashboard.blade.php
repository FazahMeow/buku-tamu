@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #f5f7fa;
        --text-color: #333;
        --light-text: #777;
        --border-color: #e0e0e0;
        --hover-color: #3a7bd5;
        --background-image: url('{{ asset('images/background_list.png') }}');
        
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    /* CSS khusus untuk halaman dashboard */
    .table-container {
        margin-top: 20px;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    /* ... tambahkan style lainnya ... */
</style>
@endsection

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
                    @if(isset($visitors) && $visitors->count() > 0)
                        @foreach($visitors as $index => $visitor)
                        <tr class="table-row" style="animation-delay: {{ $index * 0.05 }}s;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $visitor->name }}</td>
                            <td>{{ $visitor->phone }}</td>
                            <td>{{ $visitor->email }}</td>
                            <td>{{ $visitor->company }}</td>
                            <td>{{ $visitor->purpose }}</td>
                            <td>{{ $visitor->remarks }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="table-row">
                            <td colspan="7">Tidak ada data pengunjung.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div id="noResultsMessage" style="display: none; text-align: center; margin-top: 20px;">
                Mohon maaf, keyword yang Anda cari tidak ditemukan.
            </div>
        </div>
    </div>

    <div id="filterPopupOverlay" class="filter-popup-overlay">
        <div id="filterPopup" class="filter-popup">
            <span class="close-popup" onclick="closeFilterPopup()">&times;</span>
            <h2>Filter Pengunjung</h2>
            <form id="filterForm">
                <input type="text" id="nameFilter" placeholder="Nama">
                <input type="text" id="instansiFilter" placeholder="Instansi">
                <input type="text" id="purposeFilter" placeholder="Tujuan">
                <button type="button" onclick="applyFilter()">Terapkan</button>
            </form>
        </div>
    </div>

    <div id="overlay" class="content-overlay" onclick="closeNav()"></div>
</div>
    @endsection

@section('scripts')
<script>
    function applyFilter() {
        const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        const instansiFilter = document.getElementById('instansiFilter').value.toLowerCase();
        const purposeFilter = document.getElementById('purposeFilter').value.toLowerCase();

        const rows = document.getElementById('visitorTableBody').getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const name = rows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
            const instansi = rows[i].getElementsByTagName('td')[4].innerText.toLowerCase();
            const purpose = rows[i].getElementsByTagName('td')[5].innerText.toLowerCase();

            const nameMatch = name.includes(nameFilter);
            const instansiMatch = instansi.includes(instansiFilter);
            const purposeMatch = purpose.includes(purposeFilter);

            if (nameMatch && instansiMatch && purposeMatch) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }

        closeFilterPopup();
    }

    function openFilterPopup() {
        document.getElementById("filterPopupOverlay").style.display = "flex";
    }

    function closeFilterPopup() {
        document.getElementById("filterPopupOverlay").style.display = "none";
    }

    // Tambahkan event listener untuk menutup pop-up ketika mengklik di luar area pop-up
    document.getElementById("filterPopupOverlay").addEventListener("click", function(event) {
        if (event.target === this) {
            closeFilterPopup();
        }
    });

    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("visitorTable");
        switching = true;
        // Atur arah pengurutan menjadi ascending
        dir = "asc";
        
        while (switching) {
            switching = false;
            rows = table.rows;
            
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                
                // Periksa apakah dua baris harus ditukar berdasarkan arah, asc atau desc
                if (dir == "asc") {
                    if (compareValues(x.innerHTML, y.innerHTML) > 0) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (compareValues(x.innerHTML, y.innerHTML) < 0) {
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
                // Jika tidak ada pertukaran dan arah adalah "asc",
                // atur arah menjadi "desc" dan jalankan loop while lagi
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
        
        // Perbarui tampilan ikon sorting
        updateSortIcon(n, dir);
    }

    function compareValues(a, b) {
        // Hapus karakter non-numeric jika ada
        a = a.replace(/[^\d.-]/g, '');
        b = b.replace(/[^\d.-]/g, '');
        
        // Periksa apakah nilai adalah angka
        if (!isNaN(a) && !isNaN(b)) {
            return Number(a) - Number(b);
        }
        
        // Jika bukan angka, bandingkan sebagai string
        a = a.toLowerCase();
        b = b.toLowerCase();
        return a.localeCompare(b);
    }

    function updateSortIcon(column, direction) {
        // Hapus semua ikon sorting
        var headers = document.querySelectorAll('#visitorTable th');
        headers.forEach(function(header) {
            header.classList.remove('asc', 'desc');
        });
        
        // Tambahkan ikon yang sesuai ke kolom yang diurutkan
        var sortedHeader = document.querySelector('#visitorTable th:nth-child(' + (column + 1) + ')');
        sortedHeader.classList.add(direction);
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
        document.getElementById("filterPopupOverlay").style.display = "flex";
    }

    function closeFilterPopup() {
        document.getElementById("filterPopupOverlay").style.display = "none";
    }

    function searchTable() {
        const searchBar = document.getElementById('searchBar');
        if (!searchBar) return; // Keluar dari fungsi jika elemen tidak ditemukan

        const searchInput = searchBar.value.toLowerCase();
        const rows = document.getElementById('visitorTableBody').getElementsByTagName('tr');
        const noResultsMessage = document.getElementById('noResultsMessage');
        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const rowData = rows[i].textContent.toLowerCase();
            if (rowData.includes(searchInput)) {
                rows[i].style.display = '';
                found = true;
            } else {
                rows[i].style.display = 'none';
            }
        }

        if (noResultsMessage) {
            noResultsMessage.style.display = found ? 'none' : 'block';
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

    // Tambahkan event listener untuk menutup pop-up ketika mengklik di luar area pop-up
    document.getElementById("filterPopupOverlay").addEventListener("click", function(event) {
        if (event.target === this) {
            closeFilterPopup();
        }
    });

    function applyTableAnimation() {
        const tableContainer = document.querySelector('.table-container');
        if (tableContainer) {
            tableContainer.style.animationDelay = '0.1s';
        }
    }

    // Panggil fungsi ini setelah konten dimuat
    document.addEventListener('DOMContentLoaded', applyTableAnimation);

    // Tambahkan event listener untuk searchBar
    document.addEventListener('DOMContentLoaded', function() {
        const searchBar = document.getElementById('searchBar');
        if (searchBar) {
            searchBar.addEventListener('keyup', searchTable);
        }
    });
</script>
@endsection
