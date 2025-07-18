<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<!-- Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css" rel="stylesheet">


<!-- CSS FIX: Hilangkan transparansi modal khusus halaman diskon -->
<style>
  .modal-content {
    background-color: #fff !important;
    backdrop-filter: none !important;
    opacity: 1 !important;
  }
</style>

<!-- ======= Page Title & Breadcrumb ======= 
<div class="pagetitle">
  <h1>Diskon</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Diskon</li>
    </ol>
  </nav>
</div> -->

<!-- ======= Alert Diskon Aktif Hari Ini ======= -->
<?php if (session()->get('diskon')) : ?>
  <div class="alert alert-success text-center" role="alert">
    Hari ini ada diskon <?= number_format(session('diskon'), 0, ',', '.') ?> per item
  </div>
<?php endif; ?>

<!-- Flashdata -->
<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show">
    <?= session('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php elseif (session()->getFlashdata('failed')) : ?>
  <div class="alert alert-danger alert-dismissible fade show">
    <?= session('failed') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<section class="section">
  <div class="card">
    <div class="card-body">

      <div class="d-flex justify-content-between align-items-center mt-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
          Tambah Diskon
        </button>
      </div>

      <!-- Table Start -->
<table class="table table-striped datatable">
  <thead>
    <tr>
      <th>#</th>
      <th>Tanggal</th>
      <th>Nominal</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach ($diskon as $d): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
        <td><?= number_format($d['nominal'], 0, ',', '.') ?></td>
        <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['id'] ?>">Ubah</button>
          <a href="/diskon/delete/<?= $d['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
<!-- Table End -->

<!-- Modal Edit Diskon (Semua Modal Harus di Luar <tbody>) -->
<?php foreach ($diskon as $d): ?>
  <div class="modal fade" id="modalEdit<?= $d['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content bg-white" action="/diskon/update/<?= $d['id'] ?>" method="post">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Edit Diskon</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="text" class="form-control" value="<?= $d['tanggal'] ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Nominal</label>
            <input type="number" name="nominal" class="form-control" value="<?= $d['nominal'] ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>

        </tbody>
      </table>

    </div>
  </div>
</section>

<!-- Modal Tambah -->
<?php $validation = \Config\Services::validation(); ?>
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= base_url('diskon/save') ?>">
      <?= csrf_field() ?>
      <div class="modal-header">
        <h5 class="modal-title">Tambah Diskon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="text"
                 id="tanggal-tambah"
                 name="tanggal"
                 placeholder="dd/mm/yyyy"
                 class="form-control <?= $validation->hasError('tanggal') ? 'is-invalid' : '' ?>"
                 value="<?= old('tanggal') ?>"
                 required>
          <div class="invalid-feedback"><?= $validation->getError('tanggal') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">Nominal</label>
          <input type="number"
                 name="nominal"
                 class="form-control <?= $validation->hasError('nominal') ? 'is-invalid' : '' ?>"
                 value="<?= old('nominal') ?>"
                 required>
          <div class="invalid-feedback"><?= $validation->getError('nominal') ?></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  flatpickr("#tanggal-tambah", {
    altInput: true,
    altFormat: "d/m/Y",
    dateFormat: "Y-m-d",
    theme: "dark"
  });
</script>




<?= $this->endSection() ?>
