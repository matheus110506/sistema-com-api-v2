const jwt = require('jsonwebtoken');
const connection = require('../config/db');
const bcrypt = require('bcrypt');

exports.cadastrarUsuario = async (req, res) => {
    const { nome, email, senha } = req.body;

    if (!nome || !email || !senha) {
        return res.status(400).json({ mensagem: "Preencha todos os campos" });
    }

    try {

        connection.query(
            "SELECT id FROM usuarios WHERE email = ?",
            [email],
            async (err, results) => {
                if (err) {
                    return res.status(500).json({ erro: err });
                }
                if (results.length > 0) {
                    return res.status(400).json({ mensagem: "Email já cadastrado" });
                }

                const senhaHash = (await bcrypt.hash(senha, 10));

                connection.query(
                    "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)",
                    [nome, email, senhaHash],
                    (err, result) => {
                        if (err) {
                            return res.status(500).json({ erro: err });
                        }

                        res.status(201).json({
                            mensagem: "Usuário cadastrado com sucesso",
                            id: result.insertId
                        });
                    }
                );
            }
        );
    } catch (error) {
        res.status(500).json({ erro: error });
    }
};

exports.loginUsuario = (req, res) => {
    const { email, senha } = req.body;

    if (!email || !senha) {
        return res.status(400).json({ mensagem: "Preencha todos os campos" });
    }

    connection.query(
        "SELECT * FROM usuarios WHERE email = ?",
        [email],
        async (err, results) => {
            if (err) {
                return res.status(500).json({ erro: err });
            }

            if (results.length === 0) {
                return res.status(400).json({ mensagem: "Email ou senha inválidos" });
            }

            const usuario = results[0];

            const senhaValida = await bcrypt.compare(senha, usuario.senha);

            if (!senhaValida) {
                return res.status(400).json({ mensagem: "Email ou senha inválidos" });
            }

            const token = jwt.sign(
                { id: usuario.id, email: usuario.email },
                process.env.JWT_SECRET,
                { expiresIn: '1h' }
            );

            res.json({
                mensagem: "Login realizado com sucesso",
                token: token
            });
        }
    );
};