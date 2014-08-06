<section id="main">
    
    <?php if (empty($board)): ?>
        <p class="alert alert-error"><?= t('There is no column in your project!') ?></p>
    <?php else: ?>
    	<?php 
        foreach ($board as $v=>$n) {
        	if (in_array($n['title'], array('Archive', 'Deleted'))) {
        		unset($board[$v]);
        	}
        }
        ?>
        <?= Helper\template('board_show', array('current_project_id' => $current_project_id, 'board' => $board, 'categories' => $categories)) ?>
    <?php endif ?>

</section>

<?= Helper\js('assets/js/board.js') ?>
