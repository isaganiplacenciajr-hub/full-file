<?php


include_once'connectdb.php';
session_start();


if($_SESSION['useremail']==""){

header('location:../index.php');

}






include_once"header.php";


?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <div class="alert alert-primary text-center" style="font-size:1.3rem; font-weight:500;">Welcome back, Admin!</div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-12 mb-4">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #17a2b8 60%, #138496 100%); color: #fff;">
              <div class="card-body d-flex align-items-center">
                <div class="mr-3" style="font-size:2.5rem;"><i class="fas fa-box"></i></div>
                <div>
                  <div style="font-size:1.1rem; font-weight:500;">Total Products</div>
                  <div style="font-size:2rem; font-weight:bold;">
                    <?php
                    $stmt = $pdo->prepare('SELECT COUNT(*) as total_products FROM tbl_product');
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $row['total_products'] ?? 0;
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-12 mb-4">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #28a745 60%, #218838 100%); color: #fff;">
              <div class="card-body d-flex align-items-center">
                <div class="mr-3" style="font-size:2.5rem;"><i class="fas fa-file-invoice"></i></div>
                <div>
                  <div style="font-size:1.1rem; font-weight:500;">Total Orders</div>
                  <div style="font-size:2rem; font-weight:bold;">
                    <?php
                    $stmt = $pdo->prepare('SELECT COUNT(*) as total_orders FROM tbl_invoice');
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $row['total_orders'] ?? 0;
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-12 mb-4">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #ffc107 60%, #e0a800 100%); color: #fff;">
              <div class="card-body d-flex align-items-center">
                <div class="mr-3" style="font-size:2.5rem;"><i class="fas fa-coins"></i></div>
                <div>
                  <div style="font-size:1.1rem; font-weight:500;">Total Sales</div>
                  <div style="font-size:2rem; font-weight:bold;">
                    <?php
                    $stmt = $pdo->prepare('SELECT SUM(total) as total_sales FROM tbl_invoice');
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo number_format($row['total_sales'] ?? 0, 2);
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-lg-12">
            <div class="card shadow border-0">
              <div class="card-header bg-primary text-white">
                <h5 class="m-0">Stock Monitoring</h5>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Size</th>
                      <th>Stock Level</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT category, SUM(stock) as total_stock FROM tbl_product GROUP BY category");
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      $stock = $row['total_stock'];
                      $status = '';
                      $color = '';

                      if ($stock < 15) {
                        $status = 'Low Stock (Re-stocking)';
                        $color = 'text-danger';
                      } elseif ($stock <= 20) {
                        $status = 'Medium Stock';
                        $color = 'text-warning';
                      } elseif ($stock <= 25) {
                        $status = 'Sufficient Stock';
                        $color = 'text-success';
                      } elseif ($stock < 40) {
                        $status = 'High Stock';
                        $color = 'text-success';
                      } else {
                        $status = 'Very High Stock';
                        $color = 'text-primary';
                      }

                      echo "<tr>";
                      echo "<td>{$row['category']}</td>";
                      echo "<td>{$stock}</td>";
                      echo "<td class='$color'>{$status}</td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="mt-3">
                  <h6>Legend:</h6>
                  <ul>
                    <li><span class="text-danger">Red</span>: Below 15 (Low Stock)</li>
                    <li><span class="text-warning">Yellow</span>: 16 to 20 (Medium Stock)</li>
                    <li><span class="text-success">Green</span>: 21 to 25 (Sufficient Stock)</li>
                    <li><span class="text-primary">Blue</span>: 26 up (High Stock)</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
 
 <?php

include_once"footer.php";


?>