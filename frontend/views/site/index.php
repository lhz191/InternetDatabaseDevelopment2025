<?php
/**
 * 前台首页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 网站首页，展示热门新闻和最新新闻，支持分类导航
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '首页';

// 新闻图片列表
$newsImages = [
    'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=600',
    'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600',
    'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=600',
    'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600',
    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600',
    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600',
];
?>

<!-- Hero 大图 -->
<div class="hero-banner">
    <div class="hero-content">
        <h1>新闻资讯</h1>
        <p>获取最新、最热的新闻资讯，了解世界动态</p>
    </div>
</div>

<div class="container">
    <!-- 分类导航 -->
    <div class="category-section">
        <div class="category-tags">
            <a href="<?= Url::to(['/site/news']) ?>" class="category-tag active">全部</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" class="category-tag">
                    <?= Html::encode($category->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- 热门新闻 -->
    <div class="section-header">
        <h2 class="section-title">热门新闻</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($hotArticles as $index => $article): ?>
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
                            <span><?= Html::encode($article->author ?: '编辑部') ?></span>
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
    
    <!-- 最新新闻 -->
    <div class="section-header" style="margin-top: 60px;">
        <h2 class="section-title">最新发布</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($latestArticles as $index => $article): ?>
            <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                <div class="news-card-image" style="background-image: url('<?= $newsImages[($index + 3) % count($newsImages)] ?>')">
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
                            <span><?= Html::encode($article->author ?: '编辑部') ?></span>
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
</div>
