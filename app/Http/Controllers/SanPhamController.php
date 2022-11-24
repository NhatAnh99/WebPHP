<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\SanPhamYeuThich;
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

class SanPhamController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
   public function all_sanpham()
    {
        $this->AuthLogin();
        $all_sanpham = DB::table('sanpham')
        ->join('loaisanpham','loaisanpham.LSP_ID','=','sanpham.LSP_ID')
        ->join('xuhuong','xuhuong.XH_ID','=','sanpham.XH_ID')
        ->join('phongcach','phongcach.PC_ID','=','sanpham.PC_ID')->orderby('sanpham.SP_ID','desc')->get();
        $manager_sanpham = view('admin.sanpham.allsanpham') -> with ('all_sanpham', $all_sanpham);
        return view('admin_layout')->with('admin.sanpham.allsanpham', $manager_sanpham);
    }
    public function add_sanpham()
    {
        $this->AuthLogin();
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        return view('admin.sanpham.addsanpham')
        ->with('loai_loaisanpham', $loai_loaisanpham)
        ->with('xh_xuhuong', $xh_xuhuong)
        ->with('pc_phongcach', $pc_phongcach);
    }
    public function save_sanpham(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['SP_Ten'] = $request -> ten_sanpham;
        $data['SP_MoTa'] = $request -> mota_sanpham;
        $data['SP_Gia'] = $request -> gia_sanpham;
        $data['SP_SoLuong'] = $request -> soluong_sanpham;
        $data['SP_Size'] = $request -> size_sanpham;
        $data['SP_GioiTinh'] = $request -> gioitinh_sanpham;
        $data['SP_MauSac'] = $request -> mausac_sanpham;
        $data['SP_TrangThai'] = $request -> trangthai_sanpham;
        $data['LSP_ID'] = $request -> loai_sanpham;
        $data['XH_ID'] = $request -> xh_sanpham;
        $data['PC_ID'] = $request -> pc_sanpham;
        $get_hinh=$request->file('hinh_sanpham');
        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['SP_Hinh']=$new_hinh;

            DB::table('sanpham')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-sanpham'); 
           
        }
        $data['SP_Hinh']='';
        DB::table('sanpham')->insert($data);
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('all-sanpham'); 
    }
    public function edit_sanpham($sanpham_ID)
    {
        $this->AuthLogin();
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $edit_sanpham = DB::table('sanpham')-> where('SP_ID',$sanpham_ID)->get();
        $manager_sanpham = view('admin.sanpham.editsanpham') -> with ('edit_sanpham', $edit_sanpham)->with('loai_loaisanpham',$loai_loaisanpham)->with('xh_xuhuong',$xh_xuhuong)->with('pc_phongcach',$pc_phongcach);
        return view('admin_layout')->with('admin.sanpham.editsanpham', $manager_sanpham);
    }
    public function update_sanpham(Request $request, $sanpham_ID)
    {
        $this->AuthLogin();
        $data = array();
        $data['SP_Ten'] = $request -> ten_sanpham;
        $data['SP_MoTa'] = $request -> mota_sanpham;
        $data['SP_Gia'] = $request -> gia_sanpham;
        $data['SP_SoLuong'] = $request -> soluong_sanpham;
        $data['SP_Size'] = $request -> size_sanpham;
        $data['SP_GioiTinh'] = $request -> gioitinh_sanpham;
        $data['SP_MauSac'] = $request -> mausac_sanpham;
        $data['LSP_ID'] = $request -> loai_sanpham;
        $data['XH_ID'] = $request -> xh_sanpham;
        $data['PC_ID'] = $request -> pc_sanpham;
        $get_hinh=$request->file('hinh_sanpham');

        if($get_hinh){
            $get_ten_hinh= $get_hinh->getClientOriginalName();
            $ten_hinh= current(explode('.',$get_ten_hinh));
            $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
            $get_hinh->move('public/upload/sanpham',$new_hinh);
            $data['SP_Hinh']=$new_hinh;

        DB::table('sanpham')->where('SP_ID',$sanpham_ID)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-sanpham'); 
           
        }
        DB::table('sanpham')->where('SP_ID',$sanpham_ID)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-sanpham'); 
    }
    public function delete_sanpham($sanpham_ID)
    {
        $this->AuthLogin();
        DB::table('sanpham')->where('SP_ID',$sanpham_ID)->delete();
        Session::put('message','Xoá sản phẩm thành công');
        return Redirect::to('all-sanpham');
    }
    public function active_sanpham($sanpham_ID)
    {
        $this->AuthLogin();
        DB::table('sanpham')->where('SP_ID',$sanpham_ID)->update(['SP_TrangThai'=>0]);
        Session::put('message','Cập nhật trạng thái sản phẩm thành công');
        return Redirect::to('all-sanpham');
    }
    public function unactive_sanpham($sanpham_ID)
    {
        $this->AuthLogin();
        DB::table('sanpham')->where('SP_ID',$sanpham_ID)->update(['SP_TrangThai'=>1]);
        Session::put('message','Cập nhật trạng thái sản phẩm thành công');
        return Redirect::to('all-sanpham');
    }

    


    //End admin
    
    public function shop_sanpham(){
        Session::forget('search_filter_customer');
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $all_product= SanPham::where('SP_TrangThai','1')->orderby('SP_ID','desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->where('SP_TrangThai','1')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.sanpham.shop_sanpham')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('all_product',$all_product)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);

        
    }
    public function shop_sanpham_nu(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.sanpham.shop_sanpham_nu')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);

        
    }
    public function shop_sanpham_nam(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.sanpham.shop_sanpham_nam')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);

        
    }
    public function yeuthich_sanpham()
    {
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->get();
        return view('pages.sanpham.sanpham_yeuthich')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_blue(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_blue')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_yellow(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_yellow')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_black(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_black')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_red(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_red')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_orange(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_orange')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function shop_sanpham_green(){
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.mausac.shop_sanpham_green')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function show_ngoaihanganh()
    {
        Session::forget('search_filter_customer');
        $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $all_product= SanPham::where('SP_TrangThai','1')->orderby('SP_ID','desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $sp_sanpham = DB::table('sanpham')->where('SP_TrangThai','1')->orderby('SP_ID','desc')->paginate(9);
        return view('pages.loaisanpham.show_ngoaihanganh')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('all_product',$all_product)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
}
