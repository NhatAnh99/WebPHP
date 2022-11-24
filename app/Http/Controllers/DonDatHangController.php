<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Nhanvien;
use App\Models\XuHuong;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use App\Models\DonDatHang;
use App\Models\LoaiSanPham;
use App\Models\ChiTietDonDatHang;
use App\Models\ThongTinGiaoHang;
use App\Models\HoaDon;

class DonDatHangController extends Controller
{
    public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
   public function all_dondathang()
    {
        $this->AuthLogin();
            $all_order = DonDatHang::orderBy('DDH_ID', 'DESC')->paginate(5);
            return view('admin.dondathang.alldondathang') ->with(compact('all_order'));
           
        // $all_dondathang= DB::table('chitietdondathang')->where('CTDDH_ID',$chitietdondathang_ID)
        // ->join('dondathang','chitietdondathang.CTDDH_ID','=','dondathang.CTDDH_ID)
        // ->orderby('dondathang.CTDDDH_ID','desc')->get();

       //  $all_dondathang = DB::table('dondathang')
       // ->orderby('dondathang.DDH_ID','desc')->get();
       //  $manager_dondathang = view('admin.dondathang.alldondathang') -> with ('all_dondathang', $all_dondathang);
       //  return view('admin_layout')->with('admin.dondathang.alldondathang', $manager_dondathang);
    }
    public function edit_dondathang($dondathang_ID)
    {
        $this->AuthLogin();
        
        $edit_dondathang = DB::table('dondathang')-> where('DDH_ID',$dondathang_ID)->get();
        $manager_dondathang = view('admin.dondathang.adddondathang') -> with ('edit_dondathang', $edit_dondathang);
        return view('admin_layout')->with('admin.dondathang.adddondathang', $manager_dondathang);

    }
    public function update_dondathang(Request $request, $dondathang_ID)
    {
        $this->AuthLogin();
        $data = array();
        $data['DDH_TinhTrangGiao'] = $request -> tinhtranggiao_dondathang;
        $data['DDH_TinhTrangThanhToan'] = $request -> tinhtrangthanhtoan_dondathang;
        $data['DDH_TrangThai'] = $request -> trangthai_dondathang;
        DB::table('dondathang')->where('DDH_ID',$dondathang_ID)->update($data);
        Session::put('message','Lưu đơn đặt hàng thành công');
        return Redirect::to('/all-dondathang');
    }
    public function view_dondathang($dondathang_ID)
    {
        $this->AuthLogin();
        $order=DonDatHang::find($dondathang_ID);
        $order_detail=ChiTietDonDatHang::where('CTDDH_MaDon',$order->DDH_MaDon)->get();
        $order_delivery=ThongTinGiaoHang::where('GH_MaDon',$order->DDH_MaDon)->first();
        $order_hd=HoaDon::where('HD_MaDon',$order->DDH_MaDon)->first();
        foreach($order_detail as $key =>$value){
                $order_detail_update=ChiTietDonDatHang::find($value->CTDDH_ID);
                $order_detail_update->DDH_ID=$dondathang_ID;
                $order_detail_update->save();
            }
            $order_delivery_update=ThongTinGiaoHang::find($order_delivery->GH_ID);
            $order_delivery_update->DDH_ID=$dondathang_ID;
            

            $order_hd_update=HoaDon::find($order_hd->HD_ID);
            $order_hd_update->DDH_ID=$dondathang_ID;
            
            $order->save();
            $order_delivery_update->save();
            $order_hd_update->save();

            return view('admin.dondathang.viewdondathang')
            ->with('order',$order)
            ->with('order_detail',$order_detail)
            ->with('order_hd',$order_hd)
            ->with('order_delivery',$order_delivery);
        
        // $all_chitietdondathang = DB::table('dondathang')->where('DDH_ID',$dondathang_ID)
        // ->join('thongtingiaohang','thongtingiaohang.GH_ID','=','dondathang.GH_ID')
        // ->orderby('dondathang.DDH_ID','desc')->get();


        // $manager_chitietdondathang = view('admin.dondathang.viewdondathang')-> with ('all_chitietdondathang', $all_chitietdondathang);
        // return view('admin_layout')->with('admin.dondathang.viewdondathang', $manager_chitietdondathang);
    }
    // public function update_dondathang(Request $request, $dondathang_ID)
    // {
    //     $this->AuthLogin();
    //     $data = array();
    //     $data['SP_Ten'] = $request -> ten_dondathang;
    //     $data['SP_MoTa'] = $request -> mota_dondathang;
    //     $data['SP_Gia'] = $request -> gia_dondathang;
    //     $data['SP_SoLuong'] = $request -> soluong_dondathang;
    //     $data['SP_Size'] = $request -> size_dondathang;
    //     $data['SP_MauSac'] = $request -> mausac_dondathang;
    //     $data['LSP_ID'] = $request -> loai_dondathang;
    //     $data['XH_ID'] = $request -> xh_dondathang;
    //     $data['PC_ID'] = $request -> pc_dondathang;
    //     $get_hinh=$request->file('hinh_dondathang');

    //     if($get_hinh){
    //         $get_ten_hinh= $get_hinh->getClientOriginalName();
    //         $ten_hinh= current(explode('.',$get_ten_hinh));
    //         $new_hinh=$ten_hinh.rand(0,99).'.'. $get_hinh->getClientOriginalExtension();
    //         $get_hinh->move('public/upload/dondathang',$new_hinh);
    //         $data['SP_Hinh']=$new_hinh;

    //     DB::table('dondathang')->where('SP_ID',$dondathang_ID)->update($data);
    //     Session::put('message','Cập nhật sản phẩm thành công');
    //     return Redirect::to('all-dondathang'); 
           
    //     }
    //     DB::table('dondathang')->where('SP_ID',$dondathang_ID)->update($data);
    //     Session::put('message','Cập nhật sản phẩm thành công');
    //     return Redirect::to('all-dondathang'); 
    // }
    public function active_dondathang($dondathang_ID)
    {
        $this->AuthLogin();
        DB::table('dondathang')->where('SP_ID',$dondathang_ID)->update(['SP_TrangThai'=>0]);
        Session::put('message','Cập nhật trạng thái sản phẩm thành công');
        return Redirect::to('all-dondathang');
       
    }
    public function unactive_dondathang($dondathang_ID)
    {
        $this->AuthLogin();
        DB::table('dondathang')->where('SP_ID',$dondathang_ID)->update(['SP_TrangThai'=>1]);
        Session::put('message','Cập nhật trạng thái sản phẩm thành công');
        return Redirect::to('all-dondathang');
    }
    public function chuaxuly_dondathang()
    {
        $this->AuthLogin();
        $all_dondathang = DB::table('dondathang')->where('DDH_TrangThai',0)
       ->orderby('dondathang.DDH_ID','desc')->get();
        $manager_dondathang = view('admin.dondathang.chuaxuly_dondathang') -> with ('all_dondathang', $all_dondathang);
        return view('admin_layout')->with('admin.dondathang.chuaxuly_dondathang', $manager_dondathang);
    }
    public function daxuly_dondathang()
    {
        $this->AuthLogin();
        $all_dondathang = DB::table('dondathang')->where('DDH_TrangThai',1)
       ->orderby('dondathang.DDH_ID','desc')->get();
        $manager_dondathang = view('admin.dondathang.chuaxuly_dondathang') -> with ('all_dondathang', $all_dondathang);
        return view('admin_layout')->with('admin.dondathang.chuaxuly_dondathang', $manager_dondathang);
    }
    public function dangxuly_dondathang()
    {
        $this->AuthLogin();
        $all_dondathang = DB::table('dondathang')->where('DDH_TrangThai',2)
       ->orderby('dondathang.DDH_ID','desc')->get();
        $manager_dondathang = view('admin.dondathang.dangxuly_dondathang') -> with ('all_dondathang', $all_dondathang);
        return view('admin_layout')->with('admin.dondathang.dangxuly_dondathang', $manager_dondathang);
    }
    public function hoantat_dondathang()
    {
        $this->AuthLogin();
        $all_dondathang = DB::table('dondathang')->where('DDH_TrangThai',3)
       ->orderby('dondathang.DDH_ID','desc')->get();
        $manager_dondathang = view('admin.dondathang.hoantat_dondathang') -> with ('all_dondathang', $all_dondathang);
        return view('admin_layout')->with('admin.dondathang.hoantat_dondathang', $manager_dondathang);
    }
    public function huy_dondathang()
    {
        $this->AuthLogin();
        $all_dondathang = DB::table('dondathang')->where('DDH_TrangThai',4)
       ->orderby('dondathang.DDH_ID','desc')->get();
        $manager_dondathang = view('admin.dondathang.huy_dondathang') -> with ('all_dondathang', $all_dondathang);
        return view('admin_layout')->with('admin.dondathang.huy_dondathang', $manager_dondathang);
    }
    public function getdelivery(){
        $this->AuthLogin();
        $all_delivery=ThongTinGiaoHang::orderby('GH_ID','DESC')->paginate(5);
        $all_order=DonDatHang::all();
        foreach($all_order as $key =>$order){
            foreach($all_delivery as $key =>$delivery){
                if($order->DDH_MaDon==$delivery->GH_MaDon){
                    $delivery_update=ThongTinGiaoHang::find($delivery->GH_ID);
                    $delivery_update->DDH_ID=$order->GH_ID;
                    $delivery_update->save();
                }
            }
        }
        return view('admin.dondathang.alldondathang')
        ->with('all_delivery',$all_delivery);
    }

    
}
