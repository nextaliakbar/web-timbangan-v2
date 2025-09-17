<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Serah Terima Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px; /* Sedikit lebih kecil agar muat */
            padding: 12px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px; /* Kurangi margin bawah */
        }
        .header-table, .main-table, .info-table, .footer-table {
            margin-bottom: 10px;
        }
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 4px; /* Kurangi padding */
            text-align: center;
        }
        .info-table td {
            padding: 2px 5px; /* Padding lebih kecil */
            vertical-align: top; /* Sejajarkan ke atas */
        }
        .header-table td {
            padding: 3px 0;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .no-border td { border: none; }
        
        .footer-table {
            margin-top: 20px; /* Tambah jarak dari tabel utama */
        }
        .footer-table td {
            border: 1px solid black;
            height: 90px; /* Kurangi tinggi sedikit */
            vertical-align: top;
            padding-top: 10px;
        }
        .footer-table .signature-line {
            border-top: 1px solid black;
            width: 80%; /* Lebar garis */
            margin: 5px auto 0 auto; /* Tengah, jarak atas sedikit */
        }
        .small-text { font-size: 12px; } /* Untuk teks PIC */
        .bold { font-weight: bold; }
        .red-text { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <table class="header-table no-border">
        <tr>
            <td class="text-left bold">UNIMOS</td>
            <td class="text-right bold small-text">UNIMOS/FR.PRO/KIO.01,Rev : 00</td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-bottom: 15px; margin-top: 10px;">BUKTI SERAH TERIMA BARANG</h3>

    <table class="info-table">
        <tr>
            <td class="bold" style="width: 50%; border: 1px solid black; padding: 5px;">Jenis Barang yang Diserahkan : KATEGORI 3</td>
            <td class="bold" style="width: 25%; border: 1px solid black; padding: 5px;">No : 85944130</td>
            <td class="bold" style="width: 25%; border: 1px solid black; padding: 5px;">Shift : 2</td>
        </tr>
        <tr>
            <td class="bold" style="border: 1px solid black; padding: 5px;">Dari - Ke : MGFI</td>
            <td class="bold" style="border: 1px solid black; padding: 5px;">Tgl : 2025-04-04</td>
            <td class="bold" style="border: 1px solid black; padding: 5px;"></td> </tr>
        <tr>
            <td class="bold" style="border: 1px solid black; padding: 5px;">No STF/WHT : -</td>
            <td colspan="2" style="border: 1px solid black; padding: 5px;"></td> </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kode Barang</th>
                <th rowspan="2">Jenis Barang</th>
                <th colspan="2">Tgl Produksi</th>
                <th rowspan="2">Berat Barang</th>
                <th rowspan="2">NO STF</th>
                <th rowspan="2">NO WHT</th>
                <th colspan="2">Total Barang</th>
                <th rowspan="2">PCS/ROLL</th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>QTY</th>
                <th>Total Berat (Kg)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>9833</td>
                <td>Barang 3</td>
                <td>2025-05-27</td>
                <td>17:52:21</td>
                <td>50</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>40</td>
                <td>50</td>
                <td>300</td>
            </tr>
            <tr>
                <td colspan="11" class="text-left red-text" style="padding-left: 10px;">
                    <span style="font-size: 12px;">&#x2022; Berat (9833) = 50 = Keterangan Timbang</span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td class="text-center" style="width: 50%;">
                <strong class="small-text">Diserahkan Oleh</strong>
                <br><br><br><br><br><br><br><br>
                <strong class="small-text">Ali Akbar Rafsanjani</strong>
                <div class="signature-line"></div>
                <strong class="small-text">PIC SERAH</strong>
            </td>
            <td class="text-center" style="width: 50%;">
                <strong class="small-text">Diterima Oleh</strong>
                <br><br><br><br><br><br><br><br>
                <strong class="small-text">Ali Akbar Rafsanjani</strong>
                <div class="signature-line"></div>
                <strong class="small-text">PIC TERIMA</strong>
            </td>
        </tr>
    </table>
</body>
</html>