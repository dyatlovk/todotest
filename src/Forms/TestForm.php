<?php

declare(strict_types=1);

namespace App\Forms;

use App\System\FormBuilder;
use App\System\Validator;
use App\System\Validator\CSRF;
use App\System\Validator\Email;
use App\System\Validator\NotBlank;

class TestForm
{
    public function build(): FormBuilder
    {
        $form = new FormBuilder('test_form', ['action' => '/', 'method' => 'POST']);
        $form->add('name', 'text', ['class' => 'test', 'value' => ""], [new NotBlank()]);
        $form->add('email', 'email', ['class' => 'test', 'value' => ""], [new NotBlank(), new Email()]);
        $form->add('radio', 'radio', ['class' => 'radio', 'choices' => [
            'foo' => 1,
            'bar' => 2,
            'foobar' => 3,
        ], 'value' => 2]);
        $form->add('textarea', 'textarea', ['class'=> 'textarea', 'value' => 'text'], [new NotBlank('textarea required')]);
        $form->add('checkbox', 'checkbox', ['class' => 'checkbox', 'value' => [1,3], 'choices' => [
            'foo' => 1,
            'bar' => 2,
            'foobar' => 3,
        ]]);
        $form->add('select', 'select', ['class' => 'select', 'value' => [1], 'choices' => [
            'foo' => 1,
            'bar' => 2,
            'foobar' => 3,
        ]]);
        $form->add('token', 'hidden', ['value' => $form->generateCSRFToken()], [new CSRF($form->getName())]);

        return $form;
    }
}
