<?php
/**
 * 文章详情页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 新闻文章详情页面，包含文章内容、评论展示、相关推荐
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $article->title;

// 随机图片
$headerImage = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400';
?>

<style>
    .article-header {
        height: 360px;
        background: url('<?= $headerImage ?>') center/cover;
        position: relative;
        display: flex;
        align-items: flex-end;
    }
    
    .article-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
    }
    
    .article-header-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        color: white;
        width: 100%;
    }
    
    .article-category-tag {
        display: inline-block;
        padding: 6px 16px;
        background: #e74c3c;
        border-radius: 4px;
        font-size: 13px;
        margin-bottom: 16px;
    }
    
    .article-title {
        font-size: 36px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 20px;
    }
    
    .article-meta-bar {
        display: flex;
        align-items: center;
        gap: 24px;
        font-size: 14px;
        opacity: 0.9;
    }
    
    .article-meta-bar span {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .article-container {
        max-width: 800px;
        margin: -60px auto 0;
        padding: 0 20px 60px;
        position: relative;
        z-index: 2;
    }
    
    .article-body {
        background: white;
        border-radius: 12px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 32px;
    }
    
    .article-content {
        font-size: 17px;
        line-height: 1.9;
        color: #333;
    }
    
    .article-content p {
        margin-bottom: 24px;
    }
    
    .article-content img {
        max-width: 100%;
        border-radius: 8px;
        margin: 24px 0;
    }
    
    .article-footer {
        padding-top: 32px;
        border-top: 1px solid #eee;
        margin-top: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .article-tags {
        display: flex;
        gap: 8px;
    }
    
    .article-tag {
        padding: 6px 14px;
        background: #f5f5f5;
        border-radius: 16px;
        font-size: 13px;
        color: #666;
        text-decoration: none;
    }
    
    .article-share {
        display: flex;
        gap: 12px;
    }
    
    .share-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .share-btn:hover {
        background: #1a1a1a;
        color: white;
    }
    
    /* 评论区 */
    .comments-section {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .comments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }
    
    .comments-title {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .comments-count {
        background: #e74c3c;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 13px;
    }
    
    .comment-item {
        padding: 24px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .comment-item:last-child {
        border-bottom: none;
    }
    
    .comment-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    
    .comment-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 500;
    }
    
    .comment-user-info {
        flex: 1;
    }
    
    .comment-username {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 15px;
    }
    
    .comment-time {
        font-size: 13px;
        color: #999;
        margin-top: 2px;
    }
    
    .comment-content {
        font-size: 15px;
        line-height: 1.7;
        color: #333;
        padding-left: 56px;
    }
    
    .comment-actions {
        padding-left: 56px;
        margin-top: 12px;
        display: flex;
        gap: 20px;
    }
    
    .comment-action {
        font-size: 13px;
        color: #999;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .comment-action:hover {
        color: #e74c3c;
    }
    
    .comment-action.liked {
        color: #e74c3c;
    }
    
    .no-comments {
        text-align: center;
        padding: 48px 20px;
        color: #999;
    }
    
    .no-comments i {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 16px;
    }
    
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 24px;
        transition: all 0.2s;
    }
    
    .back-btn:hover {
        background: #333;
        color: white;
    }
    
    /* 相关文章 */
    .related-section {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-top: 32px;
    }
    
    .related-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #1a1a1a;
    }
    
    .related-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .related-item {
        display: flex;
        gap: 16px;
        text-decoration: none;
        padding: 12px;
        border-radius: 8px;
        transition: background 0.2s;
    }
    
    .related-item:hover {
        background: #f9f9f9;
    }
    
    .related-thumb {
        width: 100px;
        height: 70px;
        border-radius: 6px;
        background-size: cover;
        background-position: center;
        flex-shrink: 0;
    }
    
    .related-info h4 {
        font-size: 15px;
        color: #1a1a1a;
        font-weight: 500;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    
    .related-info span {
        font-size: 13px;
        color: #999;
    }
    
    @media (max-width: 768px) {
        .article-title { font-size: 26px; }
        .article-body { padding: 24px; }
        .article-content { font-size: 16px; }
        .comment-content, .comment-actions { padding-left: 0; margin-top: 16px; }
    }
</style>

<!-- 文章头部 -->
<div class="article-header">
    <div class="article-header-content">
        <span class="article-category-tag">
            <?= $article->category ? Html::encode($article->category->name) : '资讯' ?>
        </span>
        <h1 class="article-title"><?= Html::encode($article->title) ?></h1>
        <div class="article-meta-bar">
            <span><i class="far fa-user"></i> <?= Html::encode($article->author ?: '编辑部') ?></span>
            <span><i class="far fa-clock"></i> <?= date('Y-m-d H:i', strtotime($article->created_at)) ?></span>
            <span><i class="far fa-eye"></i> <?= $article->views ?> 阅读</span>
            <span><i class="far fa-heart"></i> <?= $article->likes ?> 点赞</span>
        </div>
    </div>
</div>

<div class="article-container">
    <a href="<?= Url::to(['/site/news']) ?>" class="back-btn">
        <i class="fas fa-arrow-left"></i> 返回列表
    </a>
    
    <!-- 文章正文 -->
    <div class="article-body">
        <div class="article-content">
            <?= $article->content ?>
        </div>
        
        <div class="article-footer">
            <div class="article-tags">
                <span class="article-tag"><?= $article->category ? Html::encode($article->category->name) : '资讯' ?></span>
            </div>
            <div class="article-share">
                <a href="#" class="share-btn" title="分享到微博"><i class="fab fa-weibo"></i></a>
                <a href="#" class="share-btn" title="分享到微信"><i class="fab fa-weixin"></i></a>
                <a href="#" class="share-btn" title="复制链接"><i class="fas fa-link"></i></a>
            </div>
        </div>
    </div>
    
    <!-- 评论区 -->
    <div class="comments-section">
        <div class="comments-header">
            <h3 class="comments-title">
                <i class="fas fa-comments"></i> 评论
                <span class="comments-count"><?= count($comments) ?></span>
            </h3>
        </div>
        
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <div class="comment-avatar">
                            <?= $comment->user ? mb_substr($comment->user->username, 0, 1) : '?' ?>
                        </div>
                        <div class="comment-user-info">
                            <div class="comment-username">
                                <?= $comment->user ? Html::encode($comment->user->username) : '匿名用户' ?>
                            </div>
                            <div class="comment-time">
                                <?= date('Y-m-d H:i', strtotime($comment->created_at)) ?>
                            </div>
                        </div>
                    </div>
                    <div class="comment-content">
                        <?= Html::encode($comment->content) ?>
                    </div>
                    <div class="comment-actions">
                        <span class="comment-action">
                            <i class="far fa-heart"></i> <?= $comment->likes ?> 点赞
                        </span>
                        <span class="comment-action">
                            <i class="far fa-comment"></i> 回复
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-comments">
                <i class="far fa-comments"></i>
                <p>暂无评论，快来发表第一条评论吧！</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- 相关文章 -->
    <?php if (!empty($relatedArticles)): ?>
        <div class="related-section">
            <h3 class="related-title">相关推荐</h3>
            <div class="related-list">
                <?php 
                $relatedImages = [
                    'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=300',
                    'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=300',
                    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=300',
                ];
                foreach ($relatedArticles as $index => $related): 
                ?>
                    <a href="<?= Url::to(['/site/view', 'id' => $related->aid]) ?>" class="related-item">
                        <div class="related-thumb" style="background-image: url('<?= $relatedImages[$index % 3] ?>')"></div>
                        <div class="related-info">
                            <h4><?= Html::encode($related->title) ?></h4>
                            <span><?= date('Y-m-d', strtotime($related->created_at)) ?> · <?= $related->views ?> 阅读</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
