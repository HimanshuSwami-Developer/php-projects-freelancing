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
$edit_mode = false;
$edit_data = [];

// --- Edit Mode ---
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = intval($_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM subscription_plans WHERE id=$edit_id");
    if (mysqli_num_rows($res) > 0) {
        $edit_data = mysqli_fetch_assoc($res);
        $course_id=$edit_data['course_id'];

        // Fetch headings and their features
        $headings_res = mysqli_query($con, "SELECT * FROM plan_feature_headings WHERE plan_id=$edit_id ORDER BY sort_order ASC");
        $headings = [];
        while ($heading = mysqli_fetch_assoc($headings_res)) {
            $features_res = mysqli_query($con, "SELECT * FROM plan_features WHERE heading_id={$heading['id']} ORDER BY sort_order ASC");
            $features = [];
            while ($f = mysqli_fetch_assoc($features_res)) {
                $features[] = [
                    'feature_text' => $f['feature_text'],
                    'is_included' => (bool)$f['is_included']
                ];
            }
            $heading['features'] = $features;
            $headings[] = $heading;
        }
        $edit_data['headings'] = $headings;
    } else {
        $msg = "Subscription plan not found!";
        $edit_mode = false;
    }
}

// --- Handle Add/Edit Form ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    $plan_key = mysqli_real_escape_string($con, $_POST['plan_key']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
    $original_price = mysqli_real_escape_string($con, $_POST['original_price']);
    $sale_price = mysqli_real_escape_string($con, $_POST['sale_price']);
    $payment_note = mysqli_real_escape_string($con, $_POST['payment_note']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (isset($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {
        $edit_id = intval($_POST['edit_id']);
        $check_sql = "SELECT id FROM subscription_plans WHERE plan_key='$plan_key' AND course_id='$course_id' AND id!=$edit_id";
        $check_result = mysqli_query($con, $check_sql);
        if (mysqli_num_rows($check_result) > 0) {
            $msg = "Error: Plan key already exists!";
        } else {
            $sql = "UPDATE subscription_plans SET 
                        plan_key='$plan_key',
                        name='$name',
                        subtitle='$subtitle',
                        original_price='$original_price',
                        sale_price='$sale_price',
                        payment_note='$payment_note',
                        is_active='$status'
                    WHERE id=$edit_id";
            if (mysqli_query($con, $sql)) {
                // Remove existing headings + features
                $head_ids = mysqli_query($con, "SELECT id FROM plan_feature_headings WHERE plan_id=$edit_id");
                while ($h = mysqli_fetch_assoc($head_ids)) {
                    mysqli_query($con, "DELETE FROM plan_features WHERE heading_id={$h['id']}");
                }
                mysqli_query($con, "DELETE FROM plan_feature_headings WHERE plan_id=$edit_id");

                // Re-insert headings + features
                if (isset($_POST['heading_text'])) {
                    $h_order = 0;
                    foreach ($_POST['heading_text'] as $h_index => $heading_text) {
                        $heading_text = mysqli_real_escape_string($con, $heading_text);
                        if (trim($heading_text) == "") continue;

                        mysqli_query($con, "INSERT INTO plan_feature_headings (plan_id, heading_text, sort_order)
                                            VALUES ($edit_id, '$heading_text', $h_order)");
                        $heading_id = mysqli_insert_id($con);

                        if (isset($_POST['feature_text'][$h_index])) {
                            $f_order = 0;
                            foreach ($_POST['feature_text'][$h_index] as $f_index => $f_text) {
                                $f_text = mysqli_real_escape_string($con, $f_text);
                                $included = isset($_POST['feature_included'][$h_index][$f_index]) ? 1 : 0;
                                if (trim($f_text) != "") {
                                    mysqli_query($con, "INSERT INTO plan_features (heading_id, feature_text, is_included, sort_order)
                                                        VALUES ($heading_id, '$f_text', $included, $f_order)");
                                    $f_order++;
                                }
                            }
                        }
                        $h_order++;
                    }
                }
                $msg = "Subscription plan updated successfully!";
            } else {
                $msg = "Error: " . mysqli_error($con);
            }
        }
    } else {
        // Add new plan
        $check_sql = "SELECT id FROM subscription_plans WHERE plan_key='$plan_key' and course_id='$course_id'";
        $check_result = mysqli_query($con, $check_sql);
        if (mysqli_num_rows($check_result) > 0) {
            $msg = "Error: Plan key already exists!";
        } else {
            $sql = "INSERT INTO subscription_plans (plan_key, name, subtitle, original_price, sale_price, payment_note, is_active)
                    VALUES ('$plan_key','$name','$subtitle','$original_price','$sale_price','$payment_note','$status')";
            if (mysqli_query($con, $sql)) {
                $plan_id = mysqli_insert_id($con);

                // Insert headings + features
                if (isset($_POST['heading_text'])) {
                    $h_order = 0;
                    foreach ($_POST['heading_text'] as $h_index => $heading_text) {
                        $heading_text = mysqli_real_escape_string($con, $heading_text);
                        if (trim($heading_text) == "") continue;

                        mysqli_query($con, "INSERT INTO plan_feature_headings (plan_id, heading_text, sort_order)
                                            VALUES ($plan_id, '$heading_text', $h_order)");
                        $heading_id = mysqli_insert_id($con);

                        if (isset($_POST['feature_text'][$h_index])) {
                            $f_order = 0;
                            foreach ($_POST['feature_text'][$h_index] as $f_index => $f_text) {
                                $f_text = mysqli_real_escape_string($con, $f_text);
                                $included = isset($_POST['feature_included'][$h_index][$f_index]) ? 1 : 0;
                                if (trim($f_text) != "") {
                                    mysqli_query($con, "INSERT INTO plan_features (heading_id, feature_text, is_included, sort_order)
                                                        VALUES ($heading_id, '$f_text', $included, $f_order)");
                                    $f_order++;
                                }
                            }
                        }
                        $h_order++;
                    }
                }
                $msg = "Subscription plan added successfully!";
            } else {
                $msg = "Error: " . mysqli_error($con);
            }
        }
    }
}

// --- Delete Plan ---
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $head_ids = mysqli_query($con, "SELECT id FROM plan_feature_headings WHERE plan_id=$delete_id");
    while ($h = mysqli_fetch_assoc($head_ids)) {
        mysqli_query($con, "DELETE FROM plan_features WHERE heading_id={$h['id']}");
    }
    mysqli_query($con, "DELETE FROM plan_feature_headings WHERE plan_id=$delete_id");
    mysqli_query($con, "DELETE FROM subscription_plans WHERE id=$delete_id");
    $msg = "Subscription plan deleted successfully!";
}

// --- Toggle Status ---
if (isset($_GET['toggle_id']) && is_numeric($_GET['toggle_id'])) {
    $toggle_id = intval($_GET['toggle_id']);
    $current_status = mysqli_fetch_assoc(mysqli_query($con, "SELECT is_active FROM subscription_plans WHERE id=$toggle_id"));
    $new_status = $current_status['is_active'] ? 0 : 1;
    mysqli_query($con, "UPDATE subscription_plans SET is_active=$new_status WHERE id=$toggle_id");
    $msg = "Plan status updated successfully!";
}

// --- Fetch All Plans ---
$plans = mysqli_query($con, "
    SELECT sp.*, 
        (SELECT COUNT(*) FROM plan_feature_headings h
            JOIN plan_features f ON h.id=f.heading_id WHERE h.plan_id=sp.id) as feature_count
    FROM subscription_plans sp ORDER BY sp.id DESC
");
?>

<main class="dashboard-gssecurity-main" style="padding:20px;">
    <div style="font-size:28px; margin-bottom:20px;">
        <?php echo $edit_mode ? "Edit Subscription Plan" : "Add Subscription Plan"; ?>
    </div>

    <?php if ($msg) echo "<p style='color:green;font-weight:bold; margin-bottom:15px;'>$msg</p>"; ?>

    <div style="background:#fff; padding:25px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); max-width:900px; margin-bottom:40px;">
        <form method="POST" style="display:grid; gap:15px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label>Course ID *</label>
                    <input type="text" name="course_id" value="<?php echo $edit_mode ? $edit_data['course_id'] : ''; ?>" required style="width:100%;padding:8px;">
                </div>
                <div>
                    <label>Plan Key *</label>
                    <input type="text" name="plan_key" value="<?php echo $edit_mode ? $edit_data['plan_key'] : ''; ?>" required style="width:100%;padding:8px;">
                </div>
                <div>
                    <label>Plan Name *</label>
                    <input type="text" name="name" value="<?php echo $edit_mode ? $edit_data['name'] : ''; ?>" required style="width:100%;padding:8px;">
                </div>
            </div>

            <label>Subtitle</label>
            <input type="text" name="subtitle" value="<?php echo $edit_mode ? $edit_data['subtitle'] : ''; ?>" style="padding:8px;">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div><label>Original Price (£)</label><input type="number" step="0.01" name="original_price" value="<?php echo $edit_mode ? $edit_data['original_price'] : ''; ?>" style="width:100%;padding:8px;"></div>
                <div><label>Sale Price (£)</label><input type="number" step="0.01" name="sale_price" value="<?php echo $edit_mode ? $edit_data['sale_price'] : ''; ?>" style="width:100%;padding:8px;"></div>
            </div>

            <label>Payment Note</label>
            <input type="text" name="payment_note" value="<?php echo $edit_mode ? $edit_data['payment_note'] : ''; ?>" style="padding:8px;">

            <div><input type="checkbox" name="status" <?php echo ($edit_mode && !$edit_data['is_active']) ? '' : 'checked'; ?>> Active Plan</div>

            <div id="headings-container" style="border:1px solid #ddd; padding:15px; border-radius:5px;">
    <label style="font-weight:bold;">Headings & Features</label>

    <?php if ($edit_mode && !empty($edit_data['headings'])): ?>
        <?php foreach ($edit_data['headings'] as $h_index => $heading): ?>
            <div class="heading-block" style="margin-top:10px;border:1px solid #ccc;padding:10px;border-radius:5px;">
                <input type="text" name="heading_text[]" value="<?php echo htmlspecialchars($heading['heading_text']); ?>" placeholder="Heading title" style="width:100%;padding:8px;">

                <div class="features-container" style="margin-top:10px;">
                    <?php if (!empty($heading['features'])): ?>
                        <?php foreach ($heading['features'] as $f_index => $feature): ?>
                            <div class="feature-item" style="display:flex;align-items:center;gap:10px;margin-bottom:5px;">
                                <input type="text" 
                                       name="feature_text[<?php echo $h_index; ?>][]" 
                                       value="<?php echo htmlspecialchars($feature['feature_text']); ?>" 
                                       placeholder="Feature description" 
                                       style="flex:1;padding:8px;">
                                <label>
                                    <input type="checkbox" 
                                           name="feature_included[<?php echo $h_index; ?>][<?php echo $f_index; ?>]" 
                                           <?php echo $feature['is_included'] ? 'checked' : ''; ?>> Included
                                </label>
                                <button type="button" class="remove-feature" style="background:red;color:#fff;padding:5px;">X</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button type="button" class="add-feature" style="background:#28a745;color:#fff;padding:5px;">+ Add Feature</button>
                <button type="button" class="remove-heading" style="background:#dc3545;color:#fff;padding:5px;">Remove Heading</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


            <button type="button" id="add-heading" style="background:#007bff;color:#fff;padding:8px;">+ Add Heading</button>

            <?php if ($edit_mode) echo '<input type="hidden" name="edit_id" value="'.$edit_data['id'].'">'; ?>

            <button type="submit" style="background:#007bff;color:#fff;padding:10px;font-weight:bold;">
                <?php echo $edit_mode ? 'Update Plan' : 'Add Plan'; ?>
            </button>
        </form>
    </div>

    <table style="width:100%;border-collapse:collapse;">
        <thead><tr style="background:#007bff;color:white;"><th>ID</th><th>Plan</th><th>Prices</th><th>Features</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($plans)) { ?>
            <tr style="border-bottom:1px solid #ccc;">
                <td><?php echo $row['id']; ?></td>
                <td><b><?php echo htmlspecialchars($row['name']); ?></b><br><small><?php echo htmlspecialchars($row['plan_key']); ?></small></td>
                <td>£<?php echo $row['sale_price']; ?> <del>£<?php echo $row['original_price']; ?></del></td>
                <td><?php echo $row['feature_count']; ?> features</td>
                <td><?php echo $row['is_active'] ? '<span style="color:green">Active</span>' : '<span style="color:red">Inactive</span>'; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['id']; ?>" style="background:orange;color:white;padding:5px;">Edit</a>
                    <a href="?toggle_id=<?php echo $row['id']; ?>" style="background:#17a2b8;color:white;padding:5px;">Toggle</a>
                    <a href="?delete_id=<?php echo $row['id']; ?>" style="background:red;color:white;padding:5px;" onclick="return confirm('Delete this plan?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const headingsContainer = document.getElementById('headings-container');
    const addHeadingBtn = document.getElementById('add-heading');

    // Add new heading
    addHeadingBtn.addEventListener('click', () => {
        const index = headingsContainer.querySelectorAll('.heading-block').length;
        const headingBlock = document.createElement('div');
        headingBlock.className = 'heading-block';
        headingBlock.style.cssText = 'margin-top:10px;border:1px solid #ccc;padding:10px;border-radius:5px;';
        headingBlock.innerHTML = `
            <input type="text" name="heading_text[]" placeholder="Heading title" style="width:100%;padding:8px;">
            <div class="features-container" style="margin-top:10px;">
                <div class="feature-item" style="display:flex;align-items:center;gap:10px;margin-bottom:5px;">
                    <input type="text" name="feature_text[${index}][]" placeholder="Feature description" style="flex:1;padding:8px;">
                    <label><input type="checkbox" name="feature_included[${index}][0]" checked> Included</label>
                    <button type="button" class="remove-feature" style="background:red;color:#fff;padding:5px;">X</button>
                </div>
            </div>
            <button type="button" class="add-feature" style="background:#28a745;color:#fff;padding:5px;">+ Add Feature</button>
            <button type="button" class="remove-heading" style="background:#dc3545;color:#fff;padding:5px;">Remove Heading</button>
        `;
        headingsContainer.appendChild(headingBlock);
    });

    // Delegate remove/add buttons
    headingsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-heading')) {
            e.target.closest('.heading-block').remove();
        }
        if (e.target.classList.contains('remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
        if (e.target.classList.contains('add-feature')) {
            const headingBlock = e.target.closest('.heading-block');
            const featuresContainer = headingBlock.querySelector('.features-container');
            const headingIndex = Array.from(headingsContainer.querySelectorAll('.heading-block')).indexOf(headingBlock);
            const featureIndex = featuresContainer.querySelectorAll('.feature-item').length;
            const newFeature = document.createElement('div');
            newFeature.className = 'feature-item';
            newFeature.style.cssText = 'display:flex;align-items:center;gap:10px;margin-bottom:5px;';
            newFeature.innerHTML = `
                <input type="text" name="feature_text[${headingIndex}][]" placeholder="Feature description" style="flex:1;padding:8px;">
                <label><input type="checkbox" name="feature_included[${headingIndex}][${featureIndex}]" checked> Included</label>
                <button type="button" class="remove-feature" style="background:red;color:#fff;padding:5px;">X</button>
            `;
            featuresContainer.appendChild(newFeature);
        }
    });
});
</script>
