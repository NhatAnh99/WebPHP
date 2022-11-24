<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
session_start();
use App\Models\Nhanvien;
use App\Models\xuhuong;
use App\Models\DonNhapHang;
use App\Models\NhaCungCap;

class XuHuongController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
	public function all_xuhuong()
	{
        $this->AuthLogin();
		$all_xuhuong = DB::table('xuhuong')-> get();
		$manager_xuhuong = view('admin.xuhuong.xuhuong_all') -> with ('all_xuhuong', $all_xuhuong);
		return view('admin_layout')->with('admin.xuhuong.xuhuong_all', $manager_xuhuong);
	}
	public function add_xuhuong()
	{
        $this->AuthLogin();
		return view('admin.xuhuong.xuhuong_add');
	}
	public function save_xuhuong(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['XH_ID'] = $request -> id_xuhuong;
        $data['XH_Ten'] = $request -> ten_xuhuong;
        $data['XH_TrangThai'] = $request -> trangthai_xuhuong;
        $data['XH_Nam'] = $request -> nam_xuhuong;
        $get_hinh=$request->file('hinh_xuhuong');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['XH_Hinh']=$new_hinh;

            DB::table('xuhuong')->insert($data);
            Session::put('message','Thêm xu hướng thành công');
            return Redirect::to('all-xuhuong'); 
           
        }
        $data['SP_Hinh']='';
        
        

        DB::table('xuhuong')->insert($data);
        Session::put('message','Thêm xu hướng thành công');
        return Redirect::to('all-xuhuong'); 
    }
    public function active_xuhuong($xuhuong_ID)
    {
        $this->AuthLogin();
        DB::table('xuhuong')->where('XH_ID',$xuhuong_ID)->update(['XH_TrangThai'=>0]);
        Session::put('message','Cập nhật trạng thái xu hướng thành công');
        return Redirect::to('all-xuhuong');
    }
    public function unactive_xuhuong($xuhuong_ID)
    {
        $this->AuthLogin();
        DB::table('xuhuong')->where('XH_ID',$xuhuong_ID)->update(['XH_TrangThai'=>1]);
        Session::put('message','Cập nhật trạng thái xu hướng thành công');
        return Redirect::to('all-xuhuong');
    }


    public function edit_xuhuong($xuhuong_ID)
    {
        $this->AuthLogin();
    	$edit_xuhuong = DB::table('xuhuong')-> where('XH_ID',$xuhuong_ID)->get();
		$manager_xuhuong = view('admin.xuhuong.xuhuong_edit') -> with ('edit_xuhuong', $edit_xuhuong);
		return view('admin_layout')->with('admin.xuhuong.xuhuong_all', $manager_xuhuong);
    }
    public function update_xuhuong(Request $request, $xuhuong_ID)
    {
        $this->AuthLogin();
    	$data = array();
    	$data['XH_Ten'] = $request -> ten_xuhuong;
        $data['XH_Nam'] = $request -> nam_xuhuong;
        $get_hinh=$request->file('hinh_xuhuong');

        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['XH_Hinh']=$new_hinh;

        DB::table('xuhuong')->where('XH_ID',$xuhuong_ID)->update($data);
        Session::put('message','Cập nhật xu hướng thành công');
        return Redirect::to('all-xuhuong'); 
           
        }
        DB::table('xuhuong')->where('XH_ID',$xuhuong_ID)->update($data);
        Session::put('message','Cập nhật xu hướng thành công');
        return Redirect::to('all-xuhuong');
    }
    public function delete_xuhuong($xuhuong_ID)
    {
        $this->AuthLogin();
    	DB::table('xuhuong')->where('XH_ID',$xuhuong_ID)->delete();
        Session::put('message','Xoá xu hướng thành công');
        return Redirect::to('all-xuhuong');
    }


    //End admin

    public function show_xuhuong_home($xh_ID)
    {
        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $xh_by_id = DB::table('sanpham')
        ->join('xuhuong','sanpham.XH_ID','=','xuhuong.XH_ID')
        ->where('xuhuong.XH_ID',$xh_ID)->get(); 
        $xh_ten = DB::table('xuhuong')->where('xuhuong.XH_ID',$xh_ID)->limit(1)->get();  
        return view('pages.xuhuong.show_xuhuong')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('xh_by_id',$xh_by_id)
        ->with('xh_ten',$xh_ten);
    }
}