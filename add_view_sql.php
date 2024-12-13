<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Give and Receive Form</title>
    </head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "association_database_v3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and set to empty values
$first_name = $last_name = $gender = $date_of_birth = $address = $zipcode = $telephone_number = $email = $registration_date = $assigned_area = $other_interest = $registration_supervisor = $notes = "";
$volunteer_availability = [];
$volunteer_interests = [];
$first_name_Err = $last_name_Err = $gender_Err= $date_of_birth_Err = $address_Err = $zipcode_Err = $telephone_number_Err = $email_Err = $assigned_area_Err = $registration_supervisor_Err = $volunteer_availability_Err = $volunteer_interests_Err = "";
$registration_date = date("Y-m-d");
$insert_success = false;
$points = 30;
$hours_worked = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_valid = true;
    // Check first name
    if (empty($_POST["first_name"])) {
        $is_valid = false;
        $first_name_Err = "First name is required.";
    }
    else {
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
    }
    else {
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
    } 
    else {
        $gender = test_input($_POST["gender"]);
    }

    // Check date of birth
    if (empty($_POST["date_of_birth"])) {
        $is_valid = false;
        $date_of_birth_Err = "Date of birth is required.";
    }
    else {
        $date_of_birth = test_input($_POST["date_of_birth"]);
    }

    // Check address
    if (empty($_POST["address"])) {
        $is_valid = false;
        $address_Err = "Address is required.";
    }
    else {
        $address = test_input($_POST["address"]);
    }

    // Check ZIP Code
    if (empty($_POST["zipcode"])) {
        $is_valid = false;
        $zipcode_Err = "Zipcode is required.";
    }
    else {
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
    }
    else {
        $telephone_number = test_input($_POST["telephone_number"]);
    }

    // Check email
    if (empty($_POST["email"])) {
        $is_valid = false;
        $email_Err = "Email is required";
    } 
    else {
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
    } 
    else {
        $notes = test_input($_POST["notes"]);
    }

    // If all inputs are valid, insert into the database
    if ($is_valid) {
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
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$conn->close();
?>

<h2>Give and Receive Form</h2>
<?php if ($insert_success): ?>
    <p style="color: green;">Data successfully inserted into the database!</p>

<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <!-- First name text input -->
    First Name: <input type="text" name="first_name" value="<?php echo $first_name;?>">
    <span class="error">* <?php echo $first_name_Err;?></span>
    <br><br>     

    <!-- Last name text input -->
    Last Name: <input type="text" name="last_name" value="<?php echo $last_name;?>">
    <span class="error">* <?php echo $last_name_Err;?></span>
    <br><br>

    <!-- Gender bubble check -->
    Gender:
    <input type="radio" name="gender"
    <?php if (isset($gender) && $gender=="female") echo "checked";?>
    value="female">Female
    <input type="radio" name="gender"
    <?php if (isset($gender) && $gender=="male") echo "checked";?>
    value="male">Male
    <input type="radio" name="gender"
    <?php if (isset($gender) && $gender=="other") echo "checked";?>
    value="other">Other
    <span class="error">* <?php echo $gender_Err;?></span>
    <br><br>

    <!-- Date of birth date input -->
    Date of Birth: <input type="date" name="date_of_birth" value="<?php echo $date_of_birth;?>">
    <span class="error">* <?php echo $date_of_birth_Err;?></span>
    <br><br>

    <!-- Address text input -->
    Address: <input type="text" name="address" value="<?php echo $address;?>">
    <span class="error">* <?php echo $address_Err;?></span>
    <br><br>

    <!-- ZIP code text input -->
    ZIP Code: <input type="text" name="zipcode" value="<?php echo $zipcode;?>">
    <span class="error">* <?php echo $zipcode_Err;?></span>
    <br><br>

    <!-- Telephone text input -->
    Telephone Number: <input type="text" name="telephone_number" value="<?php echo $telephone_number;?>">
    <span class="error">* <?php echo $telephone_number_Err;?></span>
    <br><br>

    <!-- Email text input -->
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $email_Err;?></span>
    <br><br>

    <!-- Availability Table -->
    <h3 style="display: inline;">Weekly Availability</h3>
    <span class="error">* <?php echo $volunteer_availability_Err;?></span>

    <table border="1">
        <tr>
            <th>Day</th>
            <th>Morning</th>
            <th>Afternoon</th>
            <th>Evening</th>
        </tr>
        <?php
        
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $time_periods = ["Morning", "Afternoon", "Evening"];
        foreach ($days as $day) {
            echo "<tr>";
            echo "<td>$day</td>";
            foreach ($time_periods as $time_period){
                $available_moment = "{$day}-{$time_period}";
                if (in_array($available_moment, $volunteer_availability)){
                    echo "<td><input type='checkbox' name='volunteer_availability[]' value=$available_moment checked></td>";
                } else {
                    echo "<td><input type='checkbox' name='volunteer_availability[]' value=$available_moment></td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </table>
    <br>

    <!-- Volunteer's Interests Table -->
    <h3 style="display: inline;">Volunteer's Interests</h3> 
    <span class="error">* <?php echo $volunteer_interests_Err;?></span>

    <table border="1">
        <tr>
            <th>Activity</th>
            <th>Check</th>
        </tr>
        <?php
        $activities = [
            "Organization of community events", 
            "Library support", 
            "Help in the community store", 
            "Support in the community grocery store", 
            "Cleaning and maintenance of public spaces", 
            "Participation in urban gardening projects"
        ];
        foreach ($activities as $activity) {
            echo "<tr>";
            echo "<td>$activity</td>";
            if (in_array($activity, $volunteer_interests)){
                echo "<td><input type='checkbox' name='volunteer_interests[]' value='$activity' checked></td>";
            } else {
                echo "<td><input type='checkbox' name='volunteer_interests[]' value='$activity'></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

    <!-- "Others" text input -->
    Other Interest: <input type="text" name="other_interest" value="<?php echo $other_interest;?>">
    <br><br>

    <!-- Assigned area dropdown -->
    Assigned Area: 
    <select name="assigned_area">
        <option value="">Select an area</option>
        <option value="Area 1" <?php if ($assigned_area == "Area 1") echo "selected"; ?>>Area 1</option>
        <option value="Area 2" <?php if ($assigned_area == "Area 2") echo "selected"; ?>>Area 2</option>
        <option value="Area 3" <?php if ($assigned_area == "Area 3") echo "selected"; ?>>Area 3</option>
        <option value="Area 4" <?php if ($assigned_area == "Area 4") echo "selected"; ?>>Area 4</option>
    </select>    
    <span class="error">* <?php echo $assigned_area_Err;?></span>
    <br><br>

    <!-- Registration Supervisor text input -->
    Registration Supervisor: <input type="text" name="registration_supervisor" value="<?php echo $registration_supervisor;?>">
    <span class="error">* <?php echo $registration_supervisor_Err;?></span>
    <br><br>

    <!-- Additional notes text input -->
    Notes:
    <br>
    <textarea name="notes" rows="5" cols="40"><?php echo $notes;?></textarea>
    <br><br>

  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>