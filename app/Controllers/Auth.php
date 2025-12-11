<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\ForgotPassword;
use App\Models\UserLog;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $TUser;
    protected $TForgotPassword;
    protected $TUserLog;
    protected $emailService;

    public function __construct() {
        $this->TUser = new Users();
        $this->TForgotPassword = new ForgotPassword();
        $this->TUserLog = new UserLog();
        $this->emailService = \Config\Services::email();
    }
    
    public function login()
    {

        // data 
        $destiny = $this->request->getVar('destiny');
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
        ];

        // data for user validation is login
        $userAgent = $this->request->getUserAgent();
        $dataIsLogin = [
            'ip_address' => $this->request->getIPAddress(),
            'device' => $userAgent->getAgentString(),
        ];  

        if ($data['username'] == null || $data['password'] == null) {
            session()->setFlashdata('error_login', 'Username dan Password harus diisi');
            return redirect()->back();
        }

        $user = $this->TUser->select("users.*, roles.name as role, satfungs.name as satfung")->join('roles', 'roles.role_id = users.role_id')->join('satfungs', 'satfungs.satfung_id = users.satfung_id')->where('username', $data['username'])->first();
        
        if ($user) {
            // user is email verified/active 
            if ($user['is_verified'] == false) {
                session()->setFlashdata('error_login', 'Akun belum diverifikasi, silahkan cek email anda');
                return redirect()->back();
            }
    
            // jika user role nya tidak sesuai hak akses
            if ($user['role'] != $destiny) {
                session()->setFlashdata('error_login', 'Anda tidak memiliki akses ke halaman tersebut, login sesuai dengan role anda!');
                return redirect()->back();
            }

            //  check user is login or not
            // if user is login
            $isLogin = $this->TUserLog->where("user_id", $user['user_id'])->first();
            
            if ($isLogin) {
                if ($isLogin['device'] !== $dataIsLogin['device']) {
                    // send email to user
                    $sendDataEmailIsLogin = [
                        "username" => $user['username'],
                        "email" => $user['email'],
                        "device" => $dataIsLogin['device'],
                    ];
    
                     // send email
                    $this->emailService->setFrom('three3teamofficial@gmail.com', 'Three3 Team');
                    $this->emailService->setTo($user['email']);
                    $this->emailService->setSubject('Verification Code');
    
                    $this->emailService->setHeader('Reply-To', 'three3teamofficial@gmail.com');
                    $this->emailService->setHeader('List-Unsubscribe', '<mailto:unsubscribe@yourdomain.com>');
    
                    $this->emailService->setMailType('html');
    
                    $msgViewIsLogin = view('utils/email/login_another_device', $sendDataEmailIsLogin);
                    $this->emailService->setMessage($msgViewIsLogin);
                    
                    if (!$this->emailService->send()) {
                        session()->setFlashdata('error_login', 'Gagal mengirim email');
                        return redirect()->back();
                    }
    
                    session()->setFlashdata('error_login', 'Anda sudah login di perangkat lain');
                    return redirect()->back();
                } else {
                                                // login proccess original
                                                $pass = $data['password'];
                                                $authenticatedPassword = password_verify($pass, $user['password']);
                                                if($authenticatedPassword) {
                                                    $sessionUser = [
                                                        'uid' => $user['user_id'],
                                                        'username' => $user['username'],
                                                        'role' => $user['role'],
                                                        'satfung' => $user['satfung'],
                                                        'satfung_id' => $user['satfung_id'],
                                                        'isLogin' => true,
                                                    ];
                                                    session()->set($sessionUser);
                                    
                                                    $role = $user['role'];
                                                    if ($role == 'admin') {
                                                        return redirect()->to('/polres');
                                                    } else {
                                                        return redirect()->to('/polsek');
                                                    }
                                                } else {
                                                    session()->setFlashdata('error_login', 'Password salah');
                                                    return redirect()->back();
                                                }
                }
            } else {

                            // login proccess with input is login
                            $pass = $data['password'];
                            $authenticatedPassword = password_verify($pass, $user['password']);
                            if($authenticatedPassword) {
                                $sessionUser = [
                                    'uid' => $user['user_id'],
                                    'username' => $user['username'],
                                    'role' => $user['role'],
                                    'satfung' => $user['satfung'],
                                    'satfung_id' => $user['satfung_id'],
                                    'isLogin' => true,
                                ];
                                session()->set($sessionUser);

                                // save user log
                                $dataUserLogSave = [
                                    "user_id" => $user['user_id'],
                                    "device" => $dataIsLogin['device'],
                                    "ip_address" => $dataIsLogin['ip_address'],
                                ];

                                if (!$this->TUserLog->save($dataUserLogSave)) {
                                    session()->setFlashdata('error_login', 'Gagal menyimpan log user');
                                    return redirect()->back();
                                }
                
                                $role = $user['role'];
                                if ($role == 'admin') {
                                    return redirect()->to('/polres');
                                } else {
                                    return redirect()->to('/polsek');
                                }
                            } else {
                                session()->setFlashdata('error_login', 'Password salah');
                                return redirect()->back();
                            }
            } 
        } else {
            session()->setFlashdata('error_login', 'Username tidak ditemukan');
            return redirect()->back();
        }
    }
 
    public function register() {
       helper(['form']);
       if(!$this->validate([
         'username' => [
            'rules' => 'required|min_length[5]|max_length[100]|is_unique[users.username]',
            'errors' => [
                'required' => '{field} Harus diisi',
                'min_length' => '{field} Minimal 5 Karakter',
                'max_length' => '{field} Maksimal 100 Karakter',
                'is_unique' => 'Username sudah digunakan sebelumnya'
            ]
            ],
         'email' => [
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => '{field} Harus diisi',
                'valid_email' => 'email tidak valid',
                'is_unique' => 'email sudah digunakan sebelumnya'
            ]
            ],
         'role_id' => [
                'rules' => 'required|is_not_unique[roles.role_id]',
                'errors' => [
                    'required' => 'Role Harus diisi',
                    'is_not_unique' => "Role harus dipilih dan sesuai dengan yang tersedia"
                ]
            ],
         'satfung_id' => [
                'rules' => 'required|is_not_unique[satfungs.satfung_id]',
                'errors' => [
                    'required' => 'satfung Harus diisi',
                    'is_not_unique' => 'satfung harus dipilih dan sesuai dengan yang tersedia'
                ]
            ],
         'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 8 Karakter',
                ]
            ],
         'password_conf' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan password',
                ]
            ],
        
       ])) {
            $msg_error = $this->validator->listErrors();
            session()->setFlashdata('error_register', $msg_error);
            return redirect()->back()->withInput();
       }

       // generate verification code
       $verification_code = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
       
       // send email
       $this->emailService->setFrom('three3teamofficial@gmail.com', 'Three3 Team');
       $this->emailService->setTo($this->request->getVar('email'));
       $this->emailService->setSubject('Verification Code');

       $this->emailService->setHeader('Reply-To', 'three3teamofficial@gmail.com');
       $this->emailService->setHeader('List-Unsubscribe', '<mailto:unsubscribe@yourdomain.com>');

       $msgViewData = [
              'username' => $this->request->getVar('username'),
              'verification_code' => $verification_code,
       ];
       $msgView = view('utils/email/verification_email_account', $msgViewData);
       $this->emailService->setMailType('html');
       $this->emailService->setMessage($msgView);
       
       if (!$this->emailService->send()) {
          session()->setFlashdata('error_register', 'Gagal mengirim email');
          return redirect()->back();
       }

       $data = [
              'username' => $this->request->getVar('username'),
              'email' => $this->request->getVar('email'),
              'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
              'role_id' => $this->request->getVar('role_id'),
              'satfung_id' => $this->request->getVar('satfung_id'),
              'verification_code' => $verification_code,
       ];


       if(!$this->TUser->save($data)) { 
         return redirect()->back()->withInput();  
       }

     session()->setFlashdata('success_register', 'Berhasil register');
     return redirect()->to('/polres/kelola-akun');
    }

    public function verifyAccount($verification_code) {
        $user = $this->TUser->where('verification_code', $verification_code)->first();

        if (!$user) {
            session()->setFlashdata('error_verify_account', 'Code tidak valid');
            return redirect()->to('/error-verify-account');
        }

        if ($user['is_verified'] == true) {
            session()->setFlashdata('error_verify_account', 'Akun sudah diverifikasi');
            return redirect()->to('/error-verify-account');
        }

        if (!$this->TUser->set('is_verified', true)->set('verification_code', null)->where('user_id', $user['user_id'])->update()) {
            session()->setFlashdata('error_verify_account', 'Gagal verifikasi akun');
            return redirect()->to('/error-verify-account');
        }

        session()->setFlashdata('success_verify_account', 'Berhasil verifikasi akun');
        return redirect()->to('/');
    }

    public function changePassword() {
        helper(['form']);
        if(!$this->validate([
          'old_password' => [
                 'rules' => 'required|min_length[8]',
                 'errors' => [
                     'required' => '{field} Harus diisi',
                     'min_length' => '{field} Minimal 8 Karakter',
                 ]
             ],
          'new_password' => [
                 'rules' => 'required|min_length[8]',
                 'errors' => [
                     'required' => '{field} Harus diisi',
                     'min_length' => '{field} Minimal 8 Karakter',
                 ]
             ],
          'confirm_password' => [
                 'rules' => 'matches[new_password]',
                 'errors' => [
                     'matches' => 'Konfirmasi Password tidak sesuai dengan password baru',
                 ]
             ],
         
        ])) {
             $msg_error = $this->validator->listErrors();
             session()->setFlashdata('error_change_password', $msg_error);
             return redirect()->back()->withInput();
        }

        $data = [
            'uid' => user('uid'),
            'old_password' => $this->request->getVar('old_password'),
            'new_password' => $this->request->getVar('new_password'),
        ];

        // is user exist
        $user = $this->TUser->where('user_id', $data['uid'])->first();
        if (!$user) {
            session()->setFlashdata('error_change_password', 'User tidak ditemukan');
            return redirect()->back();
        }

        // is old password correct
        $authenticatedPassword = password_verify($data['old_password'], $user['password']);
        if (!$authenticatedPassword) {
            session()->setFlashdata('error_change_password', 'Password lama salah');
            return redirect()->back();
        }

        // change password
        $new_password = password_hash($data['new_password'], PASSWORD_BCRYPT);
        if (!$this->TUser->set('password', $new_password)->where('user_id', $data['uid'])->update()) {
            session()->setFlashdata('error_change_password', 'Gagal mengganti password');
            return redirect()->back();
        }

        session()->setFlashdata('success_change_password', 'Berhasil mengganti password');
        return redirect()->back();
    }

    public function sendEmailForgotPassword() {
        helper(['form']);
        if(!$this->validate([
          'email' => [
                 'rules' => 'required|valid_email',
                 'errors' => [
                     'required' => '{field} Harus diisi',
                     'valid_email' => '{field} tidak valid',
                 ]
             ],
        ])) {
             $msg_error = $this->validator->listErrors();
             session()->setFlashdata('error_forgot_password', $msg_error);
             return redirect()->back()->withInput();
        }

        $email = $this->request->getVar('email');

        // user is exist
        $user = $this->TUser->where('email', $email)->first();
        if (!$user) {
            session()->setFlashdata('error_forgot_password', 'Email tidak ditemukan');
            return redirect()->back();
        }

        // create code
        $code = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        $data = [
            'user_id' => $user['user_id'],
            'code' => $code,
        ];

        // save to db 
        if (!$this->TForgotPassword->save($data)) {
            session()->setFlashdata('error_forgot_password', 'Gagal generate code');
            return redirect()->back();
        }

        // send email
        $this->emailService->setFrom('three3teamofficial@gmail.com', 'Three3 Team');
        $this->emailService->setTo($email);
        $this->emailService->setSubject('Forgot Password');
        
        $this->emailService->setHeader('Reply-To', 'three3teamofficial@gmail.com');
        $this->emailService->setHeader('List-Unsubscribe', '<mailto:unsubscribe@yourdomain.com>');

        $templateView = view('utils/email/forgot_password', ['username' => $user['username'] ,'code' => $code, 'email' => $email]);
        $this->emailService->setMailType('html');
        $this->emailService->setMessage($templateView);

        if (!$this->emailService->send()) {
            session()->setFlashdata('error_forgot_password', 'Gagal mengirim email');
            return redirect()->back();
        }

        session()->setFlashdata('success_forgot_password', 'Berhasil mengirim code untuk mengubah password, silahkan cek email anda');
        return redirect()->to('/reset-password');
    }

    public function verifyAndChangePasswordForgotPassword() {
        helper(['form']);
       if(!$this->validate([
        'code' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => '{field} Harus diisi',
                'min_length' => '{field} Minimal 3 Karakter',
            ]
            ],
            'new_password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 8 Karakter',
                ]   
            ],
            'confirm_password' => [
                'rules' => 'matches[new_password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan password baru',

                ]
            ],
       ])) {
        $msg = $this->validator->listErrors();
        session()->setFlashdata('error_forgot_password', $msg);
       }

       $data = [
        'code' => $this->request->getVar('code'),
        'new_password' => $this->request->getVar('new_password'),
       ];

       $ifCodeExist = $this->TForgotPassword->where('code', $data['code'])->first();
       if (!$ifCodeExist) {
          session()->setFlashdata('error_forgot_password', 'Code tidak valid');
          return redirect()->back();
        }

        $user_id = $ifCodeExist['user_id'];
        
        // update user password
        $new_password = password_hash($data['new_password'], PASSWORD_BCRYPT);
        if (!$this->TUser->set('password', $new_password)->where('user_id', $user_id)->update()) {
            session()->setFlashdata('error_forgot_password', 'Gagal mengganti password');
            return redirect()->back();
        }

        // delete code
        if (!$this->TForgotPassword->where('user_id', $user_id)->delete()) {
            session()->setFlashdata('error_forgot_password', 'internal server error: delete code');
            return redirect()->to('/');
        }

        session()->setFlashdata('success_forgot_password', 'Berhasil mengganti password');
        return redirect()->to('/');
    }

    public function deleteAccount($user_id) {
        if (!$this->TUser->where('user_id', $user_id)->delete()) {
            session()->setFlashdata('error_delete_account', 'Gagal menghapus akun');
            return redirect()->back();
        }

        session()->setFlashdata('success_delete_account', 'Berhasil menghapus akun');
        return redirect()->back();
    }

    public function logout() {
        // delete user log
        $user_id = user('uid');
        
        if (!$this->TUserLog->where('user_id', $user_id)->delete()) {
            session()->setFlashdata('error_logout', 'Gagal menghapus log user');
            return redirect()->back();
        }

        session()->destroy();
        return redirect()->to('/');
    }

    public function unauthorized() {
        return view('errors/unauthorized');
    }

    public function errorVerifyAccount() {
        return view('errors/verify-account');
    }
}