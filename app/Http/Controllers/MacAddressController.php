<?php

namespace App\Http\Controllers;

use App\Models\MacAddress;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class MacAddressController extends Controller
{

    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $pw = session()->get('password');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pw)) {
            $mac = $API->comm('/caps-man/access-list/print');

            $data = [
                'name' => $mac
            ];
        } else {
            return redirect()->route('failed');
        }


        return view('macaddress.mac', $data);
        // return view('macaddress.mac');
    }
    public function delete($id)
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $pw = session()->get('password');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pw)) {
            $API->comm('/caps-man/access-list/remove', [
                '.id' => '*' . $id,
            ]);

            return redirect()->route('macaddress.mac');
        } else {
            return 'Koneksi Gagal';
        }
    }
}