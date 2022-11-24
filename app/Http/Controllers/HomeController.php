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


class HomeController extends Controller
{
    public function index(){

        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        // $all_sanpham = DB::table('sanpham')
        // ->join('loaisanpham','loaisanpham.LSP_ID','=','sanpham.LSP_ID')
        // ->join('xuhuong','xuhuong.XH_ID','=','sanpham.XH_ID')
        // ->join('phongcach','phongcach.PC_ID','=','sanpham.PC_ID')->orderby('sanpham.SP_ID','desc')->get();
        $sp_sanpham = DB::table('sanpham')
        ->where('SP_TrangThai','1')
        ->orderby('SP_ID', 'desc')->limit(4)->get();
        return view ('pages.home')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('sp_sanpham',$sp_sanpham);
    }
    public function chitiet_sanpham($sp_ID)
    {
        $comment_customer=BinhLuan::where('CTDDH_ID',$sp_ID)->where('BL_PhanHoi','=',0)->where('BL_TrangThai',1)->get();
        $comment_admin=BinhLuan::with('SanPham')->where('BL_PhanHoi','>',0)->get();
        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        $chitiet_sanpham = DB::table('sanpham')
        ->join('loaisanpham','loaisanpham.LSP_ID','=','sanpham.LSP_ID')
        ->join('xuhuong','xuhuong.XH_ID','=','sanpham.XH_ID')
        ->join('phongcach','phongcach.PC_ID','=','sanpham.PC_ID')
        ->where('sanpham.SP_ID',$sp_ID)->get();

        foreach($chitiet_sanpham as $key => $value)
        {
            $loaisanpham_ID = $value ->LSP_ID;
        }
        $lienquan_sanpham = DB::table('sanpham')
        ->join('loaisanpham','loaisanpham.LSP_ID','=','sanpham.LSP_ID')
        ->join('xuhuong','xuhuong.XH_ID','=','sanpham.XH_ID')
        ->join('phongcach','phongcach.PC_ID','=','sanpham.PC_ID')
        ->where('loaisanpham.LSP_ID',$loaisanpham_ID)->whereNotIn('sanpham.SP_ID',[$sp_ID])->get();

        return view('pages.sanpham.chitiet_sanpham')
        ->with('comment_customer',$comment_customer)
        ->with('comment_admin',$comment_admin)
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('chitiet_sanpham',$chitiet_sanpham)
        ->with('lienquan_sanpham',$lienquan_sanpham);
    }
    public function timkiem_sanpham(Request $request)
    {

        $tukhoa = $request->tukhoa_sanpham;


        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        // $all_sanpham = DB::table('sanpham')
        // ->join('loaisanpham','loaisanpham.LSP_ID','=','sanpham.LSP_ID')
        // ->join('xuhuong','xuhuong.XH_ID','=','sanpham.XH_ID')
        // ->join('phongcach','phongcach.PC_ID','=','sanpham.PC_ID')->orderby('sanpham.SP_ID','desc')->get();
        $timkiem_sanpham = DB::table('sanpham')
        ->where('SP_Ten','like','%'.$tukhoa.'%')->get();
        
        return view ('pages.sanpham.timkiem_sanpham')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('timkiem_sanpham',$timkiem_sanpham);
        
    }
    public function ShowOrderTrackingDetail($order_id){
        $get_all_order_detail=ChiTietDonDatHang::where('CTDDH_ID',$order_id)->get();
        $customer_order=DonDatHang::find($order_id);
        $customer_delivery=ThongTinGiaoHang::where('GH_MaDon',$customer_order->DDH_MaDon)->first();
        $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
         $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        return view('pages.dondathang.show_order_tracking_detail')
        ->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('customer_order',$customer_order)
        ->with('all_order_detail',$get_all_order_detail)
        ->with('customer_delivery',$customer_delivery);
    }
    public function OrderTracking(){

        $now=time();
        Session::put('order_tracking_time',$now + 180);
        $data=Session::get('KH_Email');
        $time_order_tracking=Session::get('order_tracking_time');
        if(!$data || !$time_order_tracking || $time_order_tracking < $now){
            Session::forget('order_tracking');
            Session::forget('order_tracking_time');
            $get_order = null;
            $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
            $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
            $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
            return view('pages.dondathang.order_tracking')
            ->with('xh_xuhuong',$xh_xuhuong)
            ->with('pc_phongcach',$pc_phongcach)
            ->with('loai_loaisanpham',$loai_loaisanpham)
            ->with('get_order',$get_order);
            // return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
        }else{
            $order=DonDatHang::where('DDH_MaDon',$data)->orderBy('DDH_ID','DESC')->first();
            $order_delivery = ThongTinGiaoHang::where('GH_Email',$data)->orderBy('GH_ID','DESC')->get();
            $order_user=KhachHang::where('KH_Email',$data)->first();
            if(!$order && $order_delivery->count()<=0 && !$order_user){
                return Redirect::to('/order-tracking')->with('error','Not Found');
            }elseif($order){
                $get_order=DonDatHang::where('DDH_MaDon',$data)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_user && $order_delivery->count()>0){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->GH_MaDon;
                }
                $order_cus_id=DonDatHang::where('KH_ID',$order_user->KH_ID)->orderBy('DDH_ID','DESC')->get();
                foreach($order_cus_id as $k =>$v){
                    $cus_id[]=$v->DDH_ID;
                }
                $get_order=DonDatHang::whereIn('DDH_MaDon',$order_id)->orderBy('DDH_ID','DESC')->get();
                $get_order=DonDatHang::whereIn('DDH_ID',$cus_id)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_delivery->count()>0 && !$order_user){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->GH_MaDon;
                }
                $get_order=DonDatHang::whereIn('DDH_MaDon',$order_id)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_delivery->count()<=0 && $order_user){
                $get_order=DonDatHang::where('KH_ID',$order_user->KH_ID)->orderBy('DDH_ID','DESC')->get();
            }else{
                $get_order=null;
            }
            if($get_order==null){
                return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
            }
            foreach($get_order as $key=>$value){
                $customer_order_detail=ChiTietDonDatHang::where('CTDDH_MaDon',$value->DDH_MaDon)->get();
                $customer_order_delivery=ThongTinGiaoHang::where('GH_MaDon',$value->DDH_MaDon)->first();
                $customer_order_delivery_update=ThongTinGiaoHang::find($customer_order_delivery->GH_ID);
                $customer_order_delivery_update->DDH_ID=$value->DDH_ID;
                $customer_order_delivery_update->save();
                foreach($customer_order_detail as $k=>$v){
                    if($value->DDH_MaDon==$v->CTDDH_MaDon){
                        $customer_order_detail_update=ChiTietDonDatHang::find($v->CTDDH_ID);
                        $customer_order_detail_update->DDH_ID=$value->DDH_ID;
                        $customer_order_detail_update->save();
                    }
                }
            }
            
            $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
            $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
            $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
            return view('pages.dondathang.order_tracking')
            ->with('xh_xuhuong',$xh_xuhuong)
            ->with('pc_phongcach',$pc_phongcach)
            ->with('loai_loaisanpham',$loai_loaisanpham)
            ->with('get_order',$get_order);
        }
    }
    public function edit_OrderTracking(Request $request, $id)
    {
        $data = array();
        $data['DDH_TrangThai'] = 4;
        DB::table('dondathang')->where('DDH_ID',$id)->update($data);
        Session::put('message','Lưu đơn đặt hàng thành công');
        return Redirect::to('/order-tracking');
    }
    public function GetRequestOrderTracking(Request $request){
        $data=$request->all();
        $now=time();
        $order_tracking=Session::get('order_tracking');
        if($order_tracking || $data){
            Session::put('order_tracking',$data['order_tracking']);
            Session::put('order_tracking_time',$now + 180);
            return Redirect::to('/show-order-tracking');
        }else{
            return Redirect::to('/order-tracking');
        }
    }
    public function ShowOrderTracking(){
        $now=time();
        $data=Session::get('order_tracking');
        $time_order_tracking=Session::get('order_tracking_time');
        if(!$data || !$time_order_tracking || $time_order_tracking < $now){
            Session::forget('order_tracking');
            Session::forget('order_tracking_time');
            return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
        }else{
            $order=DonDatHang::where('DDH_MaDon',$data)->orderBy('DDH_ID','DESC')->first();
            $order_delivery = ThongTinGiaoHang::where('GH_Email',$data)->orderBy('GH_ID','DESC')->get();
            $order_user=KhachHang::where('KH_Email',$data)->first();
            if(!$order && $order_delivery->count()<=0 && !$order_user){
                return Redirect::to('/order-tracking')->with('error','Not Found');
            }elseif($order){
                $get_order=DonDatHang::where('DDH_MaDon',$data)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_user && $order_delivery->count()>0){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->GH_MaDon;
                }
                $order_cus_id=DonDatHang::where('KH_ID',$order_user->KH_ID)->orderBy('DDH_ID','DESC')->get();
                foreach($order_cus_id as $k =>$v){
                    $cus_id[]=$v->DDH_ID;
                }
                $get_order=DonDatHang::whereIn('DDH_MaDon',$order_id)->orderBy('DDH_ID','DESC')->get();
                $get_order=DonDatHang::whereIn('DDH_ID',$cus_id)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_delivery->count()>0 && !$order_user){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->GH_MaDon;
                }
                $get_order=DonDatHang::whereIn('DDH_MaDon',$order_id)->orderBy('DDH_ID','DESC')->get();
            }elseif($order_delivery->count()<=0 && $order_user){
                $get_order=DonDatHang::where('KH_ID',$order_user->KH_ID)->orderBy('DDH_ID','DESC')->get();
            }else{
                $get_order=null;
            }
            if($get_order==null){
                return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
            }
            foreach($get_order as $key=>$value){
                $customer_order_detail=ChiTietDonDatHang::where('CTDDH_MaDon',$value->DDH_MaDon)->get();
                $customer_order_delivery=ThongTinGiaoHang::where('GH_MaDon',$value->DDH_MaDon)->first();
                $customer_order_delivery_update=ThongTinGiaoHang::find($customer_order_delivery->GH_ID);
                $customer_order_delivery_update->DDH_ID=$value->DDH_ID;
                $customer_order_delivery_update->save();
                foreach($customer_order_detail as $k=>$v){
                    if($value->DDH_MaDon==$v->CTDDH_MaDon){
                        $customer_order_detail_update=ChiTietDonDatHang::find($v->CTDDH_ID);
                        $customer_order_detail_update->DDH_ID=$value->DDH_ID;
                        $customer_order_detail_update->save();
                    }
                }
            }
            $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
            $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
            $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
            return view('pages.dondathang.show_order_tracking')
            ->with('xh_xuhuong',$xh_xuhuong)
            ->with('pc_phongcach',$pc_phongcach)
            ->with('loai_loaisanpham',$loai_loaisanpham)
            ->with('get_order',$get_order);
        }
    }
}
