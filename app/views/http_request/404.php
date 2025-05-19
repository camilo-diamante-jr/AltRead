<?php


$redirectUrl = '/login';

// Check if the user is logged in and determine the redirect URL
if (isset($_SESSION['user_type'])) {
    $userType = $_SESSION['user_type'];

    // Redirect based on user type
    switch ($userType) {
        case 'Admin':
            $redirectUrl = '/admin/dashboard'; // Admin-specific page
            break;
        case 'Teacher':
            $redirectUrl = '/teacher/dashboard';
            break;
        case 'Learner':
            $redirectUrl = '/student/dashboard';
            break;
        default:
            $redirectUrl = '/login';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #DCE4C9, #C8E0B8);
            color: #333;
            font-family: Arial, sans-serif;
        }

        h2 {
            font-size: 34px;
            font-family: "Arial Black", sans-serif;
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        .content-section {
            background: white;
            width: 60%;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        img {
            width: 50%;
            margin: 20px auto;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .button-40 {
            background-color: #111827;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 1.125rem;
            font-weight: 600;
            padding: .75rem 1.5rem;
            text-decoration: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
            margin-top: 15px;
        }

        .button-40:hover {
            background-color: #374151;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        }

        .button-40:focus {
            outline: 2px solid #111827;
            outline-offset: 2px;
        }

        .negative-m {
            margin-top: -35px;
        }
    </style>
</head>

<body>
    <main class="vh-100 d-flex justify-content-center align-items-center">
        <section class="content-section">
            <figure class="text-center">
                <img src="../assets/gif/404-2.gif" alt="404 Not Found Image">
            </figure>
            <div class="negative-m">
                <h2>404 - Page Not Found</h2>
                <p>The page you are looking for is not available.</p>
                <a class="button-40" href="<?php echo htmlspecialchars($redirectUrl); ?>">Go to Home</a>
            </div>
        </section>
    </main>
</body>

</html>