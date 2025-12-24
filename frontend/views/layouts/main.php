<?php
/**
 * 前台主布局文件 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 前台网站主布局，包含导航、页脚等公共部分
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
    <title><?= Html::encode($this->title) ?> - 抗战胜利80周年纪念</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&family=Noto+Serif+SC:wght@600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php $this->head() ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans SC', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f6f3;
            min-height: 100vh;
            color: #333;
        }

        /* 顶部导航 - 军旅风格 */
        .navbar {
            background: linear-gradient(135deg, #8B0000 0%, #6B0000 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
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
            height: 65px;
        }

        .logo {
            font-family: 'Noto Serif SC', serif;
            font-size: 24px;
            font-weight: 700;
            color: #FFD700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .logo i {
            color: #FFD700;
            font-size: 28px;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            padding: 10px 18px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #FFD700;
        }

        .nav-links a.active {
            background: rgba(255, 215, 0, 0.2);
            color: #FFD700;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        /* 用户下拉菜单 */
        .dropdown-user {
            position: relative;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 150px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
            padding: 8px 0;
            margin-top: 5px;
            z-index: 1001;
        }

        .dropdown-user:hover .user-dropdown {
            display: block;
        }

        .logout-btn {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 8px 15px;
            color: #333;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background-color: #f5f5f5;
            color: #8B0000;
        }

        .logout-btn i {
            margin-right: 8px;
            width: 16px;
        }

        /* 主内容区 */
        .main-content {
            margin-top: 65px;
            min-height: calc(100vh - 200px);
        }

        /* Hero 大图区域 - 抗战风格 */
        .hero-banner {
            height: 450px;
            background: url('https://images.unsplash.com/photo-1580130544401-f4bd0c41e946?w=1400') center/cover;
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
            background: linear-gradient(to bottom, rgba(139, 0, 0, 0.7), rgba(0, 0, 0, 0.8));
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-family: 'Noto Serif SC', serif;
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #FFD700;
        }

        .hero-content p {
            font-size: 22px;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .hero-year {
            font-size: 120px;
            font-weight: 700;
            color: rgba(255, 215, 0, 0.15);
            position: absolute;
            bottom: 20px;
            right: 50px;
            font-family: 'Noto Serif SC', serif;
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
            font-family: 'Noto Serif SC', serif;
            font-size: 26px;
            font-weight: 600;
            color: #8B0000;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: '';
            width: 5px;
            height: 28px;
            background: linear-gradient(to bottom, #FFD700, #B8860B);
            border-radius: 2px;
        }

        .view-all {
            color: #8B0000;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .view-all:hover {
            color: #B8860B;
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
            box-shadow: 0 2px 12px rgba(139, 0, 0, 0.08);
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid rgba(139, 0, 0, 0.05);
        }

        .news-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(139, 0, 0, 0.15);
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
            padding: 5px 14px;
            background: linear-gradient(135deg, #8B0000, #6B0000);
            color: #FFD700;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .news-card-body {
            padding: 20px;
        }

        .news-card-title {
            font-family: 'Noto Serif SC', serif;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-card-summary {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
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
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B0000, #B8860B);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
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
            box-shadow: 0 2px 12px rgba(139, 0, 0, 0.08);
            border: 1px solid rgba(139, 0, 0, 0.05);
        }

        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .category-tag {
            padding: 10px 22px;
            background: #f8f6f3;
            border-radius: 20px;
            font-size: 14px;
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .category-tag:hover,
        .category-tag.active {
            background: linear-gradient(135deg, #8B0000, #6B0000);
            color: #FFD700;
            border-color: #8B0000;
        }

        /* 页脚 - 庄重风格 */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d1f1f 100%);
            color: white;
            padding: 50px 20px 24px;
            margin-top: 60px;
            border-top: 4px solid #8B0000;
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
            font-family: 'Noto Serif SC', serif;
            font-size: 26px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #FFD700;
        }

        .footer-brand h3 i {
            color: #FFD700;
        }

        .footer-brand p {
            color: #aaa;
            line-height: 1.9;
            font-size: 14px;
        }

        .footer-column h4 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #FFD700;
            font-weight: 600;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-column a:hover {
            color: #FFD700;
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid #444;
            text-align: center;
            color: #888;
            font-size: 14px;
        }

        .footer-bottom span {
            color: #FFD700;
        }

        /* 响应式 */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 36px;
            }

            .nav-links {
                display: none;
            }

            .hero-banner {
                height: 350px;
            }

            .hero-year {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- 导航栏 -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?= Url::to(['/site/index']) ?>" class="logo">
                <i class="fas fa-star"></i> 抗战胜利80周年
            </a>
            <ul class="nav-links">
                <li><a href="<?= Url::to(['/site/index']) ?>"
                        class="<?= Yii::$app->controller->route == 'site/index' ? 'active' : '' ?>">首页</a></li>
                <li><a href="<?= Url::to(['/site/news']) ?>"
                        class="<?= Yii::$app->controller->route == 'site/news' ? 'active' : '' ?>">历史回顾</a></li>
                <li><a href="<?= Url::to(['/team/index']) ?>"
                        class="<?= Yii::$app->controller->id == 'team' ? 'active' : '' ?>">团队展示</a></li>
                <li><a href="<?= Url::to(['/site/assignments']) ?>"
                        class="<?= Yii::$app->controller->route == 'site/assignments' ? 'active' : '' ?>">作业下载</a></li>
                <li><a href="<?= Url::to(['/guestbook/index']) ?>"
                        class="<?= Yii::$app->controller->id == 'guestbook' ? 'active' : '' ?>">留言板</a></li>
                <li><a href="<?= Url::to(['/site/about']) ?>"
                        class="<?= Yii::$app->controller->route == 'site/about' ? 'active' : '' ?>">关于我们</a></li>

                <?php if (Yii::$app->user->isGuest): ?>
                    <li><a href="<?= Url::to(['/site/login']) ?>">登录/注册</a></li>
                <?php else: ?>
                    <li class="dropdown-user">
                        <a href="javascript:void(0)" class="user-toggle">
                            <i class="fas fa-user-circle"></i> <?= Html::encode(Yii::$app->user->identity->username) ?>
                        </a>
                        <div class="user-dropdown">
                            <?= Html::beginForm(['/site/logout'], 'post') ?>
                            <?= Html::submitButton(
                                '<i class="fas fa-sign-out-alt"></i> 退出登录',
                                ['class' => 'logout-btn']
                            ) ?>
                            <?= Html::endForm() ?>
                        </div>
                    </li>
                <?php endif; ?>
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
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3><i class="fas fa-star"></i> 铭记历史</h3>
                    <p>纪念中国人民抗日战争暨世界反法西斯战争胜利80周年<br>南开大学互联网数据库课程设计项目</p>
                </div>
                <div class="footer-column">
                    <h4>快速导航</h4>
                    <ul>
                        <li><a href="<?= Url::to(['/site/index']) ?>">首页</a></li>
                        <li><a href="<?= Url::to(['/site/news']) ?>">历史回顾</a></li>
                        <li><a href="<?= Url::to(['/site/about']) ?>">关于我们</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>专题分类</h4>
                    <ul>
                        <li><a href="#">重大战役</a></li>
                        <li><a href="#">英雄人物</a></li>
                        <li><a href="#">历史遗址</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>联系方式</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-envelope"></i> nankai@edu.cn</a></li>
                        <li><a href="#"><i class="fab fa-github"></i> GitHub</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                © 2025 <span>抗战胜利80周年纪念网</span> · 南开大学 · 铭记历史，珍爱和平
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>