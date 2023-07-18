<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RequestGetDTO
{
  #[Assert\Regex([
    'pattern' => '/^[0-9]\d*$/',
    'message' => 'page должно быть целым числом'
  ])]
  #[Assert\Positive(message: 'page должен быть больше 0')]
  public $page;
}
