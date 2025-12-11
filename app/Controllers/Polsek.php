<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users;
use App\Models\Role;
use App\Models\Satfung;
use App\Models\Anggota;
use App\Models\Pangkat;
use App\Models\Mental;
use App\Models\Rohani;

class Polsek extends BaseController
{
    protected $TUser;
    protected $TSatfung;
    protected $TRole;
    protected $TAnggota;
    protected $TPangkat;
    protected $TMental;
    protected $TRohani;

    public function __construct()
    {
        $this->TUser = new Users();
        $this->TSatfung = new Satfung();
        $this->TRole = new Role();
        $this->TAnggota = new Anggota();
        $this->TPangkat = new Pangkat();
        $this->TMental = new Mental();
        $this->TRohani = new Rohani();
    }

    public function index()
    {
        $data = [
            'anggotas' => $this->TAnggota->where('satfung_id', user('satfung_id'))->countAllResults(),
            'title' => 'dashboard polsek',
        ];

        return view('polsek/dashboard', $data);
    }

    public function dataAnggota()
    {
        $pangkatParams = $this->request->getGet('pangkat');
        $searcParams = $this->request->getGet('search');
        $pangkat = [];
        $search = [];

        if ($pangkatParams) {
            $pangkat = ['anggotas.pangkat_id' => $pangkatParams];
        }

        if ($searcParams) {
            $search = ['anggotas.name' => $searcParams];
        }


        $anggota = $this->TAnggota->select('anggotas.*, pangkats.name as pangkat_name')
        ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
        ->where('satfung_id', user('satfung_id'))->where($pangkat)->like($search)->findAll();

        $data = [
            'title' => 'data seluruh anggota',
            'pangkat' => $this->TPangkat->findAll(),
            'anggota' => $anggota
        ];

        return view('polsek/data_anggota', $data);
    }

    public function gantiPassword()
    {
        $data = [
            'title' => 'ganti password polsek',
        ];

        return view('polsek/ganti_password', $data);
    }


    
    // public function filterNilai($anggota_id)
    // {
    //     $data = [
    //         'title' => 'filter nilai anggota',
    //         'anggota_id' => $anggota_id
    //     ];

    //     return view('polsek/filter_cek_nilai', $data);
    // }

    public function addAnggota() {
        helper('form');
        if (!$this->validate([
            'nrp' => [
                'rules' => 'required|max_length[14]|is_unique[anggotas.nrp]',
                'errors' => [
                    'required' => 'NRP harus diisi',
                    'max_length' => 'NRP maksimal 14 karakter',
                    'is_unique' => 'NRP sudah terdaftar'
                ]
            ],
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama harus diisi',
                    'max_length' => 'Nama panjang maksimal 100 karakter',
                ]
            ],
            'jabatan' => [
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => 'Jabatan harus diisi',
                    'min_length' => 'Jabatan minimal 2 karakter',
                ]
            ],
            'pangkat_id' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Pangkat harus diisi',
                    'is_natural_no_zero' => 'Pangkat tidak boleh kosong',
                ]
            ],
        ])) {
            $msg_error = $this->validator->listErrors();
            session()->setFlashdata('error_tambah_anggota', $msg_error);
            return redirect()->back()->withInput();
        }

        $data = [
            'nrp' => $this->request->getVar('nrp'),
            'name' => $this->request->getVar('name'),
            'jabatan' => $this->request->getVar('jabatan'),
            'pangkat_id' => $this->request->getVar('pangkat_id'),
            'satfung_id' => user('satfung_id'),
        ];

        if (!$this->TAnggota->save($data)) {
            session()->setFlashdata('error_tambah_anggota', 'Gagal menambahkan anggota');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success_tambah_anggota', 'success menambahkan anggota '. $data['name']);
        return redirect()->back()->withInput(); 
    }

    public function editViewAnggota($anggota_id) {
        // get data anggota
        $anggota = $this->TAnggota->where("anggota_id", $anggota_id)->first();

        if (!$anggota || $anggota['satfung_id'] != user('satfung_id')) {
            return redirect()->back();
        }

        $data = [
            'title' => 'edit anggota',
            'anggota' => $anggota,
            'pangkat' => $this->TPangkat->findAll()
        ];

        return view('polsek/edit_anggota', $data);
    }

    public function updateAnggota($anggota_id) {
        helper('form');
        if (!$this->validate([
            'nrp' => [
                'rules' => 'required|max_length[14]',
                'errors' => [
                    'required' => 'NRP harus diisi',
                    'max_length' => 'NRP maksimal 14 karakter',
                ]
            ],
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama harus diisi',
                    'max_length' => 'Nama panjang maksimal 100 karakter',
                ]
            ],
            'jabatan' => [
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => 'Jabatan harus diisi',
                    'min_length' => 'Jabatan minimal 2 karakter',
                ]
            ],
            'pangkat_id' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Pangkat harus diisi',
                    'is_natural_no_zero' => 'Pangkat tidak boleh kosong',
                ]
            ],
        ])) {
            $msg_error = $this->validator->listErrors();
            session()->setFlashdata('error_edit_anggota', $msg_error);
            return redirect()->back()->withInput();
        }

        $data = [
            'nrp' => $this->request->getVar('nrp'),
            'name' => $this->request->getVar('name'),
            'jabatan' => $this->request->getVar('jabatan'),
            'pangkat_id' => $this->request->getVar('pangkat_id'),
        ];

        if (!$this->TAnggota->update($anggota_id, $data)) {
            session()->setFlashdata('error_edit_anggota', 'Gagal mengupdate anggota');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success_edit_anggota', 'success mengupdate anggota '. $data['name']);
        return redirect()->back();
    }

    public function deleteAnggota($anggota_id) {

        $anggota = $this->TAnggota->where('anggota_id', $anggota_id)->first();

        if (!$anggota) {
            session()->setFlashdata('error_delete_anggota', 'Gagal menghapus anggota, anggota tidak ada/ tidak terdaftar');
            return redirect()->back();
        }

        if ($anggota['satfung_id'] != user('satfung_id')) {
            session()->setFlashdata('error_delete_anggota', 'Gagal menghapus anggota, anggota tidak terdaftar di sketor anda');
            return redirect()->back();
        }

        // delete nilai anggota
        if ($this->TMental->where('anggota_id', $anggota_id)->countAllResults() > 0 || $this->TRohani->where('anggota_id', $anggota_id)->countAllResults() > 0)
        {
            if (!$this->TMental->where('anggota_id', $anggota_id)->delete() || !$this->TRohani->where('anggota_id', $anggota_id)->delete()) {
                session()->setFlashdata('error_delete_anggota', 'Gagal menghapus nilai anggota');
                return redirect()->back();
            }
        }

        if (!$this->TAnggota->delete($anggota_id)) {
            session()->setFlashdata('error_delete_anggota', 'Gagal menghapus anggota');
            return redirect()->back();
        }

        session()->setFlashdata('success_delete_anggota', 'success menghapus anggota ');
        return redirect()->back();
    }

    public function cekNilai($anggota_id)
    {
        $semesterParams = $this->request->getGet("semester");
        $semester = [];

        if ($semesterParams) {
            $semester = ['semester' => $semesterParams];
        }


        $anggota = $this->TAnggota->select('anggotas.*, pangkats.name as pangkat_name')->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')->where('anggota_id', $anggota_id)->first();
        $mental = $this->TMental->where('anggota_id', $anggota_id)->where($semester)->findAll();
        $rohani = $this->TRohani->where('anggota_id', $anggota_id)->where($semester)->findAll();

        if (!$anggota || $anggota['satfung_id'] != user('satfung_id')) {
            return redirect()->back();
        }

        // years array
        $years = [];
        $yearNow = date('Y');
        $startYear = 2000;
        for ($i = $startYear; $i <= $yearNow; $i++) {
            $years[] = $i;
        }

        $data = [
            'title' => 'tambah nilai anggota',
            'anggota' => $anggota,
            'mental' => $mental,
            'rohani' => $rohani,
            'years' => $years
        ];

        return view('polsek/tambah_nilai', $data);
    }

    public function addNilai($mapel) {
        if ($mapel == null || $mapel == "") {
           return redirect()->back();
        }

        // validation
        if (!$this->validate([
         'tahun' => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'Tahun harus diisi',
                'is_natural_no_zero' => 'Tahun tidak boleh kosong',
            ]
         ],
         'semester' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Semester harus diisi',
            ]
         ],
         'nilai' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nilai harus diisi',
            ]
         ],
         'bukti' => [
            'rules' => 'uploaded[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,4096]',
            'errors' => [
                'uploaded' => 'Bukti harus diisi',
                'mime_in' => 'Bukti harus berupa gambar',
                'max_size' => 'Bukti maksimal 4MB',
            ]
         ],
        ])) {
            $msg_error = $this->validator->listErrors();
            session()->setFlashdata('error_tambah_nilai', $msg_error);
            return redirect()->back()->withInput();
        }

        $bukti = $this->request->getFile('bukti');

        $data = [
            'anggota_id' => $this->request->getVar('anggota_id'),
            'tahun' => $this->request->getVar('tahun'),
            'semester' => $this->request->getVar('semester'),
            'nilai' => $this->request->getVar('nilai'),
            'bukti' => $bukti->getName(),
        ];
        
        if ($mapel === 'mental') {
            if (!$this->TMental->save($data)) {
                session()->setFlashdata('error_tambah_nilai', 'gagal menyimpan nilai e-mental');
                return redirect()->back();
            }

            // save file
            if ($bukti->isValid() && !$bukti->hasMoved()) {
                $bukti->move('resource/bukti_nilai');
            }

            session()->setFlashdata('success_tambah_nilai', 'success menyimpan nilai e-mental tahun '. $data['tahun']);
            return redirect()->back();
        } else if($mapel === 'rohani') {
            if (!$this->TRohani->save($data)) {
                session()->setFlashdata('error_tambah_nilai', 'gagal menyimpan nilai e-rohani');
                return redirect()->back();
            }

             // save file
            if ($bukti->isValid() && !$bukti->hasMoved()) {
                $bukti->move('resource/bukti_nilai');
            }
            
            session()->setFlashdata('success_tambah_nilai', 'success menyimpan nilai e-rohani tahun '. $data['tahun']);
            return redirect()->back();
        } else {
            session()->setFlashdata('error_tambah_nilai', 'tidak ada fitur ini ' . $mapel);
            return redirect()->back();
        }
    }

    public function deleteNilai($nilai_id) {
        $mapel = $this->request->getGet('mapel');

        if ($mapel == null || $mapel == "") {
            return redirect()->back();
        }

        if ($mapel === 'mental') {
            $nilaiExist = $this->TMental->where('mental_id', $nilai_id)->first();
            if (!$nilaiExist) {
                session()->setFlashdata('error_delete_nilai', 'nilai tidak ada');
                return redirect()->back();
            }

            if (!$this->TMental->delete($nilai_id)) {
                session()->setFlashdata('error_delete_nilai', 'gagal menghapus nilai');
                return redirect()->back();
            }

            // unlink file
            $path = 'resource/bukti_nilai/' . $nilaiExist['bukti'];
            if (file_exists($path)) {
                unlink($path);
            }

            session()->setFlashdata('success_delete_nilai', 'success menghapus nilai');
            return redirect()->back();
        } else if ($mapel === 'rohani') {
            $nilaiExist = $this->TRohani->where('rohani_id', $nilai_id)->first();
            if (!$nilaiExist) {
                session()->setFlashdata('error_delete_nilai', 'nilai tidak ada');
                return redirect()->back();
            }

            if (!$this->TRohani->delete($nilai_id)) {
                session()->setFlashdata('error_delete_nilai', 'gagal menghapus nilai');
                return redirect()->back();
            }

            // unlink file
            $path = 'resource/bukti_nilai/' . $nilaiExist['bukti'];
            if (file_exists($path)) {
                unlink($path);
            }

            session()->setFlashdata('success_delete_nilai', 'success menghapus nilai');
            return redirect()->back();
        } else {
            session()->setFlashdata('error_delete_nilai', 'tidak ada fitur ini ' . $mapel);
            return redirect()->back();
        }
    }

    public function editViewNilai($nilai_id) {
        $mapel = $this->request->getGet('mapel');

        if ($mapel == null || $mapel == "") {
            return redirect()->back();
        }

        if ($mapel === 'mental') {
            $nilai = $this->TMental->where('mental_id', $nilai_id)->first();
            if (!$nilai) {
                session()->setFlashdata('error_edit_nilai', 'nilai tidak ada');
                return redirect()->back();
            }
        } else if ($mapel === 'rohani') {
            $nilai = $this->TRohani->where('rohani_id', $nilai_id)->first();
            if (!$nilai) {
                session()->setFlashdata('error_edit_nilai', 'nilai tidak ada');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error_edit_nilai', 'tidak ada fitur ini ' . $mapel);
            return redirect()->back();
        }

        $data = [
            'title' => 'edit nilai',
            'nilai' => $nilai,
            'mapel' => $mapel
        ];

        return view('polsek/edit_nilai', $data);
    }

    public function editNilai($nilai_id) {
        $mapel = $this->request->getGet('mapel');

        $data = [
            'nilai' => $this->request->getVar('nilai'),
        ];

        if ($data['nilai'] == null || $data['nilai'] == "") {
            session()->setFlashdata('error_edit_nilai', 'nilai harus diisi');
            return redirect()->back();
        }

        if ($mapel == null || $mapel == "") {
            return redirect()->back();
        }

        if ($mapel === 'mental') {
            $nilai = $this->TMental->where('mental_id', $nilai_id)->first();
            if (!$nilai) {
                session()->setFlashdata('error_edit_nilai', 'nilai tidak ada');
                return redirect()->back();
            }

            if (!$this->TMental->update($nilai_id, $data)) {
                session()->setFlashdata('error_edit_nilai', 'gagal mengupdate nilai');
                return redirect()->back();
            }

            session()->setFlashdata('success_edit_nilai', 'success mengupdate nilai');
            return redirect()->to('/polsek/cek-nilai/' . $nilai['anggota_id']);
        } else if ($mapel === 'rohani') {
            $nilai = $this->TRohani->where('rohani_id', $nilai_id)->first();
            if (!$nilai) {
                session()->setFlashdata('error_edit_nilai', 'nilai tidak ada');
                return redirect()->back();
            }

            if (!$this->TRohani->update($nilai_id, $data)) {
                session()->setFlashdata('error_edit_nilai', 'gagal mengupdate nilai');
                return redirect()->back();
            }

            session()->setFlashdata('success_edit_nilai', 'success mengupdate nilai');
            return redirect()->to('/polsek/cek-nilai/' . $nilai['anggota_id']);
        } else {
            session()->setFlashdata('error_edit_nilai', 'tidak ada fitur ini ' . $mapel);
            return redirect()->back();
        }
    }

}