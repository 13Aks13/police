<?php

namespace app\controllers;

use app\models\Crimes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\search\CrimesSearch;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\Sort;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
           'access' => [
              'class' => AccessControl::class, 'only' => ['logout'], 'rules' => [
                 [
                    'actions' => ['logout'], 'allow' => true, 'roles' => ['@'],
                 ],
              ],
           ], 'verbs' => [
              'class' => VerbFilter::class, 'actions' => [
                 'logout' => ['post'], 'index' => ['get', 'post'],
              ],
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
           ], 'captcha' => [
              'class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
           ],
           'view' => [
                'class' => 'yii\web\ViewAction',
                'viewPrefix' => '',
           ],
        ];
    }

    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'code_id' => [
                    'asc' => ['crime_id' => SORT_ASC,],
                    'desc' => ['crime_id' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Crime code',
                ],
                'crime_name' => [
                    'asc' => ['crime_name' => SORT_ASC,],
                    'desc' => ['crime_name' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Crime name',
                ],
                'crime_number' => [
                    'asc' => ['crime_number' => SORT_ASC,],
                    'desc' => ['crime_number' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Crime number',
                ],
                'crime_date' => [
                    'asc' => ['crime_date' => SORT_ASC,],
                    'desc' => ['crime_date' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Crime date',
                ],
                'quantity' => [
                    'asc' => ['quantity' => SORT_ASC,],
                    'desc' => ['quantity' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Quantity suspects',
                ],
                'crime_location' => [
                    'asc' => ['crime_location' => SORT_ASC,],
                    'desc' => ['crime_location' => SORT_DESC,],
                    'default' => SORT_ASC,
                    'label' => 'Crime location',
                ],
            ],
        ]);

        $searchModel = new CrimesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'models' => $dataProvider->getModels(),
            'data' => $searchModel,
            'pages' => $dataProvider->getPagination(),
            'sort' => $sort,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
           'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
           'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays uploadcvs page.
     *
     * @return Response|string
     */
    public function actionUploadcsv()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->upload()) {
                $model->parseCsv();

                return $this->goHome();
            }
        }

        return $this->render('uploadcsv', [
           'model' => $model,
        ]);
    }
}
