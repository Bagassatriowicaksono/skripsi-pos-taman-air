<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Midtrans\Config;
use Midtrans\Snap;

class Midtrans
{
    public function __construct()
    {
        $CI =& get_instance();

        // Load konfigurasi Midtrans
        $CI->config->load('midtrans');

        Config::$serverKey = $CI->config->item('server_key');
        Config::$clientKey = $CI->config->item('client_key');

        Config::$isProduction = $CI->config->item('is_production');
        Config::$isSanitized = $CI->config->item('is_sanitized');
        Config::$is3ds = $CI->config->item('is_3ds');
    }

    public function getSnapToken($params)
    {
        return Snap::getSnapToken($params);
    }
}