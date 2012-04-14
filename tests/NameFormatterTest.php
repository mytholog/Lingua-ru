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

use Lingua\RU\Formatter\NameFormatter;

/**
 * NameFormatter test
 *
 * @author Igor Gavrilov <igor.gavrilov@softline.ru>
 */
class NameFormatterTest extends \PHPUnit_Framework_TestCase {

	protected $lingua;

	protected function setUp() {
		$this->lingua = new Lingua();
	}

	public function testShouldReturnGenderByMiddleName() {
		$this->assertEquals(NameFormatter::MALE, $this->lingua->nameGender('Кац Саша Иванович'));
		$this->assertEquals(NameFormatter::FEMALE, $this->lingua->nameGender('Кац Саша Ивановна'));
	}

	/**
	 * @dataProvider genderMaleProvider
	 */
	public function testShouldReturnMaleGender($a) {
		$this->assertEquals(NameFormatter::MALE, $this->lingua->nameGender($a));
	}

	/**
	 * @dataProvider genderFemaleProvider
	 */
	public function testShouldReturnFemaleGender($a) {
		$this->assertEquals(NameFormatter::FEMALE, $this->lingua->nameGender($a));
	}

	/**
	 * @dataProvider caseProvider 
	 */
	public function testShouldReturnGenitiveName($a, $b) {
		$this->assertEquals($b, $this->lingua->nameInflect($a, 0));
	}

	public function caseProvider() {
		return $this->parseFile('case.csv');
	}

	public function genderMaleProvider() {
		return $this->parseFile('m_gender.csv');
	}

	public function genderFemaleProvider() {
		return $this->parseFile('f_gender.csv');
	}

	protected function parseFile($file) {
		$data = array();
		foreach (file(__DIR__ . '/_files/' . $file, FILE_SKIP_EMPTY_LINES) as $line) {
			$data[] = explode(";", trim($line));
		}

		return $data;
	}

}
