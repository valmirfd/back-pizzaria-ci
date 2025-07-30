<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Produto extends Entity
{

    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function unsetAuxiliaryAttributes()
    {
        unset($this->attributes['images']);
    }

    public function setPrice(string $price)
    {
        $this->attributes['price'] = str_replace(',', '', $price);
    }

    public function image(string $classImage = '', string $sizeImage = 'regular')
    {
        if (empty($this->attributes['images'])) {

            return $this->handleWithEmptyImage($classImage);
        }

        if (is_string($this->attributes['images'])) {

            return $this->handleWithSingleImage($classImage, $sizeImage);
        }

        if (url_is('api/adverts*')) {

            return $this->handleWithImagesForAPI();
        }
    }

    public function price()
    {
        return number_to_currency($this->attributes['price'], 'BRL', 'pt-BR', 2);
    }

    /// Métodos privados

    private function handleWithEmptyImage(string $classImage): string
    {

        if (url_is('api/produtos*')) {

            return site_url('image/product-no-image.png');
        }

        return img(
            [
                'src'       => route_to('web.image', 'product-no-image.png', 'regular'),
                'alt'       => 'No image yet',
                'title'     => 'No image yet',
                'class'     => $classImage,
            ]
        );
    }


    private function handleWithSingleImage(string $classImage, string $sizeImage): string
    {

        if (url_is('api/produtos*')) {

            return $this->buildRouteForImageAPI($this->attributes['images']);
        }

        return img(
            [
                'src'       => route_to('web.image', $this->attributes['images'], $sizeImage),
                'alt'       => $this->attributes['title'],
                'title'     => $this->attributes['title'],
                'class'     => $classImage,
            ]
        );
    }


    private function handleWithImagesForAPI(): array
    {
        $images = [];

        foreach ($this->attributes['images'] as $image) {

            $images[] = $this->buildRouteForImageAPI($image->image);
        }

        return $images;
    }


    private function buildRouteForImageAPI(string $image): string
    {
        return route_to('web.image', $image, 'small');
    }
}
