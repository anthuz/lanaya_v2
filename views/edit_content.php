<?=get_messages_from_session()?>
<?php if($content['created']): ?>
	<h1>Edit Content</h1>
	<p>You can edit and save this content.</p>
<?php else: ?>
	<h1>Create Content</h1>
	<p>Create new content.</p>
<?php endif; ?>
<br/>

<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='smaller-text'><em>
	<?php if($content['created']): ?>
		This content were created by <?=$content['owner']?> <?=$content['created']?> ago.
	<?php else: ?>
		Content not yet created.
	<?php endif; ?>

	<?php if(isset($content['updated'])):?>
		Last updated <?=$content['updated']?>.
	<?php endif; ?>
</em></p>

<?php if(!$content['created']): ?>
	<br/>
		<h4>To DELETE ALL contents in the database you must write "delete all" in the Title AND Key textfield before you press the button "Delete all"!</h4>
<?php endif; ?>
<br/>