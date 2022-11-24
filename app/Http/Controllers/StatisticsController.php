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
use App\Models\DonDatHang;
use App\Models\ChiTietDonDatHang;
use Carbon\Carbon;

class StatisticsController extends Controller
{
	public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
	public function ShowSalesStatistics(){
        $this->AuthLogin();
            $all_order_statistics=DonDatHang::orderby('DDH_ID', 'DESC')->paginate(10);
            if ($all_order_statistics->count()>0) {
                foreach ($all_order_statistics as $key=>$order) {
                    $id_order[]=$order->DDH_ID;
                }
            } else {
                $id_order=null;
            }

            if ($id_order !=null) {
                $count_detail=ChiTietDonDatHang::whereIn('DDH_ID', $id_order)->count();
                $sum_total_order=DonDatHang::sum('DDH_TongTien');
                $count_order=DonDatHang::whereIn('DDH_ID', $id_order)->count();
                $count_order_completion=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TrangThai', 3)->count();
                $count_order_unconfirmed=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TrangThai', 0)->count();
                $count_order_confirmed=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TrangThai', 1)->count();
                $count_order_in_transit=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TinhTrangGiao', 1)->count();
                $count_order_delivered=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TinhTrangGiao', 2)->count();
                $count_order_cancel=DonDatHang::whereIn('DDH_ID', $id_order)->where('DDH_TrangThai', 4)->count();
            } else {
                $count_detail=0;
                $sum_total_order=0;
                $count_order=0;
                $count_order_completion=0;
                $count_order_unconfirmed=0;
                $count_order_confirmed=0;
                $count_order_in_transit=0;
                $count_order_delivered=0;
                $count_order_cancel=0;
            }
            $all_order_statistics_success=DonDatHang::orderby('DDH_ID', 'DESC')->where('DDH_TrangThai','=', 3)->get();
            if ($all_order_statistics_success->count()>0) {
                foreach ($all_order_statistics_success as $key=>$order_success) {
                    $id_order_success[]=$order_success->DDH_ID;
                }
            } else {
                $id_order_success=null;
            }
            if ($id_order_success !=null) {
                $sum_total_order_success=DonDatHang::whereIn('DDH_ID', $id_order_success)->sum('DDH_TongTien');
                $sum_detail=ChiTietDonDatHang::whereIn('DDH_ID', $id_order_success)->sum('CTDDH_SoLuong');
                $all_order_detail_success=ChiTietDonDatHang::whereIn('DDH_ID', $id_order_success)->get();
            } else {
                $sum_detail=0;
                $sum_total_order_success=0;
            }
            return view('admin.thongke.statistics_order')
            ->with('sum_total_order', $sum_total_order)
            ->with('sum_total_order_success', $sum_total_order_success)
            ->with('sum_detail', $sum_detail)
            ->with('count_order', $count_order)
            ->with('count_order_completion', $count_order_completion)
            ->with('count_order_delivered', $count_order_delivered)
            ->with('count_detail', $count_detail)
            ->with('all_order_statistics', $all_order_statistics)
            ->with('count_order_cancel', $count_order_cancel)
            ->with('count_order_delivered', $count_order_delivered)
            ->with('count_order_in_transit', $count_order_in_transit)
            ->with('count_order_confirmed', $count_order_confirmed)
            ->with('count_order_unconfirmed', $count_order_unconfirmed);
        }
    }
