<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-comments"></i> Quản lý Đánh giá & Bình luận</h1>
        <div class="breadcrumb">
            <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>admin/reviews/recyclebin" role="button">
                <span class="glyphicon glyphicon-trash"></span> Thùng rác (<?php $total=$this->Mreview->review_trash_count(); echo $total; ?>)
            </a>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="view">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách đánh giá</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php  if($this->session->flashdata('success')):?>
                            <div class="row">
                                <div class="alert alert-success">
                                    <?php echo $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Sản phẩm</th>
                                        <th>Người đánh giá</th>
                                        <th class="text-center">Số sao</th>
                                        <th>Nội dung</th>
                                        <th class="text-center">Ngày gửi</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $row['id'] ?></td>
                                            <td>
                                                <?php 
                                                $product = $this->Msanpham->product_detail_id($row['link']);
                                                if($product) echo $product['name'];
                                                else echo "Sản phẩm đã bị xóa (ID: ".$row['link'].")";
                                                ?>
                                            </td>
                                            <td>
                                                <strong><?php echo $row['fullname'] ?></strong><br>
                                                <small><?php echo $row['email'] ?></small>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                $stars = (int)$row['title'];
                                                for($i=1; $i<=5; $i++) {
                                                    if($i <= $stars) {
                                                        echo '<i class="glyphicon glyphicon-star" style="color: #f39c12; font-size: 15px;"></i>';
                                                    } else {
                                                        echo '<i class="glyphicon glyphicon-star-empty" style="color: #ddd; font-size: 15px;"></i>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row['content'] ?></td>
                                            <td class="text-center"><?php echo date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url() ?>admin/reviews/status/<?php echo $row['id'] ?>">
                                                    <?php if($row['status']==1): ?>
                                                        <span class="label label-success">Đã duyệt</span>
                                                    <?php else: ?>
                                                        <span class="label label-warning">Chờ duyệt</span>
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() ?>admin/reviews/trash/<?php echo $row['id'] ?>" onclick="return confirm('Xác nhận xóa đánh giá này?')" role="button">
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
                                    <?php echo $strphantrang; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>