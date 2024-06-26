<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Europe/Istanbul");
	}
	public function index(){
		$this->load->view('frontend/profile');
	}
	public function profilesaya($id=''){
		$data['profile'] = $this->db->query("SELECT * FROM tbl_musteri WHERE musteriKodu LIKE '".$id."'")->row_array();
		// die(print_r($data));
		$this->load->view('frontend/profile',$data);
	}
	public function editprofile($id=''){
		$id = $this->input->post('kode');
		$where = array('musteriKodu' => $id );
		$update = array(
			'musteriNo'			=> $this->input->post('ktp'),
			'musteriAdi'  => $this->input->post('nama'),
			'musteriEmail'	    	=> $this->input->post('email'),
			'musteriFoto'		=> 'assets/frontend/img/default.png',
			'musteriAdres'		=> $this->input->post('adres'),
			'musteriTelefon'		=> $this->input->post('hp'),
			 );
		$this->db->update('tbl_musteri', $update,$where);
		$this->session->set_flashdata('message', 'swal("Success", "Data Edited", "success");');
		redirect('profile/profilesaya/'.$id);
	}
	public function tiketsaya($id=''){
		$this->getsecurity();
		$data['tiket'] = $this->db->query("SELECT * FROM tbl_rezervasyon WHERE musteriKodu ='".$id."' group by rezervasyonKodu ")->result_array();
		// die(print_r($data));
		$this->load->view('frontend/tiketmu',$data);
	}
	public function changepassword($id=''){
		$this->load->library('form_validation');
		$pelanggan = $this->db->query("SELECT musteriSifre FROM tbl_musteri where musteriKodu ='".$id."'")->row_array();
		// die(print_r($pelanggan));
		$this->form_validation->set_rules('currentpassword', 'currentpassword', 'trim|required|min_length[8]',array(
			'required' => 'Enter Password',
			 ));
		$this->form_validation->set_rules('new_password1', 'new_password1', 'trim|required|min_length[8]|matches[new_password2]',array(
			'required' => 'Enter Password.',
			'matches' => 'Password Not Same.',
			'min_length' => 'Password Minimal 8 Characters.'
			 ));
		$this->form_validation->set_rules('new_password2', 'new_password2', 'trim|required|min_length[8]|matches[new_password1]',array(
			'required' => 'Enter Password.',
			'matches' => 'Password Not Same.',
			'min_length' => 'Password Minimal 8 Characters.'
			 ));
		if ($this->form_validation->run() == false) {
			$this->load->view('frontend/changepassword');
		} else {
			$currentpassword = $this->input->post('currentpassword');
			$newpassword 	 = $this->input->post('new_password1');
			if (!password_verify($currentpassword, $pelanggan['musteriSifre'])) {
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert">
				Previous Password Wrong
					</div>');
				redirect('profile/changepassword');
			}elseif ($currentpassword == $newpassword) {
				$this->session->set_flashdata('gagal', '<div class="alert alert-danger" role="alert">
				Passwords cant be the same before
					</div>');
				redirect('profile/changepassword');
			}else{
				$password_hash = password_hash($newpassword, PASSWORD_DEFAULT);
				$where = array('musteriKodu' => $id );
				$update = array(
				'musteriSifre'			=> $password_hash,
				 );
				$this->db->update('tbl_musteri', $update,$where);
				$this->session->set_flashdata('message', 'swal("Success", "Your password has been changed successfully", "success");');
				redirect('profile/profilesaya/'.$id);
			}
		}

	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username');
		if (empty($username)) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */