<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professor
 *
 * @ORM\Table(name="professor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfessorRepository")
 */
class Professor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=50)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cref", type="string", length=25)
     */
    private $cref;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255)
     */
    private $foto;

    private $arquivoFoto;


    public function setArquivoFoto($arquivoFoto) {
        $this->arquivoFoto = $arquivoFoto;
        return $this;
    }
    public function getArquivoFoto() {
        return $this->arquivoFoto;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Professor
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cref
     *
     * @param string $cref
     *
     * @return Professor
     */
    public function setCref($cref)
    {
        $this->cref = $cref;

        return $this;
    }

    /**
     * Get cref
     *
     * @return string
     */
    public function getCref()
    {
        return $this->cref;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Professor
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Professor
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }
}

