<?php
/**
 * 前台首页 (View层)
 * @author 团队
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '首页';
?>

<!-- Hero 区域 -->
<div class="hero">
    <h1>📰 新闻资讯网</h1>
    <p>获取最新、最热的新闻资讯，了解世界动态</p>
</div>

<!-- 新闻分类 -->
<div class="sidebar-section">
    <h3 class="sidebar-title">📁 新闻分类</h3>
    <div class="category-tags">
        <?php foreach ($categories as $category): ?>
            <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" class="category-tag">
                <?= Html::encode($category->name) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- 热门新闻 -->
<h2 style="margin: 30px 0 20px; font-size: 24px; color: #202124;">
    🔥 热门新闻
</h2>

<div class="news-grid">
    <?php foreach ($hotArticles as $article): ?>
        <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
            <div class="news-card-image">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="news-card-body">
                <span class="news-card-category">
                    <?= $article->category ? Html::encode($article->category->name) : '未分类' ?>
                </span>
                <h3 class="news-card-title"><?= Html::encode($article->title) ?></h3>
                <p class="news-card-summary">
                    <?= Html::encode(mb_substr(strip_tags($article->summary ?: $article->content), 0, 100)) ?>...
                </p>
                <div class="news-card-meta">
                    <span><?= Html::encode($article->author) ?> · <?= date('Y-m-d', strtotime($article->created_at)) ?></span>
                    <div class="news-card-stats">
                        <span><i class="fas fa-eye"></i> <?= $article->views ?></span>
                        <span><i class="fas fa-heart"></i> <?= $article->likes ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- 最新新闻 -->
<h2 style="margin: 40px 0 20px; font-size: 24px; color: #202124;">
    📰 最新新闻
</h2>

<div class="news-grid">
    <?php foreach ($latestArticles as $article): ?>
        <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
            <div class="news-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="news-card-body">
                <span class="news-card-category">
                    <?= $article->category ? Html::encode($article->category->name) : '未分类' ?>
                </span>
                <h3 class="news-card-title"><?= Html::encode($article->title) ?></h3>
                <p class="news-card-summary">
                    <?= Html::encode(mb_substr(strip_tags($article->summary ?: $article->content), 0, 100)) ?>...
                </p>
                <div class="news-card-meta">
                    <span><?= Html::encode($article->author) ?> · <?= date('Y-m-d', strtotime($article->created_at)) ?></span>
                    <div class="news-card-stats">
                        <span><i class="fas fa-eye"></i> <?= $article->views ?></span>
                        <span><i class="fas fa-heart"></i> <?= $article->likes ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
