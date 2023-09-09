<?php

class Block {
    public $index;
    public $timestamp;
    public $data;
    public $previousHash;
    public $hash;
    public $nonce;

    public function __construct($index, $timestamp, $data, $previousHash = '')
    {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previousHash = $previousHash;
        $this->hash = $this->calculateHash();
        $this->nonce = 0;
    }

    public function calculateHash()
    {
        return hash('sha256', $this->index . $this->timestamp . json_encode($this->data) . $this->previousHash . $this->nonce);
    }

    public function mineBlock($difficulty)
    {
        while (substr($this->hash, 0, $difficulty) !== str_repeat('0', $difficulty)) {
            $this->nonce++;
            $this->hash = $this->calculateHash();
        }
        echo "Block mined: " . $this->hash . "\n";
    }
}

class Blockchain {
    private $chain;
    private $difficulty;

    public function __construct()
    {
        $this->chain = [$this->createGenesisBlock()];
        $this->difficulty = 2;
    }

    public function createGenesisBlock()
    {
        return new Block(0, date('Y-m-d H:i:s'), 'Genesis Block', '0');
    }

    public function getLatestBlock()
    {
        return $this->chain[count($this->chain) - 1];
    }

    public function addBlock($newBlock)
    {
        $newBlock->previousHash = $this->getLatestBlock()->hash;
        $newBlock->mineBlock($this->difficulty);
        $this->chain[] = $newBlock;
    }

    public function isChainValid()
    {
        for ($i = 1; $i < count($this->chain); $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];

            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }

            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }
        }

        return true;
    }
}

// Test the blockchain

$blockchain = new Blockchain();

ob_start();  // Start output buffering

echo "Mining block 1...\n";
$blockchain->addBlock(new Block(1, date('Y-m-d H:i:s'), ['amount' => 4]));

echo "Mining block 2...\n";
$blockchain->addBlock(new Block(2, date('Y-m-d H:i:s'), ['amount' => 8]));

$blockchainOutput = json_encode($blockchain, JSON_PRETTY_PRINT) . "\n";

echo $blockchainOutput;

$isChainValidOutput = "Is blockchain valid? " . ($blockchain->isChainValid() ? "Yes" : "No") . "\n";

echo $isChainValidOutput;

// Output written to a text file
file_put_contents('output.txt', ob_get_clean() . $blockchainOutput . $isChainValidOutput . "\n", FILE_APPEND);

echo "Output written in output.txt"

?>

