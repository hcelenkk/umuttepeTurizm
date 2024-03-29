<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		$this->load->library('form_validation');
		$this->getsecurity();
		date_default_timezone_set("Europe/Istanbul");

	}
	function getsecurity($value=''){
		$username = $this->session->userdata('level');
		if ($username == '2') {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
	public function index(){
		$data['title'] = "Admin Section";
		$data['admin'] = $this->db->query("SELECT * FROM tbl_admin")->result_array();
		$this->load->view('backend/admin', $data);
	}
	public function daftar(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('kullaniciAdi', 'kullaniciAdi', 'trim|required|min_length[5]|is_unique[tbl_admin.adminKullaniciAdi]',array(
			'required' => 'Email Gerekli.',
			'is_unique' => 'Kullanıcı adı zaten kullanılıyor'
			 ));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',array(
			'required' => 'Email Gerekli.',
			 ));
		$this->form_validation->set_rules('sifre', 'Şifre', 'trim|required|min_length[4]|matches[password2]',array(
			'matches' => 'Şifreler Farklı.',
			'min_length' => 'Şifreniz en az 8 karakter içermelidir.'
			 ));
		$this->form_validation->set_rules('password2', 'Şifre2', 'trim|required|matches[password]');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Admin Ekle";
			$this->load->view('backend/daftar',$data);
		} else {
			$kode = $this->getkod_model->get_kodadm();
			$data = array(
				'adminKodu' => $kode,
				'adminAdi' => $this->input->post('name'),
				'adminEmail'		 => $this->input->post('email'),
				'adminFoto'		=> 'assets/backend/img/default.png',
				'adminKullaniciAdi' => strtolower($this->input->post('username')),
				'adminSifre' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
				'adminSeviye'	=> 2,
				'adminDurum' => 1,
				'adminOlusturmaTarihi' => time()
				 );
			$this->db->insert('tbl_admin', $data);
			$this->session->set_flashdata('message', 'swal("Başarılı", "Hesap Başarıyla Eklendi", "success");');
    		redirect('backend/admin');
		}

	}
}