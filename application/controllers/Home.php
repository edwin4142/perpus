<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
        
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
	 	$this->load->view('home/header',$this->data);
		// $this->load->view('home/sidebar',$this->data);
		$this->load->view('home/buku',$this->data);
		$this->load->view('home/footer',$this->data);
	 }

}