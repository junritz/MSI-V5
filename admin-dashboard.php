<?php
include('header.php');
?>

<?php
include_once('admin-sidebar.php');
?>



<main class="main position-absolute overflow-hidden">
  <!-- TOP SECTIONS -->
  <div class="topbar">
    <div class="toggle position-relative text-white"><i class="fa-solid fa-bars text-dark"></i></div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="container-fluid mt-5 pb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
      <h4 class="m-0">Dashboard</h4>
      <div class="d-flex gap-2">
        <button type="button" class="action-btn">Generate PDF</button>
      </div>
    </div>
    <div class="row gy-4">
      <div class="col-lg-8 col-sm-12">
        <div class="row">
        <div class="col-12">
  <div class="row gy-4">
    <!-- COUNT ANALYSIS -->
    <div class="col-lg-4 col-sm-12">
      <div class="admin-card d-flex align-items-center justify-content-evenly flex-wrap gap-3 rounded">
        <div class="icons rounded-circle d-flex align-items-center justify-content-center">
          <i class="fa-solid fa-dollar-sign"></i>
        </div>
        <div class="context">
          <p class="card-title">Total Sales</p>
          <h4 class="count">$15,640.50</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-12">
      <div class="admin-card d-flex align-items-center justify-content-evenly flex-wrap gap-3 rounded">
        <div class="icons rounded-circle d-flex align-items-center justify-content-center">
          <i class="fa-solid fa-box"></i>
        </div>
        <div class="context">
          <p class="card-title">Total Orders</p>
          <h4 class="count">1,250</h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-12">
      <div class="admin-card d-flex align-items-center justify-content-evenly flex-wrap gap-3 rounded">
        <div class="icons rounded-circle d-flex align-items-center justify-content-center">
          <i class="fa-solid fa-users"></i>
        </div>
        <div class="context">
          <p class="card-title">Total Customers</p>
          <h4 class="count">780</h4>
        </div>
      </div>
    </div>
    
    <!-- CHART ANALYSIS -->
    <div class="col-12">
      <div class="admin-card rounded">
        <div class="w-auto" id="monthly-chart"></div>
      </div>
    </div>

    <!-- Recent Customer Purchases Table -->
    <div class="col-12">
      <div class="admin-card rounded p-0">
        <div class="label-container d-flex align-items-center justify-content-between p-2">
          <label for="recently" class="text-white">Recent Customer Purchases</label>
          <a href="" class="m-0 rounded">See More</a>
        </div>
        <div class="table-responsive">
          <table class="table recent-customer-table m-0" id="recent-customer-table">
            <thead>
              <tr>
                <th scope="col">Customer Name</th>
                <th scope="col">Product</th>
                <th scope="col">Category</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>John Doe</td>
                <td>Running Shoes</td>
                <td>Footwear</td>
                <td>$95.00</td>
                <td>01/10/2024</td>
              </tr>
              <tr>
                <td>Jane Smith</td>
                <td>Cotton T-shirt</td>
                <td>Apparel</td>
                <td>$20.00</td>
                <td>02/10/2024</td>
              </tr>
              <tr>
                <td>Michael Lee</td>
                <td>Leather Jacket</td>
                <td>Apparel</td>
                <td>$150.00</td>
                <td>03/10/2024</td>
              </tr>
              <tr>
                <td>Sara Green</td>
                <td>Sports Sneakers</td>
                <td>Footwear</td>
                <td>$110.00</td>
                <td>04/10/2024</td>
              </tr>
              <tr>
                <td>Tom Clark</td>
                <td>Graphic T-shirt</td>
                <td>Apparel</td>
                <td>$25.00</td>
                <td>05/10/2024</td>
              </tr>
              <tr>
                <td>Emily Davis</td>
                <td>Denim Jacket</td>
                <td>Apparel</td>
                <td>$80.00</td>
                <td>06/10/2024</td>
              </tr>
              <tr>
                <td>Daniel Wilson</td>
                <td>Flip Flops</td>
                <td>Footwear</td>
                <td>$15.00</td>
                <td>07/10/2024</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="row gy-4">

          <!-- Pie chart -->
          <div class="col-12">
            <div class="admin-card rounded">
              <div class="row gy-4">
                <div class="col-12">
                  <div class="" id="products-chart"></div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <h4 class="mb-4 text-secondary">Top Buyer</h4>
                    <div class="col-lg-6 col-sm-12">
                      <div class="d-flex gap-2 align-items-center text-secondary">
                        <i class="fa-solid fa-circle" style="font-size: 8px;"></i>
                        <small>Buyer Name</small>
                      </div>
                      <h5>Alfred</h5>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <div class="d-flex gap-2 align-items-center text-secondary">
                        <i class="fa-solid fa-circle" style="font-size: 8px;"></i>
                        <small>Buyer Name</small>
                      </div>
                      <h5>Don Basco</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="admin-card rounded p-0 text-white">
              <div class="label-container d-flex align-items-center justify-content-between p-2">
                <label for="recently" class="">Recently Registered Users</label>
                <a href="" class="m-0 rounded">See More</a>
              </div>
              <div class="table-responsive pb-2">
                <table class="table recent-customer-table m-0" id="recent-customer-table">
                  <thead>
                    <tr>
                      <th scope="col">Email</th>
                      <th scope="col">Registration Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>john.doe@example.com</td>
                      <td>01/10/2024</td>
                    </tr>
                    <tr>
                      <td>jane.smith@example.com</td>
                      <td>02/10/2024</td>
                    </tr>
                    <tr>
                      <td>michael.lee@example.com</td>
                      <td>03/10/2024</td>
                    </tr>
                    <tr>
                      <td>sara.green@example.com</td>
                      <td>04/10/2024</td>
                    </tr>
                    <tr>
                      <td>tom.clark@example.com</td>
                      <td>05/10/2024</td>
                    </tr>
                    <tr>
                      <td>emily.davis@example.com</td>
                      <td>06/10/2024</td>
                    </tr>
                    <tr>
                      <td>daniel.wilson@example.com</td>
                      <td>07/10/2024</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</main>

<?php
include('footer.php');
?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="module" src="assets/javascript/admin-dashboard.js"></script>