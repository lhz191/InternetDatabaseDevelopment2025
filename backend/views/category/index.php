<?php
/**
 * 分类管理列表页 (View层)
 * @author 刘浩泽 (2212478)
 * @date 2025-12-18
 * @description 后台分类管理列表，支持搜索、状态筛选、排序
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e8e8e8;
    }
    
    .category-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }
    
    .category-stats {
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        flex: 1;
        background: white;
        border-radius: 8px;
        padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-left: 4px solid;
    }
    
    .stat-card.total { border-left-color: #1890ff; }
    .stat-card.active { border-left-color: #52c41a; }
    .stat-card.inactive { border-left-color: #faad14; }
    
    .stat-card h3 {
        font-size: 28px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0 0 4px;
    }
    
    .stat-card p {
        font-size: 14px;
        color: #666;
        margin: 0;
    }
    
    .filter-bar {
        background: white;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        gap: 16px;
        align-items: center;
    }
    
    .filter-bar .form-control {
        border-radius: 6px;
        border: 1px solid #d9d9d9;
        padding: 8px 12px;
    }
    
    .filter-bar .btn {
        border-radius: 6px;
        padding: 8px 16px;
    }
    
    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .table-container .table {
        margin-bottom: 0;
    }
    
    .table-container .table th {
        background: #fafafa;
        font-weight: 600;
        color: #1a1a1a;
        border-bottom: 1px solid #e8e8e8;
        padding: 14px 16px;
    }
    
    .table-container .table td {
        padding: 14px 16px;
        vertical-align: middle;
    }
    
    .table-container .table tbody tr:hover {
        background: #f5f7fa;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.active {
        background: #f6ffed;
        color: #52c41a;
        border: 1px solid #b7eb8f;
    }
    
    .status-badge.inactive {
        background: #fffbe6;
        color: #faad14;
        border: 1px solid #ffe58f;
    }
    
    .action-btns {
        display: flex;
        gap: 8px;
    }
    
    .action-btns .btn {
        padding: 4px 10px;
        font-size: 13px;
        border-radius: 4px;
    }
    
    .category-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, #8B0000, #B8860B);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        margin-right: 10px;
    }
    
    .category-name {
        display: flex;
        align-items: center;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #8B0000, #6B0000);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .btn-add:hover {
        background: linear-gradient(135deg, #6B0000, #4B0000);
        color: white;
    }
</style>

<div class="category-index">
    <!-- 页头 -->
    <div class="category-header">
        <h1><i class="glyphicon glyphicon-folder-open" style="color: #8B0000;"></i> <?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> 添加分类', ['create'], ['class' => 'btn btn-add']) ?>
    </div>
    
    <!-- 统计卡片 -->
    <?php
    $totalCount = count($dataProvider->getModels());
    $activeCount = 0;
    $inactiveCount = 0;
    foreach ($dataProvider->getModels() as $model) {
        if ($model->status == 1) $activeCount++;
        else $inactiveCount++;
    }
    ?>
    <div class="category-stats">
        <div class="stat-card total">
            <h3><?= $dataProvider->getTotalCount() ?></h3>
            <p>总分类数</p>
        </div>
        <div class="stat-card active">
            <h3><?= $activeCount ?></h3>
            <p>已启用</p>
        </div>
        <div class="stat-card inactive">
            <h3><?= $inactiveCount ?></h3>
            <p>已禁用</p>
        </div>
    </div>
    
    <!-- 分类列表 -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>分类名称</th>
                    <th>描述</th>
                    <th style="width: 100px;">排序</th>
                    <th style="width: 100px;">状态</th>
                    <th style="width: 160px;">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                <tr>
                    <td><?= $model->cid ?></td>
                    <td>
                        <div class="category-name">
                            <span class="category-icon">
                                <i class="glyphicon glyphicon-tag"></i>
                            </span>
                            <strong><?= Html::encode($model->name) ?></strong>
                        </div>
                    </td>
                    <td><?= Html::encode($model->description ?: '-') ?></td>
                    <td><?= $model->sort_order ?></td>
                    <td>
                        <span class="status-badge <?= $model->status == 1 ? 'active' : 'inactive' ?>">
                            <?= $model->getStatusText() ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <?= Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['view', 'cid' => $model->cid], ['class' => 'btn btn-default btn-sm', 'title' => '查看']) ?>
                            <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'cid' => $model->cid], ['class' => 'btn btn-primary btn-sm', 'title' => '编辑']) ?>
                            <?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'cid' => $model->cid], [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => '删除',
                                'data' => [
                                    'confirm' => '确定要删除这个分类吗？',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
