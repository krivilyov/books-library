<?

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\helpers\Useful;

class Book extends ActiveRecord {

	const SCENARIO_CREATE_BOOK = 'create_book';
	const SCENARIO_EDIT_BOOK = 'edit_book';
	public $imageFile;

    public static function tableName()
	{
		return '{{%books}}';
	}

    public function rules()
	{
		return [
            [['name', 'createdAt', 'description', 'isbn'], 'required'],
			[['alias', 'coverImage'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'except' => self::SCENARIO_EDIT_BOOK],
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Название',
            'createdAt' => 'Год выпуска',
            'description' => 'Описание',
			'coverImage' => 'Обложка'
		];
	}

	public function beforeSave($insert) {
		if (!parent::beforeSave($insert)) {
			return false;
		}

		if($this->getIsNewRecord()){
			$this->alias = Useful::create_alias($this->id, Useful::translit($this->name));
		}

		return true;
	}

	public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@webroot') . Yii::$app->params['updir'] . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function getAuthors(){
        return $this->hasMany(Author::class, ['id' => 'author_id'])
        ->viaTable('authors_books', ['book_id' => 'id']);
	}
}