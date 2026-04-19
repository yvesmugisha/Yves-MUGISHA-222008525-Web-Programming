<?php
$host = 'localhost';
$user = 'root';
$password = 'newpassword';
$dbName = 'student_registration';

$message = '';

$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die('Database creation failed: ' . $conn->error);
}

$conn->select_db($dbName);

$createTable = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    address TEXT,
    city VARCHAR(100),
    pincode VARCHAR(20),
    state VARCHAR(100),
    country VARCHAR(100),
    hobbies VARCHAR(255),
    other_hobby VARCHAR(255),
    class_x_board VARCHAR(100),
    class_x_percentage DECIMAL(5,2),
    class_x_year YEAR,
    class_xii_board VARCHAR(100),
    class_xii_percentage DECIMAL(5,2),
    class_xii_year YEAR,
    graduation_board VARCHAR(100),
    graduation_percentage DECIMAL(5,2),
    graduation_year YEAR,
    masters_board VARCHAR(100),
    masters_percentage DECIMAL(5,2),
    masters_year YEAR,
    course_applied VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($createTable)) {
    die('Table creation failed: ' . $conn->error);
}

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = sanitize($_POST['first_name'] ?? '');
    $lastName = sanitize($_POST['last_name'] ?? '');
    $day = intval($_POST['day'] ?? 0);
    $month = intval($_POST['month'] ?? 0);
    $year = intval($_POST['year'] ?? 0);
    $email = sanitize($_POST['email'] ?? '');
    $mobile = sanitize($_POST['mobile'] ?? '');
    $gender = sanitize($_POST['gender'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $city = sanitize($_POST['city'] ?? '');
    $pincode = sanitize($_POST['pincode'] ?? '');
    $state = sanitize($_POST['state'] ?? '');
    $country = sanitize($_POST['country'] ?? '');
    $hobbies = $_POST['hobbies'] ?? [];
    $otherHobby = sanitize($_POST['other_hobby'] ?? '');
    $course = sanitize($_POST['course'] ?? '');

    $qual = [
        'class_x' => [
            'board' => sanitize($_POST['class_x_board'] ?? ''),
            'percentage' => floatval($_POST['class_x_percentage'] ?? 0),
            'year' => intval($_POST['class_x_year'] ?? 0),
        ],
        'class_xii' => [
            'board' => sanitize($_POST['class_xii_board'] ?? ''),
            'percentage' => floatval($_POST['class_xii_percentage'] ?? 0),
            'year' => intval($_POST['class_xii_year'] ?? 0),
        ],
        'graduation' => [
            'board' => sanitize($_POST['graduation_board'] ?? ''),
            'percentage' => floatval($_POST['graduation_percentage'] ?? 0),
            'year' => intval($_POST['graduation_year'] ?? 0),
        ],
        'masters' => [
            'board' => sanitize($_POST['masters_board'] ?? ''),
            'percentage' => floatval($_POST['masters_percentage'] ?? 0),
            'year' => intval($_POST['masters_year'] ?? 0),
        ],
    ];

    $hobbyList = [];
    if (is_array($hobbies)) {
        foreach ($hobbies as $hobby) {
            $hobbyList[] = sanitize($hobby);
        }
    }
    $hobbyString = implode(', ', $hobbyList);

    if (empty($firstName) || empty($lastName) || empty($email) || empty($mobile) || empty($gender) || empty($day) || empty($month) || empty($year)) {
        $message = 'Please fill in all required fields.';
    } else {
        $dob = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, dob, email, mobile, gender, address, city, pincode, state, country, hobbies, other_hobby, class_x_board, class_x_percentage, class_x_year, class_xii_board, class_xii_percentage, class_xii_year, graduation_board, graduation_percentage, graduation_year, masters_board, masters_percentage, masters_year, course_applied) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('sssssssssssssdidsdidsdidsdisss', $firstName, $lastName, $dob, $email, $mobile, $gender, $address, $city, $pincode, $state, $country, $hobbyString, $otherHobby,
                $qual['class_x']['board'], $qual['class_x']['percentage'], $qual['class_x']['year'],
                $qual['class_xii']['board'], $qual['class_xii']['percentage'], $qual['class_xii']['year'],
                $qual['graduation']['board'], $qual['graduation']['percentage'], $qual['graduation']['year'],
                $qual['masters']['board'], $qual['masters']['percentage'], $qual['masters']['year'],
                $course
            );
            if ($stmt->execute()) {
                $message = 'Registration saved successfully.';
            } else {
                $message = 'Insert failed: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = 'Prepare failed: ' . $conn->error;
        }
    }
}

function selected($value, $expected) {
    return $value == $expected ? ' selected' : '';
}

function checked($name, $value) {
    return in_array($value, $name ?? []) ? ' checked' : '';
}

$posted = $_POST;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration Form</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        label { display: inline-block; width: 140px; vertical-align: top; margin-bottom: 10px; }
        input[type=text], select, textarea { width: 260px; padding: 6px; margin-bottom: 10px; }
        textarea { height: 80px; resize: vertical; }
        .row { margin-bottom: 10px; }
        .inline { display: inline-block; margin-right: 12px; }
        fieldset { padding: 15px; margin-bottom: 20px; border: 1px solid #999; }
        legend { font-weight: bold; }
        .small-input { width: 100px; }
        .form-actions { margin-top: 10px; }
        .message { margin-bottom: 20px; font-weight: bold; color: green; }
        .error { color: red; }
        table { border-collapse: collapse; width: 100%; max-width: 860px; }
        th, td { padding: 6px 8px; border: 1px solid #ccc; }
        th { text-align: left; background: #f4f4f4; }
        .qualification td input { width: 100%; box-sizing: border-box; }
    </style>
</head>
<body>
    <h1>Student Registration Form</h1>
    <?php if ($message): ?>
        <div class="message<?= strpos($message, 'failed') !== false ? ' error' : '' ?>"><?= $message ?></div>
    <?php endif; ?>
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="row">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?= sanitize($posted['first_name'] ?? '') ?>" required>
        </div>
        <div class="row">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= sanitize($posted['last_name'] ?? '') ?>" required>
        </div>
        <div class="row">
            <label>Date of Birth</label>
            <select name="day" required>
                <option value="">Day</option>
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?= $i ?>"<?= selected($posted['day'] ?? '', $i) ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <select name="month" required>
                <option value="">Month</option>
                <?php
                $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
                foreach ($months as $num => $label): ?>
                    <option value="<?= $num ?>"<?= selected($posted['month'] ?? '', $num) ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <select name="year" required>
                <option value="">Year</option>
                <?php for ($y = 1980; $y <= 2015; $y++): ?>
                    <option value="<?= $y ?>"<?= selected($posted['year'] ?? '', $y) ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="row">
            <label for="email">Email ID</label>
            <input type="text" name="email" id="email" value="<?= sanitize($posted['email'] ?? '') ?>" required>
        </div>
        <div class="row">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" id="mobile" value="<?= sanitize($posted['mobile'] ?? '') ?>" required>
        </div>
        <div class="row">
            <label>Gender</label>
            <label class="inline"><input type="radio" name="gender" value="Male"<?= isset($posted['gender']) && $posted['gender'] === 'Male' ? ' checked' : '' ?>> Male</label>
            <label class="inline"><input type="radio" name="gender" value="Female"<?= isset($posted['gender']) && $posted['gender'] === 'Female' ? ' checked' : '' ?>> Female</label>
        </div>
        <div class="row">
            <label for="address">Address</label>
            <textarea name="address" id="address"><?= sanitize($posted['address'] ?? '') ?></textarea>
        </div>
        <div class="row">
            <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= sanitize($posted['city'] ?? '') ?>">
        </div>
        <div class="row">
            <label for="pincode">Pin Code</label>
            <input type="text" name="pincode" id="pincode" value="<?= sanitize($posted['pincode'] ?? '') ?>">
        </div>
        <div class="row">
            <label for="state">State</label>
            <input type="text" name="state" id="state" value="<?= sanitize($posted['state'] ?? '') ?>">
        </div>
        <div class="row">
            <label for="country">Country</label>
            <select name="country" id="country">
                <?php
                $countries = ['India', 'United States', 'United Kingdom', 'Australia', 'Canada', 'Others'];
                foreach ($countries as $countryValue): ?>
                    <option value="<?= $countryValue ?>"<?= selected($posted['country'] ?? '', $countryValue) ?>><?= $countryValue ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <fieldset>
            <legend>Hobbies</legend>
            <?php $hobbyOptions = ['Drawing', 'Singing', 'Dancing', 'Sketching']; ?>
            <?php foreach ($hobbyOptions as $hobby): ?>
                <label class="inline"><input type="checkbox" name="hobbies[]" value="<?= $hobby ?>"<?= checked($posted['hobbies'] ?? [], $hobby) ?>> <?= $hobby ?></label>
            <?php endforeach; ?>
            <div class="row">
                <label for="other_hobby">Others</label>
                <input type="text" name="other_hobby" id="other_hobby" value="<?= sanitize($posted['other_hobby'] ?? '') ?>">
            </div>
        </fieldset>
        <fieldset>
            <legend>Qualification</legend>
            <table class="qualification">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Examination</th>
                        <th>Board</th>
                        <th>Percentage</th>
                        <th>Year of Passing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $qualRows = ['Class X' => 'class_x', 'Class XII' => 'class_xii', 'Graduation' => 'graduation', 'Masters' => 'masters']; ?>
                    <?php $index = 1; foreach ($qualRows as $label => $fieldPrefix): ?>
                        <tr>
                            <td><?= $index++ ?></td>
                            <td><?= $label ?></td>
                            <td><input type="text" name="<?= $fieldPrefix ?>_board" value="<?= sanitize($posted[$fieldPrefix . '_board'] ?? '') ?>" maxlength="100"></td>
                            <td><input type="text" name="<?= $fieldPrefix ?>_percentage" value="<?= sanitize($posted[$fieldPrefix . '_percentage'] ?? '') ?>" maxlength="6"></td>
                            <td><input type="text" name="<?= $fieldPrefix ?>_year" value="<?= sanitize($posted[$fieldPrefix . '_year'] ?? '') ?>" maxlength="4"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>
        <div class="row">
            <label>Courses Applied For</label>
            <?php $courses = ['BCA', 'B.Com', 'B.Sc', 'B.A']; ?>
            <?php foreach ($courses as $courseValue): ?>
                <label class="inline"><input type="radio" name="course" value="<?= $courseValue ?>"<?= isset($posted['course']) && $posted['course'] === $courseValue ? ' checked' : '' ?>> <?= $courseValue ?></label>
            <?php endforeach; ?>
        </div>
        <div class="form-actions">
            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </div>
    </form>
</body>
</html>
