<?
$this->pageTitle=EO::app()->name . ' - Contact Us';
$this->breadcrumbs= [
	'Contact',
];
?>

<h1>Contact Us</h1>

<? if(EO::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?= EO::app()->user->getFlash('contact'); ?>
</div>

<? elseif(EO::app()->user->hasFlash('error')): ?>

<div class="flash-error">
	<?= EO::app()->user->getFlash('error'); ?>
</div>

<? else: ?>

<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

<? $form=$this->beginWidget('CActiveForm', [
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=> [
		'validateOnSubmit'=>true,
	],
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?= $form->errorSummary($model); ?>

	<div class="row">
		<?= $form->labelEx($model,'name'); ?>
		<?= $form->textField($model,'name'); ?>
		<?= $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?= $form->labelEx($model,'email'); ?>
		<?= $form->textField($model,'email'); ?>
		<?= $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?= $form->labelEx($model,'subject'); ?>
		<?= $form->textField($model,'subject', ['size'=>60,'maxlength'=>128]); ?>
		<?= $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?= $form->labelEx($model,'body'); ?>
		<?= $form->textArea($model,'body', ['rows'=>6, 'cols'=>50]); ?>
		<?= $form->error($model,'body'); ?>
	</div>

	<? if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?= $form->labelEx($model,'verifyCode'); ?>
		<div>
		<? $this->widget('CCaptcha'); ?>
		<?= $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?= $form->error($model,'verifyCode'); ?>
	</div>
	<? endif; ?>

	<div class="row buttons">
		<?= CHtml::submitButton('Submit'); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- form -->

<? endif; ?>