<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new PDO("mysql:host=192.168.0.5;dbname=duduhgee;charset=utf8", "bpm", "@Rkddbals0217");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to allow only alphanumeric characters and Korean characters
    function only_alpha_number(String $content){
        return preg_replace('/[^a-zA-Z0-9가-힣]/u', '', $content);
    }

    // 사용자 입력
    $userID = isset($_POST["userID"]) ? only_alpha_number($_POST["userID"]) : "";
    $userPassword = isset($_POST["userPassword"]) ? $_POST["userPassword"] : "";
    $userName = isset($_POST["userName"]) ? only_alpha_number($_POST["userName"]) : "";
    $userAge = isset($_POST["userAge"]) ? preg_replace('/[^0-9]/', '', $_POST["userAge"]) : "";

    // SQL 쿼리를 바인딩하여 사용자 입력 처리
    $statement = $db->prepare("INSERT INTO USER (userID, userPassword, userName, userAge) VALUES (:userID, SHA1(:userPassword), :userName, :userAge)");

    // 바인딩
    $statement->bindParam(':userID', $userID, PDO::PARAM_STR);
    $statement->bindParam(':userPassword', $userPassword, PDO::PARAM_STR);
    $statement->bindParam(':userName', $userName, PDO::PARAM_STR);
    $statement->bindParam(':userAge', $userAge, PDO::PARAM_INT);

    // 쿼리 실행
    $statement->execute();

    $response = array();
    $response["success"] = true;

    echo json_encode($response);
} catch (PDOException $e) {
    // 에러 처리
    echo "Database Error: " . $e->getMessage();
}
?>