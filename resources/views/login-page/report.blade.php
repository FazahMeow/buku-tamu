@extends('layouts.app')

@section('title', 'Laporan')

@section('styles')
<style>
    /* CSS khusus untuk halaman report */
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
                <div class="chart-placeholder"></div>
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
@endsection