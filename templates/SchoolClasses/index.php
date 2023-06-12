<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchoolClass> $schoolClasses
 */
?>

    <?= $this->Html->link(__('New School Class'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('School Classes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('teacher_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schoolClasses as $schoolClass): ?>
                <tr>
                    <td><?= $this->Number->format($schoolClass->id) ?></td>
                    <td><?= h($schoolClass->name) ?></td>
                    <td><?= $schoolClass->has('teacher') ? $this->Html->link( $schoolClass->teacher->first_name . ' ' . $schoolClass->teacher->last_name, ['controller' => 'Teachers', 'action' => 'view', $schoolClass->teacher->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $schoolClass->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $schoolClass->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $schoolClass->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schoolClass->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>

