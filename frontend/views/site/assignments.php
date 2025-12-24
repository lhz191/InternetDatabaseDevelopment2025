<?php

/* @var $this yii\web\View */
/* @var $teamFiles array */
/* @var $personalFiles array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '作业下载';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-assignments">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5 mt-4">
                    <h1 class="display-4" style="font-family: 'Noto Serif SC', serif; color: #8B0000;">
                        <?= Html::encode($this->title) ?></h1>
                    <p class="lead text-muted">提供团队及个人项目作业的文档与源码下载</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 团队作业 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header text-white"
                        style="background: linear-gradient(135deg, #8B0000 0%, #6B0000 100%); padding: 20px;">
                        <h3 class="card-title mb-0" style="font-family: 'Noto Serif SC', serif;"><i
                                class="fas fa-users mr-2"></i> 团队作业</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($teamFiles)): ?>
                            <div class="alert alert-warning">暂无文件可下载</div>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($teamFiles as $file): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-file-alt mr-2 text-danger"></i> <?= Html::encode($file) ?></span>
                                        <a href="<?= Url::to(['site/download', 'type' => 'team', 'file' => $file]) ?>"
                                            class="btn btn-outline-danger btn-sm" style="border-radius: 20px;">
                                            <i class="fas fa-download"></i> 下载
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- 个人作业 -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header text-white"
                        style="background: linear-gradient(135deg, #B8860B 0%, #DAA520 100%); padding: 20px;">
                        <h3 class="card-title mb-0" style="font-family: 'Noto Serif SC', serif;"><i
                                class="fas fa-user mr-2"></i> 个人作业</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($personalFiles)): ?>
                            <div class="alert alert-warning">暂无文件可下载</div>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($personalFiles as $file): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="far fa-file-alt mr-2 text-warning"></i>
                                            <?= Html::encode($file) ?></span>
                                        <a href="<?= Url::to(['site/download', 'type' => 'personal', 'file' => $file]) ?>"
                                            class="btn btn-outline-warning btn-sm"
                                            style="border-radius: 20px; color: #B8860B; border-color: #B8860B;">
                                            <i class="fas fa-download"></i> 下载
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted"><small>注意：所有下载文件仅供学习交流使用，请勿用于商业用途。</small></p>
            </div>
        </div>
    </div>
</div>