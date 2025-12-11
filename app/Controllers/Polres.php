<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users;
use App\Models\Role;
use App\Models\Satfung;
use App\Models\Anggota;
use App\Models\Mental;
use App\Models\Rohani;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Polres extends BaseController
{
    protected $TUser;
    protected $TSatfung;
    protected $TRole;
    protected $TAnggota;
    protected $TMental;
    protected $TRohani;
    protected $spreedSheet;
    protected $writer;


    public function __construct()
    {
        $this->TUser = new Users();
        $this->TSatfung = new Satfung();
        $this->TRole = new Role();
        $this->TAnggota = new Anggota();
        $this->TMental = new Mental;
        $this->TRohani = new Rohani;
        $this->spreedSheet = new Spreadsheet();
        $this->writer = IOFactory::createWriter($this->spreedSheet, 'Xlsx');
    }

    public function index()
    {
        $data = [
            'title' => 'dashboard polres',
            'totalAnggota' => $this->TAnggota->countAll(),
            'totalUser' => $this->TUser->countAll(),
        ];

        return view('polres/dashboard', $data);
    }

    public function dataAnggota()
    {
        $satfungParams = $this->request->getGet('satfung');
        $searchParams = $this->request->getGet('search');

        $satfung = [];
        $search = [];

        if ($satfungParams) {
            $satfung = ['anggotas.satfung_id' => $satfungParams];
        }
        if ($searchParams) {
            $search = ['anggotas.name' => $searchParams];
        }

        $data = [
            'title' => 'data seluruh anggota',
            'satfungs' => $this->TSatfung->findAll(),
            'anggotas' => $this->TAnggota->select('anggotas.*, pangkats.name as pangkat_name, satfungs.name as satfung_name')
            ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
            ->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')
            ->where($satfung)
            ->like($search)
            ->paginate(10),
            'pager' => $this->TAnggota->pager,
        ];

        return view('polres/data_anggota', $data);
    }

    public function gantiPassword()
    {
        $data = [
            'title' => 'ganti password polres',
        ];

        return view('polres/ganti_password', $data);
    }

    public function editNilai($anggota_id)
    {
        $tahunParams = $this->request->getGet('tahun');
        $semesterParams = $this->request->getGet('semester');
        $mapelParams = $this->request->getGet('mapel');

        $tahun = [];
        $semester = [];

        if ($tahunParams) {
            $tahun = ['tahun' => $tahunParams];
        }

        if ($semesterParams) {
            $semester = ['semester' => $semesterParams];
        }


        $anggota = $this->TAnggota->select('anggotas.*, satfungs.name as satfung_name, pangkats.name as pangkat_name')->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')->where('anggota_id', $anggota_id)->first();
        $data = [];
        
        if ($mapelParams === 'mental') {
            $nilai = $this->TMental->where('anggota_id', $anggota_id)->where($tahun)->where($semester)->findAll();
            $data = [
                'title' => 'edit nilai anggota',
                'anggota' => $anggota,
                'mapel' => 'mental',
                'tahun'=> $tahunParams,
                'semester'=> $semesterParams,
                'nilai' => $nilai
            ];
        } else if ($mapelParams === 'rohani') {
            $nilai = $this->TRohani->where('anggota_id', $anggota_id)->where($tahun)->where($semester)->findAll();
            $data = [
                'title' => 'edit nilai anggota',
                'anggota' => $anggota,
                'mapel' => 'rohani',
                'tahun'=> $tahunParams,
                'semester'=> $semesterParams,
                'nilai' => $nilai
            ];
        }

        return view('polres/edit_nilai', $data);
    }

    public function filterNilai($anggota_id)
    {
        // years array
        $years = [];
        $yearNow = date('Y');
        $startYear = 2000;
        for ($i = $startYear; $i <= $yearNow; $i++) {
            $years[] = $i;
        }

        $anggota = $this->TAnggota->where('anggota_id', $anggota_id)->first();

        $data = [
            'title' => 'filter nilai anggota',
            'anggota_id' => $anggota_id,
            'years' => $years,
            'name' => $anggota['name'],
        ];

        return view('polres/filter_cek_nilai', $data);
    }

    public function kelolaAkun()
    {
        $data = [
            'title' => 'data user akun',
            'users' => $this->TUser->select('users.*, roles.name as role, satfungs.name as satfung')->join('satfungs', 'satfungs.satfung_id = users.satfung_id')->join('roles', 'roles.role_id = users.role_id')->where('users.user_id !=', user('uid'))->findAll(),
            'role' => $this->TRole->findAll(),
            'satfung' => $this->TSatfung->findAll(),
        ];

        return view('polres/kelola_akun', $data);
    }

    public function filterLaporan() {

        // years array
        $years = [];
        $yearNow = date('Y');
        $startYear = 2000;
        for ($i = $startYear; $i <= $yearNow; $i++) {
            $years[] = $i;
        }

        $data = [
            'title' => 'filter rekap nilai',
            'years' => $years,
            'satfung' => $this->TSatfung->findAll(),
        ];

        return view('polres/filter_laporan', $data);
    }


    public function viewLaporan() {
        $data = [
            'tahun' => $this->request->getVar('tahun'),
            'semester' => $this->request->getVar('semester'),
            'satfung' => $this->request->getVar('satfung'),
            'mapel' => $this->request->getVar('mapel'),
        ];

        if ($data['mapel'] === null || $data['mapel'] === "") {
            session()->setFlashdata('error_filter', 'Pilih nilai terlebih dahulu');
            return redirect()->to('/polres/filter-laporan');
        }

        $tahun = [];
        $semester = [];
        $satfung = [];

      
        if ($data['tahun']) {
            $tahun = ['tahun' => $data['tahun']];
        }

        if ($data['semester']) {
            $semester = ['semester' => $data['semester']];
        }

        if ($data['satfung']) {
            $satfung = ['anggotas.satfung_id' => $data['satfung']];
        }

        $satfungDB = $this->TSatfung->where('satfung_id', $data['satfung'])->first();
        $satfungName = !empty($satfungDB) ? $satfungDB['name'] : null;

        if ($data['mapel'] === 'mental') {
            $mental = $this->TMental->select('mentals.*, anggotas.name as anggota_name, anggotas.satfung_id, anggotas.jabatan, pangkats.name as pangkat_name, satfungs.name as satfung_name')
            ->join('anggotas', 'anggotas.anggota_id = mentals.anggota_id')
            ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
            ->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')->where($tahun)->where($semester)->where($satfung)->orderBy('anggotas.name')->findAll();
            
            
            $dataRekap = [
                'title' => 'rekap nilai e-mental',
                'tahun' => $data['tahun'],
                'semester' => $data['semester'],
                'satfung' => $data['satfung'],
                'satfungName' => $satfungName,
                'mapel' => $data['mapel'],
                'rekap' => $mental,
            ];

            return view('polres/view_laporan', $dataRekap);
        } else if ($data['mapel'] === 'rohani') {
            $rohani = $this->TRohani->select('rohanis.*, anggotas.name as anggota_name, anggotas.satfung_id, anggotas.jabatan, pangkats.name as pangkat_name, satfungs.name as satfung_name')
            ->join('anggotas', 'anggotas.anggota_id = rohanis.anggota_id')
            ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
            ->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')->where($tahun)->where($semester)->where($satfung)->orderBy('anggotas.name')->findAll();

            $dataRekap = [
                'title' => 'rekap nilai e-rohani',
                'tahun' => $data['tahun'],
                'semester' => $data['semester'],
                'satfung' => $data['satfung'],
                'satfungName' => $satfungName,
                'mapel' => $data['mapel'],
                'rekap' => $rohani,
            ];

            return view('polres/view_laporan', $dataRekap);
        }

        
    }

    public function exportLaporan() {
        $data = [
            'tahun' => $this->request->getVar('tahun'),
            'semester' => $this->request->getVar('semester'),
            'satfung' => $this->request->getVar('satfung'),
            'mapel' => $this->request->getVar('mapel'),
        ];

        
        if ($data['mapel'] === null || $data['mapel'] === "") {
            session()->setFlashdata('error_filter', 'Pilih nilai terlebih dahulu');
            return redirect()->to('/polres/filter-laporan');
        }


        $tahun = [];
        $semester = [];
        $satfung = [];

      
        if ($data['tahun']) {
            $tahun = ['tahun' => $data['tahun']];
        }

        if ($data['semester']) {
            $semester = ['semester' => $data['semester']];
        }

        if ($data['satfung']) {
            $satfung = ['anggotas.satfung_id' => $data['satfung']];
        }

        $result = [];

        if ($data['mapel'] === 'mental') {
            $result = $this->TMental->select('mentals.*, anggotas.name as anggota_name, anggotas.satfung_id, anggotas.jabatan, pangkats.name as pangkat_name, satfungs.name as satfung_name')
            ->join('anggotas', 'anggotas.anggota_id = mentals.anggota_id')
            ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
            ->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')->where($tahun)->where($semester)->where($satfung)->orderBy('anggotas.name')->findAll();
            
        } else if ($data['mapel'] === 'rohani') {
            $result = $this->TRohani->select('rohanis.*, anggotas.name as anggota_name, anggotas.satfung_id, anggotas.jabatan, pangkats.name as pangkat_name, satfungs.name as satfung_name')
            ->join('anggotas', 'anggotas.anggota_id = rohanis.anggota_id')
            ->join('pangkats', 'pangkats.pangkat_id = anggotas.pangkat_id')
            ->join('satfungs', 'satfungs.satfung_id = anggotas.satfung_id')->where($tahun)->where($semester)->where($satfung)->orderBy('anggotas.name')->findAll();
        }

        $this->spreedSheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nama Anggota')  
        ->setCellValue('B1', 'Pangkat')  
        ->setCellValue('C1', 'Jabatan')  
        ->setCellValue('D1', 'satfung')  
        ->setCellValue('E1', 'Semester')  
        ->setCellValue('F1', 'Nilai')
        ->getStyle('A1:F1')->getFont()->setBold(true);
        
        
        $column = 2;

        foreach ($result as $key => $value) {
            $this->spreedSheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, $value['anggota_name'])
            ->setCellValue('B' . $column, $value['pangkat_name'])
            ->setCellValue('C' . $column, $value['jabatan'])
            ->setCellValue('D' . $column, $value['satfung_name'])
            ->setCellValue('E' . $column, $value['semester'])
            ->setCellValue('F' . $column, $value['nilai']);
            $column++;
        }
        
        $filename = 'Rekap Nilai-' . 'e-' . $data['mapel'] . '-' . $data['tahun'] . '-' . $data['semester'] . '-' . date('Y-m-d');
        
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        
        $this->writer->save('php://output');
        exit();

    }
   
}