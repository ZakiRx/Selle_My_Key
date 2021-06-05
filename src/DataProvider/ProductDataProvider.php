<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductDataProvider implements ContextAwareCollectionDataProviderInterface,ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return  $resourceClass === Product::class;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
       return $this->productRepository->getEnabledAndVerifiedProducts();
    }


    /**
     * @throws NonUniqueResultException
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []):?Product
    {
        if($operationName=="get"){
            $product= $this->productRepository->getEnabledAndVerifiedProduct($id);
            if($product==null){
                throw  new NotFoundHttpException("Product not exist");

            }
            else{
                return  $product;
            }
        }
           return $this->productRepository->find($id);
    }
}