<?php

namespace app\controllers;

use app\models\CrmOrder;

class AjaxController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $order = CrmOrder::find()->where(['id' => $id])->one();
		
		echo json_encode($order->getAttributes(array('id','fio','phone')));
		
    }
	
	

}
