<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property integer $level
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
//			array('parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
//			array('name, parent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'parent' => 'Parent Category',
			'level' => 'Level',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getMainCategories()
	{
		$categories = array();

		$models = self::model()->findAll(array(
			'condition'=>'parent=:parent',
			'params'=>array(':parent'=>0),
			
//Want uncategorized to be first, then sort by name...
//			'order'=>'when id = 0 than 1 else 2 end, name ASC',
		));

		foreach($models as $model){
			$categories[$model->id] = $model->name;
		}

		return $categories;
	}

	public function getChildren()
	{
		$children = self::model()->findAll(array(
			'condition'=>'parent=:parent',
			'params'=>array(':parent'=>$this->id),
		));

		return $children;
	}

	public static function getMaxLevel()
	{
		$lowest = self::model()->find(array(
			'order'=>'level DESC',
		));

		return $lowest->level;
	}

	public static function mainCategoryDropdown($name = 'category', $id="")
	{
		$html = CHtml::dropDownList($name, $id, Category::getMainCategories(), array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>Yii::app()->createUrl('category/loadSubcategories'),
				'data'=>array('parent'=>'js:this.value'),
				'success'=>self::getDropdownJs(),
		)));

		return $html;
	}

	public static function subcategoryDropdown($name, $id)
	{
		$html = CHtml::dropDownList($name, "", array(), array(
			'id'=>$id,
			'ajax'=>array(
				'type'=>'POST',
				'url'=>Yii::app()->createUrl('category/loadSubcategories'),
				'success'=>self::getDropdownJs(),
				'data'=>array('parent'=>'js:this.value'),
		)));

		return $html;
	}

	public static function getDropdownJs()
	{
		return "function(data){
			data = JSON.parse(data);

			var maxLevel = '". self::getMaxLevel() ."';
			var level = parseInt(data.level);

			if(level + 1 > maxLevel){
				return;
			}

			var elementId = '#subcategory_' + level;
			var divId = '#subcategoryDiv_' + level;

			if(data.html != ''){
				$(elementId).html(data.html);
				$(divId).show();
			}

			for(var i = level + 1; i < maxLevel; i++){
				elementId = '#subcategory_' + i;
				divId = '#subcategoryDiv_' + i;
				$(divId).hide();
				$(elementId).html('');
			}


		}";
	}

	public static function getParentFromSubcategoryDropdown($subcategories = array())
	{
		//Loop up though categories, starting at the "sub-est (deepest)" until a valid value is found.
		//In some cases, a subcategory may not be populated, or may have not been set, so check the one above it.
		$category = 1;
		for($i = count($subcategories) - 1; $i >= 0; $i--){
			if(isset($subcategories[$i]) && is_numeric($subcategories[$i])){
				$category = $subcategories[$i];
				return $category;
			}
		}
		//No valid subcategories set
		return false;
	}
}