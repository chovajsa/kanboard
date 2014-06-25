<section id="main">
    
    <?php if (empty($board)): ?>
        <p class="alert alert-error"><?= t('There is no column in your project!') ?></p>
    <?php else: ?>
        <?= Helper\template('board_show', array('current_project_id' => $current_project_id, 'board' => $board, 'categories' => $categories)) ?>
    <?php endif ?>

</section>

<?= Helper\js('assets/js/board.js') ?>
