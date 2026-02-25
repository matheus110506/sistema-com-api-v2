<h2>Tarefas</h2>

<a href="index.php?page=filhos&mae_id=<?php echo $_GET["mae_id"] ?? ''; ?>">
    Voltar para Filhos
</a>

<a href="index.php?page=tarefa_create&filho_id=<?php echo $filhoId; ?>">
    Nova Tarefa
</a>

<?php if (!empty($tarefas)): ?>
    <ul>
        <?php foreach ($tarefas as $tarefa): ?>
            <li>
                <strong><?php echo htmlspecialchars($tarefa["titulo"]); ?></strong>
                - <?php echo htmlspecialchars($tarefa["descricao"]); ?>

                | <a href="index.php?page=tarefa_delete&id=<?php echo $tarefa["id"]; ?>&filho_id=<?php echo $filhoId; ?>">
                    Excluir
                  </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Nenhuma tarefa cadastrada.</p>
<?php endif; ?>