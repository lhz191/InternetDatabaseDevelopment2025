<?php
/**
 * 联系我们页面 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 联系我们页面
 */

use yii\helpers\Html;

$this->title = '联系我们';
?>

<style>
    .contact-header {
        height: 280px;
        background: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .contact-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
    }
    
    .contact-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .contact-header h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    
    .contact-header p {
        font-size: 18px;
        opacity: 0.9;
    }
    
    .contact-container {
        max-width: 900px;
        margin: -60px auto 60px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .contact-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s;
    }
    
    .contact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }
    
    .contact-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin: 0 auto 20px;
    }
    
    .contact-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .contact-card p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
    }
    
    .contact-card a {
        color: #667eea;
        text-decoration: none;
    }
    
    .contact-card a:hover {
        text-decoration: underline;
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .info-section {
        margin-bottom: 32px;
    }
    
    .info-section:last-child {
        margin-bottom: 0;
    }
    
    .info-section h2 {
        font-size: 22px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-section h2 i {
        color: #e74c3c;
    }
    
    .info-section p {
        font-size: 15px;
        line-height: 1.8;
        color: #555;
    }
    
    .github-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 15px;
        margin-top: 16px;
        transition: all 0.2s;
    }
    
    .github-link:hover {
        background: #333;
        color: white;
    }
    
    .map-placeholder {
        height: 200px;
        background: #f5f5f5;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        margin-top: 20px;
    }
</style>

<div class="contact-header">
    <div class="contact-header-content">
        <h1>联系我们</h1>
        <p>有任何问题或建议，欢迎与我们联系</p>
    </div>
                </div>

<div class="contact-container">
    <!-- 联系方式卡片 -->
    <div class="contact-grid">
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3>电子邮箱</h3>
            <p>
                <a href="mailto:admin@nankai.edu.cn">admin@nankai.edu.cn</a>
            </p>
        </div>
        <div class="contact-card">
            <div class="contact-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <i class="fab fa-github"></i>
            </div>
            <h3>GitHub</h3>
            <p>
                <a href="https://github.com/lhz191/InternetDatabaseDevelopment2025" target="_blank">项目仓库</a>
            </p>
        </div>
        <div class="contact-card">
            <div class="contact-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3>地址</h3>
            <p>天津市南开区卫津路94号<br>南开大学</p>
        </div>
    </div>

    <!-- 详细信息 -->
    <div class="info-card">
        <div class="info-section">
            <h2><i class="fas fa-university"></i> 课程信息</h2>
            <p>
                <strong>课程名称：</strong>互联网数据库开发<br>
                <strong>开课学院：</strong>计算机学院 & 网络空间安全学院<br>
                <strong>授课教师：</strong>乜鹏<br>
                <strong>课程网站：</strong><a href="https://dbis.nankai.edu.cn/2019/0417/c12139a128118/page.htm" target="_blank">https://dbis.nankai.edu.cn</a>
            </p>
        </div>
        
        <div class="info-section">
            <h2><i class="fas fa-code-branch"></i> 开源仓库</h2>
            <p>
                本项目代码已开源至 GitHub，欢迎 Star 和 Fork！
            </p>
            <a href="https://github.com/lhz191/InternetDatabaseDevelopment2025" target="_blank" class="github-link">
                <i class="fab fa-github"></i> 访问 GitHub 仓库
            </a>
        </div>
        
        <div class="info-section">
            <h2><i class="fas fa-map"></i> 学校位置</h2>
            <p>南开大学 · 天津市南开区卫津路94号</p>
            <div class="map-placeholder">
                <span><i class="fas fa-map-marker-alt"></i> 地图加载中...</span>
            </div>
        </div>
    </div>
</div>
