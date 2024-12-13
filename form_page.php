<?php
include 'config.php';   // Database connection
include 'functions.php'; // Helper functions

// Initialize variables, error messages, etc.
$first_name = $last_name = $gender = $date_of_birth = $address = $zipcode = $telephone_number = $email = $registration_date = $assigned_area = $other_interest = $registration_supervisor = $notes = "";
$volunteer_availability = [];
$volunteer_interests = [];
$insert_success = false;
$registration_date = date("Y-m-d");
$points = 30;
$hours_worked = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // form processing logic here...
    $is_valid = true;

    include 'form_validation.php';

    // If all inputs are valid, insert into the database
    if ($is_valid) {
        include 'form_sql.php';
    }
}
$conn->close();

// Include the header for the page
include 'header.php';  
?>

<?php if ($insert_success): ?>
    <p style="color: green;">Data successfully inserted into the database!</p>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <!-- Include form fields -->
    <?php include 'form_fields.php'; ?>
</form>

<?php
// Include the footer to close the HTML structure
include 'footer.php';
?>
