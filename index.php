<?php include('includes/config.php'); ?>
<?php include('includes/header.php'); ?>

<!-- Form start -->
<form method="post" enctype="multipart/form-data">

    <div class="segment">
        <h1>Sign up</h1>
    </div>

    <label>
        <label>EmpID:</label>
        <input type="text" name="emp_id" placeholder="Enter your EmpID" required />
    </label>

    <label>
        <label>Name:</label>
        <input type="text" name="emp_name" placeholder="Enter your name" required />
    </label>

    <label>
        <label>Start Location Name:</label>
        <input type="text" name="start_loc" placeholder="Enter start location name" required />
    </label>

    <label>
        <label>End Location Name:</label>
        <input type="text" name="end_loc" placeholder="Enter end location name" required />
    </label>

    <label>
        <label>Start Photo:</label>
        <input type="file" name="start_photo" required />
    </label>

    <label>
        <label>End Photo:</label>
        <input type="file" name="end_photo" required />
    </label>

    <label>
        <label>Vehicle Number:</label>
        <input type="text" name="vehicle_number" placeholder="Enter Vehicle Number" required />
    </label>

    <label>
        <label>Vehicle Name:</label>
        <input type="text" name="vehicle_name" placeholder="Enter Vehicle Name" required />
    </label>

    <label>
        <label>Remark:</label>
        <textarea name="remark" placeholder="Enter Remark if any..."></textarea>
    </label>

    <button class="red" type="submit"><i class="icon ion-md-lock"></i> Submit</button>
</form>
<!-- Form end -->

<?php include('includes/footer.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/config.php');

    $emp_id = $_POST['emp_id'];
    $emp_name = $_POST['emp_name'];
    $start_loc = $_POST['start_loc'];
    $end_loc = $_POST['end_loc'];
    $vehicle_number = $_POST['vehicle_number'];
    $vehicle_name = $_POST['vehicle_name'];
    $remark = $_POST['remark'];

    // Handle file uploads
    $start_photo = $_FILES['start_photo'];
    $end_photo = $_FILES['end_photo'];

    // Function to check if a file is an image
    function isImage($file) {
        $check = getimagesize($file['tmp_name']);
        return $check !== false;
    }

    if (isImage($start_photo) && isImage($end_photo)) {
        // Get new travel_vehicle_id
        $result = $conn->query("SELECT MAX(travel_vehicle_id) AS max_id FROM travel_vehicle");
        $row = $result->fetch_assoc();
        $new_id = $row['max_id'] + 1;

        // Define upload paths
        $start_photo_path = "static/images/{$new_id}_start." . pathinfo($start_photo['name'], PATHINFO_EXTENSION);
        $end_photo_path = "static/images/{$new_id}_end." . pathinfo($end_photo['name'], PATHINFO_EXTENSION);

        // Move uploaded files
        if (move_uploaded_file($start_photo['tmp_name'], $start_photo_path) && move_uploaded_file($end_photo['tmp_name'], $end_photo_path)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO travel_vehicle (emp_id, emp_name, start_loc, end_loc, start_photo, end_photo, vehicle_number, vehicle_name, date, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("sssssssss", $emp_id, $emp_name, $start_loc, $end_loc, $start_photo_path, $end_photo_path, $vehicle_number, $vehicle_name, $remark);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to upload files.";
        }
    } else {
        echo "Please upload valid image files.";
    }

    $conn->close();
}
?>


