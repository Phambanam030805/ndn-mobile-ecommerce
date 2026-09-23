

<div class="flexslider">
  <ul class="slides">
   <?php
   $images = array();
   $img = isset($row['img']) ? trim($row['img']) : '';
   if ($img !== '') {
     $mang = explode('#', $img);
     foreach ($mang as $value) {
       $value = trim($value);
       if ($value !== '' && file_exists(FCPATH . 'public/images/products/' . $value)) {
         $images[] = $value;
       }
     }
   }

   if (empty($images) && !empty($row['avatar']) && file_exists(FCPATH . 'public/images/products/' . $row['avatar'])) {
     $images[] = $row['avatar'];
   }

   foreach ($images as $value) : ?>
     <li data-thumb="<?php echo base_url('public/images/products/'.$value); ?>">
        <div class="thumb-image"><img src="<?php echo base_url('public/images/products/'.$value); ?>" class="img-responsive"></div>
    </li>
<?php endforeach; ?>
</ul>
<div class="clearfix"></div>
</div>
