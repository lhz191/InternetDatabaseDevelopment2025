<?php
/**
 * 文章详情页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 后台文章详情展示页面
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '详情';
?>

<style>
    .detail-page {
        min-height: 100vh;
        background: #f0f2f5;
        margin: -20px;
        padding: 0;
    }
    
    .page-banner {
        height: 160px;
        background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400') center/cover;
        position: relative;
    }
    
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
    }
    
    .main-content {
        max-width: 900px;
        margin: -40px auto 40px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        position: relative;
        z-index: 3;
        margin-left: 20px;
        margin-top: -120px;
        margin-bottom: 80px;
    }
    
    .back-link:hover {
        color: white;
        opacity: 0.8;
    }
    
    .detail-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .card-header {
        padding: 24px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .article-title {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 16px;
        line-height: 1.4;
    }
    
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 14px;
        color: #8c8c8c;
    }
    
    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .category-tag {
        background: #f0f5ff;
        color: #2f54eb;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .status-tag {
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .status-published { background: #f6ffed; color: #52c41a; }
    .status-draft { background: #fff7e6; color: #fa8c16; }
    .status-offline { background: #f5f5f5; color: #8c8c8c; }
    
    .card-body {
        padding: 32px 24px;
    }
    
    .section {
        margin-bottom: 32px;
    }
    
    .section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        font-size: 15px;
        font-weight: 500;
        color: #8c8c8c;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .summary-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 16px;
        font-size: 15px;
        color: #666;
        line-height: 1.7;
    }
    
    .content-box {
        font-size: 16px;
        line-height: 1.8;
        color: #333;
    }
    
    .content-box p {
        margin-bottom: 16px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    
    .stat-item {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .stat-value.red { color: #ff4d4f; }
    .stat-value.blue { color: #1890ff; }
    
    .stat-label {
        font-size: 13px;
        color: #8c8c8c;
        margin-top: 4px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .info-item {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 16px;
    }
    
    .info-label {
        font-size: 13px;
        color: #8c8c8c;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 15px;
        color: #1a1a1a;
    }
    
    .card-footer {
        padding: 20px 24px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        gap: 12px;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background: #1890ff;
        color: white;
    }
    
    .btn-primary:hover {
        background: #40a9ff;
        color: white;
    }
    
    .btn-edit {
        background: #f5f5f5;
        color: #666;
    }
    
    .btn-edit:hover {
        background: #e5e5e5;
        color: #333;
    }
    
    .btn-danger {
        background: white;
        color: #ff4d4f;
        border: 1px solid #ff4d4f;
    }
    
    .btn-danger:hover {
        background: #ff4d4f;
        color: white;
    }
</style>

<div class="detail-page">
    <div class="page-banner"></div>
    
    <a href="<?= Url::to(['index']) ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> 返回文章列表
    </a>
    
    <div class="main-content">
        <div class="detail-card">
            <div class="card-header">
                <h1 class="article-title"><?= Html::encode($model->title) ?></h1>
                <div class="article-meta">
                    <span class="category-tag">
                        <?= $model->category ? Html::encode($model->category->name) : '未分类' ?>
                    </span>
                    <span><i class="far fa-user"></i> <?= Html::encode($model->author ?: '管理员') ?></span>
                    <span><i class="far fa-clock"></i> <?= date('Y-m-d H:i', strtotime($model->created_at)) ?></span>
                    <?php
                    $statusClass = ['status-draft', 'status-published', 'status-offline'];
                    $statusText = ['草稿', '已发布', '已下架'];
                    ?>
                    <span class="status-tag <?= $statusClass[$model->status] ?>">
                        <?= $statusText[$model->status] ?>
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <!-- 统计数据 -->
                <div class="section">
                    <div class="section-title"><i class="fas fa-chart-bar"></i> 数据统计</div>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value blue"><?= $model->views ?></div>
                            <div class="stat-label">浏览量</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value red"><?= $model->likes ?></div>
                            <div class="stat-label">点赞数</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= $model->is_top ? '是' : '否' ?></div>
                            <div class="stat-label">置顶</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?= $model->is_hot ? '是' : '否' ?></div>
                            <div class="stat-label">热门</div>
                        </div>
                    </div>
                </div>
                
                <!-- 文章摘要 -->
                <?php if ($model->summary): ?>
                <div class="section">
                    <div class="section-title"><i class="fas fa-align-left"></i> 文章摘要</div>
                    <div class="summary-box">
                        <?= Html::encode($model->summary) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- 文章内容 -->
                <div class="section">
                    <div class="section-title"><i class="fas fa-file-alt"></i> 文章内容</div>
                    <div class="content-box">
                        <?= $model->content ?>
                    </div>
                </div>
                
                <!-- 其他信息 -->
                <div class="section">
                    <div class="section-title"><i class="fas fa-info-circle"></i> 其他信息</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">文章ID</div>
                            <div class="info-value">#<?= $model->aid ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">来源</div>
                            <div class="info-value"><?= Html::encode($model->source ?: '原创') ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">创建时间</div>
                            <div class="info-value"><?= $model->created_at ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">更新时间</div>
                            <div class="info-value"><?= $model->updated_at ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <a href="<?= Url::to(['index']) ?>" class="btn btn-primary">
                    <i class="fas fa-list"></i> 返回列表
                </a>
                <?= Html::a('<i class="fas fa-edit"></i> 编辑', ['update', 'aid' => $model->aid], ['class' => 'btn btn-edit']) ?>
                <?= Html::a('<i class="fas fa-trash"></i> 删除', ['delete', 'aid' => $model->aid], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '确定要删除这篇文章吗？',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
