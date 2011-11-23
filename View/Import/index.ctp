<div class="form">
<?php echo $this->Form->create('Import', array('type' => 'file'));?>
        <fieldset>
                <legend><?php __('Import Data'); ?></legend>
        <?php
		echo $this->Form->file('File');
        ?>
        </fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
<hr><pre><? echo print_r($import); ?></pre><hr>
</div>
