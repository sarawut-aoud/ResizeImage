<?php 
  /**
   * ลดขนาดรูปภาพก่อนอัปโหลดเข้าสู่ Server ด้วย PHP
   *
   * @link https://appzstory.dev
   * @author Yothin Sapsamran (Jame AppzStory Studio)
   */  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจก Code ลดขนาดรูปภาพก่อนอัปโหลดเข้าสู่ Server ด้วย PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="file" class="col-sm-3 col-form-label">อัปโหลดรูปภาพ</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="file" name="file" onchange="readURL(this)" required>
                        </div>    
                    </div>
                    <div id="imgControl" class="d-none">
                        <img id="imgUpload" class="img-fluid my-3">
                        <div class="d-grid">
                            <button class="btn btn-primary" name="submit">อัปโหลด</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function readURL(input){
            if(input.files[0]){
                let reader = new FileReader();
                document.querySelector('#imgControl').classList.replace("d-none", "d-block");
                reader.onload = function (e) {
                    let element = document.querySelector('#imgUpload');
                    element.setAttribute("src", e.target.result);
                }  
                reader.readAsDataURL(input.files[0]);
            }         
        }
    </script>
</body>
</html>