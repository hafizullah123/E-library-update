<?php
session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'library');

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set default language if not set
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Check if language is changed
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Function to localize strings based on language
function localize($key) {
    global $lang;
    $translations = array(
        'en' => array(
            'title' => 'Register as Labor',
            'home' => 'Home',
            'username_label' => 'Username:',
            'password_label' => 'Password:',
            'email_label' => 'Email:',
            'register_button' => 'Register as Labor',
            'already_account' => 'Already have an account?',
            'login_here' => 'Login here',
            'error_exists' => 'Username or email already exists.',
            'success_message' => 'Registration successful. Please log in.'
        ),
        'ps' => array(
            'title' => 'د کارګر په توګه ثبت کړئ',
            'home' => 'کور',
            'username_label' => 'کارن نوم:',
            'password_label' => 'پټ نوم:',
            'email_label' => 'بریښنالیک:',
            'register_button' => 'د کارګر په توګه ثبت کړئ',
            'already_account' => 'آیا دمخه حساب لرئ؟',
            'login_here' => 'دلته ننوتل',
            'error_exists' => 'کارن نوم یا بریښنالیک مخکې موجود دی.',
            'success_message' => 'ثبتول بریالی شو. مهرباني وکړئ ننوتل.'
        ),
        'fa' => array(
            'title' => 'ثبت نام به عنوان کارگر',
            'home' => 'خانه',
            'username_label' => 'نام کاربری:',
            'password_label' => 'رمز عبور:',
            'email_label' => 'ایمیل:',
            'register_button' => 'ثبت نام به عنوان کارگر',
            'already_account' => 'قبلاً حساب دارید؟',
            'login_here' => 'اینجا وارد شوید',
            'error_exists' => 'نام کاربری یا ایمیل قبلاً وجود دارد.',
            'success_message' => 'ثبت نام موفقیت آمیز بود. لطفا وارد شوید.'
        )
    );

    // Default to English if translation not found
    if (!isset($translations[$lang][$key])) {
        $lang = 'en';
    }

    return $translations[$lang][$key];
}

// Registration logic
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $user_type = 'labor'; // Default user type to labor

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $register_error = localize('error_exists');
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $user_type);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $register_success = localize('success_message');
        } else {
            $register_error = 'Registration failed. Please try again.';
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" <?php echo in_array($lang, ['ps', 'fa']) ? 'dir="rtl"' : 'dir="ltr"'; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo localize('title'); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body[dir="rtl"] {
            direction: rtl;
        }
        body[dir="ltr"] {
            direction: ltr;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .form-group {
            text-align: <?php echo in_array($lang, ['ps', 'fa']) ? 'right' : 'left'; ?>;
        }
        .alert {
            text-align: <?php echo in_array($lang, ['ps', 'fa']) ? 'right' : 'left'; ?>;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><?php echo localize('title'); ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboar.php"><?php echo localize('home'); ?> <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo strtoupper($lang); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?lang=en">English</a>
                            <a class="dropdown-item" href="?lang=ps">پښتو</a>
                            <a class="dropdown-item" href="?lang=fa">فارسی</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2><?php echo localize('title'); ?></h2>

        <?php if (isset($register_error)): ?>
            <p class="alert alert-danger"><?php echo $register_error; ?></p>
        <?php endif; ?>
        <?php if (isset($register_success)): ?>
            <p class="alert alert-success"><?php echo $register_success; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label for="username"><?php echo localize('username_label'); ?></label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password"><?php echo localize('password_label'); ?></label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="email"><?php echo localize('email_label'); ?></label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo localize('register_button'); ?></button>
        </form>

        <p><?php echo localize('already_account'); ?> <a href="login.php"><?php echo localize('login_here'); ?></a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
