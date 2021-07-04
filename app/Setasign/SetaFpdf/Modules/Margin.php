<?php
/**
 * This file is part of SetaFPDF
 *
 * @package   setasign\SetaFpdf
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace setasign\SetaFpdf\Modules;

use setasign\SetaFpdf\Position\Converter;
use setasign\SetaFpdf\Position\Cursor;
use setasign\SetaFpdf\StateBuffer\StateBufferInterface;

/**
 * Class Margin
 *
 * The margin works completly in unit.
 */
class Margin implements StateBufferInterface
{

    /**
     * @var Cursor
     */
    protected $cursor;

    /**
     * The left margin.
     *
     * @var int|float
     */
    private $left;

    /**
     * The stored left margin.
     *
     * @var int|float
     */
    private $oldLeft;

    /**
     * The right margin.
     *
     * @var int|float
     */
    private $right;

    /**
     * The stored right margin.
     *
     * @var int|float
     */
    private $oldRight;

    /**
     * The top margin.
     *
     * @var int|float
     */
    private $top;

    /**
     * The stored top margin.
     *
     * @var int|float
     */
    private $oldTop;

    /**
     * The bottom margin.
     *
     * @var int|float
     */
    private $bottom;

    /**
     * The stored bottom margin.
     *
     * @var int|float
     */
    private $oldBottom;

    /**
     * The cell margin.
     *
     * @var int|float
     */
    private $cell;

    /**
     * The stored cell margin.
     *
     * @var int|float
     */
    private $oldCell;

    /**
     * Margin constructor.
     *
     * @param Converter $converter
     * @param Cursor $cursor
     */
    public function __construct(Converter $converter, Cursor $cursor)
    {
        $this->cursor = $cursor;
        $margin = $converter->fromPt(28.35);
        $this->set($margin, $margin);
        $this->cell = $margin / 10;
        $this->bottom = $margin * 2;
    }

    /**
     * Implementation of the FPDF::SetLeftMargin() method.
     *
     * @param int|float $margin
     */
    public function setLeft($margin)
    {
        $this->left = $margin;

        if ($this->cursor->getX() < $margin) {
            $this->cursor->setX($margin);
        }
    }

    /**
     * Implementation of the FPDF::SetRightMargin() method.
     *
     * @param int|float $margin
     */
    public function setRight($margin)
    {
        $this->right = $margin;
    }

    /**
     * Implementation of the FPDF::SetTopMargin() method.
     *
     * @param int|float $margin
     */
    public function setTop($margin)
    {
        $this->top = $margin;
    }

    /**
     * Implementation of the FPDF::SetBottomMargin() method.
     *
     * @param int|float $margin
     */
    public function setBottom($margin)
    {
        $this->bottom = $margin;
    }

    /**
     * Implementation of the FPDF::SetMargins() method.
     *
     * @param int|float $left
     * @param int|float $top
     * @param int|float|null $right
     */
    public function set($left, $top, $right = null)
    {
        $this->left = $left;
        $this->top = $top;

        $this->right = $right !== null ? $right : $left;
    }

    /**
     * Gets the left margin.
     *
     * @return int|float
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Gets the right margin.
     *
     * @return int|float
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Gets the cell margin.
     *
     * @return int|float
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * Gets the top margin.
     *
     * @return int|float
     */
    public function getTop()
    {
        return $this->top;
    }

    /**Gets the bottom margin.
     *
     * @return int|float
     */
    public function getBottom()
    {
        return $this->bottom;
    }

    /**
     * @inheritdoc
     */
    public function cleanUp()
    {
        $this->cursor = null;
    }

    /**
     * @inheritdoc
     */
    public function reset()
    {
    }

    /**
     * @inheritdoc
     */
    public function store()
    {
        $this->oldBottom = $this->bottom;
        $this->oldCell = $this->cell;
        $this->oldLeft = $this->left;
        $this->oldRight = $this->right;
        $this->oldTop = $this->top;
    }

    /**
     * @inheritdoc
     */
    public function restore()
    {
        $this->bottom = $this->oldBottom;
        $this->cell = $this->oldCell;
        $this->left = $this->oldLeft;
        $this->right = $this->oldRight;
        $this->top = $this->oldTop;
    }
}
