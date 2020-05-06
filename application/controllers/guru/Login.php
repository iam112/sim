<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

    // Load Model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('konfigurasi_model');
    }
    
    public function index()
    {
        $konfigurasi = $this->konfigurasi_model->listing();
        //Validasi 
        $this->form_validation->set_rules('username','Username','required',
                                         array('required' => '%s harus diisi'));
        
        $this->form_validation->set_rules('password','Password','required',
                                         array('required' => '%s harus diisi'));
        
        if($this->form_validation->run())
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            //Proses ke simple login
            $this->simple_login_guru->login($username,$password);
        }
        //Akhir Validasi
        
        $data = array(  'title' => 'Login Guru',
                        'konfigurasi'   =>  $konfigurasi,
                     );
        $this->load->view('guru/login/list',$data,FALSE);
    }
    
    //Fungsi logout
    public function logout()
    {
        // Ambil fungsi logout dari simple login
        $this->simple_login_guru->logout();
    }
}