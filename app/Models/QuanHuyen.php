<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'QH_name', 'QH_type','TP_ID'
    ];
    protected $primaryKey = 'QH_ID';
 	protected $table = 'quanhuyen';

}
    