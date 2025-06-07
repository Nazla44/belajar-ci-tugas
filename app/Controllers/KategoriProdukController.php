<?php

namespace App\Controllers;

use App\Models\KategoriProdukModel;

class KategoriProdukController extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriProdukModel();
    }

    // Tampilkan daftar kategori
    public function index()
    {
        $data['kategori'] = $this->kategori->findAll();
        return view('v_kategori_produk', $data);
    }

    // Simpan data baru
    public function create()
{
    $dataForm = [
        'nama_kategori' => $this->request->getPost('nama_kategori'),
        'created_at' => date("Y-m-d H:i:s")
    ];

    // Simpan data ke database
    $this->kategori->insert($dataForm);

    return redirect()->to('/kategori-produk')->with('success', 'Kategori berhasil ditambahkan');
}


    // Tampilkan form edit (optional)
    public function edit($id)
    {
        $data['kategori'] = $this->kategori->find($id);
        return view('v_kategori_produk', $data);
    }

    // Update data
    public function update($id)
    {
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->kategori->update($id, $data);
        return redirect()->to('/kategori-produk')->with('success', 'Kategori berhasil diupdate');
    }

    // Hapus data
    public function delete($id)
    {
        $this->kategori->delete($id);
        return redirect()->to('/kategori-produk')->with('success', 'Data berhasil dihapus!');
    }
}
