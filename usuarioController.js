const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");
const db = require("../config/db");

exports.cadastrarUsuario = async (req, res) => {
    try {
        const { nome, email, senha } = req.body;

        const senhaCriptografada = await bcrypt.hash(senha, 10);

        await db.execute(
            "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)",
            [nome, email, senhaCriptografada]
        );

        res.status(201).json({ mensagem: "Usuário cadastrado com sucesso" });

    } catch (error) {
        console.error(error);
        res.status(500).json({ mensagem: "Erro no cadastro" });
    }
};

exports.loginUsuario = async (req, res) => {
    try {
        const { email, senha } = req.body;

        const [rows] = await db.execute(
            "SELECT * FROM usuarios WHERE email = ?",
            [email]
        );

        if (rows.length === 0) {
            return res.status(401).json({ mensagem: "Usuário não encontrado" });
        }

        const usuario = rows[0];

        const senhaValida = await bcrypt.compare(senha, usuario.senha);

        if (!senhaValida) {
            return res.status(401).json({ mensagem: "Senha inválida" });
        }

        const token = jwt.sign(
            { id: usuario.id, email: usuario.email },
            process.env.JWT_SECRET,
            { expiresIn: "1d" }
        );

        res.json({ token });

    } catch (error) {
        console.error(error);
        res.status(500).json({ mensagem: "Erro no login" });
    }
};
