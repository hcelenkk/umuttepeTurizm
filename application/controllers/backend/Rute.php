<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rute extends CI_Controller {
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
		$data['title'] = "Destination/Terminal List";
		$data['tujuan'] = $this->db->query("SELECT * FROM tbl_sehir")->result_array();
		// die(print_r($data));
		$this->load->view('backend/tujuan', $data);
	}
	
	public function viewrute($id=''){
		$data['title'] = "Destination/Terminal List";
		$data['rute'] = $this->db->query("SELECT * FROM tbl_sehir WHERE sehirKodu = '".$id."' ")->row_array();
		// die(print_r($data));
		$this->load->view('backend/view_tujuan', $data);
	}
	public function tambahtujuan(){
		$kode = $this->getkod_model->get_kodtuj();
		$data = array(
			'hedefSehir' => $this->input->post('tujuan'),
			'sehirKodu' => $kode,
			'terminalSehri' => $this->input->post('terminal'),
			 );
		// die(print_r($data));
		$this->db->insert('tbl_sehir', $data);
		$this->session->set_flashdata('message', 'swal("Data Added Successfully");');
		redirect('backend/rute');
	}
}

/* End of file Rute.php */

/* Location: ./application/controllers/backend/Rute.php */