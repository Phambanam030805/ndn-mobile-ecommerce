<style>
  .dashboard-card { border-radius: 10px; transition: all 0.3s; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
  .dashboard-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.2); }
  .info-box-icon { border-radius: 10px 0 0 10px !important; }
  .table-modern thead th { background: #f8f9fa; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: #777; }
  .status-badge { border-radius: 20px; padding: 3px 12px; font-size: 11px; font-weight: 600; }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fa fa-dashboard"></i> Bảng điều khiển Quản trị <small>Thống kê chi tiết hệ thống</small></h1>
  </section>

  <section class="content">
    <!-- 4 Box Tổng quan -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box dashboard-card">
          <span class="info-box-icon bg-aqua"><i class="ion ion-bag"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">SẢN PHẨM</span>
            <span class="info-box-number"><?php echo number_format($total_products); ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box dashboard-card">
          <span class="info-box-icon bg-red"><i class="ion ion-ios-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">ĐƠN HÀNG</span>
            <span class="info-box-number"><?php echo number_format($total_orders); ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box dashboard-card">
          <span class="info-box-icon bg-green"><i class="ion ion-person-stalker"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">KHÁCH HÀNG</span>
            <span class="info-box-number"><?php echo number_format($total_customers); ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box dashboard-card">
          <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">DOANH THU</span>
            <span class="info-box-number"><?php echo number_format($total_revenue); ?>đ</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Biểu đồ doanh thu 12 tháng -->
      <div class="col-md-8">
        <div class="box box-primary dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title">Phân tích kinh doanh năm <?php echo date('Y'); ?></h3>
          </div>
          <div class="box-body">
            <div id="main-chart" style="height: 350px; width: 100%;"></div>
          </div>
        </div>
      </div>

      <!-- Biểu đồ Trạng thái đơn hàng -->
      <div class="col-md-4">
        <div class="box box-danger dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title">Trạng thái Đơn hàng</h3>
          </div>
          <div class="box-body text-center">
            <div id="status-chart" style="height: 350px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Top Sản phẩm bán chạy -->
      <div class="col-md-6">
        <div class="box box-info dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title">Top 10 Sản phẩm bán chạy</h3>
          </div>
          <div class="box-body">
            <table class="table table-modern">
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th>Giá hiện tại</th>
                  <th class="text-center">Đã bán</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($best_selling_products as $p): ?>
                <tr>
                  <td>
                    <img src="public/images/products/<?php echo $p['avatar'] ?>" style="width:30px; margin-right: 10px;">
                    <span style="font-weight: 600;"><?php echo $p['name'] ?></span>
                  </td>
                  <td><?php echo number_format($p['price_sale'] > 0 ? $p['price_sale'] : $p['price']) ?>đ</td>
                  <td class="text-center"><span class="badge bg-blue"><?php echo $p['number_buy'] ?></span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Đơn hàng mới nhất -->
      <div class="col-md-6">
        <div class="box box-success dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title">Đơn hàng mới nhất</h3>
          </div>
          <div class="box-body">
            <table class="table table-modern">
              <thead>
                <tr>
                  <th>Mã</th>
                  <th>Khách hàng</th>
                  <th>Tổng tiền</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($latest_orders as $o): ?>
                <tr>
                  <td><a href="admin/orders/view/<?php echo $o['id'] ?>">#<?php echo $o['orderCode'] ?></a></td>
                  <td><?php echo $o['fullname'] ?></td>
                  <td style="color: #dd4b39; font-weight: 600;"><?php echo number_format($o['money']) ?>đ</td>
                  <td>
                    <?php 
                      if($o['status']==0) echo '<span class="status-badge bg-orange">Chờ duyệt</span>';
                      elseif($o['status']==1) echo '<span class="status-badge bg-blue">Đang giao</span>';
                      elseif($o['status']==2) echo '<span class="status-badge bg-green">Thành công</span>';
                      else echo '<span class="status-badge bg-red">Đã hủy</span>';
                    ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="box-footer text-center">
            <a href="admin/orders" class="uppercase">Xem tất cả đơn hàng</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Cảnh báo Kho hàng & Đánh giá mới nhất -->
    <div class="row">
      <div class="col-md-7">
        <div class="box box-warning dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title text-warning"><i class="fa fa-warning"></i> Cảnh báo kho hàng (Sắp hết sản phẩm)</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <?php foreach ($low_stock_products as $lp): ?>
              <div class="col-md-4 col-sm-6 col-xs-6">
                <div style="padding: 10px; border: 1px solid #eee; border-radius: 5px; margin-bottom: 10px;">
                  <img src="public/images/products/<?php echo $lp['avatar'] ?>" style="width:100%; height: 100px; object-fit: contain;">
                  <h5 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 13px;"><?php echo $lp['name'] ?></h5>
                  <p style="margin:0; font-size: 12px;">Còn lại: <b class="text-red"><?php echo $lp['number'] ?></b></p>
                </div>
              </div>
              <?php endforeach; ?>
              <?php if(empty($low_stock_products)) echo '<div class="col-md-12 text-center text-muted">Tất cả sản phẩm đều đủ số lượng kho.</div>'; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="box box-solid dashboard-card">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-comments-o"></i> Đánh giá mới nhất</h3>
          </div>
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php foreach ($latest_reviews as $rev): ?>
              <li class="item">
                <div class="product-img">
                  <img src="public/images/products/<?php echo $rev['product_img'] ?>" alt="Product Image">
                </div>
                <div class="product-info">
                  <a href="admin/reviews" class="product-title"><?php echo $rev['fullname'] ?>
                    <span class="pull-right">
                      <?php 
                        $stars = (int)$rev['title'];
                        for($i=1; $i<=5; $i++): 
                      ?>
                        <i class="fa fa-star <?php echo ($i <= $stars) ? 'text-yellow' : 'text-gray'; ?>" style="font-size: 10px;"></i>
                      <?php endfor; ?>
                    </span>
                  </a>
                  <span class="product-description" style="font-style: italic;">
                    "<?php echo (strlen($rev['content']) > 60) ? substr($rev['content'], 0, 60).'...' : $rev['content']; ?>"
                  </span>
                </div>
              </li>
              <?php endforeach; ?>
              <?php if(empty($latest_reviews)) echo '<li class="item text-center text-muted">Chưa có đánh giá nào.</li>'; ?>
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="admin/reviews" class="uppercase">Xem tất cả đánh giá</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SCRIPTS -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawCharts);

  function drawCharts() {
    // 1. Biểu đồ doanh thu
    var dataRevenue = google.visualization.arrayToDataTable([
      ['Tháng', 'Doanh thu'],
      <?php for($i=1; $i<=12; $i++) echo "['T$i', {$revenue_months[$i]}],"; ?>
    ]);
    var optionsRevenue = {
      legend: { position: 'none' },
      chartArea: {width: '90%', height: '80%'},
      vAxis: { format: 'short' },
      colors: ['#3c8dbc']
    };
    var chartRevenue = new google.visualization.AreaChart(document.getElementById('main-chart'));
    chartRevenue.draw(dataRevenue, optionsRevenue);

    // 2. Biểu đồ trạng thái đơn hàng
    var dataStatus = google.visualization.arrayToDataTable([
      ['Trạng thái', 'Số lượng'],
      ['Chờ duyệt', <?php echo $order_status['pending'] ?>],
      ['Đang giao', <?php echo $order_status['shipping'] ?>],
      ['Thành công', <?php echo $order_status['success'] ?>],
      ['Đã hủy', <?php echo $order_status['cancelled'] ?>]
    ]);
    var optionsStatus = {
      pieHole: 0.4,
      colors: ['#f39c12', '#00c0ef', '#00a65a', '#dd4b39'],
      chartArea: {width: '100%', height: '80%'},
      legend: { position: 'bottom' }
    };
    var chartStatus = new google.visualization.PieChart(document.getElementById('status-chart'));
    chartStatus.draw(dataStatus, optionsStatus);
  }
</script>