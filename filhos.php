<h2>Filhos</h2>

<p>
    <a href="index.php?page=dashboard">Voltar</a> |
    <a href="index.php?page=filho_create&mae_id=<?php echo $maeId; ?>">
        Novo Filho
    </a>
</p>

<?php if (!empty($filhos) && is_array($filhos)): ?>

    <ul>
        <?php foreach ($filhos as $filho): ?>
            <li>
                <strong>
                    <?php echo htmlspecialchars($filho["nome"]); ?>
                </strong>

                | <a href="index.php?page=filho_edit&id=<?php echo $filho["id"]; ?>&mae_id=<?php echo $maeId; ?>">
                    Editar
                  </a>

                | <a href="index.php?page=filho_delete&id=<?php echo $filho["id"]; ?>&mae_id=<?php echo $maeId; ?>"
                     onclick="return confirm('Tem certeza que deseja excluir?')">
                    Excluir
                  </a>

                | <a href="index.php?page=tarefas&filho_id=<?php echo $filho["id"]; ?>">
                    Ver Tarefas
                  </a>
            </li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>
    <p>Nenhum filho cadastrado.</p>
<?php endif; ?>