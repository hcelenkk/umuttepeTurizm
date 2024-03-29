<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index(){
		$this->autlogin();
	}

	public function autlogin(){
		$this->load->view('frontend/login');
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
	
	public function cekuser(){
		$username = strtolower($this->input->post('username'));
		$password = $this->input->post('password');
		$sqlCheck = $this->db->query('select * from tbl_musteri where musteriKullaniciAdi = "'.$username.'" OR musteriEmail = "'.$username.'" ')->row();
		// die(print_r($sqlCheck));
		if ($sqlCheck) {
			if ($sqlCheck->musteriDurum == 1) { 
				if (password_verify($password,$sqlCheck->musteriSifre)) {
						$sess = [
							'musteriKodu' => $sqlCheck->musteriKodu,
							'kullaniciAdi' => $sqlCheck->musteriKullaniciAdi,
							'sifre' => $sqlCheck->musteriSifre,
							'ktp'     => $sqlCheck->musteriNo,
							musteriAdi     => $sqlCheck->musteriAdi,
							'musteriFoto'	=> $sqlCheck->musteriFoto,
							'email'   => $sqlCheck->musteriEmail,
							'telefon'   => $sqlCheck->musteriTelefon,
							'adres'	=> $sqlCheck->musteriAdres
						];
						$this->session->set_userdata($sess);
						if ($this->session->userdata('jadwal') == NULL) {
							redirect('tiket');
						}else{
							redirect('tiket/beforebeli/'.$this->session->userdata('jadwal').'/'.$this->session->userdata('asal').'/'.$this->session->userdata('tanggal'));
						}
					}else{
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
					Wrong Password
					</div>');
					redirect('login');
				}
			}else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
				Account Not verified yet!!
					</div>');
				redirect('login');
			}
		}else{
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
			Kullanıcı bulunamadı. Lütfen tekrar deneyin!
					</div>');
			redirect('login');
		}
	}

	public function daftar(){
		$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|is_unique[tbl_musteri.musteriTelefon]',array(
			'required' => 'Telefon numarası gerekli.',
			'is_unique' => 'Bu numara zaten kullanılmakta.'
			 ));
		$this->form_validation->set_rules('name', 'Name', 'trim|required',array(
			'required' => 'İsim Gerekli.',
			 ));
		$this->form_validation->set_rules('adres', 'adres', 'trim|required');
		$this->form_validation->set_rules('kullaniciAdi', 'kullaniciAdi', 'trim|required|min_length[5]|is_unique[tbl_musteri.musteriKullaniciAdi]',array(
			'required' => 'Kullanıcı Adı Gerekli.',
			'is_unique' => 'Kullanıcı Adı zaten kullanılmakta.'
			 ));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tbl_musteri.musteriEmail]',array(
			'required' => 'Email Gerekli.',
			'valid_email' => 'Email Giriniz',
			'is_unique' => 'Email adresi zaten kullanılmakta.'
			 ));
		$this->form_validation->set_rules('password1', 'sifre', 'trim|required|min_length[8]|matches[password2]',array(
			'matches' => 'Şifreler farklı.',
			'min_length' => 'Şifre Minimum 8 Karakter Olmalı.'
			 ));
		$this->form_validation->set_rules('password2', 'sifre', 'trim|required|matches[password1]');
		if ($this->form_validation->run() == false) {
			$this->load->view('frontend/daftar');
		} else {
			// die(print_r($_POST));
			$this->load->model('getkod_model');
			$data = array(
			'musteriKodu'	=> $this->getkod_model->get_kodpel(),
			'musteriAdi'  => $this->input->post('name'),
			'musteriEmail'	    	=> $this->input->post('email'),
			'musteriFoto'		=> 'assets/frontend/img/default.png',
			'musteriAdres'		=> $this->input->post('adres'),
			'musteriTelefon'		=> $this->input->post('nomor'),
			'musteriKullaniciAdi'		=> $this->input->post('username'),
			'musteriDurum' => 1,
			'musteriOlusturmaTarihi' => time(),
			'musteriSifre'		=> password_hash($this->input->post('password1'),PASSWORD_DEFAULT)
			);
			$token = md5($this->input->post('email').date("d-m-Y H:i:s"));
			$data1 = array(
				'tokenAdi' => $token,
				'tokenEmail' => $this->input->post('email'),
				'tokenOlusturmaTarihi' => time()
				 );
			$this->db->insert('tbl_musteri', $data);
			$this->db->insert('tbl_musteriToken', $data1);
			$this->_sendmail($token,'verify');
			$this->session->set_flashdata('message', 'swal("Başarılı", "Başarıyla Kaydedildi. Umuttepe Turizm\'e hoş geldiniz!", "success");');
    		redirect('login');
		}

	}
	Private function _sendmail($token='',$type=''){
		$config = [
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'demo@email.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'P@$$\/\/0RD',      // Password gmail kamu
               'smtp_port' => 465,
               'crlf'      => "rn",
               'newline'   => "rn"
           ];
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('Umuttepe Turizm');
        $this->email->to($this->input->post('email'));
        // $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');
        if ($type == 'verify') {
        	$this->email->subject('Hesap doğrulama');
       		$this->email->message('Hesabınızı doğrulamak için bağlantıya tıklayın <a href="'.base_url('login/verify?email='.$this->input->post('email').'&token='.$token).'" >Verification</a>');
        }elseif ($type == 'forgot') {
        	$this->email->subject('Umuttepe Turizm Bilet Hesabı Sıfırlama');
       		$this->email->message('Hesabınızı sıfırlamak için bağlantıya tıklayın <a href="'.base_url('login/forgot?email='.$this->input->post('email').'&token='.$token).'" >Reset Password</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo 'Hata! e-posta gönderilemiyor.';
        }
	}
	
	public function verify($value=''){
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$sqlcek = $this->db->get_where('tbl_musteri',['musteriEmail' => $email])->row_array();
		if ($sqlcek) {
			$sqlcek_token = $this->db->get_where('tbl_musteriToken',['tokenAdi' => $token])->row_array();
			if ($sqlcek_token) {
				if(time() - $sqlcek_token['tokenOlusturmaTarihi'] < (60 * 60 * 24)){
					$update = array('musteriDurum' => 1, );
					$where = array('musteriEmail' => $email );
					$this->db->update('tbl_musteri', $update,$where);
					$this->db->delete('tbl_musteriToken',['tokenEmail' => $email]);
					$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
					Successfully Verify Your Account, Login
					</div>');
					redirect('login');
				}else{
					$this->db->delete('tbl_musteri',['musteriEmail' => $email]);
					$this->db->delete('tbl_musteriToken',['tokenEmail' => $email]);
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
					Token Expired, Please re-register your account
						</div>');
	    			redirect('login');
				}
			}else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
				Incorrect Token Verification Failed
						</div>');
	    		redirect('login');
			}
		}else{
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
		Email Verification Failed
						</div>');
	    redirect('login');
		}
	}
	
	public function lupapassword($value=''){
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',array(
			'required' => 'Email Required.',
			'valid_email' => 'Enter Email Correctly',
			 ));
		if ($this->form_validation->run() == false) {
			$this->load->view('frontend/lupapassword');
		} else {
			$email = $this->input->post('email');
			$sqlcek = $this->db->get_where('tbl_musteri',['musteriEmail' => $email],['musteriDurum' => 1])->row_array();
			if ($sqlcek) {
				$token = md5($email.date("d-m-Y H:i:s"));
				$data = array(
				'tokenAdi' => $token,
				'tokenEmail' => $email,
				'tokenOlusturmaTarihi' => time()
				 );
			$this->db->insert('tbl_musteriToken', $data);
			$this->_sendmail($token,'forgot');
			$this->session->set_flashdata('message', 'swal("Success", "Successfully Reset Password Please Check Your Email", "success");');
    		redirect('login');
			}else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
						No Email Or Account Not Active
						</div>');
	   			redirect('login/lupapassword');
			}
		}
	}
	public function forgot($value=''){
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$sqlcek = $this->db->get_where('tbl_musteri',['musteriEmail' => $email])->row_array();
		if ($sqlcek) {
			$sqlcek_token = $this->db->get_where('tbl_musteriToken',['tokenAdi' => $token])->row_array();
			if ($sqlcek_token) {
				$this->session->set_userdata('resetemail' ,$email);
				$this->changepassword();
			}else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
				Failed to Reset Wrong Email Token
						</div>');
	    		redirect('login');
			}
		}else{
		$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
		Failed to Reset Wrong Email
						</div>');
	    redirect('login');
		}
	}
	
	public function changepassword($value=''){
		if ($this->session->userdata('resetemail') == NULL) {
			redirect('login/daftar');
		}
		$this->form_validation->set_rules('password1', 'sifre', 'trim|required|min_length[8]|matches[password2]',array(
			'matches' => 'Password Not Same.',
			'min_length' => 'Password Minimum 8 Characters.'
			 ));
		$this->form_validation->set_rules('password2', 'sifre', 'trim|required|matches[password1]');
		if ($this->form_validation->run() == false) {
			$this->load->view('frontend/resetpassword');
		}else{
			$email = $this->session->userdata('resetemail');
			$update = array(
				'musteriDurum' => 1,
				'musteriSifre' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT)
			);
			$where = array('musteriEmail' => $email );
			$this->db->update('tbl_musteri', $update,$where);
			$this->session->unset_userdata('resetemail');
			$this->db->delete('tbl_musteriToken',['tokenEmail' => $email]);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
					Successfully Reset, Login Your Account Back
					</div>');
			redirect('login');
		}
	}
}

/* End of file Login.php */

/* Location: ./application/controllers/Login.php */