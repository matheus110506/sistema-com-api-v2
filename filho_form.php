<h2>Cadastro de Filho</h2>

<form method="POST" action="index.php?page=filho_store">

    <input type="hidden" name="mae_id" value="<?php echo $maeId; ?>">

    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <button type="submit">Salvar</button>
</form>

<a href="index.php?page=filhos&mae_id=<?php echo $maeId; ?>">
    Voltar
</a>