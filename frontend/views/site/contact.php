<?php
/**
 * 联系我们页面 (View层)
 * @author 团队
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '联系我们';
?>

<style>
    .contact-hero {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 20px;
        padding: 60px 40px;
        color: white;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }
    
    .contact-card {
        background: white;
        border-radius: 16px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .contact-card:hover {
        transform: translateY(-10px);
    }
    
    .contact-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
    }
    
    .contact-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    
    .contact-info {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
    }
    
    .contact-link {
        color: #667eea;
        text-decoration: none;
    }
    
    .contact-link:hover {
        text-decoration: underline;
    }
    
    .download-section {
        background: white;
        border-radius: 16px;
        padding: 40px;
        margin-top: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .download-section h2 {
        font-size: 24px;
        margin-bottom: 25px;
        color: #202124;
    }
    
    .download-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .download-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
    }
    
    .download-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .download-item i {
        font-size: 24px;
    }
</style>

<div class="contact-hero">
    <h1>📧 联系我们</h1>
    <p>如有任何问题或建议，欢迎与我们联系</p>
</div>

<div class="contact-grid">
    <div class="contact-card">
        <div class="contact-icon">
            <i class="fas fa-university"></i>
        </div>
        <h3 class="contact-title">学校</h3>
        <p class="contact-info">
            南开大学<br>
            计算机学院 & 网络空间安全学院
        </p>
    </div>
    
    <div class="contact-card">
        <div class="contact-icon">
            <i class="fas fa-book"></i>
        </div>
        <h3 class="contact-title">课程</h3>
        <p class="contact-info">
            互联网数据库开发<br>
            授课教师: 乜鹏
        </p>
    </div>
    
    <div class="contact-card">
        <div class="contact-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <h3 class="contact-title">邮箱</h3>
        <p class="contact-info">
            作业提交邮箱：<br>
            <a href="mailto:nkdbis_homework@163.com" class="contact-link">
                nkdbis_homework@163.com
            </a>
        </p>
    </div>
    
    <div class="contact-card">
        <div class="contact-icon">
            <i class="fab fa-github"></i>
        </div>
        <h3 class="contact-title">GitHub</h3>
        <p class="contact-info">
            项目开源仓库：<br>
            <a href="#" class="contact-link">
                github.com/xxx/news-system
            </a>
        </p>
    </div>
</div>

<!-- 作业下载区 -->
<div class="download-section">
    <h2><i class="fas fa-download"></i> 作业下载</h2>
    
    <h4 style="margin: 20px 0 15px; color: #666;">📁 团队作业</h4>
    <div class="download-grid">
        <a href="/advanced/data/team/需求文档.pdf" class="download-item">
            <i class="fas fa-file-pdf"></i>
            <span>需求文档</span>
        </a>
        <a href="/advanced/data/team/设计文档.pdf" class="download-item">
            <i class="fas fa-file-pdf"></i>
            <span>设计文档</span>
        </a>
        <a href="/advanced/data/team/实现文档.pdf" class="download-item">
            <i class="fas fa-file-pdf"></i>
            <span>实现文档</span>
        </a>
        <a href="/advanced/data/team/用户手册.pdf" class="download-item">
            <i class="fas fa-file-pdf"></i>
            <span>用户手册</span>
        </a>
        <a href="/advanced/data/team/部署文档.pdf" class="download-item">
            <i class="fas fa-file-pdf"></i>
            <span>部署文档</span>
        </a>
        <a href="/advanced/data/team/项目展示.pptx" class="download-item">
            <i class="fas fa-file-powerpoint"></i>
            <span>项目展示PPT</span>
        </a>
    </div>
    
    <h4 style="margin: 30px 0 15px; color: #666;">👤 个人作业</h4>
    <div class="download-grid">
        <a href="/advanced/data/personal/" class="download-item">
            <i class="fas fa-folder"></i>
            <span>个人作业目录</span>
        </a>
    </div>
</div>
