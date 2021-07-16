<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
//use App\Repository\CategorieRepository;

//use App\Repository\CategorieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $items = [
            'cat'=>[1=>'Bague', 2=>'Bracelet', 3=>'Boucle d\'oreille',4=> 'Collier'],
            'photo'=>[1=>'https://zupimages.net/up/21/28/gwb4.jpg',
                2=>'https://zupimages.net/up/21/28/e812.jpg',
                3=>'https://zupimages.net/up/21/28/nzhp.jpg',
                4=> 'https://zupimages.net/up/21/28/8w5i.jpg'
            ]];

        foreach ($items['cat'] as $key => $item) :
            $categorie = new Categorie();
            $categorie->setNom($item);
            $manager->persist($categorie);
            $this->addReference('categorie_'.$key, $categorie);

        endforeach;
        $manager->flush();

        foreach ($items['photo'] as $key => $itemphoto) :
            $photo[$key] = $itemphoto;

        endforeach;

        for ($i = 1; $i < 51; $i++):

            $article = new Article();

            $id =rand(1,4);
            $categorie = $this->getReference(('categorie_'.$id));


            $article->setPhoto($photo[$id])
                ->setPrix(rand(100, 1000))
                ->setCategorie($categorie)
                ->setCreateAt(new \DateTime())
                ->setNom('Bijoux N°'.$i);
            $manager->persist($article);

        endfor;

        $manager->flush();
    }
}
