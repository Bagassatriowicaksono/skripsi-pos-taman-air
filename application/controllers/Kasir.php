<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        $this->load->library('pagination');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url=base_url('login');
            redirect($url);
        }
        cekJamLogin();
    }

    public function index()
    {
        $data = [
            'title_web' => 'Transaksi',
            'kat'       => $this->db->query('SELECT * FROM kategori WHERE deleted_at IS NULL')->result(),
            'no_bon'    => generateNumber('transaksi', 'no_bon'),
            'pp'		=> $this->db->get('profil_toko', ['id' => 1])->row(),
            'halperpage'=> 12
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/kasir/index', $data);
        $this->load->view('layout/footer', $data);
    }

    // public function store()
    // {
    //     $no_bon = $this->input->post('no_bon', true);

    //     $cekNoBon = $this->db->query('SELECT no_bon FROM transaksi WHERE no_bon = ?', [$no_bon]);
    //     if ($cekNoBon->num_rows() > 0) {
    //         $no_bon = generateNumber('transaksi', 'no_bon');
    //     }

    //     $cekNoUrut = $this->db->query("SELECT count(*) as jml FROM transaksi WHERE date = ?", [date('Y-m-d')])->row();
    //     $noUrut = $cekNoUrut->jml + 1;

    //     $voucher    = $this->input->post('voucher', true);
    //     $grandtotal = $this->input->post('grandtotal', true);
    //     $kembali    = $this->input->post('kembaliBayar', true);
    //     $dibayar    = $this->input->post('dibayar', true);

    //     if (!empty($grandtotal)) {
    //         $grandtotal = preg_replace('/[^a-zA-Z0-9\']/', '', $grandtotal);
    //     } else {
    //         $grandtotal = 0;
    //     }

    //     if (!empty($voucher)) {
    //         $voucher = preg_replace('/[^a-zA-Z0-9\']/', '', $voucher);
    //     } else {
    //         $voucher = 0;
    //     }

    //     if (!empty($kembali)) {
    //         $kembali = preg_replace('/[^a-zA-Z0-9\']/', '', $kembali);
    //     } else {
    //         $kembali = 0;
    //     }

    //     if (!empty($dibayar)) {
    //         $dibayar = preg_replace('/[^a-zA-Z0-9\']/', '', $dibayar);
    //     } else {
    //         $dibayar = 0;
    //     }

    //     if (in_array(
    //         xss_protect($this->input->post("status", true)),
    //         ['Tunai', 'Non tunai']
    //     )) {
    //         if ($dibayar < $grandtotal) {
    //             echo 'Kurang';
    //             exit;
    //         }
    //     }

    //     $hasil_cart = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
    //     $total_qty = 0;
    //     $grandmodal = 0;
    //     foreach ($hasil_cart as $isi) {
    //         $kode_menu = $isi['kode_menu'];
    //         $qty = $isi['qty'];
    //         $total_qty += $qty;

    //         $data_jual[] = array(
    //             'no_bon'        => $no_bon,
    //             'kode_menu'     => $kode_menu,
    //             'nama_menu'     => $isi['nama'],
    //             'kategori'      => $isi['kategori'],
    //             'qty'           => $qty,
    //             'harga_beli'    => $isi['harga_beli'],
    //             'harga_jual'    => $isi['harga_jual'],
    //             'keterangan'    => $isi['keterangan'],
    //             'created_at'    => date('Y-m-d H:i:s'),
    //             'date'          => date('Y-m-d'),
    //             'periode'       => date('Y-m'),
    //             'year'          => date('Y'),
    //         );
    //         $grandmodal += $isi['harga_beli'] * $qty;
    //     }

    //     // insert penjualan
    //     $total_array = count($data_jual);
    //     if ($total_array != 0) {
    //         $this->db->insert_batch('transaksi_produk', $data_jual);
    //     }

    //     // insert transaksi
    //     $data_trx = array(
    //         'no_bon'        => $no_bon,
    //         'urut'          => $noUrut,
    //         'kasir_id'      => $this->session->userdata('ses_id'),
    //         'customer_id'   => xss_protect($this->input->post("customer_id", true)),
    //         'atas_nama'     => xss_protect($this->input->post("atas_nama", true)),
    //         'pesanan'       => xss_protect($this->input->post("pesanan", true)),
    //         'status'        => xss_protect($this->input->post("status", true)),
    //         'diskon'        => xss_protect($this->input->post("diskon", true)),
    //         'pajak'         => xss_protect($this->input->post("pajak", true)),
    //         'voucher'       => $voucher,
    //         'grandmodal'    => $grandmodal,
    //         'grandtotal'    => $grandtotal,
    //         'total_qty'     => $total_qty,
    //         'dibayar'       => $dibayar,
    //         'created_at'    => date('Y-m-d H:i:s'),
    //         'date'          => date('Y-m-d'),
    //         'periode'       => date('Y-m'),
    //         'year'          => date('Y'),
    //     );
    //     $this->db->insert('transaksi', $data_trx);

    //     $this->db->where('login_id', $this->session->userdata('ses_id'));
    //     $this->db->delete('keranjang');

    //     echo $no_bon;
    // }


    public function store()
    {
        $no_bon = $this->input->post('no_bon', true);

        $cekNoBon = $this->db->query('SELECT no_bon FROM transaksi WHERE no_bon = ?', [$no_bon]);
        if ($cekNoBon->num_rows() > 0) {
            $no_bon = generateNumber('transaksi', 'no_bon');
        }

        $cekNoUrut = $this->db->query("SELECT count(*) as jml FROM transaksi WHERE date = ?", [date('Y-m-d')])->row();
        $noUrut = $cekNoUrut->jml + 1;

        $voucher    = $this->input->post('voucher', true);
        $grandtotal = $this->input->post('grandtotal', true);
        $kembali    = $this->input->post('kembaliBayar', true);
        $dibayar    = $this->input->post('dibayar', true);

        if (!empty($grandtotal)) {
            $grandtotal = preg_replace('/[^a-zA-Z0-9\']/', '', $grandtotal);
        } else {
            $grandtotal = 0;
        }

        if (!empty($voucher)) {
            $voucher = preg_replace('/[^a-zA-Z0-9\']/', '', $voucher);
        } else {
            $voucher = 0;
        }

        if (!empty($kembali)) {
            $kembali = preg_replace('/[^a-zA-Z0-9\']/', '', $kembali);
        } else {
            $kembali = 0;
        }

        if (!empty($dibayar)) {
            $dibayar = preg_replace('/[^a-zA-Z0-9\']/', '', $dibayar);
        } else {
            $dibayar = 0;
        }

        if (in_array(
            xss_protect($this->input->post("metode", true)),
            ['Tunai', 'Non tunai']
        )) {
            if ($dibayar < $grandtotal) {
                echo 'Kurang';
                exit;
            }
        }

        $hasil_cart = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        $total_qty = 0;
        foreach ($hasil_cart as $isi) {
            $kode_menu = $isi['kode_menu'];
            $qty = $isi['qty'];
            $total_qty += $qty;

            $harga = $isi['harga']; // Menggunakan harga_jual sebagai variabel harga

            $data_jual[] = array(
                'no_bon'        => $no_bon,
                'kode_menu'     => $kode_menu,
                'nama_menu'     => $isi['nama'],
                'kategori'      => $isi['kategori'],
                'qty'           => $qty,
                'harga'         => $harga,
                'keterangan'    => $isi['keterangan'],
                'created_at'    => date('Y-m-d H:i:s'),
                'date'          => date('Y-m-d'),
                'periode'       => date('Y-m'),
                'year'          => date('Y'),
            );
        }

        // insert penjualan
        $total_array = count($data_jual);
        if ($total_array != 0) {
            $this->db->insert_batch('transaksi_produk', $data_jual);
        }

        // insert transaksi
        $data_trx = array(
            'no_bon'        => $no_bon,
            'urut'          => $noUrut,
            'kasir_id'      => $this->session->userdata('ses_id'),
            'customer_id'   => xss_protect($this->input->post("customer_id", true)),
            'atas_nama'     => xss_protect($this->input->post("atas_nama", true)),
            'pesanan'       => xss_protect($this->input->post("pesanan", true)),
            'metode'        => xss_protect($this->input->post("metode", true)),
            'diskon'        => xss_protect($this->input->post("diskon", true)),
            'pajak'         => xss_protect($this->input->post("pajak", true)),
            'voucher'       => $voucher,
            'grandtotal'    => $grandtotal,
            'total_qty'     => $total_qty,
            'dibayar'       => $dibayar,
            'created_at'    => date('Y-m-d H:i:s'),
            'date'          => date('Y-m-d'),
            'periode'       => date('Y-m'),
            'year'          => date('Y'),
        );
        $this->db->insert('transaksi', $data_trx);

        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->delete('keranjang');

        echo $no_bon;
    }



    public function show()
    {
        $no_bon = $this->input->get('id');
        $t  = $this->db->query("SELECT customer.nama, customer.hp, transaksi.* FROM transaksi JOIN customer ON transaksi.customer_id=customer.id WHERE transaksi.no_bon = ?", [$no_bon])->row();
        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $no_bon])->result();
        $this->data = [
            't'  => $t,
            'tp' => $tp,
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('admin/kasir/cetak', $this->data);
    }

    public function print()
    {
        $id         = $this->input->post('id', true);
        $os         = $this->input->post('os', true);
        $print      = $this->input->post('print', true);
        $driver     = $this->input->post('driver', true);
        $cetak      = $this->input->post('cetak', true);
        $no_bon     = $this->input->get('id', true);
        $t          = $this->db->query("SELECT customer.nama, transaksi.* FROM transaksi JOIN customer ON transaksi.customer_id=customer.id WHERE transaksi.no_bon = ?", [$no_bon])->row();

        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $no_bon])->result();
        $this->data = [
            't'  => $t,
            'tp' => $tp,
            'cetak' => $cetak,
            'os' => $os,
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('admin/kasir/print', $this->data);
    }

    public function add_cart()
    {
        $id = (int)$this->input->post('id');

        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id="'.(int)$this->input->post('id').'"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        $item = array(
            'id_menu'     => $menu->id,
            'kode_menu'   => $menu->kode_menu,
            'kategori'    => $menu->kategori,
            'nama'        => $menu->nama,
            'gambar'      => $menu->gambar,
            // 'harga_beli'  => $menu->harga_pokok,
            // 'harga_jual'  => $menu->harga_jual,
            'harga'  => $menu->harga,
            'login_id'    => $this->session->userdata('ses_id')
        );

        if (!$keranjang) {
            $this->db->set('qty', 1);
            $this->db->insert('keranjang', $item);
            echo json_encode(['metode' => 'sukses']);
        } else {
            $this->db->set('qty', $keranjang->qty + 1);
            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
            echo json_encode(['metode' => 'sukses']);
        }
    }

    public function cart()
    {
        $sql = "SELECT * FROM keranjang WHERE login_id = ? ORDER BY id ASC";
        $keranjang = $this->db->query($sql, [$this->session->userdata('ses_id')])->result_array();
        if (isset($keranjang)) {
            $this->data['items'] = $keranjang;
            $this->load->view('admin/kasir/keranjang', $this->data);
        } else {
            echo '<center><b class="text-danger">*** Belum ada item yang dipilih ***</b></center>';
        }
    }

    public function update_cart()
    {
        $id = (int)$this->input->get('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id="'.(int)$this->input->get('id').'"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();

        if (isset($keranjang)) {
            $item = [
                'id_menu'       => $menu->id,
                'kode_menu'     => $menu->kode_menu,
                'kategori'      => $menu->kategori,
                'nama'          => $menu->nama,
                'gambar'        => $menu->gambar,
                'keterangan'    => $keranjang->keterangan,
                // 'harga_beli'    => $menu->harga_pokok,
                // 'harga_jual'    => $menu->harga_jual,
                'harga'    => $menu->harga,

            ];
            
            if ($this->input->post('type') == 'minus') {
                $this->db->set('qty', $keranjang->qty - 1);
            } elseif ($this->input->post('type') == 'keyup') {
                if ($this->input->post('qt') > 0) {
                    $this->db->set('qty', $this->input->post('qt'));
                } else {
                    $this->db->set('qty', 1);
                }
            } else {
                $this->db->set('qty', $keranjang->qty + 1);
            }

            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Gagal !",
                    text: "Item tidak ditemukan di keranjang.",
                })</script>';
        }
    }

    public function updateket_cart()
    {
        $id         = (int)$this->input->get('id');
        $menu       = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id= ?', [(int)$this->input->get('id')])->row();
        $keranjang  = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        $item = [
            'keterangan' => $this->input->post('qt'),
        ];

        $this->db->where('id_menu', $menu->id);
        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->update('keranjang', $item);
    }

    public function cart_table()
    {
        $keranjang = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        if (isset($keranjang)) {
            $this->data['items'] = $keranjang;
            $this->load->view('admin/kasir/table', $this->data);
        } else {
            echo '<center><b class="text-danger">*** Belum ada item yang dipilih ***</b></center>';
        }
    }


    public function del_cart()
    {
        $id = $this->input->post('id_menu');
        $this->db->where('id_menu', $id);
        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->delete('keranjang');
        // redirect('jual/tambah');
    }
}
