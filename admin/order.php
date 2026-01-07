<?php
include("include/header.php");
include("include/sidebar.php");
include("assets/config/db.php"); // make sure this file defines $con

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}


// Pagination setup
$limit = 10; // records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total records
$total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM orders");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated results
// $query = "
//     SELECT 
//         o.id AS order_id, 
//         o.name AS user_name, 
//         o.contact, 
//         o.email, 
//         o.paypal_order_id, 
//         c.title AS course_title, 
//         cd.start_date, 
//         cd.end_date, 
//         sp.name AS subscription_plan, 
//         sp.sale_price AS subscription_price, 
//         o.payment_status, 
//         o.created_at AS order_created
//     FROM orders o
//     LEFT JOIN courses c ON o.course_id = c.id
//     LEFT JOIN course_dates cd ON o.course_date_id = cd.id
//     LEFT JOIN subscription_plans sp ON o.subscription_plan_id = sp.id
//     ORDER BY o.created_at DESC
//     LIMIT $limit OFFSET $offset
// ";

// Fetch paginated results
$query = "
 SELECT 
        o.id AS order_id, 
        o.name AS user_name, 
        o.contact, 
        o.email, 
        o.paypal_order_id, 
        c.title AS course_title, 
        cd.start_date, 
        cd.end_date, 
        sp.name AS subscription_plan, 
         CASE 
    WHEN sp.sale_price = 0 OR sp.sale_price IS NULL 
    THEN c.sale_price
    ELSE sp.sale_price 
END AS subscription_price,
        o.payment_status, 
        o.created_at AS order_created
    FROM orders o
    LEFT JOIN courses c ON o.course_id = c.id
    LEFT JOIN course_dates cd ON o.course_date_id = cd.id
    LEFT JOIN subscription_plans sp ON o.subscription_plan_id = sp.id
    ORDER BY o.created_at DESC
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Orders List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    .table-container { background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; }
    th { background-color: #f1f1f1; }
    .pagination { justify-content: center; }
    .page-link { color: #0d6efd; }
    .page-item.active .page-link { background-color: #0d6efd; border-color: #0d6efd; color: #fff; }
</style>
</head>
<body>

<div class="container my-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Orders List</h2>
            <span class="text-muted">Total Orders: <?= htmlspecialchars($total_records) ?></span>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Transaction ID</th>
                        <th>Course</th>
                        <th>Course Start</th>
                        <th>Course End</th>
                        <th>Subscription Plan</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                <td><?= htmlspecialchars($order['contact']) ?></td>
                                <td><?= htmlspecialchars($order['email']) ?></td>
                                <td><?= htmlspecialchars($order['paypal_order_id']) ?></td>
                                <td><?= htmlspecialchars($order['course_title'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($order['start_date'] ? date('d M Y', strtotime($order['start_date'])) : 'N/A') ?></td>
                                <td><?= htmlspecialchars($order['end_date'] ? date('d M Y', strtotime($order['end_date'])) : 'N/A') ?></td>
                                <td><?= htmlspecialchars($order['subscription_plan'] ?? 'N/A') ?></td>
                                <td>£<?= htmlspecialchars(number_format($order['subscription_price'] ?? 0, 2)) ?></td>
                                <td>
                                    <?php if ($order['payment_status'] === 'completed'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php elseif ($order['payment_status'] === 'pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Unknown</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars(date('d M Y, h:i A', strtotime($order['order_created']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="11" class="text-center text-muted">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination mt-4">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

</body>
</html>
