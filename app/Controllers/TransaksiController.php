<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use GazzleHttp\Exception\RequestException;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;


    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();

    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    /*public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }*/
   public function cart_add()
{
    $id     = $this->request->getPost('id');
    $nama   = $this->request->getPost('nama');
    $foto   = $this->request->getPost('foto');
    $hargaAsli = (int) $this->request->getPost('harga');
    $harga = $hargaAsli;

    if (session()->has('diskon')) {
        $diskon = session('diskon');
        $harga -= $diskon;
        if ($harga < 0) $harga = 0;
    }

    $this->cart->insert([
        'id'    => $id,
        'qty'   => 1,
        'price' => $harga,
        'name'  => $nama,
        'options' => [
            'foto'       => $foto,
            'harga_asli' => $hargaAsli
        ]
    ]);

    session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
    return redirect()->to(base_url('/'));
}

/*public function cart_add()
    {
    $productModel = new ProductModel();
    $produk = $productModel->find();

    if (!$produk) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    $diskon = session()->get('diskon_nominal') ?? 0;
    $hargaSetelahDiskon = max(0, $produk['harga'] - $diskon);

    $this->cart->insert([
        'id'      => $produk['id'],
        'qty'     => 1,
        'price'   => $hargaSetelahDiskon,
        'name'    => $produk['nama'],
        'options' => [
            'foto' => $produk['foto'] ?? 'default.png'
        ]
    ]);
    }
    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }*/

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
{
    $data['items'] = $this->cart->contents();
    $data['total'] = $this->cart->total();

    return view('v_checkout', $data);
}

public function getLocation()
{
		//keyword pencarian yang dikirimkan dari halaman checkout
    $search = $this->request->getGet('search');

    $response = $this->client->request(
        'GET', 
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
            'verify' => false 
        ]
    );

    $body = json_decode($response->getBody(), true); 
    return $this->response->setJSON($body['data']);
}

   /* public function getLocation()
{ 
		//keyword pencarian yang dikirimkan dari halaman checkout
    $keyword = $this->request->getGet('search');

    $response = $this->client->request(
        'GET', 
        'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
        ]
    );

    $body = json_decode($response->getBody(), true); 
    // --- Bentuk array untuk Select2 ---
    $data = array_map(function ($item) {
        return [
            'id'   => $item['id'],
            'text' => $item['subdistrict_name'] . ', ' . $item['district_name'] . ', ' . $item['city_name'] . ', ' . $item['province_name'] . ', ' . $item['zip_code']
        ];
    }, $body['data']);
    return $this->response->setJSON($body['data']);
}
public function getLocation()
{
    $keyword = $this->request->getGet('search');

    // ----- Pastikan API‑key ada -----
    if (!$this->apiKey) {
        log_message('error', 'COST_KEY tidak ditemukan di .env');
        return $this->response->setStatusCode(500)
                              ->setJSON(['error' => 'API key missing']);
    }

    try {
        $response = $this->client->request('GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
            [
                'query' => ['search' => $keyword, 'limit' => 50],
                'headers' => [
                    'accept' => 'application/json',
                    'key'    => $this->apiKey,
                ],
                'timeout' => 5 // detik
            ]
        );

        $body = json_decode($response->getBody(), true);

        // ----- Validasi struktur -----
        if (!isset($body['data'])) {
            log_message('error', 'Field data tidak ada pada response getLocation: '
                                 . json_encode($body));
            return $this->response->setJSON(['results'=>[]]);
        }

        // ----- Bentuk hasil untuk Select2 -----
        $results = array_map(fn($row) => [
            'id'   => $row['id'],
            'text' => $row['subdistrict_name'] . ', ' .
                      $row['district_name']   . ', ' .
                      $row['city_name']       . ', ' .
                      $row['province_name']   . ', ' .
                      $row['zip_code']
        ], $body['data']);

        return $this->response->setJSON(['results' => $results]);

    } catch (RequestException $e) {
        // log & balikan kosong agar Select2 tidak macet
        log_message('error', 'getLocation error: ' . $e->getMessage());
        return $this->response->setJSON(['results'=>[]]);
    }
}

public function getLocation()
{
    $keyword = $this->request->getGet('search');
    log_message('debug', '==== getLocation keyword=' . $keyword);
    log_message('debug', '==== COST_KEY=' . ($this->apiKey ?: 'EMPTY'));

    try {
        $response = $this->client->request('GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
            [
                'query'   => ['search' => $keyword, 'limit' => 5],
                'headers' => [
                    'accept' => 'application/json',
                    'key'    => $this->apiKey,
                ],
                'timeout' => 5,      // maks 5 detik
                'verify'  => true    // ganti false bila SSL error
            ]
        );

        log_message('debug', '==== HTTP STATUS = ' . $response->getStatusCode());
        log_message('debug', '==== RAW BODY    = ' . $response->getBody());

        // kirim raw ke browser agar kita lihat strukturnya
        return $this->response->setJSON(json_decode($response->getBody(), true));

    } catch (\Throwable $e) {
        log_message('error', '==== EXCEPTION getLocation : ' . $e->getMessage());
        return $this->response->setStatusCode(500)
                              ->setJSON(['error' => $e->getMessage()]);
    }
}*/

public function getCost()
{ 
		//ID lokasi yang dikirimkan dari halaman checkout
    $destination = $this->request->getGet('destination');

		//parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
    //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
    $response = $this->client->request(
        'POST', 
        'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'multipart' => [
                [
                    'name' => 'origin',
                    'contents' => '64999'
                ],
                [
                    'name' => 'destination',
                    'contents' => $destination
                ],
                [
                    'name' => 'weight',
                    'contents' => '1000'
                ],
                [
                    'name' => 'courier',
                    'contents' => 'jne'
                ]
            ],
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
            'verify' => false
        ]
    );

    $body = json_decode($response->getBody(), true); 
    return $this->response->setJSON($body['data']);
}

public function buy()
{
    if ($this->request->getPost()) { 
        $dataForm = [
            'username' => $this->request->getPost('username'),
            'total_harga' => $this->request->getPost('total_harga'),
            'alamat' => $this->request->getPost('alamat'),
            'ongkir' => $this->request->getPost('ongkir'),
            'status' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->transaction->insert($dataForm);

        $last_insert_id = $this->transaction->getInsertID();

        foreach ($this->cart->contents() as $value) {
            $dataFormDetail = [
                'transaction_id' => $last_insert_id,
                'product_id' => $value['id'],
                'jumlah' => $value['qty'],
                'diskon' => isset($value['options']['harga_asli']) 
    ? ($value['options']['harga_asli'] - $value['price']) 
    : 0,
'subtotal_harga' => $value['qty'] * $value['price'],

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transaction_detail->insert($dataFormDetail);
        }

        $this->cart->destroy();
 
        return redirect()->to(base_url());
    }
}
}
