CREATE TABLE theme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE question (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    correct_choice_id INT NOT NULL,
    theme_id INT,
    FOREIGN KEY (theme_id) REFERENCES theme(id)
);

CREATE TABLE choice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    choice_content TEXT NOT NULL,
    question_id INT,
    FOREIGN KEY (question_id) REFERENCES question(id)
);


-- Insert theme
INSERT INTO theme (name) VALUES ('Science');

-- Insert questions for Theme 1 (Science)
INSERT INTO question (content, correct_choice_id, theme_id) VALUES
('What is the capital of France?', 2, 1),
('Who developed the theory of relativity?', 4, 1),
('What is the chemical symbol for water?', 3, 1),
('What is the largest mammal on Earth?', 4, 1),
('Which planet is known as the Red Planet?', 3, 1),
('What is the speed of light?', 2, 1),
('What is the chemical symbol for oxygen?', 3, 1),
('What is the powerhouse of the cell?', 2, 1),
('Who discovered penicillin?', 1, 1),
('What is the atomic number of carbon?', 4, 1);

-- Insert choices for Theme 1 (Science)
INSERT INTO choice (choice_content, question_id) VALUES
('Berlin', 1),
('Paris', 1), -- Correct Choice
('Madrid', 1),
('Rome', 1),

('Isaac Newton', 2),
('Albert Einstein', 2), -- Correct Choice
('Galileo Galilei', 2),
('Nikola Tesla', 2),

('H2O', 3), -- Correct Choice
('CO2', 3),
('O2', 3),
('N2', 3),

('Elephant', 4),
('Blue Whale', 4), -- Correct Choice
('Giraffe', 4),
('Lion', 4),

('Mars', 5), -- Correct Choice
('Venus', 5),
('Jupiter', 5),
('Saturn', 5),

('299,792 km/s', 6), -- Correct Choice
('150,000 km/s', 6),
('500,000 km/s', 6),
('1,000,000 km/s', 6),

('O', 7),
('O2', 7), -- Correct Choice
('CO2', 7),
('H2O', 7),

('Mitochondria', 8), -- Correct Choice
('Nucleus', 8),
('Endoplasmic Reticulum', 8),
('Golgi Apparatus', 8),

('Alexander Fleming', 9), -- Correct Choice
('Marie Curie', 9),
('Louis Pasteur', 9),
('Anton van Leeuwenhoek', 9),

('12', 10),
('6', 10),
('14', 10),
('8', 10);
