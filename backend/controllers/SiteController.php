<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
// 【新增】引入通过 Gii 生成的模型类
use common\models\PreNewsCategory;
use common\models\PreNewsArticle;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        // 【修改】获取图表所需的数据
        
        // 1. 获取所有分类
        $categories = PreNewsCategory::find()->orderBy('sort_order')->all();
        
        $chartLabels = []; // 用于存放 X 轴标签（分类名）
        $chartData = [];   // 用于存放 Y 轴数据（文章数）

        foreach ($categories as $category) {
            $chartLabels[] = $category->name;
            // 2. 统计当前分类下的文章数量
            // 假设分类关联字段是 cid，根据你的数据库设计调整
            $count = PreNewsArticle::find()->where(['cid' => $category->cid])->count();
            $chartData[] = intval($count);
        }

        // 3. 将数据传递给视图
        return $this->render('index', [
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}