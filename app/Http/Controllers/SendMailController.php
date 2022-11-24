<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\ThongTinGiaoHang;




class SendMailController extends Controller
{
	public function send_mail()
	{
		$to_name = "NhatAnh Le";
		$to_email = "nhatanhle6343322@gmail.com";


		$data = array("name" => "Áo Ta Sport 2022", "body" =>"Chào Mừng Bạn Đến Với Áo Ta Sport");
			Mail::send('pages.sendmail.send_mail',$data,function($message) use($to_email,$to_name)
			{
				$message->to($to_email)->subject('Hello');
				$message->to($to_email,$to_name);
			});
	}

	public function send_mail_all()
	{
		$all_mail = ThongTinGiaoHang::where('GH_ID')->get();
		$now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
		$title_mail = "Đơn đặt hàng".''.$now;
		$data = [];
		foreach($all_mail as $mail)
		{
			$data['email'][] = $mail->GH_Email;
		}
		dd($data);
		Mail::send('pages.sendmail.send_mail',$data,function($message) use($title_mail,$data)
			{
				$message->to($data['email'])->subject($title_mail);
				$message->from($data['email'],$title_mail);
			});
		return redirect()->back()->with('message','Gửi mail thành công');
	}
}