@extends('layouts.app')

@section('title', 'Laporan')

@section('styles')
<style>
    /* CSS khusus untuk halaman report */
    .chart-report-container {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .monthly-visitors-chart h3 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    #visitorChart {
        width: 100% !important;
        height: 300px !important;
    }
</style>
<canvas id="visitorChart" width="400" height="200"></canvas>
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
    <div class="chart-stats-row">
        <div class="chart-report-container">
            <div class="monthly-visitors-chart">
                <h3>Pengunjung Perbulan</h3>
                <div class="stats-row">
                    <div class="stat-box total-visitors">
                        <i class="fas fa-walking"></i>
                        <div class="stat-content">
                            <h4>Total Pengunjung: 66</h4>
                        </div>
                    </div>
                    <div class="stat-box today-visitors">
                        <i class="fas fa-user-tie"></i>
                        <div class="stat-content">
                            <h4>Pengunjung Hari Ini: 66</h4>
                        </div>
                    </div>
                </div>
                <canvas id="visitorChart" width="400" height="200"></canvas>
                <div class="chart-labels">
                    <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MEI</span><span>JUN</span>
                    <span>JUL</span><span>AGS</span><span>SEP</span><span>OKT</span><span>NOV</span><span>DES</span>
                </div>
            </div>
        </div>
        <div class="calendar-box">
            <!-- Tambahkan komponen kalender di sini -->
            <p class="current-date"></p>
            <div class="icons-report">
                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                <span id="next" class="material-symbols-rounded">chevron_right</span>
            </div>
            <div class="calendar">
                <ul class="weeks">
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
                <ul class="days"></ul>
            </div>
        </div>
    </div>
    <div class="visitor-table">
        <div class="table-header-report">
            <h3>Pengunjung Hari Ini</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor HP</th>
                    <th>Email</th>
                    <th>Instansi</th>
                    <th>Tujuan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>qwertyuiop asdfghjkl</td>
                    <td>1234567890</td>
                    <td>zxcvbnm@asd.com</td>
                    <td>QWERTY</td>
                    <td>qAWSERTY</td>
                    <td>asdasdasdasd...</td>
                </tr>
                <!-- Tambahkan baris lain sesuai kebutuhan -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/calendar.js') }}"></script>
<script>
    function initializeReportPage() {
        let filterPopupOverlay = document.getElementById("filterPopupOverlay");
        if (filterPopupOverlay && !filterPopupOverlay.hasAttribute('data-event-attached')) {
            filterPopupOverlay.addEventListener("click", function(event) {
                if (event.target === this) {
                    closeFilterPopup();
                }
            });
            filterPopupOverlay.setAttribute('data-event-attached', 'true');
        }

        if (typeof closeFilterPopup === 'undefined') {
            window.closeFilterPopup = function() {
                let filterPopupOverlay = document.getElementById("filterPopupOverlay");
                if (filterPopupOverlay) {
                    filterPopupOverlay.style.display = "none";
                }
            }
        }

        var ctx = document.getElementById('visitorChart').getContext('2d');
        var visitorChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: [12, 19, 3, 5, 2, 3, 10, 15, 8, 12, 5, 7],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Panggil fungsi ini jika halaman dimuat langsung (bukan melalui AJAX)
    if (typeof window.reportPageInitialized === 'undefined') {
        initializeReportPage();
        window.reportPageInitialized = true;
    }
</script>
@endsection