<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard Toko</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding: 2rem; background-color: #f9f9f9; }
    table th, table td { vertical-align: middle !important; }
    h2 { text-align: center; margin-bottom: 0.5rem; }
    .subtext { text-align: center; color: #666; margin-bottom: 2rem; font-size: 0.95rem; }
    .table-wrapper { background: #fff; border-radius: 8px; padding: 1.5rem; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    .table th, .table td { text-align: center; }
    .table td.left { text-align: left; }
  </style>
</head>
<body>

<?php
function getTransaksi()
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => "http://localhost:8080/api",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            "accept: application/json",
            "key: random123678abcghi"
        ]
    ]);

    $out = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($out, true);
    return $json['results'] ?? [];
}

$transaksi = getTransaksi();
?>

<div class="container">
  <h2>Dashboard - TOKO</h2>
  <p class="subtext"><?= date('l, d-m-Y H:i:s') ?></p>

  <div class="table-wrapper">
    <h5 class="mb-3">Transaksi Pembelian</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Username</th>
            <th class="left">Alamat</th>
            <th>Total Harga</th>
            <th>Ongkir</th>
            <th>Status</th>
            <th>Tanggal Transaksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($transaksi): ?>
          <?php $no = 1; foreach ($transaksi as $row): ?>
            <?php
              $jumlahItem = $row['total_item'] ?? (
                isset($row['detail']) ? array_sum(array_column($row['detail'], 'jumlah')) : 0
              );

              $totalDiskon = 0;
              if (isset($row['detail'])) {
                  foreach ($row['detail'] as $item) {
                      $totalDiskon += $item['diskon'] * $item['jumlah'];
                  }
              }
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td class="left"><?= htmlspecialchars($row['alamat']) ?></td>
              <td>
                <?= number_format($row['total_harga'], 0, ',', '.') ?><br>
                <small>(<?= $jumlahItem ?> item<?= $totalDiskon > 0 ? ', diskon ' . number_format($totalDiskon, 0, ',', '.') : '' ?>)</small>
              </td>
              <td><?= number_format($row['ongkir'], 0, ',', '.') ?></td>
              <td>
                <?= $row['status'] == 1 ? '<span class="badge bg-success">Sudah Selesai</span>' : '<span class="badge bg-secondary">Belum Selesai</span>' ?>
              </td>
              <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endforeach ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center">Tidak ada data transaksi</td></tr>
        <?php endif ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
