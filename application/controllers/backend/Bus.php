<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bus extends CI_Controller {
	function __construct(){
	parent::__construct();
		$this->load->model('getkod_model');
		date_default_timezone_set("Europe/Istanbul");
	}
	public function index(){
	$data['title'] = "Otobüs Yönetimi";
	$data['bus'] = $this->db->query("SELECT * FROM tbl_otobus ORDER BY otobusAdi asc")->result_array();

	$this->load->view('backend/bus', $data);	
	}
	public function viewbus($id=''){
		$data['title'] = "Otobüs İnceleme";
		$data['bus'] = $this->db->query("SELECT * FROM tbl_otobus WHERE otobusKodu = '".$id."'")->row_array();
		$this->load->view('backend/view_bus', $data);
	}
	public function tambahbus(){
		$kode = $this->getkod_model->get_kodbus();
		$data = array(
			'otobusKodu' => $kode,
			'otobusAdi' => $this->input->post('otobusAdi'),
			'otobusPlakasi'		 => $this->input->post('otobusPlakasi'),
			'otobusKapasitesi'		 => $this->input->post('seat'),
			'otobusDurumu'			=> '1'
			 );
		$this->db->insert('tbl_otobus', $data);
		$this->session->set_flashdata('message', 'swal("Başarılı", "Otobüs Verisi Kaydedildi", "success");');
		redirect('backend/bus');
	}

}
