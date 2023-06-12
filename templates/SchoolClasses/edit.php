<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchoolClass $schoolClass
 * @var string[]|\Cake\Collection\CollectionInterface $teachers
 */

?>

<?= $this->Form->postLink(
    __('Delete class'),
    ['action' => 'delete', $schoolClass->id],
    ['confirm' => __('Are you sure you want to delete # {0}?', $schoolClass->id), 'class' => 'button float-right', 'style' => 'margin-right:5px']
) ?>
<?= $this->Form->create($schoolClass) ?>
<fieldset>
    <legend>
        <?= __('Edit Class') ?>
    </legend>

    <?php

    echo $this->Form->control('name', [
        'options' => $missingClasses,
        'label' => 'Class name',
        'default' => $schoolClass->name,
    ]);
 
    echo $this->Form->control('teacher_id', [
        'options' => $teachers,
        'label' => 'Teacher',
    ]);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>