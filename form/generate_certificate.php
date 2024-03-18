<?php


if ($_SERVER['REQUEST_METHOD'] == "POST"){

    foreach ($_POST as $key => $value){
        $$key = $value;
    }

    $scores = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
    $student_score = $scores[array_rand($scores)];
    $certificate_date = date("d/m/Y ");

    //get the image and move it to the user certificate directory
    $tmp = $_FILES['student_image']['tmp_name'];
    $ext = explode("/", $_FILES['student_image']['type'])[1];
    $img_name = $student_name.".".$ext;
    $img_path = "../images/$img_name";
    move_uploaded_file($tmp, $img_path);

    //Get the certificate template and put the data on it
    $certificate_template = file_get_contents("../template/certificate_file.html");
    $certificate = str_replace("{{name}}", $student_name, $certificate_template);
    $certificate = str_replace("{{course}}", $course_name, $certificate);
    $certificate = str_replace("{{score}}", $student_score, $certificate);
    $certificate = str_replace("{{date}}", $certificate_date, $certificate);
    $certificate = str_replace("{{image}}", $img_path, $certificate);

    //Generate the certificate file
    $filename = $student_name . ".html";
    $file_path = "../certificates/$filename";

    $certificate_file = fopen("$file_path", 'w+');
    fwrite($certificate_file, $certificate);
    fclose($certificate_file);

    header("location: $file_path");

}else{
    header("location: ../index.html");
}