<?php

namespace Drupal\jugaad\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

use chillerlan\QRCode\QRCode;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "qr_code_block",
 *   admin_label = @Translation("QR Code Block"),
 * )
 */
class QRCodeBlock extends BlockBase {
	/**
	* {@inheritdoc}
	*/
	public function build() {
		$node     = \Drupal::routeMatch()->getParameter('node');
		$nodeID   = $node->id();
		$nodeData = \Drupal::entityTypeManager()->getStorage('node')->load($nodeID);
		$data = $nodeData->field_app_link->uri;
		$link = (new QRCode)->render($data);
		
		return [
			'#theme'   => 'qr_code_display',
			'#myTitle' => "QR Code",
			'#link'  => $link,
			'#cache'   => array(
				'max-age' => 0,
			)
		];
	}
}