<?php

declare(strict_types=1);

namespace FaqTest\Entity;

use Faq\Entity\Slug;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{

    /**
     * @param string $value
     * @param string $expected
     *
     * @dataProvider provider
     */
    public function testCreateSlug(string $value, string $expected)
    {
        $slug = new Slug($value);
        $this->assertEquals($expected, (string)$slug);
    }

    public function provider()
    {
        return [
            ['Testando a criação de slug', 'testando-a-criacao-de-slug'],
            ['Sobre a MadeiraMadeira', 'sobre-a-madeiramadeira'],
            ['Como cancelar o pedido/produto', 'como-cancelar-o-pedido-produto'],
        ];
    }
}
