<style>
  #system-cover{
    width:100%;
    height:45em;
    object-fit:cover;
    object-position:center center;
  }
  .d-none{
    display: none;
  }
  .font-size-20{
    font-size: 20px;
  }
</style>
    <?php
// Start the session only if one hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming 'username' is stored in the session
if (isset($_SESSION['username'])) {
    echo "<h1>Welcome, " . $_SESSION['name'] . "!</h1>";
} else {
    echo "<h3 style='floar:left; font-size: 1.1rem; font-weight: 400; margin: 0;'>Inventory And Vendor Management</h3>";
}
?>


<hr>
<div class="row">
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <a href="./?page=department" class="nav-link nav-department" style="padding: 0px; color: #2d3748; text-decoration: none; transition: background-color 0.2s;">
    <div class="info-box p-5">
      <span class="info-box-icon bg-gradient-light elevation-1 p-3"><i class="fas fa-code-branch"></i></span>
      <div class="my-auto">
        <span class="px-2">Departments</span>
        <span class="font-weight-bold font-size-20">
          <?php 
            $departments = $conn->query("SELECT id FROM department_list WHERE delete_flag = 0 AND status = 1")->num_rows;
            echo format_num($departments);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
  <a href="./?page=categories" class="nav-link nav-categories" style="padding: 0px; color: #2d3748; text-decoration: none; transition: background-color 0.2s;">
    <div class="info-box p-5">
      <span class="info-box-icon bg-gradient-light elevation-1 p-3"><i class="fas fa-th-list"></i></span>
      <div class="my-auto">
        <span class="px-2">Categories</span>
        <span class="font-weight-bold font-size-20">
          <?php 
            $category = $conn->query("SELECT * FROM category_list where delete_flag = 0 and `status` = 1")->num_rows;
            echo format_num($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
  <a href="./?page=items" class="nav-link nav-items" style="padding: 0px; color: #2d3748; text-decoration: none; transition: background-color 0.2s;">
    <div class="info-box p-5">
      <span class="info-box-icon bg-gradient-light elevation-1 p-3">
        <i class="fas fa-cubes"></i>
      </span>
      <div class="my-auto">
        <span class="px-2">Items</span>
        <span class="font-weight-bold font-size-20">
          <?php 
            $items = $conn->query("SELECT id FROM item_list where delete_flag = 0 and `status` = 1")->num_rows;
            echo format_num($items);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
    <!-- /.info-box -->
  </div>
</div>
<div class="container-fluid text-center d-none">
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="system-cover" id="system-cover" class="img-fluid">
</div>
