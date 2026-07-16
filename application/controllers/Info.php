<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Info extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
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
        $this->data = [
            'title_web' => 'Pengaturan Toko',
            'edit'     => $this->db->get_where('profil_toko', ['id' => 1])->row(),
        ];

        $this->load->view('layout/header', $this->data);
        $this->load->view('admin/info/index', $this->data);
        $this->load->view('layout/footer', $this->data);
    }

    public function update()
    {
        $data = [
            'nama_toko' => xss_protect($this->input->post("nama_toko", true)),
            'alamat_toko' => xss_protect($this->input->post("alamat_toko", true)),
            'telepon_toko' => xss_protect($this->input->post("telepon_toko", true)),
            'email_toko' => xss_protect($this->input->post("email_toko", true)),
            'pemilik_toko' => xss_protect($this->input->post("pemilik_toko", true)),
            'website_toko' => xss_protect($this->input->post("website_toko", true)),
        ];

        $this->db->where("id", 1); // ubah id dan postnya
        $this->db->update("profil_toko", $data);
        $this->session->set_flashdata("success", " Berhasil Update Data Informasi Toko ! ");
        redirect(base_url("info"));
    }

    public function print()
    {
        $upload_foto = $_FILES['gambar']['name'];
        if ($upload_foto) {
            // setting konfigurasi upload
            $nmfile = "logo_".time();
            $config['upload_path'] = './assets/image/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $nmfile;
            // load library upload
            $this->load->library('upload', $config);
            // upload gambar
            if ($this->upload->do_upload('gambar')) {
                $result1 = $this->upload->data();
                $result = array('gambar'=>$result1);
                $data1 = array('upload_data' => $this->upload->data());
                $this->db->set('driver', $data1['upload_data']['file_name']);
            } else {
                $this->session->set_flashdata("failed", " Gagal Update Data ! ".$this->upload->display_errors());
                redirect(base_url("info"));
            }
        } else {
            $this->db->set('driver', $this->input->post("driver2", true));
        }
        $pajakDef = $this->input->post("pajak_default", true);
        if($this->input->post("pajak", true) == '0') {
            $pajakDef = 0;
        }
        $data = [
            'os' => xss_protect($this->input->post("os", true)),
            'print' => xss_protect($this->input->post("print", true)),
            'print_default' => xss_protect($this->input->post("print_default", true)),
            'footer_struk' => xss_protect($this->input->post("footer_struk", true)),
            'pajak' => xss_protect($this->input->post("pajak", true)),
            'voucher' => xss_protect($this->input->post("voucher", true)),
            'diskon' => xss_protect($this->input->post("diskon", true)),
            'jam_awal' => xss_protect($this->input->post("jam_awal", true)),
            'jam_akhir' => xss_protect($this->input->post("jam_akhir", true)),
            'pajak_default' => $pajakDef
        ];

        $this->db->where("id", 1); // ubah id dan postnya
        $this->db->update("profil_toko", $data);
        $this->session->set_flashdata("success", " Berhasil Update Data Pengaturan Sistem Print dan Kasir ! ");
        redirect(base_url("info"));
    }
}
