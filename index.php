<?php
session_start();

require_once "controllers/AuthController.php";
require_once "controllers/MaeController.php";
require_once "controllers/FilhoController.php";
require_once "controllers/TarefaController.php";

$page = $_GET["page"] ?? "login";

switch ($page) {

    case "cadastro":
        (new AuthController())->cadastro();
        break;

    case "login":
        (new AuthController())->login();
        break;

    case "logout":
        (new AuthController())->logout();
        break;

    case "dashboard":
        (new MaeController())->index();
        break;

    case "mae_create":
        (new MaeController())->create();
        break;

    case "mae_store":
        (new MaeController())->store();
        break;

    case "mae_edit":
        (new MaeController())->edit();
        break;

    case "mae_update":
        (new MaeController())->update();
        break;

    case "mae_delete":
        (new MaeController())->delete();
        break;

        case "filhos":
    (new FilhoController())->index();
    break;

    case "filho_create":
    (new FilhoController())->create();
    break;

    case "filho_store":
    (new FilhoController())->store();
    break;

    case "filho_edit":
    (new FilhoController())->edit();
    break;

    case "filho_update":
    (new FilhoController())->update();
    break;

    case "filho_delete":
    (new FilhoController())->delete();
    break;

    case "tarefas":
    (new TarefaController())->index();
    break;

    case "tarefa_create":
    (new TarefaController())->create();
    break;

    case "tarefa_store":
    (new TarefaController())->store();
    break;

    case "tarefa_update":
    (new TarefaController())->update();
    break;

    case "tarefa_delete":
    (new TarefaController())->delete();
    break;

    default:
        (new AuthController())->login();
}