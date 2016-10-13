<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BannerPrincipal
 *
 * @ORM\Table(name="banner_principal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BannerPrincipalRepository")
 */
class BannerPrincipal
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
     * @ORM\Column(name="frase", type="text")
     */
    private $frase;

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
     * Set frase
     *
     * @param string $frase
     *
     * @return BannerPrincipal
     */
    public function setFrase($frase)
    {
        $this->frase = $frase;

        return $this;
    }

    /**
     * Get frase
     *
     * @return string
     */
    public function getFrase()
    {
        return $this->frase;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return BannerPrincipal
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
     * @return BannerPrincipal
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

