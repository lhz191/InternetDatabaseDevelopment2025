<?php

/* @var $this yii\web\View */
/* @var $chartLabels array 由控制器传入的分类名数组 */
/* @var $chartData array 由控制器传入的文章数量数组 */

$this->title = '后台管理系统 - 首页';

// 【新增】引入 ECharts 库 (使用 CDN)
$this->registerJsFile('https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>欢迎回来，管理员！</h1>
        <p class="lead">以下是新闻资讯系统的实时数据概览。</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-stats"></i> 各分类文章数量统计</h3>
                    </div>
                    <div class="panel-body">
                        <div id="news-chart" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <h2>快速开始</h2>
                <p>您可以点击下方链接快速进入内容管理。</p>
                <p>
                    <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['/article/index']) ?>">管理文章 &raquo;</a>
                    <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['/category/index']) ?>">管理分类 &raquo;</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>系统状态</h2>
                <p>当前系统运行正常，数据库连接稳定。</p>
            </div>
            <div class="col-lg-4">
                <h2>帮助支持</h2>
                <p>如需帮助，请查阅开发文档或联系技术支持。</p>
            </div>
        </div>

    </div>
</div>

<?php
// 【新增】处理 JS 逻辑
// 将 PHP 数组转换为 JSON 格式供 JS 使用
$jsLabels = json_encode($chartLabels);
$jsData = json_encode($chartData);

$script = <<< JS
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('news-chart'));

    // 指定图表的配置项和数据
    var option = {
        tooltip: {},
        legend: {
            data: ['文章数量']
        },
        xAxis: {
            data: $jsLabels,
            axisLabel: {
                interval: 0, // 强制显示所有标签
                rotate: 30   // 如果标签太长，倾斜显示
            }
        },
        yAxis: {},
        series: [{
            name: '文章数量',
            type: 'bar', // 设置为柱状图
            data: $jsData,
            itemStyle: {
                // 设置柱子颜色
                color: '#337ab7'
            },
            label: {
                show: true,
                position: 'top'
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