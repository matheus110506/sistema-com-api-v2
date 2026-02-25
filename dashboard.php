<h2>Meus Filhos</h2>

<?php foreach ($filhos as $filho): ?>

    <h3><?= $filho["nome"] ?> (<?= $filho["idade"] ?> anos)</h3>

    <ul>
        <?php if (!empty($filho["tarefas"])): ?>
            <?php foreach ($filho["tarefas"] as $tarefa): ?>
                <li>
                    <?= $tarefa["titulo"] ?> 
                    - <?= $tarefa["status"] ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhuma tarefa cadastrada</li>
        <?php endif; ?>
    </ul>

<?php endforeach; ?>