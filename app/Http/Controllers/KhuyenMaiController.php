<?php

namespace App\Http\Controllers;

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
use App\Models\KhuyenMai;

class KhuyenMaiController extends Controller
{
	public function check_coupon(Request $request)
	{
		$data = $request->all();
		$coupon = KhuyenMai::where('KM_TieuDe',$data['coupon'])->first();
		if ($coupon) {
			$count_coupon = $coupon->count();
			if ($count_coupon>0) {
				$coupon_session= Session::get('coupon');
				if ($coupon_session) {
					$is_avaiable = 0;
					if ($is_avaiable==0) {
						$khuyenmai[]=array(
							'tieude_coupon'=>$coupon->KM_TieuDe,
							'noidung_coupon'=>$coupon->KM_NoiDung,
							'phuongthuc_coupon'=>$coupon->KM_PhuongThuc,
							'giatri_coupon'=>$coupon->KM_GiaTri,
							'ngay_coupon'=>$coupon->KM_Ngay,
							'songay_coupon'=>$coupon->KM_SoNgay,
						);
						Session::put('coupon',$khuyenmai);
					}
				}
				else{
					$khuyenmai[]=array(
							'tieude_coupon'=>$coupon->KM_TieuDe,
							'noidung_coupon'=>$coupon->KM_NoiDung,
							'phuongthuc_coupon'=>$coupon->KM_PhuongThuc,
							'giatri_coupon'=>$coupon->KM_GiaTri,
							'ngay_coupon'=>$coupon->KM_Ngay,
							'songay_coupon'=>$coupon->KM_SoNgay,
						);
						Session::put('coupon',$khuyenmai);
				}
				Session::save();
				return redirect()->back()->with('message','Thêm mã giảm giá thành công');
			}
		}
		else{
			return redirect()->back()->with('error','Mã giảm giá không đúng');
		}
	}
	public function insert_coupon()
	{
		return view('admin.khuyenmai.insert_coupon');
	}
	public function insert_coupon_code(Request $request)
	{
		$data = $request->all();
		$coupon = new KhuyenMai;

		$coupon->KM_TieuDe = $data['tieude_coupon'];
		$coupon->KM_NoiDung = $data['noidung_coupon'];
		$coupon->KM_PhuongThuc = $data['phuongthuc_coupon'];
		$coupon->KM_GiaTri = $data['giatri_coupon'];
		$coupon->KM_Ngay = $data['ngay_coupon'];
		$coupon->KM_SoNgay = $data['songay_coupon'];

		$coupon->save();

		Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('/list-coupon'); 
	}
	public function list_coupon()
	{
		$coupon = KhuyenMai::orderby('KM_ID','desc')->get();
		return view('admin.khuyenmai.list_coupon')->with(compact('coupon'));
	}
	public function delete_coupon($coupon_ID)
	{
		$coupon = KhuyenMai::find($coupon_ID);
		$coupon->delete();
		Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('/list-coupon'); 
	}
}