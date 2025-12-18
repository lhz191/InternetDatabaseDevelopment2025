<?php
/**
 * 前台主布局文件 (View层)
 * * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 前台网站主布局，包含导航、页脚等公共部分
 */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

// --- 【新增 1】 引入模型类 
use common\models\Link;
use common\models\Tag;
use common\models\VisitLog;

AppAsset::register($this);

// --- 【新增 2】 自动记录访问日志 ---
try {
    $log = new VisitLog();
    $log->page_url = Yii::$app->request->absoluteUrl;
    $log->ip_address = Yii::$app->request->userIP;
    $log->user_agent = Yii::$app->request->userAgent;
    // visit_time 数据库通常有默认值 CURRENT_TIMESTAMP
    $log->save();
} catch (\Exception $e) {
    // 忽略日志错误，不影响页面显示
}

// --- 【新增 3】 获取标签和链接数据 ---
$hotTags = [];
$friendLinks = [];
try {
    // 获取前10个热门标签
    $hotTags = Tag::find()->orderBy(['frequency' => SORT_DESC])->limit(10)->all();
    // 获取所有友情链接
    $friendLinks = Link::find()->orderBy(['sort_order' => SORT_ASC])->all();
} catch (\Exception $e) {
    // 忽略数据库错误（防止表还没建好时报错）
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - 新闻资讯网</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php $this->head() ?>
    <style>
        /* ================== 原有 CSS 样式 (保持不变) ================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans SC', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            color: #333;
        }
        
        /* 顶部导航 */
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 60px;
        }
        
        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            color: #e74c3c;
        }
        
        .nav-links {
            display: flex;
            gap: 8px;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #666;
            font-size: 15px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        
        .nav-links a:hover {
            background: #f5f5f5;
            color: #1a1a1a;
        }
        
        .nav-links a.active {
            background: #1a1a1a;
            color: white;
        }
        
        /* 主内容区 */
        .main-content {
            margin-top: 60px;
            min-height: calc(100vh - 200px);
        }
        
        /* Hero 大图区域 */
        .hero-banner {
            height: 400px;
            background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400') center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 0 20px;
        }
        
        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 16px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-content p {
            font-size: 20px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* 内容容器 */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        /* 区块标题 */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: #e74c3c;
            border-radius: 2px;
        }
        
        .view-all {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .view-all:hover {
            color: #e74c3c;
        }
        
        /* 新闻卡片网格 */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        
        @media (max-width: 900px) {
            .news-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 600px) {
            .news-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .news-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
        
        .news-card-image {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .news-card-category {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 12px;
            background: #e74c3c;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .news-card-body {
            padding: 20px;
        }
        
        .news-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .news-card-summary {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .news-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #999;
        }
        
        .news-card-author {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .author-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
        }
        
        .news-card-stats {
            display: flex;
            gap: 12px;
        }
        
        .news-card-stats span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* 分类标签 */
        .category-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .category-tag {
            padding: 8px 20px;
            background: #f5f5f5;
            border-radius: 20px;
            font-size: 14px;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .category-tag:hover, .category-tag.active {
            background: #1a1a1a;
            color: white;
        }
        
        /* 页脚 */
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 48px 20px 24px;
            margin-top: 60px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .footer-brand h3 {
            font-size: 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-brand h3 i {
            color: #e74c3c;
        }
        
        .footer-brand p {
            color: #999;
            line-height: 1.8;
            font-size: 14px;
        }
        
        .footer-column h4 {
            font-size: 16px;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column li {
            margin-bottom: 12px;
        }
        
        .footer-column a {
            color: #999;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        
        .footer-column a:hover {
            color: white;
        }
        
        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid #333;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        /* 响应式 */
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 32px; }
            .nav-links { display: none; }
            .hero-banner { height: 300px; }
        }

        /* --- 【新增 4】 仅追加了标签云的样式，不影响其他布局 --- */
        .tag-cloud { display: flex; flex-wrap: wrap; gap: 8px; }
        .footer-tag { 
            background: #333; 
            color: #ccc; 
            padding: 4px 10px; 
            border-radius: 4px; 
            font-size: 12px; 
            text-decoration: none; 
            transition: 0.2s; 
            display: inline-block;
        }
        .footer-tag:hover { background: #e74c3c; color: white; }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar">
    <div class="navbar-container">
        <a href="<?= Url::to(['/site/index']) ?>" class="logo">
            <i class="fas fa-newspaper"></i> 新闻资讯
        </a>
        <ul class="nav-links">
            <li><a href="<?= Url::to(['/site/index']) ?>" class="<?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">首页</a></li>
            <li><a href="<?= Url::to(['/site/news']) ?>" class="<?= Yii::$app->controller->action->id == 'news' ? 'active' : '' ?>">新闻</a></li>
            <li><a href="<?= Url::to(['/team/index']) ?>" class="<?= Yii::$app->controller->id == 'team' ? 'active' : '' ?>">团队介绍</a></li>
            <li><a href="<?= Url::to(['/guestbook/index']) ?>" class="<?= Yii::$app->controller->id == 'guestbook' ? 'active' : '' ?>">留言板</a></li>
            <li><a href="<?= Url::to(['/site/about']) ?>" class="<?= Yii::$app->controller->action->id == 'about' ? 'active' : '' ?>">关于</a></li>
            <li><a href="<?= Url::to(['/site/contact']) ?>" class="<?= Yii::$app->controller->action->id == 'contact' ? 'active' : '' ?>">联系</a></li>
        </ul>
    </div>
</nav>

<main class="main-content">
    <?= $content ?>
</main>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3><i class="fas fa-newspaper"></i> 新闻资讯</h3>
                <p>南开大学互联网数据库课程设计项目<br>基于 Yii2 框架开发的新闻资讯管理系统</p>
                <p style="font-size: 12px; color: #666; margin-top: 10px;">
                    <i class="fas fa-eye"></i> 今日访问IP: <?= Html::encode(Yii::$app->request->userIP) ?>
                </p>
            </div>
            
            <div class="footer-column">
                <h4>快速导航</h4>
                <ul>
                    <li><a href="<?= Url::to(['/site/index']) ?>">首页</a></li>
                    <li><a href="<?= Url::to(['/site/news']) ?>">新闻列表</a></li>
                    <li><a href="<?= Url::to(['/team/index']) ?>">团队介绍</a></li>
                    <li><a href="<?= Url::to(['/site/about']) ?>">关于</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>热门标签</h4>
                <?php if (!empty($hotTags)): ?>
                    <div class="tag-cloud">
                        <?php foreach ($hotTags as $tag): ?>
                            <a href="<?= Url::to(['/site/news', 'tag' => $tag->name]) ?>" class="footer-tag">#<?= Html::encode($tag->name) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: #666; font-size: 13px;">暂无标签</p>
                <?php endif; ?>
            </div>
            
            <div class="footer-column">
                <h4>友情链接</h4>
                <ul>
                    <?php if (!empty($friendLinks)): ?>
                        <?php foreach ($friendLinks as $link): ?>
                            <li>
                                <a href="<?= Html::encode($link->url) ?>" target="_blank">
                                    <i class="fas fa-link"></i> <?= Html::encode($link->name) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a href="#">南开大学</a></li>
                        <li><a href="#">计算机学院</a></li>
                    <?php endif; ?>
                </ul>
            </div>           
        </div>
        <div class="footer-bottom">
            © 2025 新闻资讯管理系统 · 南开大学 · Powered by Yii2
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>