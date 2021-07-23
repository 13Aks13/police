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
                <?= $form->field($data, 'code_id'); ?>
            </th>
            <th>
                <?= $form->field($data, 'crime_name'); ?>
            </th>
            <th>
                <?= $form->field($data, 'crime_number'); ?>
            </th>
            <th>
                <?= $form->field($data, 'crime_date')->textInput(['disabled' => 'disabled']); ?>
            </th>
            <th>
                <?= $form->field($data, 'quantity'); ?>
            </th>
            <th>
                <?= $form->field($data, 'names'); ?>
            </th>
            <th>
                <?= $form->field($data, 'crime_location'); ?>
            </th>
            <th>
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
            echo "<img src='https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/".$model['long'].",".$model['lat'].",9,0/150x80?access_token=pk.eyJ1IjoiYWtzMTMiLCJhIjoiY2tyZ2I1c3JuMDFsazMxbzV4bTRmZXY1YiJ9.Fjh2BO6FmuHguwnjDIWwIA'></a>";
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
</style>