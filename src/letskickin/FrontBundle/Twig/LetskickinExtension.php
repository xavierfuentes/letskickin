<?php

namespace letskickin\FrontBundle\Twig;

class LetskickinExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('currency', array($this, 'currencyFilter')),
			new \Twig_SimpleFilter('statusToString', array($this, 'statusToStringFilter')),
		);
	}

	public function currencyFilter($number, $currency, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
	{
		$price = number_format($number, $decimals, $decPoint, $thousandsSep);
		switch($currency) {
			case 'EUR':
				$price = $price.'€';
			break;
			case 'USD':
				$price = '$'.$price;
			break;
		}

		return $price;
	}

	public function statusToStringFilter($status)
	{
		switch($status) {
			case 0:
				$statusStringified = 'cannot';
			break;
			case 1:
				$statusStringified = 'waiting';
			break;
			case 2:
				$statusStringified = 'confirmed';
			break;
		}

		return $statusStringified;
	}

	public function getName()
	{
		return 'letskickin_extension';
	}
}