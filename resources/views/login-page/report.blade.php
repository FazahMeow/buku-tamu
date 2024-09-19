@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="dashboard-container">
    <div class="stats-row">
        <div class="stat-box total-visitors">
            <i class="fas fa-walking"></i>
            <div class="stat-content">
                <h3>Total Pengunjung</h3>
                <p class="stat-number">66</p>
            </div>
        </div>
        <div class="stat-box today-visitors">
            <i class="fas fa-user-tie"></i>
            <div class="stat-content">
                <h3>Pengunjung Hari Ini</h3>
                <p class="stat-number">66</p>
            </div>
        </div>
        <div class="time-box">
            <h3>Waktu</h3>
            <p id="current-time">23:59</p>
        </div>
        <div class="calendar-box">
            <h3>Kalender</h3>
            <!-- Tambahkan komponen kalender di sini -->
        </div>
    </div>
    <div class="chart-row">
        <div class="monthly-visitors-chart">
            <h3>Pengunjung Perbulan</h3>
            <!-- Tambahkan grafik di sini -->
            <div class="chart-placeholder"></div>
            <div class="chart-labels">
                <span>JAN</span>
                <span>FEB</span>
                <span>MAR</span>
                <span>APR</span>
                <span>MEI</span>
                <span>JUN</span>
                <span>JUL</span>
                <span>AGS</span>
                <span>SEP</span>
                <span>OKT</span>
                <span>NOV</span>
                <span>DES</span>
            </div>
        </div>
    </div>
</div>
@endsection