<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
session_start();
use App\Models\Nhanvien;
use App\Models\nhacungcap;
use App\Models\DonNhapHang;

class NhaCungCapController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
	public function all_nhacungcap()
	{
        $this->AuthLogin();
		$all_nhacungcap = DB::table('nhacungcap')-> get();
		$manager_nhacungcap = view('admin.nhacungcap.allnhacungcap') -> with ('all_nhacungcap', $all_nhacungcap);
		return view('admin_layout')->with('admin.nhacungcap.allnhacungcap', $manager_nhacungcap);
	}
	public function add_nhacungcap()
	{
        $this->AuthLogin();
		return view('admin.nhacungcap.addnhacungcap');
	}
	public function save_nhacungcap(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['NCC_Ten'] = $request -> ten_nhacungcap;
        $data['NCC_Email'] = $request -> email_nhacungcap;
        $data['NCC_SDT'] = $request -> sdt_nhacungcap;
        $get_hinh=$request->file('hinh_nhacungcap');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['NCC_Hinh']=$new_hinh;

            DB::table('nhacungcap')->insert($data);
            Session::put('message','Thêm nhà cung cấp thành công');
            return Redirect::to('all-nhacungcap'); 
           
        }
        $data['SP_Hinh']='';
        
        

        DB::table('nhacungcap')->insert($data);
        Session::put('message','Thêm nhà cung cấp thành công');
        return Redirect::to('all-nhacungcap'); 
    }


    public function edit_nhacungcap($nhacungcap_ID)
    {

        $this->AuthLogin();
    	$edit_nhacungcap = DB::table('nhacungcap')-> where('NCC_ID',$nhacungcap_ID)->get();
		$manager_nhacungcap = view('admin.nhacungcap.editnhacungcap') -> with ('edit_nhacungcap', $edit_nhacungcap);
		return view('admin_layout')->with('admin.nhacungcap.allnhacungcap', $manager_nhacungcap);
    }
    public function update_nhacungcap(Request $request, $nhacungcap_ID)
    {
        $this->AuthLogin();
    	$data = array();
        $data['NCC_Ten'] = $request -> ten_nhacungcap;
        $data['NCC_Email'] = $request -> email_nhacungcap;
        $data['NCC_SDT'] = $request -> sdt_nhacungcap;
        $get_hinh=$request->file('hinh_nhacungcap');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['NCC_Hinh']=$new_hinh;

            DB::table('nhacungcap')->where('NCC_ID',$nhacungcap_ID)->update($data);
            Session::put('message','Cập nhật nhà cung cấp thành công');
            return Redirect::to('all-nhacungcap'); 
           
        }
        DB::table('nhacungcap')->where('NCC_ID',$nhacungcap_ID)->update($data);
        Session::put('message','Cập nhật nhà cung cấp thành công');
        return Redirect::to('all-nhacungcap');
    }
    public function delete_nhacungcap($nhacungcap_ID)
    {
        $this->AuthLogin();
    	DB::table('nhacungcap')->where('NCC_ID',$nhacungcap_ID)->delete();
        Session::put('message','Xoá nhà cung cấp thành công');
        return Redirect::to('all-nhacungcap');
    }
}