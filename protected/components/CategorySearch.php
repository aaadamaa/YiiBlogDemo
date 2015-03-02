<?php
Yii::import('zii.widgets.CPortlet');

class CategorySearch extends CPortlet
{
	public $title = "Category";
	
	protected function renderContent()
	{
		$maxLevel = Category::getMaxLevel();
		
		echo Category::mainCategoryDropdown('category', 'category');
		echo "<br />";
		
		for($i=0; $i<$maxLevel; $i++){
			echo Category::subcategoryDropdown("subcategory[$i]", "subcategory_$i");
		}
		
		echo "<br />";
		echo CHtml::link(CHtml::encode("Search"), array('post/index', 'category'=>''), array('id'=>'categorySearchButton'));
		
		
		Yii::app()->clientScript->registerScript('categorySearchScript', "
			$('#categorySearchButton').click(function(){
				var category = false;
				var value;
				for(i = " . ($maxLevel - 1) ."; i >= 0; i--){
					value = $('#subcategory_' + i).val();
					if(value !== null && !isNaN(value)){
						category = value;
						break;
					}
				}
				
				if(!category){
					value = $('#category').val();
					if(!isNaN(value)){
						category = value;
					}else{
						category = " . Category::NO_CATEGORY . ";
					}
				}
				
				var link = $('#categorySearchButton').attr('href');
				link = link.substr(0, link.indexOf('category=')+9) + category;
				$('#categorySearchButton').attr('href', link);
			});
		");
		
	}
}