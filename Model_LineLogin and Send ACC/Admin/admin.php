<?php
session_start();

$isSuccess = isset($_GET['success']) && $_GET['success'] === 'true';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...your-sha512-hash..." crossorigin="anonymous" />
    <style>
        .form-label {
            font-weight: bold;
        }
        .top {
            margin-top: 5%;
        }
    </style>
       <script>
        function updateStock() {
            // Make an AJAX request to update the stock
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "https://www.ttomoru.com/Line_Login/Check_order_to_push/update_stock.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Stock updated successfully.");
                }
            };
            xhr.send();
        }

        window.onload = function() {
            // Run the updateStock function every 3 seconds
            setInterval(updateStock, 3000);
        };
    </script>
    
</head>
<body onload="showContent()">
    <?php if ($isSuccess) : ?>
          <script>
            alert('Add Data Success!!');
          </script>
        <?php endif; ?>
    <div class="container top" id="content" style="display: none;">
        <h2>Product Inventory</h2>

        <!-- Button to open modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add Product</button>
         <!-- Rest of the code -->
    
    <!-- Button to update stock -->
    <a href="https://www.ttomoru.com/Line_Login/Check_order_to_push/update_stock.php" class="btn btn-primary">Update Stock</a>
    
    <!-- Reset button with icon -->
    <button type="button" class="btn btn-secondary" onclick="location.href = '<?php echo $_SERVER['PHP_SELF']; ?>'">
        <i class="fas fa-sync-alt"></i> Reset
    </button>
    
    <!-- Rest of the code -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="add_data.php">
                            <div class="form-group">
                                <label for="type" class="form-label">Type:</label>
                                <select class="form-control" id="type" name="type">
                                  <option value="Wetv">Wetv</option>
                                  <option value="Viu">Viu</option>
                                  <option value="Prime">Prime</option>
                                  <option value="Youku30">Youku30</option>
                                  <option value="HBO GO">HBO GO</option>
                                  <option value="True id+">True id+</option>
                                  <option value="Youtube">Youtube</option>
                                  <option value="Spotify">Spotify</option>
                                  <option value="Gagaoolala">Gagaoolala</option>
                                  <option value="NETFLIX">NETFLIX</option>
                                  <option value="MONOMAX">MONOMAX</option>
                                  <option value="YOUTUBE">YOUTUBE</option>
                                  <option value="JOOX">JOOX</option>
                                  <option value="BUGABOO">BUGABOO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                 <label for="product" class="col-form-label">Product:</label>
                                 <select class="form-control" id="product" name="product">
                                <?php
                                // Assuming you have already established a database connection
                                    require_once('./connect_db.php');
                                // Fetching data from the table
                                    $query = "SELECT * FROM `wp_wc_product_meta_lookup` ORDER BY `wp_wc_product_meta_lookup`.`sku` ASC";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                    $sku = $row['sku'];
                                    echo "<option value=\"$sku\">$sku</option>";
                                }
                                    } else {
                                    echo "<option value=\"\">No options found</option>";
                                 }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type" class="form-label">Number:</label>
                                <select class="form-control" id="user_id" name="user_id">
                                  <option value="1">จอที่ 1</option>
                                  <option value="2">จอที่ 2</option>
                                  <option value="3">จอที่ 3</option>
                                  <option value="4">จอที่ 4</option>
                                  <option value="5">จอที่ 5</option>
                                  <option value="6">จอที่ 6</option>
                                  <option value="7">จอที่ 7</option>
                                  <option value="8">จอที่ 8</option>
                                  <option value="9">จอที่ 9</option>
                                  <option value="10">จอที่ 10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add to Shop</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Form for adding/editing data -->
                    
                </div>
            </div>
        </div>

        <br>

        <!-- Table displaying data -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Product</th>
                    <th>Screen</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Stock</th>
                    <th>Already sold</th>
                    <th>Messenger To Line</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 require_once './show_table.php';
                ?>
            </tbody>
        </table>
    </div>
    <script>
    function showContent() {
    var password = prompt('Enter the password:');
    if (password === null) {
    // User clicked "Cancel" or pressed Esc, do nothing
    return;
    } else if (password === '123456') {
    // Password is correct, show the content
    document.getElementById('content').style.display = 'block';
     } else {
    // Password is incorrect, show a try again message
    alert('Incorrect password. Please try again.');
    showContent(); // Prompt again for password
  }
}

</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
