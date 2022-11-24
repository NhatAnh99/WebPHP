<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
session_start();
use App\Models\Nhanvien;
use App\Models\phongcach;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\NhaCungCap;

class PhongCachController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
	public function all_phongcach()
	{
        $this->AuthLogin();
		$all_phongcach = DB::table('phongcach')-> get();
		$manager_phongcach = view('admin.phongcach.phongcach_all') -> with ('all_phongcach', $all_phongcach);
		return view('admin_layout')->with('admin.phongcach.phongcach_all', $manager_phongcach);
	}
	public function add_phongcach()
	{
        $this->AuthLogin();
		return view('admin.phongcach.phongcach_add');
	}
	public function save_phongcach(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['PC_ID'] = $request -> id_phongcach;
        $data['PC_Ten'] = $request -> ten_phongcach;
        $get_hinh=$request->file('hinh_phongcach');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['PC_Hinh']=$new_hinh;

            DB::table('phongcach')->insert($data);
            Session::put('message','Thêm phong cách thành công');
            return Redirect::to('all-phongcach'); 
           
        }
        

        DB::table('phongcach')->insert($data);
        Session::put('message','Thêm phong cách thành công');
        return Redirect::to('all-phongcach'); 
    }
    public function edit_phongcach($phongcach_ID)
    {
        $this->AuthLogin();
    	$edit_phongcach = DB::table('phongcach')-> where('PC_ID',$phongcach_ID)->get();
		$manager_phongcach = view('admin.phongcach.phongcach_edit') -> with ('edit_phongcach', $edit_phongcach);
		return view('admin_layout')->with('admin.phongcach.phongcach_all', $manager_phongcach);
    }
    public function update_phongcach(Request $request, $phongcach_ID)
    {
        $this->AuthLogin();
    	$data = array();
    	$data['PC_Ten'] = $request -> ten_phongcach;
        $get_hinh=$request->file('hinh_phongcach');

        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['PC_Hinh']=$new_hinh;

        DB::table('phongcach')->where('PC_ID',$phongcach_ID)->update($data);
        Session::put('message','Cập nhật phong cách thành công');
        return Redirect::to('all-phongcach'); 
           
        }
        DB::table('phongcach')->where('PC_ID',$phongcach_ID)->update($data);
        Session::put('message','Cập nhật phong cách thành công');
        return Redirect::to('all-phongcach');
    }
    public function delete_phongcach($phongcach_ID)
    {
        $this->AuthLogin();
    	DB::table('phongcach')->where('PC_ID',$phongcach_ID)->delete();
        Session::put('message','Xoá phong cách thành công');
        return Redirect::to('all-phongcach');
    }


    //End admin
     public function show_phongcach_home($pc_ID)
    {
        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $pc_by_id = DB::table('sanpham')
        ->join('phongcach','sanpham.PC_ID','=','phongcach.PC_ID')
        ->where('phongcach.PC_ID',$pc_ID)->get(); 
        $pc_ten = DB::table('phongcach')->where('phongcach.PC_ID',$pc_ID)->limit(1)->get();  
        return view('pages.phongcach.show_phongcach')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('pc_by_id',$pc_by_id)
        ->with('pc_ten',$pc_ten);
    }
}