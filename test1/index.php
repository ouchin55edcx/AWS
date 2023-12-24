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
        <p id="time-remaining" class="text-red-500 font-bold">Time Remaining: <span id="countdown">15</span> seconds</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentQuestion = 1;
            let totalQuestions = 5;
            let countdown = 15;
            let timer;
            let score = 0; // Variable to track the user's score

            function startCountdown() {
                timer = setInterval(function() {
                    document.getElementById('countdown').textContent = countdown;
                    countdown--;

                    if (countdown < 0) {
                        clearInterval(timer);
                        nextQuestion();
                    }
                }, 1000);
            }

            function fetchNextQuestion() {
                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_question.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let questionData = JSON.parse(xhr.responseText);
                        displayQuestion(questionData);
                        startCountdown();
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        console.log('Error fetching question');
                    }
                };
                xhr.send();
            }

            function displayQuestion(questionData) {
                document.getElementById('theme').textContent = questionData.question_theme;
                document.getElementById('question').textContent = questionData.question_content;
                document.getElementById('question-id').textContent = `Question ID: ${questionData.question_id}`;

                let choicesList = document.getElementById('choices');
                choicesList.innerHTML = '';

                questionData.choices.forEach(function(choice) {
                    let li = document.createElement('li');
                    let checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = choice.choice_id;
                    checkbox.className = 'mr-2';
                    li.appendChild(checkbox);
                    li.appendChild(document.createTextNode(`(${choice.choice_id}) ${choice.choice_content}`)); // Display choice ID
                    choicesList.appendChild(li);
                });

                document.getElementById('current-question').textContent = currentQuestion;
                document.getElementById('total-questions').textContent = totalQuestions;
            }



            function nextQuestion() {
                clearInterval(timer);
                countdown = 15;

                // Get the selected choices
                let selectedChoices = [];
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                    selectedChoices.push(checkbox.value);
                });

                // Save the selected choices in session (you may need to adjust this based on your backend implementation)
                saveSelectedChoicesInSession(currentQuestion, selectedChoices);

                if (currentQuestion < totalQuestions) {
                    fetchNextQuestion();
                    currentQuestion++;
                } else {
                    document.getElementById('next-button').style.display = 'none';
                    document.getElementById('quiz-finished-message').classList.remove('hidden');
                    document.getElementById('show-result-button').classList.remove('hidden');
                }
            }

            function saveSelectedChoicesInSession(questionId, selectedChoices) {
                // Use AJAX to send data to the server
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_user_answers.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Optional: Handle the response from the server
                        console.log('User answers saved successfully');
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        console.log('Error saving user answers');
                    }
                };

                // Convert data to JSON format
                let data = JSON.stringify({
                    questionId: questionId,
                    selectedChoices: selectedChoices
                });

                // Send the data to the server
                xhr.send(data);
            }




            function showResult() {
                // Send a GET request to get_user_answers.php
                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_user_answers.php', true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let userAnswers = JSON.parse(xhr.responseText);
                        displayUserAnswers(userAnswers);
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        console.log('Error fetching user answers');
                    }
                };

                xhr.send();
            }

            function displayUserAnswers(userAnswers) {
                let userAnswersContainer = document.getElementById('user-answers');
                userAnswersContainer.innerHTML = '';

                for (let questionId in userAnswers) {
                    let answerItem = document.createElement('p');
                    answerItem.textContent = `Question ${questionId}: ${userAnswers[questionId].join(', ')}`;
                    userAnswersContainer.appendChild(answerItem);
                }
            }



            document.getElementById('next-button').addEventListener('click', nextQuestion);
            document.getElementById('show-result-button').addEventListener('click', showResult);

            fetchNextQuestion();
        });
    </script>

</body>

</html>