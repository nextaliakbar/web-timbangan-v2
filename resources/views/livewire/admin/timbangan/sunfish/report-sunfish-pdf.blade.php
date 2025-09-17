<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Serah Terima Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table, .main-table, .footer-table {
            margin-bottom: 15px;
        }
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        .info-table td {
            padding: 3px;
        }
        .header-table td {
            padding: 5px 0;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; align-items: center;}
        .no-border td { border: none; }
        .footer-table td {
            border: 1px solid black;
            height: 100px;
            vertical-align: top;
        }

        .separator {
            border-top: 2px solid black;
            width: 50%;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: auto; 
            margin-right: auto;
        }
    </style>
</head>
<body>

    <table class="header-table no-border">
        <tr>
            <td class="text-left"><strong>{{$plant}}</strong></td>
            <td class="text-right"><strong>{{$plant}}/FRP/KIO.01,Rev : 00</strong></td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-bottom: 20px;">BUKTI SERAH TERIMA BARANG</h3>

    <table class="info-table no-border">
        <tr>
            <td><strong>Jenis Barang yang Diserahkan : {{$data->KATEGORI}}</strong></td>
            <td><strong>No : {{$data->UNIQ_ID}}</strong></td>
        </tr>
        <tr>
            <td><strong>Dari - Ke : {{"$data->DARI $data->KETERANGAM"}}</strong></td>
            <td><strong>Tgl : {{date('Y-m-d H:i', strtotime($data->WAKTU))}}</strong></td>
        </tr>
         <tr>
            <td></td>
            <td class="text-right"><b>Shift : {{$data->SHIFT}}</b></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Tgl Produksi</th>
                <th>Tgl TIMBANG</th>
                <th>Berat Barang</th>
                <th>WTA</th>
                <th>WHT</th>
                <th>Total Berat (x)(Kg)</th>
                <th>PCS/ROLL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->ID_BARANG}}</td>
                    <td>{{$item->NAMA_BARANG}}</td>
                    @if(empty($item->TGL_PRODUKSI) && empty($item->SHIFT_PRODUKSI))
                        <td>-,-</td>
                    @elseif(!empty($item->TGL_PRODUKSI) && empty($item->SHIFT_PRODUKSI))
                        <td>{{$item->TGL_PRODUKSI}},-</td>
                    @elseif(empty($item->TGL_PRODUKSI) && !empty($item->SHIFT_PRODUKSI))
                        <td>-,{{$item->SHIFT_PRODUKSI}}</td>
                    @else
                        <td>{{$item->TGL_PRODUKSI}},{{$item->SHIFT_PRODUKSI}}</td>
                    @endif
                    <td>{{date('Y-m-d', strtotime($item->WAKTU))}}</td>
                    <td>{{round($item->BERAT_FILTER, 2)}}</td>
                    <td>{{$item->WTA}}</td>
                    <td>{{$item->WHT}}</td>
                    <td>{{empty($item->REALQTY) 
                    ? (round(1 * $item->BERAT_FILTER)) 
                    : (round($item->REALQTY * $item->BERAT_FILTER))}}</td>
                    <td>{{$item->PCS}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td class="text-center" style="padding-bottom: 14px; padding-top: 14px;"><strong>Diserahkan Oleh</strong>
                <br><br><br><br><br><br><br><br>
                <strong>Ali Akbar Rafsanjani</strong>
                <div class="separator"></div>
                <strong>PIC SERAH</strong>
            </td>
            <td class="text-center" style="padding-bottom: 14px; padding-top: 14px;"><strong>Diterima Oleh</strong>
                <br><br><br><br><br><br><br><br>
                <strong>Ali Akbar Rafsanjani</strong>
                <div class="separator"></div>
                <strong>PIC TERIMA</stron>
            </td>
        </tr>
    </table>

</body>
</html>