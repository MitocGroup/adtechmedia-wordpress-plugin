<?php
/**
 * Adtechmedia_AB
 *
 * @category Class
 * @package  Adtechmedia_Plugin
 * @author   AlexanderC <acucer@mitocgroup.com>
 */

use PhpAb\Storage\Storage;
use PhpAb\Storage\Adapter\Cookie;
use PhpAb\Participation\Manager;
use PhpAb\Event\Dispatcher;
use PhpAb\Participation\Filter\Percentage;
use PhpAb\Variant\Chooser\StaticChooser;
use PhpAb\Engine\Engine;
use PhpAb\Test\Test;
use PhpAb\Variant\SimpleVariant;

/**
 * Class Adtechmedia_AB
 */
class Adtechmedia_AB {
	const SHOW = 'show';
	const HIDE = 'hide';
	const DEFAULT_PERCENTAGE = 50;

	/**
	 * Constructor
	 *
	 * @param string $percentage A/B percentage.
	 */
	function __construct( $percentage = self::DEFAULT_PERCENTAGE ) {
		$this->storage = new Storage( new Cookie( Adtechmedia_Config::get( 'plugin_ab_cookie_name' ) ) );
		$this->manager = new Manager( $this->storage );
		$this->dispatcher = new Dispatcher();
		$this->filter = new Percentage( $percentage );
		$this->chooser = new StaticChooser( self::SHOW );
		$this->test = new Test( Adtechmedia_Config::get( 'plugin_ab_test_name' ) );
		$this->engine = null;
		$this->variant = self::HIDE;
	}

	/**
	 * Set percentage
	 *
	 * @param string $percentage A/B percentage.
	 *
	 * @return Adtechmedia_AB
	 */
	public function set_percentage( $percentage ) {
		$this->filter = new Percentage( $percentage );

		return $this;
	}

	/**
	 * Start A/B
	 *
	 * @return Adtechmedia_AB
	 *
	 * @throws WP_Error Started twice.
	 *
	 * @todo Add support for analytics.
	 */
	public function start() {
		if ( ! empty( $this->engine ) ) {
			throw new WP_Error( 'AdTechMedia A/B testing library can not be started twice' );
		}

		$this->dispatcher->addListener( 'phpab.participation.variant_run', array( $this, '_dispatch' ) );

		$this->init()->engine->start();

		return $this;
	}

	/**
	 * Dispatch A/B event
	 *
	 * @param array $options event options.
	 */
	public function _dispatch( $options ) {
		$this->variant = $options[2]->getIdentifier();
	}

	/**
	 * Init A/B engine
	 *
	 * @return Adtechmedia_AB
	 */
	private function init() {
		$this->engine = new Engine(
			$this->manager,
			$this->dispatcher,
			$this->filter,
			$this->chooser
		);

		$this->test->addVariant( new SimpleVariant( self::SHOW ) );
		$this->test->addVariant( new SimpleVariant( self::HIDE ) );
		$this->engine->addTest( $this->test );

		return $this;
	}

	/**
	 * Get the instance
	 *
	 * @return Adtechmedia_AB
	 */
	public static function instance() {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new static;
		}

		return $instance;
	}
}
