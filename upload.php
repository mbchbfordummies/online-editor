<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["fileToUpload"])) {
        $file = $_FILES["fileToUpload"]["tmp_name"];
        $fileType = $_FILES["fileToUpload"]["type"];

        if ($fileType === "text/plain") {
            if (is_uploaded_file($file)) {
                // Read the uploaded file content
                $fileContent = file_get_contents($file);
            } else {
                echo "File upload failed.";
            }
        } else {
            echo "Only TXT files are allowed.";
        }
    } else {
        echo "No file uploaded.";
    }
} else {
    echo "Invalid request method.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded File Content</title>
</head>
<body>
    <h2>Uploaded File Content:</h2>
    <textarea id="fileContent" rows="10" cols="80" readonly><?php echo htmlspecialchars($fileContent); ?></textarea>
    <br>
    <button onclick="copyToClipboard()">Copy</button>

<script>
function copyToClipboard() {
    var textarea = document.getElementById("fileContent");
    textarea.select();
    document.execCommand("copy");
    alert("Uploaded content copied to clipboard");
}
</script>
    <!-- <form action="regex.php" method="POST">
        <input type="hidden" name="uploadedContent" value="<?php echo base64_encode($fileContent); ?>">
        <button onclick="copyToClipboard()">Copy</button>
    </form> -->
</body>
</html>
