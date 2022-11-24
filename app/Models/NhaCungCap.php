<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'NCC_Ten', 'NCC_SDT', 'NCC_Email', 'NCC_Hinh'
    ];
    protected $primaryKey = 'NCC_ID';
 	protected $table = 'nhacungcap';

 	public function DonNhapHang()
 	{
 		 return $this->hasMany('App\Models\DonNhapHang');
 	}
}