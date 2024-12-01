<?php


    include('../incl/config.php');
    include('../incl/auth.php');
    header('Content-Type: application/json');
    $role = $rowUser['role'];
    if($role == 'Admin'){
        $notStats = 'complete';
    }elseif($role == 'User1'){
        $notStats = 'pending';

    }elseif($role == 'User2'){
        $notStats = 'processing';

    }
    $notifStatus = '';
    $sql = "UPDATE document 
    SET notif_status = ? where status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $notifStatus, $notStats);

    if ($stmt->execute()) {
    echo json_encode(["success" => true, 'role' => $role]);
    } else {
    echo json_encode(["success" => false, "message" => "Failed to update the document."]);
    }
    $stmt->close();
    $conn->close();
?>