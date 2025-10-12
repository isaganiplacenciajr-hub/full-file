
<?php

include_once'connectdb.php';
session_start();



include_once"header.php";

if(isset($_POST['btnsave']))
{


$barcode = $_POST['txtBarcode'];
$product = $_POST['txtProductcode'];
$category = $_POST['txtBarcode']; // Category dropdown
$description = $_POST['txtdescription'];
$servicetype = $_POST['txtstock']; // Service Type dropdown
$additionalfee = $_POST['txtsaleprice']; // Additional Fee input
$purchaseprice = $_POST['txtpurchaseprice'];
$saleprice = $_POST['txtsaleprice2']; // Sale Price input



$f_name = $_FILES['myfile']['name'];
$f_tmp = $_FILES['myfile']['tmp_name'];

$f_size = $_FILES['myfile']['size'];

$f_extension = explode('.', $f_name);
$f_extension = strtolower(end($f_extension));

$f_newfile = uniqid(). '.'. $f_extension;

$store = "productimages/".$f_newfile;

if($f_extension == 'jpg' || $f_extension= 'jpeg' || $f_extension == 'png' || $f_extension == 'gif'){

if($f_size>=1000000){


    $_SESSION['status']= "max file should be 1MB";
    $_SESSION['status_code']="warning";
}else{
  if(move_uploaded_file($f_tmp, $store)){

$productimage = $f_newfile;

if(empty($barcode)){



  $insert=$pdo->prepare("insert into tbl_product(product,category, description,servicetype,additionalfee,purchaseprice,saleprice,image)
  values(:product,:category,:description,:servicetype,:additionalfee,:pprice,:saleprice,:img)");




  $insert->bindParam(':product',$product);
  $insert->bindParam(':category',$category);
  $insert->bindParam(':description', $description);
  $insert->bindParam(':servicetype', $servicetype);
  $insert->bindParam(':additionalfee', $additionalfee);
  $insert->bindParam(':pprice', $purchaseprice);
  $insert->bindParam(':saleprice', $saleprice);
  $insert->bindParam(':img', $productimage);
  
  ($insert->execute());

$pid = $pdo->lastInsertId();

date_default_timezone_set("Africa/mogadishu");
$newbarcode=$pid.date('his');

$update=$pdo->prepare("update tbl_product set barcode='$newbarcode' where pid='".$pid."'");

if($update->execute()){

  $_SESSION['status']= "product inserted successfully";
  $_SESSION['status_code']="success"; 
}else{
  $_SESSION['status']= "product inserted failed";
  $_SESSION['status_code']="error";
}



}else{





$insert=$pdo->prepare("insert into tbl_product(barcode, product,category, description,servicetype,additionalfee,purchaseprice,saleprice,image)
values(:barcode,:product,:category,:description,:servicetype,:additionalfee,:pprice,:saleprice,:img)");


$insert->bindParam(':barcode', $barcode);
$insert->bindParam(':product',$product);
$insert->bindParam(':category',$category);
$insert->bindParam(':description', $description);
$insert->bindParam(':servicetype', $servicetype);
$insert->bindParam(':additionalfee', $additionalfee);
$insert->bindParam(':pprice', $purchaseprice);
$insert->bindParam(':saleprice', $saleprice);
$insert->bindParam(':img', $productimage);

if($insert->execute()){
  
  $_SESSION['status']= "product inserted successfully";
  $_SESSION['status_code']="success";
}else{
  
  $_SESSION['status']= "product inserted failed";
  $_SESSION['status_code']="error";
}


}



  }
   

}
}
else{
    
    $_SESSION['status']= "only jpg, jpeg, png and gif can be uploaded";
    $_SESSION['status_code']="warning";
    
}

}


?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Product</h1>
            <hr>
            <a href="productlist.php" class="btn btn-info"><span class="report-count"> View product you entered</span></a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">


          <div class="card card-warning card-outline">
              <div class="card-header">
                <h5 class="m-0">Product</h5>
              </div>
              



              <form action="" method="post" enctype="multipart/form-data">  
<div class="row">
<div class="col-md-6">



<div class="form-group">
    <label>Product Code:</label>
    <input type="text" class="form-control" placeholder="Enter Product Code" name="txtProductcode" required>
</div>

<div class="form-group">
  <label>Category:</label>
  <select class="form-control" name="txtBarcode" required>
    <option value="" disabled selected>Select Category</option>
    <option value="5 kg (Medium)">5 kg (Medium)</option>
    <option value="11 Kg (Standard)">11 Kg (Standard)</option>
    <option value="22 Kg (Large)">22 Kg (Large)</option>
    <option value="50 Kg (Extra Large)">50 Kg (Extra Large)</option>
  </select>
</div>


<div class="form-group">
  <label>Description:</label>
  <input type="text" class="form-control" placeholder="Enter Description" name="txtdescription" required>
</div>

<div class="form-group">
  <label>Service Type:</label>
  <select class="form-control" name="txtstock" id="servicetype" required>
    <option value="" disabled selected>Select Service Type</option>
    <option value="Delivery">Delivery</option>
    <option value="Pick-up">Pick-up</option>
  </select>
</div>

<div class="form-group">
  <label>Additional Fee:</label>
  <input type="text" class="form-control" placeholder="Enter Additional Fee" name="txtsaleprice" id="additionalfee" required>
</div>


<div class="form-group">
  <label>Purchase Price:</label>
  <input type="text" class="form-control" placeholder="Enter Purchase Price" name="txtpurchaseprice" required>
</div>


<div class="form-group">
  <label>Sale Price:</label>
  <input type="text" class="form-control" placeholder="Enter Sale Price" name="txtsaleprice2" required>
</div>

<div class="form-group">
    <label>Product Image:</label>
    <input type="file" class="input-group" name="myfile" required>
    <p>Upload image</p>
</div>


</div>

</div>

<div class="card-footer">
    <div class="text-center">
        <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="btnsave">Save Product</button></div>
                </div>



<script>
document.addEventListener('DOMContentLoaded', function() {
  var serviceType = document.getElementById('servicetype');
  var additionalFee = document.getElementById('additionalfee');
  if(serviceType && additionalFee) {
    serviceType.addEventListener('change', function() {
      if(this.value === 'Delivery') {
        additionalFee.value = '50.00';
      } else if(this.value === 'Pick-up') {
        additionalFee.value = '0.00';
      } else {
        additionalFee.value = '';
      }
    });
  }
});
</script>
</form>


</div>

            
    </div>

 </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <?php

include_once("footer.php");

?>


<?php 
if(isset($_SESSION['status'])&& $_SESSION['status']!=='')
{

  ?>
<script>
    

      Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      })
</script>



<?php
unset($_SESSION['status']);
}

?>