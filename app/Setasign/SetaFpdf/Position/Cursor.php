<?php
/**
 * This file is part of SetaFPDF
 *
 * @package   setasign\SetaFpdf
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace App\Setasign\SetaFpdf\Position;

use App\Setasign\SetaFpdf\Manager;
use App\Setasign\SetaFpdf\Modules\Margin;
use App\Setasign\SetaFpdf\StateBuffer\StateBufferInterface;

/**
 * Class Cursor
 *
 * The cursor works completly with unit.
 */
class Cursor implements StateBufferInterface
{
    /**
     * The current x position.
     *
     * @var int|float
     */
    protected $x;

    /**
     * The stored x position.
     *
     * @var int|float
     */
    protected $oldX;

    /**
     * The current y position.
     *
     * @var int|float
     */
    protected $y;

    /**
     * The stored y position.
     *
     * @var int|float
     */
    protected $oldY;

    /**
     * The manager.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Cursor constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->x = $this->y = 0;
        $this->manager = $manager;
    }

    /**
     * Gets the current x position.
     *
     * @return int|float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Sets the current x position.
     *
     * @param int|float $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Adds a value to the x position.
     *
     * @param int|float $value
     */
    public function addX($value)
    {
        $this->x += $value;
    }

    /**
     * Gets the current y position.
     *
     * @return int|float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Sets the current y position.
     *
     * @param int|float $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * Adds a values to y position.
     *
     * @param int|float $value
     */
    public function addY($value)
    {
        $this->y += $value;
    }

    /**
     * @inheritdoc
     */
    public function cleanUp()
    {
        $this->x = $this->y = $this->oldX = $this->oldY = $this->manager = null;
    }

    /**
     * @inheritdoc
     */
    public function reset()
    {
        $this->x = $this->manager->getMargin()->getLeft();
        $this->y = $this->manager->getMargin()->getTop();
    }

    /**
     * @inheritdoc
     */
    public function store()
    {
        $this->oldX = $this->x;
        $this->oldY = $this->y;
    }

    /**
     * @inheritdoc
     */
    public function restore()
    {
        $this->x = $this->oldX;
        $this->y = $this->oldY;
    }
}
