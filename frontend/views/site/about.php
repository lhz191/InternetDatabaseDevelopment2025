<?php
/**
 * 关于我们页面 (View层)
 * @author 团队
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '关于我们';
?>

<style>
    .about-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 60px 40px;
        color: white;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .about-section {
        background: white;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .about-section h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #202124;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .about-section p {
        color: #555;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .team-card {
        text-align: center;
        padding: 30px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 16px;
        transition: transform 0.3s;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 32px;
        color: white;
    }
    
    .team-name {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    
    .team-role {
        color: #666;
        font-size: 14px;
    }
    
    .tech-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    
    .tech-tag {
        padding: 8px 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        font-size: 14px;
    }
</style>

<div class="about-hero">
    <h1>🎓 关于我们</h1>
    <p>南开大学 计算机学院 互联网数据库开发 课程设计项目</p>
</div>

<div class="about-section">
    <h2><i class="fas fa-project-diagram"></i> 项目介绍</h2>
    <p>
        本项目是南开大学计算机学院《互联网数据库开发》课程的团队作业项目。
        我们开发了一个功能完整的新闻资讯管理系统，包含前台展示和后台管理两大模块。
    </p>
    <p>
        系统采用 Yii2 框架进行开发，遵循 MVC 设计模式，实现了用户管理、新闻发布、
        分类管理、评论管理等核心功能。
    </p>
</div>

<div class="about-section">
    <h2><i class="fas fa-users"></i> 团队成员</h2>
    <div class="team-grid">
        <div class="team-card">
            <div class="team-avatar">👨‍💻</div>
            <div class="team-name">组员A</div>
            <div class="team-role">用户模块开发</div>
        </div>
        <div class="team-card">
            <div class="team-avatar">👩‍💻</div>
            <div class="team-name">组员B</div>
            <div class="team-role">分类模块开发</div>
        </div>
        <div class="team-card">
            <div class="team-avatar">👨‍💻</div>
            <div class="team-name">组员C</div>
            <div class="team-role">文章模块开发</div>
        </div>
        <div class="team-card">
            <div class="team-avatar">👩‍💻</div>
            <div class="team-name">组员D</div>
            <div class="team-role">评论模块开发</div>
        </div>
    </div>
</div>

<div class="about-section">
    <h2><i class="fas fa-cogs"></i> 技术栈</h2>
    <p>本项目使用以下技术进行开发：</p>
    <div class="tech-tags">
        <span class="tech-tag">Yii2 Framework</span>
        <span class="tech-tag">PHP 8.x</span>
        <span class="tech-tag">MySQL</span>
        <span class="tech-tag">HTML5</span>
        <span class="tech-tag">CSS3</span>
        <span class="tech-tag">JavaScript</span>
        <span class="tech-tag">Bootstrap</span>
        <span class="tech-tag">Font Awesome</span>
    </div>
</div>

<div class="about-section">
    <h2><i class="fas fa-file-alt"></i> 项目文档</h2>
    <p>本项目包含以下文档：</p>
    <ul style="color: #555; line-height: 2;">
        <li>📋 需求文档 - 项目功能需求分析</li>
        <li>📐 设计文档 - 数据库设计、模块设计</li>
        <li>📝 实现文档 - 开发过程记录</li>
        <li>📖 用户手册 - 系统使用说明</li>
        <li>🚀 部署文档 - 项目部署指南</li>
        <li>📊 项目展示PPT - 项目成果展示</li>
    </ul>
</div>
