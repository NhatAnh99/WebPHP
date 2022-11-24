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
use App\Models\VanChuyen;
use App\Models\QuanHuyen;
use App\Models\TinhThanhPho;
use App\Models\XaPhuongThiTran;

class VanChuyenController extends Controller
{
	public function van_chuyen(Request $request)
	{
		$city = TinhThanhPho::orderby('TP_ID', 'ASC')->get();

		return view('admin.vanchuyen.add_vanchuyen')->with(compact('city'));
	}
	public function select_vanchuyen(Request $request)
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
	public function insert_vanchuyen(Request $request)
	{
		$data = $request->all();
		$fee_ship = new VanChuyen();
		$fee_ship->VC_ID_TP=$data['city'];
		$fee_ship->VC_ID_QH=$data['province'];
		$fee_ship->VC_ID_Xa=$data['wards'];
		$fee_ship->VC_PhiVanChuyen=$data['fee_ship'];
		$fee_ship->save();
	}
	public function select_feeship()
	{
		$fee_ship = VanChuyen::orderby('VC_ID','desc')->get();
		$output ='';
		$output .= '<div class="card-body">	
			<table class="table table-striped table-hover table-fw-widget">
				<thead>
					<tr>
						<th> Tỉnh - Thành Phố</th>
						<th> Quận - Huyện</th>
						<th> Xã - Phường - Thị Trấn</th>
						<th>Phí Ship</th>
					</tr>
				</thead>
				<tbody>
				';
				foreach($fee_ship as $key => $fee)
				{
					$output .='
					<tr>
						<td>'.$fee->tinhthanhpho->TP_name.'</td>
						<td>'.$fee->quanhuyen->QH_name.'</td>
						<td>'.$fee->xaphuongthitran->Xa_name.'</td>
						<td contenteditable data-feeship_id="'.$fee->VC_ID.'" class="fee_ship_edit">'.number_format($fee->VC_PhiVanChuyen,0,',','.',).'</td>
					</tr>
					';
				}
				$output .='
				</tbody>
			</table>
			</div>
			';
			echo $output;
	}
	public function update_vanchuyen(Request $request)
	{
		$data = $request->all();
		$fee_ship = VanChuyen::find($data['feeship_id']);
		$fee_val = rtrim($data['fee_val'],'.');
		$fee_ship->VC_PhiVanChuyen=$fee_val;
		$fee_ship->save();

	}
}