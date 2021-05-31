<?php
require('../../app_lista_tarefas/tarefa.model.php');
require('../../app_lista_tarefas/tarefa.service.php');
require('../../app_lista_tarefas/conexao.php');


$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

if ($acao == 'inserir') {
    try {
        $tarefa = new Tarefa();
        $tarefa->__set('tarefa', $_POST['tarefa']);
    
        $conexao = new Conexao();
    
        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->inserir();
        header('Location: nova_tarefa.php?inclusao=1');
    } catch (Exception $e) {
        header('Location: nova_tarefa.php?inclusao=2');
    }
}else if($acao == 'recuperar'){
   $tarefa = new Tarefa();
   $conexao = new Conexao();

   $tarefaService = new TarefaService($conexao, $tarefa);
   $tarefas = $tarefaService->recuperar();
}
else if($acao == 'atualizar'){
    try {
        $tarefa = new Tarefa();
        $tarefa->__set('tarefa', $_POST['tarefa']);
        $tarefa->__set('id', $_POST['id']);
        $conexao = new Conexao();
     
        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefas = $tarefaService->atualizar();
        header('Location: todas_tarefas.php?alteracao=1');
    } catch (Exception $e) {
        header('Location: todas_tarefas.php?alteracao=2');
    }
 
 }
 else if($acao == 'remover'){
    try {
        $tarefa = new Tarefa();
        $tarefa->__set('id', $_GET['id']);
        $conexao = new Conexao();
     
        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->remover();
        header('Location: todas_tarefas.php?remocao=1');
    } catch (Exception $e) {
        header('Location: todas_tarefas.php?remocao=2');
    }
 }
 else if($acao == 'marcarRealizada'){
    try {
        $tarefa = new Tarefa();
        $tarefa->__set('id', $_GET['id']);
        $tarefa->__set('id_status', 2);
        $conexao = new Conexao();
     
        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefaService->marcarRealizada();
        header('Location: todas_tarefas.php');
    } catch (Exception $e) {
    }
 }
 else if($acao == 'pendentes'){
    try {
        $tarefa = new Tarefa();
        $conexao = new Conexao();
     
        $tarefaService = new TarefaService($conexao, $tarefa);
        $tarefas = $tarefaService->listarPendentes();
    } catch (Exception $e) {
    }
 }
 
 
