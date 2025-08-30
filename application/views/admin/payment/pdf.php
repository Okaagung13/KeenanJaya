<h2><center>Data Pemesanan</center></h2>
<hr/>
<table border="1" width="" style="text-align:center;">
	<tr>
		<th>No</th>
		<th>Nama Barang</th>
		<th>Harga Barang</th>
		<th>Qty</th>
		<th>Total Harga</th>
	</tr>
	<?php 
	$no=1; 
	$total = 0;
	foreach ($pesanan as $row) :
		$subtotal = $row->jumlah * $row->harga; 
		$total += $subtotal; 
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?= $row->nama_brg?></td>
			<td>Rp. <?= number_format($row->harga, 0, ',', '.') ?></td>
			<td><?= number_format($row->jumlah, 0, ',', '.') ?></td>
			<td>Rp. <?= number_format($subtotal, 0, ',', '.') ?></td>
		</tr>
	<?php endforeach; ?>
</table>