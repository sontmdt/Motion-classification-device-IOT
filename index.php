<?php
$autoRefresh = isset($_GET['autoRefresh']) && $_GET['autoRefresh'] == 'on' ? true : false;

$refreshTime = 5; // Giá trị mặc định là 5 giây
if (file_exists('config.txt')) {
    $fileContent = file_get_contents('config.txt');
    $refreshTime = is_numeric($fileContent) ? (int)$fileContent / 1000 : 5;
}

if ($autoRefresh) {
    $metaRefresh = '<meta http-equiv="refresh" content="' . $refreshTime . '">'; 
} else {
    $metaRefresh = ''; 
}

$num_records = isset($_GET['num_records']) ? (int)$_GET['num_records'] : 5;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Dữ Liệu Mới Nhất</title>
    <?php echo $metaRefresh; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        #output {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .data-row {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }

        .button-container button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #45a049;
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
    <h1>Hiển Thị Dữ Liệu Mới Nhất</h1>
</header>

<div class="container">

    <form method="GET" action="">
        <div class="form-group">
            <label for="num_records">Nhập số lượng dữ liệu: </label>
            <input type="number" name="num_records" id="num_records" min="1" value="<?php echo $num_records; ?>" required>
        </div>
        <input type="submit" value="Cập nhật">
    </form>

    <div class="button-container">
        <?php if ($autoRefresh): ?>
            <a href="?autoRefresh=off&num_records=<?php echo $num_records; ?>">
                <button>OFF</button>
            </a>
        <?php else: ?>
            <a href="?autoRefresh=on&num_records=<?php echo $num_records; ?>">
                <button>ON</button>
            </a>
        <?php endif; ?>

        <a href="update.php">
            <button>Setting</button>
        </a>
    </div>

    <div id="output">
        <?php
        $mysqli = new mysqli("localhost", "root", "", "demoiot");

        if ($mysqli->connect_errno) {
            echo "Lỗi kết nối: " . $mysqli->connect_error;
            exit();
        }

        $result = $mysqli->query("SELECT timestamp, output FROM demoiot ORDER BY timestamp DESC LIMIT $num_records");

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='data-row'><strong>" . htmlspecialchars($row['timestamp']) . ":</strong> " . htmlspecialchars($row['output']) . "</div>";
            }
        } else {
            echo "Lỗi truy vấn: " . $mysqli->error;
        }

        $mysqli->close();
        ?>
    </div>

</div>

</body>
</html>
