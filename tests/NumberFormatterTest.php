<?php

/*
 * This file is part of the Lingua-ru package.
 *
 * (c) Igor Gavrilov <igor.gavrilov@softline.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lingua\RU;

/**
 * NumberFormatter test
 * 
 * @author Igor Gavrilov <igor.gavrilov@softline.ru>
 */
class NumberFormatterTest extends \PHPUnit_Framework_TestCase {

	protected $lingua;

	protected function setUp() {
		$this->lingua = new Lingua();
	}

	public function testShouldPluralNumber() {
		$array = array('час', 'часа', 'часов');
		$this->assertEquals('21 час', $this->lingua->numPlural($array, 21, true));
		$this->assertEquals('часа', $this->lingua->numPlural($array, 22));
		$this->assertEquals('часов', $this->lingua->numPlural($array, 26));
	}

	public function testShouldSpellNum() {
		$this->assertEquals('одна тысяча двести сорок четыре', $this->lingua->numSpell('1244'));
		$this->assertEquals('двести сорок четыре', $this->lingua->numSpell('244'));
		$this->assertEquals('три тысячи', $this->lingua->numSpell('3000'));
	}

	public function testShouldSpellPrice() {
		$this->assertEquals('двенадцать рублей 44 копейки', $this->lingua->priceSpell('12.44'));
		$this->assertEquals('три тысячи рублей 00 копеек', $this->lingua->priceSpell('3000'));
		$this->assertEquals('две тысячи восемьсот восемдесят один рубль 32 копейки', $this->lingua->priceSpell('2881.32'));
		$this->assertEquals('пятьсот тридцать один рубль 00 копеек', $this->lingua->priceSpell(531));
		$this->assertEquals('одна тысяча семьсот двадцать рублей 11 копеек', $this->lingua->priceSpell('1720.11'));
		$this->assertEquals('одна тысяча семьсот двадцать рублей 10 копеек', $this->lingua->priceSpell('1720.1'));
		$this->assertEquals('семь тысяч шестьдесят девять рублей семьдесят семь копеек', $this->lingua->priceSpell('7069.77', true));
		$this->assertEquals(
			'два миллиарда семьдесят миллионов сто пятьдесят четыре тысячи семьсот шестьдесят восемь рублей 32 копейки',
			$this->lingua->priceSpell('2070154768.32')
		);
	}

}
