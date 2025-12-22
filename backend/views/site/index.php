<?php

/* @var $this yii\web\View */
/* @var $chartLabels array 由控制器传入的分类名数组 */
/* @var $chartData array 由控制器传入的文章数量数组 */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '后台管理系统 - 纪念抗战胜利80周年特别版';

// 引入 ECharts 库 (使用 CDN)
$this->registerJsFile('https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>

<style>
    /* 全局背景：使用米黄色/羊皮纸质感，营造历史感 */
    body {
        background-color: #f9f7f1;
        /* 可选：添加一个极其细微的纹理背景，如果不需要可以注释掉 */
        /* background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png'); */
        color: #333;
        font-family: "Microsoft YaHei", "宋体", sans-serif;
    }

    /* Jumbotron 头部大横幅美化 */
    .jumbotron.commemorative-banner {
        /* 深红色渐变背景，象征热血与胜利 */
        background: linear-gradient(135deg, #8e0000 0%, #c62828 100%);
        color: #fff;
        border-bottom: 4px solid #d4af37; /* 金色底边框 */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        padding-top: 30px;
        padding-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    /* 可选：在 Banner 添加一个微妙的背景图案（如长城或云纹的剪影） */
    /* .jumbotron.commemorative-banner::after { ... } */

    .jumbotron.commemorative-banner h1 {
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        color: #fcedd0; /* 浅金色文字 */
        margin-top: 0;
    }
    
    /* 副标题强调 */
    .jumbotron.commemorative-banner .lead {
        color: #e0e0e0;
        font-size: 18px;
    }

    /* 主题徽章/文字点缀 */
    .theme-badge {
        display: inline-block;
        background-color: #d4af37; /* 金色背景 */
        color: #8e0000; /* 深红文字 */
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 15px;
        box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    /* Panel 面板美化 */
    .panel-commemorative {
        border: none;
        border-top: 3px solid #c62828; /* 顶部红色强调线 */
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        background-color: #fff;
    }

    .panel-commemorative .panel-heading {
        background-color: #fff; /* 保持干净的白色背景 */
        /* background: linear-gradient(to right, #c62828, #e57373); 如果喜欢红色标题栏可以用这个 */
        color: #8e0000; /* 深红色标题文字 */
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }

    .panel-commemorative .panel-title {
        font-weight: bold;
        font-size: 18px;
    }
    
    .panel-commemorative .panel-title i {
        margin-right: 8px;
        color: #d4af37; /* 金色图标 */
    }

    /* 底部栏目美化 */
    .footer-column h2 {
        color: #8e0000;
        font-weight: bold;
        border-bottom: 2px solid #d4af37;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 22px;
    }

    /* 按钮美化：红色主题按钮 */
    .btn-commemorative {
        background-color: #c62828;
        border-color: #b71c1c;
        color: #fff;
        transition: all 0.3s;
    }

    .btn-commemorative:hover {
        background-color: #8e0000;
        border-color: #8e0000;
        color: #d4af37; /* 悬停时文字变金 */
    }
</style>

<div class="site-index">

    <div class="jumbotron commemorative-banner">
        <div class="container-fluid">
            <span class="theme-badge">铭记历史 · 缅怀先烈 · 珍爱和平 · 开创未来</span>
            <h1><i class="glyphicon glyphicon-flag"></i> 欢迎回来，管理员！</h1>
            <p class="lead">纪念抗战胜利80周年 —— 实时数据概览。</p>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default panel-commemorative">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-stats"></i> 各分类文章数量统计 (主题数据)</h3>
                    </div>
                    <div class="panel-body" style="background-color: #fffdf9;"> <div id="news-chart" style="width: 100%; height: 450px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-4 footer-column">
                <h2><i class="glyphicon glyphicon-share-alt"></i> 快速开始</h2>
                <p>您可以点击下方链接快速进入内容管理。</p>
                <p>
                    <a class="btn btn-commemorative" href="<?= Url::to(['/article/index']) ?>">管理文章 &raquo;</a>
                    <a class="btn btn-commemorative" href="<?= Url::to(['/category/index']) ?>" style="margin-left: 10px;">管理分类 &raquo;</a>
                </p>
            </div>
            <div class="col-lg-4 footer-column">
                <h2><i class="glyphicon glyphicon-hdd"></i> 系统状态</h2>
                <p class="text-success"><i class="glyphicon glyphicon-ok-sign"></i> 当前系统运行正常。</p>
                <p>数据库连接稳定，数据安全无虞。</p>
            </div>
            <div class="col-lg-4 footer-column">
                <h2><i class="glyphicon glyphicon-question-sign"></i> 帮助支持</h2>
                <p>如需帮助，请查阅开发文档或联系技术支持。</p>
                <p style="color: #999; font-size: 12px;">纪念抗战胜利80周年特别版 v1.0</p>
            </div>
        </div>

    </div>
</div>

<?php
// 处理 JS 逻辑
$jsLabels = json_encode($chartLabels);
$jsData = json_encode($chartData);

$script = <<< JS
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('news-chart'));

    // 指定图表的配置项和数据
    var option = {
        // 整体背景色 (透明，使用容器背景)
        backgroundColor: 'rgba(0,0,0,0)',
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            },
            // Tooltip 样式微调，金色边框
            borderColor: '#d4af37',
            borderWidth: 1,
            backgroundColor: 'rgba(255,255,255,0.95)',
            textStyle: {
                color: '#8e0000'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            data: $jsLabels,
            axisLabel: {
                interval: 0,
                rotate: 30,
                color: '#666', // X轴文字颜色
                fontWeight: 'bold'
            },
            axisLine: {
                lineStyle: {
                    color: '#c62828' // X轴轴线颜色（红色）
                }
            },
            axisTick: {
                alignWithLabel: true
            }
        },
        yAxis: {
            axisLabel: {
                color: '#666'
            },
            axisLine: {
                show: false // 隐藏Y轴轴线，更现代
            },
            splitLine: {
                lineStyle: {
                    color: '#eee', // 网格线颜色变淡
                    type: 'dashed' // 虚线
                }
            }
        },
        series: [{
            name: '文章数量',
            type: 'bar',
            barWidth: '50%', // 调整柱子宽度
            data: $jsData,
            itemStyle: {
                // 【核心修改】使用深红色渐变，增强立体感和庄重感
                color: new echarts.graphic.LinearGradient(
                    0, 0, 0, 1,
                    [
                        {offset: 0, color: '#ef5350'},  // 顶部较亮的红
                        {offset: 0.7, color: '#c62828'}, // 中间深红
                        {offset: 1, color: '#8e0000'}   // 底部暗红
                    ]
                ),
                // 柱子圆角
                borderRadius: [5, 5, 0, 0]
            },
            label: {
                show: true,
                position: 'top',
                color: '#c62828', // 顶部数字颜色
                fontWeight: 'bold',
                fontSize: 14
            },
            // 高亮样式
            emphasis: {
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#d4af37'}, // 高亮变金色
                            {offset: 1, color: '#fbc02d'}
                        ]
                    ),
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                },
                label: {
                    color: '#8e0000' // 高亮时文字变深红
                }
            }
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    // 窗口大小变化时自动调整图表大小
    window.addEventListener('resize', function() {
        myChart.resize();
    });
JS;

// 将 JS 代码注册到页面底部
$this->registerJs($script);
?>