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

namespace IOTADevs\PEMapModder;

use IOTADevs\PEMapModder\generator\PEMapModder;
use pocketmine\level\generator\Generator;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{
	public function onEnable(){
		Generator::addGenerator(PEMapModder::class, "pemapmodder");
		if(!$this->getServer()->loadLevel("pemapmodder")){
			$this->getServer()->generateLevel("pemapmodder", time(), Generator::getGenerator("pemapmodder"));
		}
	}
}