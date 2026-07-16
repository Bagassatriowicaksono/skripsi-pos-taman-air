<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        $this->load->model('M_Datatables');
        $this->load->helper('tgl_default');
        $this->load->helper('alert');
        if ($this->session->userdata('masuk_sistem') != true) {
            $url = base_url('login');
            redirect($url);
        }
        cekJamLogin();
    }

    public function index()
    {
        if (!empty((int) $this->input->get('jenis'))) {
            $jn = (int) $this->input->get('jenis');
            if ($jn == 1) {
                $title = 'Daftar Pesanan (Dine in)';
                $date = date('Y-m-d');
            } elseif ($jn == 2) {
                $title = 'Daftar Pesanan (Take away)';
                $date = date('Y-m-d');
            } elseif ($jn == 3) {
                $title = 'Daftar Pesanan (Delivery)';
                $date = date('Y-m-d');
            } else {
                $title = 'Daftar Pesanan (Bayar Nanti)';
                $date = "";
            }
        } else {
            $title = 'Daftar Pesanan';
            $date = date('Y-m-d');
        }

        $data = [
            'title_web' => $title,
            'date' => $date
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/order/daftar', $data);
        $this->load->view('layout/footer', $data);
    }

    public function data_order()
    {
        if ($this->input->method(true) == 'POST'):
            $query = "SELECT customer.nama, login.nama_user, transaksi.* FROM transaksi 
            JOIN customer ON transaksi.customer_id = customer.id 
            JOIN login ON transaksi.kasir_id=login.id";
            $search = [
                'nama',
                'nama_user',
                'no_bon',
                'atas_nama',
                'grandtotal',
                'date',
                'metode',
                'pesanan'
            ];

            $tgl = $this->input->get('tgl') ?? date('Y-m-d');
            $where = [];
            if (!empty((int) $this->input->get('jenis'))) {
                $jn = (int) $this->input->get('jenis');
                if ($jn == 1) {
                    $where['pesanan'] = 'Dine in';
                    $where['date'] = $tgl;
                } elseif ($jn == 2) {
                    $where['pesanan'] = 'Take away';
                    $where['date'] = $tgl;
                } elseif ($jn == 3) {
                    $where['pesanan'] = 'Delivery';
                    $where['date'] = $tgl;
                } elseif ($jn == 4) {
                    $where['metode'] = 'Bayar Nanti';
                }
            } else {
                $where['date'] = $tgl;
            }

            if ($this->session->userdata('ses_level') == 'Admin') {
                $iswhere = null;
            } else {
                $uid = $this->session->userdata('ses_id');
                $iswhere = " transaksi.kasir_id = '$uid' ";
            }

            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function edit()
    {
        $id = (int) $this->uri->segment('3');
        $t = $this->db->query("SELECT customer.nama, customer.hp, login.nama_user, transaksi.* FROM 
                                transaksi JOIN customer ON transaksi.customer_id=customer.id 
                                JOIN login ON transaksi.kasir_id=login.id
                                WHERE transaksi.id = ?", [$id])->row();
        if (!isset($t)) {
            $this->session->set_flashdata("failed", "Data Tidak Tersedia ! ");
            redirect(base_url("order"));
        }
        $tp = $this->db->get_where("transaksi_produk", ['no_bon' => $t->no_bon])->result_array();
        $tp1 = $this->db->get_where("transaksi_produk", ['no_bon' => $t->no_bon])->result();
        $data = [
            'title_web' => 'Edit Order',
            't' => $t,
            'tp' => $tp,
            'tp1' => $tp1,
            'kat' => $this->db->query('SELECT * FROM kategori WHERE deleted_at IS NULL')->result(),
            'pp' => $this->db->get('profil_toko', ['id' => 1])->row()
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/order/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function edit_order()
    {
        $id = $this->input->post('id_order');
        $this->db->where('id', $id);
        $this->db->update('transaksi', ['metode' => 'Bayar Nanti']);
        $this->session->set_flashdata("success", " Berhasil Update Orderan ( Status Bayar Nanti ) ! ");
        redirect(base_url("order/edit/".(int)$id));
    }

    public function updated()
    {
        $no_bon = $this->input->post('no_bon', true);
        $id = $this->input->post('idtrx', true);
        $voucher = $this->input->post('voucher');
        $grandtotal = $this->input->post('grandtotal');
        $kembali = $this->input->post('kembaliBayar');
        $dibayar = $this->input->post('dibayar');

        // Membersihkan input
        $grandtotal = !empty($grandtotal) ? preg_replace('/[^0-9]/', '', $grandtotal) : 0;
        $voucher = !empty($voucher) ? preg_replace('/[^a-zA-Z0-9]/', '', $voucher) : 0;
        $kembali = !empty($kembali) ? preg_replace('/[^0-9]/', '', $kembali) : 0;
        $dibayar = !empty($dibayar) ? preg_replace('/[^0-9]/', '', $dibayar) : 0;

        $hasil_cart = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        if (!empty($hasil_cart)) {
            $total_qty = 0;
            // $grmo = 0;
            $data_jual = array();

            foreach ($hasil_cart as $isi) {
                $kode_menu = $isi['kode_menu'];
                $qty = $isi['qty'];
                $total_qty += $qty;
                // $grmo += $isi['harga_beli'] * $qty;

                $data_jual[] = array(
                    'no_bon' => $no_bon,
                    'kode_menu' => $kode_menu,
                    'nama_menu' => $isi['nama'],
                    'kategori' => $isi['kategori'],
                    'qty' => $qty,
                    // 'harga_beli' => $isi['harga_beli'],
                    // 'harga_jual' => $isi['harga_jual'],
                    'harga' => $isi['harga'],

                    'keterangan' => $isi['keterangan'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'date' => date('Y-m-d'),
                    'periode' => date('Y-m'),
                    'year' => date('Y'),
                );
            }

            // Insert penjualan
            if (!empty($data_jual)) {
                $this->db->insert_batch('transaksi_produk', $data_jual);
            }

            $trxs = $this->db->get_where('transaksi', ['id' => (int) $id])->row();
            $ttl_qty = $total_qty + $trxs->total_qty;
            // $grm = $grmo + $trxs->grandmodal;

            // Update transaksi
            $data_trx = array(
                'pesanan' => xss_protect($this->input->post("pesanan", true)),
                'metode' => xss_protect($this->input->post("metode", true)),
                'diskon' => xss_protect($this->input->post("diskon", true)),
                'pajak' => xss_protect($this->input->post("pajak", true)),
                'voucher' => $voucher,
                // 'grandmodal' => $grm,
                'grandtotal' => $grandtotal,
                'total_qty' => $ttl_qty,
                'dibayar' => $dibayar,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', (int) $id);
            $this->db->update('transaksi', $data_trx);

            // Hapus keranjang
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->delete('keranjang');

            // Redirect dan pesan flash
            if (in_array(xss_protect($this->input->post("metode", true)), 
                ['Tunai', 'Non tunai']
                )
            ) {
                if ($dibayar < $grandtotal) {
                    $data_trx = array('metode' => 'Bayar Nanti');
                    $this->db->where('id', (int) $id);
                    $this->db->update('transaksi', $data_trx);
                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Angka Pembayaran Kurang dari total order ! ");
                    redirect(base_url("order/edit/" . (int) $id));
                    exit;
                }
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/" . (int) $id));
            } else {
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/" . (int) $id));
            }
        } else {
            // Update transaksi tanpa keranjang
            $data_trx = array(
                'pesanan' => xss_protect($this->input->post("pesanan", true)),
                'metode' => xss_protect($this->input->post("metode", true)),
                'diskon' => xss_protect($this->input->post("diskon", true)),
                'pajak' => xss_protect($this->input->post("pajak", true)),
                'voucher' => $voucher,
                'grandtotal' => $grandtotal,
                'dibayar' => $dibayar,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', (int) $id);
            $this->db->update('transaksi', $data_trx);

            // Redirect dan pesan flash
            if (in_array(xss_protect($this->input->post("metode", true)), 
                ['Tunai', 'Non tunai']
                )
            ) {
                if ($dibayar < $grandtotal) {
                    $data_trx = array('metode' => 'Bayar Nanti');
                    $this->db->where('id', (int) $id);
                    $this->db->update('transaksi', $data_trx);
                    $this->session->set_flashdata("failed", " Gagal Update Status Orderan Lunas, Angka Pembayaran Kurang dari total order ! ");
                    redirect(base_url("order/edit/" . (int) $id));
                    exit;
                }
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/" . (int) $id));
            } else {
                $this->session->set_flashdata("success", " Berhasil Update Orderan ! ");
                redirect(base_url("order/edit/" . (int) $id));
            }
        }
    }

    public function add_cart()
    {
        $id = (int) $this->input->post('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id="' . $id . '"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();

        $item = array(
            'id_menu' => $menu->id,
            'kode_menu' => $menu->kode_menu,
            'kategori' => $menu->kategori,
            'nama' => $menu->nama,
            'gambar' => $menu->gambar,
            // 'harga_beli' => $menu->harga_pokok,
            // 'harga_jual' => $menu->harga_jual,
            'harga' => $menu->harga,
            'login_id' => $this->session->userdata('ses_id')
        );

        if (!$keranjang) {
            // Jika item belum ada di keranjang, tambahkan dengan qty = 1
            $item['qty'] = 1;
            $this->db->insert('keranjang', $item);
        } else {
            // Jika item sudah ada di keranjang, update qty
            $this->db->set('qty', $keranjang->qty + 1);
            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang');
        }
    }



    public function cart()
    {
        $keranjang = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        if (isset($keranjang)) {
            $data['items'] = $keranjang;
            $this->load->view('admin/kasir/keranjang', $data);
        } else {
            echo '<center><b class="text-danger">*** Belum ada item yang dipilih ***</b></center>';
        }
    }

    public function update_cart()
    {
        $id = (int) $this->input->get('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id="' . $id . '"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();

        if (isset($keranjang)) {
            $item = [
                'id_menu' => $menu->id,
                'kode_menu' => $menu->kode_menu,
                'kategori' => $menu->kategori,
                'nama' => $menu->nama,
                'gambar' => $menu->gambar,
                'keterangan' => $keranjang->keterangan,
                // 'harga_beli' => $menu->harga_pokok,
                // 'harga_jual' => $menu->harga_jual,
                'harga' => $menu->harga,
            ];

            if ($this->input->post('type') == 'minus') {
                $this->db->set('qty', max(1, $keranjang->qty - 1)); // Ensure qty does not go below 1
            } elseif ($this->input->post('type') == 'keyup') {
                $new_qty = (int) $this->input->post('qt');
                $this->db->set('qty', max(1, $new_qty)); // Ensure qty does not go below 1
            } else {
                $this->db->set('qty', $keranjang->qty + 1);
            }

            $this->db->where('id_menu', $menu->id);
            $this->db->where('login_id', $this->session->userdata('ses_id'));
            $this->db->update('keranjang', $item);
        } else {
            echo '<script>alert("Gagal! Item tidak ditemukan di keranjang.");</script>';
        }
    }




    public function updateket_cart()
    {
        $id = (int) $this->input->get('id');
        $menu = $this->db->query('SELECT kategori.kategori, menu.* FROM menu JOIN kategori ON menu.id_kategori = kategori.id WHERE menu.id="' . (int) $this->input->get('id') . '"')->row();
        $keranjang = $this->db->get_where('keranjang', ['id_menu' => $menu->id, 'login_id' => $this->session->userdata('ses_id')])->row();
        $item = ['keterangan' => $this->input->post('qt')];

        $this->db->where('id_menu', $menu->id);
        $this->db->where('login_id', $this->session->userdata('ses_id'));
        $this->db->update('keranjang', $item);
    }

    public function cart_table()
    {
        $keranjang = $this->db->get_where('keranjang', ['login_id' => $this->session->userdata('ses_id')])->result_array();
        $id = (int) $this->input->get('id');
        $t = $this->db->query("SELECT customer.nama, login.nama_user, transaksi.* FROM 
                                             transaksi JOIN customer ON transaksi.customer_id=customer.id 
                                             JOIN login ON transaksi.kasir_id=login.id
                                             WHERE transaksi.id = ?", [$id])->row();
        $data['t'] = $t;
        if (isset($keranjang)) {
            $data['items'] = $keranjang;
            $this->load->view('admin/order/table', $data);
        } else {
            $data['items'] = [];
            $this->load->view('admin/order/table', $data);
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

    public function hapus($id)
    {
        $cek = $this->db->get_where('transaksi', ['id' => $id])->row();
        if ($cek) {
            $this->db->query("DELETE FROM transaksi WHERE id = ?", [$id]);
            $this->db->query("DELETE FROM transaksi_produk WHERE no_bon = ?", [$cek->no_bon]);
            $this->session->set_flashdata("success", "Berhasil Delete Data!");
        } else {
            $this->session->set_flashdata("error", "Data tidak ditemukan.");
        }
        redirect(base_url("laporan"));
    }

    public function hapus_item()
    {
        $id = (int) $this->input->get('id');
        $order_id = (int) $this->input->get('order_id');
        
        // get transaksi_produk
        $edit = $this->db->get_where('transaksi_produk', ['id' => $id])->row();
        
        if ($edit) {
            // update transaksi
            $this->db->query("UPDATE transaksi SET total_qty = total_qty - ?, 
                                grandtotal = grandtotal - ?, 
                                dibayar = dibayar - ? 
                                WHERE id = ?", [
                $edit->qty, 
                $edit->harga * $edit->qty, 
                $edit->harga * $edit->qty, 
                $order_id
            ]);
            
            // delete transaksi_produk
            $this->db->where('id', $id);
            $this->db->delete('transaksi_produk');
            
            $this->session->set_flashdata("success", "Berhasil Hapus Orderan!");
        } else {
            $this->session->set_flashdata("error", "Item tidak ditemukan.");
        }
        redirect(base_url("order/edit/" . $order_id));
    }

    
    // public function hapus_item()
    // {
    //     $id = (int) $this->input->get('id');
    //     $order_id = (int) $this->input->get('order_id');
        
    //     // get transaksi_produk
    //     $edit = $this->db->get_where('transaksi_produk', ['id' => $id])->row();
        
    //     if ($edit) {
    //         // update transaksi
    //         $this->db->query("UPDATE transaksi SET total_qty = total_qty - ?, 
    //                         -- grandmodal = grandmodal - ?, 
    //                         grandtotal = grandtotal - ?, 
    //                         dibayar = dibayar - ? 
    //                         WHERE id = ?", [
    //             $edit->qty, 
    //             $edit->harga_beli * $edit->qty, 
    //             $edit->harga_jual * $edit->qty, 
    //             $edit->harga_jual * $edit->qty, 
    //             $order_id
    //         ]);
            
    //         // delete transaksi_produk
    //         $this->db->where('id', $id);
    //         $this->db->delete('transaksi_produk');
            
    //         $this->session->set_flashdata("success", "Berhasil Hapus Orderan!");
    //     } else {
    //         $this->session->set_flashdata("error", "Item tidak ditemukan.");
    //     }
    //     redirect(base_url("order/edit/" . $order_id));
    // }

   

}
