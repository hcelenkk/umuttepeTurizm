<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		date_default_timezone_set("Europe/Istanbul");
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username');
		if (empty($username)) {
			redirect('login');
		}
	}
	public function index(){
		$this->session->unset_userdata(array('jadwal','asal','tanggal'));
		$data['title'] = "Rezervasyon Yap";
		$data['asal'] = $this->db->query("SELECT * FROM `tbl_sehir` ORDER BY hedefSehir ASC")->result_array();
		$data['tujuan'] = $this->db->query("SELECT * FROM `tbl_sehir` group by hedefSehir ORDER BY hedefSehir ASC ")->result_array();
		$data['list'] = $this->db->query("SELECT * FROM `tbl_sehir` ORDER BY hedefSehir ASC")->result_array();
		$this->load->view('frontend/cektanggal',$data);
	}
	
	public function cektiket($value=''){
		$this->load->view('frontend/cektiket');
	}
	public function cekjadwal($tgl='' , $asl='', $tjn=''){
		$this->session->unset_userdata(array('jadwal','asal','tanggal'));
		$data['title'] = 'Bilet Ara';
		$data['tanggal'] = $this->input->get('tanggal').$tgl;
		$asal = $this->input->get('asal').$asl;
		$tujuan = $this->input->get('tujuan').$tjn;
		$data['asal'] = $this->db->query("SELECT * FROM tbl_sehir
               WHERE sehirKodu ='$asal'")->row_array();
		$data['jadwal'] = $this->db->query("SELECT * FROM tbl_saat LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE tbl_saat.bolgeAdi ='$tujuan' AND tbl_saat.terminalKodu = '$asal'")->result_array();
		if (!empty($data['jadwal'])) {
			if ($tujuan == $data['asal']['hedefSehir']) {
				$this->session->set_flashdata('message', 'swal("Cek", "Tujuan dan Asal tidak boleh sama", "error");');
    			redirect('tiket');
			}else{
				for ($i=0; $i < count($data['jadwal']); $i++) { 
					$data['kursi'][$i] = $this->db->query("SELECT count(koltukSahibiNo) FROM tbl_rezervasyon WHERE saatKodu = '".$data['jadwal'][$i]['saatKodu']."' AND rezervasyonYapilanTarih = '".$data['tanggal']."' AND rezervasyonTerminali = '".$asal."'")->result_array();
				};
				$this->load->view('frontend/cekjadwal',$data);
			}
		}else{
			//$this->session->set_flashdata('message', 'swal("Empty", "No Schedule", "error");');
    		redirect('tiket');
		}
		
	}
	
	public function beforebeli($jadwal="",$asal='',$tanggal=''){
		$array = array(
			'jadwal' => $jadwal,
			'asal'	=> $asal,
			'tanggal'	=> $tanggal
		);
		$this->session->set_userdata($array);
		if ($this->session->userdata('username')){
			$id = $jadwal;
			$asal = $asal;
			$data['tanggal'] = $tanggal;
			$data['asal'] =  $this->db->query("SELECT * FROM tbl_sehir
               WHERE sehirKodu ='".$asal."'")->row_array();
			$data['jadwal'] = $this->db->query("SELECT * FROM tbl_saat LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE saatKodu ='".$id."'")->row_array();
			$data['kursi'] = $this->db->query("SELECT koltukSahibiNo FROM tbl_rezervasyon WHERE saatKodu = '".$data['jadwal']['saatKodu']."' AND rezervasyonYapilanTarih = '".$data['tanggal']."' AND rezervasyonTerminali = '".$asal."'")->result_array();
			$this->load->view('frontend/beli_step1',$data);
		}else{ 
			redirect('login/autlogin');
		}
	}
	public function afterbeli(){
		$data['kursi'] = $this->input->get('kursi');
		$data['bank'] = $this->db->query("SELECT * FROM `tbl_banka` ")->result_array();
		$data['saatKodu'] = $this->session->userdata('jadwal');
		$data['asal'] = $this->session->userdata('asal');
		$data['tglberangkat'] = $this->input->get('tgl');
		if ($data['kursi']) {
			$this->load->view('frontend/beli_step2', $data);
		}else{
			$this->session->set_flashdata('message', 'swal("Empty", "Choose Your Seat", "error");');
			redirect('tiket/beforebeli/'.$data['asal'].'/'.$data['saatKodu']);
		}
	}
	
	public function gettiket($value=''){
	    include 'assets/phpqrcode/qrlib.php';
	    $asal =  $this->db->query("SELECT * FROM tbl_sehir
               WHERE sehirKodu ='".$this->session->userdata('asal')."'")->row_array();		
		$getkode =  $this->getkod_model->get_kodtmporder();
		$saatKodu = $this->session->userdata('jadwal');
		$musteriKodu = $this->session->userdata('musteriKodu');
		$tglberangkat = $this->input->post('tgl');
		$jambeli = date("Y-m-d H:i:s");
		$nama =  $this->input->post('nama');
		$kursi = $this->input->post('kursi');
		$tahun = $this->input->post('tahun');
		$no_ktp = $this->input->post('no_ktp');
		$nama_pemesan = $this->input->post('nama_pemesan');
		$hp = $this->input->post('hp');
		$alamat = $this->input->post('adres');
		$email = $this->input->post('email');
		$bank = $this->input->post('bank');
		$satu_hari        = mktime(0,0,0,date("n"),date("j")+1,date("Y"));
		$expired       = date("d-m-Y", $satu_hari)." ".date('H:i:s');
		$status 		= '1';
		QRcode::png($getkode,'assets/frontend/upload/qrcode/'.$getkode.".png","Q", 8, 8);
		$count = count($kursi);
		$tanggal = hari_indo(date('N',strtotime($jambeli))).', '.tanggal_indo(date('Y-m-d',strtotime(''.$jambeli.''))).', '.date('H:i',strtotime($jambeli));
		for($i=0; $i<$count; $i++) {
			$simpan = array(
				'rezervasyonKodu' => $getkode,
				'biletKodu' => 'T'.$getkode.$saatKodu.str_replace('-','',$tglberangkat).$kursi[$i],
				'saatKodu'	=> $saatKodu,
				'musteriKodu' => $musteriKodu,
				'rezervasyonTerminali' => $asal['sehirKodu'],
				'rezervasyonSahibi'	=> $nama_pemesan,
				'rezervasyonTarihi'	=> $tanggal,
				'rezervasyonYapilanTarih' => $tglberangkat,
				'koltukSahibiNo'		=> $kursi[$i],
				'koltukSahibiAdi' => $nama[$i],
				'koltukSahibiYasi' => $tahun[$i],
				'koltukSahibiTakipNo'	=> $no_ktp,
				'koltukSahibiTelNo'	=> $hp,
				'koltukSahibiAdresi'	=> $alamat,
				'koltukSahibiEmail'		=> $email,
				'bankaKodu' => $bank,
				'rezervasyonSonGecerlilik'	=> $expired,
				'rezervasyonQrCode'	=> 'assets/frontend/upload/qrcode/'.$getkode.'.png',
				'rezervasyonDurumu'	=> $status
			);
			$this->db->insert('tbl_rezervasyon', $simpan);
		}
		redirect('tiket/checkout/'.$getkode);
	}
	
	public function cekorder($id=''){
		$id = $this->input->post('kodetiket');
		$sqlcek = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_banka on tbl_rezervasyon.bankaKodu = tbl_banka.bankaKodu WHERE rezervasyonKodu ='$id' AND rezervasyonDurumu != 3 AND rezervasyonDurumu != 2")->result_array();
		if ($sqlcek) {
			$data['tiket'] = $sqlcek;
			$data['count'] = count($sqlcek);
			$this->load->view('frontend/payment',$data);
		}else{
			//$this->session->set_flashdata('message', 'swal("Empty", "tiket Bulunamadı", "error");');
    		redirect('tiket/cektiket');
		}
	}
	public function payment($id=''){
		$this->getsecurity();
		$sqlcek = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_otobus on tbl_saat.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_banka on tbl_rezervasyon.bankaKodu = tbl_banka.bankaKodu WHERE rezervasyonKodu ='$id'")->result_array();
		$data['count'] = count($sqlcek);
		$data['tiket'] = $sqlcek;
		$this->load->view('frontend/payment',$data);
	}
	public function checkout($value=''){
		$this->getsecurity();
		$data['tiket'] = $value;
		$send['sendmail'] = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu LEFT JOIN tbl_banka on tbl_rezervasyon.bankaKodu = tbl_banka.bankaKodu WHERE rezervasyonKodu ='$value'")->row_array();
		$send['count'] = count($send['sendmail']);
		//email
		$subject = 'Umuttepe Turizm';
		$message = $this->load->view('frontend/sendmail',$send, TRUE);
		$to 	 = $this->session->userdata('email');
        $config = [
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'demo@email.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'P@$$\/\/0RD',      // Password gmail kamu
               'smtp_port' => 465,
		   ];
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('Umuttepe Turizm');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
			$this->session->set_flashdata('message', 'swal("Success", "Please proceed towards payment confirmation!", "success");');
            $this->load->view('frontend/checkout', $data);
        } else {
		//    echo 'Error! Send an error email';
		$this->session->set_flashdata('message', 'swal("Success", "Please proceed towards payment confirmation!", "success");');
            $this->load->view('frontend/checkout', $data);
        }
	}
	
	public function caritiket(){
		$id = $this->input->post('kodetiket');
		$sqlcek = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_otobus on tbl_rezervasyon.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu WHERE rezervasyonKodu ='".$id."'")->result_array();
		if ($sqlcek == NULL) {
			$this->session->set_flashdata('message', 'swal("Kosong", "Tidak Ada Tiket", "error");');
    		redirect('tiket/cektiket');
		}else{
			$data['tiket'] = $sqlcek;
			$this->load->view('frontend/payment', $data);
		}
	}
	public function konfirmasi($value='',$harga=''){
		$this->getsecurity();
		$data['id'] = $value;
		$data['total'] = $harga;
		$this->load->view('frontend/konfirmasi', $data);
	}
	public function insertkonfirmasi($value=''){
		$this->getsecurity();
		$config['upload_path'] = './assets/frontend/upload/payment';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('userfile')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('message', 'swal("Fail", "Check Your Confirmation Again", "error");');
			redirect('tiket/konfirmasi/'.$this->input->post('rezervasyonKodu').'/'.$this->input->post('total'));
		}
		else{
			$upload_data = $this->upload->data();
			$featured_image = '/assets/frontend/upload/payment/'.$upload_data['file_name'];
			$data = array(
						'dogrulamaKodu' => $this->getkod_model->get_kodkon(),
						'rezervasyonKodu'	=> $this->input->post('rezervasyonKodu'),
						'dogrulamaBankaAdi'		=> $this->input->post('bank_km'),
						'dogrulamaAdi' =>  $this->input->post('nama'),
						'dogrulamaHesapNo'		=> $this->input->post('nomrek'),
						'dogrulamaToplam' => $this->input->post('total'),
						'dogrulamaFoto' => $featured_image
					);
			$this->db->insert('tbl_dogrulama', $data);
			$this->session->set_flashdata('message', 'swal("Success", "Thank you. Please wait for the verification!", "success");');
			redirect('profile/tiketsaya/'.$this->session->userdata('musteriKodu'));
		}
	}
	
	public function cetak($id=''){
		$this->getsecurity();
		$order = $id;
		$data['cetak'] = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_otobus on tbl_rezervasyon.otobusKodu = tbl_otobus.otobusKodu LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE rezervasyonKodu ='".$id."'")->result_array();
		$tiket = $this->db->query("SELECT musteriEmail FROM tbl_musteri WHERE musteriKodu ='".$data['cetak'][0]['musteriKodu']."'")->row_array();
		die(print_r($tiket));
	}

}

/* End of file Tiket.php */
/* Location: ./application/controllers/Tiket.php */
