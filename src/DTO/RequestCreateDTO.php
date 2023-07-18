<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RequestCreateDTO
{
  #[Assert\NotBlank(message: 'userId обязательное поле')]
  #[Assert\Regex([
    'pattern' => '/^[0-9]\d*$/',
    'message' => 'userId должно быть целым числом'
  ])]
  #[Assert\Positive(message: 'userId должен быть больше 0')]
  public $userId;

  #[Assert\NotBlank(message: 'text обязательное поле')]
  public string $text;
}
