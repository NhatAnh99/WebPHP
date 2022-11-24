<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Nhanvien;
use App\Models\sanpham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;

class TonKhoController extends Controller
{
	 public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
    public function all_sanpham_tonkho()
    {
        $this->AuthLogin();
        $all_sanpham_tonkho = DB::table('tonkho')
        ->join('sanpham','sanpham.SP_ID','=','tonkho.SP_ID')
        ->orderby('tonkho.TK_ID','desc')->get();
        $manager_sanpham_tonkho = view('admin.tonkho.show_tonkho') -> with ('all_sanpham_tonkho', $all_sanpham_tonkho);
        return view('admin_layout')->with('admin.tonkho.show_tonkho', $manager_sanpham_tonkho);
    }
    
}