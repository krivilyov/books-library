<?

namespace app\helpers;

use Yii;
use app\models\Subscribe;

class Useful {
    /**
	 * Clean HTML and values.
	 * Useful when using _GET and _POST values
	 * @param string In value
	 * @return string Out value
	 */
	public static function parseCleanValue($val) {
		if ($val == '') {
			return '';
		}

		$val = str_replace("&#032;", " ", $val);
		$val = str_replace("&", "&amp;", $val);
		$val = str_replace("<!--", "&#60;&#33;--", $val);
		$val = str_replace("-->", "--&#62;", $val);
		$val = preg_replace("/<script/i", "&#60;sсript",  $val);
		$val = str_replace(">", "&gt;", $val);
		$val = str_replace("<", "&lt;", $val);
		$val = str_replace('"', "&quot;", $val);
		$val = str_replace("$", "&#036;", $val);
		$val = str_replace("\r", "", $val); // Remove tab chars
//		$val = str_replace("!", "&#33;", $val);
		$val = str_replace("'", "&#39;", $val); // for SQL injection security

		// Recover Unicode
		$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val);
		// Trying to fix HTML entities without ;
		$val = preg_replace("/&#(\d+?)([^\d;])/i", "&#\\1;\\2", $val);

		return $val;
	}

	/**
	 * глухарь для изображений
	 * 1 - путь до оригинала
	 * 2 - путь до глухаря
	 */
	static function imgpatch($img, $path = '/img/1px.png')
	{
		if (file_exists(Yii::getAlias('@webroot') . '/upload/' . $img) && is_file(Yii::getAlias('@webroot') . '/upload/' . $img)) {
			return '/upload/' . $img;
		}
		else {
			return Yii::getAlias('@web') . $path;
		}
	}

	/**
    * Создает  альяс для урла
    */
	static function create_alias($id = NULL, $incomming_alias = NULL, $prefix = 'ver')
    {
        $alias = $prefix.$id.'-'.$incomming_alias;
        return $alias;
    }

	 /**
    * переводит строку в транслит
    */
    static function translit($string)
    {
        $replace=[
            " "=>"-",
            "'"=>"",
            "`"=>"",
            "а"=>"a","А"=>"a",
            "б"=>"b","Б"=>"b",
            "в"=>"v","В"=>"v",
            "г"=>"g","Г"=>"g",
            "д"=>"d","Д"=>"d",
            "е"=>"e","Е"=>"e",
            "ж"=>"zh","Ж"=>"zh",
            "з"=>"z","З"=>"z",
            "и"=>"i","И"=>"i",
            "й"=>"y","Й"=>"y",
            "к"=>"k","К"=>"k",
            "л"=>"l","Л"=>"l",
            "м"=>"m","М"=>"m",
            "н"=>"n","Н"=>"n",
            "о"=>"o","О"=>"o",
            "п"=>"p","П"=>"p",
            "р"=>"r","Р"=>"r",
            "с"=>"s","С"=>"s",
            "т"=>"t","Т"=>"t",
            "у"=>"u","У"=>"u",
            "ф"=>"f","Ф"=>"f",
            "х"=>"h","Х"=>"h",
            "ц"=>"c","Ц"=>"c",
            "ч"=>"ch","Ч"=>"ch",
            "ш"=>"sh","Ш"=>"sh",
            "щ"=>"sch","Щ"=>"sch",
            "ъ"=>"","Ъ"=>"",
            "ы"=>"y","Ы"=>"y",
            "ь"=>"","Ь"=>"",
            "э"=>"e","Э"=>"e",
            "ю"=>"yu","Ю"=>"yu",
            "я"=>"ya","Я"=>"ya",
            "і"=>"i","І"=>"i",
            "ї"=>"yi","Ї"=>"yi",
            "є"=>"e","Є"=>"e"
        ];
        $str = iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
        $str = strtolower($str);
        $str = str_replace('/', '-', $str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

	public static function parseDate($date) {
		$timestamp = strtotime($date);
		$year = date('Y', $timestamp);

		return $year;
	}

    public static function notifySubscribers($book) {
        foreach($book->authors as $author) {
            $subscribers = Subscribe::find()->where(['author_id'=> $author->id])->all();

            foreach($subscribers as $subscriber){
                if(self::smsPilotSMSSend(str_replace('+','',$subscriber->phone), 'Автор добавил публикацию')){
                    $subscriber->isDone = 1; //зафигачил чтобы понимать что СМС отправилось
                    $subscriber->save();
                }
            }
        }
    }

    public static function smsPilotSMSSend($phone='70000000000', $text = 'Проверка'){
        $apikey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        $sender = 'INFORM';

        $url = 'https://smspilot.ru/api.php'
            .'?send='.urlencode( $text )
            .'&to='.urlencode( $phone )
            .'&from='.$sender
            .'&apikey='.$apikey
            .'&format=json';
        
        $json = file_get_contents( $url );
        $j = json_decode( $json );

        if ( !isset($j->error)) {
            // echo 'SMS успешно отправлена server_id='.$j->send[0]->server_id;
            return true;
        } else {
            // trigger_error( $j->error->description_ru, E_USER_WARNING );
            return false;
        }
    }
}