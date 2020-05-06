<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    // Load Model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model');
        $this->load->model('tatausaha_model');
        $this->load->model('konfigurasi_model');
        // Proteksi Halaman
        $this->simple_login_tata_usaha->cek_login();
    }

    // Profile
    public function index()
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        $kode_administrasi = $this->session->userdata('kode_administrasi');
        $tata_usaha = $this->tatausaha_model->listing($kode_administrasi);

        $profile = $this->profile_model->administrasi($kode_administrasi);

        //validasi input
        $valid      = $this->form_validation;
        
        $valid->set_rules('nama', 'Nama Administrasi', 'required',
                    array('required'    =>  "%s Harus diisi"));
        
        if($valid->run()){
            //Cek jika gambar diganti
            if(!empty($_FILES['foto']['name'])){
                
            $config['upload_path']      = './assets/upload/image/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['max_size']         = '2400';//Dalam KB
            $config['max_width']        = '2024';
            $config['max_height']       = '2024';
            
            $this->load->library('upload',$config);
            
            if(!$this->upload->do_upload('foto')){
            //Akhir Validasi
        
        $data = array(  'title'       => 'Profile',
                        'profile'       => $profile,
                        'konfigurasi'   =>  $konfigurasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'error'       => $this->upload->display_errors(),
                        'isi'         => 'tata_usaha/profile/list'  );
        $this->load->view('tata_usaha/layout/wrapper',$data,FALSE);
        //masuk database
        }else{
            $upload_gambar = array('upload_data' => $this->upload->data());
                
            //Buat thumbnail gambar
            $config['image_library']    = 'gd2';
            $config['source_image']     = './assets/upload/image/'.$upload_gambar['upload_data']['file_name'];
            //lokasi folder thumbnail
            $config['new_image']        = './assets/upload/image/thumbs/';
            $config['create_thumb']     = TRUE;
            $config['maintain_ratio']   = TRUE;
            $config['width']            = 350;//Dalam Pixel
            $config['height']           = 350;//Dalam Pixel
            $config['thumb_marker']     = '';

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();
            //Akhir buat thumbnail
            
            $i = $this->input;

            $data = array(  //Disimpan nama file gambar
                            'foto'                  =>  $upload_gambar['upload_data']['file_name'],
                            'kode_administrasi'     =>  $profile->kode_administrasi,
                            'nama_administrasi'     =>  $i->post('nama'),
                            'nip'                   =>  $i->post('nip'),
                            'password'              =>  $i->post('password'),
                            'kelamin'               =>  $i->post('kelamin'),
                            'agama'                 =>  $i->post('agama'),
                            'tempat_lahir'          =>  $i->post('tempat_lahir'),
                            'tanggal_lahir'         =>  $i->post('tanggal_lahir'),
                            'alamat'                =>  $i->post('alamat'),
                         );
            $this->profile_model->edit_administrasi($data);
            $this->session->set_flashdata('sukses','Data telah diupdate');
            redirect(base_url('tata_usaha/profile'),'refresh');
            
        }}else{
            //Edit guru tanpa ganti gambar
            $i = $this->input;

            $data = array(  //Disimpan nama file gambar
                            //'foto'                  =>  $upload_gambar['upload_data']['file_name'],
                            'kode_administrasi'     =>  $profile->kode_administrasi,
                            'nama_administrasi'     =>  $i->post('nama'),
                            'nip'                   =>  $i->post('nip'),
                            'password'              =>  $i->post('password'),
                            'kelamin'               =>  $i->post('kelamin'),
                            'agama'                 =>  $i->post('agama'),
                            'tempat_lahir'          =>  $i->post('tempat_lahir'),
                            'tanggal_lahir'         =>  $i->post('tanggal_lahir'),
                            'alamat'                =>  $i->post('alamat'),
                         );
            $this->profile_model->edit_administrasi($data);
            $this->session->set_flashdata('sukses','Data telah diupdate');
            redirect(base_url('tata_usaha/profile'),'refresh');
        }}
        //akhir masuk database
        $data = array(  'title'       => 'Profile',
                        'profile'     => $profile,
                        'konfigurasi'   =>  $konfigurasi,
                        'tata_usaha'    =>  $tata_usaha,
                        'isi'         => 'tata_usaha/profile/list'  );
        $this->load->view('tata_usaha/layout/wrapper',$data,FALSE);
    }

}
?>