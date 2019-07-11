<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crmOrder".
 *
 * @property int $id
 * @property int $fio
 * @property string $phone
 * @property string $article
 * @property int $sum
 * @property string $status
 * @property int $cbn
 * @property int $cbnxl
 * @property int $hpr
 * @property int $hpb
 * @property int $hpg
 * @property int $hpx
 */
class crmOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'phone', 'article', 'sum', 'status' ], 'required'],
            [[ 'sum', 'cbn', 'cbnxl', 'hpr', 'hpb', 'hpg', 'hpx'], 'integer'],
            [['fio', 'article', 'status'], 'string'],
            [['fio','phone'], 'string', 'max' => 63],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'article' => 'Article',
            'sum' => 'Sum',
            'status' => 'Status',
            'cbn' => 'Cbn',
            'cbnxl' => 'Cbnxl',
            'hpr' => 'Hpr',
            'hpb' => 'Hpb',
            'hpg' => 'Hpg',
            'hpx' => 'Hpx',
        ];
    }
	
	/*
		расчеи кол-ва картриджей
		
		не совсем понятно, мог ли клиент бить в заказ принтер с "левыми картриджами"
		но если да, тогда математическое решение этой задачи не даст никакой пользы, тк там 2 картриджа по 390 
		и отличить 1 от другого будет невозможно
		
		поэтому я исходил из того что клиент бьет заказы картрижи только с соместимыми принтерами
	*/
	
	public function beforeSave($insert)
	{
		
		if ($this->article == 'canon')
		{
			$sum = $this->sum - 1000; //cost of printer
			
			for ($i=0;$i<=5;$i++){ //bruteforce eazest way here
				for ($j=0;$j<=5;$j++){
					if ($i*390+$j*490 == $sum){
						
						$this->cbn = $i;
						$this->cbnxl = $j;
						return parent::beforeSave($insert);
					}
				}
			}
			$this->id = -1;
			return false;
			
		}elseif ($this->article == 'hp'){
			
			
			$sum = $this->sum-2000;
			
			
			
			$remain = $sum % 390;
			
			/*этот остаток нужно будет распределить менжу 4мя видами картриджей и тогда мы получим ответ*/
			
			$count = floor($sum/390);
			
			/*цены практически одинаковые, можно узнать количество картриджей в заказе обычным делением*/
			
			$this->hpr = 0; //390
			$this->hpb = 0; //391
			$this->hpg = 0; //392
			$this->hpx = 0; //393
			
			if ($remain >= 3)
			{
				$this->hpx = floor($remain/3);
				
				if ($this->hpx>5){
					$this->hpx = 5;
				}
				
				$count -= $this->hpx;
				
				
			}
			
			if ($remain >= 2)
			{
				$this->hpg = floor($remain/2);
				
				if ($this->hpg>5){
					$this->hpg = 5;
				}
				
				$count -= $this->hpg;
				
				
			}
			
			if ($remain >= 1)
			{
				$this->hpb = $remain;
				
				if ($this->hpb > 5){
					$this->hpb = 5;
				}
				
				$count -= $this->hpg;
				
				
			}
			
			
			if ($count> 0)
			{
				$this->hpr = intval(($this->hpb * 391 + $this->hpg * 392 + $this->hpx * 393)/390);
			}
			
			if ($this->hpb * 391 + $this->hpg * 392 + $this->hpx * 393 + $this->hpr*390 != $sum){
				$this->id = -1;
				return;
			}
			
			return parent::beforeSave($insert);
			
		
			
		}
		
		

		
		
		
	}
}
