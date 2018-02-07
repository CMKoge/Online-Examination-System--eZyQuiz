<?php
 class Image {
   private $_db;
   protected $upload_dir = 'destination_image';
   public $uploaded = array();
   public $allowed = array('jpeg', 'png', 'jpg');

   public function __construct() {
     $this->_db = Database::getInstance();
   }

   public function attach_file($image) {
     $image = $_FILES['image'];
     foreach ($image['name'] as $position => $img_name) {
       $img_temp = $image['tmp_name'][$position];
       $img_size = $image['size'][$position];
       $img_error = $image['error'][$position];

       $img_ext = explode('.', $img_name);
       $img_ext = strtolower(end($img_ext));

       if (in_array($img_ext, $this->allowed)) {

         if ($img_size <= 5097152) {
           $img_name_new = uniqid('', true) . '.' . $img_ext;
           $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $img_name_new;

           if (move_uploaded_file($img_temp, $target_path)) {
             $fields = array(
               'name' => $img_name_new,
               'size' => $img_size,
               'date' => date('Y-m-d H:i:s'),
               'destination_id' => 1
             );
               if ($this->_db->insert('image',$fields)) {
               } else {
                  throw new Exception("Error Occur While Uploading Images");
               }
             $uploaded[$position] = $target_path;// Test Purpose Only
           }
         }
       }
     }
   }

 }
 ?>
