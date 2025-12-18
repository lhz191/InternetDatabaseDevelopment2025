<?php
/**
 * 关于我们页面 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 关于我们页面
 */

use yii\helpers\Html;

$this->title = '关于我们';
?>

<style>
    .about-header {
        height: 320px;
        background: url('https://images.unsplash.com/photo-1580130544401-f4bd0c41e946?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .about-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(139,0,0,0.85), rgba(0,0,0,0.7));
    }
    
    .about-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .about-header h1 {
        font-family: 'Noto Serif SC', serif;
        font-size: 46px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #FFD700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .about-header p {
        font-size: 20px;
        opacity: 0.95;
    }
    
    .about-container {
        max-width: 900px;
        margin: -60px auto 60px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    .about-card {
        background: white;
        border-radius: 12px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(139,0,0,0.1);
        margin-bottom: 32px;
        border: 1px solid rgba(139,0,0,0.05);
    }
    
    .about-section {
        margin-bottom: 40px;
    }
    
    .about-section:last-child {
        margin-bottom: 0;
    }
    
    .about-section h2 {
        font-family: 'Noto Serif SC', serif;
        font-size: 24px;
        font-weight: 600;
        color: #8B0000;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .about-section h2 i {
        color: #B8860B;
    }
    
    .about-section p {
        font-size: 16px;
        line-height: 1.9;
        color: #555;
        margin-bottom: 16px;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    
    .team-member {
        text-align: center;
        padding: 32px 20px;
        background: linear-gradient(135deg, #f8f6f3, #fff);
        border-radius: 12px;
        transition: all 0.3s;
        border: 1px solid rgba(139,0,0,0.08);
    }
    
    .team-member:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(139,0,0,0.12);
    }
    
    .member-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 32px;
        font-weight: 600;
        margin: 0 auto 16px;
    }
    
    .member-name {
        font-family: 'Noto Serif SC', serif;
        font-size: 18px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    
    .member-role {
        font-size: 14px;
        color: #8B0000;
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .member-id {
        font-size: 13px;
        color: #999;
    }
    
    .tech-stack {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 16px;
    }
    
    .tech-item {
        padding: 8px 20px;
        background: #f8f6f3;
        border-radius: 20px;
        font-size: 14px;
        color: #666;
        border: 1px solid rgba(139,0,0,0.08);
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
    }
    
    .feature-list li {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 15px;
        color: #555;
    }
    
    .feature-list li:last-child {
        border-bottom: none;
    }
    
    .feature-list i {
        color: #B8860B;
    }
    
    /* 特别高亮 */
    .highlight-box {
        background: linear-gradient(135deg, rgba(139,0,0,0.05), rgba(184,134,11,0.05));
        border-left: 4px solid #8B0000;
        padding: 20px 24px;
        border-radius: 0 8px 8px 0;
        margin: 20px 0;
    }
    
    .highlight-box p {
        margin: 0;
        color: #8B0000;
        font-weight: 500;
    }
</style>

<div class="about-header">
    <div class="about-header-content">
        <h1>关于我们</h1>
        <p>南开大学互联网数据库课程设计团队</p>
    </div>
</div>

<div class="about-container">
    <div class="about-card">
        <!-- 项目介绍 -->
        <div class="about-section">
            <h2><i class="fas fa-star"></i> 项目介绍</h2>
            <p>
                本项目是南开大学计算机学院《互联网数据库开发》课程的团队大作业。
                为纪念中国人民抗日战争暨世界反法西斯战争胜利80周年，
                我们基于 Yii2 框架开发了这个纪念网站。
            </p>
            <div class="highlight-box">
                <p><i class="fas fa-quote-left"></i> 铭记历史，缅怀先烈，珍爱和平，开创未来。</p>
            </div>
            <p>
                系统采用 MVC 设计模式，前后端分离，包含用户友好的前台展示界面和功能完善的后台管理系统。
                通过本项目，我们希望让更多人了解那段波澜壮阔的历史，铭记先烈们的英勇事迹。
            </p>
        </div>
        
        <!-- 团队成员 -->
        <div class="about-section">
            <h2><i class="fas fa-users"></i> 团队成员</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">A</div>
                    <div class="member-name">组员A</div>
                    <div class="member-role">组长 · 用户管理</div>
                    <div class="member-id">学号: XXXXXXX</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #8B0000 0%, #B8860B 100%);">刘</div>
                    <div class="member-name">刘浩泽</div>
                    <div class="member-role">首页 + 文章管理</div>
                    <div class="member-id">学号: 2212478</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">C</div>
                    <div class="member-name">组员C</div>
                    <div class="member-role">分类管理</div>
                    <div class="member-id">学号: XXXXXXX</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">D</div>
                    <div class="member-name">组员D</div>
                    <div class="member-role">评论管理</div>
                    <div class="member-id">学号: XXXXXXX</div>
                </div>
            </div>
        </div>
        
        <!-- 技术栈 -->
        <div class="about-section">
            <h2><i class="fas fa-code"></i> 技术栈</h2>
            <div class="tech-stack">
                <span class="tech-item">PHP 7.4+</span>
                <span class="tech-item">Yii2 Framework</span>
                <span class="tech-item">MySQL 5.7+</span>
                <span class="tech-item">HTML5 / CSS3</span>
                <span class="tech-item">JavaScript</span>
                <span class="tech-item">Bootstrap</span>
                <span class="tech-item">Font Awesome</span>
            </div>
        </div>
        
        <!-- 功能特性 -->
        <div class="about-section">
            <h2><i class="fas fa-list-check"></i> 功能特性</h2>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i> 抗战历史内容的增删改查管理</li>
                <li><i class="fas fa-check-circle"></i> 专题分类管理（战役、人物、遗址等）</li>
                <li><i class="fas fa-check-circle"></i> 用户评论与留言系统</li>
                <li><i class="fas fa-check-circle"></i> 团队展示页面</li>
                <li><i class="fas fa-check-circle"></i> 后台管理系统</li>
                <li><i class="fas fa-check-circle"></i> 响应式前台展示</li>
                <li><i class="fas fa-check-circle"></i> 动态图形统计展示</li>
            </ul>
        </div>
    </div>
</div>
