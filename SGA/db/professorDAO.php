<?php
/**
 * Created by PhpStorm.
 * User: alunoces
 * Date: 16/04/2019
 * Time: 21:03
 */

require_once "conexao.php";
require_once "classes/professor.php";

class professorDAO {
    public function remover($professor) {
        GLOBAL $pdo;

        try {
            $id = $professor->getIdProfessor();
            $statement = $pdo->prepare("DELETE FROM Professor WHERE idProfessor = :id");
            $statement->bindValue(":id", $id);
            if ($statement->execute()) {
                echo "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($professor) {
        GLOBAL $pdo;
        try {
            $id = $professor->getIdProfessor();
            if ($id != "") {
                $statement = $pdo->prepare("UPDATE Professor SET Nome=:nome, Cargo=:cargo  WHERE idProfessor = :id;");
                $statement->bindValue(":id", $id);
            } else {
                $statement = $pdo->prepare("INSERT INTO Professor (Nome, Cargo) VALUES (:nome, :cargo)");
            }
            $statement->bindValue(":nome", $professor->getNomeProfessor());
            $statement->bindValue(":cargo",$professor->getCargoProfessor());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    echo "Dados cadastrados com sucesso!";
                } else {
                    echo "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($professor) {
        GLOBAL $pdo;

        try {
            $statement = $pdo->prepare("SELECT idProfessor, Nome, Cargo FROM Professor WHERE idProfessor = :id");
            $statement->bindValue(":id", $professor->getIdProfessor());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $professor->setIdProfessor($rs->idProfessor);
                $professor->setNomeProfessor($rs->Nome);
                $professor->setCargoProfessor($rs->Cargo);
                return $professor;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {
        GLOBAL $pdo;
        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 3);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT idProfessor, Nome, Cargo FROM Professor LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM Professor";
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
                <th>Nome</th>
                <th>Cargo</th>
                <th colspan=\"2\">Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $var):
                echo "
                <tr>
                <td>$var->idProfessor</td>
                <td>$var->Nome</td>
                <td>$var->Cargo</td>
                <td><a href='?act=upd&id=$var->idProfessor'><i class=\"ti-reload\"></i></a></td>
                <td><a href='?act=del&id=$var->idProfessor'><i class=\"ti-close\"></i></a></td>
               </tr>
                ";
            endforeach;
            echo "
             </tbody>
             </table>
        
             <div class='box-paginacao'>
               <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
               <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
            ";
            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
               <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
             </div>";
                else:
                    echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
             ";
        endif;
    }
}