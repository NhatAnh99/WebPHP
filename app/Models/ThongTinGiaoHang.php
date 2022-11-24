<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinGiaoHang extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'GH_Ten', 'GH_Email', 'GH_SDT', 'GH_DiaChi','GH_GhiChu','GH_MaDon'
    ];
    protected $primaryKey = 'GH_ID';
 	protected $table = 'thongtingiaohang';
    
    
}