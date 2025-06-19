<?php
$file = 'config.txt'; 

if (isset($_POST['frequency'])) {
    $new_frequency = $_POST['frequency'];
    $new_frequency = $new_frequency;

    if (file_exists($file)) {
        if (file_put_contents($file, $new_frequency)) {
            $message = "Cập nhật thời gian delay thành công!";
        } else {
            $message = "Lỗi khi cập nhật thời gian delay.";
        }
    } else {
        $message = "File không tồn tại.";
    }
} else {
    $message = "Thời gian delay chưa được gửi.";
}

$file_content = file_exists($file) ? file_get_contents($file) : "1000";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            padding: 15px;
            margin-top: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            font-size: 16px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        footer {
            text-align: center;
            margin-top: 30px;
        }

        footer button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Cập nhật thời gian delay của thiết bị</h1>
</header>

<div class="container">
    <form action="" method="POST">
        <div class="form-group">
            <label for="frequency">Nhập thời gian (ms): </label>
            <input type="number" name="frequency" id="frequency" required>
        </div>
        <input type="submit" value="Cập nhật">
    </form>

    <?php if (isset($message)) : ?>
        <div class="message <?php echo (strpos($message, 'Cập nhật') !== false) ? 'success' : 'info'; ?>">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>

    <h2>Thời gian delay hiện tại của thiết bị: <?php echo htmlspecialchars($file_content); ?> ms</h2>
</div>

<footer>
    <a href="index.php"><button>Về trang chủ</button></a>
</footer>

</body>
</html>
