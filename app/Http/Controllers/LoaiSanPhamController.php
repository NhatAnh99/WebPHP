<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
session_start();
use App\Models\Nhanvien;
use App\Models\LoaiSanPham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;

class LoaiSanPhamController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
	public function all_loaisanpham()
	{
        $this->AuthLogin();
		$all_loaisanpham = DB::table('loaisanpham')-> get();
		$manager_loaisanpham = view('admin.loaisanpham.allloaisanpham')
        -> with ('all_loaisanpham', $all_loaisanpham);
		return view('admin_layout')
        ->with('admin.loaisanpham.allloaisanpham', $manager_loaisanpham);
	}
	public function add_loaisanpham()
	{
        $this->AuthLogin();
		return view('admin.loaisanpham.addloaisanpham');
	}
	public function save_loaisanpham(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['LSP_ID'] = $request -> id_loai;
        $data['LSP_Ten'] = $request -> ten_loai;
        $data['LSP_MoTa'] = $request -> mota_loai;
        $get_hinh=$request->file('hinh_loai');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['LSP_Hinh']=$new_hinh;

            DB::table('loaisanpham')->insert($data);
            Session::put('message','Thêm loại sản phẩm thành công');
            return Redirect::to('all-loaisanpham'); 
           
        }
        $data['LSP_Hinh']='';
        

        DB::table('loaisanpham')->insert($data);
        Session::put('message','Thêm loại sản phẩm thành công');
        return Redirect::to('all-loaisanpham'); 
    }
    public function edit_loaisanpham($loai_ID)
    {
        $this->AuthLogin();
    	$edit_loaisanpham = DB::table('loaisanpham')-> where('LSP_ID',$loai_ID)->get();
		$manager_loaisanpham = view('admin.loaisanpham.editloaisanpham')
        -> with ('edit_loaisanpham', $edit_loaisanpham);
		return view('admin_layout')
        ->with('admin.loaisanpham.editloaisanpham', $manager_loaisanpham);
    }
    public function update_loaisanpham(Request $request, $loai_ID)
    {
        $this->AuthLogin();
    	$data = array();
    	$data['LSP_Ten'] = $request -> ten_loai;
        $data['LSP_MoTa'] = $request -> mota_loai;
        $get_hinh=$request->file('hinh_loai');

        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['LSP_Hinh']=$new_hinh;

        DB::table('loaisanpham')->where('LSP_ID',$loai_ID)->update($data);
        Session::put('message','Cập nhật loại sản phẩm thành công');
        return Redirect::to('all-loaisanpham'); 
           
        }
        DB::table('loaisanpham')->where('LSP_ID',$loai_ID)->update($data);
        Session::put('message','Cập nhật loại sản phẩm thành công');
        return Redirect::to('all-loaisanpham');
    }
    public function delete_loaisanpham($loai_ID)
    {
        $this->AuthLogin();
    	DB::table('loaisanpham')->where('LSP_ID',$loai_ID)->delete();
        Session::put('message','Xoá loại sản phẩm thành công');
        return Redirect::to('all-loaisanpham');
    }



    //End admin


    public function show_loaisanpham_home($lsp_ID)
    {
        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $lsp_by_id = DB::table('sanpham')
        ->join('loaisanpham','sanpham.LSP_ID','=','loaisanpham.LSP_ID')
        ->where('loaisanpham.LSP_ID',$lsp_ID)->get();
        $lsp_ten = DB::table('loaisanpham')->where('loaisanpham.LSP_ID',$lsp_ID)->limit(1)->get();  
        return view('pages.loaisanpham.show_loai')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('lsp_by_id',$lsp_by_id)
        ->with('lsp_ten',$lsp_ten);
    }
}