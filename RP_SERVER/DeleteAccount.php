<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new PDO("mysql:host=192.168.0.5;dbname=duduhgee;charset=utf8", "bpm", "@Rkddbals0217");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 사용자 입력
    $userIDToDelete = isset($_POST["userID"]) ? $_POST["userID"] : "";

    if ($userIDToDelete != "") {
        // SQL 쿼리를 바인딩하여 사용자 계정 정보 삭제 처리
        $statement = $db->prepare("DELETE FROM USER WHERE userID = :userIDToDelete");

        // 바인딩
        $statement->bindParam(':userIDToDelete', $userIDToDelete, PDO::PARAM_STR);

        // 쿼리 실행
        $result = $statement->execute();

        // 사용자 공개키 정보 삭제 처리
        $keyStatement = $db->prepare("DELETE FROM PK WHERE userID = :userIDToDelete");

        // 바인딩
        $keyStatement->bindParam(':userIDToDelete', $userIDToDelete, PDO::PARAM_STR);

        // 공개키 정보 쿼리 실행
        $keyResult = $keyStatement->execute();

        $cardStatement = $db->prepare("DELETE FROM card WHERE userID = :userIDToDelete");

        // 바인딩
        $cardStatement->bindParam(':userIDToDelete', $userIDToDelete, PDO::PARAM_STR);

        // 공개키 정보 쿼리 실행
        $cardResult = $cardStatement->execute();

        $payStatement = $db->prepare("DELETE FROM pay_detail WHERE userID = :userIDToDelete");

        // 바인딩
        $payStatement->bindParam(':userIDToDelete', $userIDToDelete, PDO::PARAM_STR);

        // 공개키 정보 쿼리 실행
        $payResult = $payStatement->execute();

        $response = array();
        if ($result && $keyResult && $cardResult && $payResult) {
            $response["success"] = true;
        } else {
            $response["success"] = false;
        }
    } else {
        $response = array();
        $response["success"] = false;
    }

    echo json_encode($response);
} catch (PDOException $e) {
    // 에러 처리
    echo "Database Error: " . $e->getMessage();
}
?>