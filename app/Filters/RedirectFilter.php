<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RedirectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $session = session();
    if ($session->has('logged_in')) {
        return redirect()->to('/produk'); // Redirect ke produk setelah login
    }
}
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
{
    return $response; // Tidak melakukan apa-apa
}

}