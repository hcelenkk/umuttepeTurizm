<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	function __construct(){
	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		$this->getsecurity();
		date_default_timezone_set("Europe/Istanbul");
	}
	function getsecurity($value=''){
		if (empty($this->session->userdata('adminKullaniciAdi'))) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
	public function index(){
		$data['title'] = "Booking List";
 		$data['order'] = $this->db->query("SELECT * FROM tbl_rezervasyon group by rezervasyonKodu")->result_array();
		// die(print_r($data));
		$this->load->view('backend/order', $data);
	}
	
	public function vieworder($id=''){
		// die(print_r($_GET));
		$cek = $this->input->get('order').$id;
	 	$sqlcek = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu WHERE rezervasyonKodu ='".$cek."' ")->result_array();
	 	if ($sqlcek) {
	 		$data['tiket'] = $sqlcek;
			$data['title'] = "View Bookings";
			// die(print_r($sqlcek));
			$this->load->view('backend/view_order',$data);
	 	}else{
	 		$this->session->set_flashdata('message', 'swal("Empty", "No Order", "error");');
    		redirect('backend/tiket');
	 	}
	}
	public function inserttiket($value=''){
		$id = $this->input->post('rezervasyonKodu');
		$asal = $this->input->post('asal_beli');
		$tiket = $this->input->post('biletKodu');
		$nama = $this->input->post('nama');
		$kursi = $this->input->post('no_kursi');
		$umur = $this->input->post('umur_kursi');
		$harga = $this->input->post('harga');
		$tgl = $this->input->post('tgl_beli');
		$status = $this->input->post('status');
		$where = array('rezervasyonKodu' => $id );
		$update = array('rezervasyonDurumu' => $status );
		$this->db->update('tbl_rezervasyon', $update,$where);
		$data['asal'] = $this->db->query("SELECT * FROM tbl_sehir WHERE sehirKodu ='".$asal."'")->row_array();
		$data['cetak'] = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE rezervasyonKodu ='".$id."'")->result_array();
		$pelanggan = $this->db->query("SELECT musteriEmail FROM tbl_musteri WHERE musteriKodu ='".$data['cetak'][0]['musteriKodu']."'")->row_array();
		$pdfFilePath = "assets/backend/upload/etiket/".$id.".pdf";
		$html = $this->load->view('frontend/cetaktiket', $data, TRUE);
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath);
		for ($i=0; $i < count($nama) ; $i++) { 
			$simpan = array(
				'biletKodu' => $tiket[$i],
				'rezervasyonKodu' => $id,
				'biletAdi' => $nama[$i],
				'biletKoltuk' => $kursi[$i],
				'biletYas' => $umur[$i],
				'satinAlinanBilet' => $asal,
				'biletFiyat' => $harga,
				'biletDurum' => $status,
				'biletEtiket' => $pdfFilePath,
				'biletOlusturmaTarihi' => date('Y-m-d'),
				'biletOlusturmaYoneticisi' => $this->session->userdata('adminKullaniciAdi')
			);
		$this->db->insert('tbl_bilet', $simpan);
		}
		$this->session->set_flashdata('message', 'swal("Succeed", "Ticket Order Processed Successfully", "success");');
		redirect('backend/order');

		
	}
	
	public function kirimemail($id=''){
		$data['cetak'] = $this->db->query("SELECT * FROM tbl_rezervasyon LEFT JOIN tbl_saat on tbl_rezervasyon.saatKodu = tbl_saat.saatKodu LEFT JOIN tbl_sehir on tbl_saat.sehirKodu = tbl_sehir.sehirKodu WHERE rezervasyonKodu ='".$id."'")->result_array();
		$asal = $data['cetak'][0]['rezervasyonTerminali'];
		$kodeplg = $data['cetak'][0]['musteriKodu'];
		$data['asal'] = $this->db->query("SELECT * FROM tbl_sehir WHERE sehirKodu ='$asal'")->row_array();
		$pelanggan = $this->db->query("SELECT musteriEmail FROM tbl_musteri WHERE musteriKodu ='$kodeplg'")->row_array();
		//email
		$subject = 'E-ticket - Order ID '.$id.' - '.date('dmY');
		$message = $this->load->view('frontend/cetaktiket', $data ,TRUE);
		$attach  = base_url("assets/backend/upload/etiket/".$id.".pdf");
		$to 	= $pelanggan['musteriEmail'];
		$config = array(
			   'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'demo@email.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'P@$$\/\/0RD',      // Password gmail kamu
               'smtp_port' => 465,
               'crlf'      => "rn",
               'newline'   => "rn"
		);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('Umuttepe Turizm');
        $this->email->to($to);
        $this->email->attach($attach);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
        	$this->session->set_flashdata('message', 'swal("Succeed", "E-Ticket sent!", "success");');
			redirect('backend/order/vieworder/'.$id);
        } else {
            $this->session->set_flashdata('message', 'swal("Failed", "E-Tickets Failed to Send Contact the IT Team", "error");');
			redirect('backend/order/vieworder/'.$id);
        }

	}

}

/* End of file Order.php */

/* Location: ./application/controllers/backend/Order.php */