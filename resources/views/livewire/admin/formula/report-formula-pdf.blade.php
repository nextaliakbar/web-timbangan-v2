<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Gramatur Raw Material</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #000;
            padding: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table, .info-table, .main-table {
            margin-bottom: 15px;
        }
        .header-table td {
            padding: 2px 0;
        }
        .info-table td {
            border: 1px solid black;
            padding: 4px;
        }
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        .main-table th {
            font-weight: bold;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="text-left font-bold">{{$dataHeader->TEMPAT}}</td>
            <td class="text-right">{{$dataHeader->TEMPAT}}/FR/PRE.09,Rev 00</td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td rowspan="3">
                <h1 class="text-center font-bold"><strong>GRAMATUR RAW MATERIAL</strong></h1>
            </td>
            <td><strong>ID : {{$dataHeader->NO_DOK}}</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Tanggal Timbang : {{$dataHeader->WAKTU_TIMBANG}}</strong></td>
            <td><strong>Shift: {{$dataHeader->SHIFT_TIMBANG}}</strong></td>
        </tr>
         <tr>
            <td><strong>Tanggal Produksi : {{$dataHeader->WAKTU_PROD}}</strong></td>
            <td><strong>Shift: {{$dataHeader->SHIFT_PROD}}</strong></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>Nama barang</th>
                <th>No Batch</th>
                <th>No Lot</th>
                <th>Qty Timbang</th>
                <th>Penimbang</th>
                <th>Verifikator</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTables as $dataTable)
                <tr>
                    <td>{{$dataTable['NAMA_BARANG'] ?? 'BARANG 1'}}</td>
                    <td>{{$dataTable['BATCH'] ?? 10}}</td>
                    <td>{{$dataTable['NO_LOT'] ?? '1234567890'}}</td>
                    <td>{{number_format($dataTable['BERAT_PER_LOT'] ?? 50, 2, ",")}}</td>
                    <td>{{$dataTable['NAMA'] ?? 'Ali Akbar Rafsanjani'}}</td>
                    <td>{{$dataTable['VERIF'] ?? 'V-123455'}}</td>
                    <td>{{$dataTable['KET'] ?? 'KETERANGAN TEST'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>