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

// 抗战主题图片 - 使用稳定图片源
$warImages = [
    'https://picsum.photos/seed/war1/600/400',
    'https://picsum.photos/seed/war2/600/400',
    'https://picsum.photos/seed/war3/600/400',
    'https://picsum.photos/seed/war4/600/400',
    'https://picsum.photos/seed/war5/600/400',
    'https://picsum.photos/seed/war6/600/400',
    'https://picsum.photos/seed/war7/600/400',
    'https://picsum.photos/seed/war8/600/400',
];
?>

<!-- Hero 大图 - 抗战主题 -->
<div class="hero-banner" style="background: linear-gradient(135deg, #8B0000 0%, #4a0000 50%, #2d0000 100%);">
    <div class="hero-content">
        <h1>铭记历史 珍爱和平</h1>
        <p>纪念中国人民抗日战争暨世界反法西斯战争胜利80周年</p>
    </div>
    <div class="hero-year">1945-2025</div>
</div>

<div class="container">
    <!-- 纪念标语 -->
    <div style="text-align: center; padding: 30px 0; margin-bottom: 20px;">
        <p style="font-size: 18px; color: #8B0000; font-weight: 500; letter-spacing: 2px;">
            <i class="fas fa-star" style="color: #FFD700;"></i>
            勿忘国耻 · 振兴中华 · 缅怀先烈 · 开创未来
            <i class="fas fa-star" style="color: #FFD700;"></i>
        </p>
    </div>

    <!-- 分类导航 -->
    <div class="category-section">
        <div class="category-tags">
            <a href="<?= Url::to(['/site/news']) ?>" class="category-tag active">全部专题</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" class="category-tag">
                    <?= Html::encode($category->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- 热门文章 -->
    <div class="section-header">
        <h2 class="section-title">热门专题</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($hotArticles as $index => $article): ?>
            <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                <div class="news-card-image" style="background-image: url('<?= $warImages[$index % count($warImages)] ?>')">
                    <span class="news-card-category">
                        <?= $article->category ? Html::encode($article->category->name) : '历史' ?>
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
    
    <!-- 最新发布 -->
    <div class="section-header" style="margin-top: 60px;">
        <h2 class="section-title">最新发布</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($latestArticles as $index => $article): ?>
            <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                <div class="news-card-image" style="background-image: url('<?= $warImages[($index + 3) % count($warImages)] ?>')">
                    <span class="news-card-category">
                        <?= $article->category ? Html::encode($article->category->name) : '历史' ?>
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
