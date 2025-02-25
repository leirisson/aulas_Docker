<?php

/*
 * This file is part of the Novo SGA project.
 *
 * (c) Rogerio Lino <rogeriolino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository\ORM;

use Doctrine\Persistence\ManagerRegistry;
use Novosga\Entity\UsuarioMeta;

/**
 * UnidadeMetadataRepository
 *
 * @author Rogério Lino <rogeriolino@gmail.com>
 */
class UsuarioMetadataRepository extends EntityMetadataRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioMeta::class);
    }
}
