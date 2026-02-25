const express = require("express");
const router = express.Router();
const TarefaController = require("../controllers/TarefaController");
const authMiddleware = require("../middlewares/authMiddleware");

router.post("/", authMiddleware, TarefaController.criarTarefa);
router.get("/:filho_id", authMiddleware, TarefaController.listarTarefas);
router.put("/:id", authMiddleware, TarefaController.atualizarTarefa);
router.delete("/:id", authMiddleware, TarefaController.excluirTarefa);

module.exports = router;