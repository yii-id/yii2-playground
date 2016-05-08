<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\search\Product as ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $layout = 'playground';

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->with('category');

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportCsv()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith('category')->asArray();
        $dataProvider->pagination = false;

        $i = 1;
        $rows = [];
        $rows[] = implode("\t", ['No', 'Code', 'Name', 'Category', 'Status']); // header
        foreach ($dataProvider->query->all() as $row) {
            $r = [$i++];
            $r[] = $row['code'];
            $r[] = $row['name'];
            $r[] = isset($row['category']) ? $row['category']['name'] : '';
            $r[] = $row['status'];
            $rows[] = implode("\t", $r);
        }
        return Yii::$app->getResponse()->sendContentAsFile(implode("\n", $rows), 'product.csv', [
                'mimeType' => 'application/excel'
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
