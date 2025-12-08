<?php
/**
 * 文章表单 (View层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 文章创建/编辑表单组件
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<style>
    .article-form {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .form-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    
    .form-header h2 {
        font-size: 18px;
        font-weight: 500;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-header h2 i {
        color: #1890ff;
    }
    
    .form-body {
        padding: 32px 24px;
    }
    
    .form-section {
        margin-bottom: 32px;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        font-size: 15px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .section-title i {
        color: #1890ff;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-group .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .form-group .form-control:focus {
        outline: none;
        border-color: #1890ff;
        box-shadow: 0 0 0 3px rgba(24, 144, 255, 0.1);
    }
    
    .form-group textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .form-group select.form-control {
        cursor: pointer;
    }
    
    .form-group .help-block {
        font-size: 13px;
        color: #ff4d4f;
        margin-top: 6px;
    }
    
    .form-group.has-error .form-control {
        border-color: #ff4d4f;
    }
    
    .form-footer {
        padding: 20px 24px;
        border-top: 1px solid #f0f0f0;
        background: #fafafa;
        display: flex;
        gap: 12px;
    }
    
    .btn {
        padding: 10px 24px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    
    .btn-submit {
        background: #1890ff;
        color: white;
    }
    
    .btn-submit:hover {
        background: #40a9ff;
    }
    
    .btn-cancel {
        background: #f5f5f5;
        color: #666;
    }
    
    .btn-cancel:hover {
        background: #e5e5e5;
        color: #333;
    }
    
    .tips {
        background: #e6f7ff;
        border: 1px solid #91d5ff;
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 13px;
        color: #1890ff;
        margin-bottom: 24px;
    }
    
    .tips i {
        margin-right: 8px;
    }
</style>

<div class="article-form">
    <div class="form-header">
        <h2>
            <i class="fas fa-edit"></i>
            <?= $model->isNewRecord ? '发布新文章' : '编辑文章' ?>
        </h2>
    </div>
    
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-body'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'help-block'],
        ],
    ]); ?>
    
    <div class="tips">
        <i class="fas fa-info-circle"></i>
        请填写文章信息，带 <span style="color: #ff4d4f;">*</span> 的为必填项
    </div>
    
    <!-- 基本信息 -->
    <div class="form-section">
        <div class="section-title"><i class="fas fa-file-alt"></i> 基本信息</div>
        
        <div class="form-row">
            <?= $form->field($model, 'cid')->dropDownList(
                ArrayHelper::map($categories, 'cid', 'name'),
                ['prompt' => '请选择分类', 'class' => 'form-control']
            )->label('所属分类 <span style="color: #ff4d4f;">*</span>') ?>
            
            <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'placeholder' => '请输入作者名称'])->label('作者') ?>
        </div>
        
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => '请输入文章标题'])->label('文章标题 <span style="color: #ff4d4f;">*</span>') ?>
        
        <?= $form->field($model, 'summary')->textarea(['rows' => 3, 'placeholder' => '请输入文章摘要，用于列表展示'])->label('文章摘要') ?>
    </div>
    
    <!-- 文章内容 -->
    <div class="form-section">
        <div class="section-title"><i class="fas fa-align-left"></i> 文章内容</div>
        
        <?= $form->field($model, 'content')->textarea(['rows' => 15, 'placeholder' => '请输入文章正文内容，支持HTML格式'])->label('正文内容 <span style="color: #ff4d4f;">*</span>') ?>
    </div>
    
    <!-- 其他设置 -->
    <div class="form-section">
        <div class="section-title"><i class="fas fa-cog"></i> 其他设置</div>
        
        <div class="form-row">
            <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => '请输入文章来源'])->label('文章来源') ?>
            
            <?= $form->field($model, 'status')->dropDownList([
                0 => '草稿',
                1 => '已发布',
                2 => '已下架',
            ], ['class' => 'form-control'])->label('发布状态') ?>
        </div>
        
        <div class="form-row">
            <?= $form->field($model, 'is_top')->dropDownList([0 => '否', 1 => '是'], ['class' => 'form-control'])->label('是否置顶') ?>
            
            <?= $form->field($model, 'is_hot')->dropDownList([0 => '否', 1 => '是'], ['class' => 'form-control'])->label('是否热门') ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
    
    <div class="form-footer">
        <?= Html::submitButton('<i class="fas fa-save"></i> 保存文章', [
            'class' => 'btn btn-submit',
            'form' => 'w0',
        ]) ?>
        <?= Html::a('<i class="fas fa-times"></i> 取消', ['index'], ['class' => 'btn btn-cancel']) ?>
    </div>
</div>
