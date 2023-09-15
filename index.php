<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>MBChB for Dummies Editor</title>
</head>

<body class="bg-gray-100 overflow-auto">

    <nav class="p-4">
        <div class=" container mx-auto flex justify-between items-center">
<!-- logo on the left -->
<div>
    <a href="index.php" class=""><img src="public/dummies_logo.png" alt="logo" class="w-12 h-auto"></a>
</div>

<!-- menu items on the right -->
    <ul class="flex justify-end">
        <li class="mr-6"><a href="index.php" class="text-cyan-700 hover:text-cyan-950">Help</a></li>
        <li class="mr-6"><a href="contact.php" class="text-cyan-700 hover:text-cyan-950">Contact</a></li>
    </ul>
        </div>
    </nav>

    <div class="flex justify-center items-center my-4">
    <form action="process.php" method="POST">
    <label for="question" class="block font-mono text-cyan-700 text-sm font-semibold">Type in the Multiple Choice Questions Below:</label><br>
    <textarea name="question" id="question_data" class="mih-h-[auto] w-full resize border rounded p-2 overflow-hidden" rows="16" cols="70" placeholder="Question Text: Your question goes here.
Choices:
A) Choice A
B) Choice B
C) Choice C
D) Choice D
E) Choice E
Correct Answer: A (or B, C, D, E as needed)"></textarea> 
    </div>

    <div class="flex justify-center items-center my-4"><button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button></div>

<div class="bg-gray-200 p-6 shadow-lg text-center rounded-lg">
    <p class="text-sm font-semibold">
        To upload a file, click on the "Choose File" button below and select a text file (.txt) containing the questions. The file should be formatted as follows:
            <ul>
                <li class="text-gray-600 text-sm">Written in .txt format</li>
                <li class="text-gray-600 text-sm">Saved locally</li>
            </ul>
    </p>
</div>

</form>
    <div class="flex justify-center items-center my-4">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" accept=".txt">
    <button type="submit" class="bg-neutral-800 hover:bg-neutral-500 text-white font-bold py-2 px-4 rounded">Upload</button>
</form>
</div>
<footer class="bg-gray-500 text-white py-8">
    <div class="container mx-auto flex flex-col items-center">
        <h2 class="text-2xl font-semibold mb-4">MBChB for Dummies</h2>
        <p class="text-sm mb-2">Multiple-choice questions online editor.</p>
        <div class="flex space-x-4 mb-4">
            <a href="#" class="text-gray-300 hover:text-white transition duration-300 ease-in-out">
                About Us
            </a>
            <a href="#" class="text-gray-300 hover:text-white transition duration-300 ease-in-out">
                Contact Us
            </a>
        </div>
        <div class="text-sm text-gray-300">
            &copy; 2023 MBChB for Dummies Editor. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
