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
            background-color: #2c3e50;
            padding: 10px;
            text-align: center;
            color: white;
        }

        .header img {
            height: 50px;
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
            margin: 20px 0;
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
        }
    </style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo">
    <h1>Dashboard Admin Tamu</h1>
</div>

<div class="container">
    <!-- Cards Section -->
    <div class="card card-total">
        <h2>Total Pengunjung</h2>
        <p>66</p>
    </div>

    <div class="card card-today">
        <h2>Pengunjung Hari Ini</h2>
        <p>66</p>
    </div>

    <div class="card">
        <h2>Waktu</h2>
        <div class="clock" id="clock">00:00:00</div>
    </div>

    <div class="card">
        <h2>Kalender</h2>
        <div class="calendar" id="calendar"></div>
    </div>

    <!-- Visitor Table Section -->
    <div class="table-container">
        <h2>Daftar Pengunjung</h2>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>1234567890</td>
                    <td>johndoe@example.com</td>
                    <td>XYZ Corp</td>
                    <td>Meeting</td>
                    <td>None</td>
                </tr>
                <!-- Tambahkan data pengunjung lainnya -->
            </tbody>
        </table>
    </div>
</div>

<!-- Script untuk jam dan kalender -->
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').innerHTML = hours + ':' + minutes + ':' + seconds;
    }

    function updateCalendar() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('calendar').innerHTML = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateClock, 1000);
    updateCalendar();
</script>

</body>
</html>
