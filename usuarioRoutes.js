const express = require('express');
const router = express.Router();
const usuarioController = require('../controllers/usuarioController');
const authMiddleware = require('../middlewares/authMiddleware');

router.post('/usuarios', usuarioController.cadastrarUsuario);
router.post('/login', usuarioController.loginUsuario);
router.get('/perfil', authMiddleware.verificarToken, (req, res) => {
    res.json({
        mensagem: "Rota protegida acessada",
        usuario: req.usuario
    });
});

module.exports = router;