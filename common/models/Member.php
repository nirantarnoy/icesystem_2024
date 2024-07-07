<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $sex
 * @property int|null $status
 */
class Member extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    public $xname;

    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['xname'],'string'],
            [['name'],'required','message' => 'ห้ามว่างมึงฮู้บ่'],
            [['sex', 'status'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        $scenaios = parent::scenarios();
        $scenaios['create'] = ['name','sex'];
        return $scenaios;

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'ชื่อ'),
            'description' => Yii::t('app', 'รายละเอียด'),
            'sex' => Yii::t('app', 'เพศ'),
            'status' => Yii::t('app', 'สถานะ'),
        ];
    }
}
