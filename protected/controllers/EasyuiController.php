<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Product;

/**
 * Description of EasyuiController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class EasyuiController extends Controller
{
    public $layout = 'playground';

    public function behaviors()
    {
        return[
            [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save' => ['POST'],
                    'delete' => ['POST'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionData()
    {
        $request = Yii::$app->getRequest();
        Yii::$app->getResponse()->format = 'json';

        $query = Product::find();
        $query->asArray();
        // searching
        if (($q = $request->get('q'))) {
            $query->orWhere(['id' => $q])
                ->orWhere(['like', 'name', $q])
                ->orWhere(['code' => $q]);
        }

        // sorting
        if (($sort = $request->get('sort'))) {
            $order = $request->get('order', 'asc');
            $query->orderBy([$sort => $order == 'asc' ? SORT_ASC : SORT_DESC]);
        }

        // paging
        if (($limit = $request->get('rows'))) {
            $page = $request->get('page', 1);
            $total = $query->count();
            $query->offset(($page - 1) * $limit)->limit($limit);
            return[
                'total' => $total,
                'rows' => $query->all(),
            ];
        }
        return $query->all();
    }

    public function actionSave($id = null)
    {
        Yii::$app->getResponse()->format = 'json';

        // jika id == null berarti create new
        if ($id === null) {
            $model = new Product();
        } else {
            $model = Product::findOne($id);
            if ($model === null) {
                return[
                    'type' => 'error',
                    'message' => 'Data tidak ditemukan'
                ];
            }
        }
        if ($model->load(Yii::$app->getRequest()->post(), '') && $model->save()) {
            return [
                'type' => 'success',
            ];
        }
        return[
            'type' => 'error',
            'message' => 'Validation error',
            'error' => $model->firstErrors,
        ];
    }

    public function actionDelete($id)
    {
        Yii::$app->getResponse()->format = 'json';
        $model = Product::findOne($id);
        if ($model === null) {
            return[
                'type' => 'error',
                'message' => 'Data tidak ditemukan'
            ];
        }
        $model->delete();
        return [
            'type' => 'success',
        ];
    }
}
