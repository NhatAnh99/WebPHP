<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Nhanvien;
use App\Models\KhachHang;
use App\Models\sanpham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;
use App\Models\ThongTinGiaoHang;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDatHang;
use App\Models\BinhLuan;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function profile()
    {
        $KH_ID = Session::get('KH_ID');
        $KhachHang = DB::table('khachhang')->where('KH_ID',$KH_ID)->first();
        // dd($result);
        // $aa = \auth()->guard('users');
        // $aa = Session::get('KH_MatKhau');
        // $user = [];
        //     $user['KH_Ten']=Session::get('KH_Ten');
        //     $user['KH_Email']=Session::get('KH_Email');
        // dd($user);
        // dd(Auth::user());
        return view('profile',compact('KhachHang'));
    }
    public function update_khachhang(Request $request)
    {
        // dd('nhan');
        $KH_ID = Session::get('KH_ID');
        $data = array();
        $data['KH_Ten'] = $request -> kh_ten;
        $data['KH_SDT'] = $request -> kh_sdt;
        $data['KH_DiaChi'] = $request -> kh_diachi;
        if($request->kh_matkhau != null){
            $data['KH_MatKhau'] = md5($request->kh_matkhau);
        }
        // dd($data);
        DB::table('khachhang')->where('KH_ID',$KH_ID)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('profile'); 
    }
}