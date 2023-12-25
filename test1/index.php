
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>

    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div id="question-container" class="max-w-md mx-auto mt-8 p-6 bg-white border rounded shadow-lg">
        <h1 id="theme" class="text-lg text-blue-500 mb-2"></h1>
        <h1 id="question" class="text-xl font-bold mb-4"></h1>
        <p id="question-id" class="text-gray-700 font-bold mb-4"></p>
        <ul id="choices" class="list-none p-0"></ul>
        <p id="quiz-progress" class="mt-4 text-gray-700 font-bold">Question <span id="current-question">1</span>/<span id="total-questions">5</span></p>
        <button id="next-button" class="mt-4 px-4 py-2 bg-green-500 text-white rounded cursor-pointer hover:bg-green-600">
            Next
        </button>
        <button id="show-result-button" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600 hidden">
            Show Result
        </button>
        <p id="quiz-finished-message" class="hidden mt-4 text-green-500 font-bold">Quiz Finished!</p>
        <p id="result-message" class="hidden mt-4 text-red-500 font-bold"></p>
        <!-- Add a new element to display the score -->
        <div class="mt-4 p-4 border rounded">
            <p class="text-gray-700 font-bold">Your Score: <span id="user-score">0</span> points</p>
        </div>
        <!-- Add this element to your HTML body -->
        <div id="user-answers" class="mt-4 p-4 border rounded">
            <p class="text-gray-700 font-bold">Your Answers:</p>
        </div>
        <a href="logout.php">logout</a>
    </div>

<script src="ajax.js"></script>

</body>

</html>