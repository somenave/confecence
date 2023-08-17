<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $moscow = new Conference();
        $moscow->setCity('Moscow');
        $moscow->setYear('2022');
        $moscow->setIsInternational(true);
        $manager->persist($moscow);

        $kazan = new Conference();
        $kazan->setCity('Kazan');
        $kazan->setYear('2023');
        $kazan->setIsInternational(false);
        $manager->persist($kazan);

        $comment1 = new Comment();
        $comment1->setConference($moscow);
        $comment1->setAuthor('AuthorName');
        $comment1->setEmail('author@email.com');
        $comment1->setText('Text about this conference');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($moscow);
        $comment2->setAuthor('testAuthor');
        $comment2->setEmail('test@email.com');
        $comment2->setText('This is going to be moderated/');
        $manager->persist($comment2);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher(Admin::class)->hash('admin'));
        $manager->persist($admin);

        $manager->flush();
    }
}
