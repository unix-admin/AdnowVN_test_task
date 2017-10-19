<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Books */

?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date_create:date',
            'date_update:date',
            [
                'attribute' => 'preview',
                'format' => 'raw',
                'value'=>function($model){
                    return Html::img($model->preview,['width'=>'120px']);

                },
            ],
            'date:date',
            [
                'attribute' => 'author_id',
                'value'=>function($model){
                    $author = \app\models\Authors::find()->where('id=:authorId',['authorId'=>$model->author_id])->one();
                    if ($author){
                        return $author->getFullname();
                    }
                    return 'Не задано';

                },
            ],
        ],
    ]) ?>

</div>
