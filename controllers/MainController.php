<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Author;
use app\models\Book;
use app\models\Subscribe;
use app\helpers\Useful;

class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['authors', 'author-create', 'author-edit', 'author-delete', 'books', 'book-create', 'book-edit', 'book-delete'],
                'rules' => [
                    [
                        'actions' => ['authors', 'author-create', 'author-edit', 'author-delete', 'books', 'book-create', 'book-edit', 'book-delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
					return $this->redirect('/auth/login');
				}
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $books = Book::find()->all();

        return $this->render('index', ['books' => $books]);
    }

    public function actionBooks(){
        $books = Book::find()->orderBy('name ASC')->all();

        return $this->render('books/list', ['books' => $books]);
    }

    public function actionBookCreate(){
        $model = new Book();
        $authors = Author::find()->all();

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request->post();

            $model->attributes = $request['Book'];
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if($model->imageFile){
                $model->coverImage = $model->imageFile->name;
            }

            if($model->save()){
                $authorsFromReq = Yii::$app->request->post('Book')["authors"];
                foreach($authorsFromReq as $id){
                    $author = Author::find()->where(['id' => $id])->one();
                    
                    $model->link('authors', $author);
                }

                if($model->imageFile){
                    $model->upload();
                }

                //при создании книги оповещаем подписчиков SMSкой
                Useful::notifySubscribers($model);

                return $this->redirect('/books');
            }
        }

        return $this->render('books/edit', ['model' => $model, 'authors' => $authors]);
    }

    public function actionBookDelete($id){
        $book = Book::findOne($id);
        if($book->delete()){
            return $this->redirect('/books');
        }
    }

    public function actionBookEdit($id){
        $model = Book::findOne($id);
        $model->scenario = Book::SCENARIO_EDIT_BOOK;
        $authors = Author::find()->all();

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request->post();
            $model->attributes = $request['Book'];
           
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if($model->imageFile){
                $model->coverImage = $model->imageFile->name;
            }

            if($model->save()){
                $model->unlinkAll('authors', true);

                $authorsFromReq = Yii::$app->request->post('Book')["authors"];
                foreach($authorsFromReq as $id){
                    $author = Author::find()->where(['id' => $id])->one();
                    $model->link('authors', $author);
                }

                if($model->imageFile){
                    $model->upload();
                }

                return $this->redirect('/books');
            }
        }

        return $this->render('books/edit', ['model' => $model, 'authors' => $authors]);
    }

    public function actionBook($alias){
        $book = Book::find()->where(['alias'=> $alias])->one();

        return $this->render('book', ['book' => $book]);
    }

    public function actionAuthors(){
        $authors = Author::find()->orderBy('surname ASC')->all();

        return $this->render('authors/list', ['authors' => $authors]);
    }

    public function actionAuthorCreate(){
        $model = new Author();

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post('Author');
            if($model->save()){
                return $this->redirect('/authors');
            }
        }

        return $this->render('authors/edit', ['model' => $model]);
    }

    public function actionAuthorDelete($id){
        $model = Author::findOne($id);
        if($model->delete()){
            return $this->redirect('/authors');
        }
    }

    public function actionAuthorEdit($id){
        $model = Author::findOne($id);

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post('Author');
            if($model->save()){
                return $this->redirect('/authors');
            }
        }

        return $this->render('authors/edit', ['model' => $model]);
    }

    public function actionSubscribe($id) {
        $model = new Subscribe();
        $book = Book::findOne($id);

        if (Yii::$app->request->isPost) {
            $phone = Yii::$app->request->post('Subscribe')['phone'];
            foreach($book->authors as $author){
                $model = new Subscribe();
                //на каждого автора закидываем подписку (похер на дубликаты - нет времени :P)
                $model->phone = $phone;
                
                if($model->save()){
                    $model->link('author', $author);
                }
            }

            return $this->redirect('/');
        }

        return $this->render('subscribe', ['model' => $model, 'book' => $book]);
    }

    public function actionRating() {
        $model = new Author();

        $sortedAuthors = $model->sortByBooksQuantity();

        return $this->render('rating', ['authors' => $sortedAuthors]);
    }
}
