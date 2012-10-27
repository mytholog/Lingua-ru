<?php

/*
 * This file is part of the Lingua-ru package.
 *
 * (c) Igor Gavrilov <mytholog@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lingua\RU\Formatter;

/**
 * Number formatter (Russian language)
 *
 * @author Igor Gavrilov <mytholog@yandex.ru>
 */
class NumberFormatter {

	protected $tNum = array(
		'1' => "одна",
		'2' => "две"
	);
	
	protected $numbers = array(
		'1' => "один",
		'2' => "два",
		'3' => "три",
		'4' => "четыре",
		'5' => "пять",
		'6' => "шесть",
		'7' => "семь",
		'8' => "восемь",
		'9' => "девять",
		'10' => "десять",
		'11' => "одиннацать",
		'12' => "двенадцать",
		'13' => "тринадцать",
		'14' => "четырнадцать",
		'15' => "пятнадцать",
		'16' => "шестнадцать",
		'17' => "семнадцать",
		'18' => "восемнадцать",
		'19' => "девятнадцать"
	);

	protected $des = array(
		'2' => "двадцать",
		'3' => "тридцать",
		'4' => "сорок",
		'5' => "пятьдесят",
		'6' => "шестьдесят",
		'7' => "семьдесят",
		'8' => "восемдесят",
		'9' => "девяносто"
	);

	protected $hang = array(
		'1' => "сто",
		'2' => "двести",
		'3' => "триста",
		'4' => "четыреста",
		'5' => "пятьсот",
		'6' => "шестьсот",
		'7' => "семьсот",
		'8' => "восемьсот",
		'9' => "девятьсот"
	);

	protected $nameRub = array("рубль", "рубля", "рублей");
	protected $nameTho = array("тысяча", "тысячи", "тысяч");
	protected $nameMln = array("миллион", "миллиона", "миллионов");
	protected $nameMld = array("миллиард", "миллиарда", "миллиардов");
	protected $nameKop = array("копейка", "копейки", "копеек");

	/**
	 * Обработка множеств (склонение существительных после числительных)
	 *
	 * @param array $titles	Варианты слова (час, часа, часов)
	 * @param int $number Число, которое нужно перевести
	 * @param bool $full Если true, то возвращать вместе с цифрой
	 * @return string
	 */
	public function plural(array $titles, $number, $full = false) {
		$result = $titles[(($number % 10 == 1) && ($number % 100 != 11)) ? 0 : ((($number % 10 >= 2) && ($number % 10 <= 4) && (($number % 100 < 10) || ($number % 100 >= 20))) ? 1 : 2)];
		return $full ? $number . ' ' . $result : $result;
	}

	/**
	 * Возвращает цену (число) прописью
	 *
	 * @param mixed $price Число для преобразования
	 */
	public function priceSpell($price, $processFractional = false) {
		//считаем количество копеек, т.е. дробной части числа
		$fractional = intval(( $price * 100 - intval($price) * 100));
		//отбрасываем дробную часть
		$price = intval($price);

		if ($price != 0) {
			$resPrice = $this->numSpell($price);
		}

		//Копейки
		if ($processFractional) {
			$resFact = $this->numSpell($fractional, true);
		} else {
			$resFact = sprintf('%02d', $fractional);
		}

		return sprintf(
					'%s %s %s %s',
					$resPrice,
					$this->plural($this->nameRub, $price),
					$resFact,
					$this->plural($this->nameKop, $fractional)
				);
	}

	public function numSpell($number, $f = false) {
		$result = '';

		if ($number >= 1000000000) {
			$n = intval($number / 1000000000);
			$result = sprintf('%s %s %s', $result, $this->numSpell($n), $this->plural($this->nameMld, $n));
			$number %= 1000000000;
		}

		if ($number >= 1000000) {
			$n = intval($number / 1000000);
			$result = sprintf('%s %s %s', $result, $this->numSpell($n), $this->plural($this->nameMln, $n));
			$number %= 1000000;
		}

		if ($number >= 1000) {
			$n = intval($number / 1000);
			$result = sprintf('%s %s %s', $result, $this->numSpell($n, true), $this->plural($this->nameTho, $n));
			$number %= 1000;
		}

		if ($number >= 100) {
			$n = intval($number / 100);
			$result = sprintf('%s %s', $result, $this->hang[$n]);
			$number %= 100;
		}

		if ($number >= 20) {
			$n = intval($number / 10);
			$result = sprintf('%s %s', $result, $this->des[$n]);
			$number %= 10;
		}

		if ($number) {
			if ($number < 3 && $f)
				$result = sprintf('%s %s', $result, $this->tNum[$number]);
			else
				$result = sprintf('%s %s', $result, $this->numbers[$number]);
		}

		return trim($result);
	}

}
