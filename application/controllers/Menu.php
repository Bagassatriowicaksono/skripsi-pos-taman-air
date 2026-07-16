<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
        cekJamLogin();
    }
     
    public function index()
    {
        if ($this->session->userdata('ses_level') != 'Admin') {
            redirect('menu/persediaan');
            exit;
        }
        $this->data = [
            'title_web'  => 'Daftar Menu',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function dtmenu()
    {
        $pageNumber = xss_protect($this->input->post('pageHome', true));
        $halperpage = 12;
        $page       = isset($pageNumber) ? (int)$pageNumber : 1;
        $mulai      = ($page > 1) ? ($page * $halperpage) - $halperpage : 0;

        $wr = 'WHERE menu.deleted_at IS NULL';
        if ($this->input->get('id')) {
            $wr     .= ' AND id_kategori = '.(int)$this->input->get('id').' ';
        } elseif ($this->input->get('cari')) {
            $wr     .= ' AND (kode_menu LIKE "%'.$this->input->get('cari', true).'%" OR nama LIKE "%'.$this->input->get('cari', true).'%" OR kategori.kategori LIKE "%'.$this->input->get('cari', true).'%")';
        }

        $query      = "SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id";
       $hasil = $this->db->query($query." $wr ORDER BY menu.id_kategori ASC, menu.nama ASC LIMIT $mulai, $halperpage")->result();

        $this->data['hasil'] = $hasil;
        $this->load->view('admin/kasir/menu', $this->data);
    }

    public function data_menu()
    {
        if ($this->input->method(true)=='POST'):
            $query      = "SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id";
            $search     = array('kode_menu','kategori.kategori','nama','harga','keterangan','gambar');
            if ((int)$this->input->get('id')) {
                $where  = array('id_kategori' => (int)$this->input->get('id'));
            } else {
                $where  = null;
            }
        $iswhere = ' menu.deleted_at IS NULL';
        // if ($this->input->get('cek')) {
        //     $iswhere    .= " AND stok <= stok_minim ";
        // }


        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function stok()
    {
        if ($this->input->get('id')) {
            $this->data = [
                'title_web'  => 'Entry Persediaan Menu',
                'tipe'       => 'edit',
                'edit'       => $this->db->query("SELECT * FROM menu WHERE menu.id = ?", array($this->input->get('id')) )->row(),
            ];
        } else {
            $this->data = [
                'title_web'  => 'Entry Persediaan Menu',
                'tipe'       => ''
            ];
        }
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/stok', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function persediaan()
    {
        $this->data = [
            'title_web'  => 'Daftar Persediaan Menu',
        ];
        
        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/persediaan', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function get_menu()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
        $cek = $this->db->query("SELECT * FROM menu WHERE menu.id=?", array($id)); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $data = $cek->row();
            $result[] = array(
                'id'            => $data->id,
                'nama'          => $data->nama,
                // 'stok'          => $data->stok,
                // 'stok_minim'    => $data->stok_minim,
            );
            echo json_encode($result);
        } else {
            echo '';
        }
    }

    public function pasok()
    {
        $id =  (int)$this->input->post("id"); // parameter yang mau di update
            
        $this->form_validation->set_rules("id", "Id", "required");
        $this->form_validation->set_rules("stok", "Stok", "required");

        if ($this->form_validation->run() != false) {
            $data_r = [
                'menu_id'    => $id,
                'stok_awal'  => (int)$this->input->post("stok"),
                'stok_akhir' => (int)$this->input->post("stoka"),
                'date'       => date('Y-m-d'),
                'periode'    => date('Y-m')
            ];
            
            $this->db->insert("menu_stok", $data_r);

            $data = [
                'stok'       => (int)$this->input->post("stok"),
                'stok_minim' => (int)$this->input->post("stok_minim"),
            ];
            
            $this->db->where("id", $id); // ubah id dan postnya
            $this->db->update("menu", $data);

            $this->session->set_flashdata("success", " Berhasil Update Data Stok  ".$this->input->post('nama_menu')." !");
            redirect(base_url("menu/stok"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Update Data Stok ! ".validation_errors());
            redirect(base_url("menu/stok"));
        }
    }

    public function tambah()
    {
        $kode = $this->db->query("SELECT * FROM menu ORDER BY id DESC LIMIT 1");
        
        if ($kode->num_rows() > 0) {
            $ps = $kode->row();
            $kode_cus = $ps->id + 1;
        } else {
            $kode_cus = 1;
        }
        
        $this->data = [
            'title_web' => 'Tambah Menu',
            'kode'  	=> 'P000'.$kode_cus,
            'kat'       => $this->db->query('SELECT * FROM kategori WHERE deleted_at IS NULL')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/tambah', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function store()
    {
        $this->form_validation->set_rules("id_kategori", "Id kategori", "required");
        $this->form_validation->set_rules("kode_menu", "Kode menu", "required");
        $this->form_validation->set_rules("nama", "Nama", "required");
        // $this->form_validation->set_rules("harga_pokok", "Harga pokok", "required");
        // $this->form_validation->set_rules("harga_jual", "Harga jual", "required");
        $this->form_validation->set_rules("harga", "Harga", "required");

        if ($this->form_validation->run() != false) {
            $data = [
                'id_kategori'   => xss_protect($this->input->post("id_kategori", true)),
                'kode_menu'     => xss_protect($this->input->post("kode_menu", true)),
                'nama'          => xss_protect($this->input->post("nama", true)),
                // 'harga_pokok'   => xss_protect($this->input->post("harga_pokok", true)),
                // 'harga_jual'    => xss_protect($this->input->post("harga_jual", true)),
                'harga'    => xss_protect($this->input->post("harga", true)),
                'keterangan'    => xss_protect($this->input->post("keterangan", true)),
                // 'stok'          => 0,
                // 'stok_minim'    => (int)$this->input->post("stok_minim"),
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            $upload_foto = $_FILES['gambar']['name'];
            if ($upload_foto) {
                // setting konfigurasi upload
                $nmfile                  = "produk_".time();
                $config['upload_path']   = './assets/image/produk/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name']     = $nmfile;
                // load library upload
                $this->load->library('upload', $config);
                // upload gambar
                if ($this->upload->do_upload('gambar')) {
                    $result1 = $this->upload->data();
                    $result  = array('gambar' => $result1);
                    $data1   = array('upload_data' => $this->upload->data());
                    $this->db->set('gambar', $data1['upload_data']['file_name']);
                } else {
                    $this->session->set_flashdata("failed", " Gagal Insert Data ! ".$this->upload->display_errors());
                    redirect(base_url("menu"));
                }
            } else {
                $this->db->set('gambar', '-');
            }

            $this->db->insert("menu", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("menu"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("menu"));
        }
    }

    public function detail()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Menu ! ");
            redirect(base_url('menu'));
        }
                
        $this->data = [
            'title_web' => 'Detail Menu',
            'edit'		=> $edit,
            'kat'       => $this->db->query('SELECT * FROM kategori WHERE deleted_at IS NULL')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/detail', $this->data);
        $this->load->view('layout/footer', $this->data);
    }
    
    public function edit()
    {
        $id = (int)$this->uri->segment('3');
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $edit = $cek->row();
        } else {
            $this->session->set_flashdata("failed", " Tidak ditemukan data ID dari Menu ! ");
            redirect(base_url('menu'));
        }
                
        $this->data = [
            'title_web' => 'Edit Menu',
            'edit'		=> $edit,
            'kat'       => $this->db->query('SELECT * FROM kategori WHERE deleted_at IS NULL')->result()
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/menu/edit', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function update()
{
    $id = (int)$this->input->post("id");

    $this->form_validation->set_rules("id", "Id", "required");
    $this->form_validation->set_rules("id_kategori", "Id kategori", "required");
    $this->form_validation->set_rules("kode_menu", "Kode menu", "required");
    $this->form_validation->set_rules("nama", "Nama", "required");
    $this->form_validation->set_rules("harga", "Harga", "required");

    if ($this->form_validation->run() != false) {

        $data = [
            'id_kategori' => xss_protect($this->input->post("id_kategori", true)),
            'kode_menu'   => xss_protect($this->input->post("kode_menu", true)),
            'nama'        => xss_protect($this->input->post("nama", true)),
            'harga'       => xss_protect($this->input->post("harga", true)),
            'keterangan'  => xss_protect($this->input->post("keterangan", true)),
        ];

        if (!empty($_FILES['gambar']['name'])) {

            $nmfile = "produk_" . time();

            $config['upload_path']   = './assets/image/produk/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name']     = $nmfile;
            $config['overwrite']     = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {

                $upload = $this->upload->data();

                // simpan nama file ke database
                $data['gambar'] = $upload['file_name'];

                // hapus gambar lama
                $gambar_lama = $this->input->post('gambar_edit');

                if (!empty($gambar_lama) && $gambar_lama != '-') {

                    $file_lama = FCPATH . 'assets/image/produk/' . $gambar_lama;

                    if (file_exists($file_lama)) {
                        unlink($file_lama);
                    }
                }

            } else {

                $this->session->set_flashdata(
                    "failed",
                    "Gagal Upload Gambar!<br>" . $this->upload->display_errors()
                );

                redirect(base_url("menu/edit/".$id));
                return;
            }
        }

        $this->db->where("id", $id);
        $this->db->update("menu", $data);

        $this->session->set_flashdata("success","Berhasil Update Data!");
        redirect(base_url("menu/edit/".$id));

    } else {

        $this->session->set_flashdata(
            "failed",
            "Gagal Update Data! ".validation_errors()
        );

        redirect(base_url("menu/edit/".$id));
    }
}
    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("menu", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $hasil = $cek->row();

            // if ($hasil->gambar !== '-') {
            //     if (file_exists(FCPATH.'assets/image/produk/'.$hasil->gambar)) {
            //         unlink(FCPATH.'assets/image/produk/'.$hasil->gambar);
            //     }
            // }

            $this->db->where("id", $id); // tulis id yang dituju
            // $this->db->delete("menu");
            $this->db->update("menu", ['deleted_at' => date('Y-m-d H:i:s')]);
            
            $this->session->set_flashdata("success", " Berhasil Delete Data ! ");
            redirect(base_url("menu"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("menu"));
        }
    }
}
