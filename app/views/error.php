<!-- app/views/error.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Lỗi hệ thống</title>
</head>
<body>
    <h2>Đã xảy ra lỗi</h2>
    <p><?= isset($message) ? htmlspecialchars($message) : 'Không rõ lỗi' ?></p>
</body>
</html>