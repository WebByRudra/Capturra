require_once $_SERVER['DOCUMENT_ROOT'] . "/Capturra/includes/session.php";
secureSessionStart();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = $_SERVER['DOCUMENT_ROOT'] . "/Capturra/";
require_once $base_path . "config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /Capturra/public/login.html");
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header("Location: /Capturra/public/login.html?error=empty");
    exit();
}

/* PREPARED STATEMENT */
$stmt = mysqli_prepare($conn, "SELECT id, first_name, username, password, role FROM users WHERE email = ?");
if (!$stmt) {
    header("Location: /Capturra/public/login.html?error=server");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: /Capturra/public/login.html?error=user");
    exit();
}

$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

/* PASSWORD VERIFY */
if (!password_verify($password, $user['password'])) {
    header("Location: /Capturra/public/login.html?error=pass");
    exit();
}

/* 🔐 REGENERATE SESSION (ANTI FIXATION) */
session_regenerate_id(true);

/* ✅ STORE SESSION */
$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];
$_SESSION['name']     = $user['first_name'];

/* 🔐 SESSION BINDING (ANTI HIJACK) */
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

/* ⏱️ SESSION TIME TRACK */
$_SESSION['LAST_ACTIVITY'] = time();

/* 🚀 REDIRECT BASED ON ROLE */
if ($user['role'] === "photographer") {
    header("Location: /Capturra/public/photographer_home.php");
} else {
    header("Location: /Capturra/public/client_home.php");
}
exit();