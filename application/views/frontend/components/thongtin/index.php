<section id="content">
    <div class="container account" style="margin-top: 30px; margin-bottom: 50px;">
        <div class="row">
            <!-- Sidebar: Thông tin cá nhân -->
            <aside class="col-md-4 col-sm-12">
                <div class="account-card card-shadow">
                    <div class="card-header-modern">
                        <i class="fa fa-user-circle"></i>
                        <h3>Thông tin tài khoản</h3>
                    </div>
                    <div class="card-body-modern">
                        <div class="info-group">
                            <label>Tài khoản:</label>
                            <span><?php echo $info['username'] ?></span>
                        </div>
                        <div class="info-group">
                            <label>Họ và tên:</label>
                            <span><?php echo $info['fullname'] ?></span>
                        </div>
                        <div class="info-group">
                            <label>Email:</label>
                            <span><?php echo $info['email'] ?></span>
                        </div>
                        <div class="info-group">
                            <label>Số điện thoại:</label>
                            <span><?php echo $info['phone'] ?></span>
                        </div>
                        <hr>
                        <a href="reset_password" class="btn btn-danger btn-block btn-modern">
                            <i class="fa fa-lock"></i> Đổi mật khẩu
                        </a>

                        <!-- Phần thông báo Voucher -->
                        <div class="voucher-notification mt-4">
                            <h5 style="font-weight: bold; font-size: 14px;"><i class="fa fa-gift text-danger"></i> Quà tặng của bạn:</h5>
                            <?php 
                                $my_vouchers = $this->db->where('customer_id', $info['id'])
                                                        ->where('status', 1)
                                                        ->where('number_used < limit_number')
                                                        ->get('coupons')->result_array();
                                if(count($my_vouchers) > 0):
                                    foreach($my_vouchers as $v):
                            ?>
                                <div class="voucher-mini-card" style="background: #fff5f5; border: 1px dashed #ff4d4d; border-radius: 8px; padding: 10px; margin-bottom: 10px;">
                                    <div style="font-size: 11px; color: #888;"><?php echo $v['description'] ?></div>
                                    <div style="font-weight: bold; color: #d9534f; font-size: 15px; margin: 4px 0;"><?php echo $v['code'] ?></div>
                                    <div style="font-size: 10px; color: #999;">HSD: <?php echo date('d/m/Y', strtotime($v['expiration_date'])) ?></div>
                                </div>
                            <?php 
                                    endforeach;
                                else:
                            ?>
                                <p style="font-size: 12px; color: #999; font-style: italic;">Bạn chưa có mã giảm giá nào.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main: Danh sách đơn hàng -->
            <div class="col-md-8 col-sm-12">
                <div class="account-main-content card-shadow">
                    
                    <!-- Đơn hàng chưa duyệt -->
                    <?php if($this->Mthongtinkhach->order_listorder_customerid_not($info['id']) != null): ?>
                    <div class="order-section mb-5">
                        <div class="section-header">
                            <i class="fa fa-clock-o"></i>
                            <h4>Đơn hàng chưa duyệt</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $order = $this->Mthongtinkhach->order_listorder_customerid_not($info['id']);
                                    foreach ($order as $value):?>
                                        <tr>
                                            <td class="font-weight-bold">#<?php echo $value['orderCode'] ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($value['order_date'])) ?></td>
                                            <td class="text-center text-danger font-weight-bold"><?php echo number_format($value['money']) ?>₫</td>
                                            <td class="text-center">
                                                <span class="badge-status status-0">Đang chờ duyệt</span>
                                            </td>
                                            <td class="text-right">
                                                <a href="account/orders/<?php echo $value['id'] ?>" class="btn-action text-info" title="Xem chi tiết">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="thongtin/update/<?php echo $value['id'];?>" 
                                                   class="btn-action text-danger" 
                                                   onclick="return confirm('Xác nhận hủy đơn hàng này ?')"
                                                   title="Hủy đơn">
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tất cả đơn hàng -->
                    <div class="order-section">
                        <div class="section-header">
                            <i class="fa fa-list-alt"></i>
                            <h4>Lịch sử đơn hàng</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-right">Xem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $order = $this->Mthongtinkhach->order_listorder_customerid($info['id']);
                                    foreach ($order as $value):?>
                                        <tr>
                                            <td class="font-weight-bold">#<?php echo $value['orderCode'] ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($value['order_date'])) ?></td>
                                            <td class="text-center text-danger font-weight-bold"><?php echo number_format($value['money']) ?>₫</td>
                                            <td class="text-center">
                                                <?php
                                                switch ($value['status']) {
                                                    case '0': echo '<span class="badge-status status-0">Đang chờ duyệt</span>'; break;
                                                    case '1': echo '<span class="badge-status status-1">Đang giao hàng</span>'; break;
                                                    case '2': echo '<span class="badge-status status-2">Đã giao</span>'; break;
                                                    case '3': echo '<span class="badge-status status-3">Khách đã hủy</span>'; break;
                                                    case '4': echo '<span class="badge-status status-4">Hệ thống hủy</span>'; break;
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="account/orders/<?php echo $value['id'] ?>" class="btn-action text-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
