<?

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord {
    public static function tableName()
	{
		return '{{%authors}}';
	}

    public function rules()
	{
		return [
            [['name', 'surname', 'patronymic'], 'required'],
		];
	}

    public function attributeLabels()
	{
		return [
			'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
		];
	}

    public function getBooks(){
        return $this->hasMany(Book::class, ['id' => 'book_id'])
        ->viaTable('authors_books', ['author_id' => 'id']);
	}

	public function getSubscribers()
    {
        return $this->hasMany(Subscribe::class, ['author_id' => 'id']);
    }

	public function sortByBooksQuantity() {
		$authors = self::find()->all();
		$authorsWithBooks = [];
		$i = 0;
		foreach($authors as $author) {
			$authorsWithBooks[$i]['author'] = $author;
			$authorsWithBooks[$i]['books'] = count($author->books);
			$i++;
		}

		if(array_multisort(array_column($authorsWithBooks, 'books'), SORT_DESC, $authorsWithBooks)){
			return $authorsWithBooks;
		};

		return $authorsWithBooks;
	}
}