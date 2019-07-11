<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TestTable */

$this->title = 'Create Test Table';
$this->params['breadcrumbs'][] = ['label' => 'Test Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
