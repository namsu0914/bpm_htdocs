<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// POST로 전달된 데이터 받기
$userID = isset($_POST['userID']) ? $_POST['userID'] : '';
$publicKey = isset($_POST['publicKey']) ? $_POST['publicKey'] : '';

$con = mysqli_connect("192.168.0.5", "bpm", "@Rkddbals0217", "duduhgee", 3306);
mysqli_query($con,'SET NAMES utf8');


$statement = mysqli_prepare($con, "INSERT INTO pk (userID, publicKey) VALUES (?, ?)");
mysqli_stmt_bind_param($statement, "ss", $userID, $publicKey);
$result = mysqli_stmt_execute($statement);

$response['success'] = true;
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