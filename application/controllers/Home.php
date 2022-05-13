<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
        $this->load->model('M_Admin');
        
	 }

	 public function index()
	 {
	 	// $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['title_web'] = 'Dashboard ';
		$this->data['count_pengguna']=$this->db->query("SELECT * FROM tbl_login")->num_rows();
		$this->data['count_buku']=$this->db->query("SELECT * FROM tbl_buku")->num_rows();
		$this->data['count_pinjam']=$this->db->query("SELECT * FROM tbl_pinjam WHERE status = 'Dipinjam'")->num_rows();
		$this->data['count_kembali']=$this->db->query("SELECT * FROM tbl_pinjam WHERE status = 'Di Kembalikan'")->num_rows();
		$this->load->view('home/header',$this->data);
		// $this->load->view('home/sidebar',$this->data);
		$this->load->view('home/index',$this->data);
		$this->load->view('home/footer',$this->data);
	 }

	 public function buku()
	 {
		$this->data['title_web'] = 'Dashboard ';
		$data['buku'] = NULL;

		$judul = $this->input->post('judul');
		$data['judul'] = $judul;
		if ($judul) {
			$sql = "SELECT * FROM tbl_buku WHERE title LIKE '%$judul%'";
			$data['buku'] = $this->db->query($sql)->result_array();
		}
		

	 	$this->load->view('home/header',$this->data);
		// $this->load->view('home/sidebar',$this->data);
		$this->load->view('home/buku',$data);
		$this->load->view('home/footer',$this->data);
	 }

	function GetId()
    {
        $id_buku = $this->input->post('id_buku');

        $buku1 = $this->db->get_where('tbl_buku', ['id_buku' => $id_buku])->row_array();

        echo json_encode($buku1);
    }

    public function pengunjung()
	 {
	 	// $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['title_web'] = 'Dashboard ';

		$this->load->view('home/header',$this->data);
		// $this->load->view('home/sidebar',$this->data);
		$this->load->view('home/pengunjung',$this->data);
		$this->load->view('home/footer',$this->data);
	 }

	 public function cek_id()
    {
        $result_code = $this->input->post('nim');

        $tgl = date('Y-m-d');
        $jam_msk = date('H:i:s');
        $jam_klr = date('H:i:s');

        $cek_id = $this->M_Admin->cek_id($result_code);
        $cek_kehadiran = $this->m_admin->cek_kehadiran($result_code, $tgl);

        $foto = $this->m_admin->foto_mhs($result_code);

        if (!$cek_id) {

            $this->session->set_flashdata('foto', '<img style="display:block;" src="'.$foto.'" alt="" width="200px" height="250px">');
            $this->session->set_flashdata('nim', $result_code);
            redirect($_SERVER['HTTP_REFERER']);

        }else{

            $data = array(
                'nim' => $result_code,
                'tgl' => $tgl,
                'jam_msk' => $jam_msk,
                'id_khd' => 1,
                'id_status' => 1,
            );
            $this->m_admin->absen_masuk($data);

            $this->session->set_flashdata('foto', '<img style="display:block;" src="'.$foto.'" alt="" width="200px" height="250px">');
            $this->session->set_flashdata('nim', $result_code);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


}