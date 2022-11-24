<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonDatHang extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'CTDDH_SoLuong', 'CTDDH_DonGia', 'DDH_ID', 'SP_ID','CTDDH_MaDon'
    ];
    protected $primaryKey = 'CTDDH_ID';
 	protected $table = 'chitietdondathang';

    public function sanpham()
    {
        return $this->hasMany('App\Models\SanPham','SP_ID');
    }
    public function dondathang()
    {
        return $this->belongsTo('App\Models\DonDatHang','DDH_ID');
    }
    
}