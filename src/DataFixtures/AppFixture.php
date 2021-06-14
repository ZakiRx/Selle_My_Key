<?php
declare(strict_types=1);

namespace App\DataFixtures;


use App\Entity\Bid;
use App\Entity\Comment;
use App\Entity\Favorite;
use App\Entity\Genre;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\RateSeller;
use App\Entity\Seller;
use App\Entity\User;
use App\Repository\GenreRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Repository\SellerRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory as faker;

class AppFixture extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private SellerRepository $sellerRepository;
    private GenreRepository $genreRepository;
    private ProductRepository $productRepository;
    private UserRepository $userRepository;
    private PurchaseRepository $purchaseRepository;

    public function __construct(ProductRepository  $productRepository,
                                SellerRepository  $sellerRepository,
                                GenreRepository  $genreRepository,
                                EntityManagerInterface  $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                UserRepository $userRepository,
                                PurchaseRepository $purchaseRepository
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->sellerRepository = $sellerRepository;
        $this->genreRepository = $genreRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = faker::create();
        $this->addUsers($faker);
       $this->addGenre($faker);
       $this->addProducts($faker);
        $this->addComments($faker);
        $this->addRatings($faker);
        $this->addBids($faker);
        //$this->addPurchase($faker);
       // $this->addOrder($faker);
      //  $this->addFavorite($faker);
    }

    public function  addUsers(Generator $faker){
        //create 5 Users
        for ($i=0;$i<5;$i++){
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setDateBirth($faker->dateTimeBetween('-50 years','-10 years'));
            $user->setRoles(["ROLE_USER"]);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $user->setPassword($this->passwordEncoder->encodePassword($user,"123456"));
            $user->setEnabled(true);
            $this->entityManager->persist($user);
        }
        //create 3 Seller
        for ($i=0;$i<3;$i++){
            $user = new Seller();
            $user->setUsername($faker->userName);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setDateBirth($faker->dateTimeBetween('-50 years','-10 years'));
            $user->setRoles(["ROLE_SELLER"]);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $user->setPassword($this->passwordEncoder->encodePassword($user,"123456"));
            $user->setEnabled(true);
            $this->entityManager->persist($user);
        }
        //create 1 Admin
        $user = new User();
        $user->setUsername("admin");
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setDateBirth($faker->dateTimeBetween('-50 years','-10 years'));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail($faker->email);
        $user->setPhone($faker->phoneNumber);
        $user->setPassword($this->passwordEncoder->encodePassword($user,"123456"));
        $user->setEnabled(true);
        $user->setBalance($faker->numberBetween(50,1000));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    public function addGenre(Generator $faker){
        $genres=["Adventure","Action","Account"];
        for ($i=0;$i<3;$i++) {
            $genre =new Genre();
            $genre->setGenre($genres[$i]);
            $this->entityManager->persist($genre);
            $this->entityManager->persist($genre);
        }
        $this->entityManager->flush();
    }
    public function addProducts(Generator $faker){
        $sellers=$this->sellerRepository->findAll();
        $genres=$this->genreRepository->findAll();
        for ($i=0;$i<10;$i++){
            $product = new Product();
            $product->setName($faker->words(7,15));
            $product->setDescription($faker->text(450));
            $product->setShortDescription($faker->text(200));
            $product->setStartPrice($faker->numberBetween(500,10000));
            $product->setCurrentPrice($product->getStartPrice());
            $product->setMaxBidPrice($faker->numberBetween(150,400));
            $product->setMinBidPrice($faker->numberBetween(50,100));
            $product->setStartedAt($faker->dateTimeBetween('now','+5 days'));
            $product->setEndedAt($faker->dateTimeBetween('+5 days','+10 days'));
            $product->setEnabled(true);
            $product->setVerified(true);
            $product->setSeller($sellers[$faker->numberBetween(0,count($sellers)-1)]);
            $product->setGenre($genres[$faker->numberBetween(0,count($genres)-1)]);
            $this->entityManager->persist($product);
        }
        $this->entityManager->flush();
    }
    public function  addComments(Generator $faker){
        $products = $this->productRepository->findAll();
        $users=$this->userRepository->findAll();
        for ($i=0;$i<40;$i++){
            $comment=new Comment();
            $comment->setComment($faker->sentence(15,true));
            $comment->setUser($users[$faker->numberBetween(0,count($users)-1)]);
            $comment->setProduct($products[$faker->numberBetween(0,count($products)-1)]);
            $comment->setEnabled(true);
            $this->entityManager->persist($comment);
        }
        $this->entityManager->flush();
    }
    public function  addRatings(Generator $faker){
        $users=$this->userRepository->findAll();
        $sellers=$this->sellerRepository->findAll();
        for ($i=0;$i<50;$i++){
            $rate= new RateSeller();
            $rate->setUser($users[$faker->numberBetween(0,count($users)-1)]);
            $rate->setSeller($sellers[$faker->numberBetween(0,count($sellers)-1)]);
            $rate->setNumberStars($faker->numberBetween(1,5));
            $this->entityManager->persist($rate);
        }
        $this->entityManager->flush();
    }
    public function  addBids(Generator $faker){
        $users=$this->userRepository->findAll();
        $products=$this->productRepository->findAll();
        for ($i=0;$i<15;$i++) {
            $bid = new Bid();
            $bid->setUser($users[$faker->numberBetween(0,count($users)-1)]);
            $bid->setProduct($products[$faker->numberBetween(0,count($products)-1)]);
            $numProduct=$faker->numberBetween(0,count($products)-1);
            $minBidPrice=$products[$numProduct]->getMinBidPrice();
            $maxBidPrice=$products[$numProduct]->getMaxBidPrice();
            $bid->setPrice($faker->numberBetween($minBidPrice,$maxBidPrice));
            $this->entityManager->persist($bid);

        }
        $this->entityManager->flush();
    }
    public function addPurchase(Generator $faker){
        $products=$this->productRepository->findAll();
        $product= $products[$faker->numberBetween(0,count($products)-2)];
        $bid=$product->getBids()[count($product->getBids())-2];/*get last bid (winner)*/
        $purchase = new Purchase();
        $purchase->setBid($bid);
        $purchase->setState("en cour");
        $purchase->setCreatedAt(new \DateTime('now'));
        $purchase->setUpdatedAt(new \DateTime('now'));
        $this->entityManager->persist($purchase);
        $this->entityManager->flush();
    }
    public function addOrder(Generator $faker){
        $purchases=$this->purchaseRepository->findAll();
        $order= new Order();
        $order->setCreatedAt(new \DateTime('now'));
        $order->setPurchase($purchases[$faker->numberBetween(0,count($purchases)-1)]);
        $seller=$purchases[$faker->numberBetween(0,count($purchases)-1)]->getBid()->getProduct()->getSeller();
        $order->setSeller($seller);
        $order->setStatus("complet");
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function addFavorite(Generator $faker){

        $users=$this->userRepository->findAll();
        $products=$this->productRepository->findAll();
        for ($i=0;$i<10;$i++) {
            $numUser=$faker->numberBetween(0, count($users) - 1);
            $favorite = $users[$numUser]->getFavorite() ?? new Favorite();
            $users[$numUser]->setFavorite($favorite);
            $favorite->addProduct($products[$faker->numberBetween(0,count($products)-1)]);
            $this->entityManager->persist($favorite);
        }
        $this->entityManager->flush();

    }
}