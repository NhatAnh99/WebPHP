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
use App\Models\SanPham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;
use App\Models\BinhLuan;
use App\Models\TonKho;
use App\Models\KhuyenMai;


class SearchController extends Controller
{
    // public function ShowProductSearchHeaderCustomer(Request $request)
    // {
    //     $search_keyword=$request->search_product_customer;
    //     if ($search_keyword ==null) {
    //         return redirect()->back();
    //     }else{
    //         if ($pro_rate_id!=null) {
    //             $all_product_rate=SanPham::where('SP_TrangThai', 1)->orderby('SP_ID', $pro_rate_id)->get();
    //         } else {
    //             $all_product_rate=SanPham::where('SP_TrangThai', 1)->get();
    //         }
    //         $all_product->appends(['search_product_customer' => $search_keyword]);
    //         $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
    //         $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
    //         $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
    //         $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
    //         return view('pages.sanpham.shop_sanpham')
    //         ->with('all_product', $all_product)
    //         ->with('search_filter_customer', $search_filter_customer)
    //         ->with('xh_xuhuong',$xh_xuhuong)
    //         ->with('all_product_rate',$all_product_rate)
    //         ->with('pc_phongcach',$pc_phongcach)
    //         ->with('loai_loaisanpham',$loai_loaisanpham)
    //         ->with('sp_sanpham',$sp_sanpham);
    //     }
    // }
    public function ShowProductSearchFilterCustomer(Request $request){
        $search_filter=$request->all();
        $search_customer_phongcach=$request->search_customer_phongcach;
        $search_customer_loaisanpham=$request->search_customer_loaisanpham;
        $search_customer_xuhuong=$request->search_customer_xuhuong;
        $search_customer_gioitinh=$request->search_customer_gioitinh;
        $search_customer_gia=$request->search_customer_gia;
        
     
        if (!$search_filter  || $search_filter==null) {
            return Redirect::to('/shop-sanpham');
        }elseif ($search_customer_phongcach ==null && $search_customer_loaisanpham ==null && $search_customer_xuhuong ==null && $search_customer_gia ==null && $search_customer_gioitinh ==null) {
            return Redirect::to('/shop-sanpham');
        }else {
            $search_filter_customer[] = array(
                'search_customer_phongcach' => $search_customer_phongcach,
                'search_customer_loaisanpham' =>  $search_customer_loaisanpham,
                'search_customer_xuhuong' =>  $search_customer_xuhuong,
                'search_customer_gioitinh' =>  $search_customer_gioitinh,
                'search_customer_gia' =>  $search_customer_gia
            );
               if($search_customer_phongcach!=null){
                    if($search_customer_loaisanpham!=null){//brand!=null
                        if($search_customer_xuhuong!=null){//brand!=null SanPham type != null
                            if($search_customer_gioitinh!=null){//brand!=null SanPham type != null collection != null
                                if($search_customer_gia!=null){//brand!=null SanPham type != null collection != null gender!=null price!=null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type != null collection != null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{//gender=null
                                if($search_customer_gia!=null){//gender=null collection != null brand !=null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type != null collection != null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }else{//collection = null brand !=null  SanPham type != null
                            if($search_customer_gioitinh!=null){
                                if($search_customer_gia!=null){//gender!=null collection != null brand !=null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type != null collection != null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{
                                if($search_customer_gia!=null){//gender=null collection != null brand !=null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type != null collection != null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }
                    }else{//SanPham type = null brand !=null
                        if($search_customer_xuhuong!=null){//SanPham type = null brand !=null collection != null
                            if($search_customer_gioitinh!=null){
                                if($search_customer_gia!=null){//gender!=null collection != null brand !=null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type = null collection != null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{//SanPham type = null brand !=null collection != null gender =null
                                if($search_customer_gia!=null){//gender=null collection != null brand !=null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type = null collection != null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }

                            }
                        }else{//SanPham type = null brand !=null collection = null
                            if($search_customer_gioitinh!=null){//SanPham type = null brand !=null collection = null
                                if($search_customer_gia!=null){//gender!=null collection = null brand !=null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type = null collection = null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{//SanPham type = null brand !=null collection = null gender=null
                                if($search_customer_gia!=null){//gender=null collection = null brand !=null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('PC_ID',$search_customer_phongcach )
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand!=null SanPham type = null collection = null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('PC_ID',$search_customer_phongcach )
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }
                    }
                }else{//brand = null
                    if($search_customer_loaisanpham!=null){//brand=null
                        if($search_customer_xuhuong!=null){//brand=null SanPham type != null
                            if($search_customer_gioitinh!=null){//brand=null SanPham type != null collection != null
                                if($search_customer_gia!=null){//gender!=null collection != null brand !=null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type != null collection != null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{//gender=null collection != null brand =null  SanPham type != null
                                if($search_customer_gia!=null){//gender=null collection != null brand =null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type != null collection! = null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }else{//collection = null brand =null  SanPham type != null
                            if($search_customer_gioitinh!=null){
                                if($search_customer_gia!=null){//gender!=null collection = null brand !=null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type != null collection = null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{
                                if($search_customer_gia!=null){//gender=null collection = null brand =null  SanPham type != null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('LSP_ID', $search_customer_loaisanpham)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type != null collection = null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('LSP_ID', $search_customer_loaisanpham)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }
                    }else{//SanPham type = null brand =null
                        if($search_customer_xuhuong!=null){//SanPham type = null brand =null collection != null
                            if($search_customer_gioitinh!=null){
                                if($search_customer_gia!=null){//gender!=null collection != null brand =null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type = null collection != null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }

                            }else{//SanPham type = null brand =null collection != null gender =null
                                if($search_customer_gia!=null){//gender=null collection != null brand =null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('XH_ID', $search_customer_xuhuong)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type = null collection != null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('XH_ID', $search_customer_xuhuong)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }else{//SanPham type = null brand !=null collection = null
                            if($search_customer_gioitinh!=null){//SanPham type = null brand=null collection = null
                                if($search_customer_gia!=null){//gender!=null collection = null brand =null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[400000,600000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_GioiTinh',$search_customer_gioitinh)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type = null collection = null gender!=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->where('SP_GioiTinh',$search_customer_gioitinh)
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }else{//SanPham type = null brand=null collection = null gender=null
                                if($search_customer_gia!=null){//gender=null collection = null brand =null  SanPham type = null
                                    if($search_customer_gia==1){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->where('SP_Gia','<',100000)
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==2){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->whereBetween('SP_Gia',[100000,200000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==3){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->whereBetween('SP_Gia',[200000,400000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==4){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->whereBetween('SP_Gia',[400000,600000]) 
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==5){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->whereBetween('SP_Gia',[600000,800000])
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }elseif($search_customer_gia==6){
                                        $all_product=SanPham::where('SP_TrangThai','1')
                                        ->orderBy('SP_ID', 'DESC')->paginate(9);
                                    }
                                }else{//brand=null SanPham type = null collection = null gender=null price=null
                                    $all_product=SanPham::where('SP_TrangThai','1')
                                    ->orderBy('SP_ID', 'DESC')->paginate(9);
                                }
                            }
                        }
                    }
                }
            
            $all_product->appends(['search_customer_phongcach' => $search_customer_phongcach,
            'search_customer_loaisanpham' => $search_customer_loaisanpham,
            'search_customer_xuhuong' => $search_customer_xuhuong,
            'search_customer_gia' => $search_customer_gia,
            'search_customer_gioitinh' => $search_customer_gioitinh]);
            $xh_xuhuong = DB::table('xuhuong')-> orderby('XH_ID', 'desc')->get();
            $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
            $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
            $sp_sanpham = DB::table('sanpham')->orderby('SP_ID','desc')->paginate(9);
            return view('pages.sanpham.shop_sanpham')
            ->with('search_filter_customer', $search_filter_customer)
            ->with('xh_xuhuong',$xh_xuhuong)
            ->with('pc_phongcach',$pc_phongcach)
            ->with('loai_loaisanpham',$loai_loaisanpham)
            ->with('sp_sanpham',$all_product);
        }
    }
}