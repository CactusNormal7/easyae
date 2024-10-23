<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\ProductType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductTypeFixtures extends Fixture
{
    public const PREFIX = "productType#";
    public const POOL_MIN = 0;
    public const POOL_MAX = 10;
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        for ($i = self::POOL_MIN; $i < self::POOL_MAX; ++$i) {
            $dateCreated = $this->faker->dateTimeInInterval('-1 year', '+1 year');
            $dateUpdated = $this->faker->dateTimeBetween($dateCreated, $now);
            
            $productType = new ProductType();
            $productType
                ->setName($this->faker->numerify('product type-###'))
                ->setPrice($this->faker->randomFloat(2))
                ->setCreatedAt($dateCreated)
                ->setUpdatedAt($dateUpdated)
                ->setStatus('on')
            ;
            $manager->persist($productType);
            $this->addReference(self::PREFIX . $i, $productType);
        }
        $manager->flush();

    }
}
