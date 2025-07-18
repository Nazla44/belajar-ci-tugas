<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;
    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        helper('form');
    }

    // GET /diskon
    public function index()
    {
        /*if (! session()->get('isLoggedIn')) {
        return redirect()
            ->to('/login')
            ->with('failed', 'Silakan login dulu.');
    }*/
        return view('v_diskon', [
            'title'  => 'Data Diskon',
            'diskon' => $this->diskonModel->findAll()
        ]);
    }
    

    // GET /diskon/create
    public function create()
    {
        return view('diskon/create', [
            'title' => 'Tambah Diskon',
            'validation' => \Config\Services::validation()
        ]);
    }

    // POST /diskon/save
   public function save()
{
    $rules = [
        'tanggal' => 'required|is_unique[diskon.tanggal]',
        'nominal' => 'required|numeric'
    ];

    if (! $this->validate($rules)) {
    return redirect()->back()
        ->withInput()
        ->with('failed', implode('<br>', $this->validator->getErrors()));
    }

    $this->diskonModel->save([
        'tanggal' => $this->request->getPost('tanggal'),
        'nominal' => $this->request->getPost('nominal')
    ]);

    return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan');
}


    // GET /diskon/edit/{id}
    public function edit($id)
    {
        return view('diskon/edit', [
            'title'  => 'Edit Diskon',
            'diskon' => $this->diskonModel->find($id),
            'validation' => \Config\Services::validation(),

        ]);
    }

    // POST /diskon/update/{id}
    public function update($id)
    {
        $rules = [
            'nominal' => 'required|numeric'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getPost('nominal')
        ]);
        return redirect()->to('/diskon')->with('success', 'Diskon di‑update');
    }

    // GET /diskon/delete/{id}
    public function delete($id)
    {
        $this->diskonModel->delete($id);
        return redirect()->to('/diskon')->with('success', 'Diskon dihapus');
    }
}
