<?php

namespace backend\controllers;

use Yii;
use backend\models\Clientes;
use backend\models\ClientesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
		$request = Yii::$app->request;
		$id = $request->post('ClientesSearch')['id'];
		
		$searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$modelQuery = "";
		
		if (!is_null($id) && !empty($id)) {
			$modelQuery = ClientesSearch::find()
					->where(['=', 'id', $id,])
					->all();
		}
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelQuery' => $modelQuery,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     */
    public function actionDescargar_pdf($id)
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$modelQuery = "";
		
		if (!is_null($id) && !empty($id)) {
			$modelQuery = ClientesSearch::find()
					->where(['=', 'id', $id,])
					->all();
					
			// setup kartik\mpdf\Pdf component
			$content = $modelQuery[0]['texto'];
			$pdf = new Pdf([
				// set to use core fonts only
				'mode' => Pdf::MODE_CORE, 
				// A4 paper format
				'format' => Pdf::FORMAT_LETTER, 
				// portrait orientation
				'orientation' => Pdf::ORIENT_PORTRAIT, 
				'filename' => $modelQuery[0]['id'].'_'.$modelQuery[0]['nombre'].'.pdf',
				// stream to browser inline
				'destination' => Pdf::DEST_DOWNLOAD, 
				// your html content input
				'content' => $content,  
				// format content from your own css file if needed or use the
				// enhanced bootstrap css built by Krajee for mPDF formatting 
				'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
				// any css to be embedded if required
				'cssInline' => '.kv-heading-1{font-size:18px}', 
				 // set mPDF properties on the fly
				'options' => ['title' => 'Krajee Report Title'],
				 // call mPDF methods on the fly
				'methods' => [ 
					'SetHeader'=>['Krajee Report Header'], 
					'SetFooter'=>['{PAGENO}'],
				]
			]);
			
			// return the pdf output as per the destination setting
			return $pdf->render();
		}
		
		/*
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelQuery' => $modelQuery,
        ]);*/
		
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
