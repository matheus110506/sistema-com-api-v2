<?php
require_once "models/ApiModel.php";

class TarefaController {

    private $api;

    public function __construct() {
        $this->api = new ApiModel();
        $this->proteger();
    }

    private function proteger() {
        if (!isset($_SESSION["token"])) {
            header("Location: index.php?page=login");
            exit();
        }
    }

    public function index() {
        $token = $_SESSION["token"];
        $filhoId = $_GET["filho_id"];

        $tarefas = $this->api->listarTarefas($filhoId, $token);

        require "views/tarefas.php";
    }

    public function create() {
        $filhoId = $_GET["filho_id"];
        require "views/tarefa_form.php";
    }

    public function store() {
        $token = $_SESSION["token"];
        $filhoId = $_POST["filho_id"];

        $dados = [
            "titulo" => $_POST["titulo"],
            "descricao" => $_POST["descricao"]
        ];

        $this->api->criarTarefa($filhoId, $dados, $token);

        header("Location: index.php?page=tarefas&filho_id=$filhoId");
        exit();
    }

    public function update() {
        $token = $_SESSION["token"];
        $id = $_POST["id"];
        $filhoId = $_POST["filho_id"];

        $dados = [
            "titulo" => $_POST["titulo"],
            "descricao" => $_POST["descricao"]
        ];

        $this->api->atualizarTarefa($id, $dados, $token);

        header("Location: index.php?page=tarefas&filho_id=$filhoId");
        exit();
    }

    public function delete() {
        $token = $_SESSION["token"];
        $id = $_GET["id"];
        $filhoId = $_GET["filho_id"];

        $this->api->excluirTarefa($id, $token);

        header("Location: index.php?page=tarefas&filho_id=$filhoId");
        exit();
    }
}