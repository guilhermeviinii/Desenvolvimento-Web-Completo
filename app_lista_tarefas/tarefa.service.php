<?php

class TarefaService
{
    private $conexao;
    private $tarefa;
    public function __construct(Conexao $conexao, Tarefa $tarefa)
    {
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    public function inserir()
    {
        $query = ' insert into tb_tarefas(tarefa) values (:tarefa)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->execute();
    }

    public function recuperar()
    {
        $query = " select
                        t.id, t.id_status, t.tarefa, s.status
                   from 
                        tb_tarefas as t
                        left join tb_status as s on (s.id = t.id_status)";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar()
    {
        $query = " update tb_tarefas set
                        tarefa = :tarefa
                   where id = :id ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $stmt->bindValue(':id', $this->tarefa->__get('id'));
        $stmt->execute();
    }

    public function remover()
    {
        $query = " delete from tb_tarefas where id = :id ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->tarefa->__get('id'));
        $stmt->execute();
    }

    public function marcarRealizada()
    {
        $query = " update tb_tarefas set
                     id_status = :id_status
                   where id = :id ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
        $stmt->bindValue(':id', $this->tarefa->__get('id'));
        $stmt->execute();
    }
    public function listarPendentes()
    {
        $query = " select
        t.id, t.id_status, t.tarefa, s.status
   from 
        tb_tarefas as t
        left join tb_status as s on (s.id = t.id_status) where s.id = 1";

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
