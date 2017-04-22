<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
	<div class="clientes-search">

		<?php 
			//echo("<br><br><br>");
			//echo (is_array($modelQuery)==1 ? "true" : "false");
			//var_dump($modelQuery[0]['id']);
		?>
		<?php $form = ActiveForm::begin([
			'action' => ['index'],
			'method' => 'post',
		]); ?>

		<?= $form->field($searchModel, 'id') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>
		
		<div>
			<?php 
				if (is_array($modelQuery)==1 && sizeof($modelQuery)>0) {
					echo Html::a('Download PDF', ['/clientes/descargar_pdf', 'id' => $modelQuery[0]['id']], ['class'=>'btn btn-primary', 'style'=>'visibility:visible']);
				} else {
					echo Html::a('Download PDF', ['/clientes/descargar_pdf'], ['class'=>'btn btn-primary', 'style'=>'visibility:hidden']);
				}
			?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
</div>
