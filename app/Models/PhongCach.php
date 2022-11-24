<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongCach extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'PC_Ten'
    ];
    protected $primaryKey = 'PC_ID';
 	protected $table = 'phongcach';


    public function SanPham()
    {
        return $this->hasMany('App\Models\SanPham');
    }
}