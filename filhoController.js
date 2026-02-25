const db = require("../config/db");

// Criar filho
exports.criarFilho = async (req, res) => {
    const { nome, idade } = req.body;
    const usuario_id = req.usuario.id;

    if (!nome) {
        return res.status(400).json({ mensagem: "Nome é obrigatório" });
    }

    try {
        const [result] = await db.execute(
            "INSERT INTO filhos (nome, idade, usuario_id) VALUES (?, ?, ?)",
            [nome, idade, usuario_id]
        );

        res.status(201).json({
            mensagem: "Filho cadastrado com sucesso",
            id: result.insertId
        });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};

// Listar filhos do usuário logado
exports.listarFilhos = async (req, res) => {
    const usuario_id = req.usuario.id;

    try {
        const [rows] = await db.execute(
            "SELECT * FROM filhos WHERE usuario_id = ?",
            [usuario_id]
        );

        res.json(rows);

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};

// Atualizar filho
exports.atualizarFilho = async (req, res) => {
    const { id } = req.params;
    const { nome, idade } = req.body;
    const usuario_id = req.usuario.id;

    try {
        const [result] = await db.execute(
            "UPDATE filhos SET nome = ?, idade = ? WHERE id = ? AND usuario_id = ?",
            [nome, idade, id, usuario_id]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({ mensagem: "Filho não encontrado" });
        }

        res.json({ mensagem: "Filho atualizado com sucesso" });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};

// Excluir filho
exports.excluirFilho = async (req, res) => {
    const { id } = req.params;
    const usuario_id = req.usuario.id;

    try {
        const [result] = await db.execute(
            "DELETE FROM filhos WHERE id = ? AND usuario_id = ?",
            [id, usuario_id]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({ mensagem: "Filho não encontrado" });
        }

        res.json({ mensagem: "Filho excluído com sucesso" });

    } catch (error) {
        res.status(500).json({ erro: error.message });
    }
};