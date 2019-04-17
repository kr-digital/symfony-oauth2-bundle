<?php

namespace Trikoder\Bundle\OAuth2Bundle\Manager\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Trikoder\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;

final class ClientManager implements ClientManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $identifier): ?Client
    {
        return $this->entityManager->find(Client::class, $identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Client $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function list(?array $filterBy): array
    {
        $repository = $this->entityManager->getRepository(Client::class);

        if ($filterBy) {
            return $repository->findBy($filterBy);
        }

        return $repository->findAll();
    }
}
