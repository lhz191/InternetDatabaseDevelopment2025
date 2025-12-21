<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException; // 1. 必须引入这个，否则 actionView 会报错
use common\models\TeamDepartment;  // 2. 确保你的 common/models 下有 TeamDepartment.php
use common\models\TeamMember;      // 3. 引用队员模型

class TeamController extends Controller
{
    /**
     * 团队列表页
     */
    public function actionIndex()
    {
        // 获取所有部门及其成员
        // 注意：Gii 生成的关联方法通常叫 getPreTeamMembers，所以这里用 'preTeamMembers'
        // 如果你的模型里改成了 getTeamMembers()，请把下面换成 'teamMembers'
        $departments = TeamDepartment::find()
            ->with('teamMembers') 
            ->orderBy(['sort_order' => SORT_ASC]) // 按 sort_order 升序排列
            ->all();

        return $this->render('index', [
            'departments' => $departments,
        ]);
    }

    /**
     * 成员详情页 (点击头像跳转)
     * @param int $id
     */
    public function actionView($id)
    {
        // 使用 TeamMember 模型查找
        $model = TeamMember::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('请求的成员不存在。');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}