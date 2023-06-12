<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Teacher $teacher
 */
?>

<?= $this->Html->link(__('Edit Teacher'), ['action' => 'edit', $teacher->id], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<?= $this->Form->postLink(__('Delete Teacher'), ['action' => 'delete', $teacher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $teacher->id), 'class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<?= $this->Html->link(__('New Teacher'), ['action' => 'add'], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
<h3>
    <?= __('Teacher') ?>
</h3>
<table>
    <tr>
        <th>
            <?= __('First Name') ?>
        </th>
        <td>
            <?= h($teacher->first_name) ?>
        </td>
    </tr>
    <tr>
        <th>
            <?= __('Last Name') ?>
        </th>
        <td>
            <?= h($teacher->last_name) ?>
        </td>
    </tr>

</table>
<div class="related">
    <?php if (!empty($teacher->school_classes)): ?>
        <h4>
            <?= __('Teaches class:') ?>
        </h4>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>
                        <?= __('Id') ?>
                    </th>
                    <th>
                        <?= __('Name') ?>
                    </th>

                    <th>
                        <?= __('Students') ?>
                    </th>
                    <th class="actions">
                        <?= __('Actions') ?>
                    </th>
                </tr>
                <?php foreach ($teacher->school_classes as $schoolClasses): ?>
                    <tr>
                        <td>
                            <?= h($schoolClasses->id) ?>
                        </td>
                        <td>
                            <?= h($schoolClasses->name) ?>
                        </td>

                        <td>
                            <?= h($schoolClasses->students_count) ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'SchoolClasses', 'action' => 'view', $schoolClasses->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'SchoolClasses', 'action' => 'edit', $schoolClasses->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'SchoolClasses', 'action' => 'delete', $schoolClasses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schoolClasses->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
</div>