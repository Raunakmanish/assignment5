<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
  <?= $this->Html->css([
    
        'milligram.min',
        'cake',
        'style'
          
]) ?>
         <?php echo $this->Flash->render() ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
       <?php  echo $this->Form->create($user,['type'=>'file']);?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('user_profile.first_name');
                    echo $this->Form->control('user_profile.last_name');
                    echo $this->Form->control('user_profile.contact');
                    echo $this->Form->control('user_profile.address');
                    echo $this->Form->control('user_profile.images',['type'=>'file']);
                    // echo $this->Form->control('user_profile.profile_image');
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('confirm password');

                    // echo $this->Form->control('user_type');
                    // echo $this->Form->control('status');
                    // echo $this->Form->control('created_date');
                    // echo $this->Form->control('modified_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
