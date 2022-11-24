<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhThanhPho extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'TP_name', 'TP_type'
    ];
    protected $primaryKey = 'TP_ID';
 	protected $table = 'tinhthanhpho';

}
    