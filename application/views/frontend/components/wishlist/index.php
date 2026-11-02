<div class="container" style="padding: 30px 15px;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; border-bottom: 2px solid #d70018; padding-bottom: 12px;">
        <h2 style="margin: 0; font-size: 22px; color: #333;">
            <i class="fas fa-heart" style="color: #d70018;"></i> Sản phẩm yêu thích
            <span style="background: #d70018; color: #fff; font-size: 12px; padding: 2px 8px; border-radius: 20px; margin-left: 8px; font-weight: 600;"><?php echo $count; ?></span>
        </h2>
        <?php if($count > 0): ?>
        <a href="<?php echo base_url('san-pham'); ?>" class="btn btn-default btn-sm" style="border-radius: 20px;">
            <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
        </a>
        <?php endif; ?>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <?php if(empty($list)): ?>
    <!-- Trạng thái rỗng -->
    <div style="text-align: center; padding: 80px 20px;">
        <i class="fas fa-heart-broken" style="font-size: 70px; color: #e0e0e0; display: block; margin-bottom: 20px;"></i>
        <h4 style="color: #999; font-weight: 400;">Danh sách yêu thích trống</h4>
        <p style="color: #bbb; margin-bottom: 25px;">Hãy thêm những sản phẩm bạn yêu thích để mua sau nhé!</p>
        <a href="<?php echo base_url('san-pham'); ?>" class="btn" style="background: #d70018; color: #fff; border-radius: 25px; padding: 12px 30px; font-weight: 600;">
            <i class="fas fa-shopping-bag"></i> Khám phá sản phẩm
        </a>
    </div>
    <?php else: ?>
    <!-- Danh sách sản phẩm yêu thích -->
    <div class="row">
        <?php foreach($list as $item): ?>
        <?php
            $price     = ($item['price_sale'] > 0) ? $item['price_sale'] : $item['price'];
            $old_price = ($item['price_sale'] > 0) ? $item['price'] : 0;
            $discount  = ($item['price_sale'] > 0 && $item['sale'] > 0) ? $item['sale'] : 0;
        ?>
        <div class="col-md-3 col-sm-4 col-xs-6" id="wishlist-item-<?php echo $item['id']; ?>" style="margin-bottom: 25px;">
            <div style="border: 1px solid #eee; border-radius: 10px; overflow: hidden; transition: box-shadow .2s; background: #fff; position: relative;"
                 onmouseover="this.style.boxShadow='0 6px 25px rgba(0,0,0,0.12)'"
                 onmouseout="this.style.boxShadow='none'">
                
                <!-- Badge giảm giá -->
                <?php if($discount > 0): ?>
                <span style="position: absolute; top: 10px; left: 10px; background: #d70018; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; z-index: 2;">-<?php echo $discount; ?>%</span>
                <?php endif; ?>

                <!-- Nút xóa khỏi wishlist -->
                <button onclick="removeWishlist(<?php echo $item['id']; ?>)"
                        title="Xóa khỏi yêu thích"
                        style="position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.9); border: 1px solid #eee; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; z-index: 2; display: flex; align-items: center; justify-content: center; color: #d70018;">
                    <i class="fas fa-times" style="font-size: 12px;"></i>
                </button>

                <!-- Ảnh sản phẩm -->
                <a href="<?php echo base_url($item['alias']); ?>">
                    <img src="<?php echo base_url('public/images/products/' . $item['avatar']); ?>"
                         alt="<?php echo htmlspecialchars($item['name']); ?>"
                         style="width: 100%; height: 180px; object-fit: contain; padding: 15px; background: #fafafa;">
                </a>

                <!-- Thông tin -->
                <div style="padding: 12px 15px 15px;">
                    <a href="<?php echo base_url($item['alias']); ?>"
                       style="font-size: 13px; font-weight: 600; color: #333; text-decoration: none; display: block; margin-bottom: 8px; line-height: 1.4; height: 38px; overflow: hidden;">
                        <?php echo htmlspecialchars($item['name']); ?>
                    </a>

                    <div style="margin-bottom: 12px;">
                        <span style="font-size: 16px; font-weight: 700; color: #d70018;"><?php echo number_format($price); ?>đ</span>
                        <?php if($old_price > 0): ?>
                        <span style="font-size: 12px; color: #999; text-decoration: line-through; margin-left: 5px;"><?php echo number_format($old_price); ?>đ</span>
                        <?php endif; ?>
                    </div>

                    <!-- Nút hành động -->
                    <div style="display: flex; gap: 6px;">
                        <a href="<?php echo base_url($item['alias']); ?>" 
                           class="btn btn-sm btn-block"
                           style="background: #d70018; color: #fff; border-radius: 5px; font-size: 12px; font-weight: 600; flex: 1; text-align: center; padding: 7px 4px;">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                        <button onclick="addToCartFromWishlist(<?php echo $item['id']; ?>, '<?php echo addslashes($item['name']); ?>')"
                                class="btn btn-sm"
                                style="background: #ff6b35; color: #fff; border: none; border-radius: 5px; font-size: 12px; font-weight: 600; padding: 7px 8px;" title="Thêm vào giỏ">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function removeWishlist(productId) {
    if(!confirm('Xóa sản phẩm này khỏi danh sách yêu thích?')) return;
    $.ajax({
        url: base_url + 'yeu-thich/xoa/' + productId,
        type: 'GET',
        success: function(res) {
            try {
                var r = JSON.parse(res);
                if(r.status === 'success') {
                    $('#wishlist-item-' + productId).fadeOut(300, function() { $(this).remove(); });
                    // Cập nhật badge nếu có
                    if($('.wishlist-count').length) {
                        var count = parseInt($('.wishlist-count').text() || 0);
                        $('.wishlist-count').text(Math.max(0, count - 1));
                    }
                }
            } catch(e) { location.reload(); }
        }
    });
}

function addToCartFromWishlist(productId, productName) {
    $.ajax({
        url: base_url + 'addcart',
        type: 'POST',
        data: { id: productId },
        success: function(res) {
            try {
                var r = JSON.parse(res);
                if(r.status === 'success') {
                    alert('Đã thêm "' + productName + '" vào giỏ hàng!');
                    if(r.count) $('.cart-count').text(r.count);
                }
            } catch(e) {}
        }
    });
}
</script>
