<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//frontend
Route::get('/', 'HomeController@index');
Route::get('/home-layout','HomeController@index');
Route::get('/chi-tiet-san-pham/{sp_ID}','HomeController@chitiet_sanpham');



//mausac
Route::get('/shop-sanpham-blue','SanPhamController@shop_sanpham_blue');
Route::get('/shop-sanpham-yellow','SanPhamController@shop_sanpham_yellow');
Route::get('/shop-sanpham-black','SanPhamController@shop_sanpham_black');
Route::get('/shop-sanpham-red','SanPhamController@shop_sanpham_red');   
Route::get('/shop-sanpham-green','SanPhamController@shop_sanpham_green');
Route::get('/shop-sanpham-orange','SanPhamController@shop_sanpham_orange');

//thaydoithongtinkhachhang trangchu
Route::get('/profile','ProfileController@profile');
Route::post('/update-khachhang','ProfileController@update_khachhang');

//Binhluan khachhang
Route::post('/post-comment-customer', 'CommentController@PostCommentCustomer');
Route::post('/load-comment','CommentController@LoadComment');
Route::post('/approval-comment', 'CommentController@ApprovalComment');
Route::get('/delete-comment/{comment_id}', 'CommentController@DeleteComment');


//timkiemkhachhang
Route::get('/search-product-customer', 'SearchController@ShowProductSearchHeaderCustomer');
Route::get('/search-product-filter-customer', 'SearchController@ShowProductSearchFilterCustomer');


//timkiemtrangchu
Route::post('/timkiem-sanpham','HomeController@timkiem_sanpham');

//mo rong
Route::get('/shop-ngoaihanganh','SanPhamController@show_ngoaihanganh');


//sanphamtrangchu

Route::get('/shop-sanpham','SanPhamController@shop_sanpham');
Route::get('/shop-sanpham-nu','SanPhamController@shop_sanpham_nu');
Route::get('/shop-sanpham-nam','SanPhamController@shop_sanpham_nam');
Route::get('/yeuthich-sanpham','SanPhamController@yeuthich_sanpham');

//sanphamyeuthich
// Route::get('/yeu-thich-san-pham/{id}','SanPhamController@yeuthich_sanpham')->name('sanpham.yeuthich');
// Route::get('/san-pham-yeu-thich','SanPhamController@sanpham_yeuthich')->name('sanpham.sanpham_yeuthich');

//loaisanphamtrangchu
Route::get('/loai-san-pham/{lsp_ID}','LoaiSanPhamController@show_loaisanpham_home');

//xuhuongtrangchu
Route::get('/xu-huong-san-pham/{xh_ID}','XuHuongController@show_xuhuong_home');



//phongcachtrangchu
Route::get('/phong-cach-san-pham/{pc_ID}','PhongCachController@show_phongcach_home');



//dondathangkhachhang
Route::get('/show-order-tracking-detail/{order_id}', 'HomeController@ShowOrderTrackingDetail');
Route::get('/show-order-tracking','HomeController@ShowOrderTracking');
Route::get('/order-tracking','HomeController@OrderTracking');
Route::post('/get-order-tracking','HomeController@GetRequestOrderTracking');

Route::post('/del-dondathang/{id}','HomeController@edit_OrderTracking');





//giohang
Route::post('/save-giohang','GioHangController@save_giohang');
Route::get('/delete-giohang/{rowId}','GioHangController@delete_giohang');
Route::get('/show-giohang','GioHangController@show_giohang');
Route::post('/add-cart-ajax','GioHangController@add_cart_ajax');
Route::get('/gio-hang','GioHangController@gio_hang');
Route::post('/update-cart','GioHangController@update_cart');
Route::get('/delete-cart/{session_id}','GioHangController@delete_cart');

//khuyenmai
Route::get('/send-coupon','KhuyenMaiController@send_coupon');
Route::post('/check-coupon','KhuyenMaiController@check_coupon');
Route::post('/insert-coupon-code','KhuyenMaiController@insert_coupon_code');
Route::get('/insert-coupon','KhuyenMaiController@insert_coupon');
Route::get('/list-coupon','KhuyenMaiController@list_coupon');
Route::get('/delete-coupon/{coupon_ID}','KhuyenMaiController@delete_coupon');



//thanhtoan
Route::get('/login-thanhtoan','ThanhToanController@login_thanhtoan');
Route::get('/logout-thanhtoan','ThanhToanController@logout_thanhtoan');
Route::get('/fill-thanhtoan','ThanhToanController@fill_thanhtoan');
Route::get('/show-thanhtoan','ThanhToanController@show_thanhtoan');
Route::post('/add-khachhang','ThanhToanController@add_khachhang');
Route::post('/login-khachhang','ThanhToanController@login_khachhang');
Route::post('/save-thanhtoan-khachhang','ThanhToanController@save_thanhtoan_khachhang');
Route::post('/don-dathang','ThanhToanController@don_dathang');
Route::post('/select-vanchuyen-home','ThanhToanController@select_vanchuyen_home');
Route::post('/calculate-fee','ThanhToanController@calculate_fee');
Route::post('/select-address','ThanhToanController@select_address');





//sendmail
Route::get('/send-mail','SendMailController@send_mail');
Route::get('/send-mail-all','SendMailController@send_mail_all');




//backend
Route::get('/admin-login','AdminController@index');
Route::get('/admin','AdminController@show_layout');
Route::get('/admin-logout','AdminController@logout');
Route::post('/admin-admin','AdminController@show_admin');


//loaisanphamAdmin
Route::get('/all-loaisanpham','LoaiSanPhamController@all_loaisanpham');
Route::get('/add-loaisanpham','LoaiSanPhamController@add_loaisanpham');
Route::get('/edit-loaisanpham/{loai_ID}','LoaiSanPhamController@edit_loaisanpham');
Route::get('/delete-loaisanpham/{loai_ID}','LoaiSanPhamController@delete_loaisanpham');

Route::post('/save-loaisanpham','LoaiSanPhamController@save_loaisanpham');
Route::post('/update-loaisanpham/{loai_ID}','LoaiSanPhamController@update_loaisanpham');

//phongcachadmin
Route::get('/all-phongcach','PhongCachController@all_phongcach');
Route::get('/add-phongcach','PhongCachController@add_phongcach');
Route::get('/edit-phongcach/{phongcach_ID}','PhongCachController@edit_phongcach');
Route::get('/delete-phongcach/{phongcach_ID}','PhongCachController@delete_phongcach');

Route::post('/save-phongcach','PhongCachController@save_phongcach');
Route::post('/update-phongcach/{phongcach_ID}','PhongCachController@update_phongcach');


//xuhuongadmin
Route::get('/all-xuhuong','XuHuongController@all_xuhuong');
Route::get('/add-xuhuong','XuHuongController@add_xuhuong');
Route::get('/edit-xuhuong/{xuhuong_ID}','XuHuongController@edit_xuhuong');
Route::get('/delete-xuhuong/{xuhuong_ID}','XuHuongController@delete_xuhuong');


Route::get('/active-xuhuong/{xuhuong_ID}','XuHuongController@active_xuhuong');
Route::get('/unactive-xuhuong/{xuhuong_ID}','XuHuongController@unactive_xuhuong');


Route::post('/save-xuhuong','XuHuongController@save_xuhuong');
Route::post('/update-xuhuong/{xuhuong_ID}','XuHuongController@update_xuhuong');



//nhacungcapadmin
Route::get('/all-nhacungcap','NhaCungCapController@all_nhacungcap');
Route::get('/add-nhacungcap','NhaCungCapController@add_nhacungcap');
Route::get('/edit-nhacungcap/{nhacungcap_ID}','NhaCungCapController@edit_nhacungcap');
Route::get('/delete-nhacungcap/{nhacungcap_ID}','NhaCungCapController@delete_nhacungcap');


Route::post('/save-nhacungcap','NhaCungCapController@save_nhacungcap');
Route::post('/update-nhacungcap/{nhacungcap_ID}','NhaCungCapController@update_nhacungcap');


// khachhang
Route::get('/all-khachhang',[
    'as' =>'allKhachHang',
    'uses' => 'KhachHangController@all_khachhang'
]);


//sanphamadmin
Route::get('/add-sanpham','SanPhamController@add_sanpham');
Route::get('/all-sanpham','SanPhamController@all_sanpham');
Route::get('/edit-sanpham/{sanpham_ID}','SanPhamController@edit_sanpham');
Route::get('/delete-sanpham/{sanpham_ID}','SanPhamController@delete_sanpham');

Route::get('/active-sanpham/{sanpham_ID}','SanPhamController@active_sanpham');
Route::get('/unactive-sanpham/{sanpham_ID}','SanPhamController@unactive_sanpham');


Route::post('/save-sanpham','SanPhamController@save_sanpham');
Route::post('/update-sanpham/{sanpham_ID}','SanPhamController@update_sanpham');








//dondathangadmin
Route::get('/add-dondathang','DonDatHangController@add_dondathang');
Route::get('/add-show-dondathang','DonDatHangController@add_show_dondathang');
Route::get('/all-dondathang','DonDatHangController@all_dondathang');
Route::get('/view-dondathang/{dondathang_ID}','DonDatHangController@view_dondathang');
Route::get('/edit-dondathang/{dondathang_ID}','DonDatHangController@edit_dondathang');
Route::get('/addrow-dondathang','DonDatHangController@addrow_dondathang');

Route::get('/active-dondathang/{dondathang_ID}','DonDatHangController@active_dondathang');
Route::get('/unactive-dondathang/{dondathang_ID}','DonDatHangController@unactive_dondathang');
Route::get('/chuaxuly-dondathang','DonDatHangController@chuaxuly_dondathang');
Route::get('/daxuly-dondathang','DonDatHangController@daxuly_dondathang');
Route::get('/dangxuly-dondathang','DonDatHangController@dangxuly_dondathang');
Route::get('/hoantat-dondathang','DonDatHangController@hoantat_dondathang');
Route::get('/huy-dondathang','DonDatHangController@huy_dondathang');
Route::get('/delivery', 'DonDatHangController@getdelivery');



Route::post('/save-dondathang','DonDatHangController@save_dondathang');
Route::post('/update-dondathang/{dondathang_ID}','DonDatHangController@update_dondathang');


//vanchuyen
Route::get('/van-chuyen','VanChuyenController@van_chuyen');
Route::post('/select-vanchuyen','VanChuyenController@select_vanchuyen');
Route::post('/insert-vanchuyen','VanChuyenController@insert_vanchuyen');
Route::post('/select-feeship','VanChuyenController@select_feeship');
Route::post('/update-vanchuyen','VanChuyenController@update_vanchuyen');

//Binhluan
Route::get('/comment', 'CommentController@Index');




//thongke

Route::get('/sales-statistics', 'StatisticsController@ShowSalesStatistics');