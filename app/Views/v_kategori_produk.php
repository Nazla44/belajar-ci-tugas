<?= $this->extend('layout') ?>
<?= $this->section('content') ?> 

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashData('success') ?></div>
<?php endif ?>
<?php if (session()->getFlashData('failed')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashData('failed') ?></div>
<?php endif ?>

<!-- Tombol Tambah -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Kategori
</button>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/kategori-produk/simpan') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> <!-- Tombol Tutup -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tabel Data -->
<table class="table mt-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($kategori)) : ?>
            <?php $no=1; foreach ($kategori as $kat) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kat['nama_kategori']) ?></td>
                    <td>
                        <!-- Tombol Edit (Modal) -->
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $kat['id'] ?>">Edit</button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $kat['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?= base_url('/kategori-produk/update/' . $kat['id']) ?>" method="post">
                                        <?= csrf_field(); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="nama_kategori" class="form-control" value="<?= esc($kat['nama_kategori']) ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> <!-- Tombol Tutup -->
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <a href="<?= base_url('/kategori-produk/delete/' . $kat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr><td colspan="3">Belum ada data kategori.</td></tr>
        <?php endif ?>
    </tbody>
</table>

<?= $this->endSection() ?>
