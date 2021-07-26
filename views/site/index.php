<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $data app\models\Crimes */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;


$this->title = 'Crimes';

?>
<div class="site-index">

    <table>
        <thead>
        <tr>
            <?php $form = ActiveForm::begin(['id' => 'crimes-form', 'method' => 'get', 'action' => '/index']) ?>
            <th>
                <?= $form->field($data, 'orders[code_id_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC']); ?>
                <?= $form->field($data, 'orders[code_id_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC']); ?>
                <?= $form->field($data, 'code_id'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[crime_name_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC']); ?>
                <?= $form->field($data, 'orders[crime_name_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC']); ?>
                <?= $form->field($data, 'crime_name'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[crime_number_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC']); ?>
                <?= $form->field($data, 'orders[crime_number_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC']); ?>
                <?= $form->field($data, 'crime_number'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[crime_date_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'orders[crime_date_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'crime_date')->textInput(['disabled' => 'disabled']); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[quantity_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC']); ?>
                <?= $form->field($data, 'orders[quantity_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC']); ?>
                <?= $form->field($data, 'quantity'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[names_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'orders[names_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'names'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[crime_location_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'orders[crime_location_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'crime_location'); ?>
            </th>
            <th>
                <?= $form->field($data, 'orders[coordinates_asc]')->checkbox(['uncheck' => false, 'label' => 'ASC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'orders[coordinates_desc]')->checkbox(['uncheck' => false, 'label' => 'DESC', 'disabled' => 'disabled']); ?>
                <?= $form->field($data, 'coordinates'); ?>
            </th>
            <th>
                <?= Html::submitButton('GO') ?>
                <?= Html::a('Reset', 'index') ?>
            </th>
            <?php ActiveForm::end(); ?>
        </tr>
        </thead>
        <tbody>
        <?php
        echo "<tr>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<tr>";
        foreach ($models as $model) {
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
            echo "<td>".$model['lat'].",".$model['long']."</td>";
            echo "<td>";
            echo "<img src='https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s+e41111(".$model['long'].",".$model['lat']."),pin-s+f90b0b(".$model['long'].",".$model['lat'].")/".$model['long'].",".$model['lat'].",15.43,0/200x100?access_token=pk.eyJ1IjoiYWtzMTMiLCJhIjoiY2tyZ2I1c3JuMDFsazMxbzV4bTRmZXY1YiJ9.Fjh2BO6FmuHguwnjDIWwIA'></a>";

            //https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s+e41111(-84.3889,33.771),pin-s+f90b0b(-84.3919,33.7699)/-84.3919,33.7699,15.43,0/300x200?access_token=YOUR_MAPBOX_ACCESS_TOKEN
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <?php
    echo LinkPager::widget([
       'pagination' => $pages,
    ]);
    ?>

</div>

<style>
    table {
        width: 100%;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .order-group {
        display: flex;
        flex-direction: row;
    }
</style>