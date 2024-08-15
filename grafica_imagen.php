<?php
  $data = json_decode(file_get_contents('php://input'), true);
  $image = $data['image'];
  $image = str_replace('data:image/png;base64,', '', $image);
  $image = str_replace(' ', '+', $image);
  $imageData = base64_decode($image);

  $tempImage = 'temp_chart.png';
  file_put_contents($tempImage, $imageData);
  /* if(!file_exists('./temp_chart_1.png'))
    file_put_contents('temp_chart_1.png', $imageData);
  else
    file_put_contents('temp_chart_2.png', $imageData); */

  #echo json_encode([])
?>