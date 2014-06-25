<section id="main" class="public-board">

    <?php if (empty($columns)): ?>
        <p class="alert alert-error"><?= t('There is no column in your project!') ?></p>
    <?php else: ?>
        <table id="board">
            <tr>
                <?php $column_with = round(100 / count($columns), 2); ?>
                <?php foreach ($columns as $column): ?>
                <th width="<?= $column_with ?>%">
                    <?= Helper\escape($column['title']) ?>
                    <?php if ($column['task_limit']): ?>
                        <span title="<?= t('Task limit') ?>" class="task-limit">(<?= Helper\escape(count($column['tasks']).'/'.$column['task_limit']) ?>)</span>
                    <?php endif ?>
                </th>
                <?php endforeach ?>
            </tr>
            

        <?php foreach ($categories as $cid=>$category) { ?>
        <?php if ($category == 'All categories') continue; ?>
        <tr>
        <td colspan="10"><span style="font-weight:bold; font-size:20px"><strong><?=$category;?></strong></span></td>
        </tr>

        <tr>
        <?php foreach ($board as $column): ?>
            <td
                id="column-<?= $column['id'] ?>"
                class="column <?= $column['task_limit'] && count($column['tasks']) > $column['task_limit'] ? 'task-limit-warning' : '' ?>"
                data-column-id="<?= $column['id'] ?>"
                data-task-limit="<?= $column['task_limit'] ?>"
                >
                <?php 
                    $colors[0] = '';
                    $colors[1] = '';
                    $colors[2] = 'yellow';
                    $colors[3] = 'blue';
                ?>
                <?php $tmpCat = 0;?>
                <?php foreach ($column['tasks'] as $task): ?>
                    <?php if ($task['category_id'] == $cid) { ?>

                    
                    
                    <div class="task-board task-<?= $colors[$task['owner_id']] ?>"
                         title="<?= t('View this task') ?>">

                        <?= Helper\template('board_task', array('task' => $task, 'categories' => $categories)) ?>

                    </div>
                    <?php } ?>

                    <?php $tmpCat = $task['category_id']; ?>
                <?php endforeach ?>
            </td>
        <?php endforeach ?>
        </tr>
    <?php } ?>



        </table>
    <?php endif ?>

</section>