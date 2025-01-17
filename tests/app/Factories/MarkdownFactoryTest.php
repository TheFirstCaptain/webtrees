<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2021 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees\Factories;

use Fisharebest\Webtrees\TestCase;
use Fisharebest\Webtrees\Tree;

/**
 * Test harness for the class MarkdownFactory
 *
 * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
 */
class MarkdownFactoryTest extends TestCase
{
    /**
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testAutoLinkWithoutTree(): void
    {
        $factory  = new MarkdownFactory();

        $this->assertSame(
            "<p>FOO <a href=\"https://example.com\">https://example.com</a> BAR</p>\n",
            $factory->autolink('FOO https://example.com BAR')
        );
    }

    /**
     * @covers \Fisharebest\Webtrees\CommonMark\XrefExtension
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testAutoLinkWithTree(): void
    {
        $factory = new MarkdownFactory();
        $tree    = $this->createStub(Tree::class);

        $this->assertSame(
            "<p>FOO <a href=\"https://example.com\">https://example.com</a> BAR</p>\n",
            $factory->autolink('FOO https://example.com BAR', $tree)
        );
    }

    /**
     * @covers \Fisharebest\Webtrees\CommonMark\XrefExtension
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testAutoLinkWithHtml(): void
    {
        $factory  = new MarkdownFactory();

        $this->assertSame(
            "<p>&lt;b&gt; <a href=\"https://example.com\">https://example.com</a> &lt;/b&gt;</p>\n",
            $factory->autolink('<b> https://example.com </b>')
        );
    }

    /**
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testMarkdownWithoutTree(): void
    {
        $factory = new MarkdownFactory();

        $this->assertSame(
            "<p>FOO https://example.com BAR</p>\n",
            $factory->markdown('FOO https://example.com BAR')
        );

        $this->assertSame(
            "<p>FOO <a href=\"https://example.com\">https://example.com</a> BAR</p>\n",
            $factory->markdown('FOO <https://example.com> BAR')
        );
    }

    /**
     * @covers \Fisharebest\Webtrees\CommonMark\XrefExtension
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testMarkdownWithTree(): void
    {
        $tree    = $this->createStub(Tree::class);
        $factory = new MarkdownFactory();

        $this->assertSame(
            "<p>FOO https://example.com BAR</p>\n",
            $factory->markdown('FOO https://example.com BAR', $tree)
        );

        $this->assertSame(
            "<p>FOO <a href=\"https://example.com\">https://example.com</a> BAR</p>\n",
            $factory->markdown('FOO <https://example.com> BAR', $tree)
        );
    }

    /**
     * @covers \Fisharebest\Webtrees\CommonMark\XrefExtension
     * @covers \Fisharebest\Webtrees\Factories\MarkdownFactory
     */
    public function testMarkdownWithHtml(): void
    {
        $factory = new MarkdownFactory();

        $this->assertSame(
            "<p>&lt;b&gt; <a href=\"https://example.com\">https://example.com</a> &lt;/b&gt;</p>\n",
            $factory->markdown('<b> <https://example.com> </b>')
        );
    }
}
