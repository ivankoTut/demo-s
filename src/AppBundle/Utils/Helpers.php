<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 24.01.18
 * Time: 17:28
 */

namespace AppBundle\Utils;
use Buzz\Browser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class Helpers
{

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function randomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    public function validateEntity($entity)
    {
        $errors = $this->validator->validate($entity);
        $browser = new Browser();
        $response = $browser->get($entity->getFullLink());

        if ($response->getHeaders()[0] != 'HTTP/1.1 200 Ok') {
            $errors = [];
            $errors[] = [
                "property_path" => "fullLink",
                "message" => "The status is not 200"
            ];
        }

        return count($errors) > 0 ? $errors : false;
    }

}