<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

class Block extends BaseObject
{
    public $version;
    public $previuos_block_hash;
    public $next_block_hash;
    public $height;
    public $bits;
    public $size;
    public $miner;
    public $merkleroot;
    public $transactions;
    public $hash;
    public $timestamp;
    public $nonce;
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