<?php

use MAKS\Mighty\Validator;
use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Constraint;

// validate any data on the fly
$result = Validator::validateData([1, 2, 3], Validation::array()->arrayIsSequential())->getResult();

// validate structured data
$results = ($validator = new Validator())
    ->setData([
        'name'    => 'John Doe',
        'age'     => 25,
        'hobbies' => ['coding', 'reading'],
        'consent' => 'yes',
    ])
    ->setValidations([
        'name'      => $validator->validation()->string()->stringCharset('UTF-8'),
        'age'       => $validator->validation()->integer()->between(16, 63),
        'hobbies'   => $validator->validation()->array()->not()->empty(),
        'hobbies.*' => $validator->validation()->string()->between(3, 21),
        'consent'   => $validator->validation()->if('${age.value}', 18, '>')->or()->accepted()->optimistic(),
    ])
    ->validate();

// validate data using constraints (can also be used as attributes)
$result = (new Constraint\Rule\Currency())->validate('USD')->getResult();
