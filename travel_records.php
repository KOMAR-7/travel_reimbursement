<?php include ('includes/config.php'); ?>
<?php include ('includes/header.php'); ?>

<div class="container_tbl" style="padding: 20px;">
    <div class="table-wrapper">
        <div class="table-title">
            <h2>Travel Reimbursement Records</h2>
        </div>
        <table id="employeeTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Start Location</th>
                    <th>End Location</th>
                    <th>Start Photo</th>
                    <th>End Photo</th>
                    <!-- <th>Site Name</th> -->
                    <th>Vehicle Number</th>
                    <th>Vehicle Name</th>
                    <th>Date</th>
                    <th>Remark</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM travel_vehicle";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["travel_vehicle_id"] . "</td>";
                        echo "<td>" . $row["emp_id"] . "</td>";
                        echo "<td>" . $row["emp_name"] . "</td>";
                        echo "<td>" . $row["start_loc"] . "</td>";
                        echo "<td>" . $row["end_loc"] . "</td>";
                        echo "<td><img src='" . $row["start_photo"] . "' class='thumbnail' onclick='openModal(\"" . $row["start_photo"] . "\")'></td>";
                        echo "<td><img src='" . $row["end_photo"] . "' class='thumbnail' onclick='openModal(\"" . $row["end_photo"] . "\")'></td>";
                        // echo "<td>" . $row["site_name"] . "</td>";
                        echo "<td>" . $row["vehicle_number"] . "</td>";
                        echo "<td>" . $row["vehicle_name"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["remark"] . "</td>";
                        echo "<td><button onclick='handleAction(" . $row["travel_vehicle_id"] . ")'>Download Pdf</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No data found</td></tr>";
                }
                $conn->close();
                ?>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<?php include ('includes/footer.php'); ?>