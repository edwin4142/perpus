<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');

class M_Admin extends CI_Model
{
  function __construct()
  {
	 parent::__construct();
	 //validasi jika user belum login
	 }

   function get_table($table_name)
   {
     $get_user = $this->db->get($table_name);
     return $get_user->result_array();
   }

   function get_tableid($table_name,$where,$id)
   {
     $this->db->where($where,$id);
     $edit = $this->db->get($table_name);
     return $edit->result_array();
   }

   function get_tableid_edit($table_name,$where,$id)
   {
     $this->db->where($where,$id);
     $edit = $this->db->get($table_name);
     return $edit->row();
   }

   function add_multiple($table,$data = array())
  {
      $total_array = count($data);

      if($total_array != 0)
      {
      $this->db->insert_batch($table, $data);
      }
  }

   function insertTable($table_name,$data)
   {
     $tambah = $this->db->insert($table_name,$data);
     return $tambah;
   }

   function LastinsertId($table_name,$data)
   {
     $this->db->insert($table_name,$data);
     $insert_id = $this->db->insert_id();
     return $insert_id;
   }

   function update_table($table_name,$where,$id,$data)
   {
     $this->db->where($where,$id);
     $update = $this->db->update($table_name,$data);
     return $update;
   }

   function delete_table($table_name,$where,$id)
   {
     $this->db->where($where,$id);
     $hapus = $this->db->delete($table_name);
     return $hapus;
   }

   function delete_table_multiple($table_name,$where,$id)
   {
      if (!empty($id)) {
         $this->db->where_in($where,$id);
         $hapus = $this->db->delete($table_name);
         return $hapus;
      }
   }

   function edit_table($table_name,$where,$id)
   {
     $this->db->where($where,$id);
     $edit = $this->db->get($table_name);
     return $edit->row();
   }

   function CountTable($table_name)
   {
     $Count = $this->db->get($table_name);
     return $Count->num_rows();
   }

   function CountTableId($table_name,$where,$id)
   {
     $this->db->where($where,$id);
     $Count = $this->db->get($table_name);
     return $Count->num_rows();
   }

   function SelectTable($table_name,$query,$id,$orderby)
   {
       $this->db->select($query, FALSE); // select('RIGHT(user.id_odojers,4) as kode', FALSE);
       $this->db->order_by($id,$orderby);
       $query = $this->db->get($table_name); // cek dulu apakah ada sudah ada kode di tabel.
       return $query;
   }

   function SelectTableSQL($query)
   {
       $row = $this->db->query($query);
       return $row;
   }

  function get_user($user)
  {
    $this->db->where('id_login',$user);
    $get_user = $this->db->get('tbl_login');
    return $get_user->row();
	}
	
	function rp($angka){
			$hasil_rupiah = "Rp" . number_format($angka,0,',','.'). ',-';
			return $hasil_rupiah;
	}

 
	public function buat_kode($table_name,$kodeawal,$idkode,$orderbylimit)
  {
      $query = $this->db->query("select * from $table_name $orderbylimit"); // cek dulu apakah ada sudah ada kode di tabel.
      
		  if($query->num_rows() > 0){
        //jika kode ternyata sudah ada.
        $hasil = $query->row();
        $kd = $hasil->$idkode;
        $cd = $kd;
        $nomor = $query->num_rows();
        $kode = $cd + 1;
        $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
        $kdj = $kodejadi;
		  }else {
        //jika kode belum ada
        $kode = 0+1;
        $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
        $kdj = $kodejadi;
      }
		  return $kdj;
  }

  public function buat_kode_join($table_name,$kodeawal,$idkode)
  {
      $query = $this->db->query($table_name); // cek dulu apakah ada sudah ada kode di tabel.
		  if($query->num_rows() > 0){
        //jika kode ternyata sudah ada.
        $hasil = $query->row();
        $kd = $hasil->$idkode;
        $cd = $kd;
        $kode = $cd + 1;
        $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
        $kdj = $kodejadi;
		  }else {
        //jika kode belum ada
        $kode = 0+1;
        $kodejadi = $kodeawal."00".$kode;    // hasilnya CUS-0001 dst.
        $kdj = $kodejadi;
      }
		  return $kdj;
  }

  public function foto($nim)
  {
    $hasil = '<img src="https://dpna.api.untan.ac.id/mhs/getpicbynim/'.$nim.'" clas="img-responsive" style="height:auto;width:100px;">';
    return $hasil;
  }
  public function foto2($nim)
  {
    $hasil = "https://dpna.api.untan.ac.id/mhs/getpicbynim/".$nim;
    return $hasil;
  }

  public function simpan_qr($nim)
    {   
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config2['cacheable']    = true; //boolean, the default is true
        $config2['cachedir']     = '/assets_style/'; //string, the default is application/cache/
        $config2['errorlog']     = '/assets_style/'; //string, the default is application/logs/
        $config2['imagedir']     = '/assets_style/image/qr_code'; //direktori penyimpanan qr code
        $config2['quality']      = true; //boolean, the default is true
        $config2['size']         = '1024'; //interger, the default is 1024
        $config2['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config2['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config2);
 
        $image_name=$nim.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $nim; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = BASEPATH.'../assets_style/image/qr_code/'.$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }
  
  function acak($panjang)
  {
      $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
      $string = '';
      for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter[$pos];
      }
      return $string;
  }
}
?>
