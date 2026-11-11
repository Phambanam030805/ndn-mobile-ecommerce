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

  /* Nút thao tác In & Xuất Báo cáo chuẩn Doanh nghiệp */
  .btn-dashboard-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    text-decoration: none;
  }
  .btn-print-report {
    background: #0f172a;
    color: #ffffff;
  }
  .btn-print-report:hover {
    background: #1e293b;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(15,23,42,0.18);
  }
  .btn-export-excel {
    background: #10b981;
    color: #ffffff;
  }
  .btn-export-excel:hover {
    background: #059669;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(16,185,129,0.25);
  }

  /* Khung in báo cáo doanh nghiệp (Mặc định ẩn trên màn hình thường) */
  #enterprise-report-print-area {
    display: none;
  }

  /* Bảng báo cáo doanh nghiệp chuẩn */
  .table-enterprise-report {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
    font-size: 11pt;
    font-family: 'Times New Roman', Times, serif;
    background: #ffffff;
  }
  .table-enterprise-report th,
  .table-enterprise-report td {
    border: 1px solid #333333;
    padding: 6px 10px;
    vertical-align: middle;
    color: #000000;
  }
  .table-enterprise-report th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
  }

    /* CHẾ ĐỘ IN ẤN CHUẨN DOANH NGHIỆP: TRIỆT TIÊU 100% GIAO DIỆN WEB & LINK RÁC CỦA TRÌNH DUYỆT */
  @media print {
    /* Đặt margin: 0 để trình duyệt (Chrome/Edge) KHÔNG THỂ in link URL, ngày giờ ở góc trái/phải trang */
    @page {
      size: A4 portrait;
      margin: 0 !important;
    }

    body, html, .wrapper, .content-wrapper {
      background: #ffffff !important;
      padding: 0 !important;
      margin: 0 !important;
      width: 100% !important;
      min-height: auto !important;
      overflow: visible !important;
    }

    /* Ẩn hoàn toàn tất cả thành phần web */
    .main-header, .main-sidebar, .main-footer, .sidebar-brand-panel,
    .dashboard-header-bar, .kpi-grid, .row, .content > *:not(#enterprise-report-print-area),
    button, select, input, .filter-select, a {
      display: none !important;
    }

    /* Hiển thị duy nhất khu vực văn bản in với lề giấy nội tại 12mm x 15mm */
    #enterprise-report-print-area {
      display: block !important;
      position: absolute !important;
      left: 0 !important;
      top: 0 !important;
      width: 100% !important;
      box-sizing: border-box !important;
      margin: 0 !important;
      padding: 12mm 15mm 12mm 15mm !important;
      background: #ffffff !important;
      color: #000000 !important;
      font-family: 'Times New Roman', Times, serif !important;
      font-size: 10.5pt !important;
      line-height: 1.3 !important;
    }

    /* Triệt tiêu 100% in URL link rác */
    a[href]:after, a:after {
      content: none !important;
    }

    /* Phân trang chủ động chuẩn 2 trang A4 */
    .page-break-after {
      page-break-after: always !important;
      break-after: page !important;
      height: 0;
      display: block;
      clear: both;
    }
    .print-avoid-break {
      page-break-inside: avoid !important;
    }
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
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
      <div class="dashboard-header-date">
        <i class="far fa-calendar-alt" style="color: var(--primary);"></i>
        <span>Hôm nay: <?php echo date('d/m/Y'); ?></span>
      </div>
      <button type="button" class="btn-dashboard-action btn-print-report" onclick="printEnterpriseReport()" title="In báo cáo thống kê chuẩn doanh nghiệp">
        <i class="fas fa-print"></i> In báo cáo
      </button>
      <button type="button" class="btn-dashboard-action btn-export-excel" onclick="exportEnterpriseExcel()" title="Xuất báo cáo thống kê ra tệp Excel">
        <i class="fas fa-file-excel"></i> Xuất Excel
      </button>
    </div>
  </div>

  <section class="content" style="padding: 0 20px 20px;">

        <!-- ========================================================================= -->
    <!-- BÁO CÁO DOANH NGHIỆP CHUẨN IN ẤN (CHUẨN 2 TRANG A4 CÂN ĐỐI, KHÔNG RÁC)   -->
    <!-- ========================================================================= -->
    <div id="enterprise-report-print-area">
      
      <!-- ====================== TRANG 1 ====================== -->
      <div class="print-page-1">
        <!-- 1. QUỐC HIỆU & THÔNG TIN DOANH NGHIỆP -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; border: none;">
          <tr>
            <td style="width: 55%; vertical-align: top; text-align: left; font-size: 10pt; line-height: 1.3; border: none; padding: 0;">
              <strong style="font-size: 11pt; text-transform: uppercase;">CÔNG TY TNHH THƯƠNG MẠI & DỊCH VỤ NDN MOBILE</strong><br>
              <strong>Hệ thống Bán lẻ Điện thoại Di động & Phụ kiện Chính hãng</strong><br>
              Địa chỉ: 123 Đường Cầu Giấy, Q. Cầu Giấy, TP. Hà Nội<br>
              Hotline: 1900.6868 | Email: contact@ndnmobile.vn<br>
              Số hiệu: <strong>BC-<?php echo $selected_year; ?>/NDN-TCKT</strong>
            </td>
            <td style="width: 45%; vertical-align: top; text-align: center; font-size: 10pt; line-height: 1.3; border: none; padding: 0;">
              <strong style="font-size: 11pt; text-transform: uppercase;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong><br>
              <strong style="text-decoration: underline;">Độc lập – Tự do – Hạnh phúc</strong><br><br>
              <em>Hà Nội, ngày <?php echo date('d'); ?> tháng <?php echo date('m'); ?> năm <?php echo date('Y'); ?></em>
            </td>
          </tr>
        </table>

        <!-- 2. TIÊU ĐỀ BÁO CÁO -->
        <div style="text-align: center; margin: 12px 0 14px;">
          <h2 style="font-size: 15pt; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">BÁO CÁO THỐNG KÊ DOANH THU & KẾT QUẢ KINH DOANH</h2>
          <div style="font-size: 11pt; font-style: italic; margin-top: 3px;">Kỳ thống kê: Toàn bộ năm <?php echo $selected_year; ?> (Từ 01/01/<?php echo $selected_year; ?> đến 31/12/<?php echo $selected_year; ?>)</div>
          <div style="font-size: 10pt; color: #333333; margin-top: 3px;">Người lập biểu: <strong><?php echo !empty($user['fullname']) ? $user['fullname'] : $user['username']; ?></strong> | Thời điểm kết xuất: <?php echo date('d/m/Y H:i:s'); ?></div>
        </div>

        <!-- 3. MỤC I: TỔNG QUAN CHỈ SỐ HOẠT ĐỘNG TOÀN HỆ THỐNG (KPIS) -->
        <div style="margin-bottom: 14px;">
          <h4 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px; text-transform: uppercase;">I. TỔNG HỢP CÁC CHỈ SỐ KINH DOANH & HOẠT ĐỘNG CHÍNH</h4>
          <table class="table-enterprise-report" style="font-size: 10pt;">
            <thead>
              <tr>
                <th style="width: 8%; text-align: center; padding: 4px;">STT</th>
                <th style="width: 38%; text-align: left; padding: 4px 8px;">Chỉ số hoạt động / Quản trị</th>
                <th style="width: 22%; text-align: right; padding: 4px 8px;">Giá trị ghi nhận</th>
                <th style="width: 12%; text-align: center; padding: 4px;">Đơn vị</th>
                <th style="width: 20%; text-align: left; padding: 4px 8px;">Diễn giải nghiệp vụ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center; padding: 4px;">01</td>
                <td style="padding: 4px 8px;"><strong>Tổng doanh thu bán hàng lũy kế</strong></td>
                <td style="text-align: right; font-weight: bold; font-family: 'Courier New', monospace; font-size: 10.5pt; padding: 4px 8px;"><?php echo number_format($total_revenue); ?> đ</td>
                <td style="text-align: center; padding: 4px;">VNĐ</td>
                <td style="padding: 4px 8px;">Đơn giao thành công</td>
              </tr>
              <tr>
                <td style="text-align: center; padding: 4px;">02</td>
                <td style="padding: 4px 8px;"><strong>Tổng số lượng đơn hàng phát sinh</strong></td>
                <td style="text-align: right; font-weight: bold; font-family: 'Courier New', monospace; font-size: 10.5pt; padding: 4px 8px;"><?php echo number_format($total_orders); ?></td>
                <td style="text-align: center; padding: 4px;">Đơn hàng</td>
                <td style="padding: 4px 8px;">Toàn hệ thống</td>
              </tr>
              <tr>
                <td style="text-align: center; padding: 4px;">03</td>
                <td style="padding: 4px 8px;"><strong>Tổng số khách hàng thành viên</strong></td>
                <td style="text-align: right; font-weight: bold; font-family: 'Courier New', monospace; font-size: 10.5pt; padding: 4px 8px;"><?php echo number_format($total_customers); ?></td>
                <td style="text-align: center; padding: 4px;">Khách hàng</td>
                <td style="padding: 4px 8px;">Tài khoản kích hoạt</td>
              </tr>
              <tr>
                <td style="text-align: center; padding: 4px;">04</td>
                <td style="padding: 4px 8px;"><strong>Số lượng sản phẩm trực tuyến</strong></td>
                <td style="text-align: right; font-weight: bold; font-family: 'Courier New', monospace; font-size: 10.5pt; padding: 4px 8px;"><?php echo number_format($total_products); ?></td>
                <td style="text-align: center; padding: 4px;">Mặt hàng</td>
                <td style="padding: 4px 8px;">Đang kinh doanh</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 4. MỤC II: BẢNG KÊ CHI TIẾT DOANH THU & ĐƠN HÀNG 12 THÁNG -->
        <div style="margin-bottom: 5px;">
          <h4 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px; text-transform: uppercase;">II. BẢNG KÊ DOANH THU & ĐƠN HÀNG 12 THÁNG NĂM <?php echo $selected_year; ?></h4>
          <table class="table-enterprise-report" style="font-size: 9.5pt;">
            <thead>
              <tr>
                <th style="width: 8%; text-align: center; padding: 3px;">Kỳ</th>
                <th style="width: 22%; text-align: left; padding: 3px 6px;">Thời gian</th>
                <th style="width: 18%; text-align: right; padding: 3px 6px;">Số đơn phát sinh</th>
                <th style="width: 14%; text-align: right; padding: 3px 6px;">Tỷ trọng đơn</th>
                <th style="width: 24%; text-align: right; padding: 3px 6px;">Doanh thu thực tế (VNĐ)</th>
                <th style="width: 14%; text-align: right; padding: 3px 6px;">Tỷ trọng DT</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $sum_year_orders = array_sum($orders_count_months);
                $sum_year_money = array_sum($revenue_months);
                for($m = 1; $m <= 12; $m++):
                  $m_money = $revenue_months[$m] ?? 0;
                  $m_orders = $orders_count_months[$m] ?? 0;
                  $pct_orders = $sum_year_orders > 0 ? ($m_orders / $sum_year_orders) * 100 : 0;
                  $pct_money = $sum_year_money > 0 ? ($m_money / $sum_year_money) * 100 : 0;
              ?>
              <tr>
                <td style="text-align: center; padding: 2.5px;"><?php echo sprintf('T%02d', $m); ?></td>
                <td style="padding: 2.5px 6px;">Tháng <?php echo sprintf('%02d', $m); ?>/<?php echo $selected_year; ?></td>
                <td style="text-align: right; padding: 2.5px 6px;"><?php echo number_format($m_orders); ?> đơn</td>
                <td style="text-align: right; padding: 2.5px 6px;"><?php echo number_format($pct_orders, 1); ?>%</td>
                <td style="text-align: right; font-weight: bold; font-family: 'Courier New', monospace; padding: 2.5px 6px;"><?php echo number_format($m_money); ?> đ</td>
                <td style="text-align: right; padding: 2.5px 6px;"><?php echo number_format($pct_money, 1); ?>%</td>
              </tr>
              <?php endfor; ?>
              <tr style="background: #f2f2f2; font-weight: bold;">
                <td colspan="2" style="text-align: center; text-transform: uppercase; padding: 3.5px;">TỔNG CỘNG NĂM <?php echo $selected_year; ?></td>
                <td style="text-align: right; padding: 3.5px 6px;"><?php echo number_format($sum_year_orders); ?> đơn</td>
                <td style="text-align: right; padding: 3.5px 6px;">100.0%</td>
                <td style="text-align: right; font-family: 'Courier New', monospace; font-size: 10pt; padding: 3.5px 6px;"><?php echo number_format($sum_year_money); ?> đ</td>
                <td style="text-align: right; padding: 3.5px 6px;">100.0%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ĐƯỜNG NGẮT TRANG CHỦ ĐỘNG: ĐẢM BẢO CHUẨN XÁC 2 TRANG A4 -->
      <div class="page-break-after"></div>

      <!-- ====================== TRANG 2 ====================== -->
      <div class="print-page-2" style="padding-top: 10px;">
        <!-- 5. MỤC III: TỔNG HỢP TRẠNG THÁI ĐƠN HÀNG & TOP 5 SẢN PHẨM BÁN CHẠY -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px; border: none;">
          <tr>
            <!-- Cột Trái: Trạng thái đơn -->
            <td style="width: 44%; vertical-align: top; border: none; padding: 0 8px 0 0;">
              <h4 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px; text-transform: uppercase;">III. TRẠNG THÁI XỬ LÝ ĐƠN HÀNG</h4>
              <table class="table-enterprise-report" style="font-size: 9.5pt;">
                <thead>
                  <tr>
                    <th style="width: 62%; text-align: left; padding: 4px 6px;">Trạng thái</th>
                    <th style="width: 38%; text-align: right; padding: 4px 6px;">Số lượng</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding: 4px 6px;">Chờ duyệt tiếp nhận</td>
                    <td style="text-align: right; font-weight: bold; padding: 4px 6px;"><?php echo number_format($order_status['pending']); ?> đơn</td>
                  </tr>
                  <tr>
                    <td style="padding: 4px 6px;">Đang giao hàng</td>
                    <td style="text-align: right; font-weight: bold; padding: 4px 6px;"><?php echo number_format($order_status['shipping']); ?> đơn</td>
                  </tr>
                  <tr>
                    <td style="padding: 4px 6px;">Giao thành công</td>
                    <td style="text-align: right; font-weight: bold; padding: 4px 6px;"><?php echo number_format($order_status['success']); ?> đơn</td>
                  </tr>
                  <tr>
                    <td style="padding: 4px 6px;">Đã hủy / Hoàn trả</td>
                    <td style="text-align: right; font-weight: bold; padding: 4px 6px;"><?php echo number_format($order_status['cancelled']); ?> đơn</td>
                  </tr>
                  <tr style="background: #f2f2f2; font-weight: bold;">
                    <td style="text-transform: uppercase; padding: 4px 6px;">Tổng đơn phát sinh</td>
                    <td style="text-align: right; padding: 4px 6px;"><?php echo number_format(array_sum($order_status)); ?> đơn</td>
                  </tr>
                </tbody>
              </table>
            </td>

            <!-- Cột Phải: Top sản phẩm bán chạy -->
            <td style="width: 56%; vertical-align: top; border: none; padding: 0 0 0 8px;">
              <h4 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px; text-transform: uppercase;">IV. TOP 5 SẢN PHẨM BÁN CHẠY NHẤT</h4>
              <table class="table-enterprise-report" style="font-size: 9pt;">
                <thead>
                  <tr>
                    <th style="width: 9%; text-align: center; padding: 4px 2px;">STT</th>
                    <th style="width: 48%; text-align: left; padding: 4px 6px;">Tên sản phẩm</th>
                    <th style="width: 18%; text-align: right; padding: 4px 4px;">Đã bán</th>
                    <th style="width: 25%; text-align: right; padding: 4px 6px;">Doanh thu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($best_selling_products)): $stt=1; foreach($best_selling_products as $bp): ?>
                  <tr>
                    <td style="text-align: center; padding: 3px 2px;"><?php echo $stt++; ?></td>
                    <td style="padding: 3px 6px;"><?php echo htmlspecialchars($bp['name']); ?></td>
                    <td style="text-align: right; font-weight: bold; padding: 3px 4px;"><?php echo number_format($bp['real_sold']); ?></td>
                    <td style="text-align: right; font-family: 'Courier New', monospace; padding: 3px 6px;"><?php echo number_format($bp['real_revenue']); ?> đ</td>
                  </tr>
                  <?php endforeach; else: ?>
                  <tr><td colspan="4" style="text-align: center; padding: 4px;">Chưa có dữ liệu</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </td>
          </tr>
        </table>

        <!-- 6. MỤC V: CẢNH BÁO TỒN KHO THẤP -->
        <div style="margin-bottom: 20px;">
          <h4 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px; text-transform: uppercase;">V. DANH SÁCH SẢN PHẨM CẢNH BÁO TỒN KHO THẤP (&le; 40 SẢN PHẨM)</h4>
          <table class="table-enterprise-report" style="font-size: 9.5pt;">
            <thead>
              <tr>
                <th style="width: 8%; text-align: center; padding: 4px;">STT</th>
                <th style="width: 42%; text-align: left; padding: 4px 8px;">Tên sản phẩm</th>
                <th style="width: 20%; text-align: right; padding: 4px 8px;">Đơn giá niêm yết</th>
                <th style="width: 15%; text-align: right; padding: 4px 8px;">Tồn kho hiện tại</th>
                <th style="width: 15%; text-align: center; padding: 4px 8px;">Trạng thái</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($low_stock_products)): $sttk=1; foreach($low_stock_products as $lp): ?>
              <tr>
                <td style="text-align: center; padding: 3.5px;"><?php echo $sttk++; ?></td>
                <td style="padding: 3.5px 8px;"><?php echo htmlspecialchars($lp['name']); ?></td>
                <td style="text-align: right; font-family: 'Courier New', monospace; padding: 3.5px 8px;"><?php echo number_format($lp['price']); ?> đ</td>
                <td style="text-align: right; font-weight: bold; color: #b91c1c; padding: 3.5px 8px;"><?php echo number_format($lp['number']); ?> chiếc</td>
                <td style="text-align: center; padding: 3.5px 8px;">Cần nhập thêm</td>
              </tr>
              <?php endforeach; else: ?>
              <tr><td colspan="5" style="text-align: center; padding: 4px;">Tồn kho ổn định</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- 7. CHỮ KÝ XÁC NHẬN CHUẨN DOANH NGHIỆP (3 BÊN) -->
        <div style="margin-top: 25px; page-break-inside: avoid;" class="print-avoid-break">
          <table style="width: 100%; border-collapse: collapse; text-align: center; border: none;">
            <tr>
              <td style="width: 33%; vertical-align: top; border: none; padding: 0;">
                <strong style="font-size: 11pt;">NGƯỜI LẬP BÁO CÁO</strong><br>
                <span style="font-size: 9.5pt; font-style: italic;">(Ký và ghi rõ họ tên)</span>
                <br><br><br><br><br>
                <strong style="font-size: 11pt;"><?php echo !empty($user['fullname']) ? $user['fullname'] : $user['username']; ?></strong>
              </td>
              <td style="width: 33%; vertical-align: top; border: none; padding: 0;">
                <strong style="font-size: 11pt;">KẾ TOÁN TRƯỞNG</strong><br>
                <span style="font-size: 9.5pt; font-style: italic;">(Ký và ghi rõ họ tên)</span>
                <br><br><br><br><br>
                <strong style="font-size: 11pt;">....................................................</strong>
              </td>
              <td style="width: 34%; vertical-align: top; border: none; padding: 0;">
                <strong style="font-size: 11pt;">GIÁM ĐỐC DOANH NGHIỆP</strong><br>
                <span style="font-size: 9.5pt; font-style: italic;">(Ký tên và đóng dấu)</span>
                <br><br><br><br><br>
                <strong style="font-size: 11pt;">....................................................</strong>
              </td>
            </tr>
          </table>
        </div>
      </div>

    </div>

    
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


    // 1. Hàm in Báo cáo Doanh nghiệp chuẩn A4, loại bỏ 100% link rác và ngày giờ do trình duyệt tự chèn
  function printEnterpriseReport() {
    window.print();
  }

  // 2. Hàm xuất Báo cáo Doanh nghiệp ra tệp Microsoft Excel (.xls) chuẩn lưới dữ liệu doanh nghiệp
  function exportEnterpriseExcel() {
    var year = '<?php echo $selected_year; ?>';
    var reporter = '<?php echo !empty($user['fullname']) ? $user['fullname'] : $user['username']; ?>';
    var exportDate = '<?php echo date('d/m/Y H:i'); ?>';

    var excelHtml = `
      <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
      <head>
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
        <!--[if gte mso 9]>
        <xml>
          <x:ExcelWorkbook>
            <x:ExcelWorksheets>
              <x:ExcelWorksheet>
                <x:Name>BaoCao_NDNMobile_${year}</x:Name>
                <x:WorksheetOptions>
                  <x:DisplayGridlines/>
                </x:WorksheetOptions>
              </x:ExcelWorksheet>
            </x:ExcelWorksheets>
          </x:ExcelWorkbook>
        </xml>
        <![endif]-->
        <style>
          body { font-family: 'Times New Roman', serif; font-size: 11pt; color: #000; }
          table { border-collapse: collapse; width: 100%; }
          .header-title { font-size: 16pt; font-weight: bold; text-align: center; }
          .sub-title { font-size: 11.5pt; font-style: italic; text-align: center; }
          .section-title { font-size: 12pt; font-weight: bold; background-color: #d9e1f2; border: 0.5pt solid #000; }
          th { background-color: #f2f2f2; font-weight: bold; text-align: center; border: 0.5pt solid #000; }
          td { border: 0.5pt solid #000; vertical-align: middle; }
          .text-left { text-align: left; }
          .text-center { text-align: center; }
          .text-right { text-align: right; }
          .money-font { font-family: 'Courier New', monospace; font-weight: bold; }
          .no-border { border: none !important; }
        </style>
      </head>
      <body>
        <table>
          <!-- Cột định kích thước chuẩn Excel (Colgroup) -->
          <col width="60">
          <col width="260">
          <col width="160">
          <col width="120">
          <col width="200">
          <col width="130">

          <!-- ĐẦU TRANG DOANH NGHIỆP & QUỐC HIỆU -->
          <tr>
            <td colspan="3" class="no-border" style="font-weight: bold; font-size: 11pt;">CÔNG TY TNHH THƯƠNG MẠI & DỊCH VỤ NDN MOBILE</td>
            <td colspan="3" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</td>
          </tr>
          <tr>
            <td colspan="3" class="no-border">Hệ thống Bán lẻ Điện thoại Di động & Phụ kiện Chính hãng</td>
            <td colspan="3" class="no-border text-center" style="text-decoration: underline; font-weight: bold;">Độc lập – Tự do – Hạnh phúc</td>
          </tr>
          <tr>
            <td colspan="3" class="no-border">Địa chỉ: 123 Đường Cầu Giấy, Q. Cầu Giấy, TP. Hà Nội</td>
            <td colspan="3" class="no-border text-center" style="font-style: italic;">Hà Nội, ngày <?php echo date('d/m/Y'); ?></td>
          </tr>
          <tr>
            <td colspan="3" class="no-border">Số hiệu: BC-${year}/NDN-TCKT</td>
            <td colspan="3" class="no-border"></td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 15px;"></td></tr>

          <!-- TIÊU ĐỀ BÁO CÁO -->
          <tr>
            <td colspan="6" class="no-border header-title">BÁO CÁO THỐNG KÊ DOANH THU & KẾT QUẢ KINH DOANH</td>
          </tr>
          <tr>
            <td colspan="6" class="no-border sub-title">Kỳ thống kê: Toàn bộ năm ${year} (Từ 01/01/${year} đến 31/12/${year})</td>
          </tr>
          <tr>
            <td colspan="6" class="no-border text-center" style="font-size: 10pt; color: #555;">Người lập biểu: ${reporter} | Thời điểm kết xuất: ${exportDate}</td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 15px;"></td></tr>

          <!-- MỤC I: TỔNG QUAN CHỈ SỐ HOẠT ĐỘNG (KPIS) -->
          <tr>
            <td colspan="6" class="section-title">I. TỔNG HỢP CÁC CHỈ SỐ KINH DOANH & HOẠT ĐỘNG CHÍNH</td>
          </tr>
          <tr>
            <th>STT</th>
            <th colspan="2">Chỉ số hoạt động / Quản trị</th>
            <th>Giá trị ghi nhận</th>
            <th>Đơn vị tính</th>
            <th>Diễn giải nghiệp vụ</th>
          </tr>
          <tr>
            <td class="text-center">01</td>
            <td colspan="2"><strong>Tổng doanh thu bán hàng lũy kế</strong></td>
            <td class="text-right money-font"><?php echo number_format($total_revenue); ?> đ</td>
            <td class="text-center">VNĐ</td>
            <td>Đơn giao thành công</td>
          </tr>
          <tr>
            <td class="text-center">02</td>
            <td colspan="2"><strong>Tổng số lượng đơn hàng phát sinh</strong></td>
            <td class="text-right money-font"><?php echo number_format($total_orders); ?></td>
            <td class="text-center">Đơn hàng</td>
            <td>Toàn hệ thống</td>
          </tr>
          <tr>
            <td class="text-center">03</td>
            <td colspan="2"><strong>Tổng số khách hàng thành viên</strong></td>
            <td class="text-right money-font"><?php echo number_format($total_customers); ?></td>
            <td class="text-center">Khách hàng</td>
            <td>Tài khoản kích hoạt</td>
          </tr>
          <tr>
            <td class="text-center">04</td>
            <td colspan="2"><strong>Số lượng sản phẩm trực tuyến</strong></td>
            <td class="text-right money-font"><?php echo number_format($total_products); ?></td>
            <td class="text-center">Mặt hàng</td>
            <td>Đang kinh doanh</td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 15px;"></td></tr>

          <!-- MỤC II: BẢNG KÊ DOANH THU 12 THÁNG -->
          <tr>
            <td colspan="6" class="section-title">II. BẢNG KÊ DOANH THU & ĐƠN HÀNG 12 THÁNG NĂM ${year}</td>
          </tr>
          <tr>
            <th>Kỳ</th>
            <th>Thời gian</th>
            <th>Số đơn phát sinh</th>
            <th>Tỷ trọng đơn</th>
            <th>Doanh thu thực tế (VNĐ)</th>
            <th>Tỷ trọng DT</th>
          </tr>
          <?php 
            $sum_year_orders = array_sum($orders_count_months);
            $sum_year_money = array_sum($revenue_months);
            for($m = 1; $m <= 12; $m++):
              $m_money = $revenue_months[$m] ?? 0;
              $m_orders = $orders_count_months[$m] ?? 0;
              $pct_orders = $sum_year_orders > 0 ? ($m_orders / $sum_year_orders) * 100 : 0;
              $pct_money = $sum_year_money > 0 ? ($m_money / $sum_year_money) * 100 : 0;
          ?>
          <tr>
            <td class="text-center">T<?php echo sprintf('%02d', $m); ?></td>
            <td>Tháng <?php echo sprintf('%02d', $m); ?>/${year}</td>
            <td class="text-right"><?php echo number_format($m_orders); ?> đơn</td>
            <td class="text-right"><?php echo number_format($pct_orders, 1); ?>%</td>
            <td class="text-right money-font"><?php echo number_format($m_money); ?> đ</td>
            <td class="text-right"><?php echo number_format($pct_money, 1); ?>%</td>
          </tr>
          <?php endfor; ?>
          <tr style="background-color: #f2f2f2; font-weight: bold;">
            <td colspan="2" class="text-center">TỔNG CỘNG NĂM ${year}</td>
            <td class="text-right"><?php echo number_format($sum_year_orders); ?> đơn</td>
            <td class="text-right">100.0%</td>
            <td class="text-right money-font"><?php echo number_format($sum_year_money); ?> đ</td>
            <td class="text-right">100.0%</td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 15px;"></td></tr>

          <!-- MỤC III: TRẠNG THÁI ĐƠN HÀNG -->
          <tr>
            <td colspan="6" class="section-title">III. TRẠNG THÁI XỬ LÝ ĐƠN HÀNG TOÀN HỆ THỐNG</td>
          </tr>
          <tr>
            <th>STT</th>
            <th colspan="3">Trạng thái quy trình đơn hàng</th>
            <th colspan="2">Số lượng đơn hàng</th>
          </tr>
          <tr>
            <td class="text-center">01</td>
            <td colspan="3">Đơn hàng chờ duyệt tiếp nhận</td>
            <td colspan="2" class="text-right money-font"><?php echo number_format($order_status['pending']); ?> đơn</td>
          </tr>
          <tr>
            <td class="text-center">02</td>
            <td colspan="3">Đơn hàng đang vận chuyển giao hàng</td>
            <td colspan="2" class="text-right money-font"><?php echo number_format($order_status['shipping']); ?> đơn</td>
          </tr>
          <tr>
            <td class="text-center">03</td>
            <td colspan="3">Đơn hàng giao hàng thành công</td>
            <td colspan="2" class="text-right money-font"><?php echo number_format($order_status['success']); ?> đơn</td>
          </tr>
          <tr>
            <td class="text-center">04</td>
            <td colspan="3">Đơn hàng đã hủy / Hoàn trả</td>
            <td colspan="2" class="text-right money-font"><?php echo number_format($order_status['cancelled']); ?> đơn</td>
          </tr>
          <tr style="background-color: #f2f2f2; font-weight: bold;">
            <td colspan="4" class="text-center">TỔNG SỐ ĐƠN HÀNG ĐÃ XỬ LÝ</td>
            <td colspan="2" class="text-right money-font"><?php echo number_format(array_sum($order_status)); ?> đơn</td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 15px;"></td></tr>

          <!-- MỤC IV: TOP 5 SẢN PHẨM BÁN CHẠY NHẤT -->
          <tr>
            <td colspan="6" class="section-title">IV. TOP 5 SẢN PHẨM CÓ DOANH THU & SỐ LƯỢNG BÁN CAO NHẤT</td>
          </tr>
          <tr>
            <th>STT</th>
            <th colspan="3">Tên sản phẩm</th>
            <th>Số lượng đã bán</th>
            <th>Doanh thu mang lại</th>
          </tr>
          <?php if(!empty($best_selling_products)): $stt=1; foreach($best_selling_products as $bp): ?>
          <tr>
            <td class="text-center"><?php echo $stt++; ?></td>
            <td colspan="3"><?php echo htmlspecialchars($bp['name']); ?></td>
            <td class="text-right money-font"><?php echo number_format($bp['real_sold']); ?></td>
            <td class="text-right money-font"><?php echo number_format($bp['real_revenue']); ?> đ</td>
          </tr>
          <?php endforeach; else: ?>
          <tr><td colspan="6" class="text-center">Chưa có dữ liệu giao dịch</td></tr>
          <?php endif; ?>
          <tr><td colspan="6" class="no-border" style="height: 25px;"></td></tr>

          <!-- PHẦN KÝ TÊN XÁC NHẬN CHUẨN DOANH NGHIỆP -->
          <tr>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">NGƯỜI LẬP BÁO CÁO</td>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">KẾ TOÁN TRƯỞNG</td>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">GIÁM ĐỐC DOANH NGHIỆP</td>
          </tr>
          <tr>
            <td colspan="2" class="no-border text-center" style="font-style: italic; font-size: 10pt;">(Ký và ghi rõ họ tên)</td>
            <td colspan="2" class="no-border text-center" style="font-style: italic; font-size: 10pt;">(Ký và ghi rõ họ tên)</td>
            <td colspan="2" class="no-border text-center" style="font-style: italic; font-size: 10pt;">(Ký tên và đóng dấu)</td>
          </tr>
          <tr><td colspan="6" class="no-border" style="height: 50px;"></td></tr>
          <tr>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">${reporter}</td>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">..................................</td>
            <td colspan="2" class="no-border text-center" style="font-weight: bold; font-size: 11pt;">..................................</td>
          </tr>
        </table>
      </body>
      </html>
    `;

    var blob = new Blob(['\ufeff' + excelHtml], {
      type: 'application/vnd.ms-excel;charset=utf-8'
    });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'BaoCao_KinhDoanh_NDNMobile_Nam_' + year + '.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }

</script>