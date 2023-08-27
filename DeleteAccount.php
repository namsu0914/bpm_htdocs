<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// POST로 전달된 데이터 받기
$userID = isset($_POST['userID']) ? $_POST['userID'] : '';


$con = mysqli_connect("192.168.0.5", "bpm", "@Rkddbals0217", "duduhgee", 3306);
mysqli_query($con,'SET NAMES utf8');

$statement = mysqli_prepare($con, "DELETE FROM USER WHERE userID = '$userID'");
$result = mysqli_stmt_execute($statement);


// 응답 데이터 생성
$response = array();
if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

// 응답 데이터 전송
header('Content-Type: application/json');
echo json_encode($response);

// DB 연결 종료
$stmt->close();
$conn->close();

?>