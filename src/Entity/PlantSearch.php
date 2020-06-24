<?php
namespace App\Entity;

class PlantSearch{
    /**
     * @var string|null
     */
    private  $maladie;

    /**
     * @return string|null
     */
    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    /**
     * @param string|null $maladie
     */
    public function setMaladie(string $maladie): void
    {
        $this->maladie = $maladie;
    }
}