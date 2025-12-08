<?php
/**
 * 前台主布局文件
 * @author 团队
 * @date 2025-12-08
 */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
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
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --dark-color: #202124;
            --light-color: #f8f9fa;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans SC', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        /* 导航栏 */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 15px 0;
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
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-1);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        /* 主要内容区 */
        .main-content {
            margin-top: 80px;
            padding: 40px 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Hero区域 */
        .hero {
            background: var(--gradient-1);
            border-radius: 20px;
            padding: 60px 40px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .hero p {
            font-size: 18px;
            opacity: 0.9;
            position: relative;
        }
        
        /* 新闻卡片 */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .news-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .news-card-image {
            height: 200px;
            background: var(--gradient-3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
        }
        
        .news-card-body {
            padding: 25px;
        }
        
        .news-card-category {
            display: inline-block;
            padding: 5px 12px;
            background: var(--gradient-1);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 12px;
        }
        
        .news-card-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 12px;
            line-height: 1.4;
        }
        
        .news-card-summary {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .news-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #999;
            font-size: 13px;
        }
        
        .news-card-stats {
            display: flex;
            gap: 15px;
        }
        
        .news-card-stats span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        /* 侧边栏 */
        .sidebar-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
            position: relative;
        }
        
        .sidebar-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--gradient-1);
        }
        
        /* 分类标签 */
        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .category-tag {
            padding: 8px 16px;
            background: var(--light-color);
            border-radius: 20px;
            font-size: 14px;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .category-tag:hover {
            background: var(--gradient-1);
            color: white;
        }
        
        /* 页脚 */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 40px 20px;
            text-align: center;
            margin-top: 60px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-copyright {
            color: rgba(255,255,255,0.5);
            font-size: 14px;
        }
        
        /* 响应式 */
        @media (max-width: 768px) {
            .hero h1 { font-size: 28px; }
            .news-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<!-- 导航栏 -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="<?= Url::to(['/site/index']) ?>" class="logo">
            <i class="fas fa-newspaper"></i> 新闻资讯网
        </a>
        <ul class="nav-links">
            <li><a href="<?= Url::to(['/site/index']) ?>"><i class="fas fa-home"></i> 首页</a></li>
            <li><a href="<?= Url::to(['/site/news']) ?>"><i class="fas fa-list"></i> 新闻列表</a></li>
            <li><a href="<?= Url::to(['/site/about']) ?>"><i class="fas fa-info-circle"></i> 关于我们</a></li>
            <li><a href="<?= Url::to(['/site/contact']) ?>"><i class="fas fa-envelope"></i> 联系我们</a></li>
        </ul>
    </div>
</nav>

<!-- 主要内容 -->
<main class="main-content">
    <?= $content ?>
</main>

<!-- 页脚 -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="<?= Url::to(['/site/index']) ?>">首页</a>
            <a href="<?= Url::to(['/site/about']) ?>">关于我们</a>
            <a href="<?= Url::to(['/site/contact']) ?>">联系我们</a>
            <a href="/advanced/backend/web/">后台管理</a>
        </div>
        <p class="footer-copyright">
            © 2025 新闻资讯管理系统 - 南开大学互联网数据库课程设计<br>
            Powered by Yii2 Framework
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
