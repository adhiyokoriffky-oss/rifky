<?php
//  Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Koneksi database
require_once ('koneksi.php');
function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// Ambil data barang masuk
$data = query(" SELECT sl.id, p.product_code, p.product_name, c.category_name, sl.qty, sl.stock_before, sl.stock_after, sl.note, sl.created_at, u.name AS created_by
                FROM stock_logs sl
                JOIN products p ON sl.product_id = p.id
                JOIN categories c ON p.category_id = c.id
                JOIN users u ON sl.created_by = u.id
                WHERE sl.change_type = 'ADD'
                ORDER BY sl.created_at DESC");

// Inisialisasi mPDF
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4-L'
]);

$html = '
<html>
<head>
    <title>Laporan Barang Masuk</title>
    <style>
        body { font-family: sans-serif; }

        h1 { 
            text-align: center; 
             color: #262626;
             margin-bottom: 5px;
        }

        h3 { 
            text-align: center; 
             margin-top: 0;
             margin-bottom: 20px;
        }
        table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-bottom: 20px;
        }
        thead th { 
                background-color: #198754; 
                color: white;
                padding: 10px; 
                font-size: 12px;
        }
        tbody td {
            padding: 8px;
            font-size: 11px;
            border: 1px solid #ccc;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-center { 
            text-align: center; 
        }
        .text-right { 
            text-align: right; 
        }
        .qty-masuk {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>InvAdmin</h1>
    <h3>LAPORAN BARANG MASUK</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Qty Masuk</th>
                <th>Stok Sebelum</th>
                <th>Stok Sesudah</th>
                <th>Keterangan</th>
                <th>Diinput Oleh</th>
            </tr>
        </thead>
        <tbody>
';

$no = 1;

foreach ($data as $row) {
    $html .= '
        <tr>
            <td class="text-center">' . $no++ . '</td>
            <td class="text-center">' . date('d-m-Y H:i', strtotime($row['created_at'])) . '</td>
            <td>' . $row['product_code'] . '</td>
            <td>' . $row['product_name'] . '</td>
            <td>' . $row['category_name'] . '</td>
            <td class="text-center qty-masuk">+' . $row['qty'] . '</td>
            <td class="text-center">' . $row['stock_before'] . '</td>
            <td class="text-center">' . $row['stock_after'] . '</td>
            <td>' . $row['note'] . '</td>
            <td class="text-center">' . $row['created_by'] . '</td>
        </tr>
    ';
}

$html .= '
        </tbody>
    </table>
</body>
</html>
';

// Generate PDF
$mpdf->WriteHTML($html);
$mpdf->Output('laporan_barang_masuk.pdf', 'I');
?>