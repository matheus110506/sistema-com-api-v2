<?php
require_once "models/ApiModel.php";

class MaeController {

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
        $maes = $this->api->listarMaes($token);
        require "views/dashboard.php";
    }

    public function create() {
        require "views/mae_form.php";
    }

    public function store() {
        $token = $_SESSION["token"];

        $dados = [
            "nome" => $_POST["nome"]
        ];

        $this->api->criarMae($dados, $token);

        header("Location: index.php?page=dashboard");
        exit();
    }

    public function edit() {
        $id = $_GET["id"];
        require "views/mae_form.php";
    }

    public function update() {
        $token = $_SESSION["token"];
        $id = $_POST["id"];

        $dados = [
            "nome" => $_POST["nome"]
        ];

        $this->api->atualizarMae($id, $dados, $token);

        header("Location: index.php?page=dashboard");
        exit();
    }

    public function delete() {
        $token = $_SESSION["token"];
        $id = $_GET["id"];

        $this->api->excluirMae($id, $token);

        header("Location: index.php?page=dashboard");
        exit();
    }
}