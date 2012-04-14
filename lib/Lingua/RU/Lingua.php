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
use Lingua\RU\Formatter\NumberFormatter;

/**
 * Russian Lingua library
 *
 * @author Igor Gavrilov <igor.gavrilov@softline.ru>
 */

class Lingua {

	protected $options = array(
		'encoding'	=> 'UTF-8'
	);

	public function __construct(array $options = array()) {
		array_merge($this->options, $options);
		mb_internal_encoding($this->options['encoding']);
	}

	/**
	 * Возвращает пол
	 *
	 * @param string $fullName Фамилия Имя Отчество
	 * @return string
	 */
	public function nameGender($fullName) {
		$nameFormatter = new NameFormatter();
		return $nameFormatter->getGender($fullName);
	}

	/**
	 * Возвращает просклоненное имя в выбранном падеже
	 *
	 * @param string $fullName Фамилия Имя Отчество
	 * @param int $case Падеж (0 - genitive, 1 - dative, 2 - accusative, 3 - instrumentative, 4 - prepositional)
	 * @return string
	 */
	public function nameInflect($fullName, $case) {
		$nameFormatter = new NameFormatter();
		return $nameFormatter->inflect($fullName, $case);
	}

	/**
	 * Обработка множеств (склонение существительных после числительных)
	 *
	 * @param array $titles	Варианты слова (час, часа, часов)
	 * @param int $number Число, которое нужно перевести
	 * @param bool $full Если true, то возвращать вместе с цифрой
	 * @return string
	 */
	public function numPlural(array $titles, $number, $full = false) {
		$numberFormatter = new NumberFormatter();
		return $numberFormatter->plural($titles, $number, $full);
	}

	/**
	 * Возвращает число прописью
	 *
	 * @param mixed $number Число для преобразования
	 * @return string
	 */
	public function numSpell($number) {
		$numberFormatter = new NumberFormatter();
		return $numberFormatter->numSpell($number);
	}

	/**
	 * Возвращает цену (число) прописью
	 * 
	 * @param mixed $price Число для преобразования
	 * @param bool Преобразовывать копейки
	 * @return string
	 */
	public function priceSpell($price, $processFractional = false) {
		$numberFormatter = new NumberFormatter();
		return $numberFormatter->priceSpell($price, $processFractional);
	}

}
