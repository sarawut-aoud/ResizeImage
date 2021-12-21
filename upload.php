<?php 
  /**
   * ลดขนาดรูปภาพก่อนอัปโหลดเข้าสู่ Server ด้วย PHP
   *
   * @link https://appzstory.dev
   * @author Yothin Sapsamran (Jame AppzStory Studio)
   */  
    if(isset($_POST["submit"]) && !$_FILES['file']['error']) {
        $file = $_FILES['file']['tmp_name']; 
        $sourceProperties = getimagesize($file);
        $fileNewName = time();
        $folderPath = "uploads/";
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];

        switch ($imageType) {

            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file); 
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;

            default:
                echo "Invalid Image type.";
                exit;
                break;
        }
        move_uploaded_file($file, $folderPath. $fileNewName. "_origin.". $ext);
    } else {
        header("location: ./");
    }

    function imageResize($imageResourceId,$width,$height) {
        $targetWidth = $width < 1280 ? $width : 1280 ;
        $targetHeight = ($height/$width)* $targetWidth;
        $targetLayer = imagecreatetruecolor($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        return $targetLayer;
    }


    /** show details */
    function size_as_kb($size = 0) {
        if($size < 1048576) {
            $size_kb = round($size / 1024, 2);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($size / 1048576, 2);
            return "{$size_mb} MB";
        }
    }

    function imgSize($img) {
        $targetWidth = $img[0] < 1280 ? $img[0] : 1280 ;
        $targetHeight = ($img[1] / $img[0])* $targetWidth;
        return [round($targetWidth, 2), round($targetHeight, 2)];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppzStory Upload Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="alert alert-primary text-center" role="alert">
                    <h4>อัปโหลดรูปภาพสำเร็จแล้ว</h4>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <img src="uploads/<?php echo $fileNewName."_origin.". $ext ?>" class="card-img-top" alt="...">
                    <div class="alert alert-danger text-center" role="alert">
                        <h4>ข้อมูลรูปภาพ ต้นฉบับ</h4>
                    </div>
                    <div class="card-body">
                        <h5>ชื่อรูปภาพ: <?php echo $fileNewName."_origin.". $ext ?></h5>
                        <h5>สัดส่วนรูปภาพ: <?php echo $sourceProperties[0]."px * ".$sourceProperties[1]."px" ?></h5>
                        <h5>ขนาดไฟล์: <?php echo size_as_kb($_FILES['file']['size']) ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <img src="uploads/<?php echo $fileNewName."_thump.". $ext ?>" class="card-img-top" alt="...">
                    <div class="alert alert-success text-center" role="alert">
                        <h4>ข้อมูลรูปภาพใหม่ หลังปรับขนาดแล้ว</h4>
                    </div>
                    <div class="card-body">
                        <h5>ชื่อรูปภาพ: <?php echo $fileNewName."_thump.". $ext ?></h5>
                        <h5>สัดส่วนรูปภาพ: <?php echo imgSize($sourceProperties)[0]."px * ".imgSize($sourceProperties)[1]."px" ?></h5>
                        <h5>ขนาดไฟล์: <?php echo size_as_kb(filesize("uploads/{$fileNewName}_thump.{$ext}")) ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center my-5">
                <a href="./" class="btn btn-primary btn-lg"> อัปโหลดรูปภาพใหม่ </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>