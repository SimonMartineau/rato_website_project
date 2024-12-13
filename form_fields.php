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