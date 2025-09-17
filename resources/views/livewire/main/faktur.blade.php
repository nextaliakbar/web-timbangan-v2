<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$dataTimbang->UNIQ_ID}} - {{$dataTimbang->ID_BARANG}}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');

        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .faktur-container {
            border: 2px dashed #ccc;
            width: 3cm;
            height: 5cm;
            padding: 2mm;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            box-sizing: border-box;
            
            /* Menggunakan Flexbox untuk sebaran vertikal */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            font-size: 5pt;
            line-height: 1.2;
        }

        .header, .content, .weight, .jo-numbers-container {
             width: 100%;
        }

        .product-name {
            font-weight: bold;
        }

        .weight {
            font-size: 10pt;
            font-weight: 700;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 1mm 0;
            margin: 1mm 0;
        }

        .pcs, .jo-number {
            font-size: 4.5pt;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        
        /* Tombol Cetak */
        .print-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        @media print {
            @page {
                size: 3cm 5cm;
                margin: 0;
            }

            body, html {
                margin: 0 !important;
                padding: 0 !important;
                height: 100%;
                min-height: auto;
                background: none;
            }

            body > * {
                display: none;
            }

            .faktur-container {
                display: flex !important;
                position: fixed;
                top: 0;
                left: 0;

                border: none;
                box-shadow: none;

                width: 3cm;
                height: 5cm;
                padding: 2mm;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>

    <!-- Elemen ini yang akan dicetak oleh browser -->
    <div class="faktur-container">
        <div class="header">
            <div class="ref-id">{{$dataTimbang->UNIQ_ID}}</div>
            <div class="datetime">{{date('Y-m-d H:i', strtotime($dataTimbang->WAKTU))}}</div>
        </div>

        <div class="content">
            <div class="product-name">{{$dataTimbang->NAMA_BARANG}}</div>
            <div class="status">{{$dataTimbang->DARI}}</div>
        </div>

        <div class="weight">{{$dataTimbang->BERAT_FILTER}}</div>
        
        @if(!empty($dataTimbang->PCS))
            <div class="pcs">PCS = {{$dataTimbang->PCS}}</div>
        @endif

        <div class="jo-numbers-container">
            @foreach ($dataJo as $data)
                <div class="jo-number">{{$data->NO_JO}}</div>
            @endforeach
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>

