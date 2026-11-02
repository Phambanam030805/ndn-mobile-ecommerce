<div class="flexslider">
  <ul class="slides">
   <?php
   $images = array();
   $img = isset($row['img']) ? trim($row['img']) : '';
   if ($img !== '') {
     $mang = explode('#', $img);
     foreach ($mang as $value) {
       $value = trim($value);
       if ($value !== '') {
         $images[] = $value;
       }
     }
   }

   if (empty($images) && !empty($row['avatar'])) {
     $images[] = $row['avatar'];
   }

   // Lọc ảnh trùng
   $images = array_unique($images);

   foreach ($images as $value) : 
       $img_src = base_url('public/images/products/' . $value);
   ?>
     <li data-thumb="<?php echo $img_src; ?>">
        <div class="thumb-image" style="text-align: center; background: #fff; padding: 10px; border-radius: 8px;">
            <img src="<?php echo $img_src; ?>" class="img-responsive" style="max-height: 420px; margin: 0 auto; object-fit: contain;" alt="<?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?>">
        </div>
    </li>
<?php endforeach; ?>
</ul>
<div class="clearfix"></div>
</div>
