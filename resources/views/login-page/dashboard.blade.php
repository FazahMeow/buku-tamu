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

    .time-range-selector {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        background-color: white;
        font-size: 14px;
        color: var(--text-color);
        cursor: pointer;
        transition: all 0.3s ease;
        outline: none;
        width: 150px;
    }

    .time-range-selector:hover {
        border-color: var(--primary-color);
    }

    .time-range-selector:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
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

    .chart-placeholder {
        height: 200px;
        background-color: #f0f0f0;
        margin-bottom: 10px;
    }
    .chart-container {
        position: relative;
        width: 100%;
        height: auto;
        margin-top: 20px;
    }

    canvas {
        width: 100% !important;
        height: auto !important;
    }

    .visitor-table {
        width: 100%; /* Adjust to fit next to the calendar */
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .text-center {
        text-align: center;
    }

    .table-header-report h3 {
        color: var(--primary-color);
    }

    .sidebar {
        position: fixed;
        top: 50%;
        right: -500px;
        width: 500px;
        height: 500px;
        background-color: #333;
        color: #fff;
        padding: 20px;
        transition: right 0.5s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        transform: translateY(-50%);
        z-index: 1000;
    }

    .sidebar-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 20px;
    }

    .sidebar-handle {
        position: absolute;
        top: 50%;
        left: -30px;
        height: 500px;
        width: 30px;
        background-color: #333;
        color: #fff;
        padding: 10px;
        transition: right 0.5s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        transform: translateY(-50%);
        border-radius: 10px 0 0 10px;
        cursor: pointer;
        z-index: 1001;
    }

    .sidebar-handle span {
        font-size: 16px;
        white-space: nowrap;
        transform: rotate(-90deg);
        letter-spacing: 5px;
    }

    .sidebar.show {
        right: 0;
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
    <!-- Jam -->
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
    <!-- Chart -->
    <div class="chart-report-container">
        <div class="monthly-visitors-chart">
            <div class="btn-time-range">
                <select id="timeRangeSelector" class="time-range-selector">
                    <option value="monthly" selected>Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            
            <div class="chart-container">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Visitor Table -->
    <div class="visitor-table">
        <div class="table-header-report">
            <h3>Pengunjung Bulan Ini</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitorTableData as $index => $visitor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $visitor->nama }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td>
                        @if($visitor->dibuat_pada instanceof \Carbon\Carbon)
                            {{ $visitor->dibuat_pada->format('d F Y') }}
                        @else
                            {{ $visitor->dibuat_pada }}
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pengunjung bulan ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Sidebar untuk kalender -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-handle">
            <span>KALENDER</span>
        </div>
    </div>
    <div class="calendar">
        <div class="calendar-header">
            <button id="prevMonth">&lt;</button>
            <span id="currentMonth"></span>
            <button id="nextMonth">&gt;</button>
        </div>
        <div class="calendar-body">
            <div class="weeks">
                <span>Min</span>
                <span>Sen</span>
                <span>Sel</span>
                <span>Rab</span>
                <span>Kam</span>
                <span>Jum</span>
                <span>Sab</span>
            </div>
            <div class="days"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    let visitorChart = null;

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const timeRangeButtons = document.querySelectorAll('timeRangeSelector');

        // Initialize chart with monthly data
        updateChart('monthly');

        // Event listener untuk selector
        timeRangeSelector.addEventListener('change', function() {
            const selectedRange = this.value;
            updateChart(selectedRange);
        });

        

        // Initialize calendar
        initializeCalendar();
    });

    // Initialize sidebar
    const sidebar = document.getElementById('sidebar');
    const sidebarHandle = document.querySelector('.sidebar-handle');

    sidebarHandle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });

    function updateChart(timeRange) {
        fetch(`/dashboard?time_range=${timeRange}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const chartData = prepareChartData(data, timeRange);
            if (visitorChart instanceof Chart) {
                visitorChart.destroy();
            }
            visitorChart = createChart(chartData, timeRange);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function prepareChartData(data, timeRange) {
        if (!data || typeof data !== 'object') {
            console.error('Invalid data received:', data);
            return { labels: [], values: [] };
        }

        const labels = Object.keys(data);
        const values = Object.values(data);

        switch(timeRange) {
            case 'monthly':
                return {
                    labels: labels.map(month => {
                        const [year, monthNum] = month.split('-');
                        const date = new Date(year, parseInt(monthNum) - 1);
                        return date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                    }),
                    values: values
                };
            case 'yearly':
                return {
                    labels: labels.map(year => `Tahun ${year}`),
                    values: values
                };
            default:
                return { labels, values };
        }
    }

    function createChart(data, timeRange) {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        if (!data || !data.labels || !data.values) {
            console.error('Invalid chart data:', data);
            return null;
        }

        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: data.values,
                    backgroundColor: 'rgb(0, 255, 156)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) { 
                                return Math.floor(value); 
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: `Pengunjung ${
                            timeRange === 'monthly' ? 'Bulanan' : 
                            'Tahunan'
                        }`,
                        padding: {
                            bottom: 20
                        },
                        font: {
                            size: 24,
                            family: 'Poppins',
                        },
                    }
                }
            }
        });
    }


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