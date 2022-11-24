<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();
use App\Models\Nhanvien;
use App\Models\sanpham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;
use App\Models\TinhThanhPho;
use App\Models\QuanHuyen;
use App\Models\XaPhuongThiTran;
use App\Models\VanChuyen;

class GioHangController extends Controller
{
	public function gio_hang()
	{
		$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
		return view('pages.giohang.show_giohang_ajax')
		->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham);

	}

	public function add_cart_ajax(Request $request)
	{
		$data = $request-> all();
		$session_id = substr(md5(microtime()).rand(0,26),5);

		$cart = Session::get('cart');
		if($cart==true)
		{
			$is_avaiable = 0;
			foreach($cart as $key => $val)
			{
				if($val['sanpham_id']==$data['sanpham_id'])
				{
					$is_avaiable++;
				}
			}
			if(	$is_avaiable == 0)
			{
				$cart[] = array(
				'session_id'=> $session_id,
				'sanpham_id'=> $data['sanpham_id'],
				'sanpham_ten'=>$data['sanpham_ten'],
				'sanpham_hinh'=>$data['sanpham_hinh'],
				'sanpham_gia'=>$data['sanpham_gia'],
				'sanpham_soluong'=>$data['sanpham_soluong'],
			);
				Session::put('cart',$cart);
			}

		}else
		{
			$cart[] = array(
				'session_id'=> $session_id,
				'sanpham_id'=> $data['sanpham_id'],
				'sanpham_ten'=>$data['sanpham_ten'],
				'sanpham_hinh'=>$data['sanpham_hinh'],
				'sanpham_gia'=>$data['sanpham_gia'],
				'sanpham_soluong'=>$data['sanpham_soluong'],
			);
		}
		Session::put('cart',$cart);
		Session::save();
	}
	public function save_giohang(Request $request)
	{

		
		$sanphamID = $request -> sanphamid_hidden;
		$soluong = $request -> sluong;
		$sanpham_info = DB::table('sanpham')-> where('SP_ID',$sanphamID)->first();
        $data['id'] = $sanpham_info->SP_ID;
        $data['name'] = $sanpham_info->SP_Ten;
        $data['qty'] = $soluong;
        $data['price'] = $sanpham_info->SP_Gia;
        $data['options']['image'] = $sanpham_info->SP_Hinh;
        Cart::add($data);
        return Redirect::to('/show-giohang');
		// Cart::destroy();
		
	}
	public function show_giohang()
	{

		$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
		return view('pages.giohang.show_giohang')
		->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham);
	}
	public function update_cart(Request $request)
	{
		$data = $request->all();
		$cart= Session::get('cart');
		if($cart==true)
		{
			foreach($data['cart_qty'] as $key =>$qty)
			{
				foreach($cart as $session => $val)
				{
					if($val['session_id']==$key)
					{
						$cart[$session]['sanpham_soluong'] = $qty;
					}
				}
			}
			Session::put('cart',$cart);
			return redirect()->back()->with('message','Cập nhật sản phẩm thành công');
		}else
		{
			return redirect()->back()->with('message','Cập nhật sản phẩm thất bại');
		}
	}
	public function delete_cart($session_id)
	{
		$cart= Session::get('cart');
		if($cart==true)
		{
			foreach($cart as $key => $val)
			{
				if($val['session_id'] == $session_id)
				{
					unset($cart[$key]);
				}
			}
			Session::put('cart',$cart);
			return redirect()->back()->with('message','Xóa sản phẩm thành công');
		}else
		{
			return redirect()->back()->with('message','Xóa sản phẩm thất bại');
		}
	}
	public function delete_giohang($rowId)
	{
		Cart::update($rowId,0);
		return redirect::to('/show-giohang');
	}
}