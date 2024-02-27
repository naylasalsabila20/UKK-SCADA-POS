<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function login(){
        {
            $validasiForm=[
                'email'=>'required',
                'password'=>'required'
            ];
    
            if($this->validate($validasiForm)){
                $email=$this->request->getPost('email');
                $password=md5($this->request->getPost('password'));
    
                $whereLogin=[
                    'email'=>$email,
                    'password'=>$password
                ];
    
                $cekLogin = $this->pengguna->where($whereLogin)->findAll(); 
               if (count($cekLogin)==1) {
                    $dataSession = [
                        'email'=>$cekLogin[0]['email'],
                        'password'=>$cekLogin[0]['password'],
                        'nama'=>$cekLogin[0]['nama'],
                        'level'=>$cekLogin[0]['level'],
                        'sudahkahLogin'=>true
                    ];
    
                    session()->set($dataSession);
                    return redirect()->to('/halaman-admin');
                    
                } else {
                    return redirect()->to('/')->with('pesan', '<p class="text-danger text-center">
                    Gagal Login! <br> Periksa Email atau Password!</p>');
                }
            }
    
            return view('login');
             }
            }
  
    public function halamanAdmin(){
        $data=[
            'DailySell'=>$this->penjualan->getDailySell(),   
            'DailyPenjualan'=>$this->penjualan->getDailyPenjualan(),  
            'listDetailPenjualan'=>$this->detail->getDailyDetailPenjualan(),
            'stokLow'=>$this->produk->jumlahStokHabis(), 
        ];
        return view('dashboard',$data);
    }
    public function logout(){
        session()->destroy();
        return redirect()->to('/');
 }

}
