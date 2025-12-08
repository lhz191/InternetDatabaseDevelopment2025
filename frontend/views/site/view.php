<?php
/**
 * 文章详情页 (View层)
 * @author 团队
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $article->title;
?>

<style>
    .article-container {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 30px;
    }
    
    @media (max-width: 900px) {
        .article-container {
            grid-template-columns: 1fr;
        }
    }
    
    .article-main {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .article-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .article-category {
        display: inline-block;
        padding: 5px 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        font-size: 13px;
        margin-bottom: 15px;
    }
    
    .article-title {
        font-size: 32px;
        font-weight: 700;
        color: #202124;
        line-height: 1.4;
        margin-bottom: 20px;
    }
    
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: #666;
        font-size: 14px;
    }
    
    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .article-content {
        font-size: 16px;
        line-height: 1.8;
        color: #333;
    }
    
    .article-content p {
        margin-bottom: 20px;
    }
    
    .article-sidebar .sidebar-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .related-item {
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .related-item:last-child {
        border-bottom: none;
    }
    
    .related-item a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .related-item a:hover {
        color: #667eea;
    }
    
    .comment-item {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }
    
    .comment-user {
        font-weight: 600;
        color: #333;
    }
    
    .comment-time {
        color: #999;
        font-size: 13px;
    }
    
    .comment-content {
        margin-top: 10px;
        color: #555;
        line-height: 1.6;
    }
</style>

<div class="article-container">
    <!-- 文章主体 -->
    <div class="article-main">
        <div class="article-header">
            <span class="article-category">
                <?= $article->category ? Html::encode($article->category->name) : '未分类' ?>
            </span>
            <h1 class="article-title"><?= Html::encode($article->title) ?></h1>
            <div class="article-meta">
                <span><i class="fas fa-user"></i> <?= Html::encode($article->author) ?></span>
                <span><i class="fas fa-clock"></i> <?= date('Y-m-d H:i', strtotime($article->created_at)) ?></span>
                <span><i class="fas fa-eye"></i> <?= $article->views ?> 阅读</span>
                <span><i class="fas fa-heart"></i> <?= $article->likes ?> 点赞</span>
                <?php if ($article->source): ?>
                    <span><i class="fas fa-link"></i> 来源: <?= Html::encode($article->source) ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="article-content">
            <?= $article->content ?>
        </div>

        <!-- 评论区 -->
        <div style="margin-top: 50px; padding-top: 30px; border-top: 2px solid #eee;">
            <h3 style="font-size: 20px; margin-bottom: 20px;">
                <i class="fas fa-comments"></i> 评论 (<?= count($comments) ?>)
            </h3>
            
            <?php if (empty($comments)): ?>
                <p style="color: #999; text-align: center; padding: 30px;">暂无评论</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div>
                            <span class="comment-user">
                                <?= $comment->user ? Html::encode($comment->user->username) : '匿名用户' ?>
                            </span>
                            <span class="comment-time">
                                · <?= date('Y-m-d H:i', strtotime($comment->created_at)) ?>
                            </span>
                        </div>
                        <div class="comment-content">
                            <?= Html::encode($comment->content) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 侧边栏 -->
    <div class="article-sidebar">
        <!-- 相关文章 -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">📰 相关文章</h3>
            <?php if (empty($relatedArticles)): ?>
                <p style="color: #999;">暂无相关文章</p>
            <?php else: ?>
                <?php foreach ($relatedArticles as $related): ?>
                    <div class="related-item">
                        <a href="<?= Url::to(['/site/view', 'id' => $related->aid]) ?>">
                            <?= Html::encode($related->title) ?>
                        </a>
                        <div style="font-size: 12px; color: #999; margin-top: 5px;">
                            <?= date('Y-m-d', strtotime($related->created_at)) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- 返回按钮 -->
        <div class="sidebar-section" style="text-align: center;">
            <a href="<?= Url::to(['/site/news']) ?>" 
               style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 25px; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> 返回列表
            </a>
        </div>
    </div>
</div>

