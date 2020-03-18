<?php
$recviz_mag = mysqli_query($con_li, "SELECT * FROM `cordinat`"); // sql запрос на выбор всех координат
$cord = mysqli_fetch_assoc($recviz_mag); // приравниваем данные к массиву
?>
