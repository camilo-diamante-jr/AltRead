<?php


$redirectUrl = '/login';

// Check if the user is logged in and determine the redirect URL
if (isset($_SESSION['user_type'])) {
    $userType = $_SESSION['user_type'];

    // Redirect based on user type
    switch ($userType) {
        case 'Admin':
            $redirectUrl = '/admin'; // Admin-specific page
            break;
        case 'Teacher':
            $redirectUrl = '/teacher/dashboard'; // Teacher-specific page
            break;
        case 'Learner':
            $redirectUrl = '/dashboard'; // Learner-specific page
            break;
        default:
            $redirectUrl = '/login'; // Default homepage
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - Method not Allowed</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
</head>

<body>
    <main class="vh-100 d-flex justify-content-center align-items-center">
        <section class="content-section">
            <div class="negative-m">
                <h2>405 - Method not allowed</h2>
                <p>The method you are using is strictly not allowed.</p><a class="button-40" href="<?php echo htmlspecialchars($redirectUrl); ?>">Go to Home</a>
            </div>
        </section>
    </main>
</body>

</html>