<?php

namespace app\controllers;

use Yii;
use app\models\CrmOrder;


class ApiController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $request = Yii::$app->request;
	   
	   if (!$request->isGet){
			throw new BadRequestHttpException("Invalid request");
	   }
	   
	   $order= new CrmOrder();
	   
	   $order->fio = $request->get('fio');
	   $order->phone = $request->get('phone');
	   $order->article = $request->get('article');
	   $order->sum = $request->get('sum');
	   $order->status = $request->get('status');
	   
	   $order->save();
	   if ($order->errors ){
		   print('-1');
		   
	   }
	   print $order->id;
	   
	   
	   
	   
    }

}
