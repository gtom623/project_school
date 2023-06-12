<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \Cake\Collection\CollectionInterface|string[] $schoolClasses
 */
?>

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
       
