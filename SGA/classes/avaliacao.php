<?php
/**
 * Created by PhpStorm.
 * User: alunoces
 * Date: 16/04/2019
 * Time: 22:00
 */

class avaliacao {

    private $idAvaliacao;
    private $turma;
    private $aluno;
    private $Nota1;
    private $Nota2;
    private $Nota3;
    private $Nota4;
    private $NotaFinal;
    private $situacao;

    /**
     * avaliacao constructor.
     * @param $idAvaliacao
     * @param $turma
     * @param $aluno
     * @param $Nota1
     * @param $Nota2
     * @param $Nota3
     * @param $Nota4
     * @param $NotaFinal
     * @param $situacao
     */
    public function __construct($idAvaliacao, $turma, $aluno, $Nota1, $Nota2, $Nota3, $Nota4, $NotaFinal, $situacao)
    {
        $this->idAvaliacao = $idAvaliacao;
        $this->turma = $turma;
        $this->aluno = $aluno;
        $this->Nota1 = $Nota1;
        $this->Nota2 = $Nota2;
        $this->Nota3 = $Nota3;
        $this->Nota4 = $Nota4;
        $this->NotaFinal = $NotaFinal;
        $this->situacao = $situacao;
    }

    /**
     * @return mixed
     */
    public function getIdAvaliacao()
    {
        return $this->idAvaliacao;
    }

    /**
     * @param mixed $idAvaliacao
     */
    public function setIdAvaliacao($idAvaliacao)
    {
        $this->idAvaliacao = $idAvaliacao;
    }

    /**
     * @return mixed
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param mixed $turma
     */
    public function setTurma($turma)
    {
        $this->turma = $turma;
    }

    /**
     * @return mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param mixed $aluno
     */
    public function setAluno($aluno)
    {
        $this->aluno = $aluno;
    }

    /**
     * @return mixed
     */
    public function getNota1()
    {
        return $this->Nota1;
    }

    /**
     * @param mixed $Nota1
     */
    public function setNota1($Nota1)
    {
        $this->Nota1 = $Nota1;
    }

    /**
     * @return mixed
     */
    public function getNota2()
    {
        return $this->Nota2;
    }

    /**
     * @param mixed $Nota2
     */
    public function setNota2($Nota2)
    {
        $this->Nota2 = $Nota2;
    }

    /**
     * @return mixed
     */
    public function getNota3()
    {
        return $this->Nota3;
    }

    /**
     * @param mixed $Nota3
     */
    public function setNota3($Nota3)
    {
        $this->Nota3 = $Nota3;
    }

    /**
     * @return mixed
     */
    public function getNota4()
    {
        return $this->Nota4;
    }

    /**
     * @param mixed $Nota4
     */
    public function setNota4($Nota4)
    {
        $this->Nota4 = $Nota4;
    }

    /**
     * @return mixed
     */
    public function getNotaFinal()
    {
        return $this->NotaFinal;
    }

    /**
     * @param mixed $NotaFinal
     */
    public function setNotaFinal($NotaFinal)
    {
        $this->NotaFinal = $NotaFinal;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }


}