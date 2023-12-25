document.addEventListener('DOMContentLoaded', function () {
    let currentQuestion = 1;
    let totalQuestions = 4;

    let score = 0; // Variable to track the user's score

    function fetchNextQuestion() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_question.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if(xhr.responseText){
                let questionData = JSON.parse(xhr.responseText);
                displayQuestion(questionData);}
                // Remove the next line as it's not needed anymore
                // startCountdown();
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

        questionData.choices.forEach(function (choice) {
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
        // Remove the next line as it's not needed anymore
        // clearInterval(timer);
        // countdown = 15;

        // Get the selected choices
        let selectedChoices = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(function (checkbox) {
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

        xhr.onreadystatechange = function () {
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

        xhr.onreadystatechange = function () {
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
