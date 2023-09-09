# PHP Simple Blockchain Algorithm
This is a simple PHP implementation of a blockchain with basic functionality including block creation, mining, and chain validation.

# Simple PHP Blockchain Implementation

This is a simple PHP implementation of a blockchain with basic functionality including block creation, mining, and chain validation.

## Block Class

The `Block` class represents a block in the blockchain. It has the following attributes:

- `index`: The index of the block.
- `timestamp`: The timestamp of when the block was created.
- `data`: The data stored in the block.
- `previousHash`: The hash of the previous block in the chain.
- `hash`: The hash of the current block.
- `nonce`: A value used in mining.

The class also includes methods for calculating the block's hash and mining the block.

## Blockchain Class

The `Blockchain` class manages the chain of blocks. It has the following features:

- Initialization with a genesis block.
- Ability to add new blocks to the chain.
- Checking the validity of the blockchain.

## License

This project is licensed under the MIT License.
