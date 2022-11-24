<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
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
use App\Models\BinhLuan;
use App\Models\DonDatHang;

class KhachHangController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
   public function all_khachhang()
    {
        $this->AuthLogin();
        $all_khachhang = DB::table('khachhang')->get();
        $manager_khachhang = view('admin.khachhang.allkhachhang') -> with ('all_khachhang', $all_khachhang);
        return view('admin_layout')->with('admin.khachhang.allkhachhang', $manager_khachhang);
    }
    
    // public function editkhachhang(Request $request, $kh_ID)
    // {
    //     $this->AuthLogin();
    //     $data = array();
    //     $data['KH_Ten'] = $request -> ten_khachhang;
    //     $data['KH_GioiTinh'] = $request -> gioitinh_khachhang;
    //     $data['KH_Email'] = $request -> email_khachhang;
    //     $data['KH_SDT'] = $request -> sdt_khachhang;
    //     $data['KH_DiaChi'] = $request -> diachi_khachhang;

    //     DB::table('khachhang')->where('KH_ID',$khachhang_ID)->update($data);
    //     Session::put('message','Cập nhật thông tin thành công');
    //     return Redirect::to('all-khachhang'); 
    // }
    // public function save_khachhang(Request $request)
    // {
    //     $this->AuthLogin();
    //     $data = array();
    //     $data['KH_Ten'] = $request -> ten_khachhang;
    //     $data['KH_GioiTinh'] = $request -> gioitinh_khachhang;
    //     $data['KH_Email'] = $request -> email_khachhang;
    //     $data['KH_SDT'] = $request -> sdt_khachhang;
    //     $data['KH_DiaChi'] = $request -> diachi_khachhang;

    //         DB::table('khachhang')->insert($data);
    //         Session::put('message','Thêm thành công');
    //         return Redirect::to('all-khachhang'); 
           

    // }

}

