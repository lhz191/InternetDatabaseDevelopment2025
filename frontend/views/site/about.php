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
        height: 280px;
        background: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1400') center/cover;
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
        background: rgba(0,0,0,0.5);
    }
    
    .about-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .about-header h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    
    .about-header p {
        font-size: 18px;
        opacity: 0.9;
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
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 32px;
    }
    
    .about-section {
        margin-bottom: 40px;
    }
    
    .about-section:last-child {
        margin-bottom: 0;
    }
    
    .about-section h2 {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .about-section h2 i {
        color: #e74c3c;
    }
    
    .about-section p {
        font-size: 16px;
        line-height: 1.8;
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
        background: #f9f9f9;
        border-radius: 12px;
        transition: all 0.3s;
    }
    
    .team-member:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
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
        font-size: 18px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    
    .member-role {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
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
        background: #f5f5f5;
        border-radius: 20px;
        font-size: 14px;
        color: #666;
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
        color: #52c41a;
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
            <h2><i class="fas fa-info-circle"></i> 项目介绍</h2>
            <p>
                本项目是南开大学计算机学院《互联网数据库开发》课程的团队大作业。
                我们基于 Yii2 框架开发了一个功能完整的新闻资讯管理系统，
                实现了新闻的发布、分类、评论等核心功能。
            </p>
            <p>
                系统采用 MVC 设计模式，前后端分离，包含用户友好的前台展示界面和功能完善的后台管理系统。
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
                    <div class="member-avatar">B</div>
                    <div class="member-name">组员B</div>
                    <div class="member-role">分类管理</div>
                    <div class="member-id">学号: XXXXXXX</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">C</div>
                    <div class="member-name">组员C</div>
                    <div class="member-role">文章管理</div>
                    <div class="member-id">学号: XXXXXXX</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">刘</div>
                    <div class="member-name">刘浩泽</div>
                    <div class="member-role">评论管理</div>
                    <div class="member-id">学号: 2212478</div>
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
            <h2><i class="fas fa-star"></i> 功能特性</h2>
            <ul class="feature-list">
                <li><i class="fas fa-check-circle"></i> 新闻文章的增删改查管理</li>
                <li><i class="fas fa-check-circle"></i> 新闻分类管理</li>
                <li><i class="fas fa-check-circle"></i> 用户评论系统</li>
                <li><i class="fas fa-check-circle"></i> 后台管理系统</li>
                <li><i class="fas fa-check-circle"></i> 响应式前台展示</li>
                <li><i class="fas fa-check-circle"></i> 用户认证与权限管理</li>
            </ul>
        </div>
    </div>
</div>
