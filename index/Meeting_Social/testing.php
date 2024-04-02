<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scrollable PHP Content with Fixed Header</title>
<style>
    .iframe-container {
        position: relative;
        width: 100%;
        height: 300px; /* Adjust height as needed */
        overflow: hidden;
    }
    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .fixed-header {
        position: sticky;
        top: 0;
        background-color: white;
        padding: 10px;
        z-index: 1000; /* Ensure it's above the iframe content */
    }
    .scrollable-content {
        overflow-y: scroll;
        height: calc(100% - 40px); /* Subtract header height */
        padding-top: 40px; /* Adjust according to header height */
    }
</style>
</head>
<body>

<div class="iframe-container">
    <div class="fixed-header">
        <!-- Content for the fixed header -->
        <h1>Fixed Header Content</h1>
        <!-- You can add more content here -->
    </div>
    <div class="scrollable-content">
        <iframe src="your_php_file.php" scrolling="no"></iframe>
    </div>
</div>

</body>
</html>
