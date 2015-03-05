<?php
/* @var $this GroupsController */
/* @var $data Groups */
?>
<script>
	function getAjaxLink(id, name){
		return "<div>"+name+" <a class=\"delete"+id+"\" href=\"#\" onclick=\" {jQuery.ajax({'url':'/InterNationsTest/index.php/groups/removeFromGroup','type':'POST','beforeSend':function( request ) \
     	{ \
       		$('.delete"+id+"_loading').animate({opacity: 1}); \
     	},'success':function( data ) \
		{ \
            if( data == 'done' ){ \
            	$('.delete"+id+"').parent().fadeOut(); \
            }else{ \
                alert( data ); \
            } \
          	$('.delete"+id+"_loading').animate({opacity: 0}); \
 	 	},'data':{'model_id':'"+id+"'},'cache':false}); return false; }\">remove from group</a><img class=\"action_loading delete"+id+"_loading\"></div>";
	}
</script>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users')); ?>:</b>
	<div class="group_users">
	<?php
		if( count($data->users)==0 ){
			echo "no users added yet";
		}

		foreach ($data->users as $key => $user_model) {
			echo '<div>'.$user_model->user->name.' ';
			echo CHtml::link(
				"remove from group", '#',
		        array(
		        	'onClick'=>' {'.CHtml::ajax(
		    			array(
							'url'=>Yii::app()->createUrl( 'groups/removeFromGroup' ),
							// array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request )
				         	{
				           		$('.delete".$user_model->id."_loading').animate({opacity: 1});
				         	}",
				    		'success' => "function( data )
							{
				                if( data == 'done' ){
				                	$('.delete".$user_model->id."').parent().fadeOut();
				                }else{
				                    alert( data );
				                }
				              	$('.delete".$user_model->id."_loading').animate({opacity: 0});
				     	 	}",
					    	'data' => array('model_id' => $user_model->id),
				    	),
		                array('live'=>false, 'id'=>'delete'.$user_model->id,)
			    	).' return false; }',
					'href' => Yii::app()->createUrl( 'groups/removeFromGroup' ),
					'class' => 'delete'.$user_model->id,
				)
			);

	 		echo '<img class="action_loading delete'.$user_model->id.'_loading" /></div>';
		}
	?>
	</div>

	<?php
		echo '<br /><div><b>add user: </b>';
		echo CHtml::dropDownList('users', '', $users, array('empty' => '(Select User)', 'id' => 'new_user_'.$data->id)).' ';
		echo CHtml::link(
			"add", '#',
	        array(
	        	'onClick'=>' {'.CHtml::ajax(
	    			array(
						'url'=>Yii::app()->createUrl( 'groups/addToGroup' ),
						// array( // ajaxOptions
					    'type' => 'POST',
					    'beforeSend' => "function( request )
			         	{
			           		$('.add".$data->id."_loading').animate({opacity: 1});
			         	}",
			    		'success' => "function( data )
						{
							data = JSON.parse(data);
			                if( data[0] == 'done' ){
			                	$('.add".$data->id."').parent().parent().find('.group_users').append(getAjaxLink(data[1], data[2]));
			                }else{
			                    alert( data[0] );
			                }
			              	$('.add".$data->id."_loading').animate({opacity: 0});
			     	 	}",
				    	'data' => array('user_id' => 'js: $("#new_user_"+'.$data->id.').val()', 'group_id' => $data->id),
			    	),
	                array('live'=>false, 'id'=>'add'.$data->id,)
		    	).' return false; }',
				'href' => Yii::app()->createUrl( 'groups/addToGroup' ),
				'class' => 'add'.$data->id,
			)
		);
 		echo '<img class="action_loading add'.$data->id.'_loading" /></div>';
	?>
</div>