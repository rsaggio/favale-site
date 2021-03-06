<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
	public function findNews()
    {
        return $this->findBy(array(), array('data' => 'DESC'));
    }

    public function findByTitulo($titulo) {

    	$titulo = strtolower($titulo);

 		$em = $this->getEntityManager();

 		$query = $em->createQuery("SELECT p FROM AppBundle:Post p WHERE LOWER(p.titulo) LIKE '%{$titulo}%'");
             

    	$entities = $query->getResult();  

    	return $entities; 	
    }

    public function findByAutorNome($nome) {

    	$nome = strtolower($nome);

 		$em = $this->getEntityManager();

 		$query = $em->createQuery("SELECT p FROM AppBundle:Post p JOIN p.autor a WHERE LOWER(a.nome) LIKE '%{$nome}%'");
             

    	$entities = $query->getResult();  

    	return $entities; 	
    }
}
