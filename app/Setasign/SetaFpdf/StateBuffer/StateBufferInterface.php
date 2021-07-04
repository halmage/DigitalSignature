<?php
/**
 * This file is part of SetaFPDF
 *
 * @package   setasign\SetaFpdf
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace App\Setasign\SetaFpdf\StateBuffer;

use App\Setasign\SetaFpdf\CleanupInterface;

interface StateBufferInterface extends CleanupInterface
{
    /**
     * Resets the state.
     */
    public function reset();

    /**
     * Stores the current state.
     */
    public function store();

    /**
     * Restores the last stored state.
     */
    public function restore();
}
