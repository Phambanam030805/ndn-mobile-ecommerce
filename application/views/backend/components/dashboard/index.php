<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Chart.js 3.9.1 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
  :root {
    --primary: #d70018;
    --primary-dark: #b91c1c;
    --primary-light: #fef2f2;
    --success: #10b981;
    --warning: #f59e0b;
    --info: #0284c7;
    --danger: #ef4444;
    --purple: #8b5cf6;
    --text-dark: #0f172a;
    --text-muted: #64748b;
    --border-color: #f1f5f9;
  }

  .content-wrapper {
    background-color: #f8fafc !important;
    padding-top: 50px !important;
  }

  /* Header Top Title */
  .dashboard-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px 12px;
    flex-wrap: wrap;
    gap: 10px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 16px;
  }
  .dashboard-header-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .dashboard-header-title small {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-muted);
  }
  .dashboard-header-date {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
  }

  /* 4 KPI Cards */
  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 16px;
  }
  @media (max-width: 1200px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 600px) {
    .kpi-grid { grid-template-columns: 1fr; }
  }

  .kpi-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #e2e8f0;
    box-shadow: 0 3px 12px -2px rgba(0, 0, 0, 0.04);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
  }
  .kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px -3px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
  }
  .kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
  }
  .kpi-card.card-blue::before { background: var(--info); }
  .kpi-card.card-green::before { background: var(--success); }
  .kpi-card.card-purple::before { background: var(--purple); }
  .kpi-card.card-red::before { background: var(--primary); }

  .kpi-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .kpi-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
  }
  .kpi-value {
    font-size: 21px;
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1.2;
  }
  .kpi-subtext {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 1px;
  }

  .kpi-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
  }
  .card-blue .kpi-icon-wrap { background: #e0f2fe; color: var(--info); }
  .card-green .kpi-icon-wrap { background: #d1fae5; color: var(--success); }
  .card-purple .kpi-icon-wrap { background: #ede9fe; color: var(--purple); }
  .card-red .kpi-icon-wrap { background: #fee2e2; color: var(--primary); }

  /* Modern Card Box */
  .modern-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 3px 12px -2px rgba(0, 0, 0, 0.04);
    margin-bottom: 16px;
    overflow: hidden;
  }
  .modern-box-header {
    padding: 12px 18px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
  }
  .modern-box-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .modern-box-title i {
    color: var(--primary);
  }
  .modern-box-body {
    padding: 20px;
  }

  /* Year filter select */
  .filter-select {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1.5px solid #cbd5e1;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    outline: none;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s;
  }
  .filter-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.1);
  }

  /* Donut Legend Stats */
  .donut-legend-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px dashed #e2e8f0;
  }
  .donut-legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 12.5px;
  }
  .donut-legend-label {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #475569;
    font-weight: 500;
  }
  .donut-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
  }
  .donut-legend-val {
    font-weight: 700;
    color: var(--text-dark);
  }

  /* Tables */
  .table-clean {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  .table-clean thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 14px;
    border-bottom: 1.5px solid #e2e8f0;
  }
  .table-clean tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
    vertical-align: middle;
  }
  .table-clean tbody tr:last-child td {
    border-bottom: none;
  }
  .table-clean tbody tr:hover td {
    background: #fafbfc;
  }

  /* Status Badges */
  .badge-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1.3;
  }
  .badge-pending { background: #fef3c7; color: #b45309; }
  .badge-shipping { background: #e0f2fe; color: #0369a1; }
  .badge-success { background: #d1fae5; color: #047857; }
  .badge-cancelled { background: #fee2e2; color: #b91c1c; }

  /* Product Sold Badge */
  .badge-sold-count {
    background: #f1f5f9;
    color: #0f172a;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
  }

  /* Low stock item card */
  .low-stock-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
  }
  @media (max-width: 768px) {
    .low-stock-grid { grid-template-columns: 1fr 1fr; }
  }
  .low-stock-card {
    border: 1px solid #e2e8f0;
    background: #ffffff;
    border-radius: 12px;
    padding: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    transition: all 0.2s;
  }
  .low-stock-card:hover {
    border-color: #f59e0b;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.1);
  }
  .low-stock-card img {
    width: 65px;
    height: 65px;
    object-fit: contain;
    margin-bottom: 8px;
  }
  .low-stock-name {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
    margin-bottom: 4px;
  }
  .low-stock-qty {
    font-size: 11.5px;
    font-weight: 700;
    color: #d97706;
    background: #fef3c7;
    padding: 2px 8px;
    border-radius: 20px;
  }
</style>

<div class="content-wrapper">
  <!-- Top bar header -->
  <div class="dashboard-header-bar">
    <h1 class="dashboard-header-title">
      <i class="fas fa-chart-line" style="color: var(--primary);"></i>
      Bảng điều khiển Quản trị
      <small>Dữ liệu kinh doanh thời gian thực</small>
    </h1>
    <div class="dashboard-header-date">
      <i class="far fa-calendar-alt" style="color: var(--primary);"></i>
      <span>Hôm nay: <?php echo date('d/m/Y'); ?></span>
    </div>
  </div>

  <section class="content" style="padding: 0 20px 20px;">
    
    <!-- 1. 4 Thẻ KPI Tổng quan -->
    <div class="kpi-grid">
      <!-- Card Doanh thu -->
      <div class="kpi-card card-red">
        <div class="kpi-info">
          <span class="kpi-label">Tổng Doanh Thu</span>
          <span class="kpi-value" style="color: var(--primary);"><?php echo number_format($total_revenue); ?>đ</span>
          <span class="kpi-subtext"><i class="fas fa-check-double text-success"></i> Đơn giao thành công</span>
        </div>
        <div class="kpi-icon-wrap">
          <i class="fas fa-wallet"></i>
        </div>
      </div>

      <!-- Card Đơn hàng -->
      <div class="kpi-card card-blue">
        <div class="kpi-info">
          <span class="kpi-label">Tổng Đơn Hàng</span>
          <span class="kpi-value"><?php echo number_format($total_orders); ?></span>
          <span class="kpi-subtext"><?php echo $order_status['pending']; ?> đơn chờ duyệt</span>
        </div>
        <div class="kpi-icon-wrap">
          <i class="fas fa-shopping-cart"></i>
        </div>
      </div>

      <!-- Card Khách hàng -->
      <div class="kpi-card card-green">
        <div class="kpi-info">
          <span class="kpi-label">Khách Hàng</span>
          <span class="kpi-value"><?php echo number_format($total_customers); ?></span>
          <span class="kpi-subtext"><i class="fas fa-user-check text-success"></i> Tài khoản kích hoạt</span>
        </div>
        <div class="kpi-icon-wrap">
          <i class="fas fa-users"></i>
        </div>
      </div>

      <!-- Card Sản phẩm -->
      <div class="kpi-card card-purple">
        <div class="kpi-info">
          <span class="kpi-label">Sản Phẩm Đang Bán</span>
          <span class="kpi-value"><?php echo number_format($total_products); ?></span>
          <span class="kpi-subtext">Danh mục trực tuyến</span>
        </div>
        <div class="kpi-icon-wrap">
          <i class="fas fa-mobile-alt"></i>
        </div>
      </div>
    </div>

    <!-- 2. Hàng Biểu đồ: Doanh thu 12 tháng + Trạng thái đơn hàng -->
    <div class="row">
      <!-- Biểu đồ phân tích doanh thu -->
      <div class="col-lg-8 col-md-12">
        <div class="modern-box">
          <div class="modern-box-header">
            <h3 class="modern-box-title">
              <i class="fas fa-chart-area"></i>
              Doanh thu & Số lượng đơn năm <?php echo $selected_year; ?>
            </h3>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; color: #64748b; font-weight: 500;">Chọn năm:</span>
              <select class="filter-select" id="yearSelector" onchange="changeYear(this.value)">
                <?php foreach ($available_years as $yr): ?>
                  <option value="<?php echo $yr; ?>" <?php echo ($yr == $selected_year) ? 'selected' : ''; ?>>
                    Năm <?php echo $yr; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modern-box-body" style="padding: 14px 18px 18px;">
            <div style="position: relative; height: 250px; width: 100%;">
              <canvas id="revenueChartCanvas"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Biểu đồ trạng thái đơn hàng -->
      <div class="col-lg-4 col-md-12">
        <div class="modern-box">
          <div class="modern-box-header">
            <h3 class="modern-box-title">
              <i class="fas fa-chart-pie"></i>
              Tỷ lệ Trạng thái Đơn hàng
            </h3>
            <span style="font-size: 12px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 3px 8px; border-radius: 6px;">
              Tổng: <?php echo array_sum($order_status); ?> đơn
            </span>
          </div>
          <div class="modern-box-body" style="padding: 14px 18px 18px;">
            <div style="position: relative; height: 185px; width: 100%;">
              <canvas id="orderStatusCanvas"></canvas>
            </div>

            <!-- Legend Thống kê số lượng chi tiết -->
            <div class="donut-legend-list">
              <div class="donut-legend-item">
                <div class="donut-legend-label">
                  <span class="donut-dot" style="background: #10b981;"></span> Thành công
                </div>
                <span class="donut-legend-val"><?php echo $order_status['success']; ?></span>
              </div>
              <div class="donut-legend-item">
                <div class="donut-legend-label">
                  <span class="donut-dot" style="background: #0284c7;"></span> Đang giao
                </div>
                <span class="donut-legend-val"><?php echo $order_status['shipping']; ?></span>
              </div>
              <div class="donut-legend-item">
                <div class="donut-legend-label">
                  <span class="donut-dot" style="background: #f59e0b;"></span> Chờ duyệt
                </div>
                <span class="donut-legend-val"><?php echo $order_status['pending']; ?></span>
              </div>
              <div class="donut-legend-item">
                <div class="donut-legend-label">
                  <span class="donut-dot" style="background: #ef4444;"></span> Đã hủy
                </div>
                <span class="donut-legend-val"><?php echo $order_status['cancelled']; ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 3. Hàng Bảng: Top sản phẩm bán chạy thật & Đơn hàng mới nhất -->
    <div class="row">
      <!-- Top sản phẩm bán chạy -->
      <div class="col-lg-6 col-md-12">
        <div class="modern-box">
          <div class="modern-box-header">
            <h3 class="modern-box-title">
              <i class="fas fa-crown" style="color: #f59e0b;"></i>
              Top Sản phẩm bán chạy nhất
            </h3>
            <a href="admin/product" style="font-size: 12.5px; font-weight: 600; color: var(--primary); text-decoration: none;">
              Xem kho sản phẩm <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
            </a>
          </div>
          <div class="modern-box-body" style="padding: 0;">
            <table class="table-clean">
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th>Giá niêm yết</th>
                  <th class="text-center">Đã bán</th>
                  <th class="text-right">Doanh thu tạm tính</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($best_selling_products)): ?>
                  <?php foreach ($best_selling_products as $p): 
                    $actual_sold = (int)$p['real_sold'];
                    $cur_price = $p['price_sale'] > 0 ? $p['price_sale'] : $p['price'];
                  ?>
                  <tr>
                    <td>
                      <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="public/images/products/<?php echo $p['avatar']; ?>" style="width: 36px; height: 36px; object-fit: contain; border-radius: 6px; border: 1px solid #f1f5f9; background: #fff;">
                        <div>
                          <div style="font-weight: 700; color: #1e293b;"><?php echo $p['name']; ?></div>
                          <div style="font-size: 11px; color: #94a3b8;">ID: #<?php echo $p['id']; ?></div>
                        </div>
                      </div>
                    </td>
                    <td style="font-weight: 600; color: #475569;">
                      <?php echo number_format($cur_price); ?>đ
                    </td>
                    <td class="text-center">
                      <span class="badge-sold-count"><?php echo $actual_sold; ?></span>
                    </td>
                    <td class="text-right" style="font-weight: 700; color: var(--primary);">
                      <?php echo number_format($p['real_revenue'] > 0 ? $p['real_revenue'] : ($actual_sold * $cur_price)); ?>đ
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted" style="padding: 20px;">Chưa có dữ liệu bán hàng.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Đơn hàng mới nhất -->
      <div class="col-lg-6 col-md-12">
        <div class="modern-box">
          <div class="modern-box-header">
            <h3 class="modern-box-title">
              <i class="fas fa-receipt"></i>
              Đơn hàng gần đây
            </h3>
            <a href="admin/orders" style="font-size: 12.5px; font-weight: 600; color: var(--primary); text-decoration: none;">
              Quản lý toàn bộ đơn <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
            </a>
          </div>
          <div class="modern-box-body" style="padding: 0;">
            <table class="table-clean">
              <thead>
                <tr>
                  <th>Mã đơn</th>
                  <th>Khách hàng</th>
                  <th>Ngày đặt</th>
                  <th>Tổng tiền</th>
                  <th class="text-center">Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($latest_orders)): ?>
                  <?php foreach ($latest_orders as $o): ?>
                  <tr>
                    <td>
                      <a href="admin/orders/view/<?php echo $o['id']; ?>" style="font-weight: 700; color: #0284c7; text-decoration: none;">
                        #<?php echo $o['orderCode']; ?>
                      </a>
                    </td>
                    <td style="font-weight: 600; color: #334155;">
                      <?php echo $o['fullname']; ?>
                    </td>
                    <td style="font-size: 12px; color: #64748b;">
                      <?php echo date('d/m/Y H:i', strtotime($o['order_date'])); ?>
                    </td>
                    <td style="font-weight: 700; color: var(--primary);">
                      <?php echo number_format($o['money']); ?>đ
                    </td>
                    <td class="text-center">
                      <?php 
                        if($o['status'] == 0) {
                            echo '<span class="badge-status badge-pending"><i class="fas fa-clock"></i> Chờ duyệt</span>';
                        } elseif($o['status'] == 1) {
                            echo '<span class="badge-status badge-shipping"><i class="fas fa-shipping-fast"></i> Đang giao</span>';
                        } elseif($o['status'] == 2) {
                            echo '<span class="badge-status badge-success"><i class="fas fa-check-circle"></i> Thành công</span>';
                        } else {
                            echo '<span class="badge-status badge-cancelled"><i class="fas fa-times-circle"></i> Đã hủy</span>';
                        }
                      ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted" style="padding: 20px;">Chưa có đơn hàng nào.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- CHARTS INITIALIZATION SCRIPT -->
<script>
  function changeYear(yr) {
    window.location.href = 'admin?year=' + yr;
  }

  document.addEventListener('DOMContentLoaded', function() {
    // 1. Dữ liệu thực từ PHP
    var monthsLabels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
    var revenueData = [
      <?php for($i=1; $i<=12; $i++) echo ($revenue_months[$i] ?? 0) . ($i < 12 ? ',' : ''); ?>
    ];
    var ordersCountData = [
      <?php for($i=1; $i<=12; $i++) echo ($orders_count_months[$i] ?? 0) . ($i < 12 ? ',' : ''); ?>
    ];

    // Vẽ biểu đồ Doanh thu (Line/Area Chart mượt mà với Gradient)
    var ctxRevenue = document.getElementById('revenueChartCanvas').getContext('2d');
    var gradientFill = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, 'rgba(215, 0, 24, 0.25)');
    gradientFill.addColorStop(1, 'rgba(215, 0, 24, 0.0)');

    new Chart(ctxRevenue, {
      type: 'line',
      data: {
        labels: monthsLabels,
        datasets: [
          {
            label: 'Doanh thu thực tế (VNĐ)',
            data: revenueData,
            borderColor: '#d70018',
            backgroundColor: gradientFill,
            fill: true,
            tension: 0.35,
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#d70018',
            pointBorderWidth: 2,
            pointRadius: 4.5,
            pointHoverRadius: 6.5,
            yAxisID: 'y'
          },
          {
            label: 'Số lượng đơn thành công',
            data: ordersCountData,
            borderColor: '#0284c7',
            borderDash: [5, 5],
            fill: false,
            tension: 0.35,
            borderWidth: 2,
            pointBackgroundColor: '#0284c7',
            pointRadius: 3.5,
            pointHoverRadius: 5.5,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              boxWidth: 14,
              font: { family: "'Inter', sans-serif", size: 12, weight: '600' },
              color: '#475569'
            }
          },
          tooltip: {
            backgroundColor: '#0f172a',
            padding: 12,
            titleFont: { size: 13, weight: 'bold' },
            bodyFont: { size: 12.5 },
            callbacks: {
              label: function(context) {
                var label = context.dataset.label || '';
                if (label.indexOf('Doanh thu') !== -1) {
                  return ' ' + label + ': ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' đ';
                }
                return ' ' + label + ': ' + context.raw + ' đơn';
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { family: "'Inter', sans-serif", size: 11.5 }, color: '#64748b' }
          },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: { color: '#f1f5f9' },
            ticks: {
              font: { family: "'Inter', sans-serif", size: 11 },
              color: '#64748b',
              callback: function(value) {
                if (value >= 1000000) {
                  return (value / 1000000).toFixed(0) + 'M';
                }
                return value;
              }
            }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            grid: { drawOnChartArea: false },
            ticks: {
              font: { family: "'Inter', sans-serif", size: 11 },
              color: '#0284c7',
              stepSize: 2,
              callback: function(value) { return value + ' đơn'; }
            }
          }
        }
      }
    });

    // 2. Vẽ biểu đồ Tròn Trạng thái Đơn hàng (Doughnut Chart)
    var ctxStatus = document.getElementById('orderStatusCanvas').getContext('2d');
    var statusSuccess = <?php echo (int)$order_status['success']; ?>;
    var statusShipping = <?php echo (int)$order_status['shipping']; ?>;
    var statusPending = <?php echo (int)$order_status['pending']; ?>;
    var statusCancelled = <?php echo (int)$order_status['cancelled']; ?>;

    new Chart(ctxStatus, {
      type: 'doughnut',
      data: {
        labels: ['Thành công', 'Đang giao', 'Chờ duyệt', 'Đã hủy'],
        datasets: [{
          data: [statusSuccess, statusShipping, statusPending, statusCancelled],
          backgroundColor: ['#10b981', '#0284c7', '#f59e0b', '#ef4444'],
          borderWidth: 3,
          borderColor: '#ffffff',
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#0f172a',
            padding: 10,
            callbacks: {
              label: function(context) {
                var total = statusSuccess + statusShipping + statusPending + statusCancelled;
                var val = context.raw || 0;
                var pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                return ' ' + context.label + ': ' + val + ' đơn (' + pct + '%)';
              }
            }
          }
        }
      }
    });
  });
</script>