<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 05/07/17
 * Time: 17:50
 */

namespace Corollarium;

use PHPUnit\Framework\TestCase;
use RuntimeException;


class HtmlBuilderTest extends TestCase
{
    const HEADER = '<h1>HEADER</h1>';
    const CONTENT = '<p>CONTENT</p>';
    const FOOTER = '<footer>FOOTER</footer>';


    private function removeEspaces(string $text): string
    {
        return preg_replace('/\s/', '', $text);
    }

    /**
     * @covers HtmlBuilder::builder
     */
    public function test_gerar_instancia_do_builder()
    {
        $builder = HtmlBuilder::builder();

        $this->assertInstanceOf(HtmlBuilder::class, $builder);
    }


    /**
     * @covers HtmlBuilder::setTitle
     */
    public function test_set_title()
    {
        $builder = HtmlBuilder::builder();

        $builder->setTitle('teste');

        $head = $this->removeEspaces($builder->head());

        $this->assertRegExp("/<title>teste<\/title>/", $head);
    }


    /**
     * @covers HtmlBuilder::head
     */
    public function test_gera_tag_head()
    {
        $builder = HtmlBuilder::builder();

        $head = $this->removeEspaces($builder->head());

        $this->assertRegExp("/<head>.*<\/head>/", $head);
    }


    /**
     * @covers HtmlBuilder::addJS
     */
    public function test_throw_exception_se_lista_nao_contem_somente_strings_js()
    {
        $this->expectException(RuntimeException::class);

        $builder = HtmlBuilder::builder();

        $builder->addJS([
            'index.js',
            8,
            'index2.js',
        ]);
    }


    /**
     * @covers HtmlBuilder::addCSS
     */
    public function test_throw_exception_se_lista_nao_contem_somente_strings_css()
    {
        $this->expectException(RuntimeException::class);

        $builder = HtmlBuilder::builder();

        $builder->addJS([
            'index.css',
            6,
            'index2.css',
        ]);
    }


    /**
     * @covers HtmlBuilder::setHeader
     */
    public function test_set_header()
    {
        $builder = HtmlBuilder::builder();


        $builder->setHeader(function ()
        {
            return HtmlBuilderTest::HEADER;
        });

        $this->assertEquals(HtmlBuilderTest::HEADER, $builder->getHeader());
    }


    /**
     * @covers HtmlBuilder::setContent
     */
    public function test_set_content()
    {
        $builder = HtmlBuilder::builder();

        $builder->setContent(function ()
        {
            return HtmlBuilderTest::CONTENT;
        });

        $this->assertEquals(HtmlBuilderTest::CONTENT, $builder->getContent());
    }


    /**
     * @covers HtmlBuilder::setFooter
     */
    public function test_set_footer()
    {
        $builder = HtmlBuilder::builder();

        $builder->setFooter(function ()
        {
            return HtmlBuilderTest::FOOTER;
        });

        $this->assertEquals(HtmlBuilderTest::FOOTER, $builder->getFooter());
    }


    /**
     * @covers HtmlBuilder::getHeader
     */
    public function test_get_header()
    {
        $builder = HtmlBuilder::builder();

        $this->assertEquals(HtmlBuilderTest::HEADER, $builder->getHeader());
    }


    /**
     * @covers HtmlBuilder::getContent
     */
    public function test_get_content()
    {
        $builder = HtmlBuilder::builder();

        $this->assertEquals(HtmlBuilderTest::CONTENT, $builder->getContent());
    }


    /**
     * @covers HtmlBuilder::getFooter
     */
    public function test_get_footer()
    {
        $builder = HtmlBuilder::builder();

        $this->assertEquals(HtmlBuilderTest::FOOTER, $builder->getFooter());
    }


    /**
     * @covers HtmlBuilder::render
     */
    public function test_render_html_page()
    {
        $builder = HtmlBuilder::builder();

        $html = $this->removeEspaces($builder->render());

        $this->assertRegExp("/<html>.*<\/html>/", $html);
    }
}
