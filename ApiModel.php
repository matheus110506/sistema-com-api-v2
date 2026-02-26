<?php

class ApiModel {

    private $baseUrl = "http://localhost:3000";

private function request($endpoint, $method = "GET", $data = null, $token = null) {

    $url = $this->baseUrl . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = ['Content-Type: application/json'];

    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method !== "GET") {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Erro cURL: " . curl_error($ch);
        exit();
    }

    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return json_decode($response, true);
}

    public function cadastro($nome, $email, $senha) {
        return $this->request("/auth/cadastro", "POST", [
            "nome" => $nome,
            "email" => $email,
            "senha" => $senha
        ]);
    }

    public function login($email, $senha) {
        return $this->request("/auth/login", "POST", [
            "email" => $email,
            "senha" => $senha
        ]);
    }

    public function listarFilhos($token) {
        return $this->request("/filhos", "GET", null, $token);
    }

    public function criarFilho($dados, $token) {
        return $this->request("/filhos", "POST", $dados, $token);
    }

    public function atualizarFilho($id, $dados, $token) {
        return $this->request("/filhos/$id", "PUT", $dados, $token);
    }

    public function excluirFilho($id, $token) {
        return $this->request("/filhos/$id", "DELETE", null, $token);
    }

    public function listarTarefas($filhoId, $token) {
        return $this->request("/tarefas/$filhoId", "GET", null, $token);
    }

    public function criarTarefa($dados, $token) {
        return $this->request("/tarefas", "POST", $dados, $token);
    }

    public function atualizarTarefa($id, $dados, $token) {
        return $this->request("/tarefas/$id", "PUT", $dados, $token);
    }

    public function excluirTarefa($id, $token) {
        return $this->request("/tarefas/$id", "DELETE", null, $token);
    }
}
