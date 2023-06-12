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
    <?php if (!empty($missingClasses)) {
        echo 'Class without a Teacher: ' . implode(', ', $missingClasses);
    } else {
        echo 'No free classes. Delete the class first';
    } ?>
    <?php

    echo $this->Form->control('name', [
        'options' => $missingClasses,
        'label' => 'Class name'
    ]);

    if (!$teachers->count()) {
        echo 'No free teachers. Add a teacher ' . implode(', ', $missingClasses);
    }
    echo $this->Form->control('teacher_id', [
        'options' => $teachers,
        'label' => 'Free Teacher'
    ]);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>