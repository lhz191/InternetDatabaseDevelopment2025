<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
// 注意：如果你没有重命名模型，Gii生成的默认类名可能是 PreTeamDepartment
// 请检查 common/models/ 下的文件名。如果是 PreTeamDepartment.php，请使用下面的 use 语句：
use common\models\TeamDepartment; 
use common\models\TeamMember;
// 如果你已经重命名为 TeamDepartment，则使用：use common\models\TeamDepartment;

class TeamController extends Controller
{
    public function actionIndex()
    {
        // 获取所有部门及其成员
        // 这里的 PreTeamDepartment 类名要和你上方 use 的一致
        $departments = TeamDepartment::find()
            ->with('teamMembers') // 这里关联方法名通常是 'preTeamMembers' (取决于Gii生成), 请检查 Model 文件
            ->orderBy('sort_order')
            ->all();

        return $this->render('index', [
            'departments' => $departments,
        ]);
    }
}