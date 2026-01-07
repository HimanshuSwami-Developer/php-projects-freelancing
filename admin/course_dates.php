<?php
include("include/header.php");
include("include/sidebar.php");
include("assets/config/db.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}

$msg = "";

// --- Helper: Generate all dates between start and end ---
function getDatesBetween($start_date, $end_date) {
    $dates = [];
    $current = strtotime($start_date);
    $end = strtotime($end_date);
    while ($current <= $end) {
        $dates[] = date('Y-m-d', $current);
        $current = strtotime("+1 day", $current);
    }
    return $dates;
}

// Fetch all courses for dropdown
$all_courses = mysqli_query($con, "SELECT id, title FROM courses ORDER BY title ASC");

// Check if we are editing a course date
$edit_mode = false;
$edit_data = [];

if(isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])){
    $edit_mode = true;
    $edit_id = intval($_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM course_dates WHERE id=$edit_id");
    if(mysqli_num_rows($res) > 0){
        $edit_data = mysqli_fetch_assoc($res);
    } else {
        $msg = "Course date not found!";
        $edit_mode = false;
    }
}

// Handle Add/Edit submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $seats_left_text = mysqli_real_escape_string($con, $_POST['seats_left_text']);
    $selected_dates = isset($_POST['selected_dates']) ? json_encode($_POST['selected_dates']) : null;

    if(isset($_POST['edit_id']) && is_numeric($_POST['edit_id'])){
        $edit_id = intval($_POST['edit_id']);
        $sql = "UPDATE course_dates SET 
                    course_id='$course_id', 
                    start_date='$start_date', 
                    end_date='$end_date', 
                    selected_dates='$selected_dates',
                    price='$price', 
                    seats_left_text='$seats_left_text',
                    status='$status' 
                WHERE id=$edit_id";
        if(mysqli_query($con, $sql)){
            $msg = "Course date updated successfully!";
        } else {
            $msg = "Error: ".mysqli_error($con);
        }
    } else {
        $sql = "INSERT INTO course_dates (course_id, start_date, end_date, selected_dates, price, seats_left_text, status) 
                VALUES ('$course_id','$start_date','$end_date','$selected_dates','$price','$seats_left_text','$status')";
        if(mysqli_query($con, $sql)){
            $msg = "Course date added successfully!";
        } else {
            $msg = "Error: ".mysqli_error($con);
        }
    }
}

// Handle delete
if(isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])){
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($con, "DELETE FROM course_dates WHERE id=$delete_id");
    $msg = "Course date deleted successfully!";
}

// Fetch all course dates with course title
$dates = mysqli_query($con,"SELECT cd.*, c.title AS course_title 
                            FROM course_dates cd 
                            LEFT JOIN courses c ON cd.course_id = c.id 
                            ORDER BY cd.id DESC");
?>

<main class="dashboard-gssecurity-main" style="padding:20px;">
    <div class="dashboard-gssecurity-title" style="font-size:28px; margin-bottom:20px;">
        <?php echo $edit_mode ? "Edit Course Date" : "Add Course Date"; ?>
    </div>

    <?php if($msg){ echo "<p style='color:green;font-weight:bold; margin-bottom:15px;'>$msg</p>"; } ?>

    <!-- Add/Edit Form -->
    <div style="background:#fff; padding:25px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); max-width:650px; margin-bottom:40px;">
        <form action="" method="POST" style="display:grid; grid-gap:15px;">
            <label style="font-weight:bold;">Select Course</label>
            <select name="course_id" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">
                <option value="">-- Select Course --</option>
                <?php while($course = mysqli_fetch_assoc($all_courses)) { ?>
                    <option value="<?php echo $course['id']; ?>" 
                        <?php if($edit_mode && $edit_data['course_id'] == $course['id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($course['title']); ?>
                    </option>
                <?php } ?>
            </select>

            <label style="font-weight:bold;">Start Date</label>
            <input type="text" id="start_date" name="start_date" value="<?php echo $edit_mode ? $edit_data['start_date'] : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">End Date</label>
            <input type="text" id="end_date" name="end_date" value="<?php echo $edit_mode ? $edit_data['end_date'] : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <!-- Selected Dates Checkbox List -->
            <div id="date-checkboxes" style="margin-top:15px;">
                <!-- Checkboxes will be inserted dynamically -->
            </div>

            <label style="font-weight:bold;">Price (£)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $edit_mode ? $edit_data['price'] : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">Seats Left Text</label>
            <input type="text" name="seats_left_text" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['seats_left_text']) : ''; ?>" placeholder="e.g. 5 seats left or Fully booked" style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">Status</label>
            <select name="status" style="padding:8px; border-radius:5px; border:1px solid #ccc;">
                <option value="open" <?php echo $edit_mode && $edit_data['status']=='open'?'selected':''; ?>>Open</option>
                <option value="closed" <?php echo $edit_mode && $edit_data['status']=='closed'?'selected':''; ?>>Closed</option>
            </select>

            <?php if($edit_mode){ ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_data['id']; ?>">
            <?php } ?>

            <button type="submit" style="background:#007BFF; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
                <?php echo $edit_mode ? "Update Date" : "Add Date"; ?>
            </button>
        </form>
    </div>

    <!-- Course Dates Table -->
    <div class="dashboard-gssecurity-title" style="font-size:28px; margin-bottom:15px;">All Course Dates</div>
    <table style="width:100%; border-collapse:collapse; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background:#007BFF; color:#fff; text-align:left;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Course Title</th>
                <th style="padding:12px;">Start Date</th>
                <th style="padding:12px;">End Date</th>
                <th style="padding:12px;">Selected Dates</th>
                <th style="padding:12px;">Price (£)</th>
                <th style="padding:12px;">Seats Left</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($dates)>0): ?>
            <?php while($row=mysqli_fetch_assoc($dates)){ ?>
                <tr style="border-bottom:1px solid #ccc; transition:background 0.3s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                    <td style="padding:10px;"><?php echo $row['id']; ?></td>
                    <td style="padding:10px;"><?php echo htmlspecialchars($row['course_title']); ?></td>
                    <td style="padding:10px;"><?php echo $row['start_date']; ?></td>
                    <td style="padding:10px;"><?php echo $row['end_date']; ?></td>
                    <td style="padding:10px;">
                        <?php
                            if (!empty($row['selected_dates'])) {
                                $selected = json_decode($row['selected_dates'], true);
                                $allDates = getDatesBetween($row['start_date'], $row['end_date']);
                                $start = date('d D, M', strtotime($row['start_date']));
                                $end = date('d D, M', strtotime($row['end_date']));

                                if ($row['start_date'] == $row['end_date']) {
                                    echo "$start";
                                } elseif (count($selected) == count($allDates)) {
                                    echo "$start - $end";
                                } else {
                                    echo "$start - $end<br><small>";
                                    $displayDates = [];
                                    foreach ($selected as $d) {
                                        $displayDates[] = date('d D', strtotime($d));
                                    }
                                    echo implode(" - ", $displayDates) . "</small>";
                                }
                            } else {
                                echo "-";
                            }
                        ?>
                    </td>
                    <td style="padding:10px;"><?php echo $row['price']; ?></td>
                    <td style="padding:10px; 
                        <?php 
                            if (stripos($row['seats_left_text'], 'full') !== false) echo 'color:red;font-weight:bold;';
                            elseif (stripos($row['seats_left_text'], 'limited') !== false) echo 'color:orange;font-weight:bold;';
                        ?>">
                        <?php echo htmlspecialchars($row['seats_left_text']); ?>
                    </td>
                    <td style="padding:10px;"><?php echo $row['status']; ?></td>
                    <td style="padding:10px;">
                        <a href="?edit_id=<?php echo $row['id']; ?>" style="padding:5px 10px; background:orange;color:#fff;border-radius:5px;text-decoration:none; margin-right:5px;">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" style="padding:5px 10px; background:red;color:#fff;border-radius:5px;text-decoration:none;" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="9" style="text-align:center; padding:15px;">No course dates found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Flatpickr -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr("#start_date", { dateFormat: "Y-m-d" });
flatpickr("#end_date", { dateFormat: "Y-m-d" });

function generateDateCheckboxes(start, end, preselected=[]) {
    const container = document.getElementById("date-checkboxes");
    container.innerHTML = "";

    if (!start || !end) return;

    let startDate = new Date(start);
    let endDate = new Date(end);
    if (startDate > endDate) return;

    const options = { weekday: 'short', day: '2-digit', month: 'short' };

    while (startDate <= endDate) {
        let formatted = startDate.toISOString().split("T")[0];
        let label = startDate.toLocaleDateString('en-US', options);
        let checked = preselected.includes(formatted) ? "checked" : "checked"; // Default all selected
        container.innerHTML += `
            <label style="margin-right:10px;">
                <input type="checkbox" name="selected_dates[]" value="${formatted}" ${checked}> ${label}
            </label>`;
        startDate.setDate(startDate.getDate() + 1);
    }
}

// Watch date inputs
document.getElementById("start_date").addEventListener("change", updateCheckboxes);
document.getElementById("end_date").addEventListener("change", updateCheckboxes);

function updateCheckboxes() {
    const start = document.getElementById("start_date").value;
    const end = document.getElementById("end_date").value;
    generateDateCheckboxes(start, end);
}

// Preload checkboxes in edit mode
<?php if($edit_mode && !empty($edit_data['selected_dates'])): ?>
    document.addEventListener("DOMContentLoaded", () => {
        const preselected = <?php echo $edit_data['selected_dates']; ?>;
        generateDateCheckboxes("<?php echo $edit_data['start_date']; ?>", "<?php echo $edit_data['end_date']; ?>", preselected);
    });
<?php endif; ?>
</script>
