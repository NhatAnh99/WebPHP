<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\NhanVien;
use DB;
session_start();

class AdminController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
    public function index(){
        return view('admin_login');
    }
    public function show_layout(){
        $this->AuthLogin();
        return view('admin.admin_index');
    }
    public function show_admin(Request $request)
    {
        // dd('nhan');
        $this->AuthLogin();
       $NV_TaiKhoan = $request -> NV_TaiKhoan;
       $NV_MatKhau = md5($request -> NV_MatKhau);


       $result = DB::table('nhanvien')-> where ('NV_TaiKhoan',$NV_TaiKhoan)-> where('NV_MatKhau',$NV_MatKhau) -> first();
       //return view('admin.admin_index');
        if($result){
            Session::put('NV_Ten',$result-> NV_Ten);
            Session::put('NV_ID',$result-> NV_ID);
            return redirect::to('/admin');
        }else{
            Session::put('message','Tài khoản hoặc mặt khẩu không chính xác vui lòng nhập lại!');
            return redirect::to('/admin-login');
        }

    }
    public function logout()
    {
        $this->AuthLogin();
        Session::put('NV_Ten',null);
        Session::put('NV_ID',null);
        return redirect::to('/admin-login');
    }
}
