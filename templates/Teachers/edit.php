<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Teacher $teacher
 */
?>
<?= $this->Form->postLink(
    __('Delete teacher'),
    ['action' => 'delete', $teacher->id],
    ['confirm' => __('Are you sure you want to delete # {0}?', $teacher->id), 'class' => 'button float-right', 'style' => 'margin-left:5px']
) ?>
<?= $this->Form->create($teacher, ['type' => 'put']) ?>

<fieldset>
        <legend><?= __('Edit Teacher') ?></legend>
       <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>


