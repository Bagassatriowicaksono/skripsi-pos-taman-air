<?php
/**
 *
 * Author    : Fauzan Falah ( Anang )
 * File      : alert_cms_helper.php
 * Web Name  : Kasir Cafe
 * Version   : v1.0.0
 * Website   : https://www.codekop.com/
 * License   : MIT
 * Framework : CodeIgniter v3.1.11
 * Facebook  : https://www.facebook.com/fauzan.falah2
 * HP/WA	 : 089618173609
 * E-mail 	 : codekop157@gmail.com / fauzancodekop@gmail.com / fauzan1892@codekop.com
 * Ket       : Berisi tentang fungsi-fungsi alert alert yg digunakan
 *
 *
 */

if (!function_exists('alert_failed')) {
    function alert_failed($html)
    {
        $alert = '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ' . $html . '
                    </div>';
        return $alert;
    }
}

if (!function_exists('alert_success')) {
    function alert_success($html)
    {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ' . $html . '
                    </div>';
        return $alert;
    }
}

function cek_id($table, $col, $val)
{
    $sql = "SELECT * FROM $table WHERE $col = ? ORDER BY id DESC LIMIT 1";
    $ci =& get_instance();
    $cek = $ci->db->query($sql, [$val])->num_rows();
    if ($cek > 0) {
        return time();
    } else {
        return $val;
    }
}

function getTableNullDeleted($table, $where)
{
    $sql = "SELECT * FROM $table WHERE $where ORDER BY id DESC LIMIT 1";
    $ci =& get_instance();
    $cek = $ci->db->query($sql)->result();
    return $cek;
}

if (!function_exists('generateNumber')) {
    function generateNumber($table, $column)
    {
        $ci =& get_instance();
        $ci->load->database();
        $sql = 'SELECT DATE_FORMAT(NOW(),"%Y%m") ym, MAX(' . $column . ') id FROM ' . $table;
        $query = $ci->db->query($sql);
        $row = $query->row();
        $newNo = 0;
        $currNo = 0;
        $currYearMonth = $row->ym;
        ;
        $currNo = $row->id;
        if (!isset($currNo) || $currNo == 0 || $currNo == '0') {
            $newNo = $currYearMonth * 10000 + 1;
        } else {
            $strCurrNo = $currNo;
            settype($strCurrNo, "string");
            $strCurrYearMonth = $currYearMonth;
            settype($strCurrYearMonth, "string");

            if (substr($strCurrNo, 0, 6) == $strCurrYearMonth) {
                $newNo = $currNo + 1;
            } else if (substr($strCurrNo, 0, 6) > $strCurrYearMonth) {
                $newNo = $currNo + 1;
            } else {
                $newNo = $currYearMonth * 10000 + 1;
            }
        }
        return $newNo;
    }
}

if (!function_exists('getRupiah')) {
    function getRupiah($number, $rupiah = 'Rp')
    {
        return $rupiah . ' ' . number_format((float) $number ?? 0, 0, '.', '.');
    }
}

if (!function_exists('xss_protect')) {
    function xss_protect($request)
    {
        return $request;
    }
}

if (!function_exists('generateNumberCode')) {
    function generateNumberCode($kode, $table, $column)
    {
        $ci =& get_instance();
        $ci->load->database();
        $db = $ci->db;
        $query = $db->query('SELECT ' . $column . ' AS id_table FROM ' . $table . ' ORDER BY ' . $table . '.id DESC LIMIT 1');
        $row = $query->row();
        $newNo = 0;
        $currNo = 0;
        $currYearMonth = date('ymd');
        if ($row) {
            $currKode = $row->id_table;
            $currEx = explode($kode, $currKode);
            if (isset($currEx[1])) {
                $currNo = $currEx[1];
            } else {
                $currNo = $currEx[0];
            }
        }
        if ($currNo == 0) {
            $newNo = 1;
        } else {
            $strCurrNo = $currNo;
            settype($strCurrNo, "string");
            $strCurrYearMonth = $currYearMonth;
            settype($strCurrYearMonth, "string");

            if (substr($strCurrNo, 0, 6) == $strCurrYearMonth) {
                $currNoEx = explode('-', $currNo);
                if (isset($currNoEx[1])) {
                    $newNo = $currNoEx[1] + 1;
                } else {
                    $currNo = 1;
                }
            } else {
                $newNo = 1;
            }
        }
        $kodeFinal = $kode . $currYearMonth . '-' . $newNo;
        return $kodeFinal;
    }
}
