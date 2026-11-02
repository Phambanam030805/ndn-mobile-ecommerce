<div class="content-wrapper">
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-picture"></i> Quản lý sliders</h1>
		<div class="breadcrumb">
			<?php
			if($user['role']==1){
				echo '<a class="btn btn-primary btn-sm" href="'.base_url().'admin/sliders/insert" role="button">
				<span class="glyphicon glyphicon-plus"></span> Thêm mới
				</a>';
			}
			?>
			<a class="btn btn-primary btn-sm" href="<?php echo base_url()?>admin/sliders/recyclebin" role="button">
				<span class="glyphicon glyphicon-trash"></span> Thùng rác
                (<?php echo (isset($this->Mtrinhchieu)) ? $this->Mtrinhchieu->content_trash_count('slider') : 0; ?>)
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

							<div class="row">
								<div class="table-responsive">
									<?php 
										$cur_page = isset($current) ? $current : (isset($this->phantrang) ? $this->phantrang->PageCurrent() : 1);
										$stt = ($cur_page - 1) * 10 + 1;
									?>
									<table class="table table-hover modern-admin-table">
										<thead>
											<tr>
												<th class="text-center" style="width: 60px;">STT</th>
												<th>Hình</th>
												<th>Tên sliders</th>
												<th>Liên kết</th>
												<th class="text-center">Trạng thái</th>
												<th class="text-center" colspan="2">Thao tác</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($list as $row):?>
												<tr>
													<td class="text-center" style="font-weight: 600; color: #64748b;"><?php echo $stt++; ?></td>
													<td>
														<img src="public/images/banners/<?php echo $row['img'] ?>" class="modern-thumbnail-slider">
													</td>
													<td class="article-title">
														<a href="<?php echo base_url() ?>admin/sliders/update/<?php echo $row['id'] ?>">
															<?php echo $row['title'] ?>
														</a>
													</td>
													<td><?php echo $row['link'] ?></td>
													<td class="text-center">
														<a href="<?php echo base_url() ?>admin/sliders/status/<?php echo $row['id'] ?>">
															<?php if($row['status']==1):?>
																<span class="glyphicon glyphicon-ok-circle mauxanh18"></span>
															<?php else: ?>
																<span class="glyphicon glyphicon-remove-circle maudo"></span>
															<?php endif; ?>
														</a>
													</td>
													<?php
													if($user['role']==1){
														echo '<td class="text-center">
															<a class="btn btn-modern-edit btn-xs" href="'.base_url().'admin/sliders/update/'.$row['id'].'" role="button">
																<span class="glyphicon glyphicon-edit"></span> Sửa
															</a>
														</td>';
													}
													?>
													<td class="text-center">
														<a class="btn btn-modern-delete btn-xs" href="<?php echo base_url() ?>admin/sliders/trash/<?php echo $row['id'] ?>" onclick="return confirm('Xác nhận xóa slider này ?')" role="button">
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
.box { border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: none; }
.modern-admin-table { border-collapse: separate; border-spacing: 0; width: 100%; }
.modern-admin-table thead th { background: #f4f6f9; color: #495057; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 15px; border-bottom: 2px solid #e9ecef; }
.modern-admin-table tbody td { vertical-align: middle !important; padding: 15px; border-top: 1px solid #f0f2f5; color: #333; }
.modern-admin-table tbody tr:hover { background-color: #f8f9fa; }
.article-title { font-weight: 600; color: #2c3e50 !important; font-size: 15px; }

/* Thumbnail Slider */
.modern-thumbnail-slider {
    width: 150px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.modern-thumbnail-slider:hover { transform: scale(1.1); }

/* Nút bấm (Sửa / Xóa) */
.btn-modern-edit, .btn-modern-delete { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; transition: all 0.3s ease; border: none; display: inline-block; }
.btn-modern-edit { background-color: #e8f4fd; color: #0984e3; }
.btn-modern-edit:hover { background-color: #0984e3; color: #fff; box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3); }
.btn-modern-delete { background-color: #ffeaea; color: #d63031; }
.btn-modern-delete:hover { background-color: #d63031; color: #fff; box-shadow: 0 4px 10px rgba(214, 48, 49, 0.3); }

/* Nút Thêm mới */
.content-header .btn-primary { background: linear-gradient(135deg, #d70018, #ff4757); border: none; border-radius: 6px; padding: 8px 16px; box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3); font-weight: 600; transition: all 0.3s ease; }
.content-header .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(215, 0, 24, 0.4); }

/* Icon Trạng thái */
.mauxanh18 { color: #00b894; font-size: 18px; }
.maudo { color: #d63031; font-size: 18px; }

/* Phân trang */
.pagination > li > a, .pagination > li > span { border-radius: 4px; margin: 0 3px; color: #d70018; border: none; background: #f4f6f9; font-weight: 600; }
.pagination > .active > a, .pagination > .active > span { background: #d70018 !important; color: #fff !important; box-shadow: 0 4px 10px rgba(215, 0, 24, 0.2); }
</style>
