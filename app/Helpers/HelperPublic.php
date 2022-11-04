<?php

namespace App\Helpers;

class HelperPublic
{
    public static function helpResponse($code, $data = [], $msg = null, $status = null)
    {
        switch ($code) {
            case '200':
                $s = 'OK';
                $m = 'Sukses';
                break;
            case '201':
                $s = 'Created';
                $m = 'Data berhasil dibuat';
                break;
            case '202':
                $s = 'Saved';
                $m = 'Data berhasil disimpan';
                break;
            case '204':
                $s = 'No Content';
                $m = 'Data tidak ditemukan';
                break;
            case '304':
                $s = 'Not Modified';
                $m = 'Data gagal disimpan';
                break;
            case '400':
                $s = 'Bad Request';
                $m = 'Fungsi tidak ditemukan';
                break;
            case '401':
                $s = 'Unauthorized';
                $m = 'Silahkan login terlebih dahulu';
                break;
            case '402':
                $s = 'Payment Needed';
                $m = 'User harus melakukan pembayaran terlebih dahulu';
                break;
            case '403':
                $s = 'Forbidden';
                $m = 'Anda tidak dapat mengakses halaman ini, silahkan hubungi Administrator';
                break;
            case '404':
                $s = 'Not Found';
                $m = 'Halaman tidak ditemukan';
                break;
            case '405':
                $s = 'Method Not Allowed';
                $m = 'Metode request tidak diizinkan';
                break;
            case '414':
                $s = 'Request URI Too Long';
                $m = 'Data yang dikirim terlalu panjang';
                break;
            case '422':
                $s = 'Unprocessable Entity';
                $m = 'Data yang Anda inputkan tidak sesuai ketentuan';
                break;
            case '500':
                $s = 'Internal Server Error';
                $m = 'Maaf, terjadi kesalahan dalam mengolah data';
                break;
            case '502':
                $s = 'Bad Gateway';
                $m = 'Tidak dapat terhubung ke server';
                break;
            case '503':
                $s = 'Service Unavailable';
                $m = 'Server tidak dapat diakses';
                break;
            case '504':
                $s = 'Gateway Timeout';
                $m = 'Server tidak merespon';
                break;
            default:
                $s = 'Undefined';
                $m = 'Undefined';
                break;
        }

        $status = ($status != null) ? $status : $s;
        $msg = ($msg != null) ? $msg : $m;
        return [
            'status' => [
                'code' => $code,
                'message' => $msg
            ],
            'data' => $data,
        ];
    }
}
