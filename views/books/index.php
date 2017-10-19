<?php

use app\models\Authors;
use kartik\field\FieldRange;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
;$this->registerJs("
    var modelId = 0;
    $(document).on('show.bs.modal',function(){
       $.ajax({
            method: \"GET\",
            url: \"/books/view?id=\"+modelId,
            success: function(data){
                $('#modal-body').html(data);
            }
            
        })
    })
    $('.view').click(function(){
        modelId = $( this ).attr('model');
        $('#viewModal').modal('show');
    })
    $('.delete').click(function(){
        var id = $( this ).attr('model');
        var result = confirm('Удалить книгу?');
        if(result){
        $.post('/books/delete?id='+id)
        }        
        
    })
    

")
?>
<?php
echo newerton\fancybox\FancyBox::widget([
    'target' => '.test',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => true,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);

?>


<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div>
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'method' => 'get',
            'fieldConfig' => [
                'template' => "<div class=\"col-md-4\">{input}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ]]);?>
        <div class="form-group">
                <?= $form->field($searchModel, 'author_id')->dropDownList(
                        ArrayHelper::map(Authors::find()->asArray()->all(),'id','firstname'),['prompt'=>'Автор'])->label() ?>
                <?= $form->field($searchModel, 'name')->textInput(['placeholder'=>'Название','maxlength' => true]) ?>
                <br />
            <div class="row form-group">
            <div class="col-md-6">
                <?= FieldRange::widget([
                    'form' => $form,
                    'model' => $searchModel,
                    'attribute1' => 'dateStart',
                    'attribute2' => 'dateEnd',
                    'separator' => 'до',
                    'options' => ['placeholder'=>'30/11/2017'],
                    'options2' => ['placeholder'=>'30/12/2017'],
                    'type' => FieldRange::INPUT_DATE,
                ]);
                ?>
            </div>
            </div>
            <div class="form-group align-right">
                <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
        <?php ActiveForm::end()?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'raw',
                'label' => 'Превью',
                'value' => function ($data) {
                    return Html::a(Html::img($data['preview'],['width' => '120px']), $data['preview'],['class' => 'test']);

                },
            ],
            [
                'attribute' => 'author_id',
                'value'=>function($model){
                    return $model->author->getFullName();
                }
            ],
            [
                'attribute' => 'date',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->date, 'long');
                },
            ],
            [
                'attribute' => 'date_create',
                'format' => 'html',
                   'value' => function ($model) {
                    $currentDate = time();
                    $date = strtotime($model->date_create);
                    $different = $currentDate - $date;
                    $addTime = floor($different/(60*60*24));
                    switch ($addTime){
                        case 0:
                            return 'Cегодня';
                            break;
                        case 1:
                            return 'Вчера';
                            break;
                        default:
                            return "{$addTime } дней назад";
                    }
                },
            ],
            [
             'class' => 'yii\grid\ActionColumn',
                'header' => 'Кнопки действий',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function($url, $model, $key) {
                    return Html::a('[просм]','#',['class'=>'view','model'=>$model->id]);
                },
                'update' => function($url, $model, $key) {
                    return Html::a('[ред]',\yii\helpers\Url::to(['books/update','id'=>$model->id]));
                },
                'delete' => function($url, $model, $key) {
                    return Html::a('[удл]','#',['class'=>'delete','model'=>$model->id]);
                },
            ]
        ],
        ],
    ]); ?>
</div>
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Просмотр книги</h4>
            </div>
            <div id="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>

