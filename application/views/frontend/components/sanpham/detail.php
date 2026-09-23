<section id="product-detail" class="product-detail-page">
    <div class="container">
        <?php if($row):?>
            <!-- Breadcrumbs hiện đại -->
            <nav aria-label="breadcrumb" class="modern-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('san-pham/'.$this->Mdanhmuc->category_link($row['catid'])); ?>"><?php echo $name; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['name'] ?></li>
                </ol>
            </nav>

            <div class="product-view-container card-shadow">
                <div class="row">
                    <!-- Ảnh sản phẩm -->
                    <div class="col-md-6 col-sm-12">
                        <div class="product-gallery-wrapper">
                            <?php $this->load->view('frontend/modules/jcarousel');?>
                        </div>
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="col-md-6 col-sm-12">
                        <div class="product-view-info">
                            <h1 class="product-main-name"><?php echo $row['name'] ?></h1>
                            
                            <div class="product-status-bar">
                                <span class="status-item">Thương hiệu: <strong><?php $producer=$this->Mnhacungcap->producer_detail($row['producer_id']); echo $producer['name']; ?></strong></span>
                                <span class="divider">|</span>
                                <span class="status-item">Đã bán: <strong><?php echo $row['number_buy']; ?></strong></span>
                                <span class="divider">|</span>
                                <span class="status-item">Tình trạng: 
                                    <strong class="<?php echo ($row['number'] - $row['number_buy'] > 0) ? 'text-success' : 'text-danger'; ?>">
                                        <?php if($row['number'] - $row['number_buy']==0 || $row['status'] == 0) echo 'Hết hàng'; else echo 'Còn hàng' ?>
                                    </strong>
                                </span>
                            </div>

                            <div class="product-price-block">
                                <div class="price-current"><?php echo render_price($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']); ?></div>
                                <?php if($row['price_sale'] > 0 && $row['sale'] > 0): ?>
                                    <div class="price-old-wrapper">
                                        <span class="price-old"><?php echo number_format($row['price']); ?>₫</span>
                                        <span class="sale-badge">-<?php echo $row['sale'] ?>%</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="product-short-desc">
                                <h5><i class="fa fa-align-left"></i> Mô tả ngắn:</h5>
                                <p><?php echo $row['sortDesc'] ?></p>
                            </div>

                            <!-- Lựa chọn thuộc tính (Nâng cấp chuẩn) -->
                            <div class="product-variations-modern mb-4">
                                <?php if(!empty($row['capacity'])): ?>
                                    <div class="variation-item mb-4">
                                        <h5 class="variation-label">Dung lượng: <span id="current-capacity-text" class="text-danger font-weight-bold"></span></h5>
                                        <div class="variation-options capacity-group" id="capacity-options">
                                            <?php $caps = explode(',', $row['capacity']); 
                                            foreach($caps as $index => $cap): $cap = trim($cap); ?>
                                                <div class="cap-item <?php echo $index==0?'active':''; ?>" 
                                                     onclick="selectVariationModern(this, 'capacity', '<?php echo $cap; ?>')">
                                                    <span class="cap-text"><?php echo $cap; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="hidden" name="selected_capacity" id="selected_capacity" value="<?php echo trim($caps[0]); ?>">
                                    </div>
                                <?php endif; ?>

                                <?php if(!empty($row['color'])): ?>
                                    <div class="variation-item mb-4">
                                        <h5 class="variation-label">Màu sắc: <span id="current-color-text" class="text-danger font-weight-bold"></span></h5>
                                        <div class="variation-options color-group" id="color-options">
                                            <?php 
                                            $cols = explode(',', $row['color']); 
                                            // Hàm map màu sang mã Hex (Tinh chỉnh màu siêu chuẩn theo ảnh)
                                            function get_color_hex($color_name) {
                                                $map = [
                                                    'Titan Tự Nhiên' => '#bebebe', 'Titan Sa Mạc' => '#C9B197', 'Titan Trắng' => '#f5f5f5', 'Titan Đen' => '#2c2c2c',
                                                    'Titan Xám' => '#808080', 'Đen' => '#000000', 'Trắng' => '#ffffff', 'Vàng Starlight' => '#E7DED0', 'Vàng đồng' => '#EAE0D0', 'Vàng' => '#E7E0D0', 'Tím' => '#B5B1D2',
                                                    'Xanh dương đậm' => '#1B2631', 'Xanh dương nhạt' => '#AED6F1', 'Xanh dương' => '#8FA0AB', 'Xanh' => '#2C3E50', 'Đỏ' => '#e74c3c', 'Hồng nhạt' => '#F7D1D1', 'Hồng' => '#D2B9B1', 'Bạc' => '#EAE3D2', 'Xanh Teal' => '#008080',
                                                    'Titan' => '#7f8c8d', 'Obsidian' => '#4b4b4b', 'Porcelain' => '#fdf5e6', 'Bay' => '#add8e6', 'Xanh Lưu Ly' => '#000080',
                                                    'Vàng Cát' => '#EAE3D2', 'Be' => '#f5f5dc', 'Đen Đồng' => '#3d3d3d', 'Kem' => '#fffdd0', 'Cam' => '#E8A48B',
                                                    'Đen bạc' => '#707070', 'Xanh lá' => '#D2E5D2'
                                                ];
                                                foreach($map as $key => $hex) {
                                                    if(strpos(mb_strtolower($color_name), mb_strtolower($key)) !== false) return $hex;
                                                }
                                                return '#ddd'; 
                                            }
                                            
                                            foreach($cols as $index => $col): $col = trim($col); 
                                                $hex = get_color_hex($col);
                                            ?>
                                                <div class="color-item <?php echo $index==0?'active':''; ?>" 
                                                     title="<?php echo $col; ?>"
                                                     onclick="selectVariationModern(this, 'color', '<?php echo $col; ?>')">
                                                    <span class="color-swatch" style="background-color: <?php echo $hex; ?>; border: 1px solid <?php echo ($hex == '#ffffff' ? '#ddd' : $hex); ?>"></span>
                                                    <span class="color-name-popup"><?php echo $col; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="hidden" name="selected_color" id="selected_color" value="<?php echo trim($cols[0]); ?>">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Khối mua hàng -->
                            <div class="purchase-action">
                                <?php if($row['number'] - $row['number_buy']==0 || $row['status'] == 0): ?>
                                    <div class="out-of-stock-msg">
                                        <i class="fa fa-info-circle"></i> Sản phẩm hiện đang ngừng kinh doanh
                                    </div>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger btn-buy-now" onclick="onAddCart(<?php echo $row['id']; ?>)">
                                        <i class="fa fa-shopping-cart"></i> MUA NGAY
                                        <span>Giao hàng tận nơi nhanh chóng</span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Khối Khuyến mại & Chính sách -->
                            <div class="product-policy-box">
                                <div class="policy-header"><i class="fa fa-gift"></i> Khuyến mại đặc biệt</div>
                                <div class="policy-content">
                                    <ul class="promo-list">
                                        <li><i class="fa fa-check-circle"></i> Tặng PMH Phụ Kiện 2,000,000đ cho đơn hàng trên 10tr.</li>
                                        <li><i class="fa fa-check-circle"></i> Giảm thêm 900,000đ khi mua combo (Phone + Watch + Buds).</li>
                                        <li><i class="fa fa-check-circle"></i> Miễn phí giao hàng nội thành trong 30 phút.</li>
                                    </ul>
                                </div>
                                
                                <div class="policy-footer">
                                    <div class="footer-item"><i class="fa fa-refresh"></i> 1 đổi 1 trong 30 ngày</div>
                                    <div class="footer-item"><i class="fa fa-shield"></i> Bảo hành 12 tháng chính hãng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Đặc điểm nổi bật -->
                <div class="row mt-5">
                    <div class="col-md-8 col-sm-12">
                        <div class="product-full-detail">
                            <h3 class="detail-title">Đặc điểm nổi bật</h3>
                            <div class="detail-content">
                                <?php echo $row['detail']?>
                            </div>
                        </div>
                        
                        <!-- Bình luận -->
                        <div class="product-reviews mt-5">
                            <h3 class="detail-title">Bình luận khách hàng</h3>
                            <div class="fb-comments" data-href="<?php echo base_url($row['alias']) ?>" data-numposts="5" data-width="100%"></div>
                        </div>
                    </div>

                    <!-- Cột phụ (Nếu có thông tin thêm) -->
                    <div class="col-md-4 col-sm-12">
                        <div class="sidebar-box card-shadow mb-4 p-3">
                            <h5 class="font-weight-bold mb-3">Thông số kỹ thuật</h5>
                            <div class="tech-specs-summary">
                                <p>Đang cập nhật chi tiết từ nhà sản xuất...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION ĐÁNH GIÁ & BÌNH LUẬN -->
            <div class="product-reviews-section mt-5 card-shadow p-4" style="background: #fff; border-radius: 12px; margin-top: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <div class="section-title-modern">
                    <h2 style="font-size: 24px; font-weight: bold; text-transform: uppercase;">Đánh giá & Bình luận</h2>
                    <div class="title-underline" style="margin-left: 0;"></div>
                </div>

                <div class="row mt-4" style="margin-top: 20px;">
                    <!-- Tóm tắt đánh giá -->
                    <div class="col-md-4 text-center" style="border-right: 1px solid #eee;">
                        <div class="rating-average">
                            <h1 style="font-size: 48px; color: #d70018; margin-bottom: 5px; font-weight: bold;">
                                <?php echo (isset($review_stats['avg_rating']) && $review_stats['avg_rating'] > 0) ? round($review_stats['avg_rating'], 1) : '0'; ?>/5
                            </h1>
                            <div class="stars" style="color: #f1c40f; font-size: 20px; margin-bottom: 10px;">
                                <?php 
                                $avg = isset($review_stats['avg_rating']) ? round($review_stats['avg_rating']) : 0;
                                for($i=1; $i<=5; $i++) echo $i <= $avg ? '<i class="fa fa-star"></i>' : '<i class="far fa-star"></i>';
                                ?>
                            </div>
                            <p class="text-muted"><?php echo isset($review_stats['total_reviews']) ? $review_stats['total_reviews'] : '0'; ?> đánh giá</p>
                            <button class="btn btn-danger btn-modern mt-2" onclick="jQuery('#reviewForm').slideToggle()" style="background: #d70018; border: none; border-radius: 25px; padding: 10px 20px;">Gửi đánh giá của bạn</button>
                        </div>
                    </div>

                    <!-- Danh sách bình luận -->
                    <div class="col-md-8">
                        <div class="reviews-list" style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                            <?php if(isset($reviews) && count($reviews) > 0): ?>
                                <?php foreach($reviews as $rv): ?>
                                    <div class="review-item mb-4 pb-3" style="border-bottom: 1px solid #f0f0f0; margin-bottom: 20px; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <strong style="font-size: 16px;"><?php echo htmlspecialchars($rv['fullname']); ?></strong>
                                            <small class="text-muted"><?php echo date('d/m/Y', strtotime($rv['created_at'])); ?></small>
                                        </div>
                                        <div class="stars" style="color: #f1c40f; font-size: 12px; margin: 5px 0;">
                                            <?php for($i=1; $i<=5; $i++) echo $i <= (int)$rv['title'] ? '<i class="fa fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                        </div>
                                        <p class="mt-2" style="color: #555; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($rv['content'])); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-5" style="padding: 50px 0;">
                                    <i class="fa fa-comments-o fa-3x" style="color: #ddd; margin-bottom: 15px;"></i>
                                    <p class="text-muted italic">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Form gửi đánh giá -->
                <div id="reviewForm" class="mt-4 p-4" style="display: none; background: #f9f9f9; border-radius: 12px; margin-top: 25px; padding: 25px; border: 1px solid #eee;">
                    <h4 class="mb-3 font-weight-bold" style="margin-bottom: 20px; font-weight: bold;">Gửi đánh giá của bạn</h4>
                    <form id="frmReview">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Nhập tên của bạn" required 
                                       value="<?php echo $this->session->userdata('fullname') ? $this->session->userdata('fullname') : ''; ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email (không bắt buộc)"
                                       value="<?php echo $this->session->userdata('email') ? $this->session->userdata('email') : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group" style="margin: 15px 0;">
                            <label>Đánh giá của bạn <span class="text-danger">*</span></label>
                            <div class="star-rating" id="star-rating-box" style="font-size: 28px; color: #ccc; cursor: pointer;">
                                <i class="fa fa-star star-item" data-value="1"></i>
                                <i class="fa fa-star star-item" data-value="2"></i>
                                <i class="fa fa-star star-item" data-value="3"></i>
                                <i class="fa fa-star star-item" data-value="4"></i>
                                <i class="fa fa-star star-item" data-value="5"></i>
                                <input type="hidden" name="rating" id="selected_rating" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nội dung đánh giá <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..." required style="resize: none;"></textarea>
                        </div>
                        <div class="mt-3" style="margin-top: 15px;">
                            <button type="button" class="btn btn-primary" onclick="submitReview()" style="background: #0f9ed8; border: none; padding: 10px 25px; border-radius: 5px;">Gửi đánh giá</button>
                            <button type="button" class="btn btn-link" onclick="jQuery('#reviewForm').slideUp()" style="color: #666;">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sản phẩm liên quan -->
            <div class="related-products-section mt-5 mb-5">
                <div class="section-title-modern">
                    <h2>Sản phẩm liên quan</h2>
                    <div class="title-underline"></div>
                </div>
                <?php $list_spcungloai = $this->Msanpham->product_cungloai($row['catid'], $row['id'], 4); ?>
                <div class="row">
                    <?php if(count($list_spcungloai) > 0): ?>
                        <?php foreach ($list_spcungloai as $sp) :?>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div class="product-lt product-card-modern">
                                    <div class="lt-product-group-image">
                                        <a href="<?php echo base_url($sp['alias']); ?>">
                                            <img class="img-p" src="<?php echo base_url('public/images/products/'.$sp['avatar']); ?>" alt="<?php echo $sp['name']; ?>">
                                        </a>
                                        <?php if($sp['sale'] > 0) :?>
                                            <div class="giam-percent"><span>-<?php echo $sp['sale'] ?>%</span></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="lt-product-group-info">
                                        <a href="<?php echo base_url($sp['alias']); ?>"><h3><?php echo $sp['name'] ?></h3></a>
                                        <div class="price-box">
                                            <?php if($sp['sale'] > 0) :?>
                                                <span class="price-new"><?php echo number_format($sp['price_sale']); ?>₫</span>
                                                <span class="price-old"><?php echo number_format($sp['price']); ?>₫</span>
                                            <?php else: ?>
                                                <span class="price-new"><?php echo number_format($sp['price']); ?>₫</span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12 text-center py-4">
                            <p class="text-muted">Hiện chưa có sản phẩm nào cùng loại.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function selectVariationModern(element, type, value) {
    // Xóa active của các thẻ cùng nhóm
    jQuery('#' + type + '-options .cap-item, #' + type + '-options .color-item').removeClass('active');
    // Thêm active cho thẻ hiện tại
    jQuery(element).addClass('active');
    // Cập nhật giá trị vào hidden input
    jQuery('#selected_' + type).val(value);
    // Cập nhật text hiển thị
    jQuery('#current-' + type + '-text').text(value);
}

// Khởi tạo text mặc định
jQuery(document).ready(function() {
    jQuery('#current-capacity-text').text(jQuery('#selected_capacity').val());
    jQuery('#current-color-text').text(jQuery('#selected_color').val());
});

function onAddCart(id){
    var capacity = jQuery('#selected_capacity').val() || '';
    var color = jQuery('#selected_color').val() || '';
    
    var strurl="<?php echo base_url('sanpham/addcart');?>";
    jQuery.ajax({
        url: strurl,
        type: 'POST',
        dataType: 'json',
        data: {
            id: id, 
            capacity: capacity,
            color: color,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        success: function(res) {
            if(res.status == 'success'){
                $('#cart-count').html('(' + res.count + ')');
                $('#cart-total').html(res.total);
                alert('Đã thêm sản phẩm [' + color + ' ' + capacity + '] vào giỏ hàng thành công!');
            }
        }
    });
}

// Xử lý chọn sao đánh giá
jQuery(document).on('click', '#star-rating-box .star-item', function() {
    var val = jQuery(this).data('value');
    jQuery('#selected_rating').val(val);
    jQuery('#star-rating-box .star-item').each(function() {
        if (jQuery(this).data('value') <= val) {
            jQuery(this).css('color', '#f1c40f').removeClass('far').addClass('fa');
        } else {
            jQuery(this).css('color', '#ccc').removeClass('fa').addClass('far');
        }
    });
});

// Gửi đánh giá qua AJAX
function submitReview() {
    var product_id = jQuery('input[name="product_id"]').val();
    var fullname = jQuery('input[name="fullname"]').val();
    var email = jQuery('input[name="email"]').val();
    var rating = jQuery('#selected_rating').val();
    var content = jQuery('textarea[name="content"]').val();

    if (!fullname || !rating || !content) {
        alert('Vui lòng điền đầy đủ thông tin và chọn số sao đánh giá!');
        return;
    }

    var strurl = "<?php echo base_url('sanpham/add_review');?>";
    jQuery.ajax({
        url: strurl,
        type: 'POST',
        dataType: 'json',
        data: {
            product_id: product_id,
            fullname: fullname,
            email: email,
            rating: rating,
            content: content,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        success: function(res) {
            alert(res.message);
            if (res.status == 'success') {
                location.reload();
            }
        }
    });
}
</script>

<style>
/* CSS NÂNG CẤP BIẾN THỂ CHUẨN */
.variation-label {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    margin-bottom: 12px;
}
.variation-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

/* Dung lượng */
.cap-item {
    border: 1px solid #ddd;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
    min-width: 80px;
    text-align: center;
}
.cap-item.active {
    border-color: #d70018;
    background: #fff5f5;
    color: #d70018;
    font-weight: 700;
    box-shadow: 0 0 0 1px #d70018;
}
.cap-text {
    font-size: 14px;
}

/* Màu sắc Swatches */
.color-item {
    position: relative;
    cursor: pointer;
    padding: 4px;
    border: 2px solid transparent;
    border-radius: 50%;
    transition: all 0.2s ease;
}
.color-item.active {
    border-color: #d70018;
    transform: scale(1.1);
}
.color-swatch {
    display: block;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}
.color-name-popup {
    position: absolute;
    bottom: 110%;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
    z-index: 10;
}
.color-item:hover .color-name-popup {
    opacity: 1;
    visibility: visible;
}

/* Responsive */
@media (max-width: 767px) {
    .variation-options {
        gap: 8px;
    }
    .cap-item {
        min-width: 70px;
        padding: 6px 10px;
    }
}
</style>
