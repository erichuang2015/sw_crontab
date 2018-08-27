<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Agents;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Agents */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agents-view">

    <p>
        <?= Html::a(Yii::t('app', 'Back'), ['#'], ['class' => 'btn btn-default button-back']); ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="box table-responsive">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title;?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= DetailView::widget([
                        'model'      => $model,
                        'template'   => '<tr><th{captionOptions} width="20%">{label}</th><td{contentOptions}>{value}</td></tr>',
                        'options'    => ['class' => 'table table-bordered detail-view'],
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'value' => $model->id,
                            ],
                            [
                                'format'=> 'html',
                                'attribute' => 'categoryId',
                                'value' => function ($model) {
                                    $html = '<ul class="list-unstyled">';
                                    if($model->categoryId && ($data = Category::getDropDownListData($model->categoryId))) {
                                        foreach($data as $name) {
                                            $html .= '<li><span class="label label-primary">'.html::encode($name).'</span></li>';
                                        }
                                    }
                                    else {
                                        $html .= '<li><span class="not-set">' . Yii::t('yii', '(not set)') . '</span></li>';
                                    }
                                    $html .= '</ul>';
                                    return $html;
                                },
                            ],
                            [
                                'attribute' => 'name',
                                'value' => $model->name,
                            ],
                            [
                                'attribute' => 'ip',
                                'value' => $model->ip,
                            ],
                            [
                                'attribute' => 'port',
                                'value' => $model->port,
                            ],
                            [
                                'format' => 'html',
                                'attribute' => 'status',
                                'value' => function($model){
                                    if($model->status == Agents::STATUS_DISABLED) return '<span class="label label-danger">'.Yii::t('app','Disabled').'</span>';
                                    if($model->status == Agents::STATUS_ENABLED) return '<span class="label label-success">'.Yii::t('app','Enabled').'</span>';
                                }
                            ],
                            // 节点状态
                            [
                                'format'    => 'html', // 此列内容输出时不会被转义
                                'attribute' => 'agent_status', // 字段名
                                'value'     => function ($model) { // 该列内容
                                    if ($model->agent_status == Agents::AGENT_STATUS_OFFLINE) return '<span class="label label-danger">' . Yii::t('app', 'Offline') . '</span>';
                                    if ($model->agent_status == Agents::AGENT_STATUS_ONLINE) return '<span class="label label-success">' . Yii::t('app', 'Normal') . '</span>';
                                    if ($model->agent_status == Agents::AGENT_STATUS_ONLINE_REPORT_FAILED) return '<span class="label label-success">' . Yii::t('app', 'No heartbeat, but the nodes are normal') . '</span>';
                                },
                            ],
                            // 心跳
                            [
                                'label' => Yii::t('app', 'Heartbeat'),
                                'attribute' => 'last_report_time', // 字段名
                                'value' => function ($model) {
                                    if($model->last_report_time) {
                                        return Yii::$app->formatter->asDatetime($model->last_report_time);
                                    }
                                    return '';
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
