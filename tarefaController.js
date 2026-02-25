const db = require("../config/db");

// Criar tarefa
exports.criarTarefa = async (req, res) => {
    const { titulo, descricao, filho_id } = req.body;
    const usuario_id = req.usuario.id;

    if (!titulo || !filho_id) {
        return res.status(400).json({ mensagem: "Título e filho são obrigatórios" });
    }

    try {
        // 🔐 Verifica se o filho pertence ao usuário logado
        const [filho] = await db.execute(
            "SELECT id FROM filhos WHERE id = ? AND usuario_id = ?",
            [filho_id, usuario_id]
        );

        if (filho.length === 0) {
            return res.status(403).json({ mensagem: "Acesso negado" });
        }

        const [result] = await db.execute(
            "INSERT INTO tarefas (titulo, descricao, filho_id) VALUES (?, ?, ?)",
            [titulo, descricao, filho_id]
        );

        res.status(201).json({
            mensagem: "Tarefa criada com sucesso",
            id: result.insertId
        });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};


// Listar tarefas de um filho
exports.listarTarefas = async (req, res) => {
    const { filho_id } = req.params;
    const usuario_id = req.usuario.id;

    try {
        const [filho] = await db.execute(
            "SELECT id FROM filhos WHERE id = ? AND usuario_id = ?",
            [filho_id, usuario_id]
        );

        if (filho.length === 0) {
            return res.status(403).json({ mensagem: "Acesso negado" });
        }

        const [rows] = await db.execute(
            "SELECT * FROM tarefas WHERE filho_id = ?",
            [filho_id]
        );

        res.json(rows);

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};


// Atualizar tarefa
exports.atualizarTarefa = async (req, res) => {
    const { id } = req.params;
    const { titulo, descricao, status } = req.body;
    const usuario_id = req.usuario.id;

    try {
        const [tarefa] = await db.execute(
            `SELECT t.id 
             FROM tarefas t
             JOIN filhos f ON t.filho_id = f.id
             WHERE t.id = ? AND f.usuario_id = ?`,
            [id, usuario_id]
        );

        if (tarefa.length === 0) {
            return res.status(403).json({ mensagem: "Acesso negado" });
        }

        await db.execute(
            "UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ?",
            [titulo, descricao, status, id]
        );

        res.json({ mensagem: "Tarefa atualizada com sucesso" });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};


// Excluir tarefa
exports.excluirTarefa = async (req, res) => {
    const { id } = req.params;
    const usuario_id = req.usuario.id;

    try {
        const [tarefa] = await db.execute(
            `SELECT t.id 
             FROM tarefas t
             JOIN filhos f ON t.filho_id = f.id
             WHERE t.id = ? AND f.usuario_id = ?`,
            [id, usuario_id]
        );

        if (tarefa.length === 0) {
            return res.status(403).json({ mensagem: "Acesso negado" });
        }

        await db.execute(
            "DELETE FROM tarefas WHERE id = ?",
            [id]
        );

        res.json({ mensagem: "Tarefa excluída com sucesso" });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};