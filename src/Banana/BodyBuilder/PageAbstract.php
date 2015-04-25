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
 * Abstract class PageAbstract
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class PageAbstract extends WidgetsGroupAbstract
{

    const PAGE_TITLE_DEFAULT = 'BodyBuilder page';

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
     * @return PageAbstract
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
     * @param \Banana\BodyBuilder\Rendering\Structure\Block $block
     *
     * @return void
     */
    protected function buildBlock(Rendering\Structure\Block $block)
    {
        $this->buildTitle($block)
            ->buildMeta($block);
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Structure\Block $block
     *
     * @return $this
     */
    protected function buildMeta(Rendering\Structure\Block $block)
    {
        foreach ($this->getMetaElements() as $metaElement) {
            $metaBlock = $block->addBlock('meta');
            $metaBlock->setVariable('meta', $metaElement->toString());
        }
        return $this;
    }

    /**
     * @return ElementInterface[]
     */
    public function getMetaElements()
    {
        return $this->meta;
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Structure\Block $block
     *
     * @return $this
     */
    protected function buildTitle(Rendering\Structure\Block $block)
    {
        $block->setVariable('title', $this->getTitleElement()->toString());
        return $this;
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

}
