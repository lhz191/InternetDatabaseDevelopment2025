<?php
/**
 * 文章列表页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 后台文章管理列表页面，支持搜索、筛选、排序、批量操作
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\PreNewsCategory;
use yii\helpers\ArrayHelper;

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;

// 统计数据
$totalArticles = \common\models\PreNewsArticle::find()->count();
$publishedCount = \common\models\PreNewsArticle::find()->where(['status' => 1])->count();
$draftCount = \common\models\PreNewsArticle::find()->where(['status' => 0])->count();
$totalViews = \common\models\PreNewsArticle::find()->sum('views') ?: 0;

// 新闻图片
$newsImages = [
    'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=300',
    'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=300',
    'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=300',
    'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=300',
    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=300',
    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=300',
];
?>

<style>
    .article-page {
        min-height: 100vh;
        background: #f0f2f5;
        margin: -20px;
        padding: 0;
    }
    
    .page-banner {
        height: 180px;
        background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
    }
    
    .banner-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .banner-content h1 {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .banner-content p {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .main-content {
        max-width: 1200px;
        margin: -40px auto 40px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    /* 统计卡片 */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
    }
    
    .stat-icon.blue { background: #1890ff; }
    .stat-icon.green { background: #52c41a; }
    .stat-icon.orange { background: #fa8c16; }
    .stat-icon.purple { background: #722ed1; }
    
    .stat-info h3 {
        font-size: 26px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0 0 4px 0;
    }
    
    .stat-info p {
        font-size: 14px;
        color: #8c8c8c;
        margin: 0;
    }
    
    /* 筛选栏 */
    .filter-bar {
        background: white;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }
    
    .filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-item label {
        font-size: 14px;
        color: #666;
        white-space: nowrap;
    }
    
    .filter-select {
        padding: 6px 12px;
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        font-size: 14px;
        min-width: 120px;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #1890ff;
    }
    
    /* 工具栏 */
    .toolbar {
        background: white;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #1890ff;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-create:hover {
        background: #40a9ff;
        color: white;
    }
    
    .batch-select {
        padding: 8px 12px;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
        font-size: 14px;
    }
    
    .btn-batch {
        padding: 8px 16px;
        background: #52c41a;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }
    
    .btn-batch:hover {
        background: #73d13d;
    }
    
    .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .search-input {
        padding: 8px 12px;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
        font-size: 14px;
        width: 200px;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #1890ff;
    }
    
    .btn-search {
        padding: 8px 16px;
        background: #1890ff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-search:hover {
        background: #40a9ff;
    }
    
    /* 文章列表 */
    .article-list {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .list-header {
        padding: 16px 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .list-header h2 {
        font-size: 16px;
        font-weight: 500;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .check-all {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .article-item {
        padding: 20px 24px;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        gap: 16px;
        transition: background 0.2s;
        align-items: flex-start;
    }
    
    .article-item:hover {
        background: #fafafa;
    }
    
    .article-item:last-child {
        border-bottom: none;
    }
    
    .item-checkbox {
        width: 18px;
        height: 18px;
        margin-top: 40px;
        cursor: pointer;
    }
    
    .article-thumb {
        width: 140px;
        height: 90px;
        border-radius: 8px;
        background-size: cover;
        background-position: center;
        flex-shrink: 0;
    }
    
    .article-info {
        flex: 1;
        min-width: 0;
    }
    
    .article-title {
        font-size: 16px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .article-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .article-title a:hover {
        color: #1890ff;
    }
    
    .badge {
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 3px;
    }
    
    .badge-top {
        background: #ff4d4f;
        color: white;
    }
    
    .badge-hot {
        background: #fa8c16;
        color: white;
    }
    
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
        color: #8c8c8c;
        margin-bottom: 8px;
    }
    
    .article-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .article-summary {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .article-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex-shrink: 0;
    }
    
    .btn-action {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
        white-space: nowrap;
    }
    
    .btn-view { background: #f5f5f5; color: #666; }
    .btn-view:hover { background: #e5e5e5; color: #333; }
    .btn-edit { background: #e6f7ff; color: #1890ff; }
    .btn-edit:hover { background: #1890ff; color: white; }
    .btn-top { background: #fff1f0; color: #ff4d4f; }
    .btn-top:hover { background: #ff4d4f; color: white; }
    .btn-top.active { background: #ff4d4f; color: white; }
    .btn-hot { background: #fff7e6; color: #fa8c16; }
    .btn-hot:hover { background: #fa8c16; color: white; }
    .btn-hot.active { background: #fa8c16; color: white; }
    .btn-delete { background: #f5f5f5; color: #999; }
    .btn-delete:hover { background: #ff4d4f; color: white; }
    
    .status-tag {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .status-published { background: #f6ffed; color: #52c41a; }
    .status-draft { background: #fff7e6; color: #fa8c16; }
    .status-offline { background: #f5f5f5; color: #8c8c8c; }
    
    .category-tag {
        display: inline-block;
        padding: 2px 8px;
        background: #f0f5ff;
        color: #2f54eb;
        border-radius: 4px;
        font-size: 12px;
    }
    
    /* 分页 */
    .pagination-wrap {
        padding: 20px 24px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .pagination a, .pagination span {
        padding: 8px 14px;
        background: #f5f5f5;
        border-radius: 4px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
    }
    
    .pagination a:hover { background: #e5e5e5; }
    .pagination .active span { background: #1890ff; color: white; }
    
    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #d9d9d9;
        margin-bottom: 16px;
    }
    
    .empty-state h3 {
        font-size: 16px;
        color: #8c8c8c;
        font-weight: normal;
    }
</style>

<div class="article-page">
    <!-- 页面横幅 -->
    <div class="page-banner">
        <div class="banner-content">
            <h1><i class="fas fa-newspaper"></i> 文章管理</h1>
            <p>管理新闻文章 · 发布资讯内容</p>
        </div>
    </div>
    
    <div class="main-content">
        <!-- 统计卡片 -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-file-alt"></i></div>
                <div class="stat-info">
                    <h3><?= $totalArticles ?></h3>
                    <p>全部文章</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?= $publishedCount ?></h3>
                    <p>已发布</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-edit"></i></div>
                <div class="stat-info">
                    <h3><?= $draftCount ?></h3>
                    <p>草稿箱</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-eye"></i></div>
                <div class="stat-info">
                    <h3><?= number_format($totalViews) ?></h3>
                    <p>总浏览量</p>
                </div>
            </div>
        </div>
        
        <!-- 筛选栏 -->
        <div class="filter-bar">
            <form action="" method="get" class="filter-row" id="filterForm">
                <input type="hidden" name="r" value="article/index">
                <div class="filter-item">
                    <label>分类：</label>
                    <select name="cid" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">全部分类</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->cid ?>" <?= $cid == $cat->cid ? 'selected' : '' ?>>
                                <?= Html::encode($cat->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-item">
                    <label>状态：</label>
                    <select name="status" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">全部状态</option>
                        <option value="1" <?= $status === '1' ? 'selected' : '' ?>>已发布</option>
                        <option value="0" <?= $status === '0' ? 'selected' : '' ?>>草稿</option>
                        <option value="2" <?= $status === '2' ? 'selected' : '' ?>>已下架</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>排序：</label>
                    <select name="sort" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="created_at" <?= $sort === 'created_at' ? 'selected' : '' ?>>最新发布</option>
                        <option value="views" <?= $sort === 'views' ? 'selected' : '' ?>>浏览最多</option>
                        <option value="likes" <?= $sort === 'likes' ? 'selected' : '' ?>>点赞最多</option>
                    </select>
                </div>
                <input type="hidden" name="keyword" value="<?= Html::encode($keyword) ?>">
            </form>
        </div>
        
        <!-- 工具栏 -->
        <div class="toolbar">
            <div class="toolbar-left">
                <a href="<?= Url::to(['create']) ?>" class="btn-create">
                    <i class="fas fa-plus"></i> 发布文章
                </a>
                <select id="batch-action" class="batch-select">
                    <option value="">批量操作</option>
                    <option value="top">设为置顶</option>
                    <option value="untop">取消置顶</option>
                    <option value="hot">设为热门</option>
                    <option value="unhot">取消热门</option>
                    <option value="publish">发布</option>
                    <option value="draft">转草稿</option>
                    <option value="delete">删除</option>
                </select>
                <button type="button" class="btn-batch" onclick="doBatchAction()">执行</button>
            </div>
            <form action="<?= Url::to(['index']) ?>" method="get" class="search-box">
                <input type="text" name="keyword" class="search-input" placeholder="搜索文章标题..." value="<?= Html::encode($keyword) ?>">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            </form>
        </div>
        
        <!-- 文章列表 -->
        <form id="batch-form" action="<?= Url::to(['batch-action']) ?>" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            <input type="hidden" name="action" id="batch-action-input" value="">
            
            <div class="article-list">
                <div class="list-header">
                    <h2>
                        <input type="checkbox" class="check-all" onclick="toggleAll(this)">
                        文章列表
                    </h2>
                    <span style="color: #8c8c8c; font-size: 14px;">共 <?= $dataProvider->getTotalCount() ?> 篇文章</span>
                </div>
                
                <?php if ($dataProvider->getTotalCount() > 0): ?>
                    <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                        <div class="article-item">
                            <input type="checkbox" name="ids[]" value="<?= $model->aid ?>" class="item-checkbox">
                            <div class="article-thumb" style="background-image: url('<?= $newsImages[$index % count($newsImages)] ?>')"></div>
                            <div class="article-info">
                                <h3 class="article-title">
                                    <a href="<?= Url::to(['view', 'aid' => $model->aid]) ?>">
                                        <?= Html::encode($model->title) ?>
                                    </a>
                                    <?php if ($model->is_top): ?>
                                        <span class="badge badge-top">置顶</span>
                                    <?php endif; ?>
                                    <?php if ($model->is_hot): ?>
                                        <span class="badge badge-hot">热门</span>
                                    <?php endif; ?>
                                </h3>
                                <div class="article-meta">
                                    <span class="category-tag">
                                        <?= $model->category ? Html::encode($model->category->name) : '未分类' ?>
                                    </span>
                                    <span><i class="far fa-user"></i> <?= Html::encode($model->author ?: '编辑') ?></span>
                                    <span><i class="far fa-clock"></i> <?= date('Y-m-d H:i', strtotime($model->created_at)) ?></span>
                                    <span><i class="far fa-eye"></i> <?= number_format($model->views) ?></span>
                                    <span><i class="far fa-heart"></i> <?= number_format($model->likes) ?></span>
                                    <?php
                                    $statusClass = ['status-draft', 'status-published', 'status-offline'];
                                    $statusText = ['草稿', '已发布', '已下架'];
                                    ?>
                                    <span class="status-tag <?= $statusClass[$model->status] ?>">
                                        <?= $statusText[$model->status] ?>
                                    </span>
                                </div>
                                <p class="article-summary">
                                    <?= Html::encode(mb_substr(strip_tags($model->summary ?: $model->content), 0, 100)) ?>...
                                </p>
                            </div>
                            <div class="article-actions">
                                <?= Html::a('<i class="fas fa-eye"></i>', ['view', 'aid' => $model->aid], ['class' => 'btn-action btn-view', 'title' => '查看']) ?>
                                <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'aid' => $model->aid], ['class' => 'btn-action btn-edit', 'title' => '编辑']) ?>
                                <?= Html::a($model->is_top ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>', ['toggle-top', 'aid' => $model->aid], [
                                    'class' => 'btn-action btn-top' . ($model->is_top ? ' active' : ''),
                                    'title' => $model->is_top ? '取消置顶' : '置顶',
                                    'data-method' => 'post'
                                ]) ?>
                                <?= Html::a($model->is_hot ? '<i class="fas fa-fire-alt"></i>' : '<i class="fas fa-fire"></i>', ['toggle-hot', 'aid' => $model->aid], [
                                    'class' => 'btn-action btn-hot' . ($model->is_hot ? ' active' : ''),
                                    'title' => $model->is_hot ? '取消热门' : '设为热门',
                                    'data-method' => 'post'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'aid' => $model->aid], [
                                    'class' => 'btn-action btn-delete',
                                    'title' => '删除',
                                    'data' => [
                                        'confirm' => '确定要删除这篇文章吗？',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="pagination-wrap">
                        <?= \yii\widgets\LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['class' => 'pagination'],
                        ]) ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>暂无文章，点击上方按钮发布第一篇文章</h3>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAll(checkbox) {
    var checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(function(cb) {
        cb.checked = checkbox.checked;
    });
}

function doBatchAction() {
    var action = document.getElementById('batch-action').value;
    if (!action) {
        alert('请选择批量操作');
        return;
    }
    
    var checkboxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('请选择要操作的文章');
        return;
    }
    
    if (action === 'delete') {
        if (!confirm('确定要删除选中的 ' + checkboxes.length + ' 篇文章吗？')) {
            return;
        }
    }
    
    document.getElementById('batch-action-input').value = action;
    document.getElementById('batch-form').submit();
}
</script>
