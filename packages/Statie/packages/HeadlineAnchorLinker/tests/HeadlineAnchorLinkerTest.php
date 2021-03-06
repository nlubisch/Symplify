<?php declare(strict_types=1);

namespace Symplify\Statie\HeadlineAnchorLinker\Tests;

use PHPUnit\Framework\TestCase;
use Symplify\Statie\HeadlineAnchorLinker\HeadlineAnchorLinker;

final class HeadlineAnchorLinkerTest extends TestCase
{
    public function test(): void
    {
        $headlineAnchorLinker = new HeadlineAnchorLinker();

        $this->assertSame(
            '<h2 id="hey"><a href="#hey">Hey</a></h2>',
            $headlineAnchorLinker->processContent('<h2>Hey</h2>')
        );
        $this->assertSame(
            '<h3 id="hi-tom"><a href="#hi-tom">Hi <b>Tom<b></a></h3>',
            $headlineAnchorLinker->processContent('<h3>Hi <b>Tom<b></h3>')
        );
    }

    public function testHeadingWithLink(): void
    {
        $headlineAnchorLinker = new HeadlineAnchorLinker();

        $this->assertSame(
            '<h2 id="hey"><a href="http://example.com">Hey</a></h2>',
            $headlineAnchorLinker->processContent('<h2><a href="http://example.com">Hey</a></h2>')
        );

        $this->assertSame(
            '<h3 id="hi-tom">Hi <a href="http://example.com"><b>Tom<b></a></h3>',
            $headlineAnchorLinker->processContent('<h3>Hi <a href="http://example.com"><b>Tom<b></a></h3>')
        );
    }
}
