<?php

/* @var $this yii\web\View */


use yii\helpers\Html;

$this->title = 'Show crime';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-crime-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <table>
      <thead>
      <tr>
        <th>Code ID</th>
        <th>Crime Name</th>
        <th>#</th>
        <th>Date</th>
        <th>Quantity</th>
        <th>Suspects</th>
        <th>Location</th>
        <th>Lattitude</th>
        <th>Longtittude</th>
      </tr>
      </thead>
      <tbody>
      <?php
        echo "<tr>";
          echo "<td>".$model['code_id']."</td>";
          echo "<td>".$model['crime_name']."</td>";
          echo "<td>".$model['crime_number']."</td>";
          echo "<td>".$model['crime_date']."</td>";

          /* quantity */
          echo "<td>";
            echo $model->suspects[0]['quantity'] ?? '?';
            echo "</td>";

          /* names */
          echo "<td>";
            if (isset($model->suspects)) {
            foreach ($model->suspects as $suspect) {
            echo $suspect['name']."<br>";
            }
            }
            echo "</td>";

          echo "<td>".$model['crime_location']."</td>";
          echo "<td>".$model['lat']."</td>";
          echo "<td>".$model['long']."</td>";
        echo "</tr>";
      ?>
      <tbody>
    </table>


    <?php echo "<img src='https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s+e41111(".$model['long'].",".$model['lat']."),pin-s+f90b0b(".$model['long'].",".$model['lat'].")/".$model['long'].",".$model['lat'].",10,0/1200x800?access_token=pk.eyJ1IjoiYWtzMTMiLCJhIjoiY2tyZ2I1c3JuMDFsazMxbzV4bTRmZXY1YiJ9.Fjh2BO6FmuHguwnjDIWwIA'></a>"; ?>
</div>

<style>
    table {
        width: 100%;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>