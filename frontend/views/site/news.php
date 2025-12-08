<?php
/**
 * 新闻列表页 (View层)
 * @author 团队
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $currentCategory ? $currentCategory->name : '新闻列表';
?>

<!-- 页面标题 -->
<div class="hero" style="padding: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <h1>📰 <?= Html::encode($this->title) ?></h1>
    <p><?= $currentCategory ? Html::encode($currentCategory->description) : '浏览所有新闻资讯' ?></p>
</div>

<!-- 分类筛选 -->
<div class="sidebar-section">
    <h3 class="sidebar-title">📁 分类筛选</h3>
    <div class="category-tags">
        <a href="<?= Url::to(['/site/news']) ?>" class="category-tag <?= !$currentCategory ? 'active' : '' ?>" 
           style="<?= !$currentCategory ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' : '' ?>">
            全部
        </a>
        <?php foreach ($categories as $category): ?>
            <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" 
               class="category-tag"
               style="<?= ($currentCategory && $currentCategory->cid == $category->cid) ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' : '' ?>">
                <?= Html::encode($category->name) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- 新闻列表 -->
<div class="news-grid">
    <?php foreach ($dataProvider->getModels() as $article): ?>
        <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
            <div class="news-card-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
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

<?php if (empty($dataProvider->getModels())): ?>
    <div style="text-align: center; padding: 60px; background: white; border-radius: 16px; margin-top: 20px;">
        <i class="fas fa-inbox" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
        <p style="color: #999; font-size: 16px;">暂无新闻内容</p>
    </div>
<?php endif; ?>

<!-- 分页 -->
<div style="margin-top: 40px; display: flex; justify-content: center;">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['style' => 'padding: 10px 15px; margin: 0 5px; background: white; border-radius: 8px; text-decoration: none; color: #333;'],
        'activePageCssClass' => 'active',
    ]) ?>
</div>

