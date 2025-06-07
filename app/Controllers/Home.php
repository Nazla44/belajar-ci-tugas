<?php

namespace App\Controllers;

use App\Models\ProductModel;
class Home extends BaseController
{
    protected $product;
    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
    }

    public function index(): string
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home', $data);
    }

    // 1. TAmbahkan method untuk FAQ
    public function faq(): string
    {
        $data = [
            'title' => 'FAQ',
            'faqs'  => [
                'question' => 'Bagaimana Cara Memesan Produk?',
                'answer'   => 'Login terlebih dahulu, lalu pilih produk di menu Katalog.'
            ],
            [
                'question' => 'Bagaimanasistem pembayaran?',
                'answer'   => 'Kami menerima transfer bank dan pembayaran digital.'
            ]
        ];
        return view('faq',$data);
    }
}
