@extends('layouts.app')

@section('title', 'Laporan')

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

    /* CSS khusus untuk halaman report */
    .chart-report-container {
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .monthly-visitors-chart h3 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    #visitorChart {
        width: 100% !important;
        height: 300px !important;
    }

    .table-and-calendar-container {
        display: flex;
        justify-content: space-between;
    }

    .monthly-visitors-chart {
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .monthly-visitors-chart h3, .table-header-report h3{
        color: var(--primary-color);
    }

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
        width: 100%; /* Adjust to fit next to the calendar */
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table-header-report h3 {
        color: var(--primary-color);
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 300px; /* You can adjust this height based on your design */
        margin-top: 20px;
    }

    canvas {
        width: 100% !important;
        height: auto !important;
    }

    .sidebar {
        position: fixed;
        top: 0;
        right: -300px; /* Mulai dari luar layar */
        width: 300px;
        height: 100%;
        background-color: #fff;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        transition: right 0.3s ease-in-out;
        z-index: 1000;
        overflow-y: auto; /* Untuk konten yang mungkin lebih panjang */
    }

    .sidebar.open {
        right: 0; /* Geser ke dalam layar saat terbuka */
    }

    .sidebar-toggle {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%) rotate(-90deg);
        transform-origin: right center;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
        z-index: 1001;
        transition: right 0.3s ease-in-out;
    }

    .sidebar-toggle.open {
        right: 300px; /* Geser tombol saat sidebar terbuka */
    }

    .calendar-popup {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .calendar-popup-content {
        background-color: #ffffff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 15px;
        width: 300px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .calendar {
        font-family: Arial, sans-serif;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .calendar-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        z-index: 1;
    }

    .calendar-header button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }

    .calendar .weeks {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .calendar .days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .calendar .days li {
        list-style: none;
        text-align: center;
        padding: 5px;
        background-color: #f0f0f0;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .calendar .days li:hover {
        background-color: #e0e0e0;
    }

    .calendar-popup.show {
        display: flex;
        opacity: 1;
    }

    .close-popup {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-popup:hover {
        color: #000;
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <div class="clock-container">
        <div class="clock-col">
            <p class="clock-day clock-timer">
            </p>
            <p class="clock-label">
            Hari
            </p>
        </div>
        <div class="clock-col">
            <p class="clock-hours clock-timer">
            </p>
            <p class="clock-label">
            Jam
            </p>
        </div>
        <div class="clock-col">
            <p class="clock-minutes clock-timer">
            </p>
            <p class="clock-label">
            Menit
            </p>
        </div>
        <div class="clock-col">
            <p class="clock-seconds clock-timer">
            </p>
            <p class="clock-label">
            Detik
            </p>
        </div>
    </div>
    <div id="sidebarToggle" class="sidebar-toggle">KALENDER</div>
    <div class="chart-report-container">
        <div class="monthly-visitors-chart">
            <h3>Pengunjung Perbulan</h3>
            <!-- Tombol Kalender di pojok kanan atas -->
            <div class="stats-row">
                <div class="stat-box total-visitors">
                    <i class="fas fa-walking"></i>
                    <div class="stat-content">
                        <h4>Total Pengunjung: {{ array_sum($totalVisitorsPerMonth) }}</h4>
                    </div>
                </div>
                <div class="stat-box today-visitors">
                    <i class="fas fa-user-tie"></i>
                    <div class="stat-content">
                        <h4>Pengunjung Hari Ini: {{ $todayVisitors }}</h4>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
        <!-- Sidebar untuk kalender -->
        <div id="sidebar" class="sidebar">
            <div class="sidebar-content">
                <h3>Kalender</h3>
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prevMonth">&lt;</button>
                        <h2 id="currentMonth">Bulan Tahun</h2>
                        <button id="nextMonth">&gt;</button>
                    </div>
                    <ul class="weeks">
                        <li>Min</li>
                        <li>Sen</li>
                        <li>Sel</li>
                        <li>Rab</li>
                        <li>Kam</li>
                        <li>Jum</li>
                        <li>Sab</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Table (Left) -->
    <div class="visitor-table">
        <div class="table-header-report">
            <h3>Pengunjung Hari Ini</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Masuk pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitorTableData as $index => $visitor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $visitor->name }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>{{ $visitor->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    var visitorChart; // Deklarasi global agar bisa diakses di berbagai fungsi

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                console.log('Sidebar toggled'); // Untuk debugging
            });
        } else {
            console.error('Sidebar atau toggle button tidak ditemukan');
        }

        function initializeCalendar() {
            // ... (kode kalender tetap sama)
        }

        initializeCalendar();
    });

    // Fungsi untuk update chart pengunjung
    function updateVisitorChart(data) {
        var ctx = document.getElementById('visitorChart').getContext('2d');

        // Hancurkan chart sebelumnya jika ada
        if (visitorChart) {
            visitorChart.destroy();
        }

        // Inisialisasi chart baru
        visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Warna titik
                    tension: 0.4  // Garis halus
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: 'rgba(200, 200, 200, 0.5)' } }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: { color: '#333', font: { size: 14 } }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#000',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 5,
                        caretPadding: 10
                    }
                },
                elements: {
                    point: { radius: 5, hoverRadius: 7 }
                }
            }
        });
    }

    // Panggil fungsi updateVisitorChart dengan data pengunjung
    updateVisitorChart({{ json_encode(array_values($totalVisitorsPerMonth)) }});

    // Inisialisasi kalender
    function initializeCalendar() {
        const daysTag = document.querySelector(".days"),
        currentDate = document.querySelector(".current-date"),
        prevNextIcon = document.querySelectorAll(".icons-report span");

        if (!daysTag || !currentDate || prevNextIcon.length === 0) {
            console.log("Elemen kalender belum dimuat, menunggu...");
            setTimeout(initializeCalendar, 100); // Coba lagi setelah 100ms
            return;
        }

        let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth();

        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                        "Agustus", "September", "Oktober", "November", "Desember"];

        const renderCalendar = () => {
            let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
            lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(),
            lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
            lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
            let liTag = "";

            for (let i = firstDayofMonth; i > 0; i--) {
                liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
            }

            for (let i = 1; i <= lastDateofMonth; i++) {
                let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                            && currYear === new Date().getFullYear() ? "active" : "";
                liTag += `<li class="${isToday}">${i}</li>`;
            }

            for (let i = lastDayofMonth; i < 6; i++) {
                liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
            }
            currentDate.innerText = `${months[currMonth]} ${currYear}`;
            daysTag.innerHTML = liTag;
        }
        renderCalendar();

        prevNextIcon.forEach(icon => {
            icon.addEventListener("click", () => {
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if(currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth, new Date().getDate());
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date();
                }
                renderCalendar();
            });
        });
    }
</script>
@endsection