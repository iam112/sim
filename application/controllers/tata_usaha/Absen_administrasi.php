<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_administrasi extends CI_Controller {

    // Load Model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('absen_administrasi_model');
        $this->load->model('konfigurasi_model');
        $this->load->model('metodekehadiran_model');
        $this->load->model('konfigurasi_model');
        // Proteksi Halaman
        $this->simple_login_tata_usaha->cek_login();
    }

    // Halaman Absen Administrasi
    public function index()
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        $kode_administrasi = $this->session->userdata('kode_administrasi');
        $tata_usaha = $this->tatausaha_model->listing($kode_administrasi);
        $administrasi = $this->tatausaha_model->administrasi();
        $data = array(  'title'         =>  'Absensi Administrasi',
                        'administrasi'  =>  $administrasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'konfigurasi'   =>  $konfigurasi,
                        'isi'           =>  'tata_usaha/absen_administrasi/list'
                     );
        $this->load->view('tata_usaha/layout/wrapper', $data, false);
    }

    //Tambah Absen
    public function tambah($nip)
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        $kode_administrasi = $this->session->userdata('kode_administrasi');
        $tata_usaha = $this->tatausaha_model->listing($kode_administrasi);

        $absen = $this->absen_administrasi_model->detail_administrasi($nip);
        $metode = $this->metodekehadiran_model->listing();
        //validasi input
        $valid      = $this->form_validation;
        
        $valid->set_rules('nip', 'NIP', 'required',
                    array('required'    =>  "%s Harus diisi"));

        $valid->set_rules('jam', 'Jam', 'required',
                    array('required'    =>  "%s Harus diisi"));

        $valid->set_rules('tanggal', 'Tanggal', 'required',
                    array('required'    =>  "%s Harus diisi"));

        $valid->set_rules('metode', 'Metode', 'required',
                    array('required'    =>  "%s Harus diisi"));

        $valid->set_rules('status_kehadiran', 'Status Kehadiran', 'required',
                    array('required'    =>  "%s Harus diisi"));
        
        if($valid->run()===false){
            //Akhir Validasi
        
        $data = array(  'title'     =>  'Tambah Absen',
                        'absen'   =>  $absen,
                        'konfigurasi'   =>  $konfigurasi,
                        'metode'    =>  $metode,
                        'tata_usaha'    =>  $tata_usaha,
                        'isi'       =>  'tata_usaha/absen_administrasi/tambah'
                     );
        $this->load->view('tata_usaha/layout/wrapper', $data, false);
        //masuk database
        }else{
            $i = $this->input;
            
            $data = array(  'nip'           =>  $nip,
                            'jam'           =>  $i->post('jam'),
                            'tanggal'       =>  $i->post('tanggal'),
                            'metode'           =>  $i->post('metode'),
                            'status_kehadiran'  =>  $i->post('status_kehadiran')
                         );
            $this->absen_administrasi_model->tambah_administrasi($data);
            $this->session->set_flashdata('sukses', 'Data telah ditambah');
            redirect(base_url('tata_usaha/absen_administrasi/riwayat/'.$nip), 'refresh');
        }
        //akhir masuk database
            
        $data = array(  'title'         =>  'Tambah Absen',
                        'absen'         =>  $absen,
                        'metode'        =>  $metode,
                        'konfigurasi'   =>  $konfigurasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'isi'           =>  'tata_usaha/absen_administrasi/tambah'
                     );
        $this->load->view('tata_usaha/layout/wrapper', $data, false);
    }

    //Riwayat Absen
    public function riwayat($nip)
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        $kode_administrasi = $this->session->userdata('kode_administrasi');
        $tata_usaha = $this->tatausaha_model->listing($kode_administrasi);

        $absen = $this->absen_administrasi_model->riwayat_administrasi($nip);
        $data = array(  'title'     =>  'Riwayat Absen',
                        'absen'     =>  $absen,
                        'konfigurasi'   =>  $konfigurasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'isi'       =>  'tata_usaha/absen_administrasi/riwayat'
                     );
        $this->load->view('tata_usaha/layout/wrapper', $data, false);
    }

    // Laporan
    public function laporan()
    {
        $bulan = date("m");
        $tahun = date("Y");	
        $tgl = date_create($tahun.'-'.$bulan.'-01');
        $bulan_txt = date_format($tgl, "F");
        $tgl_akhir = date("t");
        $hasil_arr = array();

        $hasil_absen = $this->absen_administrasi_model->datakehadiran_administrasi($tahun,$bulan);

        $kode_administrasi = $this->session->userdata('kode_administrasi');
        $tata_usaha = $this->tatausaha_model->listing($kode_administrasi);
        $konfigurasi = $this->konfigurasi_model->listing();

        $administrasi = $this->tatausaha_model->administrasi();
        $data = array(  'title'         =>  'Laporan Data Absensi Administrasi',
                        'administrasi'  =>  $administrasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'tgl'           =>  $tgl,
                        'bulan_txt'     =>  $bulan_txt,
                        'hasil_absen'   =>  $hasil_absen,
                        'tahun'         =>  $tahun,
                        'tgl_akhir'     =>  $tgl_akhir,
                        'hasil_arr'     =>  $hasil_arr,
                        'konfigurasi'   =>  $konfigurasi,
                        'isi'           =>  'tata_usaha/absen_administrasi/laporan'
                    );
        $this->load->view('tata_usaha/layout/wrapper', $data, false);
    }

    // Cetak
    public function cetak($nip)
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        $absen = $this->absen_administrasi_model->detail_administrasi($nip);
        $data = array(  'title' =>  'Data Absen Administrasi',
                        'guru'  =>  $guru,
                        'konfigurasi'   =>  $konfigurasi,
                     );
        $this->load->view('tata_usaha/absen_administrasi/cetak', $data, false);
    }

    // Delete Absen administrasi
    public function delete($nip,$jam,$tanggal,$metode)
    {
        $data = array('nip'     => $nip,
                      'jam'     =>  $jam,
                      'tanggal' =>  $tanggal,
                      'metode'  =>  $metode
                     );

        $this->absen_administrasi_model->delete_administrasi($data);
        $this->session->set_flashdata('sukses', 'Data telah dihapus');
        redirect(base_url('tata_usaha/absen_administrasi/riwayat/'.$nip), 'refresh');
    }
}
?>