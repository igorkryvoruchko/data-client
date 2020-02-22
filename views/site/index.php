<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Send Query';
?>
<div>
    <p><?=Html::a(\Yii::t('app', 'Send XML Query'), ['site/send-query'], ['class' => 'btn btn-success'])?></p>
    <pre>$data = [
            "firstName" => "Vasya",
            "lastName" => "Pupkin",
            "dateOfBirth" => "1984-07-31",
            "Salary"    	=> "1000",
            "creditScore" => "good"
        ];</pre>
</div>
