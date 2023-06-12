<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>

<?= $this->Html->link(__('Edit Student'), ['action' => 'edit', $student->id], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<?= $this->Form->postLink(__('Delete Student'), ['action' => 'delete', $student->id], ['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<?= $this->Html->link(__('New Student'), ['action' => 'add'], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<h3>
    <?= __('Student') ?>
</h3>
<table>
    <tr>
        <th>
            <?= __('First Name') ?>
        </th>
        <td>
            <?= h($student->first_name) ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('Last Name') ?>
        </th>
        <td>
            <?= h($student->last_name) ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('Gender') ?>
        </th>
        <td>
            <?= h($student->gender) ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('School Class') ?>
        </th>
        <td>
            <?= $student->has('school_class') ? $this->Html->link($student->school_class->name, ['controller' => 'SchoolClasses', 'action' => 'view', $student->school_class->id]) : '' ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('Language Group') ?>
        </th>
        <td>
            <?= h($student->language_group) ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('Id') ?>
        </th>
        <td>
            <?= $this->Number->format($student->id) ?>
        </td>
    </tr>
</table>