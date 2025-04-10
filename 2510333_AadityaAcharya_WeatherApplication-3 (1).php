<?php
header("Content-Type: application/json");
// connection to server
$server="sql206.infinityfree.com";
$userName="if0_38246138";
$password="YaigOQREKB6rfE";
$conn=mysqli_connect($server,$userName,$password);
if(!$conn){
    echo "Failed to connect".mysqli_connect_error();
}
// creation of database
$create_database="CREATE DATABASE IF NOT EXISTS if0_38246138_aaditya";
mysqli_query($conn,$create_database);
// select database
mysqli_select_db($conn,'if0_38246138_aaditya');
// create table
$create_table="CREATE TABLE IF NOT EXISTS weather(
city TEXT NOT NULL,
country TEXT NOT NULL,
weather_condition TEXT NOT NULL,
main_weather_condition TEXT NOT NULL,
humidity INT NOT NULL,
pressure INT NOT NULL,
wind_speed INT NOT NULL,
wind_direction INT NOT NULL,
temperature INT NOT NULL,
date_time INT NOT NULL,
icon TEXT NOT NULL);";
mysqli_query($conn,$create_table);
// delete table after  hours
$current_time=time();
$date_time_two_hours_ago=$current_time-7200;
$delete_two_hours_old_data="DELETE FROM weather WHERE date_time<$date_time_two_hours_ago";
mysqli_query($conn,$delete_two_hours_old_data);
// check input value 
$cityname=isset($_GET['q'])?$_GET['q']:"swansea";
$select_data="SELECT * FROM weather WHERE city='$cityname'";
$result=mysqli_query($conn,$select_data);
// fetch data from api
if(mysqli_num_rows($result)==0){
    $url="https://api.openweathermap.org/data/2.5/weather?&q=".$cityname."&appid=ebe7f9cc36589ce002502387aa6948f2&units=metric";
    $respond=file_get_contents($url);
    $data=json_decode($respond,true);
    $city=$data['name'];
    $country=$data['sys']['country'];
    $weather_condition=$data['weather'][0]['description'];
    $main_weather_condition=$data['weather'][0]['main'];
    $humidity=$data['main']['humidity'];
    $pressure=$data['main']['pressure'];
    $wind_speed=$data['wind']['speed'];
    $wind_direction=$data['wind']['deg'];
    $temperature=$data['main']['temp'];
    $date_time=$data['dt'];
    $icon=$data['weather'][0]['icon'];                                                             // insert into database
    $insert_in_table="INSERT INTO weather (city, country,weather_condition,main_weather_condition,humidity,pressure,wind_speed,wind_direction,temperature,date_time,icon) VALUES ('$city', '$country','$weather_condition','$main_weather_condition','$humidity','$pressure','$wind_speed','$wind_direction','$temperature','$date_time','$icon')";
    mysqli_query($conn,$insert_in_table);
};
$result=mysqli_query($conn,$select_data);
// converting data to associative array
$rows=[];
while($row=mysqli_fetch_assoc($result)){
    $rows[]=$row;
}
// converting data to json
echo(json_encode($rows));
mysqli_close($conn);
?>