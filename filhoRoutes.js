const express = require("express");
const router = express.Router();
const FilhoController = require("../controllers/FilhoController");
const authMiddleware = require("../middlewares/authMiddleware");

router.post("/", authMiddleware, FilhoController.criarFilho);
router.get("/", authMiddleware, FilhoController.listarFilhos);
router.put("/:id", authMiddleware, FilhoController.atualizarFilho);
router.delete("/:id", authMiddleware, FilhoController.excluirFilho);

module.exports = router;