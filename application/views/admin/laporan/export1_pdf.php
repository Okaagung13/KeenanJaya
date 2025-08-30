<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>LAPORAN PENJUALAN</h3>
     
    <table>
        <thead>
            <tr>
                <th>No </th>
                <th>ID Pesanan</th>
                <th>Nama Pembeli</th>
                <!---  <th>Total Bayar</th> --->
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($laporan as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->order_id ?></td>
                <td><?= $row->name ?></td>
                <!---  <td>Rp <?= number_format($row->total_bayar ?? 0, 0, ',', '.') ?></td> --->
                <td><?= $row->status ?? 'Belum Diketahui' ?></td>
                <td><?= $row->transaction_time ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
