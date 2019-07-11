<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\CrmOrder;

$dataProvider = new ActiveDataProvider([
    'query' => CrmOrder::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
           

            'id',
            ['attribute'=>'fio',
			 'label'=>'ФИО'
			],	  
			['attribute'=>'phone',
			 'label'=>'Телефон'
			],	  
				
            ['attribute'=>'status',
			 'label'=>'Статус',
			 'value'=>function($model, $index, $widget){
				if ($model->status == 1) return 'новый заказ';
				if ($model->status == 2) return 'клиенту позвонил менеджер';
				if ($model->status == 3) return 'заказ на доставке курьера';
				if ($model->status == 4) return 'заказ доставлен клиенту';
				if ($model->status == 5) return 'клиент отказался от заказа';
				
			 }
			 
			 
			],	 
            
            ['attribute'=>'article','format'=>'raw','value'=>function($model, $index, $widget){
				$ret = '';
				
				if ($model->article) $ret .= "{$model->article}<br>";
				if ($model->cbn) $ret .= "CBN x {$model->cbn}<br>";
				if ($model->cbnxl) $ret .= "CBNXL x {$model->cbn}<br>";
				if ($model->hpr) $ret .= "HPR x {$model->hpr}<br>";
				if ($model->hpb) $ret .= "HPB x {$model->hpb}<br>";
				if ($model->hpg) $ret .= "HPG x {$model->hpg}<br>";
				if ($model->hpx) $ret .= "HPX x {$model->hpx}<br>";
				
				return $ret;
				
			},
			'label'=>'Корзина'
			],
            
            // 'created_at',
            // 'updated_at',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'urlCreator' => function ($action, $model, $key, $index){
					return '#';
				},
				'buttonOptions'=>array("class" =>  "edit"),
			],
        ],
    ]);
?>
<div id = "overlay">

</div>
<div id = "form">
	<form>
		<label>ФИО</label>
		<input type = "text" value = "" id = "fio" class = "form-control">
		<label>Телефон</label>
		<input type = "text" value = "" id = "phone" class = "form-control">
		<label>Статус</label>
		<select id = "status" class = "form-control">
			<option value = "1">новый заказ</option>
			<option value = "2">клиенту позвонил менеджер</option>
			<option value = "3">заказ на доставке курьера</option>
			<option value = "4">заказ доставлен клиенту</option>
			<option value = "5">клиент отказался от заказа</option>
		</select>
		<br>
		<input type = "hidden" value = "" id = "form-id">
		<input type = "button" value = "OK" id = "ok" class = "btn btn-primary">
		<input type = "button" value = "Отмена" id = "neok" class = "btn btn-secondary ">
		
	</form>
</div>
<style>
 #overlay{
	 width:100%;
	 height:100%;
	 background-color: black;
	 position:absolute;
	 top:0px;
	 left:0px;
	 opacity:.1;
	display:none;
	 
 }
 #form{
	 border-radius: 8px;
	 top:30%;
	 left:40%;
	 width:20%;
	 position:absolute;
	 z-index:10;
	 opacity:1;
	 background-color:grey;
	 padding: 20px;
	 display:none;
 }
 	 
 }
</style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
jQuery(document).ready(function(){
	
	jQuery('#overlay').click(function(){
		
		jQuery('#neok').click();
		
		
	})
	jQuery('#neok').click(function(){
		jQuery('#overlay').hide();
		jQuery('#form').hide();
		
	});
	
	jQuery('.edit').click(function(){
	
		var id = jQuery(this).parent('td').parent('tr').children('td:first').html();
	
	
	
		jQuery.get( "?r=ajax/index&id="+id, function( data ) {
			
			data = JSON.parse(data);
			
			jQuery("#fio").val(data.fio);
			jQuery("#phone").val(data.phone);
			jQuery("#form-id").val(data.id);
			
			jQuery("#neok").show();
			jQuery("#form").show();
			
		});
	
	
	})
	jQuery('#ok').click(function(){
		
		var data = [];
		data.id = jQuery("#form-id").val();
		data.fio = jQuery("#fio").val();
		data.phone = jQuery("#phone").val();
		
		
		//тут не закончено
		jQuery.post( "?r=ajax/update&id="+JSON.stringify(data), function( data ) {
			if (data == 'okay'){
				var tr = jQuery('tr[data-key='+id+']');
				tr.children(td).next().html(fio);
				tr.children(td).next().next().html(phone);
				
			}
			
		});
		
		
		
	})
});


</script>