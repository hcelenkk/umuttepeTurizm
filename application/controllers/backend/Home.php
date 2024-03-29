<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		$this->getsecurity();
		date_default_timezone_set("Europe/Istanbul");
	}
	public function index(){
		$data['title'] = "Anasayfa";
		$data['order'] = $this->db->query("SELECT count(rezervasyonKodu) FROM tbl_rezervasyon WHERE rezervasyonDurumu ='1'")->result_array();
		$data['tiket'] = $this->db->query("SELECT count(biletKodu) FROM tbl_bilet WHERE biletDurum = '2'")->result_array();
		$data['konfirmasi'] = $this->db->query("SELECT count(dogrulamaKodu) FROM tbl_dogrulama ")->result_array();
		$data['bus'] = $this->db->query("SELECT count(otobusKodu) FROM tbl_otobus WHERE otobusDurumu = 1 ")->result_array();
		$data['terminal'] = $this->db->query("SELECT count(sehirKodu) FROM tbl_sehir")->result_array();
		$data['schedules'] = $this->db->query("SELECT count(saatKodu) FROM tbl_saat")->result_array();
		
		$this->load->view('backend/home', $data);
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('adminKullaniciAdi');
		if (empty($username)) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
}
