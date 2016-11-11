<html>
<head>
</head>
<body>
<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$db_selected = mysqli_select_db($conn, 'database');
if (!$db_selected){
	die('can\'t use database ' . mysql_error());
}
/*
Get all questions
SELECT QUESTIONID, Question FROM Questions

How many students answer which question IE 10 students answered question 1, 2 students answered question 2
$query = "SELECT QUESTIONID, COUNT(UserAnswer) AS HowManyTried FROM Answers GROUP BY QUESTIONID";

Number of Students who answered question correctly
$query = "SELECT Answers.QUESTIONID, COUNT(UserAnswer) AS NumberCorrectlyAnswered FROM Answers INNER JOIN Questions ON Questions.QUESTIONID=Answers.QUESTIONID WHERE Questions.CorrectAnswer=Answers.UserAnswer GROUP BY QUESTIONID"

Questions Answered by Student
SELECT MatricNumber, COUNT(QUESTIONID) AS StudentAnswered FROM Answers GROUP BY MatricNumber

Question Answered Correct by which student
SELECT MatricNumber, COUNT(*) AS StudentCorrect FROM Answers AS A1 WHERE UserAnswer=(SELECT CorrectAnswer FROM Questions WHERE QuestionID = A1.QuestionID) GROUP BY MatricNumber
*/
$query = "SELECT COUNT(Answers.QuestionID) AS TotalTried, Answers.QuestionID, Questions.Question FROM Answers,Questions WHERE Answers.QUESTIONID=Questions.QUESTIONID GROUP BY Answers.QuestionID";
$result = $conn->query($query);

echo "<table border=\"border\">";
echo "<th>Question ID</th><th>Question</th><th>Student(s) answered</th>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['QuestionID'] . "</td><td>" . $row['Question'] . "</td><td>" . $row['TotalTried'] . "</td></tr>";
}
echo "</table><br>";


$query = "SELECT Answers.QUESTIONID, Questions.Question, COUNT(UserAnswer) AS NumberCorrectlyAnswered FROM Answers INNER JOIN Questions ON Questions.QUESTIONID=Answers.QUESTIONID WHERE Questions.CorrectAnswer=Answers.UserAnswer GROUP BY QUESTIONID";
$result = $conn->query($query);

echo "<table border=\"border\">";
echo "<th>Question ID</th><th>Question</th><th>No of Students who answered correctly</th>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['QUESTIONID'] . "</td><td>" . $row['Question'] . "</td><td>" . $row['NumberCorrectlyAnswered'] . "</td></tr>";
}
echo "</table><br>";


$query = "SELECT MatricNumber, COUNT(QUESTIONID) AS StudentAnswered FROM Answers GROUP BY MatricNumber";
$result = $conn->query($query);

echo "<table border=\"border\">";
echo "<th>Student Matric</th><th>Questions tried</th>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['MatricNumber'] . "</td><td>" . $row['StudentAnswered'] . "</td></tr>";
}
echo "</table><br>";


$query = "SELECT MatricNumber, COUNT(*) AS StudentCorrect FROM Answers AS A1 WHERE UserAnswer=(SELECT CorrectAnswer FROM Questions WHERE QuestionID = A1.QuestionID) GROUP BY MatricNumber";
$result = $conn->query($query);

echo "<table border=\"border\">";
echo "<th>Student Matric</th><th>Questions answered correctly</th>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['MatricNumber'] . "</td><td>" . $row['StudentCorrect'] . "</td></tr>";
}
echo "</table>";

mysqli_close($conn);
?>
</body>
</html>
