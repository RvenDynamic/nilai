<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('guest/login');
    }

    public function loginPolres()
    {
       if (isLogin()) {
            if (user('role') !== 'admin') {
                return redirect()->to('/polsek');
            } 

            return redirect()->to('/polres');
       }
        return view('guest/login_polres');
    }

    public function loginPolsek()
    {
        if (isLogin()) {
            if (user('role') !== 'satuan fungsi') {
                return redirect()->to('/polres');
            }
            
            return redirect()->to('/polsek');
       }

        return view('guest/login_polsek');
    }

    public function lupaPassword()
    {
        return view('guest/lupa_password');
    }

    public function resetPassword()
    {
        return view('guest/password_baru');
    }
  
}