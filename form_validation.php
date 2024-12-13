<?php
// Check first name
if (empty($_POST["first_name"])) {
    $is_valid = false;
    $first_name_Err = "First name is required.";
} else {
    $first_name = test_input($_POST["first_name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$first_name)) {
        $is_valid = false;
        $first_name_Err = "Only letters and white space allowed.";
    }
}

// Check last name
if (empty($_POST["last_name"])) {
    $is_valid = false;
    $last_name_Err = "Last name is required.";
} else {
    $last_name = test_input($_POST["last_name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$last_name)) {
        $is_valid = false;
        $last_name_Err = "Only letters and white space allowed.";
    }
}

// Check gender
if (empty($_POST["gender"])) {
    $is_valid = false;
    $gender_Err = "Gender is required.";
} else {
    $gender = test_input($_POST["gender"]);
}

// Check date of birth
if (empty($_POST["date_of_birth"])) {
    $is_valid = false;
    $date_of_birth_Err = "Date of birth is required.";
} else {
    $date_of_birth = test_input($_POST["date_of_birth"]);
}

// Check address
if (empty($_POST["address"])) {
    $is_valid = false;
    $address_Err = "Address is required.";
} else {
    $address = test_input($_POST["address"]);
}

// Check ZIP Code
if (empty($_POST["zipcode"])) {
    $is_valid = false;
    $zipcode_Err = "Zipcode is required.";
} else {
    $zipcode = test_input($_POST["zipcode"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$zipcode)) {
        $is_valid = false;
        $zipcode_Err = "Only numbers allowed.";
    }
}

// Check telephone number
if (empty($_POST["telephone_number"])) {
    $is_valid = false;
    $telephone_number_Err = "Telephone number is required.";
} else {
    $telephone_number = test_input($_POST["telephone_number"]);
}

// Check email
if (empty($_POST["email"])) {
    $is_valid = false;
    $email_Err = "Email is required";
} else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $is_valid = false;
        $email_Err = "Invalid email format.";
    }
}

// Check volunteer availibility
if (empty($_POST["volunteer_availability"])){
    $is_valid = false;
    $volunteer_availability_Err = "Volunteer must be available at least once.";
} else {
    $volunteer_availability = $_POST['volunteer_availability'];
}

// Check volunteer interests
if (empty($_POST['volunteer_interests']) && empty($_POST["other_interest"])){
    $is_valid = false;
    $volunteer_interests_Err = "Volunteer must pick at least one interest.";
} else {
    $volunteer_interests = $_POST['volunteer_interests'];
    if (!empty($_POST["other_interest"])) {
        $other_interest = test_input($_POST["other_interest"]);
        $volunteer_interests[] = $other_interest; // Add "other" interest to the interests array
    }
}

// Check assigned area
if (empty($_POST["assigned_area"])) {
    $is_valid = false;
    $assigned_area_Err = "Assigned area is required.";
} else {
    $assigned_area = test_input($_POST["assigned_area"]);
}

// Check registered supervisor
if (empty($_POST["registration_supervisor"])) {
    $is_valid = false;
    $registration_supervisor_Err = "Registration supervisor is required.";
} else {
    $registration_supervisor = test_input($_POST["registration_supervisor"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$registration_supervisor)) {
        $is_valid = false;
        $registration_supervisor_Err = "Only letters and white space allowed.";
    }
}

// Check notes
if (empty($_POST["notes"])) {
    $notes = "";
} else {
    $notes = test_input($_POST["notes"]);
}

?>