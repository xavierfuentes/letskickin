<?php

namespace letskickin\FrontBundle\Twig;

class LetskickinExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('currency', array($this, 'currencyFilter')),
		);
	}

	public function currencyFilter($number, $currency, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
	{
		$price = number_format($number, $decimals, $decPoint, $thousandsSep);
		switch($currency) {
			case 'EUR':
				$price = $price.'€';
			break;
			case 'EUR':
				$price = '$'.$price;
			break;
		}

		return $price;
	}

	public function getName()
	{
		return 'letskickin_extension';
	}
}