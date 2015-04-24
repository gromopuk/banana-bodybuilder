<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder;

use Banana\BodyBuilder\Elements\ElementInterface;
use Banana\BodyBuilder\Elements\Type as ElementType;

/**
 * Class Page
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Page extends WidgetsGroupAbstract
{

    const PAGE_TITLE_DEFAULT = 'Banana\BodyBuilder generated page';
    const PAGE_TEMPLATE = <<<'TEMPLATE'
<!DOCTYPE html>
<html>
<head lang="en">
    @block meta\@
        @@:meta\@
    @\block meta\@
    @@:title\@
</head>
<body>
@block include_body\@
    @include@:template@\include
@\block include_body\@
</body>
</html>
TEMPLATE;

    /** @var ElementInterface */
    protected $title;
    /** @var ElementInterface[] */
    protected $meta = [];

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setTitleElement($this->createElement(ElementType::TITLE, [], $title));
    }

    /**
     * @param ElementInterface $title
     *
     * @return $this
     */
    public function setTitleElement(ElementInterface $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return Page
     */
    public function addMeta(array $attributes)
    {
        return $this->addMetaElement($this->createElement(ElementType::META, $attributes));
    }

    /**
     * @param ElementInterface $meta
     *
     * @return $this
     */
    public function addMetaElement(ElementInterface $meta)
    {
        $this->meta[] = $meta;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateString()
    {
        return self::PAGE_TEMPLATE;
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Block $block
     *
     * @return void
     */
    protected function buildBlock(Rendering\Block $block)
    {
        $block->setVariable('elementTitle', $this->getTitleElement()->toString());
        foreach ($this->getMetaElements() as $metaElement) {
            $metaBlock = $block->addBlock('elementsMeta');
            $metaBlock->setVariable('elementMeta', $metaElement->toString());
        }
    }

    /**
     * @return ElementInterface
     */
    public function getTitleElement()
    {
        if ($this->title === null) {
            $this->title = $this->createElement(ElementType::TITLE, [], static::PAGE_TITLE_DEFAULT);
        }
        return $this->title;
    }

    /**
     * @return ElementInterface[]
     */
    public function getMetaElements()
    {
        return $this->meta;
    }

}
