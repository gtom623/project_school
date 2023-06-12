<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchoolClass $schoolClass
 */
?>

        <?= $this->Html->link(__('Edit Class'), ['action' => 'edit', $schoolClass->id], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
            <?= $this->Form->postLink(__('Delete Class'), ['action' => 'delete', $schoolClass->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schoolClass->id), 'class' => 'button float-right', 'style' => 'margin-right:5px']) ?>
            <?= $this->Html->link(__('New Class'), ['action' => 'add'], ['class' => 'button float-right', 'style' => 'margin-right:5px']) ?>    
        <h3><?= __('Class details') ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($schoolClass->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Teacher') ?></th>
                    <td><?= $schoolClass->has('teacher') ? $this->Html->link($schoolClass->teacher->first_name . ' ' . $schoolClass->teacher->last_name, ['controller' => 'Teachers', 'action' => 'view', $schoolClass->teacher->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($schoolClass->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Students') ?></h4>
                <?php if (!empty($schoolClass->students)) : ?>
                <div class="table-responsive">
                      <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Gender') ?>
                           
                            <?= $this->Html->link('∧', ['action' => 'view', $schoolClass->id, '?' => ['sort' => 'gender', 'direction' => 'asc']], ['escape' => false]) ?>
                            <?= $this->Html->link('∨', ['action' => 'view', $schoolClass->id, '?' => ['sort' => 'gender', 'direction' => 'desc']], ['escape' => false]) ?>
   
                        </th>
                            <th><?= __('School Class Id') ?></th>
                            <th><?= __('Language Group') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($schoolClass->students as $students) : ?>
                        <tr>
                            <td><?= h($students->id) ?></td>
                            <td><?= h($students->first_name) ?></td>
                            <td><?= h($students->last_name) ?></td>
                            <td><?= h($students->gender) ?></td>
                            <td><?= h($students->school_class_id) ?></td>
                            <td><?= h($students->language_group) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Students', 'action' => 'view', $students->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Students', 'action' => 'edit', $students->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Students', 'action' => 'delete', $students->id], ['confirm' => __('Are you sure you want to delete # {0}?', $students->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
      