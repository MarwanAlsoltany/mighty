<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Benchmarks;

use MAKS\Mighty\Validator;
use MAKS\Mighty\Validation;
use PhpBench\Attributes as Bench;

#[Bench\OutputTimeUnit('milliseconds')]
class ValidatorBench
{
    #[Bench\Revs(500)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(5)]
    #[Bench\Sleep(10000)]
    #[Bench\Timeout(300)]
    #[Bench\Groups(['validator', 'single'])]
    public function benchSingleValidationString(): void
    {
        Validator::validateData(rand(1, 50000), 'required&integer');
    }

    #[Bench\Revs(500)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(5)]
    #[Bench\Sleep(10000)]
    #[Bench\Timeout(300)]
    #[Bench\Groups(['validator', 'single'])]
    public function benchSingleValidationObject(): void
    {
        Validator::validateData(rand(1, 50000), Validation::required()->integer());
    }

    #[Bench\Skip]
    #[Bench\Revs(1)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(1)]
    #[Bench\Sleep(10000)]
    #[Bench\Groups(['validator', 'single'])]
    public function benchSingleValidationStringSimple(): void
    {
        $validator = new Validator();
        $validator
            ->setData(range(1, 10000))
            ->setValidations(['*' => 'integer'])
            ->validate();
    }

    #[Bench\Revs(50)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(1)]
    #[Bench\Sleep(10000)]
    #[Bench\Timeout(900)]
    #[Bench\Groups(['validator', 'bulk'])]
    public function benchBulkValidationObject(): void
    {
        $validator = new Validator();

        $validations = [
            'name'           => $validator->validation()->required()->string()->stringCharset('UTF-8', 'ASCII')->pessimistic(),
            'age'            => $validator->validation()->required()->integer()->min(18),
            'email'          => $validator->validation()->required()->email(),
            'username'       => $validator->validation()->required()->username(),
            'password'       => $validator->validation()->required()->password()->callback(fn ($input) => true),
            'file'           => $validator->validation()->null()->xor()->group(fn (Validation $validation) => $validation->file()->fileIsFile()->fileSizeGte(filesize(__FILE__))->fileMime('text/x-php')),
            'submission'     => $validator->validation()->required()->datetime()->datetimeLt('2022-12-07'),
            'data'           => $validator->validation()->required()->array()->arrayHasKey('nickname'),
            'data.*'         => $validator->validation()->scalar()->or()->array()->optimistic(),
            'data.nickname'  => $validator->validation()->string()->min(2)->max(32),
            'data.hobbies.*' => $validator->validation()->ifEq('${data.hobbies.validations.array}', false)->or()->group(fn (Validation $validation) => $validation->string()->min(3)),
            'consent'        => $validator->validation()->assert('${age.value}', 18, '>=')->or()->accepted()->optimistic(),
        ];

        $validator
            ->setData($this->getData())
            ->setValidations($validations)
            ->setMessages($this->getMessages())
            ->setLabels($this->getLabels())
            ->validate();
    }

    #[Bench\Revs(50)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(1)]
    #[Bench\Sleep(10000)]
    #[Bench\Timeout(900)]
    #[Bench\Groups(['validator', 'bulk'])]
    public function benchBulkValidationString(): void
    {
        $validator = new Validator();

        $validator
            ->setData($this->getData())
            ->setValidations($this->getValidations())
            ->setMessages($this->getMessages())
            ->setLabels($this->getLabels())
            ->validate();
    }


    public function getData(): array
    {
        return [
            'name'       => 'John Doe',
            'age'        => 32,
            'email'      => 'john.doe@domian.tld',
            'username'   => 'john.doe',
            'password'   => 'Secret@123',
            'file'       => __FILE__,
            'submission' => 'now',
            'data'       => [
                'nickname' => 'JOE',
                'number'   => 7,
                'hobbies'  => [
                    'reading',
                    'coding',
                    'gaming',
                ]
            ],
            'consent' => 'yes',
        ];
    }

    public function getValidations(): array
    {
        return [
            'name'           => '!required&string&string.charset:"UTF-8","ASCII"',
            'age'            => 'required&integer&min:18',
            'email'          => 'required&email',
            'username'       => 'required&username',
            'password'       => 'required&password',
            'file'           => 'null^(file&file.isFile&file.size.gte:12800&file.mime:"text/x-php")',
            'submission'     => 'required&datetime&datetime.lt:"2022-12-07"',
            'data'           => 'required&array&array.hasKey:"nickname"',
            'data.*'         => '?scalar|array',
            'data.nickname'  => 'string&min:2&max:32',
            'data.hobbies.*' => 'if.eq:${data.hobbies.validations.array},false|(string&min:3)',
            'consent'        => '?assert:${age.value},18,">="|accepted',
        ];
    }

    public function getMessages(): array
    {
        return [
            '*' => [
                'required' => '${@label} is a required field.',
            ],
            'age' => [
                'min' => '${@label} must be at least ${@arguments.0}.',
            ],
            'username' => [
                'matches' => '${@label} must contain letters, numbers, and the following characters ".-_" only.',
            ],
            'consent' => [
                'assert' => 'You must be at least ${@arguments.1} years old to submit this form.',
            ]
        ];
    }

    public function getLabels(): array
    {
        return [
            'name'     => 'Name',
            'age'      => 'Age',
            'email'    => 'E-Mail',
            'password' => 'Password',
            'file'     => 'File',
            'data'     => 'Data',
            'data.*'   => 'Value of data',
            'consent'  => 'Consent',
        ];
    }
}
