<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Isi Buku Tamu</h1>
    <form method="post" action="{{route('guestbook.store')}}">
        @csrf
        @method('post')
        <div>
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama Lengkap"/>
        </div>
        <div>
            <label>No HP</label>
            <input type="text" name="nohp" placeholder="Isi No HP"/>
        </div>
        <div>
            <label>Email</label>
            <input type="text" name="email" placeholder="Isi Alamat Email"/>
        </div>
        <div>
            <label>Instansi</label>
            <input type="text" name="instansi" placeholder="Isi Instansi"/>
        </div>
        <div>
            <label>Tujuan</label>
            <input type="text" name="tujuan" placeholder="Isi Tujuan"/>
        </div>
        <div>
            <label>Keterangan</label>
            <input type="text" name="ket" placeholder="Isi keterangan kunjungan"/>
        </div>
        <div>
            <input type="submit" value="Save"/>
        </div>
    </form>
</body>
</html>