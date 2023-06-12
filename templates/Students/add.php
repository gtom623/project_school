<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \Cake\Collection\CollectionInterface|string[] $schoolClasses
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Students'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="students form content">
            <?= $this->Form->create($student) ?>
            <fieldset>
                <legend><?= __('Add Student') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');                   
          
                    echo $this->Form->label('gender', __('Gender'));
                    echo $this->Form->select('gender', $genderGroups, ['empty' => __('Select Gender')]);  

                    echo $this->Form->control('school_class_id', ['options' => $schoolClasses, 'empty' => __('Select Class')]);
                    echo $this->Form->label('language', __('Language'));
                    echo $this->Form->select('language_group', $languageGroups, ['empty' => __('Select Language')]);  
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
