<div class="content-wrapper">
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-cd"></i> Danh sách sản phẩm</h1>
		<div class="breadcrumb">
			<?php
			if($user['role']==1){
				echo '<a class="btn btn-primary btn-sm" href="'.base_url().'admin/product/insert" role="button">
				<span class="glyphicon glyphicon-plus"></span> Thêm mới
				</a>';
			}
			?>
			<a class="btn btn-primary btn-sm" href="<?php echo base_url()?>admin/product/recyclebin" role="button">
				<span class="glyphicon glyphicon-trash"></span> Thùng rác(<?php $total=$this->Msanpham->product_trash_count(); echo $total; ?>)
			</a>
		</div>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box" id="view">
					<div class="box-header with-border">
						<div class="box-body">
							<?php if($this->session->flashdata('success')):?>
								<div class="row">
									<div class="alert alert-success">
										<?php echo $this->session->flashdata('success'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									</div>
								</div>
							<?php endif;?>
							<?php if($this->session->flashdata('error')):?>
								<div class="row">
									<div class="alert alert-error">
										<?php echo $this->session->flashdata('error'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									</div>
								</div>
							<?php endif;?>

							<div class="row" style='padding:0px; margin:0px;'>
								<div class="table-responsive">
									<table class="table table-hover modern-admin-table">
										<thead>
											<tr>
												<th class="text-center" style="width:20px">ID</th>
												<th>Hình</th>
												<th>Tên sản phẩm</th>
												<th class="text-center">Tồn kho</th>
												<th class="text-center">Đã bán</th>
												<th>Loại sản phẩm</th>
												<th class="text-center">Trạng thái</th>
												<th class="text-center">Nhập hàng</th>
												<th class="text-center" colspan="2">Thao tác</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($list as $row):?>
												<tr>
													<td class="text-center"><?php echo $row['id'] ?></td>
													<td>
														<img src="public/images/products/<?php echo $row['avatar'] ?>" alt="<?php echo $row['name'] ?>" class="modern-thumbnail">
													</td>
													<td class="article-title"><?php echo $row['name'] ?></td>
													<td class="text-center"><?php echo $row['number'] - $row['number_buy'] ?></td>
													<td class="text-center"><?php echo $row['number_buy'] ?></td>
													<?php 
													$namecat = $this->Mdanhmuc->category_name($row['catid']);
													?>
													<td><?php echo $namecat ?></td>
													<td class="text-center">
														<a href="<?php echo base_url() ?>admin/product/status/<?php echo $row['id'] ?>">
															<?php if($row['status']==1):?>
																<span class="glyphicon glyphicon-ok-circle mauxanh18"></span>
															<?php else: ?>
																<span class="glyphicon glyphicon-remove-circle maudo"></span>
															<?php endif; ?>
														</a>
													</td>
													<?php  
													if($user['role']==1){
														echo '
														<td class="text-center">
															<a class="btn btn-modern-import btn-xs" href="'.base_url().'admin/product/import/'.$row['id'].'" role="button">
																<span class="glyphicon glyphicon-log-in"></span> Nhập hàng
															</a>
														</td>
														<td class="text-center">
															<a class="btn btn-modern-edit btn-xs" href="'.base_url().'admin/product/update/'.$row['id'].'" role="button">
																<span class="glyphicon glyphicon-edit"></span> Sửa
															</a>
														</td>';
													}else{
														echo '
														<td class="text-center"><p class="fa fa-lock" style="color:red"> Không đủ quyền</p></td>
														<td></td>';
													}
													?>
													<td class="text-center">
														<a class="btn btn-modern-delete btn-xs" href="<?php echo base_url() ?>admin/product/trash/<?php echo $row['id'] ?>" onclick="return confirm('Xác nhận xóa sản phẩm này ?')" role="button">
															<span class="glyphicon glyphicon-trash"></span> Xóa
														</a>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>

								<div class="row">
									<div class="col-md-12 text-center">
										<ul class="pagination">
											<?php echo $strphantrang ?>
										</ul>
									</div>
								</div>
							</div>
						</div><!-- ./box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		</div>
	</section>
</div>

<!-- 🌈 STYLE MODERN DASHBOARD -->
<style>
/* Bảng dữ liệu hiện đại */
.box {
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    border-top: none;
}
.modern-admin-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-admin-table thead th {
    background: #f4f6f9;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 13px;
    padding: 15px;
    border-bottom: 2px solid #e9ecef;
}
.modern-admin-table tbody td {
    vertical-align: middle !important;
    padding: 15px;
    border-top: 1px solid #f0f2f5;
    color: #333;
}
.modern-admin-table tbody tr:hover {
    background-color: #f8f9fa;
}
.article-title {
    font-weight: 600;
    color: #2c3e50 !important;
    font-size: 15px;
}

/* Thumbnail bài viết/sản phẩm */
.modern-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.modern-thumbnail:hover {
    transform: scale(1.1);
}

/* Nút bấm (Sửa / Xóa / Nhập hàng) */
.btn-modern-edit, .btn-modern-delete, .btn-modern-import {
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    transition: all 0.3s ease;
    border: none;
    display: inline-block;
}

/* Nút Sửa (Xanh nhạt) */
.btn-modern-edit {
    background-color: #e8f4fd;
    color: #0984e3;
}
.btn-modern-edit:hover {
    background-color: #0984e3;
    color: #fff;
    box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3);
}

/* Nút Xóa (Đỏ nhạt) */
.btn-modern-delete {
    background-color: #ffeaea;
    color: #d63031;
}
.btn-modern-delete:hover {
    background-color: #d63031;
    color: #fff;
    box-shadow: 0 4px 10px rgba(214, 48, 49, 0.3);
}

/* Nút Nhập hàng (Xanh lá) */
.btn-modern-import {
    background-color: #e3fbf4;
    color: #00b894;
}
.btn-modern-import:hover {
    background-color: #00b894;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3);
}

/* Nút Thêm mới (Giữ nguyên màu thương hiệu nhưng đẹp hơn) */
.content-header .btn-primary {
    background: linear-gradient(135deg, #d70018, #ff4757);
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3);
    font-weight: 600;
    transition: all 0.3s ease;
}
.content-header .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(215, 0, 24, 0.4);
}

/* Icon Trạng thái */
.mauxanh18 {
    color: #00b894;
    font-size: 18px;
}
.maudo {
    color: #d63031;
    font-size: 18px;
}

/* Phân trang */
.pagination > li > a, .pagination > li > span {
    border-radius: 4px;
    margin: 0 3px;
    color: #d70018;
    border: none;
    background: #f4f6f9;
    font-weight: 600;
}
.pagination > .active > a, .pagination > .active > span {
    background: #d70018 !important;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(215, 0, 24, 0.2);
}
</style>
