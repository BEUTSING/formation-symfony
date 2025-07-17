<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    //definition of validation rules
    // #[Assert\NotBlank(message: 'Le nom est obligatoire')]

    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\length(min: 3, max: 200)]
    public string $name = '';
     
    #[Assert\NotBlank(message: 'L\'email est obligatoire')]
    #[Assert\Email]
    public string $email = '';

    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\length(min: 3, max: 200)]
    public string $message = '';

}  