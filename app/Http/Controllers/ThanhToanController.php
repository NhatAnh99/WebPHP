<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use Session;
use Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Nhanvien;
use App\Models\sanpham;
use App\Models\HoaDon;
use App\Models\XuHuong;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDatHang;
use App\Models\DonNhapHang;
use App\Models\ThongTinGiaoHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;
use App\Models\TinhThanhPho;
use App\Models\QuanHuyen;
use App\Models\XaPhuongThiTran;
use App\Models\VanChuyen;

class ThanhToanController extends Controller
{
	public function login_thanhtoan()
	{
		$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
        

		return view('pages.thanhtoan.login_thanhtoan')
		->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham);
	}


	public function add_khachhang(Request $request)
	{
		$data = array();
		$data['KH_Ten'] =$request->kh_ten; 
		$data['KH_Email'] =$request->kh_email; 
		$data['KH_MatKhau'] =md5($request->kh_matkhau); 
		$data['KH_SDT'] =$request->kh_sdt; 
		$data['KH_DiaChi'] =$request->kh_diachi;

		$khachhang_id = DB::table('khachhang')->insertGetId($data);

		Session::put('KH_ID',$khachhang_id);
		Session::put('KH_Ten',$request->kh_ten); 
		return redirect::to('/fill-thanhtoan');
	}
	public function fill_thanhtoan(Request $request)
	{

		$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();

        $city = TinhThanhPho::orderby('TP_ID','ASC')->get();

		return view('pages.thanhtoan.fill_thanhtoan')
		->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham)
        ->with('city',$city);
	}

    public function save_thanhtoan_khachhang(Request $request)
    {
        $data = $request->all();
        $order_detail = Session::get('cart');
        $order_transport_fee = Session::get('feeship');
        $order_coupon = Session::get('coupon');
        $order_code = substr(str_shuffle(str_repeat("ThoiTrang", 5)), 0, 2) . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 6);
        $order_old = DonDatHang::where('DDH_MaDon', $order_code)->first();
        if (!$order_detail) {
            return Redirect::to('/')->with('message', 'Chưa có sản phẩm trong giỏ hàng!');
        } else {
            if ($data['order_city'] == -1 || $data['order_province'] == -1 || $data['order_wards'] == -1) {
                return Redirect::to('/fill-thanhtoan')->with('error', 'Vui lòng chọn địa chỉ vận chuyển!');
            } else {
                if (!$order_old) {
                    $order_code = substr(str_shuffle(str_repeat("ThoiTrang", 5)), 0, 2) . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 6);
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                    $order_hd = new HoaDon();
                    $order_hd->HD_NgayXuat = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                    $order_hd->HD_MaDon = $order_code;


                    $order = new DonDatHang();
                    $order->DDH_MaDon = $order_code;
                    $order->DDH_NgayDat = $order_date;
                    $order->KH_ID = Session::get('KH_ID');
                    $order->DDH_TinhTrangThanhToan = 0;//chưa thanh toán COD
                    $order->DDH_TinhTrangGiao = 0;// chưa giao hàng
                    $order->DDH_TrangThai = 0;// chưa xử lý


                    $order_delivery = new ThongTinGiaoHang();
                    $ci = TinhThanhPho::find($data['order_city']);
                    $prov = QuanHuyen::find($data['order_province']);
                    $wards = XaPhuongThiTran::find($data['order_wards']);
                    if ($ci && $prov && $wards) {
                        $address = $data['gh_diachi'] . ',' . $wards->Xa_name . ',' . $prov->QH_name . ',' . $ci->TP_name;
                        $order_delivery->GH_DiaChi = $address;
                    } else {
                        $order_delivery->GH_DiaChi = $data['gh_diachi'];
                    }
                    $order_delivery->GH_Ten = $data['gh_ten'];
                    $order_delivery->GH_Email = $data['gh_email'];
                    $order_delivery->GH_SDT = $data['gh_sdt'];
                    $order_delivery->GH_GhiChu = $data['gh_ghichu'];
                    $order_delivery->GH_MaDon = $order_code;
                    $total = 0;

                    $content = $order_detail;

                    foreach ($order_detail as $or => $or_detail) {
                        $order_detail = new ChiTietDonDatHang();
                        $order_detail->CTDDH_SoLuong = $or_detail['sanpham_soluong'];
                        $order_detail->SP_ID = $or_detail['sanpham_id'];
                        $order_detail->CTDDH_MaDon = $order_code;
                        $order_detail->CTDDH_DonGia = $or_detail['sanpham_gia'];
                        $total += ($or_detail['sanpham_gia'] * $or_detail['sanpham_soluong']);
                        $cart_array[] = array(
                            'sanpham_ten' => $or_detail['sanpham_ten'],
                            'sanpham_gia' => $or_detail['sanpham_gia'],
                            'sanpham_soluong' => $or_detail['sanpham_soluong']
                        );
                        $order_detail->save();
                    }
                    if (Session::get('feeship')) {
                        $tran_fee = Session::get('feeship');
                    } else {
                        $tran_fee = 35000;
                    }
                    if (isset($order_coupon)) {
                        foreach ($order_coupon as $co => $cou) {
                            if ($cou['phuongthuc_coupon'] == 2) {
                                $discount = $cou['giatri_coupon'];
                            } elseif ($cou['phuongthuc_coupon'] == 1) {
                                $discount = $total * ($cou['giatri_coupon'] / 100);
                            } else {
                                $discount = $cou['giatri_coupon'];
                            }
                            break;
                        }
                        $order->DDH_TongTien = $total + $tran_fee - $discount;
                        $order_hd->HD_TongTienTT = $total + $tran_fee - $discount;
                    } else {
                        $discount = 0;
                        $order->DDH_TongTien = $total + $tran_fee;
                        $order_hd->HD_TongTienTT = $total + $tran_fee;
                    }
                    $order_hd->save();
                    $order->save();
                    $order_delivery->save();

                    //Detail này để truyền thông tin đơn hàng vào email để hiển thị cho khách hàng
                    $details = [
                        'tenkh' => $order_delivery->GH_Ten,
                        'sdt' => $order_delivery->GH_SDT,
                        'email' => $order_delivery->GH_Email,
                        'diachi' => $order_delivery->GH_DiaChi,
                        'hoadon_id' => $order_hd->HD_MaDon,
                        'tongtien' => $order->DDH_TongTien,
                        'content' => $content
                    ];
//Hàm gửi mail
                    Mail::to($order_delivery->GH_Email)->send(new SendMail($details));


                    Session::forget('cart');
                    Session::forget('coupon');
                    Session::forget('feeship');
                    Session::forget('count_cart');
                    $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai', '1')->orderby('XH_ID', 'desc')->get();
                    $pc_phongcach = DB::table('phongcach')->orderby('PC_ID', 'desc')->get();
                    $loai_loaisanpham = DB::table('loaisanpham')->orderby('LSP_ID', 'desc')->get();
                    return view('pages.thanhtoan.cash_thanhtoan')
                        ->with('xh_xuhuong', $xh_xuhuong)
                        ->with('pc_phongcach', $pc_phongcach)
                        ->with('loai_loaisanpham', $loai_loaisanpham)
                        ->with('message', 'Đặt hàng thành công, vui lòng kiểm tra email hoặc đăng nhập để theo dõi đơn hàng!');
                }
            }
        }


        //thêm vào hóa đơn

        // $data = array();
        // $data['HD_NgayXuat']=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        // $data['HD_TongTienTT']=$request->total;
        // $hoadon_id = DB::table('hoadon')->insertGetId($data);


        // // thông tin giao hàng
        // $data = array();
        // $data['GH_Ten'] =$request->gh_ten;
        // $data['GH_Email'] =$request->gh_email;
        // $data['GH_GhiChu'] =$request->gh_ghichu;
        // $data['GH_SDT'] =$request->gh_sdt;
        // $data['GH_DiaChi'] =$request->gh_diachi;
        // $data['HD_ID'] =$hoadon_id;

        // $giaohang_id = DB::table('thongtingiaohang')->insertGetId($data);

        // Session::put('GH_ID',$giaohang_id);
        // return redirect::to('/show-thanhtoan');
    }
	public function show_thanhtoan()
	{	
		$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
		return view('pages.thanhtoan.show_thanhtoan')
		->with('xh_xuhuong',$xh_xuhuong)
        ->with('pc_phongcach',$pc_phongcach)
        ->with('loai_loaisanpham',$loai_loaisanpham);
	}
	public function logout_thanhtoan()
	{
		Session::flush();
		return redirect::to('/login-thanhtoan');
	}
	public function login_khachhang(Request $request)
	{
        // dd('nhan');
		$kh_email = $request->kh_email;
		$kh_matkhau = md5($request->kh_matkhau);
		$result = DB::table('khachhang')->where('KH_Email',$kh_email)->where('KH_MatKhau',$kh_matkhau)->first();

		if($result)
		{
			Session::put('KH_ID',$result->KH_ID);
            Session::put('KH_Ten',$result->KH_Ten);
            Session::put('KH_Email',$result->KH_Email);
            Session::put('KH_SDT',$result->KH_SDT);
            Session::put('KH_DiaChi',$result->KH_DiaChi);
            Session::put('KH_MatKhau',$request->kh_matkhau);
			return redirect::to('/');
		}
		else{
			return redirect::to('/login-thanhtoan');
		}	
	}
	 public function don_dathang(Request $request)
     {
         // thêm vào hóa đơn
         $data = array();
         $data['HD_VAT'] = '21';
         $data['HD_TongTienTT'] = Cart::total();
         $hoadon_id = DB::table('hoadon')->insertGetId($data);

         $KH_Email = $request->kh_email;
         $KH_ID = Session::get('KH_ID');
         $KH = KhachHang::findOrfail($KH_ID);
         $tenkh = $KH->KH_Ten;
         $sdt = $KH->KH_SDT;
         $email = $KH->KH_Email;
         $diachi = $KH->KH_DiaChi;
         // thêm vào dondathang
         $dathang_data = array();
         $dathang_data['DDH_TongTien'] = Cart::total();
         $dathang_data['DDH_TrangThai'] = 'Đang chờ xử lí';
         $dathang_data['GH_ID'] = Session::get('GH_ID');
         $dathang_data['HD_ID'] = $hoadon_id;
         $dathang_data['KH_ID'] = Session::get('KH_ID');
         $dathang_id = DB::table('dondathang')->insertGetId($dathang_data);
         // thêm vào chi tiết đơn đặt hàng
         $content = Cart::content();
         foreach ($content as $v_content)
         {
             $chitiet_dathang_data['CTDDH_SoLuong'] = $v_content->qty;
             $chitiet_dathang_data['CTDDH_DonGia'] = $v_content->price;
             $chitiet_dathang_data['SP_ID'] = $v_content->id;
             $chitiet_dathang_data['DDH_ID'] = $dathang_id;
             $chitiet_dathang_id = DB::table('chitietdondathang')->insert($chitiet_dathang_data);
         }
//Detail này để truyền thông tin đơn hàng vào email để hiển thị cho khách hàng
         $details = [
             'tenkh' => $tenkh,
             'sdt' => $sdt,
             'email' => $email,
             'diachi' => $diachi,
             'hoadon_id' => $hoadon_id,
             'tongtien' => Cart::total(),
             'content' => $content
         ];
//Hàm gửi mail
         Mail::to($KH_Email)->send(new SendMail($details));

         $xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
         $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
         $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
         Cart::destroy();
         return view('pages.thanhtoan.cash_thanhtoan')
             ->with('xh_xuhuong',$xh_xuhuong)
             ->with('pc_phongcach',$pc_phongcach)
             ->with('loai_loaisanpham',$loai_loaisanpham);
     }



	// 	// thêm vào hóa đơn
	// 	$data = array();
	// 	$data['HD_VAT']=Cart::tax(0);
	// 	$data['HD_NgayXuat']=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
	// 	$data['HD_TongTienTT']=Cart::total(0); 
	// 	$hoadon_id = DB::table('hoadon')->insertGetId($data);



	// 	// thông tin giao hàng
	// 	$giaohang_data = array();
	// 	$giaohang_data['GH_Ten'] =$request->gh_ten;
	// 	$giaohang_data['GH_Email'] =$request->gh_email;
	// 	$giaohang_data['GH_GhiChu'] =$request->gh_ghichu;
	// 	$giaohang_data['GH_SDT'] =$request->gh_sdt;
	// 	$giaohang_data['GH_DiaChi'] =$request->gh_diachi;
	// 	$giaohang_data['HD_ID'] =$hoadon_id;
	// 	$giaohang_id = DB::table('thongtingiaohang')->insertGetId($giaohang_data);

		


	// 	// thêm vào dondathang
	// 	$dathang_data = array();
	// 	$dathang_data['DDH_NgayDat']=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
	// 	$dathang_data['DDH_TongTien']=Cart::total(0);
	// 	$dathang_data['DDH_TinhTrangThanhToan']=0;
	// 	$dathang_data['DDH_TinhTrangGiao']=0;
	// 	$dathang_data['DDH_TrangThai']=0;
	// 	$dathang_data['GH_ID']=$giaohang_id;
	// 	$dathang_data['HD_ID']=$hoadon_id;
	// 	$dathang_data['KH_ID']=Session::get('KH_ID');
	// 	$dathang_id = DB::table('dondathang')->insertGetId($dathang_data);

		


	// 	// thêm vào chi tiết đơn đặt hàng
	// 	$content=Cart::content();
	// 	foreach($content as $v_content)
	// 	{
	// 		$chitiet_dathang_data['CTDDH_SoLuong'] =$v_content->qty;
	// 		$chitiet_dathang_data['CTDDH_DonGia']=$v_content->price;
	// 		$chitiet_dathang_data['SP_ID']=$v_content->id; 
	// 		$chitiet_dathang_data['DDH_ID']=$dathang_id;
	// 		$chitiet_dathang_id = DB::table('chitietdondathang')->insert($chitiet_dathang_data);
	// 	}		
	// 	$xh_xuhuong = DB::table('xuhuong')->where('XH_TrangThai','1')-> orderby('XH_ID', 'desc')->get();
 //        $pc_phongcach = DB::table('phongcach')-> orderby('PC_ID', 'desc')->get();
 //        $loai_loaisanpham = DB::table('loaisanpham')-> orderby('LSP_ID', 'desc')->get();
	// 	Cart::destroy();
	// 	return view('pages.thanhtoan.cash_thanhtoan')
	// 	->with('xh_xuhuong',$xh_xuhuong)
 //        ->with('pc_phongcach',$pc_phongcach)
 //        ->with('loai_loaisanpham',$loai_loaisanpham);
	// }
	public function select_vanchuyen_home(Request $request)
	{
		$data = $request->all();
		
		if($data['action'])
		{
			$output='';
			if($data['action']=="city")
			{
				$select_province = QuanHuyen::where('TP_ID',$data['ma_id'])->orderby('QH_ID','ASC')->get();
					$output.='<option>--Chọn quận huyện--</option>';
				foreach($select_province as $key => $province)
				{
					$output.='<option value="'.$province->QH_ID.'">'.$province->QH_name.'</option>';
				}
			}else{
				$select_wards = XaPhuongThiTran::where('QH_ID',$data['ma_id'])->orderby('Xa_ID','ASC')->get();
					$output.='<option>--Chọn phường xã	 thị trấn--</option>';
				foreach($select_wards as $key => $wards)
				{
					$output.='<option value="'.$wards->Xa_ID.'">'.$wards->Xa_name.'</option>';
				}
			}
		}
		echo $output;
	}
	public function select_address(Request $request)
	{
        $data =$request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="order_city"){
                $select_province=QuanHuyen::where('TP_ID',$data['ma_id'])->orderby('QH_ID','ASC')->get();
                $output.='<option value="-1">---Chọn Quận Huyện---</option>';
                foreach($select_province as $key =>$province){
                    $output.='<option value="'.$province->QH_ID.'">'.$province->QH_name.'</option>';
                }
            }else{
    			$select_wards = XaPhuongThiTran::where('QH_ID',$data['ma_id'])->orderby('Xa_ID','ASC')->get();
    			$output.='<option value="-1">---Chọn Xã Phường Thị trấn---</option>';
    			foreach($select_wards as $k => $ward){
    				$output.='<option value="'.$ward->Xa_ID.'">'.$ward->Xa_name.'</option>';
    			}
    		}
            echo $output;
        }
    }
	public function calculate_fee(Request $request)
	{
		$data = $request->all();
		if($data['city'])
		{
			$feeship = VanChuyen::where('VC_ID_TP',$data['city'])
			->where('VC_ID_QH',$data['province'])
			->where('VC_ID_Xa',$data['wards'])->get();
			if($feeship)
			{
				$count_feeship = $feeship->count();
				if($count_feeship>0){
					foreach($feeship as $key => $fee){
					Session::put('feeship',$fee->VC_PhiVanChuyen);
					Session::save();
					}
				}else{
					Session::put('feeship',35000);
					Session::save();
				}
			}
		}
	}
}