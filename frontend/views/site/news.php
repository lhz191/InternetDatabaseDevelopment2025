<?php
/**
 * 新闻列表页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 新闻列表页面，支持分类筛选
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $currentCategory ? $currentCategory->name : '新闻列表';

// 新闻图片列表
$newsImages = [
    'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=600',
    'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600',
    'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=600',
    'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600',
    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600',
    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600',
    'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=600',
    'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=600',
];
?>

<style>
    .page-header {
        height: 200px;
        background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
    }
    
    .page-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .page-header h1 {
        font-size: 36px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .page-header p {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    
    .filter-label {
        font-weight: 500;
        color: #333;
    }
    
    .filter-tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .filter-tag {
        padding: 6px 16px;
        background: #f5f5f5;
        border-radius: 16px;
        font-size: 14px;
        color: #666;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .filter-tag:hover {
        background: #e5e5e5;
        color: #333;
    }
    
    .filter-tag.active {
        background: #1a1a1a;
        color: white;
    }
    
    .results-info {
        margin-bottom: 24px;
        color: #666;
        font-size: 14px;
    }
    
    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 48px;
    }
    
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
    }
    
    .pagination a, .pagination span {
        display: block;
        padding: 10px 16px;
        background: white;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    
    .pagination a:hover {
        background: #f5f5f5;
    }
    
    .pagination .active span {
        background: #1a1a1a;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 18px;
        color: #999;
        font-weight: normal;
    }
</style>

<!-- 页面头部 -->
<div class="page-header">
    <div class="page-header-content">
        <h1><?= Html::encode($this->title) ?></h1>
        <p><?= $currentCategory ? Html::encode($currentCategory->description) : '浏览所有新闻资讯' ?></p>
    </div>
</div>

<div class="container">
    <!-- 分类筛选 -->
    <div class="filter-bar">
        <span class="filter-label">分类：</span>
        <div class="filter-tags">
            <a href="<?= Url::to(['/site/news']) ?>" class="filter-tag <?= !$currentCategory ? 'active' : '' ?>">
                全部
            </a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" 
                   class="filter-tag <?= ($currentCategory && $currentCategory->cid == $category->cid) ? 'active' : '' ?>">
                    <?= Html::encode($category->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- 结果统计 -->
    <div class="results-info">
        共找到 <strong><?= $dataProvider->getTotalCount() ?></strong> 条新闻
    </div>
    
    <!-- 新闻列表 -->
    <?php if ($dataProvider->getTotalCount() > 0): ?>
        <div class="news-grid">
            <?php foreach ($dataProvider->getModels() as $index => $article): ?>
                <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                    <div class="news-card-image" style="background-image: url('<?= $newsImages[$index % count($newsImages)] ?>')">
                        <span class="news-card-category">
                            <?= $article->category ? Html::encode($article->category->name) : '资讯' ?>
                        </span>
                    </div>
                    <div class="news-card-body">
                        <h3 class="news-card-title"><?= Html::encode($article->title) ?></h3>
                        <p class="news-card-summary">
                            <?= Html::encode(mb_substr(strip_tags($article->summary ?: $article->content), 0, 80)) ?>...
                        </p>
                        <div class="news-card-meta">
                            <div class="news-card-author">
                                <span class="author-avatar"><?= mb_substr($article->author ?: '编', 0, 1) ?></span>
                                <span><?= Html::encode($article->author ?: '编辑部') ?> · <?= date('m-d', strtotime($article->created_at)) ?></span>
                            </div>
                            <div class="news-card-stats">
                                <span><i class="far fa-eye"></i> <?= $article->views ?></span>
                                <span><i class="far fa-heart"></i> <?= $article->likes ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- 分页 -->
        <div class="pagination-wrap">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => 'pagination'],
            ]) ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <h3>暂无新闻内容</h3>
        </div>
    <?php endif; ?>
</div>
