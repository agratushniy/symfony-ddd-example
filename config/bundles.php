<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                              => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class                               => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class                   => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class                       => ['dev'  => true,
                                                                                           'test' => true
    ],
    FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle::class => ['test' => true],
];
