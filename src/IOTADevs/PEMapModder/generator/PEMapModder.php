<?php

/**
 *
 * d8b  .d88888b. 88888888888     d8888 8888888b.
 * Y8P d88P" "Y88b    888        d88888 888  "Y88b
 *     888     888    888       d88P888 888    888
 * 888 888     888    888      d88P 888 888    888  .d88b.  888  888 .d8888b
 * 888 888     888    888     d88P  888 888    888 d8P  Y8b 888  888 88K
 * 888 888     888    888    d88P   888 888    888 88888888 Y88  88P "Y8888b.
 * 888 Y88b. .d88P    888   d8888888888 888  .d88P Y8b.      Y8bd8P       X88
 * 888  "Y88888P"     888  d88P     888 8888888P"   "Y8888    Y88P    88888P'
 *
 * // This world generator was made by @CortexPE ^_^
 *
 * This is free and unencumbered software released into the public domain.
 *
 * Anyone is free to copy, modify, publish, use, compile, sell, or
 * distribute this software, either in source code form or as a compiled
 * binary, for any purpose, commercial or non-commercial, and by any
 * means.
 *
 * In jurisdictions that recognize copyright laws, the author or authors
 * of this software dedicate any and all copyright interest in the
 * software to the public domain. We make this dedication for the benefit
 * of the public at large and to the detriment of our heirs and
 * successors. We intend this dedication to be an overt act of
 * relinquishment in perpetuity of all present and future rights to this
 * software under copyright law.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information, please refer to <http://unlicense.org>
 *
 * @author iOTADevs
 * @link http://iotadevs.github.io
 *
 */

declare(strict_types = 1);

namespace IOTADevs\PEMapModder\generator;

use pocketmine\level\generator\biome\Biome;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\level\generator\Generator;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class PEMapModder extends Generator {
	/** @var ChunkManager */
	private $level;
	/** @var Random */
	private $random;
	/** @var Chunk */
	private $singleChunk = null;
	/** @var Chunk */
	private $currentChunk;

	private $floorHeight = 5;

	public function __construct(array $settings = []){
	}

	public function init(ChunkManager $level, Random $random){
		$this->level = $level;
		$this->random = $random;
	}

	public function generateChunk(int $chunkX, int $chunkZ){
		// TODO: Verify if these coordinates are correct... These are all just assumptions from what I see on his avatar. No Hate Please xD
		if($this->singleChunk === null){
			$this->currentChunk = clone $this->level->getChunk($chunkX, $chunkZ);
			$this->currentChunk->setGenerated();

			for($Z = 0; $Z <= 15; ++$Z){
				for($X = 0; $X <= 15; ++$X){
					$this->currentChunk->setBiomeId($X, $Z, Biome::PLAINS);
					for($y = 0; $y <= Level::Y_MAX; ++$y){
						// Generate floor
						if($y < $this->floorHeight){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::DIRT);
						}elseif($y == $this->floorHeight){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::GRASS);
							if(($X >= 6 && $X <= 9) && ($Z >= 6 && $Z <= 9)){
								$this->currentChunk->setBlockId($X, $y, $Z, Block::FENCE);
								$this->currentChunk->setBlockId($X, $y + 1, $Z, Block::TORCH);
							}
							if(($X >= 7 && $X <= 8) && ($Z >= 7 && $Z <= 8)){
								$this->currentChunk->setBlockId($X, $y, $Z, Block::GLOWSTONE);
							}
							if($X != $Z){ // dont put wool on where they meet
								if(($X == 3) && ($Z >= 3 && $Z <= 11)){
									$this->currentChunk->setBlockId($X, $y, $Z, Block::WOOL);
								}
								if(($Z == 3) && ($X >= 3 && $X <= 11)){
									$this->currentChunk->setBlockId($X, $y, $Z, Block::WOOL);
								}
							}
						}
						$this->currentChunk->setBlockId($X, 0, $Z, Block::BEDROCK);

						// Generate torches
						if(
							(
								($X == 0) ||
								($X == 15) ||
								($Z == 0) ||
								($Z == 15) ||
								(($X == $Z) || ((16 - $X - 1) == $Z)) // cross
							) && ($y == ($this->floorHeight + 1))
						){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::TORCH);
							if($X == 2 && $Z == 2){
								$this->currentChunk->setBlockId($X, $y, $Z, Block::AIR);
							}
						}

						// Generate Fence Tower
						if(($X >= 7 && $X <= 8) && ($Z >= 7 && $Z <= 8) && ($y >= ($this->floorHeight + 1) && $y <= ($this->floorHeight + 3))){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::FENCE);
							$this->currentChunk->setBlockId($X, $y + 1, $Z, Block::TORCH);
						}
						if($Z == 8 && ($X >= 7 && $X <= 8) && ($y == ($this->floorHeight + 4))){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::FENCE);
							$this->currentChunk->setBlockId($X, $y + 1, $Z, Block::TORCH);
						}
						if($Z == 8 && $X == 8 && ($y == ($this->floorHeight + 5))){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::FENCE);
							$this->currentChunk->setBlockId($X, $y + 1, $Z, Block::TORCH);
						}

						if($X == 12 && $Z == 12 && $y == 24){
							$this->currentChunk->setBlockId($X, $y, $Z, Block::WOOL);
							$this->currentChunk->setBlockId($X, $y + 1, $Z, Block::TORCH);
						}

						// Update Light Levels
						$blockId = $this->currentChunk->getBlockId($X, $y, $Z);
						if($blockId == Block::TORCH || $blockId == Block::GLOWSTONE){
							$block = Block::get($blockId);
							$lightLevel = $block->getLightLevel();
							if($lightLevel > 0){
								$this->currentChunk->setBlockLight($X, $y, $Z, $lightLevel);
							}
						}
					}
				}
			}

			$this->singleChunk = clone $this->currentChunk;
		}else{
			$this->currentChunk = clone $this->singleChunk;
		}

		$chunk = clone $this->currentChunk;
		$chunk->setX($chunkX);
		$chunk->setZ($chunkZ);
		$this->level->setChunk($chunkX, $chunkZ, $chunk);
	}

	public function populateChunk(int $chunkX, int $chunkZ){
	}

	public function getSettings(): array{
		return [];
	}

	public function getName(): string{
		return "PEMapModder";
	}

	public function getSpawn(): Vector3{
		return new Vector3(128, 128, 128);
	}
}