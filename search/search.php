<?php
$conn = new mysqli("localhost", "root", "", "techgo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// الحصول على الكلمة من GET
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($query !== '') {
    // منع حقن SQL
    $safeQuery = $conn->real_escape_string($query);

    // تنفيذ البحث
    $sql = "SELECT name, url FROM product_pages WHERE name LIKE '%$safeQuery%'";
    $result = $conn->query($sql);

    // التحقق إذا كانت هناك نتائج
    if ($result->num_rows > 0) {
        // الحصول على أول نتيجة فقط
        $row = $result->fetch_assoc();
        $url = htmlspecialchars($row['url']);
        $fullUrl = "http://localhost/E-commerce/" . $url;  // بناء الرابط الكامل للمنتج

        // إعادة التوجيه مباشرة إلى أول رابط
        header("Location: $fullUrl");
        exit;  // تأكد من إنه بعد التوجيه بيوقف تنفيذ باقي الكود
    } else {
        echo "<p>لا توجد نتائج مطابقة.</p>";
    }
} else {
    echo "<p>من فضلك أدخل كلمة للبحث.</p>";
}

$conn->close();
?>
