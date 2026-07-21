<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        if ($this->session->userdata('masuk_sistem') != true) {
            $url = base_url('login');
            redirect($url);
        }
        cekJamLogin();
    }

    public function index()
    {
        if (!empty($this->input->get('a', true))) {
            $a = htmlentities($this->input->get('a', true));
            $b = htmlentities($this->input->get('b', true));
            $periode = 'Periode ' . time_explode_date(htmlentities($this->input->get('a', true)), 'id') . ' s.d. ' . time_explode_date(htmlentities($this->input->get('b', true)), 'id');
            $iswhere = ' WHERE transaksi.date BETWEEN "' . $a . '" AND "' . $b . '" AND metode != "Bayar Nanti" ';
            $urlexcel = base_url('laporan/excel?a=' . $a . '&b=' . $b);
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir', true);
                $user = $this->db->get_where('login', ['id' => $ks])->row();
                $iswhere .= ' AND kasir_id = ' . $ks . '';
                $periode .= ' Kasir : ' . $user->nama_user;
                $urlexcel .= '&kasir=' . $ks;
            }
        } else {
            $iswhere = ' WHERE metode != "Bayar Nanti" AND periode = "' . date('Y-m') . '" ';
            $urlexcel = base_url('laporan/excel');
            $periode = 'Periode ' . bln('id') . ' ' . date('Y') . ' ';
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir', true);
                $user = $this->db->get_where('login', ['id' => $ks])->row();
                $iswhere .= ' AND kasir_id = ' . $ks . '';
                $periode .= 'Kasir : ' . $user->nama_user;
                $urlexcel .= '?kasir=' . $ks;
            }
        }

        // $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi' . $iswhere)->row();
        $total = $this->db->query('SELECT SUM(transaksi_produk.harga * transaksi_produk.qty) as h, SUM(transaksi_produk.qty) as qty FROM transaksi_produk JOIN transaksi ON transaksi_produk.no_bon = transaksi.no_bon ' . $iswhere)->row();

        $data = [
            'title_web' => 'Laporan Penjualan',
            'periode' => $periode,
            'total' => $total,
            'urlexcel' => $urlexcel
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function data_order()
    {
        if ($this->input->method(true) == 'POST'):
            $query = "SELECT customer.nama, login.nama_user, transaksi.* FROM transaksi JOIN customer ON transaksi.customer_id = customer.id 
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
            if ($this->session->userdata('ses_level') == 'Admin') {
                $where = null;
            } else {
                $where = array('transaksi.kasir_id' => $this->session->userdata('ses_id'));
            }

            if (!empty($this->input->get('a', true))) {
                $a = htmlentities($this->input->get('a', true));
                $b = htmlentities($this->input->get('b', true));
                if ($this->input->get('kasir', true)) {
                    $ks = $this->input->get('kasir', true);
                    $iswhere = 'transaksi.date BETWEEN "' . $a . '" AND "' . $b . '" AND kasir_id ="' . $ks . '"';
                } else {
                    $iswhere = 'transaksi.date BETWEEN "' . $a . '" AND "' . $b . '"';
                }
            } else {
                $iswhere = ' periode = "' . date('Y-m') . '"';
                if ($this->input->get('kasir', true)) {
                    $ks = $this->input->get('kasir', true);
                    $iswhere .= ' AND kasir_id ="' . $ks . '" ';
                }
            }

            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function excel()
    {
        $query = "SELECT customer.nama, login.nama_user, transaksi.* FROM transaksi 
                  JOIN customer ON transaksi.customer_id = customer.id 
                  JOIN login ON transaksi.kasir_id=login.id";

        if (!empty($this->input->get('a', true))) {
            $a = htmlentities($this->input->get('a', true));
            $b = htmlentities($this->input->get('b', true));
            $periode = 'Periode ' . time_explode_date(htmlentities($this->input->get('a', true)), 'id') . ' s.d. ' . time_explode_date(htmlentities($this->input->get('b', true)), 'id');
            $iswhere = ' WHERE transaksi.date BETWEEN "' . $a . '" AND "' . $b . '" AND metode != "Bayar Nanti" ';
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir', true);
                $user = $this->db->get_where('login', ['id' => $ks])->row();
                $iswhere .= ' AND kasir_id = ' . $ks . '';
                $periode .= ' Kasir : ' . $user->nama_user;
            }
        } else {
            $iswhere = ' WHERE metode != "Bayar Nanti" AND periode = "' . date('Y-m') . '" ';
            $periode = 'Periode ' . bln('id') . ' ' . date('Y') . ' ';
            if ($this->input->get('kasir')) {
                $ks = $this->input->get('kasir', true);
                $user = $this->db->get_where('login', ['id' => $ks])->row();
                $iswhere .= ' AND kasir_id = ' . $ks . '';
                $periode .= 'Kasir : ' . $user->nama_user;
            }
        }

        $transaksi = $this->db->query($query . $iswhere)->result();

        $data = [
            'transaksi' => $transaksi,
            'periode' => $periode,
        ];

        $this->load->view('admin/laporan/excel', $data);
    }

    // public function cash()
    // {
    //     $m = $this->input->get('m', true) ?? date('m');
    //     $y = $this->input->get('y', true) ?? date('Y');
    //     $iswhere = ' WHERE periode = "' . $y . '-' . $m . '" ';
    //     $periode = 'Periode ' . bulan($m, 'id') . ' ' . $y;

    //     $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi ' . $iswhere . ' AND transaksi.status != "Bayar Nanti"')->row();
    //     $data = [
    //         'title_web' => 'Cash Flow ',
    //         'periode' => $periode,
    //         'total' => $total,
    //         'month' => $m,
    //         'year' => $y,
    //         'keuangan' => $this->db->query('SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
    //                         FROM keuangan_lainnya 
    //                         JOIN keuangan_ledger 
    //                         ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger ' . $iswhere)->result()
    //     ];

    //     $this->load->view('layout/header', $data);
    //     $this->load->view('admin/laporan/cash', $data);
    //     $this->load->view('layout/footer', $data);
    // }

    // public function pdf()
    // {
    //     // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
    //     $this->load->library('pdfgenerator');
    //     $m = $this->input->get('m', true) ?? date('m');
    //     $y = $this->input->get('y', true) ?? date('Y');
    //     $iswhere = ' WHERE periode = "' . $y . '-' . $m . '"';
    //     $periode = 'Periode ' . bulan($m, 'id') . ' ' . $y;

    //     $total = $this->db->query('SELECT SUM(grandtotal) as gr, SUM(grandmodal) as gm, SUM(total_qty) as qty FROM transaksi' . $iswhere . ' AND transaksi.status != "Bayar Nanti"')->row();
    //     // title dari pdf
    //     $data['title_pdf'] = 'Cash Flow ' . $periode;
    //     $data['keuangan'] = $this->db->query('SELECT keuangan_ledger.keterangan as ket, keuangan_lainnya.* 
    //                         FROM keuangan_lainnya 
    //                         JOIN keuangan_ledger 
    //                         ON keuangan_lainnya.no_ledger = keuangan_ledger.no_ledger ' . $iswhere)->result();
    //     $data['periode'] = $periode;
    //     $data['total'] = $total;
    //     // filename dari pdf ketika didownload
    //     $file_pdf = 'laporan_cash_flow_' . date('Y-m-d');
    //     // setting paper
    //     $paper = 'A4';
    //     //orientasi paper potrait / landscape
    //     $orientation = "portrait";
    //     $html = $this->load->view('admin/laporan/pdf', $data, true);
    //     // run dompdf
    //     $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    // }

    // laporan perproduk
    public function produk()
    {
        if (!empty($this->input->get('nama', true))) {
            $nama = ' AND nama_menu LIKE "%' . $this->input->get('nama', true) . '%"';
        } else {
            $nama = '';
        }

        if ($this->session->userdata('ses_level') == 'Admin') {
            $auth = '';
        } else {
            $uid = $this->session->userdata('ses_id');
            $auth = " AND transaksi.kasir_id = $uid";
        }

        if (!empty($this->input->get('a', true))) {
            $a = localToTimeStamp(htmlentities($this->input->get('a', true)));
            $b = localToTimeStamp(htmlentities($this->input->get('b', true)));
            $iswhere = 'WHERE transaksi_produk.created_at BETWEEN "' . $a . '" AND "' . $b . '" ' . $nama . " " . $auth;
            $periode = 'Periode ' . $a . ' s.d. ' . $b;
            $urlexcel = base_url('laporan/produk_excel?a=' . $a . '&b=' . $b);
        } else {
            $iswhere = ' WHERE transaksi_produk.periode = "' . date('Y-m') . '" ' . $nama . " " . $auth;
            $periode = 'Periode ' . bln('id') . ' ' . date('Y');
            $urlexcel = base_url('laporan/produk_excel');
        }

        if ($this->input->get('kasir')) {
            $ks = $this->input->get('kasir', true);
            $user = $this->db->get_where('login', ['id' => $ks])->row();
            $periode .= ' Kasir : ' . $user->nama_user;
            if (!empty($this->input->get('a', true))) {
                $urlexcel .= '&kasir=' . $ks;
            } else {
                $urlexcel .= '?kasir=' . $ks;
            }
        }
        // $total = $this->db->query('SELECT SUM(transaksi_produk.harga_beli * qty) as hb, 
        //                             SUM(transaksi_produk.harga_jual* qty) as hj, 
        //                             SUM(transaksi_produk.qty) as qty,
        //                             transaksi.kasir_id  FROM transaksi_produk 
        //                             JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon ' . $iswhere)->row();

       $total = $this->db->query(' SELECT SUM(transaksi_produk.harga * transaksi_produk.qty) AS h, SUM(transaksi_produk.qty) AS qty FROM transaksi_produk JOIN transaksi ON transaksi_produk.no_bon = transaksi.no_bon' . $iswhere)->row();


        $data = [
            'title_web' => 'Laporan Menu',
            'periode' => $periode,
            'total' => $total,
            'urlexcel' => $urlexcel
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/laporan/produk', $data);
        $this->load->view('layout/footer', $data);
    }

    public function data_produk()
    {
        if ($this->input->method(true) == 'POST'):
            $query = "SELECT customer.nama, login.nama_user, transaksi.atas_nama, transaksi.pesanan,transaksi.metode,transaksi.customer_id, 
                      transaksi_produk.* FROM transaksi_produk 
                      JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon 
                      JOIN customer ON transaksi.customer_id = customer.id 
                      JOIN login ON transaksi.kasir_id=login.id";
            $search = [
                'kode_menu',
                'nama',
                'nama_user',
                'transaksi_produk.no_bon',
                'atas_nama',
                'pesanan',
                'nama_menu',
                'kategori',
            ];

            $where = null;
            if (!empty($this->input->get('kasir', true))) {
                $where = array('transaksi.kasir_id' => $this->input->get('kasir', true));
            }

            if (!empty($this->input->get('a', true))) {
                $a = localToTimeStamp(htmlentities($this->input->get('a', true)));
                $b = localToTimeStamp(htmlentities($this->input->get('b', true)));
                $iswhere = 'transaksi_produk.created_at BETWEEN "' . $a . '" AND "' . $b . '"';
            } else {
                $iswhere = ' transaksi_produk.periode = "' . date('Y-m') . '"';
            }

            header('Content-Type: application/json');
            echo $this->M_Datatables->get_tables_query($query, $search, $where, $iswhere);
        endif;
    }

    public function produk_excel()
    {
        $query = "SELECT customer.nama, login.nama_user, transaksi.atas_nama, transaksi.pesanan,transaksi.metode,transaksi.customer_id,
                  transaksi_produk.* FROM transaksi_produk 
                  JOIN transaksi ON transaksi_produk.no_bon=transaksi.no_bon 
                  JOIN customer ON transaksi.customer_id = customer.id 
                  JOIN login ON transaksi.kasir_id=login.id";

        if (!empty($this->input->get('a', true))) {
            $a = localToTimeStamp(htmlentities($this->input->get('a', true)));
            $b = localToTimeStamp(htmlentities($this->input->get('b', true)));
            $iswhere = ' WHERE transaksi_produk.created_at BETWEEN "' . $a . '" AND "' . $b . '"';
            $periode = 'Periode ' . $a . ' s.d. ' . $b;
        } else {
            $iswhere = ' WHERE transaksi_produk.periode  = "' . date('Y-m') . '"';
            $periode = 'Periode ' . bln('id') . ' ' . date('Y');
        }

        if ($this->input->get('kasir')) {
            $ks = $this->input->get('kasir', true);
            $user = $this->db->get_where('login', ['id' => $ks])->row();
            $periode .= ' Kasir : ' . $user->nama_user;
            $iswhere .= ' AND transaksi.kasir_id  = "' . $this->input->get('kasir', TRUE) . '"';
        }

        $transaksi = $this->db->query($query . $iswhere)->result();

        $data = [
            'transaksi' => $transaksi,
            'periode' => $periode,
        ];

        $this->load->view('admin/laporan/produk_excel', $data);
    }

    // public function terlaris()
    // {
    //     if (!empty($this->input->get('a', true))) {
    //         $a = htmlentities($this->input->get('a', true));
    //         $b = htmlentities($this->input->get('b', true));
    //         $periode = 'Periode ' . time_explode_date(htmlentities($this->input->get('a', true)), 'id') . ' s.d. ' . time_explode_date(htmlentities($this->input->get('b', true)), 'id');
    //         $urlexcel = base_url('laporan/laris_excel?a=' . $a . '&b=' . $b);
    //     } else {
    //         $periode = 'Periode ' . bln('id') . ' ' . date('Y');
    //         $urlexcel = base_url('laporan/laris_excel');
    //     }

    //     $data = [
    //         'title_web' => 'Laporan',
    //         'periode' => $periode,
    //         'urlexcel' => $urlexcel
    //     ];

    //     $this->load->view('layout/header', $data);
    //     $this->load->view('admin/laporan/laris', $data);
    //     $this->load->view('layout/footer', $data);
    // }

    public function laris()
    {
        if (!empty($this->input->get('a', true))) {
            $a = htmlentities($this->input->get('a', true));
            $b = htmlentities($this->input->get('b', true));
            $periode = 'Periode ' . time_explode_date($a, 'id') . ' s.d. ' . time_explode_date($b, 'id');
            $urlexcel = base_url('laporan/laris_excel?a=' . $a . '&b=' . $b);
            $this->db->where('date >=', $a);
            $this->db->where('date <=', $b);
        } else {
            $periode = 'Periode ' . bln('id') . ' ' . date('Y');
            $urlexcel = base_url('laporan/laris_excel');
            $this->db->where('MONTH(date)', date('m'));
            $this->db->where('YEAR(date)', date('Y'));
        }

        // $this->db->select('kode_menu, nama_menu, kategori, SUM(qty) as qty_terjual, harga, SUM(qty * harga) as total_penjualan');
        $this->db->select('kode_menu, nama_menu, kategori, SUM(qty) as qty_terjual');
        $this->db->group_by('kode_menu, nama_menu, kategori');
        $this->db->order_by('qty_terjual', 'DESC');
        $query = $this->db->get('transaksi_produk');
        $transaksi = $query->result();

        $data = [
            'title_web' => 'Menu Terlaris',
            'periode' => $periode,
            'urlexcel' => $urlexcel,
            'transaksi' => $transaksi
        ];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/laporan/laris', $data);
        $this->load->view('layout/footer', $data);
    }
   

}
