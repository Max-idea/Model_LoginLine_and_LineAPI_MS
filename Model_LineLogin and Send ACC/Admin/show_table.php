<tbody>
    <?php
    require_once './connect_db.php';
    // Fetching data from the table
    $query = "SELECT * FROM `product_account`";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['ID']."</td>";
            echo "<td>".$row['Type']."</td>";
            echo "<td>".$row['Product']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['Username']."</td>";
            echo "<td>".$row['Password']."</td>";
            echo "<td>".$row['Stock']."</td>";
            echo "<td>".$row['Stock_Sell']."</td>";
            echo "<td>";
            if ($row['Send_status'] === null) {
                echo "ยังไม่ส่ง";
                } elseif ($row['Send_status'] === 0) {
                    echo "เกิดข้อผิดพลาด";
                    } elseif ($row['Send_status'] === 1) {
                        echo "ส่งสำเร็จ";
                        }
                        echo "</td>";
            echo "<td>";
            echo "<a href='delete.php?id=".$row['ID']."' class='btn btn-danger'>Del</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No data found</td></tr>";
    }

    $conn->close();
    ?>
</tbody>
