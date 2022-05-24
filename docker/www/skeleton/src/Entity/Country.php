<?php

namespace EfTech\ContactList\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Страна
 *
 * @ORM\Table (
 *     name="countries"
 * )
 * @ORM\Entity (repositoryClass="")
 *
 */
class Country
{
    /**
     *
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(type="integer",name="id")
     * @ORM\SequenceGenerator(sequenceName="countries_id_seq")
     */
    private int $id;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private string $name;
}