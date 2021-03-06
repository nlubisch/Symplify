<?php declare(strict_types=1);

namespace Symplify\Statie\HeadlineAnchorLinker;

use Nette\Utils\Strings;

final class HeadlineAnchorLinker
{
    /**
     * @var string
     */
    private const HEADLINE_PATTERN = '#<h(?<level>[1-6])>(?<title>.*?)<\/h[1-6]>#';

    /**
     * @var string
     */
    private const LINK_PATTERN = '#<a.*>(.*)<\/a>#';

    /**
     * Before:
     * - <h1>Some headline</h1>
     *
     * After:
     * - <h1 id="some-headline"><a href="#some-headline">Some headline</a></h1>
     */
    public function processContent(string $content): string
    {
        return Strings::replace($content, self::HEADLINE_PATTERN, function (array $result): string {
            $titleWithoutTags = strip_tags($result['title']);
            $headlineId = Strings::webalize($titleWithoutTags);
            $titleWithLink = Strings::match($result['title'], self::LINK_PATTERN);
            $titleHasLink = is_array($titleWithLink) ? count($titleWithLink) > 0 : false;

            // Title contains <a> element
            if ($result['title'] !== $titleWithoutTags && $titleHasLink) {
                return sprintf(
                    '<h%s id="%s">%s</h%s>',
                    $result['level'],
                    $headlineId,
                    $result['title'],
                    $result['level']
                );
            }

            return sprintf(
                '<h%s id="%s"><a href="#%s">%s</a></h%s>',
                $result['level'],
                $headlineId,
                $headlineId,
                $result['title'],
                $result['level']
            );
        });
    }
}
