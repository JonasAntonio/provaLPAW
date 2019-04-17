<?php
/**
 * Created by PhpStorm.
 * User: alunoces
 * Date: 16/04/2019
 * Time: 21:59
 */

class avaliacaoDAO{

    public function remover($avaliacao) {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM avalicacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($avaliacao) {
        global $pdo;
        try {
            if ($avaliacao->getIdAvaliacao() != "") {
                $statement = $pdo->prepare("UPDATE avaliacao SET Turma_idTurma=:turma, Aluno_idAluno=:aluno, Nota1=:nota1, Nota2=:nota2, Nota3=:nota3, Nota4=:nota4, NotaFinal=:notaFinal,Situacao=:situacao  WHERE idAvaliacao = :id;");
                $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            } else {
                $statement = $pdo->prepare("INSERT INTO avaliacao (Turma_idTurma, Aluno_idAluno, Nota1, Nota2, Nota3, Nota4, NotaFinal, Situacao) VALUES (:turma, :aluno, :nota1,:nota2,:nota3,:nota4,:notaFinal, :situacao )");
            }
            $statement->bindValue(":turma",$avaliacao->getTurma());
            $statement->bindValue(":aluno",$avaliacao->getAluno());
            $statement->bindValue(":nota1",$avaliacao->getNota1());
            $statement->bindValue(":nota2",$avaliacao->getNota2());
            $statement->bindValue(":nota3",$avaliacao->getNota3());
            $statement->bindValue(":nota4",$avaliacao->getNota4());
            $statement->bindValue(":notaFinal",$avaliacao->getNotaFinal());
            $statement->bindValue(":situacao",$avaliacao->getSituacao());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";
                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($avaliacao) {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT * FROM avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $avaliacao->getIdAvaliacao());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $avaliacao->setIdAvaliacao($rs->idAvaliacao);
                $avaliacao->setTurma($rs->Turma_idTurma);
                $avaliacao->setAluno($rs->Aluno_idAluno);
                $avaliacao->setNota1($rs->Nota1);
                $avaliacao->setNota2($rs->Nota2);
                $avaliacao->setNota3($rs->Nota3);
                $avaliacao->setNota4($rs->Nota4);
                $avaliacao->setNotaFinal($rs->NotaFinal);
                $avaliacao->setSituacao($rs->Situacao);
                return $avaliacao;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {
        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT * FROM avaliacao LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM Disciplina";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Código</th>
        <th>Turma</th>
        <th>Aluno</th>
        <th>Nota 1</th>
        <th>Nota 2</th>
        <th>Nota 3</th>
        <th>Nota 4</th>
        <th>Nota Final</th>
        <th>Situação</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach($dados as $inst):
                echo "<tr>
        <td>$inst->idAvaliacao</td>
        <td>$inst->Turma_idTurma</td>
        <td>$inst->Aluno_idAluno</td>
        <td>$inst->Nota1</td>
        <td>$inst->Nota2</td>
        <td>$inst->Nota3</td>
        <td>$inst->Nota4</td>
        <td>$inst->NotaFinal</td>
        <td>$inst->Situacao</td>
        <td><a href='?act=upd&id=$inst->idDisciplina'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$inst->idDisciplina'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo"
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";
endif;
        }

}