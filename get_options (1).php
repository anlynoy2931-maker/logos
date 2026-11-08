<?php
include __DIR__ . '/db.php';


if(isset($_GET['major_id']) && !isset($_GET['course_id'])){

    $major_id = $_GET['major_id'];

    $sql = "SELECT DISTINCT c.course_id, c.course_name
            FROM program_options p
            JOIN courses c ON p.course_id = c.course_id
            WHERE p.major_id = '$major_id'";

    $result = $conn->query($sql);

    echo '<option value="">-- ເລືອກຫຼັກສູດ --</option>';

    while($row = $result->fetch_assoc()){
        echo "<option value='".$row['course_id']."'>".$row['course_name']."</option>";
    }
}


if(isset($_GET['major_id']) && isset($_GET['course_id'])){

    $major_id = $_GET['major_id'];
    $course_id = $_GET['course_id'];

    $sql = "SELECT DISTINCT t.time_id, t.time_name
            FROM program_options p
            JOIN study_time t ON p.time_id = t.time_id
            WHERE p.major_id = '$major_id'
            AND p.course_id = '$course_id'";

    $result = $conn->query($sql);

    echo '<option value="">-- ເລືອກເວລາ --</option>';

    while($row = $result->fetch_assoc()){
        echo "<option value='".$row['time_id']."'>".$row['time_name']."</option>";
    }
}
?>