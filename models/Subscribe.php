<?

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\ArrayHelper;

class Subscribe extends ActiveRecord {
    public static function tableName()
	{
		return '{{%subscribers}}';
	}

    public function rules()
	{
		return [
            [['phone'], 'required'],
			['phone', 'match', 'pattern' => '/^\+?[1-9][0-9]{7,14}$/', 'message' => 'Телефона, должно быть в формате +7XXXXXXXXXX'],
			[['isDone'], 'safe']
		];
	}

    public function attributeLabels()
	{
		return [
			'phone' => 'Телефон',
		];
	}

	public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}