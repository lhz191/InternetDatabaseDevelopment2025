<?php
/**
 * 创建文章页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 后台创建新文章页面
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '发布文章';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .create-page {
        min-height: 100vh;
        background: #f0f2f5;
        margin: -20px;
        padding: 0;
    }
    
    .page-banner {
        height: 140px;
        background: url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
    }
    
    .banner-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .banner-content h1 {
        font-size: 28px;
        font-weight: 600;
        margin: 0;
    }
    
    .main-content {
        max-width: 900px;
        margin: -30px auto 40px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 3;
    }
    
    .back-link:hover {
        color: white;
        opacity: 0.8;
    }
</style>

<div class="create-page">
    <div class="page-banner">
        <a href="<?= Url::to(['index']) ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> 返回列表
        </a>
        <div class="banner-content">
            <h1><i class="fas fa-plus-circle"></i> 发布新文章</h1>
        </div>
    </div>
    
    <div class="main-content">
        <?= $this->render('_form', [
            'model' => $model,
            'categories' => $categories,
        ]) ?>
    </div>
</div>
