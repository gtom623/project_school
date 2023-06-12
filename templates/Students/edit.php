<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var string[]|\Cake\Collection\CollectionInterface $schoolClasses
 */
?>
        <?= $this->Form->postLink(
                __('Delete student'),
                ['action' => 'delete', $student->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'button float-right','style' => 'margin-right:5px']
            ) ?>    
        <?= $this->Form->create($student) ?>
            <fieldset>
                <legend><?= __('Edit Student') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->label('gender', __('Gender'));
                    echo $this->Form->select('gender', $genderGroups,);  
                    echo $this->Form->control('school_class_id', ['options' => $schoolClasses]);
                    echo $this->Form->label('language', __('Language'));
                    echo $this->Form->select('language_group', $languageGroups);  
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
   