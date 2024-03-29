<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {
	function __construct(){
	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		$this->getsecurity();
		$this->load->library('form_validation');
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
		$data['title'] = "Schedule Management";
		$data['jadwal'] = $this->db->query("SELECT * FROM tbl_saat LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_sehir on tbl_saat.terminalKodu = tbl_sehir.sehirKodu ")->result_array();
		$this->load->view('backend/jadwal', $data);
	}
	public function viewtambahjadwal($value=''){
		$data['title'] = "Add Schedule";
		$data['bus'] = $this->db->query("SELECT * FROM tbl_otobus ORDER BY otobusAdi asc")->result_array();
		$data['tujuan'] = $this->db->query("SELECT * FROM tbl_sehir ORDER BY hedefSehir asc")->result_array();
		$this->load->view('backend/tambahjadwal', $data);
	}
	
	public function tambahjadwal(){
		$this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required|min_length[5]|max_length[12]');
		if ($this->form_validation->run() ==  FALSE) {
			$data['title'] = "Add Schedule";
			$data['bus'] = $this->db->query("SELECT * FROM tbl_otobus ORDER BY otobusAdi asc")->result_array();
			$data['tujuan'] = $this->db->query("SELECT * FROM tbl_sehir ORDER BY hedefSehir asc")->result_array();
			$this->load->view('backend/tambahjadwal', $data);
		} else {
			$asal = $this->input->post('asal');
			$tujuan = $this->db->query("SELECT * FROM tbl_sehir
               WHERE sehirKodu ='".$this->input->post('tujuan')."'")->row_array();
			if ($asal == $tujuan['sehirKodu']) {
				$this->session->set_flashdata('message', 'swal("Succeed", "Schedule Goals Cant Be the Same", "error");');
			redirect('backend/jadwal');
			}else{
			$kode = $this->getkod_model->get_kodjad();
			$simpan = array(
					'saatKodu' => $kode,
					'terminalKodu' => $asal,
					'sehirKodu' => $tujuan['sehirKodu'],
					'otobusKodu' => $this->input->post('bus'),
					'bolgeAdi' => $tujuan['hedefSehir'],
					'kalkisSaati' => $this->input->post('berangkat'),
					'varisSaati' => $this->input->post('tiba'),
					'fiyatTarifesi' =>  $this->input->post('harga'),
					 );
			// die(print_r($simpan));
			$this->db->insert('tbl_saat', $simpan);
			$this->session->set_flashdata('message', 'swal("Succeed", "New schedule has been added", "success");');
			redirect('backend/jadwal');
			}
			
		}
		
	}
	public function viewjadwal($id=''){
		$data['title'] = "Destination List";
	 	$sqlcek = $this->db->query("SELECT * FROM tbl_saat LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE saatKodu ='".$id."'")->row_array();
	 	if ($sqlcek) {
	 		$data['asal'] = $this->db->query("SELECT * FROM tbl_sehir WHERE sehirKodu = '".$sqlcek['terminalKodu']."'")->row_array();
	 		$data['jadwal'] = $sqlcek;
			$data['title'] = "View Schedule";
			// die(print_r($data));
			$this->load->view('backend/view_jadwal',$data);
	 	}else{
	 		$this->session->set_flashdata('message', 'swal("Failed", "Something Went Wrong. Please Try Again", "error");');
			redirect('backend/jadwal');
	 	}
	}	
}

/* End of file Jadwal.php */

/* Location: ./application/controllers/backend/Jadwal.php */