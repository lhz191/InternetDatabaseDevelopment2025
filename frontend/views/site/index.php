<?php
/**
 * 前台首页 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 网站首页，展示热门新闻和最新新闻，支持分类导航
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '首页';

// 抗战主题图片 - 使用稳定图片源
$warImages = [
    'https://picsum.photos/seed/war1/600/400',
    'https://picsum.photos/seed/war2/600/400',
    'https://picsum.photos/seed/war3/600/400',
    'https://picsum.photos/seed/war4/600/400',
    'https://picsum.photos/seed/war5/600/400',
    'https://picsum.photos/seed/war6/600/400',
    'https://picsum.photos/seed/war7/600/400',
    'https://picsum.photos/seed/war8/600/400',
];
?>

<!-- Hero 大图 - 抗战主题 -->
<div class="hero-banner" style="background: linear-gradient(135deg, #8B0000 0%, #4a0000 50%, #2d0000 100%);">
    <div class="hero-content">
        <h1>铭记历史 珍爱和平</h1>
        <p>纪念中国人民抗日战争暨世界反法西斯战争胜利80周年</p>
    </div>
    <div class="hero-year">1945-2025</div>
</div>

<div class="container">
    <!-- 纪念标语 -->
    <div style="text-align: center; padding: 30px 0; margin-bottom: 20px;">
        <p style="font-size: 18px; color: #8B0000; font-weight: 500; letter-spacing: 2px;">
            <i class="fas fa-star" style="color: #FFD700;"></i>
            勿忘国耻 · 振兴中华 · 缅怀先烈 · 开创未来
            <i class="fas fa-star" style="color: #FFD700;"></i>
        </p>
    </div>

    <!-- 分类导航 -->
    <div class="category-section">
        <div class="category-tags">
            <a href="<?= Url::to(['/site/news']) ?>" class="category-tag active">全部专题</a>
            <?php foreach ($categories as $category): ?>
                <a href="<?= Url::to(['/site/news', 'cid' => $category->cid]) ?>" class="category-tag">
                    <?= Html::encode($category->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- 热门文章 -->
    <div class="section-header">
        <h2 class="section-title">热门专题</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($hotArticles as $index => $article): ?>
            <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                <div class="news-card-image" style="background-image: url('<?= $warImages[$index % count($warImages)] ?>')">
                    <span class="news-card-category">
                        <?= $article->category ? Html::encode($article->category->name) : '历史' ?>
                    </span>
                </div>
                <div class="news-card-body">
                    <h3 class="news-card-title"><?= Html::encode($article->title) ?></h3>
                    <p class="news-card-summary">
                        <?= Html::encode(mb_substr(strip_tags($article->summary ?: $article->content), 0, 80)) ?>...
                    </p>
                    <div class="news-card-meta">
                        <div class="news-card-author">
                            <span class="author-avatar"><?= mb_substr($article->author ?: '编', 0, 1) ?></span>
                            <span><?= Html::encode($article->author ?: '编辑部') ?></span>
                        </div>
                        <div class="news-card-stats">
                            <span><i class="far fa-eye"></i> <?= $article->views ?></span>
                            <span><i class="far fa-heart"></i> <?= $article->likes ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- 最新发布 -->
    <div class="section-header" style="margin-top: 60px;">
        <h2 class="section-title">最新发布</h2>
        <a href="<?= Url::to(['/site/news']) ?>" class="view-all">
            查看全部 <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="news-grid">
        <?php foreach ($latestArticles as $index => $article): ?>
            <div class="news-card" onclick="location.href='<?= Url::to(['/site/view', 'id' => $article->aid]) ?>'">
                <div class="news-card-image" style="background-image: url('<?= $warImages[($index + 3) % count($warImages)] ?>')">
                    <span class="news-card-category">
                        <?= $article->category ? Html::encode($article->category->name) : '历史' ?>
                    </span>
                </div>
                <div class="news-card-body">
                    <h3 class="news-card-title"><?= Html::encode($article->title) ?></h3>
                    <p class="news-card-summary">
                        <?= Html::encode(mb_substr(strip_tags($article->summary ?: $article->content), 0, 80)) ?>...
                    </p>
                    <div class="news-card-meta">
                        <div class="news-card-author">
                            <span class="author-avatar"><?= mb_substr($article->author ?: '编', 0, 1) ?></span>
                            <span><?= Html::encode($article->author ?: '编辑部') ?></span>
                        </div>
                        <div class="news-card-stats">
                            <span><i class="far fa-eye"></i> <?= $article->views ?></span>
                            <span><i class="far fa-heart"></i> <?= $article->likes ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- 抗战历史时间线 -->
    <div class="section-header" style="margin-top: 60px;">
        <h2 class="section-title">抗战历史时间线</h2>
    </div>
    
    <div class="timeline-section">
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1931.9.18</div>
                <div class="timeline-content">
                    <h4>九一八事变</h4>
                    <p>日本关东军炮轰沈阳北大营，中国人民开始了长达14年的抗日战争。</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1937.7.7</div>
                <div class="timeline-content">
                    <h4>七七事变</h4>
                    <p>日军进攻卢沟桥，全面抗战爆发，中华民族开始全民族抗战。</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1937.12.13</div>
                <div class="timeline-content">
                    <h4>南京大屠杀</h4>
                    <p>侵华日军攻占南京，制造了惨绝人寰的南京大屠杀，30万同胞遇难。</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1938.3</div>
                <div class="timeline-content">
                    <h4>台儿庄大捷</h4>
                    <p>中国军队在台儿庄歼敌万余人，取得抗战以来正面战场首次重大胜利。</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1940.8</div>
                <div class="timeline-content">
                    <h4>百团大战</h4>
                    <p>八路军发动百团大战，参战兵力达105个团，沉重打击了日军。</p>
                </div>
            </div>
            <div class="timeline-item victory">
                <div class="timeline-dot"></div>
                <div class="timeline-date">1945.9.3</div>
                <div class="timeline-content">
                    <h4>抗战胜利</h4>
                    <p>日本正式签署投降书，中国人民抗日战争取得伟大胜利！</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-section {
    background: linear-gradient(135deg, #f8f4f0 0%, #fff 100%);
    border-radius: 12px;
    padding: 40px;
    margin-bottom: 40px;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #8B0000, #FFD700);
}

.timeline-item {
    position: relative;
    padding-bottom: 32px;
    padding-left: 40px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #8B0000;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(139,0,0,0.3);
}

.timeline-item.victory .timeline-dot {
    width: 24px;
    height: 24px;
    left: -30px;
    background: linear-gradient(135deg, #FFD700, #FFA500);
    border: 4px solid #fff;
}

.timeline-date {
    display: inline-block;
    background: linear-gradient(135deg, #8B0000, #6B0000);
    color: #FFD700;
    padding: 4px 14px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.timeline-item.victory .timeline-date {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #8B0000;
}

.timeline-content {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border-left: 3px solid #8B0000;
}

.timeline-item.victory .timeline-content {
    border-left-color: #FFD700;
    background: linear-gradient(135deg, #fffef0 0%, #fff 100%);
}

.timeline-content h4 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 8px;
}

.timeline-content p {
    font-size: 14px;
    color: #666;
    margin: 0;
    line-height: 1.6;
}

.timeline-item.victory .timeline-content h4 {
    color: #8B0000;
}

/* 数据统计图表样式 */
.stats-section {
    margin-top: 60px;
    margin-bottom: 40px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.chart-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.chart-card h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-card h3 i {
    color: #8B0000;
}

.chart-container {
    height: 300px;
}

.stats-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .stats-summary {
        grid-template-columns: repeat(2, 1fr);
    }
}

.stat-item {
    background: linear-gradient(135deg, #f8f4f0 0%, #fff 100%);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    border: 1px solid #f0e8e0;
}

.stat-item .number {
    font-size: 32px;
    font-weight: 700;
    color: #8B0000;
    display: block;
}

.stat-item .label {
    font-size: 14px;
    color: #666;
    margin-top: 4px;
}
</style>

<!-- 引入ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

<!-- 数据统计模块 -->
<div class="container">
    <div class="section-header" style="margin-top: 60px;">
        <h2 class="section-title">数据统计</h2>
    </div>
    
    <!-- 统计概览 -->
    <div class="stats-summary">
        <div class="stat-item">
            <span class="number">520</span>
            <span class="label">历史专题</span>
        </div>
        <div class="stat-item">
            <span class="number">8</span>
            <span class="label">专题分类</span>
        </div>
        <div class="stat-item">
            <span class="number">125K</span>
            <span class="label">总浏览量</span>
        </div>
        <div class="stat-item">
            <span class="number">8.5K</span>
            <span class="label">总点赞数</span>
        </div>
    </div>
    
    <!-- 图表区域 -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="chart-card">
                <h3><i class="fas fa-chart-line"></i> 近30天访问趋势</h3>
                <div id="trendChart" class="chart-container"></div>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> 分类内容分布</h3>
                <div id="categoryChart" class="chart-container"></div>
            </div>
        </div>
    </div>
</div>

<script>
// 访问趋势图
var trendChart = echarts.init(document.getElementById('trendChart'));
var trendOption = {
    tooltip: {
        trigger: 'axis',
        axisPointer: { type: 'shadow' }
    },
    legend: {
        data: ['浏览量', '点赞数'],
        top: 0
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: {
        type: 'category',
        data: ['11/18', '11/20', '11/22', '11/24', '11/26', '11/28', '11/30', '12/02', '12/04', '12/06', '12/08', '12/10', '12/12', '12/14', '12/16', '12/18'],
        axisLabel: { rotate: 45 }
    },
    yAxis: { type: 'value' },
    series: [
        {
            name: '浏览量',
            type: 'line',
            smooth: true,
            data: [1200, 1450, 1680, 1100, 1280, 1890, 1380, 780, 1200, 980, 1150, 1480, 1820, 1350, 1720, 1450],
            itemStyle: { color: '#8B0000' },
            areaStyle: {
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    { offset: 0, color: 'rgba(139,0,0,0.3)' },
                    { offset: 1, color: 'rgba(139,0,0,0.05)' }
                ])
            }
        },
        {
            name: '点赞数',
            type: 'line',
            smooth: true,
            data: [89, 102, 125, 82, 91, 145, 95, 55, 88, 72, 85, 108, 138, 96, 128, 102],
            itemStyle: { color: '#FFD700' }
        }
    ]
};
trendChart.setOption(trendOption);

// 分类分布饼图
var categoryChart = echarts.init(document.getElementById('categoryChart'));
var categoryOption = {
    tooltip: {
        trigger: 'item',
        formatter: '{b}: {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        right: 10,
        top: 'center'
    },
    series: [{
        type: 'pie',
        radius: ['40%', '70%'],
        center: ['35%', '50%'],
        avoidLabelOverlap: false,
        itemStyle: {
            borderRadius: 8,
            borderColor: '#fff',
            borderWidth: 2
        },
        label: { show: false },
        emphasis: {
            label: {
                show: true,
                fontSize: 16,
                fontWeight: 'bold'
            }
        },
        data: [
            { value: 85, name: '重大战役', itemStyle: { color: '#8B0000' } },
            { value: 72, name: '英雄人物', itemStyle: { color: '#B8860B' } },
            { value: 45, name: '历史遗址', itemStyle: { color: '#4a4a4a' } },
            { value: 58, name: '抗战文化', itemStyle: { color: '#1890ff' } },
            { value: 63, name: '纪念活动', itemStyle: { color: '#52c41a' } },
            { value: 38, name: '历史档案', itemStyle: { color: '#722ed1' } },
            { value: 52, name: '老兵故事', itemStyle: { color: '#13c2c2' } },
            { value: 67, name: '国际视角', itemStyle: { color: '#eb2f96' } }
        ]
    }]
};
categoryChart.setOption(categoryOption);

// 响应式
window.addEventListener('resize', function() {
    trendChart.resize();
    categoryChart.resize();
});
</script>
