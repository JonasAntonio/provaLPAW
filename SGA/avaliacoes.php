<?php
/**
 * Created by PhpStorm.
 * User: alunoces
 * Date: 16/04/2019
 * Time: 21:58
 */

include_once 'estrutura/Template.php';

//Class
require_once 'db/avaliacaoDAO.php';

$template = new Template();

$template->header();
$template->sidebar();
$template->navbar();


$object = new avaliacaoDAO();

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $turma = (isset($_POST["turma"]) && $_POST["turma"] != null) ? $_POST["turma"] : "";
    $aluno = (isset($_POST["aluno"]) && $_POST["aluno"] != null) ? $_POST["aluno"] : "";
    $situacao = (isset($_POST["situacao"]) && $_POST["situacao"] != null) ? $_POST["situacao"] : "";
    $nota1 = (isset($_POST["nota1"]) && $_POST["nota1"] != null) ? $_POST["nota1"] : "";
    $nota2 = (isset($_POST["nota2"]) && $_POST["nota2"] != null) ? $_POST["nota2"] : "";
    $nota3 = (isset($_POST["nota3"]) && $_POST["nota3"] != null) ? $_POST["nota3"] : "";
    $nota4 = (isset($_POST["nota4"]) && $_POST["nota4"] != null) ? $_POST["nota4"] : "";
    $notaFinal = (isset($_POST["notaFinal"]) && $_POST["notaFinal"] != null) ? $_POST["notaFinal"] : "";

} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $turma = NULL;
    $aluno = NULL;
    $situacao = null;
    $nota1 = null;
    $nota2 = null;
    $nota3 = null;
    $nota4 = null;
    $notaFinal = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    $avaliacao = new avaliacao($id, '', '', '','', '', '', '', '');
    $resultado = $object->atualizar($avaliacao);
    $turma = $resultado->getTurma();
    $aluno = $resultado->getAluno();
    $situacao = $resultado->getSituacao();
    $nota1 = $resultado->getNota1();
    $nota2 = $resultado->getNota2();
    $nota3 = $resultado->getNota3();
    $nota4 = $resultado->getNota4();
    $notaFinal = $resultado->getNotaFinal();
}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $turma != "") {
    $avaliacao = new avaliacao($id, $aluno, $turma, $situacao,$nota1);
    $msg =$object->salvar($avaliacao);
    $id = null;
    $turma = null;
    $aluno = null;
    $situacao = null;
    $nota1 = null;
    $nota2 = null;
    $nota3 = null;
    $nota4 = null;
    $notaFinal = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $avaliacao = new avaliacao($id, '', '', '','', '', '', '', '');
    $msg = $object->remover($avaliacao);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Disciplinas</h4>
                        <p class='category'>Lista de disciplinas do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save" method="POST" name="form1" >
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>" />
                            Aluno:
                            <select name="aluno">
                                <option value="">--Selecione--</option>
                                <?php
//                                $query = "SELECT * FROM aluno order by Nome;";
//                                $statement = $pdo->prepare($query);
//                                if ($statement->execute()) {
//                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
//                                    foreach ($result as $rs) {
//                                        if ($rs->idAluno == $aluno) {
//                                            echo "<option value='$rs->idAluno' selected>$rs->Nome</option>";
//                                        } else {
//                                            echo "<option value='$rs->idAluno'>$rs->Nome</option>";
//                                        }
//                                    }
//                                } else {
//                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
//                                }
                                ?>
                            </select>
                            Turma:
                            <select name="turma">
                                <option value="">--Selecione--</option>
                                <?php
//                                $query = "SELECT * FROM turma order by Nome;";
//                                $statement = $pdo->prepare($query);
//                                if ($statement->execute()) {
//                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
//                                    foreach ($result as $rs) {
//                                        if ($rs->idTurma == $turma) {
//                                            echo "<option value='$rs->idTurma' selected>$rs->Nome</option>";
//                                        } else {
//                                            echo "<option value='$rs->idTurma'>$rs->Nome</option>";
//                                        }
//                                    }
//                                } else {
//                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
//                                }
                                ?>
                            </select>
                            Nota 1:
                            <input type="text" size="5" name="sigla" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota1) && ($nota1 != null || $nota1 != "")) ? $nota1 : '';
                            ?>" />
                            Nota 2:
                            <input type="text" size="5" name="sigla" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota2) && ($nota2 != null || $nota2 != "")) ? $nota2 : '';
                            ?>" />
                            Nota 3:
                            <input type="text" size="5" name="sigla" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota3) && ($nota3 != null || $nota3 != "")) ? $nota3 : '';
                            ?>" />
                            Nota 4:
                            <input type="text" size="5" name="sigla" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota4) && ($nota4 != null || $nota4 != "")) ? $nota4 : '';
                            ?>" />
                            Nota Final:
                            <input type="text" size="5" name="sigla" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($notaFinal) && ($notaFinal != null || $notaFinal != "")) ? $notaFinal : '';
                            ?>" />
                            Situação:
                            <select name="turma">
                                <option value="">--Selecione--</option>
                                <?php
                                //                                $query = "SELECT * FROM turma order by Nome;";
                                //                                $statement = $pdo->prepare($query);
                                //                                if ($statement->execute()) {
                                //                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                //                                    foreach ($result as $rs) {
                                //                                        if ($rs->idTurma == $turma) {
                                //                                            echo "<option value='$rs->idTurma' selected>$rs->Nome</option>";
                                //                                        } else {
                                //                                            echo "<option value='$rs->idTurma'>$rs->Nome</option>";
                                //                                        }
                                //                                    }
                                //                                } else {
                                //                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                //                                }
                                ?>
                            </select>

                            <input type="submit" VALUE="Cadastrar"/>
                            <hr>
                        </form>
                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        //chamada a paginação
                        $object->tabelapaginada();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
