<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanChuyen extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'VC_ID_TP', 'VC_ID_Xa','VC_ID_QH','VC_PhiVanChuyen'
    ];
    protected $primaryKey = 'VC_ID';
 	protected $table = 'vanchuyen';



    public function tinhthanhpho()
    {
        return $this->belongsTo('App\Models\TinhThanhPho','VC_ID_TP');
    }
    public function quanhuyen()
    {
        return $this->belongsTo('App\Models\QuanHuyen','VC_ID_QH');
    }
    public function xaphuongthitran()
    {
        return $this->belongsTo('App\Models\XaPhuongThiTran','VC_ID_Xa');
    }
}
    