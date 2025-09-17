<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Timbangan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000;
            padding: 24px;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <h3 class="text-center font-bold">Laporan Timbangan Barang 3</h3>

    <table class="details-table" style="margin: 20px auto; border-collapse: collapse">
        <tr>
            <td>Plant</td>
            <td>:</td>
            <td><strong>{{$plant}}</strong></td>
        </tr>
        <tr>
            <td>No.BSTB</td>
            <td>:</td>
            <td>{{$bstbNumber}}</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{$date}}</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td>{{$itemName}}</td>
        </tr>
        <tr>
            <td>Tanggal Update</td>
            <td>:</td>
            <td>{{$updateDate}}</td>
        </tr>
        <tr>
            <td>Dimensi</td>
            <td>:</td>
            <td>{{$dimension}}</td>
        </tr>
    </table>

</body>
</html>