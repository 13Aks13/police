<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Upload CSV';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-uploadcsv">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please choose file:</p>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'csvFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>
</div>
