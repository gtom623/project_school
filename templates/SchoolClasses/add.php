<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchoolClass $schoolClass
 * @var \Cake\Collection\CollectionInterface|string[] $teachers
 */
?>

<?= $this->Form->create($schoolClass) ?>
<fieldset>
    <legend><?= __('Add School Class') ?></legend>
    <?php if (!empty($missingClasses)) {
        echo 'Class without a Teacher: ' . implode(', ', $missingClasses);
    } ?>
    <?php
    echo $this->Form->control('name', ['options' => $missingClasses]);
    echo $this->Form->control('teacher_id', ['options' => $teachers]);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>