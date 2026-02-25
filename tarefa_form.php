<h2>Cadastro de Tarefa</h2>

<form method="POST" action="index.php?page=tarefa_store">

    <input type="hidden" name="filho_id" value="<?php echo $filhoId; ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required></textarea><br><br>

    <button type="submit">Salvar</button>
</form>

<a href="index.php?page=tarefas&filho_id=<?php echo $filhoId; ?>">
    Voltar
</a>