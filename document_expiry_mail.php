<?php
require_once './../session.php';
require_once './../db.php';

/* ======================================================
   CRON LOCK — RUN ONLY ONCE PER DAY
====================================================== */
$conn = getDB();

$jobName = 'document_expiry_master_mail';
$todayDate = date('Y-m-d');

$check = $conn->prepare("
    SELECT last_run FROM cron_logs WHERE job_name = ?
");
$check->bind_param("s", $jobName);
$check->execute();
$result = $check->get_result()->fetch_assoc();
$check->close();

if ($result && date('Y-m-d', strtotime($result['last_run'])) === $todayDate) {
    return;
}

$upsert = $conn->prepare("
    INSERT INTO cron_logs (job_name, last_run)
    VALUES (?, NOW())
    ON DUPLICATE KEY UPDATE last_run = NOW()
");
$upsert->bind_param("s", $jobName);
$upsert->execute();
$upsert->close();

/* ======================================================
   PHPMailer
====================================================== */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/* ======================================================
   SETTINGS
====================================================== */
$today = new DateTime();

/* ======================================================
   FETCH USERS
====================================================== */
$sql = "
SELECT 
    id, name, email,

    sia_expirey,
    sia_mail_30, sia_mail_15, sia_mail_7,

    act_expirey, act_mail_sent,
    share_code_expirey, share_code_mail_sent

FROM users
WHERE email IS NOT NULL
";

$result = $conn->query($sql);

/* ======================================================
   LOOP USERS
====================================================== */
while ($user = $result->fetch_assoc()) {

    /* ===============================
       SIA → MULTI STAGE (TOLERANCE)
    =============================== */
    if (!empty($user['sia_expirey'])) {

        $siaExpiry = new DateTime($user['sia_expirey']);
        $siaDaysLeft = (int)$today->diff($siaExpiry)->format('%r%a');

        $siaStages = [
            30 => 'sia_mail_30',
            15 => 'sia_mail_15',
            7  => 'sia_mail_7'
        ];

        foreach ($siaStages as $days => $flagColumn) {

            if ($user[$flagColumn] == 1) continue;
            if ($siaDaysLeft > $days || $siaDaysLeft < ($days - 1)) continue;

            sendMail(
                $user['email'],
                $user['name'],
                'SIA Licence',
                $siaExpiry->format('d M Y'),
                $days
            );

            $update = $conn->prepare("
                UPDATE users SET {$flagColumn} = 1 WHERE id = ?
            ");
            $update->bind_param("i", $user['id']);
            $update->execute();
            $update->close();
        }
    }

    /* ===============================
       OTHER DOCS → ONE TIME (15 DAYS)
    =============================== */
    $otherDocs = [
        [
            'label' => 'ACT Document',
            'expiry' => $user['act_expirey'],
            'flag' => 'act_mail_sent'
        ],
        [
            'label' => 'Share Code Document',
            'expiry' => $user['share_code_expirey'],
            'flag' => 'share_code_mail_sent'
        ]
    ];

    foreach ($otherDocs as $doc) {

        if (empty($doc['expiry']) || $user[$doc['flag']] == 1) continue;

        $expiryDate = new DateTime($doc['expiry']);
        $daysLeft = (int)$today->diff($expiryDate)->format('%r%a');

        if ($daysLeft <= 15 && $daysLeft >= 14) {

            sendMail(
                $user['email'],
                $user['name'],
                $doc['label'],
                $expiryDate->format('d M Y'),
                15
            );

            $update = $conn->prepare("
                UPDATE users SET {$doc['flag']} = 1 WHERE id = ?
            ");
            $update->bind_param("i", $user['id']);
            $update->execute();
            $update->close();
        }
    }
}

$conn->close();

/* ======================================================
   EMAIL FUNCTION
====================================================== */
function sendMail($toEmail, $toName, $document, $expiryDate, $daysLeft)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'himanshuswami2810@gmail.com';
        $mail->Password = 'nhxl bqsl iefi iypd'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('himanshuswami2810@gmail.com', 'DD Associate');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = "⚠ {$document} Expiry Reminder – {$daysLeft} Days Left";

        $mail->Body = "
        <p>Dear <b>{$toName}</b>,</p>
        <p>Your <b>{$document}</b> will expire in <b>{$daysLeft} days</b>.</p>
        <p><b>Expiry Date:</b> {$expiryDate}</p>
        <p>Please renew it as soon as possible.</p>
        <br><p>Regards,<br><b>DD Associate</b></p>
        ";

        $mail->send();

    } catch (Exception $e) {
        error_log("Mail Error ({$document}): " . $mail->ErrorInfo);
    }
}
