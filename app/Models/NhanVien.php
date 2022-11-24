<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NhanVien extends Model
{
	public $timeStamp = false;
	protected $fillable = [
		'NV_Ten', 'NV_GioiTinh', 'NV_Email', 'NV_SDT', 'NV_DiaChi', 'NV_TaiKhoan', 'NV_MatKhau'
	];
	protected $primaryKey='NV_ID';
	protected $table = 'nhanvien';

	
	public function DonNhapHang()
	{
		return $this->belongsTo('App\Models\DonNhapHang');
	}
}
 ?>
