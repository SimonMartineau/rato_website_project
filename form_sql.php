<?php
// Insert volunteer data into Memebrs table
$stmt = $conn->prepare("INSERT INTO Members (first_name, last_name, gender, date_of_birth, address, zip_code, telephone_number, email, assigned_area, registration_supervisor, notes, registration_date) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind the parameters to the prepared statement
$stmt->bind_param("ssssssssssss", $first_name, $last_name, $gender, $date_of_birth, $address, $zipcode, $telephone_number, $email, $assigned_area, $registration_supervisor, $notes, $registration_date);

// Execute the prepared statement
if ($stmt->execute()) {
// Retrieve the ID of the inserted member
$member_id = $conn->insert_id;
} else {
echo "Error inserting member: " . $stmt->error;
$stmt->close();
return; // Stop all further execution if the insert fails
}
// Close the statement
$stmt->close();

// Insert availability into Member_Availability
foreach ($volunteer_availability as $availability){
list($weekday, $time_period) = explode('-', $availability);
// Prepare the query with placeholders for the user inputs
$stmt = $conn->prepare("INSERT INTO Member_Availability (member_id, weekday, time_period) 
VALUES (?, ?, ?)");

// Bind the parameters to the prepared statement
$stmt->bind_param("iss", $member_id, $weekday, $time_period);

// Execute the prepared statement
if ($stmt->execute()) {
// Successful insertion
} else {
echo "Error: " . $stmt->error;
$stmt->close();
return; // Stop all further execution if the insert fails
}

// Close the statement
$stmt->close();
}

// Insert interests into Member_Interests table
foreach ($volunteer_interests as $interest) {
$stmt = $conn->prepare("INSERT INTO Member_Interests (member_id, interest) VALUES (?, ?)");
$stmt->bind_param("is", $member_id, $interest);

if (!$stmt->execute()) {
echo "Error inserting interest: " . $stmt->error;
$stmt->close();
return; // Stop all further execution if the insert fails
}
$stmt->close();
}

// If the data was sent correctly, reset the form
$insert_success = true;
$first_name = $last_name = $gender = $date_of_birth = $address = $zipcode = $telephone_number = $email = $registration_date = $assigned_area = $other_interest = $registration_supervisor = $notes = "";
$volunteer_availability = [];
$volunteer_interests = [];
?>