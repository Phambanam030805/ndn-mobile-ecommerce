<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-cd"></i> Thùng rác đánh giá</h1>
        <div class="breadcrumb">
            <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>admin/reviews" role="button">
                <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
            </a>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="view">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách đánh giá đã xóa</h3>
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
                                            <td class="text-center">
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url() ?>admin/reviews/restore/<?php echo $row['id'] ?>" role="button">
                                                    <i class="fa fa-undo"></i> Khôi phục
                                                </a>
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() ?>admin/reviews/delete/<?php echo $row['id'] ?>" onclick="return confirm('Xác nhận xóa vĩnh viễn đánh giá này?')" role="button">
                                                    <i class="fa fa-trash"></i> Xóa vĩnh viễn
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