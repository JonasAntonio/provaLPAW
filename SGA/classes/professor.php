<?php
/**
 * Created by PhpStorm.
 * User: alunoces
 * Date: 16/04/2019
 * Time: 21:03
 */

class professor
{
    private $idProfessor;
    private $nomeProfessor;
    private $cargoProfessor;

    /**
     * professor constructor.
     * @param $idProfessor
     * @param $nomeProfessor
     * @param $cargoProfessor
     */
    public function __construct($idProfessor, $nomeProfessor, $cargoProfessor)
    {
        $this->idProfessor = $idProfessor;
        $this->nomeProfessor = $nomeProfessor;
        $this->cargoProfessor = $cargoProfessor;
    }


    /**
     * @return mixed
     */
    public function getIdProfessor()
    {
        return $this->idProfessor;
    }

    /**
     * @param mixed $idProfessor
     */
    public function setIdProfessor($idProfessor)
    {
        $this->idProfessor = $idProfessor;
    }

    /**
     * @return mixed
     */
    public function getNomeProfessor()
    {
        return $this->nomeProfessor;
    }

    /**
     * @param mixed $nomeProfessor
     */
    public function setNomeProfessor($nomeProfessor)
    {
        $this->nomeProfessor = $nomeProfessor;
    }

    /**
     * @return mixed
     */
    public function getCargoProfessor()
    {
        return $this->cargoProfessor;
    }

    /**
     * @param mixed $cargoProfessor
     */
    public function setCargoProfessor($cargoProfessor)
    {
        $this->cargoProfessor = $cargoProfessor;
    }


}
