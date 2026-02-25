<?php
require_once "models/ApiModel.php";

class FilhoController {

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
        $maeId = $_GET["mae_id"];

        $filhos = $this->api->listarFilhos($maeId, $token);

        require "views/filhos.php";
    }

    public function create() {
        $maeId = $_GET["mae_id"];
        require "views/filho_form.php";
    }

    public function store() {
        $token = $_SESSION["token"];
        $maeId = $_POST["mae_id"];

        $dados = [
            "nome" => $_POST["nome"]
        ];

        $this->api->criarFilho($maeId, $dados, $token);

        header("Location: index.php?page=filhos&mae_id=$maeId");
        exit();
    }

    public function edit() {
        $id = $_GET["id"];
        $maeId = $_GET["mae_id"];

        require "views/filho_form.php";
    }

    public function update() {
        $token = $_SESSION["token"];
        $id = $_POST["id"];
        $maeId = $_POST["mae_id"];

        $dados = [
            "nome" => $_POST["nome"]
        ];

        $this->api->atualizarFilho($id, $dados, $token);

        header("Location: index.php?page=filhos&mae_id=$maeId");
        exit();
    }

    public function delete() {
        $token = $_SESSION["token"];
        $id = $_GET["id"];
        $maeId = $_GET["mae_id"];

        $this->api->excluirFilho($id, $token);

        header("Location: index.php?page=filhos&mae_id=$maeId");
        exit();
    }
}