<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_table".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property int $is_deleted
 */
class TestTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'count', 'is_deleted'], 'required'],
            [['id', 'count', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
