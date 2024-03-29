<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	function __construct(){
	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		$this->getsecurity();
		date_default_timezone_set("Europe/Istanbul");
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('adminKullaniciAdi');
		if (empty($username)) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
	
	public function index(){
		$data['title'] = 'Report';
		$data['bulan'] = $this->db->query("SELECT DISTINCT DATE_FORMAT(biletOlusturmaTarihi,'%M %Y') AS bulan FROM tbl_bilet")->result_array();
		$this->load->view('backend/laporan', $data);
	}
	public function laportanggal($value=''){
		$data['mulai'] = $this->input->post('mulai');
		$data['sampai'] = $this->input->post('sampai');
		$data['laporan'] = $this->db->query("SELECT * FROM tbl_bilet WHERE (biletOlusturmaTarihi BETWEEN '".$data['mulai']."' AND '".$data['sampai']."') AND biletDurum = 2")->result_array();
		for ($i=0; $i < count($data['laporan']) ; $i++) { 
			$total[$i] = $data['laporan'][$i]['biletFiyat'];
		}
		$data['total'] = array_sum($total);
		$this->load->view('backend/laporan/laporan_pertanggal', $data);		
	}
	public function laporbulan($value=''){
		$data['bulan'] = $this->input->post('bln');
		// $data['laporan'] = $this->db->query("SELECT biletOlusturmaTarihi,DATE_FORMAT(biletOlusturmaTarihi,'%M %Y') AS bulan,DATE_FORMAT(biletOlusturmaTarihi,'%d %M %Y') FROM tbl_bilet  WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$data['bulan']' ORDER BY biletKodu DESC");
		die(print_r($data));
		// for ($i=0; $i < count($data['laporan']) ; $i++) { 
		// 	$total[$i] = $data['laporan'][$i]['biletFiyat'];
		// }
		// $data['total'] = array_sum($total);
		// $this->load->view('backend/laporan/laporan_pertanggal', $data);
	}
}

/* End of file Laporan.php */

/* Location: ./application/controllers/backend/Laporan.php */