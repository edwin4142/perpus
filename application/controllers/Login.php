<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
        
	 }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->data['title_web'] = 'Login | Perpustakaan';
		$this->load->view('login_view',$this->data);
	}

	public function daftar()
	{
		$this->data['title_web'] = 'Daftar | Perpustakaan';
		$this->load->view('daftar',$this->data);
	}

	public function daftarsimpan()
	{
		$nim = $this->input->post('nim');
		$password = $this->input->post('password');
		$no = $this->input->post('no');

		$akses_db = $this->db->get_where('tbl_login', ['user' => $nim])->row_array();
        
		if ($akses_db) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
											  Anda sudah terdaftar sebagai member
											</div>');
            redirect('login/daftar', 'location');
		}

		$akses = $this->siakadRegis($nim, $password);
		if ($akses['nama'] == NULL OR $akses['nama'] == 'SERVICE DOWN') {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
											  NIM atau Password salah
											</div>');
            redirect('login/daftar', 'location');
        }

        $this->load->library('upload',$config);
        if(!empty($_FILES['ktm']['name']))
        {
            // setting konfigurasi upload
            $config['upload_path'] = './assets_style/image/ktm_file/';
            $config['allowed_types'] = 'pdf'; 
            $config['encrypt_name'] = TRUE; //nama yang terupload nantinya
            // load library upload
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('ktm')) {
                $this->upload->data();
                $file2 = array('upload_data' => $this->upload->data());
                $this->db->set('ktm', $file2['upload_data']['file_name']);
            }else{
                $this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
                        <p> Upload KTM Gagal !</p>
                    </div></div>');
                redirect(base_url('login/daftar')); 
            }
        }

        $data = array(
            'anggota_id' => $nim,
            'user' => $nim, 
            'pass' => md5($password), 
            'level' => 'Anggota', 
            'nama' => $akses['nama'],
            'prodi' => $akses['prodi'],
            'semester' => $akses['semester'],
            'tgl_bergabung' => date('Y-m-d'),
            'telepon' => $no,
            'status' => 0
        );


        $this->db->insert('tbl_login', $data);
        $this->sendInfodaftar($nim, $akses['nama'], $no);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                              Data anda terkirim, silahkan menunggu admin memvalidasi data Anda. Pemberitahuan akan dikirim lewat nomor Whatsapp Anda
                                            </div>');
        redirect('login', 'location');

	}

    public function auth()
    {
        $user = htmlspecialchars($this->input->post('user',TRUE),ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass',TRUE),ENT_QUOTES);
        $pass2 = $this->input->post('pass');
        // auth
        $aksi = $this->cekLoginSiakad($user, $pass2);

        if ($user == 'admin') {
                
        }else{
            if ($aksi == 'SERVICE DOWN') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Service Siakad Down</div>');
                redirect('login', 'location');
            }
            if ($aksi == 'ERROR') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        NIM/Password Siakad Salah</div>');
                redirect('login', 'location');
            }
        }

        
        $proses_login = $this->db->query("SELECT * FROM tbl_login WHERE user='$user' AND pass = md5('$pass')");
        $row = $proses_login->num_rows();

        if($row > 0)
        {
            $hasil_login = $proses_login->row_array();
            if ($hasil_login['status'] == 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Akun Anda belum di validasi Admin</div>');
                redirect('login', 'location');
            }
            // create session
            $this->session->set_userdata('masuk_perpus',TRUE);
            $this->session->set_userdata('level',$hasil_login['level']);
            $this->session->set_userdata('ses_id',$hasil_login['id_login']);
            $this->session->set_userdata('anggota_id',$hasil_login['anggota_id']);

            echo '<script>window.location="'.base_url().'dashboard";</script>';
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Akun Anda belum terdaftar</div>');
                redirect('login', 'location');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        echo '<script>window.location="'.base_url().'";</script>';
    }

    function siakadRegis($nim, $password)
    {
        $data = array(
            'nim' => $nim,
            'password' => $password
        );
         
        $payload = json_encode($data);
         
        // Prepare new cURL resource
        $ch = curl_init('203.24.50.140/API/login-siakad-mhs.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($ch);
         
        // Close cURL session handle
        curl_close($ch);
        
        $tes = json_decode($result);
        $hasil1 = $tes->STATUS;   
        if (!$hasil1) {
            return array('nama' => 'SERVICE DOWN');
        }else{
            if($tes->STATUS == 'SUCCESS'){
                return array('nama' => $tes->USER->nama, 'prodi' => $tes->USER->progdi, 'semester' => $tes->USER->thkad);
            }else{
                return array('nama' => NULL, 'prodi' => NULL, 'semester' => NULL);
            }
        }
    }

    public function cekLoginSiakad($nim,$password)
    {
        $data = array(
            'nim' => $nim,
            'password' => $password
        );
         
        $payload = json_encode($data);
         
        // Prepare new cURL resource
        $ch = curl_init('203.24.50.140/API/login-siakad-mhs.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($ch);
         
        // Close cURL session handle
        curl_close($ch);
        
        $tes = json_decode($result);
        $hasil = $tes->STATUS;   
        if (!$hasil) {
            $hasil = 'SERVICE DOWN';
        }
        return $hasil;
    }

    public function sendInfodaftar($nim, $nama, $no)
    {
        $data = array(
            'api_key' => '979b07377545d6ccda68e8fa2e8d629cad2216de',
            'sender' => '6281522658229',
            'number' => '62'.$no,
            'message' => '*'.$nama.' '.$nim.'* Terimaksih data Anda telah terkirim di Perpustakaan Teknik Informatika Universitas Tanjungpura, admin sedang memvalidasi data Anda, silahkan menunggu informasi selanjutnya'
        );

        $payload = json_encode($data);

        $curl = curl_init(); 

        curl_setopt_array($curl, [
                             CURLOPT_URL => 'https://wa.gofly.id/api/send-message.php',
                             CURLOPT_RETURNTRANSFER => true,
                             CURLOPT_ENCODING => '',
                             CURLOPT_MAXREDIRS => 10,
                             CURLOPT_TIMEOUT => 2,
                             CURLOPT_FOLLOWLOCATION => true,
                             CURLOPT_SSL_VERIFYPEER => 0,
                             CURLOPT_CONNECTTIMEOUT => 2,
                             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                             CURLOPT_CUSTOMREQUEST => 'POST',
                             CURLOPT_POSTFIELDS => json_encode($data), ]
                           );
         
        // Set HTTP Header for POST request
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($curl);
         
        // Close cURL session handle
        curl_close($curl);

        var_dump($result);
    }

    function wa_api($data)
    {
        $payload = json_encode($data);

        $curl = curl_init(); 

        curl_setopt_array($curl, [
                             CURLOPT_URL => 'https://wa.gofly.id/api/send-message.php',
                             CURLOPT_RETURNTRANSFER => true,
                             CURLOPT_ENCODING => '',
                             CURLOPT_MAXREDIRS => 10,
                             CURLOPT_TIMEOUT => 2,
                             CURLOPT_FOLLOWLOCATION => true,
                             CURLOPT_SSL_VERIFYPEER => 0,
                             CURLOPT_CONNECTTIMEOUT => 2,
                             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                             CURLOPT_CUSTOMREQUEST => 'POST',
                             CURLOPT_POSTFIELDS => json_encode($data), ]
                           );
         
        // Set HTTP Header for POST request
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($curl);
         
        // Close cURL session handle
        curl_close($curl);
    }
}
