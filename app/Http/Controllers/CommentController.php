<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Nhanvien;
use App\Models\KhachHang;
use App\Models\sanpham;
use App\Models\XuHuong;
use App\Models\DonNhapHang;
use App\Models\PhongCach;
use App\Models\NhaCungCap;
use App\Models\LoaiSanPham;
use App\Models\ThongTinGiaoHang;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDatHang;
use App\Models\BinhLuan;


class CommentController extends Controller
{
	public function AuthLogin()
    {
        $NV_ID = Session::get('NV_ID');
        if($NV_ID)
           return redirect::to('/admin');
        else
            return redirect::to('/admin-login')->send();
    }
    public function Index(){
        $this->AuthLogin();
            $comment_customer=BinhLuan::where('BL_PhanHoi', '=', 0)->orderby('BL_ID', 'DESC')->paginate(5);
            $comment_admin=BinhLuan::where('BL_PhanHoi', '>', 0)->paginate(5);
            return view('admin.binhluan.show_comment')->with(compact('comment_customer', 'comment_admin'));
    }
	public function PostCommentCustomer(Request $request){
        $data=$request->all();
        $customer=Session::get('KH_ID');

        // $order=ChiTietDonDatHang::where('CTDDH_MaDon',)->get();
        if($data['review_name']==NULL || $data['review_comment']==NULL){
            return redirect()->back()->with('Thêm bình luận không thành công, vui lòng nhập đầy đủ các trường!');
        }
        // elseif(!$order){
        // 	return redirect()->back()->with('Vui lòng mua sản phẩm để bình luận!');
        // }
        	else{
            if($customer){
                $comment=new BinhLuan();
                $comment->BL_Ten=$data['review_name'];
                $comment->BL_NoiDung=$data['review_comment'];
                $comment->BL_PhanHoi=0;
                $comment->BL_TrangThai=0;
                $comment->KH_ID= Session::get('KH_ID');
                $comment->NV_ID=0;
                $comment->CTDDH_ID=$data['product_id'];
                $comment->save();
            }else{
                $comment=new BinhLuan();
                $comment->BL_Ten=$data['review_name'];
                $comment->BL_NoiDung=$data['review_comment'];
                $comment->BL_PhanHoi=0;
                $comment->BL_TrangThai=0;
                $comment->KH_ID= Session::get('KH_ID');
                $comment->NV_ID=0;
                $comment->CTDDH_ID=$data['product_id'];
                $comment->save();
            }
            return redirect()->back()->with('message','Đã thêm bình luận thành công, đang chờ phê duyệt!');
        }
    }

    public function LoadComment(Request $request){
            $product_id=$request->comment_product_id;
            $comment_customer=BinhLuan::where('CTDDH_ID', $product_id)->where('BL_PhanHoi', '=', 0)->get();
            $comment_admin=BinhLuan::with('ChiTietDonDatHang')->where('BL_PhanHoi', '>', 0)->get();
            $output = '';
            foreach ($comment_customer as $key => $comment) {
                $output .= '
                <div class="product_info_inner ">
                    <div class="product_ratting mb-10 col-md-6">
                        <strong>'.$comment->BL_Ten.'</strong>
                        <p>'.$comment->BL_NoiDung.'</p>
                    </div>
                    &emsp;&emsp;';
                foreach ($comment_admin as $k =>$ad_comment) {
                    if ($ad_comment->BL_PhanHoi==$comment->BL_ID) {
                        $output .= '
                            <div class="col-md-6">
                            <div class="product_demo">
                                <strong>Admin</strong>
                                <p>'.$ad_comment->BL_NoiDung.'</p>
                            </div>
                        </div>
                            ';
                    }
                }
                $output .= '
                </div>
            ';
            }
            echo $output;
        }
    public function ApprovalComment(Request $request) {
        $this->AuthLogin();
            $data = $request->all();
            $comment = BinhLuan::find($data['comment_id']);
            $comment->BL_TrangThai = $data['comment_status'];
            $comment->save();
        
	}
	public function DeleteComment($comment_id){
        $this->AuthLogin();
            $comment=BinhLuan::find($comment_id);
            if (!$comment) {
                return Redirect::to('comment')->with('error', 'Không tồn tại đánh giá!');
            } else {
                $comment->delete();
                BinhLuan::where('BL_PhanHoi', $comment_id)->delete();
                return Redirect::to('comment')->with('message', 'Xóa thành công!');
            }
    }
}