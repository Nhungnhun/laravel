<!-- resources/views/emails/your_mailable.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Thư chúc mừng</title>
</head>
<body>
    <h1>Chúc mừng!</h1>
    <p>Xin chào <b><?php echo $userName; ?></b>,</p>
    <p>Yêu cầu mượn sách <b><?php echo $bookName; ?></b> với mã <b><?php echo $code; ?></b> của bạn đã được duyệt!</p>
</body>
</html>

