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

// 抗战主题 - 使用渐变背景
$headerGradient = 'linear-gradient(135deg, #8B0000 0%, #4a0000 50%, #2d0000 100%)';
?>

<style>
    .article-header {
        height: 360px;
        background: <?= $headerGradient ?>;
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
        background: linear-gradient(to top, rgba(139,0,0,0.85) 0%, rgba(0,0,0,0.3) 100%);
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
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #FFD700;
        border-radius: 4px;
        font-size: 13px;
        margin-bottom: 16px;
        font-weight: 600;
        letter-spacing: 1px;
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
    }
    
    /* 发表评论表单 */
    .comment-form-wrap {
        display: flex;
        gap: 16px;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 24px;
    }
    
    .comment-form-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8B0000, #B8860B);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .comment-form-box {
        flex: 1;
    }
    
    .comment-input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 15px;
        resize: none;
        transition: all 0.2s;
        font-family: inherit;
    }
    
    .comment-input:focus {
        outline: none;
        border-color: #8B0000;
        box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
    }
    
    .comment-form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
    }
    
    .comment-tip {
        font-size: 13px;
        color: #999;
    }
    
    .comment-submit-btn {
        padding: 10px 24px;
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #FFD700;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    
    .comment-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.3);
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
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #FFD700;
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
        color: #8B0000;
    }
    
    .comment-action.liked {
        color: #8B0000;
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
        
        <!-- 发表评论 -->
        <div class="comment-form-wrap">
            <div class="comment-form-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="comment-form-box">
                <textarea class="comment-input" id="commentInput" placeholder="说说你的看法..." rows="3"></textarea>
                <div class="comment-form-footer">
                    <span class="comment-tip">请文明发言，理性讨论</span>
                    <button class="comment-submit-btn" onclick="submitComment()">
                        <i class="fas fa-paper-plane"></i> 发表评论
                    </button>
                </div>
            </div>
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

<!-- 阅读进度条 -->
<div class="reading-progress" id="readingProgress"></div>

<!-- 侧边工具栏 -->
<div class="side-tools">
    <button class="tool-btn like-btn <?= in_array($article->aid, Yii::$app->session->get('liked_articles', [])) ? 'liked' : '' ?>" 
            onclick="likeArticle(<?= $article->aid ?>)" title="点赞">
        <i class="fas fa-heart"></i>
        <span id="likeCount"><?= $article->likes ?></span>
    </button>
    <button class="tool-btn" onclick="shareArticle()" title="分享">
        <i class="fas fa-share-alt"></i>
    </button>
    <button class="tool-btn back-top" onclick="scrollToTop()" title="返回顶部">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>

<!-- 分享弹窗 -->
<div class="share-modal" id="shareModal">
    <div class="share-content">
        <h4>分享文章</h4>
        <div class="share-links">
            <a href="javascript:void(0)" onclick="shareToWeibo()" class="share-item weibo">
                <i class="fab fa-weibo"></i> 微博
            </a>
            <a href="javascript:void(0)" onclick="copyLink()" class="share-item copy">
                <i class="fas fa-link"></i> 复制链接
            </a>
        </div>
        <button class="close-modal" onclick="closeShareModal()">关闭</button>
    </div>
</div>

<style>
/* 阅读进度条 */
.reading-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #8B0000, #FFD700);
    z-index: 9999;
    transition: width 0.1s;
}

/* 侧边工具栏 */
.side-tools {
    position: fixed;
    right: 30px;
    bottom: 100px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 100;
}

.tool-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background: white;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #666;
    transition: all 0.3s;
}

.tool-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.tool-btn span {
    font-size: 11px;
    margin-top: 2px;
}

.like-btn:hover, .like-btn.liked {
    color: #8B0000;
    background: #fff5f5;
}

.like-btn.liked i {
    animation: heartBeat 0.5s;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.3); }
}

.back-top {
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.back-top.show {
    opacity: 1;
    visibility: visible;
}

/* 分享弹窗 */
.share-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0,0,0,0.5);
    display: none;
    z-index: 9999;
}

.share-modal.show {
    display: block;
}

.share-content {
    background: white;
    border-radius: 12px;
    padding: 24px;
    width: 320px;
    text-align: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10000;
}

.share-content h4 {
    margin: 0 0 20px;
    font-size: 18px;
    color: #333;
}

.share-links {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 20px;
}

.share-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.2s;
}

.share-item.weibo {
    background: linear-gradient(135deg, #8B0000, #6B0000);
    color: #FFD700;
}

.share-item.copy {
    background: linear-gradient(135deg, #B8860B, #8B6914);
    color: white;
}

.share-item i {
    font-size: 24px;
}

.share-item:hover {
    transform: scale(1.05);
}

.close-modal {
    padding: 10px 30px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 6px;
    cursor: pointer;
}

.close-modal:hover {
    background: #f5f5f5;
}

@media (max-width: 768px) {
    .side-tools {
        right: 15px;
        bottom: 80px;
    }
    
    .tool-btn {
        width: 44px;
        height: 44px;
        font-size: 16px;
    }
}
</style>

<script>
// 阅读进度条
window.addEventListener('scroll', function() {
    var scrollTop = window.scrollY;
    var docHeight = document.documentElement.scrollHeight - window.innerHeight;
    var progress = (scrollTop / docHeight) * 100;
    document.getElementById('readingProgress').style.width = progress + '%';
    
    // 返回顶部按钮显示/隐藏
    var backTopBtn = document.querySelector('.back-top');
    if (scrollTop > 300) {
        backTopBtn.classList.add('show');
    } else {
        backTopBtn.classList.remove('show');
    }
});

// 点赞功能
function likeArticle(aid) {
    var btn = document.querySelector('.like-btn');
    if (btn.classList.contains('liked')) {
        return; // 已点赞直接返回，不弹窗打扰用户
    }
    
    // 使用绝对路径
    var baseUrl = window.location.pathname.replace(/\/index\.php.*/, '/index.php');
    var url = baseUrl + '?r=site/like&id=' + aid;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.classList.add('liked');
            document.getElementById('likeCount').textContent = data.likes;
            btn.style.transform = 'scale(1.2)';
            setTimeout(() => { btn.style.transform = 'scale(1)'; }, 200);
        } else {
            // 已点赞的情况不弹窗
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// 返回顶部
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// 分享功能
function shareArticle() {
    document.getElementById('shareModal').classList.add('show');
}

function closeShareModal() {
    document.getElementById('shareModal').classList.remove('show');
}

function shareToWeibo() {
    var url = encodeURIComponent(window.location.href);
    var title = encodeURIComponent(document.title);
    window.open('https://service.weibo.com/share/share.php?url=' + url + '&title=' + title, '_blank');
    closeShareModal();
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('链接已复制到剪贴板');
        closeShareModal();
    });
}

// 提交评论（UI演示，实际提交由评论模块实现）
function submitComment() {
    var content = document.getElementById('commentInput').value.trim();
    
    if (!content) {
        alert('请输入评论内容');
        return;
    }
    
    // 获取 CSRF Token (Yii2 安全机制必须)
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // 构建提交数据
    var formData = new FormData();
    formData.append('article_id', <?= $article->aid ?>); // 注入文章ID
    formData.append('content', content);

    // 发送请求 (假设后端路由为 site/comment)
    fetch('<?= Url::to(['site/comment']) ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-Token': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('评论发表成功！');
            document.getElementById('commentInput').value = ''; // 清空输入框
            location.reload(); // 简单处理：刷新页面显示新评论
        } else {
            alert(data.message || '评论失败');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('网络错误，请稍后重试');
    });
}
</script>
