<?php

namespace app\controllers;

use app\models\search\CrimesSearch;
use Yii;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\Crimes;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;


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
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CrimesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
           'models' => $dataProvider->getModels(),
           'data' => $searchModel,
           'pages' => $dataProvider->getPagination()
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex2()
    {
        $request = Yii::$app->request;

        $query = new Query();
        $query->select('*')->from('crimes')->where(['not', ['id' => null]]);

        if ($request->isPost) {
            $param = $request->getBodyParam('Crimes');
            $codeid = $param['code_id'];
            $crimename = $param['crime_name'];
            $crimenumber = $param['crime_number'];
            $crimedate = $param['crime_date'];
            $crimelocation = $param['crime_location'];

            /*** Search start ***/
            if ($codeid) {
                $query->andWhere(['code_id' => $codeid]);
            }

            if ($crimename) {
                $query->andWhere(['like', 'crime_name', $crimename]);
            }

            if ($crimenumber) {
                $query->andWhere(['=', 'crime_number', $crimenumber]);
            }

            if ($crimedate) {
                $query->andWhere(['=', 'crime_date', $crimedate]);
            }

            if ($crimelocation) {
                $query->andWhere(['like', 'crime_location', $crimelocation]);
            }
            /*** Search end ***/
        }

        if ($request->isGet) {
            $codeid = $request->get('codeid');
            $crimename = $request->get('crime_name');
            $crimenumber = $request->get('crime_number');
            $crimedate = $request->get('crime_date');
            $crimelocation = $request->get('crime_location');

            /*** Search start ***/
            if ($codeid) {
                $query->andWhere(['code_id' => $codeid]);
            }

            if ($crimename) {
                $query->andWhere(['like', 'crime_name', $crimename]);
            }

            if ($crimenumber) {
                $query->andWhere(['=', 'crime_number', $crimenumber]);
            }

            if ($crimedate) {
                $query->andWhere(['=', 'crime_date', $crimedate]);
            }

            if ($crimelocation) {
                $query->andWhere(['like', 'crime_location', $crimelocation]);
            }
            /*** Search end ***/
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->orderBy('code_id ASC')->all();


        foreach ($models as $key => $model) {
            $subq = new Query();
            $models[$key]['quantity'] = $subq->select('quantity')->from('suspects')->where(['code_link_id' => $model['code_id']])->one();

            $subq2 = new Query();
            $models[$key]['suspects'] = $subq2->select('name')->from('suspects')->where(['code_link_id' => $model['code_id']])->all();
        }

        return $this->render('index', [
           'sort' => ['code_id' => 'ASC'], 'data' => new Crimes(), 'models' => $models, 'pages' => $pages,
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
