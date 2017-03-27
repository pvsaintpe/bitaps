<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class Block extends Object
{
    /** @var int */
    public $version;

    /** @var string */
    public $previuos_block_hash;

    /** @var string */
    public $next_block_hash;

    /** @var int */
    public $height;

    /** @var int */
    public $bits;

    /** @var int */
    public $size;

    /** @var string */
    public $miner;

    /** @var string */
    public $merkleroot;

    /** @var int */
    public $transactions;

    /** @var string */
    public $hash;

    /** @var int */
    public $timestamp;

    /** @var int */
    public $nonce;

    /** @var string */
    public $coinbase;

    /**
     * @return Block
     */
    public function getPreviousBlock()
    {
        return BitAps::getBlock($this->previuos_block_hash);
    }

    /**
     * @return BlockTransaction[]
     */
    public function getTransactions()
    {
        return BitAps::getBlockTransactions($this->hash);
    }

    /**
     * @return Block
     */
    public function getNextBlock()
    {
        return BitAps::getBlock($this->next_block_hash);
    }
}