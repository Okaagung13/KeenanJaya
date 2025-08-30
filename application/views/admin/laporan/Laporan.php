<!-- BEGIN: Content -->
<div class="content">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 2xl:col-span-9">
            <div class="intro-y box p-5">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-medium">Laporan Penjualan</h2>
                    <a href="<?= site_url('laporan/export1_pdf') ?>" class="btn btn-danger text-white">Export PDF</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-slate-100 text-slate-700">
                                <th class="whitespace-nowrap">No</th>
                                <th class="whitespace-nowrap">ID Pesanan</th>
                                <th class="whitespace-nowrap">Nama Pembeli</th>
                                <th class="whitespace-nowrap">Total Bayar</th>
                                <th class="whitespace-nowrap">Status</th>
                                <th class="whitespace-nowrap">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($laporan as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row->order_id, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>Rp <?= number_format($row->total_bayar ?? 0, 0, ',', '.') ?></td>
                                    <td>
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            <?= $row->status == 'Lunas' ? 'bg-success text-white' : 'bg-warning text-white' ?>">
                                            <?= $row->status ?? 'Belum Diketahui' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y H:i:s', strtotime($row->transaction_time)) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php if (empty($laporan)) : ?>
                        <div class="text-center text-slate-500 mt-4">Belum ada data laporan penjualan.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content -->
